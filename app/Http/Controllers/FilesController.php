<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\HeadingRowImport;
use PhpOption\None;
use PhpParser\Node\Stmt\Break_;
use Symfony\Component\VarDumper\VarDumper;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function index()
    {
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
            $filePath =  $request->file('files')->storeAs("public/excel-data", $fileName);

            // Storage::putFile('file/download', $request->file('files'));
            // mapping
            // $headers = (new HeadingRowImport)->toCollection(storage_path().('/app/'.$filePath));
            // $keys = $headers[0][0];
            // $values = collect(["string","date","string","text","text","text","string","string","string","string","string","string","string","number","string","number","string","string","string","string","string"]);

            // // check apakah format upload sesuai
            // if(count($keys) == count($values)){
            //     // mapping
            //     $mapping = $keys->combine($values);
            //     $mapping = json_encode($mapping, JSON_PRETTY_PRINT);


            $heading = (new HeadingRowImport)->toArray($request->file('files'));
            $columnName = $heading[0][0];
            $testType = ['text', 'number'];
            $cb =  fn(string $column, $type) : array =>  ["title" => $column, "type"=>$type ? $type : 'text'];
            
            $mapping = array_map($cb,  $columnName, $testType);
            // return view('contents.files.column', compact('columnName'));
                // insert data to database
                $fileModel = Files::create([
                    'filename' => $fileName,
                    'created_by' => Auth::user()->id,
                    'path' => "file/download/$fileName",
                    'mapping' => $mapping #diganti $mapping apabila sudah dibutuhkan
                ]);

                // save to db
                $fileModel->save();

                // send to RabbitMq
                $queueManager = app('queue');
                $queue = $queueManager->connection('rabbitmq');
                $queue->pushRaw($fileModel, 'files');
                $id = Files::where('filename', $fileName)->first()->id;

                // kembalikan ke halaman 'file-index'
                return redirect()->route('file-index')->with(['success'=>'Data Berhasil disimpan', 'mapping' => $mapping, 'id' => $id]);
            // }else{
            //     // mengembalikan karena format upload tidak sesuai dengan keys + values
            //     return redirect()->route('file-index')->with('error','Data Upload Tidak Sesuai format');
            // }
        }
    }

    public function ShowAndDestroy(Request $request,$id)
    {
        $files = Files::find($id);
        $filename = $files->filename;

        switch ($request->input('file-details')) {
            case 'details':
                // check apakah report telah berada di redis
                if(Redis::exists($filename)) {
                        // langkah sleep karena jika sudah request "Similarity" akan membutuhkan
                        // sleep(5);
                        $response = Redis::command('lrange', [$filename, -1, -1]);
                        $response = json_decode($response[0]);
                        $response = json_encode($response);
                        // var_dump(($response));
                        return view('contents.files.details',compact('files','response'));
                } else {
                        return back()->with('error','Data Belum Tersedia');
                }
                break;

            // case 'delete':
            //     $files = Files::findOrFail($id);
            //     $files->delete();
            //     return back()->with('success','Files Berhasil Dihapus');
            //     break;
        }
    }

    public function destroy($id)
    {
        $files = Files::findOrFail($id);

        $files->delete();

        return back()->with('success','file Berhasil Dihapus');
    }


    public function update(Request $request, $id)
    {
       
        $file = Files::find($id);
        $file->mapping = json_decode($request->get('columnNames'));
 
        $file->save();  
        $queueManager = app('queue');
        $queue = $queueManager->connection('rabbitmq');
        $queue->pushRaw($file, 'files');
        // return back()->with('success','Data Telah dikirim ke Message Broker');
        return redirect()->route('file-index')->with('success','Data Telah dikirim ke Message Broker');
        // return redirect()->route('file-index')->with(['success'=>'Data Berhasil disimpan']);

    }

    public function path(Request $request, $id)
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


    public function download(Request $request, $filename)
    {
        ob_end_clean();
        return response()->download("../storage/app/public/excel-data/$filename");
    }
}
