@props(['type'=>'text','value'=>'','name','label'=>false,'id'=>''])
<div class="form-group">
    @if ($label)
    <label for="{{$id}}">{{$label}}</label>
    @endif
    <textarea type="{{$type}}" name="name" id="{{$id}}"
      {{$attributes->class([
        'form-control',
        'is-invalid'=>$errors->has($name)
      ])}}
    >{{old($name,$value)}}</textarea>
        @error($name)
            <li class="invalid-feedback">{{$message}}</li>
        @enderror
</div>