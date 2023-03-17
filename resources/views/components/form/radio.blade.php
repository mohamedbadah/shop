@props(['name','checked'=>false,'option'])
   <div class="form-group">
            <label for="">status</label><br/>
           @foreach ($option as $item)
           <input type="radio" name="{{$name}}" value="{{$item}}" 
           @checked(old('status',$checked)==$item)
            {{-- {{$attributes->class([
                'form-check-input'
            ])}} --}}
           />{{$item}}<br>    
           @endforeach 
        </div>