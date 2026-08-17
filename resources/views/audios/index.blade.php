@extends('layouts.admin')

@section('title', 'Audio')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <p class="text-sm text-gray-500">Manage uploaded audio tracks.</p>
        <a href="{{ route('audios.create') }}"
           class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">
            + Upload Audio
        </a>
    </div>

    <div class="overflow-x-auto rounded-xl bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-500">
                <tr>
                    <th class="px-6 py-3 font-medium">Thumbnail</th>
                    <th class="px-6 py-3 font-medium">Audio ID</th>
                    <th class="px-6 py-3 font-medium">Title</th>
                    <th class="px-6 py-3 font-medium">Artist</th>
                    <th class="px-6 py-3 font-medium">Category</th>
                    <th class="px-6 py-3 font-medium">Year</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($audios as $audio)
                    <tr>
                        <td class="px-6 py-3">
                            @if ($audio->thumbnail)
                                <img src="{{ asset('storage/'.$audio->thumbnail) }}" alt="{{ $audio->title }}" class="h-10 w-10 rounded object-cover">
                            @else
                                <div class="h-10 w-10 rounded bg-gray-100"></div>
                            @endif
                        </td>
                        <td class="px-6 py-3 font-mono text-xs text-gray-500">{{ $audio->audio_id }}</td>
                        <td class="px-6 py-3">{{ $audio->title }}</td>
                        <td class="px-6 py-3">{{ $audio->artist }}</td>
                        <td class="px-6 py-3">{{ $audio->category->name }}</td>
                        <td class="px-6 py-3">{{ $audio->year_of_publish }}</td>
                        <td class="px-6 py-3">
                            @if ($audio->status)
                                <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800">Active</span>
                            @else
                                <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-right space-x-3">
                            <a href="{{ route('audios.edit', $audio) }}" class="font-medium text-gray-700 hover:text-gray-900">Edit</a>
                            <form action="{{ route('audios.destroy', $audio) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this audio?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-6 text-center text-gray-500">No audio uploaded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $audios->links() }}
    </div>
@endsection
