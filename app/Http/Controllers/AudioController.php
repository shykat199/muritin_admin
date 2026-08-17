<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Shykat\WebpBolt\Encoders\WebpEncoder;
use Shykat\WebpBolt\ImageProcessor;
use Shykat\WebpBolt\Transforms\Resize;

class AudioController extends Controller
{
    public function index(): View
    {
        $audios = Audio::with('category')->latest()->paginate(15);

        return view('audios.index', compact('audios'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('audios.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {

        try {
            ini_set('memory_limit', '512M');
            set_time_limit(300);

            $validated = $request->validate($this->rules());

            $storedFiles = [];

            $validated['audio_file'] = $request->file('audio_file')->store('audios', 'public');
            $storedFiles[] = $validated['audio_file'];

            if ($request->hasFile('thumbnail')) {
                $validated['thumbnail'] = $this->storeThumbnailAsWebp($request->file('thumbnail'));
                $storedFiles[] = $validated['thumbnail'];
            }

            $validated['status'] = $request->boolean('status');

            Audio::create($validated);
        } catch (\Throwable $exception) {
            foreach ($storedFiles as $path) {
                Storage::disk('public')->delete($path);
            }

            return back()
                ->withInput()
                ->with('error', 'Could not save the audio. Please try again.');
        }

        return redirect()->route('audios.index')->with('status', 'Audio created successfully.');
    }

    public function edit(Audio $audio): View
    {
        $categories = Category::orderBy('name')->get();

        return view('audios.edit', compact('audio', 'categories'));
    }

    public function update(Request $request, Audio $audio): RedirectResponse
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $validated = $request->validate($this->rules(forUpdate: true));

        if ($request->hasFile('audio_file')) {
            Storage::disk('public')->delete($audio->audio_file);
            $validated['audio_file'] = $request->file('audio_file')->store('audios', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            if ($audio->thumbnail) {
                Storage::disk('public')->delete($audio->thumbnail);
            }
            $validated['thumbnail'] = $this->storeThumbnailAsWebp($request->file('thumbnail'));
        }

        $validated['status'] = $request->boolean('status');

        $audio->update($validated);

        return redirect()->route('audios.index')->with('status', 'Audio updated successfully.');
    }

    public function destroy(Audio $audio): RedirectResponse
    {
        Storage::disk('public')->delete(array_filter([$audio->audio_file, $audio->thumbnail]));

        $audio->delete();

        return redirect()->route('audios.index')->with('status', 'Audio deleted successfully.');
    }

    private function storeThumbnailAsWebp(UploadedFile $file): string
    {
        $relativePath = 'thumbnails/' . Str::random(40) . '.webp';
        $destination = Storage::disk('public')->path($relativePath);

        (new ImageProcessor())
            ->addTransform(new Resize(800, 800))
            ->save($file->getRealPath(), $destination, new WebpEncoder(quality: 80));

        return $relativePath;
    }

    private function rules(bool $forUpdate = false): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'artist' => ['required', 'string', 'max:255'],
            'audio_file' => [$forUpdate ? 'nullable' : 'required', 'file', 'mimes:mp3,mpga', 'max:102400'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'year_of_publish' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'status' => ['nullable', 'boolean'],
        ];
    }
}
