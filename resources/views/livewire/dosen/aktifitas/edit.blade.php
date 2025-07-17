<div class="relative">
    <input 
        type="number" 
        min="0" 
        max="100" 
        wire:model.live="{{ $field }}"
        wire:key="input-{{ $field }}"
        value="{{ $value }}"
        class="w-16 px-2 py-1 border rounded text-center @error($field) border-red-500 @enderror"
        @if($value === '') placeholder="0" @endif
    >
    @error($field)
        <div class="absolute top-full left-0 text-xs text-red-500 mt-1 w-full">
            Nilai harus antara 0-100
        </div>
    @enderror
</div>