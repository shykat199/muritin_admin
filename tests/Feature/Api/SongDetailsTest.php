<?php

namespace Tests\Feature\Api;

use App\Models\Audio;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SongDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_song_details_can_be_fetched_by_audio_id(): void
    {
        $category = Category::create([
            'name' => 'Pop',
            'slug' => 'pop',
            'status' => true,
        ]);

        $song = Audio::create([
            'audio_id' => 'AUD-TEST1234',
            'category_id' => $category->id,
            'title' => 'Test Song',
            'artist' => 'Test Artist',
            'audio_file' => 'test-song.mp3',
            'thumbnail' => 'test-song.webp',
            'year_of_publish' => 2026,
            'status' => true,
        ]);

        $this->getJson('/api/songs/'.$song->audio_id)
            ->assertOk()
            ->assertJsonPath('data.audio_id', 'AUD-TEST1234')
            ->assertJsonPath('data.title', 'Test Song')
            ->assertJsonPath('data.artist', 'Test Artist')
            ->assertJsonPath('data.year_of_publish', 2026)
            ->assertJsonPath('data.category.id', $category->id)
            ->assertJsonPath('data.category.name', 'Pop')
            ->assertJsonPath('data.category.slug', 'pop')
            ->assertJsonPath('data.thumbnail_url', asset('uploads/thumbnails/test-song.webp'))
            ->assertJsonPath('data.audio_url', asset('uploads/audios/test-song.mp3'));
    }

    public function test_inactive_song_is_not_exposed(): void
    {
        $category = Category::create([
            'name' => 'Pop',
            'slug' => 'pop',
            'status' => true,
        ]);

        Audio::create([
            'audio_id' => 'AUD-INACTIVE',
            'category_id' => $category->id,
            'title' => 'Inactive Song',
            'artist' => 'Test Artist',
            'audio_file' => 'inactive.mp3',
            'year_of_publish' => 2026,
            'status' => false,
        ]);

        $this->getJson('/api/songs/AUD-INACTIVE')->assertNotFound();
    }

    public function test_unknown_audio_id_returns_not_found(): void
    {
        $this->getJson('/api/songs/AUD-UNKNOWN')->assertNotFound();
    }
}
