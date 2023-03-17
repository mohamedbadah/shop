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
                <th colspan="2">action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
            <tr>
                <td>{{$role->id}}</td>
                <td>{{$role->name}}</td>
                @can('update', $role)
                <td><a href="{{route('admin.role.edit',$role->id)}}" class="btn btn-outline-primary">Edit</a></td>                    
                @endcan
                <td>
                    @can('delete',$role)
                    <form action="{{route('admin.role.destroy',$role->id)}}" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <input type="hidden" name="_method" value="delete" />
                        {{-- @csrf --}}
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>    
                    @endcan
                </td>   
            </tr>  
            @endforeach
        </tbody>
     </table>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    {{$roles->links()}}
  </div>
@endsection

@section('nav-link')
@parent
<li class="breadcrumb-item active">Starter Page</li>
@endsection