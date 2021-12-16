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
                              <a  class="btn btn-warning" href="{{Storage::url($file->path)}}" target="blank">Check</a>  
                              <a  class="btn btn-primary" href="{{route('path',$file->id)}}" target="blank">Report</a>  
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                  </div> 
                  <p>Halaman {{$files->currentPage()}}</p>
                  <div class="nav justify-content-center">
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
                            <label for="file" class="nav justify-content-center mb-4">
                                <i class="fas fa-file-upload" style="border: 1px solid black;padding: 26px; cursor:pointer;border-radius:5px;box-shadow: 2px 3px #888888;" onmouseover="this.style.color='#0F0'" onMouseOut="this.style.color='#00F'" >
                                </i>
                            </label>
                            <input class="form-control" type="file" id="file" type="file" multiple name="files[]" accept="data/*">
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
    </script>
@endsection