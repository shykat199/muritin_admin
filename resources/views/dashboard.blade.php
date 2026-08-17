@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Categories</p>
            <p class="mt-2 text-3xl font-semibold">{{ $categoriesCount }}</p>
        </div>
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Total Audio</p>
            <p class="mt-2 text-3xl font-semibold">{{ $audiosCount }}</p>
        </div>
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Active Audio</p>
            <p class="mt-2 text-3xl font-semibold">{{ $activeAudiosCount }}</p>
        </div>
    </div>

    <div class="mt-6 rounded-xl bg-white shadow-sm">
        <div class="border-b border-gray-100 px-6 py-4">
            <h2 class="font-semibold">Recently added audio</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-3 font-medium">Audio ID</th>
                        <th class="px-6 py-3 font-medium">Title</th>
                        <th class="px-6 py-3 font-medium">Artist</th>
                        <th class="px-6 py-3 font-medium">Category</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($latestAudios as $audio)
                        <tr>
                            <td class="px-6 py-3 font-mono text-xs text-gray-500">{{ $audio->audio_id }}</td>
                            <td class="px-6 py-3">{{ $audio->title }}</td>
                            <td class="px-6 py-3">{{ $audio->artist }}</td>
                            <td class="px-6 py-3">{{ $audio->category->name }}</td>
                            <td class="px-6 py-3">
                                @if ($audio->status)
                                    <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800">Active</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">No audio uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
