@if ($errors->any())
<div class="alert alert-danger">
 <h3>Error Occured!</h3>
 @foreach ($errors->all() as $error)
     <li>{{$error}}</li>
 @endforeach
</div>
@endif
<div class="form-row">
    <div class="col-sm-6">
    <x-form.input name="name" :value="$product->name" id="name" label="name"/>
    </div>
    <div class="col-sm-6">
        <x-form.textarea name="description" id="descs" :value="$product->description" label="description"/>
    </div>
</div>
<div class="form-row">
    <div class="col-sm-6">
        <x-form.input type="file" name="image" label="image"/>
    </div>
    <div class="col-sm-6">
        <x-form.label>category</x-from.label>
        <select name="category_id" class="form-control">
            <option value="">category optinal</option>
            @foreach (App\Models\Category::all() as $category)
                <option value="{{$category->id}}" @selected(old('category_id',$product->category_id)==$category->id)>{{$category->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-row">
    <div class="col-sm">
    <x-form.input name="price" :value="$product->price" label="price"/>
    </div>
    <div class="col-sm">
    <x-form.input name="price_compare" :value="$product->price_compare" label="price_compare"/>
    </div>
</div>
<div class="form-row">
    <div class="col-sm-6">
        <x-form.radio name="status" :option="['active','archived','draft']" :checked="$product->status"/>
    </div>
    <div class="col-sm-6">
        <x-form.input label="Tags" name="tag" :value="$tags"/>
    </div>
</div>
<div class="form-group"><button type="submit" class="btn btn-primary">{{$update??"save"}}</button></div>