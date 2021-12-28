@extends('layouts.frontend')
@section('title','Users')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">User</h1>
            </div>
            @if (session()->has('deleted'))
            <div class="alert alert-success" role="alert" id="deleted">
                User Berhasil dihapus
            </div>
            @endif
                <!-- Start Table -->
                    <div class="card shadow mb-4">
                      <div class="card-header py-3">
                          <h6 class="m-0 font-weight-bold text-primary">Table Users</h6>
                      </div>
                      <div class="card-body">
                          <div class="table-responsive">
                          <div class="d-sm-flex align-items-center justify-content-between mb-4">
                              <p>Result {{ $users->total()}}  </p>
                              <form action="{{route('user-index')}}">
                                <div class="input-group mb-3">
                                  <input type="text" class="form-control" name="search" id="search"  placeholder="Search..." value="{{ request('search')}}">
                                  <button class="btn btn-outline-primary" type="submit" id="btn-search" >
                                    <i class="fas fa-search"></i>
                                  </button>
                                </div>                                
                              </form>
                          </div>
                              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Join At</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                      <td>{{ $no++ }}</td>
                                      <td>{{ $user->name}}</td>
                                      <td>{{ $user->created_at->diffForHumans()}}</td>
                                      <td>
                                        <form action="{{route('destroy', $user->id)}}" method="POST">
                                          {{ csrf_field() }}
                                          {{ method_field('DELETE') }}
                                          <button href="#" type="submit" class="btn btn-danger btn-circle" onclick="return confirm('Are you Sure ?')">
                                            <i class="fas fa-trash"></i>
                                          </button>
                                        </form>
                                      </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                              </table>
                            </div>
                            <p>Halaman {{$users->currentPage()}}</p>
                            <div class="d-flex justify-content-center">
                              {{ $users->links() }}
                            </div>
                      </div>
                  </div>

            {{-- end table --}}
    </div>
    <script>
      setTimeout(() => {
          $('#deleted').slideUp('fast');
      }, 1500);
    </script>
@endsection