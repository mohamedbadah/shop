@extends('admin.layouts.dashboard')
@push('style')
{{-- <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">   --}}
@endpush
@section('user',Auth::user()->name)
@section('title-page',"product")
{{-- @section('title',env('APP_NAME')) --}}
@section('title',config('app.name'))
@section('content')
<div class="content">
    <div class="container-fluid">
     <form action="{{route('admin.product.update',$product->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="put"/> 
          @include('admin.dashboard.product.__form',[
            'update'=>"Update"
          ])
     </form>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
@endsection

@section('nav-link')
@parent
<li class="breadcrumb-item active">Starter Page</li>
@endsection
@push('style')
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" /> 
@endpush
@push('script')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script> 
<script>
  var inputElm = document.querySelector("[name='tag']"),
    tagify = new Tagify (inputElm);
</script>
@endpush