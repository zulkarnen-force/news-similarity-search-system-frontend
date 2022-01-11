<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\HeadingRowImport;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // check rules
        if(Auth::user()->name == 'admin'){
            $files = Files::with(['report']);
        }else{
            $files = Files::with(['report'])->where('created_by','=',Auth::user()->id);
        }

        if(request('search')){ $files->where('created_at','LIKE','%'.request('search').'%'); }
    
        return view('contents.files.index',[
            'files' => $files->orderBy('id', 'DESC')->paginate(5)->onEachSide(1)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check extensi file
        $request->validate([
            'files' => 'required|mimes:csv,xlx,xls,xlsx|max:1024'
        ]);
        if($request->file()) 
        {
            // filename & path
            $fileName = 'Bino_'.time().'.'.$request->file('files')->getClientOriginalExtension();
            $filePath =  $request->file('files')->storeAs('public/excel-data', $fileName);

            // mapping
            $headers = (new HeadingRowImport)->toCollection(storage_path().('/app/'.$filePath));
            $keys = $headers[0][0];
            $values = collect(["string","date","string","text","text","text","string","string","string","string","string","string","string","number","string","number","string","string","string","string","string"]);

            // check apakah format upload sesuai
            if(count($keys) == count($values)){
                // mapping
                $mapping = $keys->combine($values);
                $mapping = json_encode($mapping, JSON_PRETTY_PRINT);
                
                // insert data to database
                $fileModel = Files::create([
                    'filename' => $fileName,    
                    'created_by' => Auth::user()->id,
                    'path' => $filePath,
                    'mapping' => $mapping
                ]);

                // save to db
                $fileModel->save();

                // send to RabbitMq
                $queueManager = app('queue');
                $queue = $queueManager->connection('rabbitmq');
                $queue->pushRaw($fileModel, 'files');

                // kembalikan ke halaman 'file-index'
                return redirect()->route('file-index')->with('success','Data Berhasil disimpan');
            }else{
                // mengembalikan karena format upload tidak sesuai dengan keys + values
                return redirect()->route('file-index')->with('error','Data Upload Tidak Sesuai format');
            }
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $files = Files::find($id);

        // check apakah report telah berada di redis
        if(Redis::exists($files->filename))
        {
            $response = Redis::command('lrange', [$files->filename, 0, -1]);
            $response = json_decode($response[0]);
            $response = json_encode($response);
            return view('contents.files.details',compact('files','response'));
        }
        else
        {
            return back()->with('error','Data Belum Tersedia');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function path($id)
    {
        $path = Files::find($id);

        // send to Rabbitmq
        $queueManager = app('queue');
        $queue = $queueManager->connection('rabbitmq');
        $queue->pushRaw($path, 'files');
        
        return back()->with('success','Data Telah Terkirim Ke Message Broker');
    }
}
