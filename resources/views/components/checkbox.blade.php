<div>
    <label class="flex items-center space-x-2 cursor-pointer">
        <input
            type="checkbox"
            name="{{ $name }}"
            value="{{ $value ?? 1 }}"
            @checked($checked ?? false)
            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
        >
        <span class="text-gray-700 text-sm">{{ $label }}</span>
    </label>
</div>
