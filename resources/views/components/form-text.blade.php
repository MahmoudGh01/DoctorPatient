<div class="mb-4">
    <label>{{$label}}:</label><br/>
    <input
        type="text"
        name="{{$name}}"
        placeholder="{{$placeholder}}"
        value="{{old($name,$value)}}"
        class="w-full border @error($name) border-red-500 @else border-black @enderror"
    >
    @error($name)
    <div class="text-red-500">{{$message}}</div>
    @enderror
</div>
