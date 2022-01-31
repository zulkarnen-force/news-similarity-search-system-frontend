<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\HeadingRowImport;
use PhpOption\None;
use PhpParser\Node\Stmt\Break_;

class FilesController extends Controller
{
    public function index()
    {
        // check rules
        
        if(Auth::user()->roles == 'ADMIN'){
            $files = Files::with(['report']);
        }else{
            $files = Files::with(['report'])->where('created_by','=',Auth::user()->id);
        }
        if(request('search')){ 
            $files->where('files.created_at','LIKE','%'.request('search').'%'); }
    
        return view('contents.files.index',[
            'files' => $files->orderBy('id', 'DESC')->paginate(5)->onEachSide(1)->withQueryString()
        ]);
    }

    public function create()
    {
        //
    }

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
            // $headers = (new HeadingRowImport)->toCollection(storage_path().('/app/'.$filePath));
            // $keys = $headers[0][0];
            // $values = collect(["string","date","string","text","text","text","string","string","string","string","string","string","string","number","string","number","string","string","string","string","string"]);

            // // check apakah format upload sesuai
            // if(count($keys) == count($values)){
            //     // mapping
            //     $mapping = $keys->combine($values);
            //     $mapping = json_encode($mapping, JSON_PRETTY_PRINT);
                
                // insert data to database
                $fileModel = Files::create([
                    'filename' => $fileName,    
                    'created_by' => Auth::user()->id,
                    'path' => $filePath,
                    'mapping' => "None" #diganti $mapping apabila sudah dibutuhkan
                ]);

                // save to db
                $fileModel->save();

                // send to RabbitMq
                $queueManager = app('queue');
                $queue = $queueManager->connection('rabbitmq');
                $queue->pushRaw($fileModel, 'files');

                // kembalikan ke halaman 'file-index'
                return redirect()->route('file-index')->with('success','Data Berhasil disimpan');
            // }else{
            //     // mengembalikan karena format upload tidak sesuai dengan keys + values
            //     return redirect()->route('file-index')->with('error','Data Upload Tidak Sesuai format');
            // }
        } 
    }

    public function ShowAndDestroy(Request $request,$id)
    {
        $files = Files::find($id);
        switch ($request->input('file-details')) {
            case 'details':
                // check apakah report telah berada di redis
                if(Redis::exists($files->filename)) {
                        // langkah sleep karena jika sudah request "Similarity" akan membutuhkan 
                        sleep(5);
                        $response = Redis::command('lrange', [$files->filename, -1, -1]);
                        $response = json_decode($response[0]);
                        $response = json_encode($response);
                        return view('contents.files.details',compact('files','response'));
                } else {
                        return back()->with('error','Data Belum Tersedia');
                }
                break;

            case 'delete':
                $files = Files::findOrFail($id);
                $files->delete();
                return back()->with('success','Files Berhasil Dihapus');
                break;
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function path(Request $request,$id)
    {
        $path = Files::find($id);
        // send to Rabbitmq

        $queueManager = app('queue');
        $queue = $queueManager->connection('rabbitmq');
        $queue->pushRaw($path, 'files');
        // return back()->with('success','Data Telah dikirim ke Message Broker');
        return redirect()->route('file-index')->with('success','Data Telah dikirim ke Message Broker');
    }

    public function json_edit(Request $request)
    {  
        $filename = $request->input('filename');
        $data = $request->input('data');
        Redis::command('rpush',[$filename,$data]);
        return redirect()->route('file-index')->with('success','Data File Berhasil Diubah');
    }
}
