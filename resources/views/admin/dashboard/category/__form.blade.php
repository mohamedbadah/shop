       @if ($errors->any())
           <div class="alert alert-danger">
            <h3>Error Occured!</h3>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
           </div>
       @endif
       {{-- <div class="form-group">
            <label for="name">name</label>
            <input type="text" name="name" id="name" value="{{old('name',$category->name)}}"@class(
                ['form-control', 'is-invalid' => $errors->has('name')])>
                @error('name')
                    <li class="invalid-feedback">{{$message}}</li>
                @enderror
        </div> --}}
        <x-form.label value="name">dsfdsfsd</x-form.label>
        <x-form.input name="name" :value="$category->name" id="name" label="name"/>
        {{-- <div class="form-group">
            <label for="desc" >description</label>
            <textarea class="form-control" name="description">{{old('description',$category->description)}}</textarea>
        </div> --}}
        <x-form.textarea name="description" id="descs" :value="$category->description" label="description"/>
        {{-- <div class="form-group">
            <label for="desc" >image</label>
            <input type="file" name="image" id="file" class="form-control">
        </div> --}}
        <x-form.input type="file" name="image"/>
        {{-- <div class="form-group">
            <label for="">status</label><br/>
           <input type="radio" name="status" value="active" @checked(old('status',$category->status)=="active")/>active<br>
           <input type="radio" name="status" value="inactive" @checked(old('status',$category->status)=="inactive")/>inactive<br/>
        </div> --}}
      <x-form.radio name="status" :checked="$category->status" :option="['active','inactive']"/>
        <div class="form-group">
            <select name="parent_id" class="form-control">
                <option value="">category optinal</option>
                @foreach ($parent as $item)
                    <option value="{{$item->id}}" @selected(old('parent_id',$category->parent_id)==$item->id)>{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group"><button type="submit" class="btn btn-primary">{{$update??"save"}}</button></div>