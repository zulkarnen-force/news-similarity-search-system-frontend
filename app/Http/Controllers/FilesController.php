<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contents.files');
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
        $files = $request->file('files');

        if($request->hasFile('files'))
        {
            foreach($files as $file)
            {
                $path = $file->store('public/excel-data');

                Files::create([
                    'filename' => $file,
                    'created_by' => Auth::user()->id,
                    'path' => $path
                ]);
            }
        }
        return redirect()->route('file-index')->with('success','Data Berhasil Diupload');

        // if($request->hasFile('file')){

        //     // upload path
        //     $path = 'file/';

        //     // get extension
        //     $extension = $request->file('file')->getClientOriginalExtension();

        //     // valid Extension
        //     $validextensions = array("xlsx","csv","xls","xlsm");

        //     // check 
        //     if(in_array(strtolower($extension),$validextensions)){

        //         // rename file
        //         $fileName = $request->file('file')->getClientOriginalName().time().'.'.$extension;
        //         $request->file('file')->move($path,$fileName);
        //     }
        // }

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
}
