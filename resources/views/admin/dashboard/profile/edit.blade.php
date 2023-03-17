@extends('admin.layouts.dashboard')
@push('style')
@endpush
@section('user',Auth::user()->name)
@section('title-page',"profile")
{{-- @section('title',env('APP_NAME')) --}}
@section('title',config('app.name'))
@section('content')
<div class="content">
    <x-alert type="success"/>
    <div class="container-fluid">
     <form action="{{route('admin.update_profile')}}" method="POST">
        @csrf
        @method("patch")
        <div class="form-row">
         <div class="col-sm-6">
      <x-form.input name="first_name" :value="$user->profile->first_name" label="first name"/>
       </div>
       <div class="col-sm-6">
      <x-form.input name="last_name" :value="$user->profile->last_name" label="last name"/>
       </div>
          </div>
          <div class="form-row">
            <div class="col-sm-6">
                <x-form.input type="date" name="birthday" :value="$user->profile->birthday" label="birthday"/>
            </div>
            <div class="col-sm-6">
        <x-form.radio name="gender" :option="['male','female']" :checked="$user->profile->gender"/>
            </div>
          </div>
          <div class="form-row">
            <div class="col-sm-4">
                <x-form.input name="city" :value="$user->profile->city" label="city"/>
            </div>
            <div class="col-sm-4">
                <x-form.input name="street_address" :value="$user->profile->street_address" label="street_address"/>
            </div>
            <div class="col-sm-4">
                <x-form.input name="status" :value="$user->profile->status" label="status"/>
            </div>
          </div>
          <div class="form-row">
            <div class="col-sm-4">
              <x-form.input name="postal_code" :value="$user->profile->postal_code" label="postal_code"/>
            </div>
            <div class="col-sm-4">
                <x-form.select name="country" :options="$countries" :selected="$user->profile->country" label="country"/>
            </div>
            <div class="col-sm-4">
        <x-form.select name="locale" :options="$Locales" :selected="$user->profile->locale" label="locale"/>
            </div>
          </div>
         <button type="submit" class="btn btn-primary">save</button>
     </form>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
@endsection

@section('nav-link')
@parent
<li class="breadcrumb-item active">Starter Page</li>
@endsection