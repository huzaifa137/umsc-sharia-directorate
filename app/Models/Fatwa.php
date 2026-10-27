<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Fatwa extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'question',
        'ruling',
        'category',
        'icon',
        'color',
        'quran_reference',
        'hadith_reference',
        'youtube_url',
        'status',
        'published_at',
        'created_by',
        'views_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * A friendly palette the admin form cycles through by default, and the
     * public page falls back to if a fatwa somehow has no color set.
     */
    public const PALETTE = ['#6c3fc5', '#1791c8', '#1fa383', '#e08e0b', '#d6336c'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public static function nextSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . (++$i);
        }

        return $slug;
    }

    /**
     * Converts any of the common YouTube URL shapes (watch?v=, youtu.be/,
     * /embed/, with or without extra query params) into an /embed/ URL
     * suitable for an <iframe src>. Returns null if the field is empty or
     * doesn't look like YouTube at all.
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (!$this->youtube_url) {
            return null;
        }

        $id = null;

        if (preg_match('~youtu\.be/([A-Za-z0-9_-]{6,})~', $this->youtube_url, $m)) {
            $id = $m[1];
        } elseif (preg_match('~[?&]v=([A-Za-z0-9_-]{6,})~', $this->youtube_url, $m)) {
            $id = $m[1];
        } elseif (preg_match('~youtube\.com/embed/([A-Za-z0-9_-]{6,})~', $this->youtube_url, $m)) {
            $id = $m[1];
        }

        return $id ? "https://www.youtube.com/embed/{$id}" : null;
    }
}