@if ($errors->any())
<div class="alert alert-danger">
 <h3>Error Occured!</h3>
 @foreach ($errors->all() as $error)
     <li>{{$error}}</li>
 @endforeach
</div>
@endif
<div class="form-group">
<x-form.label>role</x-form.label>
<x-form.input name="name" :value="$role->name"  id="name" label="name"/>
</div>
<div class="form-group">
@foreach (app("abilities") as $bility_code=>$ability_name)
<div class="row">
    <div class="col-sm-6">
       {{$ability_name}}
</div>

   <div class="col-sm-2">        
    <input type="radio" @if (isset($role_ability[$bility_code])) @checked($role_ability[$bility_code]=="allows") @endif   name="abilities[{{$bility_code}}]" value="allows"/> allows
    </div>
   <div class="col-sm-2">
    <input type="radio" @if (isset($role_ability[$bility_code])) @checked($role_ability[$bility_code]=="deny") @endif   name="abilities[{{$bility_code}}]" value="deny"/> deny
   </div>
   <div class="col-sm-2">
    <input type="radio" @if (isset($role_ability[$bility_code])) @checked($role_ability[$bility_code]=="inherit") @endif  name="abilities[{{$bility_code}}]" value="inherit"/> inherit
   </div>
    <br>
</div>
@endforeach
</div>
<div class="form-group"><button type="submit" class="btn btn-primary">{{$update??"save"}}</button></div>