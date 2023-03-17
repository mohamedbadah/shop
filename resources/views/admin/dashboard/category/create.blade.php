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
    <div class="container-fluid">
     <form action="{{route('admin.category.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.dashboard.category.__form')
     </form>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
@endsection

@section('nav-link')
@parent
<li class="breadcrumb-item active">Starter Page</li>
@endsection