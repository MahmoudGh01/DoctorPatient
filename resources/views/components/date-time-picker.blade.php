<div
    x-data="{
        date: '{{ old($name, $value ? \Carbon\Carbon::parse($value)->toDateString() : '') }}',
        time: '{{ old($name, $value ? \Carbon\Carbon::parse($value)->format('H:i') : '') }}',
        update() {
            if (this.date && this.time) {
                $refs.output.value = `${this.date} ${this.time}:00`;
            }
        }
    }"
    x-init="update()"
    class="mb-4"
>
    @if($label)
        <label>{{ $label }}:</label><br/>
    @endif

    <input
        type="hidden"
        x-model="date"
        @change="update()"
        class="w-full border mb-2 @error($name) border-red-500 @else border-black @enderror"
    >

    <input
        type="hidden"
        x-model="time"
        @change="update()"
        class="w-full border @error($name) border-red-500 @else border-black @enderror"
    >

    <input type="hidden" name="{{ $name }}" x-ref="output">

    @error($name)
    <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>
