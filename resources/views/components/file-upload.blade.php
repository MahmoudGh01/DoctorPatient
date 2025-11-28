<div
    x-data="{
        preview: null,
        showPreview(event) {
            const file = event.target.files[0];
            if (file) {
                this.preview = URL.createObjectURL(file);
            }
        }
    }"
    class="mb-4"
>
    @if($label)
        <label>{{ $label }}:</label><br/>
    @endif

    <input
        type="file"
        name="{{ $name }}"
        accept="{{ $accept }}"
        @change="showPreview"
        class="w-full border @error($name) border-red-500 @else border-black @enderror p-2 rounded"
    >

    {{-- Preview --}}
    <template x-if="preview">
        <img
            :src="preview"
            class="h-24 mt-4 rounded border shadow object-cover"
        >
    </template>

    @error($name)
    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
    @enderror
</div>
