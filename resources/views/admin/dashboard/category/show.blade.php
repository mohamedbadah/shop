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
    <a class="btn sm btn-outline-primary mb-2" href="{{route('admin.category.index')}}" >back</a>
    <div class="container-fluid">
     <x-alert type="success"/>
     <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>image</th>
                <th>price</th>
                <th>store</th>
                <th>category</th>
                <th colspan="2">action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $products=$category->products()->with("store")->latest("id")->paginate(5);
            @endphp
            @foreach ($products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->name}}</td>
                {{-- <td><img src='{{asset("storage/$product->image")}}' height="50"/></td> --}}
                <td><img src='{{$product->image}}' height="50"/></td>
                <td>{{$product->price}}</td>
                <td>{{$product->store->name}}</td>
                <td>{{$product->category->name}}</td>
                <td><a href="{{route('admin.product.edit',$product->id)}}" class="btn btn-outline-primary">Edit</a></td>
                <td>
                    <form action="{{route('admin.product.destroy',$product->id)}}" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <input type="hidden" name="_method" value="delete" />
                        {{-- @csrf --}}
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>  
            @endforeach
        </tbody>
     </table>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    {{$products->links()}}
    {{-- {{$categories->withQueryString()->links("paginator.pag")}} --}}
    {{-- {{$category->products->withQueryString()->appends(['search'=>1])->links()}} --}}
  </div>
@endsection

@section('nav-link')
@parent
<li class="breadcrumb-item active">Starter Page</li>
@endsection