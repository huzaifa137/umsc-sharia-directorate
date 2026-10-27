<?php
// app/Http/Controllers/ConsultancyController.php

namespace App\Http\Controllers;

use App\Models\ConsultancyApplication;
use App\Models\SearchIndex;
use App\Services\AccessControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ConsultancyController extends Controller
{
    /**
     * Dashboard - shows statistics and recent applications
     */
    public function dashboard()
    {
        $user = AccessControl::user();
        $role = AccessControl::role();
        
        $query = ConsultancyApplication::query();
        
        // Apply data scope
        if ($role) {
            switch ($role->data_scope) {
                case 'self':
                    $query->where('created_by', $user->id);
                    break;
                case 'county':
                    $query->where('officer_county', $user->county);
                    break;
                case 'district':
                    $query->where('officer_district', $user->district);
                    break;
                case 'region':
                    $query->where('officer_region', $user->region);
                    break;
                case 'global':
                    break;
            }
        }
        
        $stats = [
            'total' => $query->count(),
            'submitted' => (clone $query)->where('status', 'submitted')->count(),
            'under_review' => (clone $query)->where('status', 'under_review')->count(),
            'reviewed' => (clone $query)->where('status', 'reviewed')->count(),
            'approved' => (clone $query)->where('status', 'approved')->count(),
            'rejected' => (clone $query)->where('status', 'rejected')->count(),
            'accomplished' => (clone $query)->where('status', 'accomplished')->count(),
        ];
        
        $recent = $query->orderByDesc('created_at')->limit(10)->get();
        
        return view('consultancy.dashboard', compact('stats', 'recent'));
    }

    /**
     * Create new consultation application
     */
    public function create()
    {
        return view('consultancy.create');
    }

    /**
     * Store consultation application
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'applicant_phone' => 'required|string|max:20',
            'applicant_email' => 'nullable|email|max:255',
            'applicant_nin' => 'nullable|string|max:20',
            'applicant_address' => 'nullable|string|max:500',
            'applicant_occupation' => 'nullable|string|max:255',
            'consultation_type' => 'required|in:business,family,financial,property,employment,educational,health,social,religious,other',
            'consultation_type_other' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:500',
            'description' => 'required|string',
            'background_info' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $user = AccessControl::user();
        
        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('consultancy/attachments', 'public');
            $attachmentPath = $path;
        }

        $application = ConsultancyApplication::create([
            'application_id' => ConsultancyApplication::generateApplicationId(),
            'created_by' => $user->id,
            'officer_district' => $user->district ?? null,
            'officer_county' => $user->county ?? null,
            'officer_region' => $user->region ?? null,
            'applicant_name' => $data['applicant_name'],
            'applicant_phone' => $data['applicant_phone'],
            'applicant_email' => $data['applicant_email'] ?? null,
            'applicant_nin' => $data['applicant_nin'] ?? null,
            'applicant_address' => $data['applicant_address'] ?? null,
            'applicant_occupation' => $data['applicant_occupation'] ?? null,
            'consultation_type' => $data['consultation_type'],
            'consultation_type_other' => $data['consultation_type_other'] ?? null,
            'subject' => $data['subject'] ?? null,
            'description' => $data['description'],
            'background_info' => $data['background_info'] ?? null,
            'attachment_path' => $attachmentPath,
            'status' => 'submitted',
        ]);

        // Create search index entry
        SearchIndex::create([
            'module' => 'consultancy',
            'application_id' => $application->application_id,
            'title' => "Consultation: {$application->consultation_type_label}",
            'keywords' => "{$application->applicant_name} {$application->subject} {$application->consultation_type}",
            'reference_id' => $application->id,
            'created_by' => $user->id,
            'officer_district' => $user->district ?? null,
            'officer_county' => $user->county ?? null,
            'status' => $application->status,
            'application_date' => now()->toDateString(),
            'required_role' => $user->role_id ?? null,
        ]);

        return redirect()->route('consultancy.show', $application->id)
            ->with('success', 'Consultation request submitted successfully.');
    }

    /**
     * Display consultation application
     */
    public function show(ConsultancyApplication $consultancy)
    {
        $this->authorizeView($consultancy);
        return view('consultancy.show', compact('consultancy'));
    }

    /**
     * Edit consultation application
     */
    public function edit(ConsultancyApplication $consultancy)
    {
        $this->authorizeEdit($consultancy);
        return view('consultancy.edit', compact('consultancy'));
    }

    /**
     * Update consultation application
     */
    public function update(Request $request, ConsultancyApplication $consultancy)
    {
        $this->authorizeEdit($consultancy);

        $data = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'applicant_phone' => 'required|string|max:20',
            'applicant_email' => 'nullable|email|max:255',
            'applicant_nin' => 'nullable|string|max:20',
            'applicant_address' => 'nullable|string|max:500',
            'applicant_occupation' => 'nullable|string|max:255',
            'consultation_type' => 'required|in:business,family,financial,property,employment,educational,health,social,religious,other',
            'consultation_type_other' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:500',
            'description' => 'required|string',
            'background_info' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            if ($consultancy->attachment_path) {
                Storage::disk('public')->delete($consultancy->attachment_path);
            }
            $data['attachment_path'] = $request->file('attachment')->store('consultancy/attachments', 'public');
        }

        $consultancy->update($data);

        return redirect()->route('consultancy.show', $consultancy->id)
            ->with('success', 'Consultation request updated successfully.');
    }

    /**
     * Delete consultation application
     */
    public function destroy(ConsultancyApplication $consultancy)
    {
        $this->authorizeDelete($consultancy);

        if ($consultancy->attachment_path) {
            Storage::disk('public')->delete($consultancy->attachment_path);
        }

        $consultancy->delete();

        return redirect()->route('consultancy.dashboard')
            ->with('success', 'Consultation request deleted successfully.');
    }

    /**
     * Review consultation - add Islamic guidance
     */
    public function review(Request $request, ConsultancyApplication $consultancy)
    {
        $this->authorizeReview($consultancy);

        $data = $request->validate([
            'islamic_guidance' => 'required|string',
            'recommendation' => 'nullable|string',
            'conditions' => 'nullable|string',
            'restrictions' => 'nullable|string',
            'quran_reference' => 'nullable|string',
            'hadith_reference' => 'nullable|string',
            'scholar_reference' => 'nullable|string',
        ]);

        $user = AccessControl::user();

        $consultancy->update([
            'islamic_guidance' => $data['islamic_guidance'],
            'recommendation' => $data['recommendation'] ?? null,
            'conditions' => $data['conditions'] ?? null,
            'restrictions' => $data['restrictions'] ?? null,
            'quran_reference' => $data['quran_reference'] ?? null,
            'hadith_reference' => $data['hadith_reference'] ?? null,
            'scholar_reference' => $data['scholar_reference'] ?? null,
            'reviewed_at' => now(),
            'reviewed_by' => $user->id,
            'status' => 'reviewed',
        ]);

        // Update search index
        SearchIndex::where('module', 'consultancy')
            ->where('reference_id', $consultancy->id)
            ->update(['status' => 'reviewed']);

        return redirect()->route('consultancy.show', $consultancy->id)
            ->with('success', 'Consultation reviewed and guidance provided.');
    }

    /**
     * Approve/Sign consultation
     */
    public function sign(ConsultancyApplication $consultancy)
    {
        $this->authorizeSign($consultancy);

        $user = AccessControl::user();

        $consultancy->update([
            'signed_at' => now(),
            'signed_by' => $user->id,
            'status' => 'approved',
        ]);

        // Update search index
        SearchIndex::where('module', 'consultancy')
            ->where('reference_id', $consultancy->id)
            ->update(['status' => 'approved']);

        return redirect()->route('consultancy.show', $consultancy->id)
            ->with('success', 'Consultation approved and signed successfully.');
    }

    /**
     * Reject consultation
     */
    public function reject(ConsultancyApplication $consultancy)
    {
        $this->authorizeReview($consultancy);

        $consultancy->update([
            'status' => 'rejected',
        ]);

        // Update search index
        SearchIndex::where('module', 'consultancy')
            ->where('reference_id', $consultancy->id)
            ->update(['status' => 'rejected']);

        return redirect()->route('consultancy.show', $consultancy->id)
            ->with('warning', 'Consultation request rejected.');
    }

    /**
     * Print certificate/consultation document
     */
    public function printCertificate(ConsultancyApplication $consultancy)
    {
        $this->authorizeView($consultancy);

        $certificateNumber = $consultancy->application_id;
        $qrCode = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode(url('/consultancy/verify/' . $consultancy->id));

        return view('consultancy.certificate', compact('consultancy', 'certificateNumber', 'qrCode'));
    }

    /**
     * List all consultancy applications
     */
    public function index(Request $request)
    {
        $user = AccessControl::user();
        $role = AccessControl::role();

        $query = ConsultancyApplication::query();

        // Apply data scope
        if ($role) {
            switch ($role->data_scope) {
                case 'self':
                    $query->where('created_by', $user->id);
                    break;
                case 'county':
                    $query->where('officer_county', $user->county);
                    break;
                case 'district':
                    $query->where('officer_district', $user->district);
                    break;
                case 'region':
                    $query->where('officer_region', $user->region);
                    break;
                case 'global':
                    break;
            }
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('consultation_type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('applicant_name', 'like', "%{$search}%")
                    ->orWhere('application_id', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $applications = $query->orderByDesc('created_at')->paginate(20);

        $types = ConsultancyApplication::select('consultation_type')
            ->distinct()
            ->pluck('consultation_type');

        return view('consultancy.index', compact('applications', 'types'));
    }

    /**
     * Get consultation data for AJAX requests (used by review modal)
     */
    /**
 * Get consultation data for AJAX requests (used by view modal)
 */
public function getData(ConsultancyApplication $consultancy)
{
    $this->authorizeView($consultancy);
    
    return response()->json([
        'id' => $consultancy->id,
        'application_id' => $consultancy->application_id,
        'applicant_name' => $consultancy->applicant_name,
        'applicant_phone' => $consultancy->applicant_phone,
        'applicant_email' => $consultancy->applicant_email,
        'applicant_nin' => $consultancy->applicant_nin,
        'applicant_address' => $consultancy->applicant_address,
        'applicant_occupation' => $consultancy->applicant_occupation,
        'consultation_type' => $consultancy->consultation_type,
        'consultation_type_label' => $consultancy->consultation_type_label,
        'consultation_type_other' => $consultancy->consultation_type_other,
        'subject' => $consultancy->subject,
        'description' => $consultancy->description,
        'background_info' => $consultancy->background_info,
        'islamic_guidance' => $consultancy->islamic_guidance,
        'recommendation' => $consultancy->recommendation,
        'conditions' => $consultancy->conditions,
        'restrictions' => $consultancy->restrictions,
        'quran_reference' => $consultancy->quran_reference,
        'hadith_reference' => $consultancy->hadith_reference,
        'scholar_reference' => $consultancy->scholar_reference,
        'status' => $consultancy->status,
        'status_label' => $consultancy->status_label,
        'status_color' => $consultancy->status_color,
        'created_at' => $consultancy->created_at,
        'reviewed_at' => $consultancy->reviewed_at,
        'signed_at' => $consultancy->signed_at,
        'reviewer' => $consultancy->reviewer ? $consultancy->reviewer->full_name : null,
        'signatory' => $consultancy->signatory ? $consultancy->signatory->full_name : null,
    ]);
}

    /**
     * Update consultation status
     */
    public function updateStatus(Request $request, ConsultancyApplication $consultancy)
    {
        $this->authorizeReview($consultancy);
        
        $request->validate([
            'status' => 'required|in:submitted,under_review,reviewed,approved,rejected,accomplished'
        ]);
        
        $consultancy->update(['status' => $request->status]);

        // Update search index
        SearchIndex::where('module', 'consultancy')
            ->where('reference_id', $consultancy->id)
            ->update(['status' => $request->status]);
        
        return redirect()->route('consultancy.show', $consultancy->id)
            ->with('success', 'Status updated successfully.');
    }

    /**
     * Authorization helpers
     */
    private function authorizeView(ConsultancyApplication $application)
    {
        $user = AccessControl::user();
        $role = AccessControl::role();

        if (!$role) abort(403);

        $canView = match($role->data_scope) {
            'self' => $application->created_by == $user->id,
            'county' => $application->officer_county == $user->county,
            'district' => $application->officer_district == $user->district,
            'region' => $application->officer_region == $user->region,
            'global' => true,
            default => false,
        };

        abort_unless($canView, 403);
    }

    private function authorizeEdit(ConsultancyApplication $application)
    {
        $user = AccessControl::user();
        abort_unless($application->created_by == $user->id || AccessControl::hasFullAccess(), 403);
        abort_unless(in_array($application->status, ['submitted', 'under_review']), 403, 'This consultation cannot be edited.');
    }

    private function authorizeDelete(ConsultancyApplication $application)
    {
        $user = AccessControl::user();
        abort_unless($application->created_by == $user->id || AccessControl::hasFullAccess(), 403);
        abort_unless(in_array($application->status, ['submitted', 'under_review', 'rejected']), 403, 'This consultation cannot be deleted.');
    }

    private function authorizeReview(ConsultancyApplication $application)
    {
        abort_unless(AccessControl::hasFullAccess() || AccessControl::can('consultancy.review'), 403);
        abort_unless($application->status != 'approved', 403, 'This consultation has already been approved.');
    }

    private function authorizeSign(ConsultancyApplication $application)
    {
        abort_unless(AccessControl::hasFullAccess(), 403, 'Only the Director can sign consultations.');
        abort_unless($application->status == 'reviewed', 403, 'This consultation must be reviewed before signing.');
    }
}