@extends('admin.layouts.dashboard')
@push('style')
{{-- <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">   --}}
@endpush
@section('user',Auth::user()->name)
@section('title-page',"category")
{{-- @section('title',env('APP_NAME')) --}}
@section('title',config('app.name'))
@section('content')
<div class="content">
    <a class="btn sm btn-outline-primary mb-2" href="{{route('admin.role.create')}}" >create</a>
    <div class="container-fluid">
     <x-alert type="success"/>
     <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>Email</th>
                <th>role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
            <tr>
                <td>{{$admin->id}}</td>
                <td><a href="{{route('admin.admin.edit',$admin->id)}}" class="text text-primary">{{$admin->name}}</td>
                <td>{{$admin->email}}</td>
            </tr>  
            @endforeach
        </tbody>
     </table>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    {{$admins->links()}}
  </div>
@endsection

@section('nav-link')
@parent
<li class="breadcrumb-item active">Starter Page</li>
@endsection