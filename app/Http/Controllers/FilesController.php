<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
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
        $no=1;
        $files = Files::with(['report'])->orderBy('id', 'DESC')->paginate(5)->onEachSide(1);
        return view('contents.files',compact('files','no'));
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
        $request->validate([
            'files' => 'required|mimes:csv,xlx,xls,xlsx|max:2048'
        ]);
        if($request->file()) 
        {
            // filename & path
            $fileName = 'Bino_'.time().'.'.$request->file('files')->getClientOriginalExtension();
            $filePath =  $request->file('files')->storeAs('public/excel-data', $fileName);

            // mapping
            $headings = (new HeadingRowImport)->toCollection(storage_path().('/app/'.$filePath));
            // insert data to database
            $fileModel = Files::create([
                'filename' => $fileName,    
                'created_by' => Auth::user()->id,
                'path' => $filePath,
                'mapping' => $headings
            ]);
            $fileModel->save();

            // send to RabbitMq
            $queueManager = app('queue');
            $queue = $queueManager->connection('rabbitmq');
            $queue->pushRaw($fileModel, 'default');

            // kembalikan ke halaman 'file-index'
            return redirect()->route('file-index')->with('success','Data Berhasil Diupload');
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $path = Files::find($id,['id','filename','path','mapping']);
        print_r($path->toJson());
        $queueManager = app('queue');
        $queue = $queueManager->connection('rabbitmq');
        $queue->pushRaw($path, 'default');
    }
}
