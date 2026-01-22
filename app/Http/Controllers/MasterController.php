<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SearchIndex;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\DivorceApplication;
use App\Http\Controllers\Helper;
use Webpatser\Countries\Countries;
use App\Models\NikkahApplication;
use App\Models\ConvertApplication;
use App\Models\GuardianshipApplication;
use App\Models\InheritanceApplication;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MasterController extends Controller
{
    public function landingHomePage()
    {
        return view('landing.index');
    }

    public function nikahRegistration()
    {
        $countries = Cache::rememberForever('countries.list', function () {
            return Countries::select('iso_3166_2', 'name', 'calling_code')
                ->orderBy('name')
                ->get();
        });

        return view('landing.nikah', compact('countries'));
    }

    public function saveNikahApplication(Request $request)
    {
        // 1. Remove unwanted inputs
        $data = $request->except([
            '_token',
            'application_id',
            'groomPhoto',
            'bridePhoto',
        ]);

        // 2. Generate Application ID
        $datePart = Carbon::now()->format('dmy'); // 260109
        $randomPart = random_int(1000000, 9999999); // 0551164-like
        $data['application_id'] = 'NK-UMSC' . $datePart . $randomPart;

        // 3. Handle Groom Photo
        if ($request->hasFile('groomPhoto')) {
            $data['groom_photo_path'] = $request
                ->file('groomPhoto')
                ->store('nikkah/grooms', 'public');
        }

        // 4. Handle Bride Photo
        if ($request->hasFile('bridePhoto')) {
            $data['bride_photo_path'] = $request
                ->file('bridePhoto')
                ->store('nikkah/brides', 'public');
        }

        // 5. Store Application
        $application = NikkahApplication::create($data);

        // 6. Return success (adjust as needed)
        return response()->json([
            'success' => true,
            'message' => 'Nikkah application submitted successfully',
            'id' => $application->id, // ✅ ADD THIS
            'application_id' => $application->application_id,
        ]);
    }

    public function divorceApplication()
    {
        $countries = Cache::rememberForever('countries.list', function () {
            return Countries::select('iso_3166_2', 'name')
                ->orderBy('name')
                ->get();
        });

        return view('divorce.divorce-application', compact('countries'));
    }

    public function saveDivorceApplication(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(['groomPhoto', 'bridePhoto']);

            // Generate Application ID (DV-UMSC)
            $datePart = Carbon::now()->format('dmy');
            $randomPart = random_int(1000000, 9999999);
            $data['application_id'] = 'DV-UMSC' . $datePart . $randomPart;
            $data['status'] = 'submitted';

            // Store photos
            if ($request->hasFile('groomPhoto')) {
                $data['groom_photo_path'] = $request
                    ->file('groomPhoto')
                    ->store('divorce/groom_photos', 'public');
            }

            if ($request->hasFile('bridePhoto')) {
                $data['bride_photo_path'] = $request
                    ->file('bridePhoto')
                    ->store('divorce/bride_photos', 'public');
            }

            $application = DivorceApplication::create($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'application_id' => $application->application_id,
                'message' => 'Divorce application submitted successfully'
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => true,
                'application_id' => $application->application_id,
                'message' => 'Divorce Application Submitted'
            ]);
        }
    }

    public function saveUpdatedDivorceApplication(Request $request)
    {
        dd($request->all());
    }

    public function inheritanceApplication()
    {
        return view('inheritance.inheritance-application');
    }

    public function saveInheritanceApplication(Request $request)
    {
        // Ensure AJAX request
        if (!$request->ajax()) {
            abort(403);
        }

        // Validate request
        $validated = $request->validate([
            // Deceased
            'deceased_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'date_of_death' => 'required|date',
            'place_of_death' => 'required|string|max:255',
            'cause_of_death' => 'nullable|string|max:255',
            'deceased_nin' => 'required|string|max:30',
            'marital_status' => 'required|string',
            'occupation' => 'nullable|string|max:255',
            'last_residence' => 'required|string',

            // Applicant
            'applicant_name' => 'required|string|max:255',
            'relationship' => 'required|string|max:100',
            'applicant_nin' => 'required|string|max:30',
            'applicant_phone' => 'required|string|max:20',

            // Estate
            'total_estate_value' => 'required|numeric',
            'outstanding_debts' => 'nullable|numeric',
            'funeral_expenses' => 'required|numeric',
            'unpaid_zakat' => 'nullable|numeric',
            'other_liabilities' => 'nullable|numeric',

            // Properties
            'property_type.*' => 'required|string',
            'property_description.*' => 'required|string',
            'property_value.*' => 'required|numeric',
            'property_location.*' => 'nullable|string',

            // Heirs
            'sons_count' => 'required|integer|min:0',
            'daughters_count' => 'required|integer|min:0',
            'father_alive' => 'required',
            'mother_alive' => 'required',
            'full_brothers' => 'nullable|integer|min:0',
            'full_sisters' => 'nullable|integer|min:0',
            'uterine_brothers' => 'nullable|integer|min:0',
            'uterine_sisters' => 'nullable|integer|min:0',
            'pregnant_heir' => 'required',
            'minor_heirs' => 'required',

            // Verification
            'imam_name' => 'required|string|max:255',
            'imam_reg_number' => 'nullable|string|max:100',
            'mosque_name' => 'required|string|max:255',

            // Upload
            'death_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            /* ===========================
             | Upload Death Certificate
             =========================== */
            $certificatePath = $request->file('death_certificate')
                ->store('death_certificates', 'public');

            /* ===========================
             | Create Application
             =========================== */

            $applicationId = 'INH-UMSC' . Carbon::now()->format('dmy') . random_int(1000000, 9999999);

            $application = InheritanceApplication::create([
                'application_id' => $applicationId,
                'status' => 'submitted',

                'deceased_name' => $request->deceased_name,
                'gender' => $request->gender,
                'date_of_death' => $request->date_of_death,
                'place_of_death' => $request->place_of_death,
                'cause_of_death' => $request->cause_of_death,
                'deceased_nin' => $request->deceased_nin,
                'marital_status' => $request->marital_status,
                'occupation' => $request->occupation,
                'last_residence' => $request->last_residence,

                'applicant_name' => $request->applicant_name,
                'relationship' => $request->relationship,
                'applicant_nin' => $request->applicant_nin,
                'applicant_phone' => $request->applicant_phone,

                'total_estate_value' => $request->total_estate_value,
                'outstanding_debts' => $request->outstanding_debts,
                'funeral_expenses' => $request->funeral_expenses,
                'unpaid_zakat' => $request->unpaid_zakat,
                'other_liabilities' => $request->other_liabilities,

                'death_certificate_path' => $certificatePath,
            ]);

            /* ===========================
             | Save Properties
             =========================== */
            foreach ($request->property_type as $index => $type) {
                $application->properties()->create([
                    'type' => $type,
                    'description' => $request->property_description[$index],
                    'value' => $request->property_value[$index],
                    'location' => $request->property_location[$index] ?? null,
                ]);
            }

            /* ===========================
             | Save Heirs
             =========================== */
            $application->heirs()->create([
                'spouse_name' => $request->spouse_name,
                'spouse_nin' => $request->spouse_nin,
                'sons_count' => $request->sons_count,
                'daughters_count' => $request->daughters_count,
                'father_alive' => $request->father_alive,
                'father_name' => $request->father_name,
                'mother_alive' => $request->mother_alive,
                'mother_name' => $request->mother_name,
                'full_brothers' => $request->full_brothers ?? 0,
                'full_sisters' => $request->full_sisters ?? 0,
                'uterine_brothers' => $request->uterine_brothers ?? 0,
                'uterine_sisters' => $request->uterine_sisters ?? 0,
                'pregnant_heir' => $request->pregnant_heir,
                'minor_heirs' => $request->minor_heirs,
            ]);

            /* ===========================
             | Save Verification
             =========================== */
            $application->verification()->create([
                'imam_name' => $request->imam_name,
                'imam_reg_number' => $request->imam_reg_number,
                'mosque_name' => $request->mosque_name,
                'verification_date' => now(),
            ]);

            DB::commit();

            /* ===========================
             | AJAX SUCCESS RESPONSE
             =========================== */
            return response()->json([
                'success' => true,
                'reference' => $application->application_id,
                'redirect_url' => route('inheritance.dashboard'),
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to submit application',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function guardianshipApplication()
    {
        return view('guardianship.guardianship-application');
    }

    public function saveguardianshipApplication(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            // Ward Details
            'ward_name' => 'required|string|max:255',
            'ward_gender' => 'required|in:male,female',
            'ward_dob' => 'required|date',
            'ward_age' => 'required|integer|min:0',
            'birth_certificate_number' => 'nullable|string|max:255',
            'ward_type' => 'required|in:orphan,abandoned,special_needs,normal',
            'guardianship_type' => 'required|in:minor,incapacitated,testamentary,emergency',
            'health_conditions' => 'nullable|string',
            'ward_education_level' => 'nullable|in:none,nursery,primary,secondary,vocational,university',
            'ward_photo' => 'required|image|max:2048',

            // Parental Information
            'father_name' => 'required|string|max:255',
            'father_status' => 'required|in:alive,deceased,unknown,incapacitated',
            'mother_name' => 'nullable|string|max:255',
            'mother_status' => 'required|in:alive,deceased,unknown,incapacitated',
            'birth_certificate' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // Guardian Applicant Details
            'guardian_name' => 'required|string|max:255',
            'guardian_gender' => 'nullable|in:male,female',
            'guardian_dob' => 'required|date',
            'guardian_nin' => 'required|string|max:255',
            'relationship_to_ward' => 'required|in:father,mother,relative,other',
            'guardian_phone' => 'required|string|max:20',
            'guardian_address' => 'required|string',
            'previous_experience' => 'nullable|string',
            'criminal_record' => 'required|in:yes,no',
            'health_status' => 'nullable|string|max:255',
            'religious_background' => 'nullable|string',
            'motivation' => 'required|string',
            'guardian_photo' => 'required|image|max:2048',

            // Guardianship Terms
            'guardianship_duration' => 'required|in:until_majority,specific_period,indefinite',
            'reporting_frequency' => 'nullable|in:monthly,quarterly,annually,none',
            'powers_granted' => 'nullable|array',
            'restrictions' => 'nullable|string',

            // Verification
            'imam_name' => 'nullable|string|max:255',
            'imam_reg_number' => 'nullable|string|max:255',
            'mosque_name' => 'nullable|string|max:255',

            // Witnesses
            'witness1_name' => 'nullable|string|max:255',
            'witness1_nin' => 'nullable|string|max:255',
            'witness2_name' => 'nullable|string|max:255',
            'witness2_nin' => 'nullable|string|max:255',
        ]);

        // Handle file uploads
        $wardPhotoPath = null;
        $birthCertificatePath = null;
        $guardianPhotoPath = null;

        if ($request->hasFile('ward_photo')) {
            $wardPhotoPath = $request->file('ward_photo')->store('guardianship/ward_photos', 'public');
        }

        if ($request->hasFile('birth_certificate')) {
            $birthCertificatePath = $request->file('birth_certificate')->store('guardianship/birth_certificates', 'public');
        }

        if ($request->hasFile('guardian_photo')) {
            $guardianPhotoPath = $request->file('guardian_photo')->store('guardianship/guardian_photos', 'public');
        }

        $applicationId = 'GUI-UMSC' . Carbon::now()->format('dmy') . random_int(1000000, 9999999);
        // Prepare data for database
        $applicationData = [
            // Ward Details
            'application_id' => $applicationId,
            'ward_name' => $validated['ward_name'],
            'ward_gender' => $validated['ward_gender'],
            'ward_dob' => $validated['ward_dob'],
            'ward_age' => $validated['ward_age'],
            'birth_certificate_number' => $validated['birth_certificate_number'] ?? null,
            'ward_type' => $validated['ward_type'],
            'guardianship_type' => $validated['guardianship_type'],
            'health_conditions' => $validated['health_conditions'] ?? null,
            'ward_education_level' => $validated['ward_education_level'] ?? null,
            'ward_photo_path' => $wardPhotoPath,

            // Parental Information
            'father_name' => $validated['father_name'],
            'father_status' => $validated['father_status'],
            'mother_name' => $validated['mother_name'] ?? null,
            'mother_status' => $validated['mother_status'],
            'birth_certificate_path' => $birthCertificatePath,

            // Guardian Applicant Details
            'guardian_name' => $validated['guardian_name'],
            'guardian_gender' => $validated['guardian_gender'] ?? null,
            'guardian_dob' => $validated['guardian_dob'],
            'guardian_nin' => $validated['guardian_nin'],
            'relationship_to_ward' => $validated['relationship_to_ward'],
            'guardian_phone' => $validated['guardian_phone'],
            'guardian_address' => $validated['guardian_address'],
            'previous_experience' => $validated['previous_experience'] ?? null,
            'criminal_record' => $validated['criminal_record'],
            'health_status' => $validated['health_status'] ?? null,
            'religious_background' => $validated['religious_background'] ?? null,
            'motivation' => $validated['motivation'],
            'guardian_photo_path' => $guardianPhotoPath,

            // Guardianship Terms
            'guardianship_duration' => $validated['guardianship_duration'],
            'reporting_frequency' => $validated['reporting_frequency'] ?? null,
            'powers_granted' => $validated['powers_granted'] ?? null,
            'restrictions' => $validated['restrictions'] ?? null,

            // Verification
            'imam_name' => $validated['imam_name'] ?? null,
            'imam_reg_number' => $validated['imam_reg_number'] ?? null,
            'mosque_name' => $validated['mosque_name'] ?? null,

            // Witnesses
            'witness1_name' => $validated['witness1_name'] ?? null,
            'witness1_nin' => $validated['witness1_nin'] ?? null,
            'witness2_name' => $validated['witness2_name'] ?? null,
            'witness2_nin' => $validated['witness2_nin'] ?? null,

            // Status
            'status' => 'pending',
        ];

        // Save to database
        try {
            $application = GuardianshipApplication::create($applicationData);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully!',
                'data' => $application,
                'redirect_url' => route('guardianship.dashboard'),
                'application_id' => $application->application_id,
            ]);

        } catch (\Exception $e) {
            // Rollback file uploads if database save fails
            if ($wardPhotoPath)
                Storage::disk('public')->delete($wardPhotoPath);
            if ($birthCertificatePath)
                Storage::disk('public')->delete($birthCertificatePath);
            if ($guardianPhotoPath)
                Storage::disk('public')->delete($guardianPhotoPath);

            return response()->json([
                'success' => false,
                'message' => 'Failed to save application: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function guardianshipDashboard()
    {
        // Fetch stats globally across all records
        $stats = [
            'total' => GuardianshipApplication::count(),
            'pending' => GuardianshipApplication::where('status', 'submitted')->count(),
            'approved' => GuardianshipApplication::where('status', 'accomplished')->count(),
            'rejected' => GuardianshipApplication::where('status', 'rejected')->count(),
        ];

        $applications = GuardianshipApplication::orderBy('created_at', 'desc')->paginate(10);

        return view('guardianship.guardianship-dashboard', compact('applications', 'stats'));
    }

    public function convertApplication()
    {
        return view('converts.convert-application');
    }

    public function saveConvertApplication(Request $request)
    {
        $data = $request->all();

        // Handle file uploads
        $fileFields = ['signature', 'officer_signature', 'official_stamp'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/convert_applications', $filename);
                $data[$field] = 'convert_applications/' . $filename;
            }
        }

        // Generate unique application_id
        $applicationId = 'CV-UMSC' . Carbon::now()->format('dmy') . random_int(1000000, 9999999);
        $data['application_id'] = $applicationId;

        // Convert checkbox to boolean
        $data['declaration_agreement'] = $request->has('declaration_agreement');

        // Save
        $application = ConvertApplication::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Conversion application submitted successfully',
            'id' => $application->id,
            'redirect_url' => route('convert.dashboard'),
            'application_id' => $application->application_id,
        ]);
    }

    public function divorceDashboard()
    {
        $all = DivorceApplication::all()->count();
        $pending = DivorceApplication::where('status', 'pending')->count();
        $Rejected = DivorceApplication::where('status', 'rejected')->count();
        $Finalised = DivorceApplication::where('status', 'accomplished')->count();

        return view('divorce.divorce-dashboard', compact(['all', 'pending', 'Rejected', 'Finalised']));
    }

    public function inheritanceDashboard()
    {

        $all = InheritanceApplication::all()->count();
        $pending = InheritanceApplication::where('status', 'submitted')->count();
        $Rejected = InheritanceApplication::where('status', 'rejected')->count();
        $Finalised = InheritanceApplication::where('status', 'accomplished')->count();

        $applications = InheritanceApplication::latest()->paginate(5);

        return view('inheritance.inheritance-dashboard', compact(['all', 'pending', 'Rejected', 'Finalised', 'applications']));
    }

    public function nikahDashboard()
    {
        // Existing stats
        $totalNikah = NikkahApplication::count();
        $submittedNikah = NikkahApplication::where('status', 'submitted')->count();
        $approvedNikah = NikkahApplication::where('status', 'approved')->count();
        $rejectedNikah = NikkahApplication::where('status', 'rejected')->count();

        // Nikah management card
        $pendingNikah = $submittedNikah;

        $thisMonthNikah = NikkahApplication::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Recent registrations (latest 5)
        $recentNikah = NikkahApplication::latest()->take(5)->get();

        return view('nikah.nikah-dashboard', compact(
            'totalNikah',
            'submittedNikah',
            'approvedNikah',
            'rejectedNikah',
            'pendingNikah',
            'thisMonthNikah',
            'recentNikah'
        ));
    }

    public function nikahApplications()
    {
        $applications = NikkahApplication::latest()->paginate(10);

        return view('nikah.all-applications', compact('applications'));
    }

    public function shownikahApplicationInformation($id)
    {
        $application = NikkahApplication::findOrFail($id);

        return response()->json($application);
    }

    public function editNikahApplication($id)
    {
        $application = NikkahApplication::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $application
        ]);
    }

    public function updateNikahApplication(Request $request, $id)
    {
        $application = NikkahApplication::findOrFail($id);

        $data = $request->except([
            '_token',
            'groomPhoto',
            'bridePhoto',
        ]);


        if ($request->hasFile('groomPhoto')) {

            if (
                $application->groom_photo_path &&
                Storage::disk('public')->exists($application->groom_photo_path)
            ) {

                Storage::disk('public')->delete($application->groom_photo_path);
            }

            $data['groom_photo_path'] = $request
                ->file('groomPhoto')
                ->store('nikkah/grooms', 'public');
        }

        if ($request->hasFile('bridePhoto')) {

            if (
                $application->bride_photo_path &&
                Storage::disk('public')->exists($application->bride_photo_path)
            ) {

                Storage::disk('public')->delete($application->bride_photo_path);
            }

            $data['bride_photo_path'] = $request
                ->file('bridePhoto')
                ->store('nikkah/brides', 'public');
        }

        $application->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Application updated successfully'
        ]);
    }

    public function deleteNikahApplication($id)
    {
        $application = NikkahApplication::findOrFail($id);

        if ($application->groom_photo_path && Storage::disk('public')->exists($application->groom_photo_path)) {
            Storage::disk('public')->delete($application->groom_photo_path);
        }

        if ($application->bride_photo_path && Storage::disk('public')->exists($application->bride_photo_path)) {
            Storage::disk('public')->delete($application->bride_photo_path);
        }

        $application->delete();

        return response()->json([
            'success' => true,
            'message' => 'Application and photos deleted successfully'
        ]);
    }

    public function nikahStatusApplications($statusId)
    {
        if ($statusId == 0) {

            $applications = NikkahApplication::where('status', 'submitted')->paginate(10);
            return view('nikah.status-applications', compact('applications', 'statusId'));

        } elseif ($statusId == 10) {

            $applications = NikkahApplication::where('status', 'approved')->paginate(10);
            return view('nikah.status-applications', compact('applications', 'statusId'));

        } elseif ($statusId == -10) {

            $applications = NikkahApplication::where('status', 'rejected')->paginate(10);
            return view('nikah.status-applications', compact('applications', 'statusId'));

        } elseif ($statusId == 100) {

            $applications = NikkahApplication::orderBy('created_at', 'desc')->paginate(10);
            return view('nikah.status-applications', compact('applications', 'statusId'));
        }
    }

    public function updateNikkahApplicationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $application = NikkahApplication::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return response()->json(['success' => true, 'status' => $application->status]);
    }

    public function divorceStatusApplications($statusId)
    {
        if ($statusId == 0) {
            $applications = DivorceApplication::where('status', 'pending')->paginate(10);
            return view('divorce.status-applications', compact('applications', 'statusId'));
        } elseif ($statusId == 10) {
            $applications = DivorceApplication::where('status', 'accomplished')->paginate(10);
            return view('divorce.status-applications', compact('applications', 'statusId'));
        } elseif ($statusId == -10) {
            $applications = DivorceApplication::where('status', 'rejected')->paginate(10);
            return view('divorce.status-applications', compact('applications', 'statusId'));
        } elseif ($statusId == 100) {
            $applications = DivorceApplication::orderBy('created_at', 'desc')->paginate(10);
            return view('divorce.status-applications', compact('applications', 'statusId'));
        }
    }

    public function inheritanceStatusApplications($statusId)
    {

        if ($statusId == 0) {
            $applications = InheritanceApplication::where('status', 'submitted')->paginate(10);
            return view('inheritance.status-applications', compact('applications', 'statusId'));
        } elseif ($statusId == 10) {

            $applications = InheritanceApplication::where('status', 'accomplished')->paginate(10);
            return view('inheritance.status-applications', compact('applications', 'statusId'));
        } elseif ($statusId == -10) {

            $applications = InheritanceApplication::where('status', 'rejected')->paginate(10);
            return view('inheritance.status-applications', compact('applications', 'statusId'));
        } elseif ($statusId == 100) {

            $applications = InheritanceApplication::orderBy('created_at', 'desc')->paginate(10);
            return view('inheritance.status-applications', compact('applications', 'statusId'));
        }
    }

    public function guardianshipStatusApplications($statusId)
    {
        if ($statusId == 0) {

            $applications = GuardianshipApplication::where('status', 'submitted')->paginate(10);
            return view('guardianship.status-applications', compact('applications', 'statusId'));
        } elseif ($statusId == 10) {

            $applications = GuardianshipApplication::where('status', 'accomplished')->paginate(10);
            return view('guardianship.status-applications', compact('applications', 'statusId'));
        } elseif ($statusId == -10) {

            $applications = GuardianshipApplication::where('status', 'rejected')->paginate(10);
            return view('guardianship.status-applications', compact('applications', 'statusId'));
        } elseif ($statusId == 100) {

            $applications = GuardianshipApplication::orderBy('created_at', 'desc')->paginate(10);
            return view('guardianship.status-applications', compact('applications', 'statusId'));
        }
    }


    public function convertDashboard()
    {

        $currentMonth = now()->month;
        $currentYear = now()->year;

        $total_converts = ConvertApplication::count();

        $this_month = ConvertApplication::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $pending = ConvertApplication::where('status', 'pending')->count();
        $accomplished = ConvertApplication::where('status', 'accomplished')->count();

        $sources = ConvertApplication::distinct('former_religion')->count();
        $applications = ConvertApplication::latest()->paginate(10);

        $religions = ConvertApplication::select('former_religion')
            ->get()
            ->groupBy('former_religion')
            ->map(function ($group) use ($total_converts) {
                return round(($group->count() / max($total_converts, 1)) * 100);
            });

        $stats = [
            'total_converts' => $total_converts,
            'this_month' => $this_month,
            'pending' => $pending,
            'sources' => $sources,
            'religions' => $religions,
        ];

        return view('converts.convert-dashboard', compact('stats', 'applications', 'accomplished'));
    }

    public function convertStatusApplications($statusId)
    {

        if ($statusId == 0) {
            $applications = ConvertApplication::where('status', 'pending')->paginate(10);
            return view('converts.status-applications', compact('applications', 'statusId'));
        } elseif ($statusId == 10) {

            $applications = ConvertApplication::where('status', 'accomplished')->paginate(10);
            return view('converts.status-applications', compact('applications', 'statusId'));
        } elseif ($statusId == -10) {

            $applications = ConvertApplication::where('status', 'rejected')->paginate(10);
            return view('converts.status-applications', compact('applications', 'statusId'));
        } elseif ($statusId == 100) {

            $applications = ConvertApplication::orderBy('created_at', 'desc')->paginate(10);
            return view('converts.status-applications', compact('applications', 'statusId'));
        }
    }

    // No internet

    public function editDivorceApplication($id)
    {
        $application = DivorceApplication::findOrFail($id);
        return view('divorce.edit-application', compact('application'));
    }


    public function viewDivorceApplication($id)
    {

        $application = DivorceApplication::findOrFail($id);

        return view('divorce.view-application', compact('application'));
    }


    public function deleteDivorceApplication($id)
    {

        $application = DivorceApplication::findOrFail($id);
        $application_id = $application->application_id;

        $application->delete();

        return response()->json([
            'success' => true,
            'message' => 'Divorce application Deleted successfully',
            'application_id' => $application_id,
        ]);
    }

    public function showdivorceApplicationInformation($id)
    {
        $application = DivorceApplication::findOrFail($id);

        return response()->json($application);
    }


    public function usersDashboard()
    {
        // Define the status messages as an array
        $statusMessages = [
            0 => 'Your account has been banned.',
            8 => 'Your account is locked.',
            9 => 'Your account is suspended.',
        ];

        // Get stats for each user role
        $roles = [
            'Imaam' => 1,
            'District Qadh' => 2,
            'Directorate Sharia' => 3
        ];

        $roleStats = [];

        foreach ($roles as $roleName => $roleId) {
            // Total users for this role
            $totalUsers = User::where('user_role', $roleId)->count();

            $activeUsers = User::where('user_role', $roleId)
                ->where('account_status', 10)
                ->count();

            // Pending users for this role (assuming status 0 means pending)
            $pendingUsers = User::where('user_role', $roleId)
                ->whereIn('account_status', [1, 0, 8, 9]) // Pending status (banned, locked, suspended)
                ->count();

            $suspended = User::where('user_role', $roleId)
                ->where('account_status', 9) // Pending status (banned, locked, suspended)
                ->count();

            $roleStats[] = [
                'title' => $roleName,
                'icon' => Helper::getIconForRole($roleId),
                'color' => '#00580f',
                'bg' => '#F0FDF0',
                'stats' => [
                    'users' => $totalUsers,
                    'active' => $activeUsers,
                    'pending' => $pendingUsers,
                    'suspended' => $suspended,
                ]
            ];
        }

        $users = User::latest()->paginate(7);

        return view('admin.user-dashboard', compact('roleStats', 'statusMessages', 'users', 'suspended'));
    }


    public function addUsers()
    {
        return view('admin.add-users');
    }


    public function manageUsers()
    {
        $users = User::latest()->paginate(10);

        return view('admin.manage-users', compact(['users']));
    }


    public function saveNewUser(Request $request)
    {

        $data = $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'firstname' => 'nullable|string',
            'lastname' => 'nullable|string',
            'gender' => 'nullable|in:male,female,other',
            'phonenumber' => 'nullable|string',
            'country' => 'nullable|string',
            'profile_photo' => 'nullable|image|max:2048',
            'user_role' => 'required|integer',
            'account_status' => 'required|integer',
            'registration_status' => 'required|integer',
        ]);

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully!'
        ]);
    }

    public function smartSearch(Request $request)
    {
        $adminId = Session::get('LoggedAdmin');

        if (!$adminId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // 2️⃣ Get admin
        $admin = DB::table('users')->where('id', $adminId)->first();

        // 3️⃣ Build query
        $query = SearchIndex::query();

        // Category filter
        if ($request->filled('scope')) {
            $query->where('module', $request->scope);
        }

        // Keyword search
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('application_id', 'like', "%$keyword%")
                    ->orWhere('keywords', 'like', "%$keyword%")
                    ->orWhere('title', 'like', "%$keyword%");
            });
        }

        // Date filters
        if ($request->filled('date_from')) {
            $query->whereDate('application_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('application_date', '<=', $request->date_to);
        }

        // 4️⃣ Role-based filtering
        $query->where(function ($q) use ($admin) {
            $q->whereNull('required_role')
                ->orWhere('required_role', '<=', $admin->user_role);
        });

        // 5️⃣ Execute
        $results = $query
            ->orderByDesc('application_date')
            ->limit(50)
            ->get();

        return response()->json($results);
    }

    public function viewNikahRecords($id)
    {
        $adminId = Session::get('LoggedAdmin');

        if (!$adminId) {
            abort(401);
        }

        $admin = DB::table('users')->where('id', $adminId)->first();

        $application = NikkahApplication::findOrFail($id);

        // if ($admin->user_role < 1) {
        //     abort(403);
        // }

        Helper::auditTrail('view', 'NikkahApplication', $application->id, 'success', null, null, 'Viewed Nikah application ' . $application->application_id);

        return view('nikah.view', compact('application'));
    }

    public function view($id)
    {
        $adminId = Session::get('LoggedAdmin');

        if (!$adminId){
            abort(401);
        }

        $admin = DB::table('users')->where('id', $adminId)->first();

        $application = DivorceApplication::findOrFail($id);

        // Example: District Qadh & above
        if ($admin->user_role < 2) {
            abort(403);
        }

        Helper::auditTrail(
            'view',
            'DivorceApplication',
            $application->id,
            'success',
            null,
            null,
            'Viewed Divorce case ' . $application->application_id
        );

        return view('divorce.view', compact('application'));
    }
}
