@extends('layouts.frontend')
@section('title','Upload Files')

@section('content')
<input type="text" name="mapping" id="mapping" value=<?php echo json_encode(session('mapping')); ?> hidden>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Upload File</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#upload">
                    <i class="fas fa-download fa-sm text-white-50"></i> Upload File
                </a>
            </div>
        {{-- alert-flash-succes --}}
        @if (session()->has('success'))
        <div class="alert alert-success" role="alert" id="success">
            {{ session('success') }}
        </div>
        @endif

        @if (session()->has('mapping'))
        <!-- Modal -->
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Column Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
            <form action="{{ route('update-column', session('id')) }}" method="post">
                {{ csrf_field() }}
                @method('PUT')
                @foreach (session('mapping') as $map )
                
                <div class="row" id="options">

                    <div class="col-md">
                        <label for="optionType">{{ $map['title'] }}</label>
                    </div>

                    <div class="col">
                        <select id="optionType" name="optionType">
                            <option value="text">text</option>
                            <option value="number">number</option>
                            <option value="calendar">calendar</option>
                            <option value="numeric">numeric</option>
                        </select>
                    </div>
                    
                </div> <!--  row -->
                @endforeach 

                
                <input id="json" type="text" name="columnNames" hidden>

                <div class="modal-footer">   
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn-save" class="btn btn-primary">Save changes</button>   
                </div>
            </form>

            </div>
            </div>
        </div>
        </div>

        <script>
        
        const changeType = (titleAndTypeFormat, newType) => {

            titleAndTypeFormat.map((v, i) => {
                v['type'] = newType[i]
            });
            return titleAndTypeFormat

        }
        
        let mapping = document.getElementById("mapping").value
        const titleAndType = JSON.parse(mapping)
        
        document.getElementById('btn-save').addEventListener('click', function(e) {
            let arr = []
            $('#options option:selected').each(function() {
                console.error($(this).val())
                arr.push($(this).val())
            })
        
            $("#json").val(JSON.stringify(changeType(titleAndType, arr, 'type')));

        })
        
    </script>
           <script>
                   window.onload = function () {
                       OpenBootstrapPopup();
                    };
                    function OpenBootstrapPopup() {
                        $("#exampleModalLong").modal('show');
                    }
            </script>

        @endif

        {{-- alert-errors --}}
        @if ($errors->any() or session()->has('error'))
        <div class="alert alert-danger" role="alert" id="error">
            @if (session()->has('error'))
                {{ session('error') }}
            @else
                Maaf File Harus csv,xlx,xls,xlsx <i class="fas fa-file-csv"></i><i class="far fa-file-excel"></i><br> Maksimal Ukuran File 1 Mb
            @endif
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
                        <form action="{{route('file-index')}}">
                            <div class="input-group mb-3">
                                <input type="month" class="form-control" value="{{ request('search')}}" name="search" id="search">
                                <button class="btn btn-outline-primary" id="btn-search" type="submit" id="button-addon2">
                                    <i class="fas fa-filter"></i>
                              </button>
                            </div>
                        </form>
                    </div>
                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                      <thead>
                        <tr>
                          <th width="50px">No</th>
                          <th width="200px">Reporter</th>
                          <th width="100px">Report Date</th>
                          <th width="100px">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($files as $no => $file)
                        <tr>
                          <td>{{  ++$no + ($files->currentPage()-1) * $files->perPage() }}</td>
                          <td>{{ $file->report->name ?? 'None'}}</td>
                        <td>{{ $file->created_at->diffForHumans()}}</td>
                          <td>
                            <form action="{{route('file-details', $file->id)}}" method="POST">
                                @csrf
                                <button type="submit" title="Detail" class="btn btn-success btn-circle" name="file-details" value="details">
                                    <i class="fas fa-file-excel"></i>
                                </button>
                                <a class="btn btn-primary btn-circle" title="Send To View" href="{{route('path',$file->id)}}" name="message" value="path">
                                    <i class="far fa-share-square"></i>
                                </a>
                            </form>
                            <form action="{{route('file-details', $file->id)}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            <button href="#" type="submit" class="btn btn-danger btn-circle" title="Delete" name="file-details" value="delete" onclick="return confirm('Are you Sure ?')">
                                <i class="fas fa-trash"></i>
                            </button>
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
                          <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{Auth::user()->name}}" disabled>
                        </div>
                      </div>
                <form action="{{ route('file-upload') }}" class="w-full" method="post" enctype="multipart/form-data">
                @csrf
                        <div class="form-group files">
                            <label>Upload File </label>
                            <input type="file" class="form-control" name="files" enctype="multipart/form-data">
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
