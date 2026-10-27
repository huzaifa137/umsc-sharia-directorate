<?php

namespace App\Http\Controllers;

use App\Models\ConvertApplication;
use App\Models\DivorceApplication;
use App\Models\GuardianshipApplication;
use App\Models\InheritanceApplication;
use App\Models\NikkahApplication;
use App\Services\AccessControl;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * One entry per certificate type. This is the single source of truth for
     * which model backs it, which Blade view renders it, what a "ready to
     * certify" record looks like for that module, and which fields are safe
     * for the Director to touch from the quick-edit modal before printing.
     *
     * `completed_status` is a list, not a single value — the status
     * vocabulary is NOT consistent across modules (Nikah uses "approved",
     * most others use "accomplished"), and Guardianship specifically has an
     * extra intermediate "active" status (an ongoing, not-yet-concluded
     * guardianship) that's also certificate-eligible, alongside
     * "accomplished" (a concluded one).
     */
    private const MODULES = [
        'nikah' => [
            'model' => NikkahApplication::class,
            'view' => 'certificates.nikah',
            'label' => 'Nikah (Marriage)',
            'completed_status' => ['approved'],
            'name_fields' => ['groom_given_name', 'groom_surname', 'bride_given_name', 'bride_surname'],
            'name_format' => '%s %s & %s %s',
            'editable_fields' => ['imam_name', 'masjid_name'],
        ],
        'divorce' => [
            'model' => DivorceApplication::class,
            'view' => 'certificates.divorce',
            'label' => 'Divorce',
            'completed_status' => ['accomplished'],
            'name_fields' => ['groom_given_name', 'groom_surname', 'bride_given_name', 'bride_surname'],
            'name_format' => '%s %s & %s %s',
            'editable_fields' => ['imam_name', 'divorce_place'],
        ],
        'inheritance' => [
            'model' => InheritanceApplication::class,
            'view' => 'certificates.inheritance',
            'label' => 'Inheritance',
            'completed_status' => ['accomplished'],
            'name_fields' => ['deceased_name', 'applicant_name'],
            'name_format' => 'Estate of %s (applicant: %s)',
            'editable_fields' => ['place_of_death'],
        ],
        'guardianship' => [
            'model' => GuardianshipApplication::class,
            'view' => 'certificates.guardianship',
            'label' => 'Guardianship',
            'completed_status' => ['active', 'accomplished'],
            'name_fields' => ['ward_name', 'guardian_name'],
            'name_format' => '%s (guardian: %s)',
            'editable_fields' => ['imam_name', 'mosque_name'],
        ],
        'convert' => [
            'model' => ConvertApplication::class,
            'view' => 'certificates.convert',
            'label' => 'Convert to Islam',
            'completed_status' => ['accomplished'],
            'name_fields' => ['former_names', 'new_names'],
            'name_format' => '%s (now %s)',
            'editable_fields' => ['conversion_place', 'officer_name'],
        ],
    ];

    private function guard()
    {
        abort_unless(AccessControl::can('certificates.view'), 403, 'This module is restricted to the Director for Sharia.');
    }

    private function moduleOrFail(string $type): array
    {
        abort_unless(isset(self::MODULES[$type]), 404, 'Unknown certificate type.');

        return self::MODULES[$type];
    }

    /**
     * Filter form + results (results only render once at least a type has
     * been chosen). One GET request, one page — shareable/bookmarkable URL,
     * and printable directly from the browser like the rest of the admin panel.
     */
    public function index(Request $request)
    {
        $this->guard();

        $modules = collect(self::MODULES)->map(fn ($m, $slug) => ['slug' => $slug, 'label' => $m['label']])->values();

        $results = null;
        $selectedType = $request->query('type');

        if ($selectedType && isset(self::MODULES[$selectedType])) {
            $results = $this->runSearch($selectedType, $request);
        }

        return view('admin.certificates', [
            'modules' => $modules,
            'selectedType' => $selectedType,
            'filters' => $request->query(),
            'results' => $results,
            'editableFields' => $selectedType ? (self::MODULES[$selectedType]['editable_fields'] ?? []) : [],
        ]);
    }

    private function runSearch(string $type, Request $request)
    {
        $module = self::MODULES[$type];
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = $module['model']::query()->whereIn('status', $module['completed_status']);

        if ($request->filled('year')) {
            $query->whereYear('created_at', (int) $request->query('year'));
        }
        if ($request->filled('month')) {
            $query->whereMonth('created_at', (int) $request->query('month'));
        }
        if ($request->filled('day')) {
            $query->whereDay('created_at', (int) $request->query('day'));
        }
        if ($request->filled('region')) {
            $query->where('officer_region', 'like', '%' . $request->query('region') . '%');
        }
        if ($request->filled('district')) {
            $query->where('officer_district', 'like', '%' . $request->query('district') . '%');
        }
        if ($request->filled('county')) {
            $query->where('officer_county', 'like', '%' . $request->query('county') . '%');
        }

        return $query->orderByDesc('created_at')->paginate(25)->withQueryString();
    }

    /**
     * Render one certificate for preview or single-record printing —
     * exactly the same template used for bulk printing, so what the
     * Director previews is pixel-identical to what gets printed.
     *
     * Also supplies $certificateNumber and $qrCode to every certificate
     * view (not just ones that use them) so any template — including
     * ones built independently of this controller — can rely on them
     * being present without needing a per-template special case here.
     * No server-side QR package is installed in this project, so $qrCode
     * is a URL to a free QR-image API rather than a locally generated
     * data URI; that's a reasonable default but swap it for a proper
     * package (e.g. simplesoftwareio/simple-qrcode) if offline rendering
     * ever matters.
     */
    public function preview(string $type, int $id)
    {
        $this->guard();
        $module = $this->moduleOrFail($type);

        $application = $module['model']::findOrFail($id);

        $certificateNumber = $application->application_id
            ?? ('UMSC-' . strtoupper($type) . '-' . $application->id);

        $verifyUrl = url('/certificates/verify/' . $type . '/' . $application->id);
        $qrCode = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($verifyUrl);

        return view($module['view'], compact('application', 'certificateNumber', 'qrCode'));
    }

    /**
     * Quick-edit a small whitelist of certificate-relevant fields (e.g. the
     * officiating Imam's name, or the venue) directly from the Director's
     * certificates dashboard, without sending them into the full
     * module-specific edit workflow.
     */
    public function updateField(Request $request, string $type, int $id)
    {
        $this->guard();
        $module = $this->moduleOrFail($type);

        $field = $request->input('field');
        abort_unless(in_array($field, $module['editable_fields'], true), 422, 'That field is not editable from here.');

        $value = $request->input('value', '');
        $application = $module['model']::findOrFail($id);
        $application->{$field} = $value;
        $application->save();

        return response()->json(['status' => 'ok', 'field' => $field, 'value' => $value]);
    }

    /**
     * The bulk-print landing page: takes a type + list of ids from the
     * certificates dashboard, and loads each certificate in a hidden iframe
     * client-side (same technique as the exam certificate bulk download)
     * to merge them into one PDF for a single "print all selected" action.
     */
    public function bulkPrint(Request $request)
    {
        $this->guard();

        $type = $request->query('type');
        $module = $this->moduleOrFail($type);

        $ids = array_filter(array_map('intval', explode(',', (string) $request->query('ids', ''))));
        abort_if(empty($ids), 422, 'No certificates were selected.');

        $applications = $module['model']::whereIn('id', $ids)->get();

        return view('admin.certificates-bulk-print', [
            'type' => $type,
            'label' => $module['label'],
            'applications' => $applications,
        ]);
    }
}