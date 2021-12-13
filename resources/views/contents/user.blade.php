@extends('layouts.frontend')
@section('title','Users')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">User</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
                </a>
            </div>
            {{-- start table --}}
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Join_at</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $user->name}}</td>
                      <td>{{ $user->created_at}}</td>
                      <td>
                        <form action="{{route('destroy', $user->id)}}" method="POST">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                          <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you Sure ?')">Hapus</button>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>


            {{-- end table --}}
    </div>
@endsection