@if ($errors->any())
<div class="alert alert-danger">
 <h3>Error Occured!</h3>
 @foreach ($errors->all() as $error)
     <li>{{$error}}</li>
 @endforeach
</div>
@endif
<div class="form-group">
<x-form.label>admin</x-form.label>
<x-form.input name="name" :value="$admin->name"  id="name" label="name"/>
<x-form.input name="email" :value="$admin->email"  id="name" label="name"/>
    @foreach ($roles as $role)
     <div class="row">
        <div class="col-sm-4">{{$role->name}}</div>
        <div class="col-sm-4"><input type="checkbox" name="role[{{$role->id}}]" value="{{$role->id}}" @checked(isset($role_admin[$role->id])==$role->id)/> {{$role->name}}</div>
     </div>
    @endforeach
</div>
<div class="form-group">
</div>
<div class="form-group"><button type="submit" class="btn btn-primary">{{$update??"save"}}</button></div>