@extends('layouts.frontend')
@section('title','Upload Files')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Upload File</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#upload">
                    <i class="fas fa-download fa-sm text-white-50"></i> Upload File
                </a>
            </div>
        {{-- alert-succes --}}
        @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            Data Telah Berhasil ditambahkan
        </div>
        @endif
    </div>
    <!--Modal-->
    <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('file-upload') }}" class="w-full" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="w-full px-3">
                        <input type="file" multiple name="files[]" accept="data/*" placeholder="Photos" class="block w-full bg-gray-200 text-gray-700 border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:border-gray-500" >
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection