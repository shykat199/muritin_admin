@extends('layouts.admin')

@section('title', 'New Category')

@section('content')
    <div class="max-w-lg rounded-xl bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('categories.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Bollywood Hits" required
                       class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500">
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug <span class="text-gray-400">(optional, auto-generated)</span></label>
                <input id="slug" type="text" name="slug" value="{{ old('slug') }}" placeholder="e.g. bollywood-hits"
                       class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500">
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="rounded border-gray-300">
                Active
            </label>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">
                    Save
                </button>
                <a href="{{ route('categories.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Cancel</a>
            </div>
        </form>
    </div>
@endsection
