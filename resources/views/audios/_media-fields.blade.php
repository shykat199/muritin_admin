@php
    $isEdit = isset($audio) && $audio->exists;
@endphp

<div>
    <label class="block text-sm font-medium text-gray-700">
        Audio File <span class="text-gray-400">(MP3, max 8MB @if ($isEdit) — leave empty to keep current @endif)</span>
    </label>
    <div id="audio-dropzone"
         class="mt-1 flex cursor-pointer flex-col items-center justify-center gap-1 rounded-lg border-2 border-dashed border-gray-300 p-4 text-center transition-colors hover:border-gray-400 hover:bg-gray-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-2v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-2c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z" />
        </svg>
        <p class="text-sm text-gray-600"><span class="font-medium text-gray-800">Click to upload</span> or drag and drop</p>
        <p class="text-xs text-gray-400">MP3 up to 8MB</p>
        <input id="audio_file" type="file" name="audio_file" accept=".mp3,audio/mpeg" {{ $isEdit ? '' : 'required' }} class="hidden">
    </div>
    <div id="audio-preview" class="mt-3 rounded-lg border border-gray-200 p-3 {{ $isEdit && $audio->audio_file ? '' : 'hidden' }}">
        <p id="audio-filename" class="mb-2 truncate text-xs font-medium text-gray-600">
            @if ($isEdit && $audio->audio_file)
                Current: {{ basename($audio->audio_file) }}
            @endif
        </p>
        <audio id="audio-player" controls class="w-full" @if ($isEdit && $audio->audio_file) src="{{ asset('uploads/audios/'.$audio->audio_file) }}" @endif></audio>
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">
        Thumbnail Image @if ($isEdit) <span class="text-gray-400">(leave empty to keep current)</span> @endif
    </label>
    <div id="thumb-dropzone"
         class="mt-1 flex cursor-pointer flex-col items-center justify-center gap-1 rounded-lg border-2 border-dashed border-gray-300 p-4 text-center transition-colors hover:border-gray-400 hover:bg-gray-50">
        <img id="thumb-preview-img"
             src="{{ $isEdit && $audio->thumbnail ? asset('uploads/thumbnails/'.$audio->thumbnail) : '' }}"
             class="mb-2 h-40 w-40 rounded-lg object-cover {{ $isEdit && $audio->thumbnail ? '' : 'hidden' }}">
        <div id="thumb-placeholder" class="flex flex-col items-center gap-1 {{ $isEdit && $audio->thumbnail ? 'hidden' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V7a1 1 0 011-1z" />
            </svg>
            <p class="text-sm text-gray-600"><span class="font-medium text-gray-800">Click to upload</span> or drag and drop</p>
            <p class="text-xs text-gray-400">PNG, JPG up to 2MB</p>
        </div>
        <input id="thumbnail" type="file" name="thumbnail" accept="image/*" class="hidden">
    </div>
</div>
