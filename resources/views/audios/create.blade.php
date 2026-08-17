@extends('layouts.admin')

@section('title', 'Upload Audio')

@section('content')
    <div class="w-full rounded-xl bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('audios.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select id="category_id" name="category_id" required
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Tum Hi Ho" required
                       class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500">
            </div>

            <div>
                <label for="artist" class="block text-sm font-medium text-gray-700">Artist</label>
                <input id="artist" type="text" name="artist" value="{{ old('artist') }}" placeholder="e.g. Arijit Singh" required
                       class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500">
            </div>

            <div>
                <label for="year_of_publish" class="block text-sm font-medium text-gray-700">Year of Publish</label>
                <input id="year_of_publish" type="number" name="year_of_publish" value="{{ old('year_of_publish') }}"
                       min="1900" max="{{ date('Y') + 1 }}" placeholder="e.g. {{ date('Y') }}" required
                       class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500">
            </div>

            @include('audios._media-fields')

            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="rounded border-gray-300">
                Active
            </label>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">
                    Save
                </button>
                <a href="{{ route('audios.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Cancel</a>
            </div>
        </form>
    </div>

    @include('audios._dropzone-scripts')
@endsection
