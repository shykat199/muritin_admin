<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Audio extends Model
{
    protected $fillable=['audio_id', 'category_id', 'title', 'artist', 'audio_file', 'thumbnail', 'year_of_publish', 'status'];
    protected $table = 'audios';

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'year_of_publish' => 'integer',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Audio $audio) {
            if (empty($audio->audio_id)) {
                $audio->audio_id = static::generateUniqueAudioId();
            }
        });
    }

    protected static function generateUniqueAudioId(): string
    {
        do {
            $id = 'AUD-'.strtoupper(Str::random(8));
        } while (static::where('audio_id', $id)->exists());

        return $id;
    }
}
