<?php

namespace App\Http\Controllers;

use App\Models\Fatwa;
use App\Services\AccessControl;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FatwaAdminController extends Controller
{
    /**
     * Management list — shows every fatwa regardless of status, unlike the
     * public index which only shows published ones.
     */
    public function index()
    {
        $fatwas = Fatwa::with('creator')->orderByDesc('created_at')->get();

        return view('fatwa.admin-index', compact('fatwas'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Fatwa::nextSlug($data['title']);
        $data['created_by'] = AccessControl::user()->id;

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $fatwa = Fatwa::create($data);

        Helper::auditTrail('Fatwa Created', 'Fatwa', $fatwa->id, 'success', null, $data, "Published a new fatwa: \"{$fatwa->title}\".");

        return response()->json(['status' => true, 'message' => 'Fatwa saved successfully.', 'fatwa' => $fatwa]);
    }

    /**
     * Returns the raw record as JSON so the edit modal can populate itself,
     * matching the pattern your Nikah edit modal already uses.
     */
    public function edit(Fatwa $fatwa)
    {
        return response()->json(['status' => true, 'data' => $fatwa]);
    }

    public function update(Request $request, Fatwa $fatwa)
    {
        $data = $this->validated($request, $fatwa->id);

        if ($data['title'] !== $fatwa->title) {
            $data['slug'] = Fatwa::nextSlug($data['title']);
        }

        if ($data['status'] === 'published' && !$fatwa->published_at) {
            $data['published_at'] = now();
        }

        $fatwa->update($data);

        Helper::auditTrail('Fatwa Updated', 'Fatwa', $fatwa->id, 'success', null, $data, "Updated fatwa: \"{$fatwa->title}\".");

        return response()->json(['status' => true, 'message' => 'Fatwa updated successfully.', 'fatwa' => $fatwa->fresh()]);
    }

    public function destroy(Fatwa $fatwa)
    {
        $title = $fatwa->title;
        $fatwa->delete();

        Helper::auditTrail('Fatwa Deleted', 'Fatwa', $fatwa->id, 'success', null, null, "Deleted fatwa: \"{$title}\".");

        return response()->json(['status' => true, 'message' => 'Fatwa deleted successfully.']);
    }

    /**
     * One-click publish/unpublish from the management table, without
     * opening the full edit modal.
     */
    public function toggleStatus(Fatwa $fatwa)
    {
        $fatwa->status = $fatwa->status === 'published' ? 'draft' : 'published';

        if ($fatwa->status === 'published' && !$fatwa->published_at) {
            $fatwa->published_at = now();
        }

        $fatwa->save();

        return response()->json(['status' => true, 'message' => 'Status updated.', 'new_status' => $fatwa->status]);
    }

    protected function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'question' => ['required', 'string', 'max:2000'],
            'ruling' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'icon' => ['nullable', 'string', 'max:60'],
            'color' => ['nullable', 'string', 'max:20'],
            'quran_reference' => ['nullable', 'string'],
            'hadith_reference' => ['nullable', 'string'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ]);
    }
}