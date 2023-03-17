@props(['name'=>'','selected'=>false,'options'=>[],"value"=>'','label'=>false])
   <div class="form-group">
    @if ($label)
        <label>{{$label}}</label>
    @endif
       <select name="{{$name}}" {{$attributes->class([
         'form-control',
         'from-select',
         'is-invalid'=>$errors->has($name)
         ])}}>
        @foreach ($options as $value=>$option)
        <option value="{{$value}}" @selected(old($name,$value)==$selected)>{{$option}}</option>
        @endforeach
       </select>
        </div>