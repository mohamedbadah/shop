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
    <a class="btn sm btn-outline-primary mb-2" href="{{route('admin.category.create')}}" >create</a>
    <a class="btn sm btn-outline-primary mb-2" href="{{route('admin.category.trash')}}" >archive</a>

    <div class="container-fluid">
     <x-alert type="success"/>
     <x-alert type="info"/>
     <form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">
        <div class="row">
            <div class="col-sm-5">
        <x-form.input name="name"  :value="request('name')" class="form-control"/>
    </div>
    <div class="col-sm-5">
        <div class="form-group">
       <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status')=="active")>active</option>
        <option value="inactive" @selected(request('status')=="inactive")>inactive</option>
       </select>
       </div>
    </div>
    <div class="col-sm-2">
       <button class="btn btn-dark mx-2">Filter</button>
    </div>
    </div>
     </form>
     <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>image</th>
                <th>description</th>
                <th>product</th>
                <th>parent_id</th>
                <th colspan="2">action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td><img src='{{asset("storage/$category->image")}}' height="50"/></td>
                <td>{{$category->description}}</td>
                <td><a href="{{route("admin.category.show",$category->id)}}">products({{$category->products_count}})</a></td>
                <td>{{$category->parent->name}}</td>
                @can('category.update')
                <td><a href="{{route('admin.category.edit',$category->id)}}" class="btn btn-outline-primary">Edit</a></td>                    
                @endcan
                @if (Auth::user()->can("category.destroy"))
                <td>
                    <form action="{{route('admin.category.destroy',$category->id)}}" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <input type="hidden" name="_method" value="delete" />
                        {{-- @csrf --}}
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td> 
                @endif    
            </tr>  
            @endforeach
        </tbody>
     </table>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    {{-- {{$categories->links()}} --}}
    {{-- {{$categories->withQueryString()->links("paginator.pag")}} --}}
    {{$categories->withQueryString()->appends(['search'=>1])->links()}}
  </div>
@endsection

@section('nav-link')
@parent
<li class="breadcrumb-item active">Starter Page</li>
@endsection