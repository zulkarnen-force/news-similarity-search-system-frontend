@extends('layouts.frontend')
@section('title','User Profile')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">User Profile</h1>
        </div>
    <!-- Start Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Profile</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <img src="{{url('/issets/img/undraw_profile.svg')}}" class="rounded mx-auto d-block" style="height: 150px; width:150px">
                <table class="table table-bordered mt-5">
                    <tr>
                        <th>Name</th>
                        <td>{{$users->name}}</td>
                    </tr>
                    <tr>
                        <th>Join at</th>
                        <td>{{date("F j, Y",strtotime($users->created_at))}}</td>
                    </tr>
                    <tr>
                        <th>authority</th>
                        <td>{{$users->roles}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection