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
        <div class="alert alert-success" role="alert" id="success">
            Data Telah Berhasil ditambahkan
        </div>
        @endif

        {{-- alert errors --}}
        @if ($errors->any())
        <div class="alert alert-danger" role="alert" id="error">
            Maaf File Harus csv,xlx,xls,xlsx <i class="fas fa-file-csv"></i> <i class="far fa-file-excel"></i> 
            <br> Maksimal Ukuran File 1 Mb
        </div>
        @endif
        <!-- Start Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Table Files</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <p>Result {{ $files->total()}}  </p>
                        <input type="text" class="rounded border-white" placeholder="Search...">
                    </div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Reporter</th>
                          <th>Report Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($files as $file)
                        <tr>
                          <td>{{ $no++}}</td>
                          <td>{{ $file->report->name}}</td>
                          <td>{{ $file->created_at->diffForHumans()}}</td>
                          <td>
                            {{-- {{Storage::url($file->path)}} --}}
                            <form action="{{route('file-details', $file->id)}}" method="POST">
                                @csrf
                                <button type="submit"  class="btn btn-warning btn-circle">
                                    <i class="fas fa-file-word"></i>
                                </button>  
                                <a  class="btn btn-primary btn-circle" href="{{route('path',$file->id)}}" target="blank">
                                    <i class="far fa-share-square"></i>
                                </a>  
                            </form>
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                  </div> 
                  <p>Halaman {{$files->currentPage()}}</p>
                  <div class="d-flex justify-content-center">
                    {{ $files->links() }}
                  </div>   
            </div>
        </div>
        {{-- end table --}}
    </div>

    <!--Modal-->
    <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Report</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="w-full px-3">
                    <div class="mb-3 row mt-3">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Reporter</label>
                        <div class="col-sm-10">
                          <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{Auth::user()->name}}">
                        </div>
                      </div>
                <form action="{{ route('file-upload') }}" class="w-full" method="post" enctype="multipart/form-data">
                @csrf
                        <div class="mb-3">
                            <input class="btn btn-light btn-icon-split" type="file" id="file" type="file" name="files" accept="data/*" enctype="multipart/form-data">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
    setTimeout(() => {
        $('#success').slideUp('fast');
    }, 1500);
    setTimeout(() => {
        $('#error').slideUp('fast');
    }, 4000);
    </script>
@endsection