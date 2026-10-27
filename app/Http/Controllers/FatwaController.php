<?php

namespace App\Http\Controllers;

use App\Models\Fatwa;
use Illuminate\Http\Request;

class FatwaController extends Controller
{
    /**
     * Public listing — anyone visiting the site can see this, no login
     * required. Only ever shows published fatwas.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));
        $category = trim((string) $request->query('category'));

        $fatwas = Fatwa::published()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('question', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->when($category !== '', fn ($query) => $query->where('category', $category))
            ->orderByDesc('published_at')
            ->get();

        $categories = Fatwa::published()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('fatwa.public.index', compact('fatwas', 'categories', 'search', 'category'));
    }

    /**
     * Public detail page for a single fatwa.
     */
    public function show(Fatwa $fatwa)
    {
        $isPublished = $fatwa->status === 'published' && (!$fatwa->published_at || $fatwa->published_at->isPast());

        // Anyone logged into the admin panel (the Director, previewing before
        // publishing) can see a draft via this same route — the public route
        // has no auth middleware at all, so we check the session directly
        // rather than relying on a permission gate.
        abort_unless($isPublished || session()->has('LoggedAdmin'), 404);

        if ($isPublished) {
            $fatwa->increment('views_count');
        }

        $related = Fatwa::published()
            ->where('id', '!=', $fatwa->id)
            ->when($fatwa->category, fn ($q) => $q->where('category', $fatwa->category))
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('fatwa.public.show', compact('fatwa', 'related'));
    }
}