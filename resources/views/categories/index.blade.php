@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <p class="text-sm text-gray-500">Manage audio categories.</p>
        <a href="{{ route('categories.create') }}"
           class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">
            + New Category
        </a>
    </div>

    <div class="overflow-x-auto rounded-xl bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-500">
                <tr>
                    <th class="px-6 py-3 font-medium">Name</th>
                    <th class="px-6 py-3 font-medium">Slug</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-6 py-3">{{ $category->name }}</td>
                        <td class="px-6 py-3 text-gray-500">{{ $category->slug }}</td>
                        <td class="px-6 py-3">
                            @if ($category->status)
                                <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800">Active</span>
                            @else
                                <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-right space-x-3">
                            <a href="{{ route('categories.edit', $category) }}" class="font-medium text-gray-700 hover:text-gray-900">Edit</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-gray-500">No categories yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
@endsection
