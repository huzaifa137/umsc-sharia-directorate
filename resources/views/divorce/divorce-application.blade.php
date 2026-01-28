@include('layouts.form-headers')

<script>
    const translations = {
        en: {
            application_id_label: "Application ID:",
            back_to_dashboard: "Back to Dashboard",
            husband_personal_details: "Husband's Personal Details",
            current_step_subtitle: "Step 1 of 4: Primary Identification",
            current_step_title: "Husband's Personal Details",
            complete_all_sections: "Complete all 8 sections in order",
            progress: "Progress",
            completed_steps: "0 of 8 sections completed",
            step_1_title: "Husband's Personal Details",
            step_2_title: "Husband's Residential Address",
            step_3_title: "Wife's Personal Details",
            step_4_title: "Wife's Residential Address",
            step_5_title: "Divorce Details",
            step_6_title: "Witnesses & Authority",
            step_7_title: "Children & Iddah",
            step_8_title: "Passport Photographs",
            instructions_title: "Instructions",
            instruction_step_1: "Complete each step in order",
            instruction_step_2: "All required fields must be filled",
            instruction_step_3: "Review your information before submitting",
            instruction_step_4: "You can't skip ahead until current step is complete",
            divorce_application_title: "Divorce Application",
            previous_button: "Previous",
            next_step_button: "Next Step",
            submit_application_button: "Submit Application"
        },
        ar: {
            application_id_label: "رقم الطلب:",
            back_to_dashboard: "العودة إلى لوحة التحكم",
            husband_personal_details: "البيانات الشخصية للزوج",
            current_step_subtitle: "الخطوة 1 من 4: التعريف الأساسي",
            current_step_title: "البيانات الشخصية للزوج",
            complete_all_sections: "أكمل جميع الأقسام الثمانية بالترتيب",
            progress: "التقدم",
            completed_steps: "0 من 8 أقسام مكتملة",
            step_1_title: "البيانات الشخصية للزوج",
            step_2_title: "عنوان سكن الزوج",
            step_3_title: "البيانات الشخصية للزوجة",
            step_4_title: "عنوان سكن الزوجة",
            step_5_title: "تفاصيل الطلاق",
            step_6_title: "الشهود والسلطة",
            step_7_title: "الأطفال والعِدة",
            step_8_title: "صور جواز السفر",
            instructions_title: "تعليمات",
            instruction_step_1: "أكمل كل خطوة بالترتيب",
            instruction_step_2: "يجب ملء جميع الحقول المطلوبة",
            instruction_step_3: "راجع معلوماتك قبل الإرسال",
            instruction_step_4: "لا يمكنك الانتقال إلى الأمام حتى تكتمل الخطوة الحالية",
            divorce_application_title: "طلب الطلاق",
            previous_button: "السابق",
            next_step_button: "الخطوة التالية",
            submit_application_button: "إرسال الطلب"
        },
        sw: {
            application_id_label: "Nambari ya Ombi:",
            back_to_dashboard: "Rudi kwenye Dashibodi",
            husband_personal_details: "Taarifa Binafsi za Mume",
            current_step_subtitle: "Hatua ya 1 kati ya 4: Utambulisho wa Msingi",
            current_step_title: "Taarifa Binafsi za Mume",
            complete_all_sections: "Kamilisha sehemu zote 8 kwa mpangilio",
            progress: "Maendeleo",
            completed_steps: "Sehemu 0 kati ya 8 zimekamilika",
            step_1_title: "Taarifa Binafsi za Mume",
            step_2_title: "Anwani ya Makazi ya Mume",
            step_3_title: "Taarifa Binafsi za Mke",
            step_4_title: "Anwani ya Makazi ya Mke",
            step_5_title: "Maelezo ya Talaka",
            step_6_title: "Mashahidi & Mamlaka",
            step_7_title: "Watoto & Iddah",
            step_8_title: "Picha za Pasipoti",
            instructions_title: "Maelekezo",
            instruction_step_1: "Kamilisha kila hatua kwa mpangilio",
            instruction_step_2: "Shughuli zote zinazohitajika lazima zizilishwe",
            instruction_step_3: "Angalia taarifa zako kabla ya kuwasilisha",
            instruction_step_4: "Huwezi kuruka mbele hadi hatua ya sasa ikamilike",
            divorce_application_title: "Ombi la Talaka",
            previous_button: "Iliyotangulia",
            next_step_button: "Hatua Inayofuata",
            submit_application_button: "Wasilisha Ombi"
        }
    };
</script>

<div style="display: flex; min-height: 100vh; font-family: sans-serif;">
    <!-- Left Side: Step Navigation -->
    <div style="flex: 0.4; background: #f8fafc; padding: 40px; overflow-y: auto; border-right: 1px solid #e2e8f0;">
        <div style="position: sticky; top: 0; background: #f8fafc; padding-bottom: 20px; z-index: 10;">
            <h1 data-i18n="divorce_application_title" style="color: #21532B; margin-bottom: 5px;">
                Divorce Application
            </h1>

            <p data-i18n="complete_all_sections" style="color: #64748b; font-size: 14px; margin-bottom: 30px;">
                Complete all 8 sections in order
            </p>

            <!-- Progress Tracker -->
            <div
                style="margin-bottom: 40px; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span data-i18n="progress" style="font-size: 14px; color: #64748b; font-weight: 600;">
                        Progress
                    </span>

                    <span id="progressPercentage" style="font-size: 16px; color: #21532B; font-weight: bold;">0%</span>
                </div>
                <div style="height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                    <div id="progressBar"
                        style="height: 100%; background: #21532B; width: 0%; transition: width 0.5s ease;"></div>
                </div>
                <p id="completedSteps" data-i18n="completed_steps"
                    style="font-size: 13px; color: #64748b; margin-top: 10px; text-align: center;">
                    0 of 8 sections completed
                </p>

            </div>

            <!-- Step Indicators -->
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @php
                    $stepTitles = [
                        1 => 'Husband\'s Personal Details',
                        2 => 'Husband\'s Residential Address',
                        3 => 'Wife\'s Personal Details',
                        4 => 'Wife\'s Residential Address',
                        5 => 'Divorce Details',
                        6 => 'Witnesses & Authority',
                        7 => 'Children & Iddah',
                        8 => 'Passport Photographs',
                    ];
                @endphp

                @for ($i = 1; $i <= 8; $i++)
                    <div class="step-indicator {{ $i === 1 ? 'active' : '' }} {{ $i > 1 ? 'locked' : '' }}"
                        data-step="{{ $i }}" id="stepIndicator{{ $i }}"
                        style="display: flex; align-items: center; gap: 15px; padding: 18px; background: white; border: 2px solid #e2e8f0; border-radius: 10px; cursor: pointer; transition: all 0.3s ease; position: relative;">

                        <!-- Step Number -->
                        <div class="step-number"
                            style="width: 36px; height: 36px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #64748b; font-size: 14px; flex-shrink: 0;">
                            {{ $i }}
                        </div>

                        <!-- Step Info -->
                        <div style="flex: 1;">
                            <div style="font-size: 15px; font-weight: 600; color: #64748b;">Step {{ $i }}
                            </div>
                            <div style="font-size: 13px; color: #94a3b8; margin-top: 3px;" data-i18n="step_{{ $i }}_title">
                                {{ $stepTitles[$i] }}
                            </div>
                        </div>

                        <!-- Status Icon -->
                        <div class="step-status" style="width: 24px; height: 24px; flex-shrink: 0;">
                            @if ($i === 1)
                                <svg style="color: #21532B; width: 100%; height: 100%;" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 8v4l3 3"></path>
                                </svg>
                            @else
                                <svg style="color: #cbd5e1; width: 100%; height: 100%;" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M19 4.5L5 19.5"></path>
                                </svg>
                            @endif
                        </div>
                    </div>
                @endfor
            </div>


            <!-- Instructions -->
            <div
                style="margin-top: 40px; background: #f0f9ff; padding: 20px; border-radius: 10px; border-left: 4px solid #3D6946;">

                <h4 data-i18n="instructions_title" style="color: #2C5C36; margin-top: 0; font-size: 14px;">
                    Instructions
                </h4>

                <ul style="color: #64748b; font-size: 13px; padding-left: 20px; margin-bottom: 0;">
                    <li data-i18n="instruction_step_1">Complete each step in order</li>
                    <li data-i18n="instruction_step_2">All required fields must be filled</li>
                    <li data-i18n="instruction_step_3">Review your information before submitting</li>
                    <li data-i18n="instruction_step_4">You can't skip ahead until current step is complete</li>
                </ul>
            </div>

        </div>
    </div>

    <!-- Right Side: Form Content -->
    <div style="flex: 1; background: white; padding: 40px; overflow-y: auto;">
        <div
            style="position: sticky; top: 0; background: white; padding-bottom: 20px; z-index: 10; border-bottom: 1px solid #e2e8f0; margin-bottom: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 id="currentStepTitle" data-i18n="current_step_title"
                    style="color: #21532B; margin: 0; font-size: 1.8rem;">
                    Husband's Personal Details
                </h2>

                <div id="stepCompletionStatus"
                    style="background: #f1f5f9; padding: 8px 16px; border-radius: 20px; font-size: 14px; color: #64748b;">
                    Step <span id="currentStepNumber">1</span> of 8
                </div>
            </div>
            <p id="currentStepSubtitle" data-i18n="current_step_subtitle"
                style="color: #64748b; margin: 10px 0 0 0; font-size: 14px;">
                Step 1 of 4: Primary Identification
            </p>
        </div>

        <form method="POST" action="{{ route('save.divorce.application') }}" enctype="multipart/form-data"
            id="multiStepForm">
            @csrf

            <!-- Step 1: Husband's Personal Details -->
            <div class="form-step active" id="step1">
                <!-- Your existing form section -->
                <div
                    style="background: #21532B; border-radius: 12px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 10px 25px rgba(26, 58, 38, 0.15); font-family: sans-serif;">
                    <div
                        style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.03); border-radius: 50%;">
                    </div>
                    <div
                        style="position: absolute; bottom: -50px; left: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.03); border-radius: 50%;">
                    </div>

                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div
                            style="background: #ffffff; color: #21532B; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 18px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            1</div>
                        <div>
                            <h3 style="color: #ffffff; font-size: 1.5rem; font-weight: 700; margin: 0; letter-spacing: -0.5px;"
                                data-i18n="husband_personal_details">
                                Husband's Personal Details
                            </h3>

                            <p style="color: rgba(255,255,255,0.6); margin: 0; font-size: 13px;">Step 1 of 4: Primary
                                Identification</p>
                        </div>
                    </div>

                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; position: relative; z-index: 1;">
                        @php $fieldStyle = "width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #cbd5e1; background: #ffffff; color: #1e293b; margin-top: 8px; font-size: 14px; transition: all 0.2s ease; outline: none;"; @endphp
                        @foreach (['groom_surname' => 'Surname *', 'groom_given_name' => 'Given Name *', 'groom_nin' => 'NIN *', 'groom_phone' => 'Telephone *', 'groom_email' => 'Email Address *', 'groom_tribe' => 'Tribe *'] as $name => $label)
                            <div
                                style="display: flex; flex-direction: column; background: rgba(255, 255, 255, 0.05); padding: 16px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.08);">
                                <label
                                    style="font-size: 12px; color: rgba(255, 255, 255, 0.9); font-weight: 600; letter-spacing: 0.3px;">{{ $label }}</label>
                                <input type="text" name="{{ $name }}"
                                    placeholder="Enter {{ strtolower(str_replace('*', '', $label)) }}"
                                    style="{{ $fieldStyle }}"
                                    data-required="{{ strpos($label, '*') !== false ? 'true' : 'false' }}">

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Step 2: Husband's Address -->
            <div class="form-step" id="step2" style="display: none;">
                <div
                    style="background: #21532B; border-radius: 12px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 10px 25px rgba(26, 58, 38, 0.15); font-family: sans-serif;">

                    <div
                        style="position: absolute; bottom: -50px; left: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.03); border-radius: 50%;">
                    </div>

                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div
                            style="background: #ffffff; color: #21532B; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 18px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            2</div>
                        <div>
                            <h3 style="color: #ffffff; font-size: 1.5rem; font-weight: 700; margin: 0;">Husband's
                                Residential Address</h3>
                            <p style="color: rgba(255,255,255,0.6); margin: 0; font-size: 13px;">Step 2 of 4: Location
                                Details</p>
                        </div>
                    </div>

                    <!-- Fields -->
                    <div class="groom-address">
                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; position: relative; z-index: 1;">

                            @php
                                $fieldStyle =
                                    'width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #cbd5e1; background: #ffffff; color: #1e293b; margin-top: 8px; font-size: 14px; transition: all 0.2s ease; outline: none;';
                                $addressFields = [
                                    'groom_district' => [
                                        'label' => 'Groom District *',
                                        'type' => 'select',
                                        'class' => 'district-select select2',
                                    ],
                                    'groom_municipality' => [
                                        'label' => 'County / Municipality *',
                                        'type' => 'select',
                                        'class' => 'county-select select2',
                                    ],
                                    'groom_sub_county' => [
                                        'label' => 'Sub County *',
                                        'type' => 'select',
                                        'class' => 'subcounty-select select2',
                                    ],
                                    'groom_parish' => [
                                        'label' => 'Parish / Ward *',
                                        'type' => 'select',
                                        'class' => 'parish-select select2',
                                    ],
                                    'groom_village' => [
                                        'label' => 'Village (LC1 Zone) *',
                                        'type' => 'select',
                                        'class' => 'village-select select2',
                                    ],
                                    'groom_plot_number' => ['label' => 'Plot Number', 'type' => 'text'],
                                ];
                            @endphp

                            @foreach ($addressFields as $name => $field)
                                <div
                                    style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 16px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                    <label style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600;">
                                        {{ $field['label'] }}
                                    </label>

                                    @if ($field['type'] === 'select')
                                        <select name="{{ $name }}" class="{{ $field['class'] ?? '' }}" style="{{ $fieldStyle }}"
                                            data-required="{{ str_contains($field['label'], '*') ? 'true' : 'false' }}">
                                            <option value="">Select
                                                {{ strtolower(str_replace('*', '', $field['label'])) }}
                                            </option>
                                        </select>
                                    @else
                                        <input type="text" name="{{ $name }}" placeholder="Enter {{ strtolower($field['label']) }}"
                                            style="{{ $fieldStyle }}" data-required="false">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Wife’s Personal Details -->
            <div class="form-step" id="step3" style="display: none;">
                <div
                    style="background: #21532B; border-radius: 12px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 10px 25px rgba(26, 58, 38, 0.15); font-family: sans-serif;">
                    <div
                        style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.03); border-radius: 50%;">
                    </div>

                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div
                            style="background: #ffffff; color: #21532B; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 18px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            3</div>
                        <div>
                            <h3
                                style="color: #ffffff; font-size: 1.5rem; font-weight: 700; margin: 0; letter-spacing: -0.5px;">
                                Wife’s Personal Details</h3>
                            <p style="color: rgba(255,255,255,0.6); margin: 0; font-size: 13px;">Step 3 of 8: Primary
                                Identification</p>
                        </div>
                    </div>

                    <!-- Fields -->
                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; position: relative; z-index: 1;">
                            @php
                                $wifeFields = [
                                    'bride_surname' => 'Surname *',
                                    'bride_given_name' => 'Given Name *',
                                    'bride_nin' => 'NIN *',
                                    'bride_phone' => 'Telephone *',
                                    'bride_email' => 'Email Address *',
                                    'bride_tribe' => 'Tribe *',
                                ];
                            @endphp

                            @foreach ($wifeFields as $name => $label)
                                <div
                                    style="display: flex; flex-direction: column; background: rgba(255, 255, 255, 0.05); padding: 16px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <label
                                        style="font-size: 12px; color: rgba(255, 255, 255, 0.9); font-weight: 600; letter-spacing: 0.3px;">
                                        {{ $label }}
                                    </label>
                                    <input type="text" name="{{ $name }}"
                                        placeholder="Enter {{ strtolower(str_replace('*', '', $label)) }}"
                                        style="{{ $fieldStyle }}"
                                        data-required="{{ str_contains($label, '*') ? 'true' : 'false' }}"
                                        onfocus="this.style.borderColor='#ffffff'; this.style.boxShadow='0 0 0 4px rgba(255, 255, 255, 0.15)';"
                                        onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                                </div>
                            @endforeach
                        </div>
                </div>
            </div>

            <!-- Step 4: Wife’s Residential Address -->
            <div class="form-step" id="step4" style="display: none;">
                <div
                    style="background: #21532B; border-radius: 12px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 10px 25px rgba(26, 58, 38, 0.15); font-family: sans-serif;">

                    <div
                        style="position: absolute; bottom: -50px; left: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.03); border-radius: 50%;">
                    </div>

                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div
                            style="background: #ffffff; color: #21532B; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 18px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            4</div>
                        <div>
                            <h3 style="color: #ffffff; font-size: 1.5rem; font-weight: 700; margin: 0;">Wife’s
                                Residential Address</h3>
                            <p style="color: rgba(255,255,255,0.6); margin: 0; font-size: 13px;">Step 4 of 8: Location
                                Details</p>
                        </div>
                    </div>

                    <!-- Fields -->
                    <div class="bride-address">

                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; position: relative; z-index: 1;">
                        @php
                            $fieldStyle =
                                'width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #cbd5e1; background: #ffffff; color: #1e293b; margin-top: 8px; font-size: 14px; transition: all 0.2s ease; outline: none;';

                            $brideAddressFields = [
                                'bride_district' => [
                                    'label' => 'Bride District *',
                                    'type' => 'select',
                                    'class' => 'district-select select2',
                                ],
                                'bride_municipality' => [
                                    'label' => 'County / Municipality *',
                                    'type' => 'select',
                                    'class' => 'county-select select2',
                                ],
                                'bride_sub_county' => [
                                    'label' => 'Sub County *',
                                    'type' => 'select',
                                    'class' => 'subcounty-select select2',
                                ],
                                'bride_parish' => [
                                    'label' => 'Parish / Ward *',
                                    'type' => 'select',
                                    'class' => 'parish-select select2',
                                ],
                                'bride_village' => [
                                    'label' => 'Village (LC1 Zone) *',
                                    'type' => 'select',
                                    'class' => 'village-select select2',
                                ],
                                'bride_plot_number' => ['label' => 'Plot Number', 'type' => 'text'],
                            ];
                        @endphp

                        @foreach ($brideAddressFields as $name => $field)
                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 16px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">

                                <label
                                    style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; letter-spacing: 0.3px;">
                                    {{ $field['label'] }}
                                </label>

                                @if ($field['type'] === 'select')
                                    <select name="{{ $name }}" class="{{ $field['class'] ?? '' }}" style="{{ $fieldStyle }}"
                                        data-required="{{ str_contains($field['label'], '*') ? 'true' : 'false' }}">
                                        <option value="">Select
                                            {{ strtolower(str_replace('*', '', $field['label'])) }}
                                        </option>
                                    </select>
                                @else
                                    <input type="text" name="{{ $name }}" placeholder="Enter {{ strtolower($field['label']) }}"
                                        style="{{ $fieldStyle }}" data-required="false">
                                @endif

                            </div>
                        @endforeach
                    </div>
                    </div>
                </div>
            </div>

            <!-- Step 5: Divorce Details -->
            <div class="form-step" id="step5" style="display: none;">
                <div
                    style="background: #21532B; border-radius: 12px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 10px 25px rgba(26, 58, 38, 0.15); font-family: sans-serif;">

                    <div
                        style="position: absolute; top: -50px; left: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.03); border-radius: 50%;">
                    </div>

                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div
                            style="background: #ffffff; color: #21532B; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 18px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            5</div>
                        <div>
                            <h3
                                style="color: #ffffff; font-size: 1.5rem; font-weight: 700; margin: 0; letter-spacing: -0.5px;">
                                Divorce Details</h3>
                            <p style="color: rgba(255,255,255,0.6); margin: 0; font-size: 13px;">Step 5 of 8: Legal
                                Dissolution Information</p>
                        </div>
                    </div>

                    <!-- Fields -->
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; position: relative; z-index: 1;">
                        @php
                            $fieldStyle =
                                'width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #cbd5e1; background: #ffffff; color: #1e293b; margin-top: 8px; font-size: 14px; transition: all 0.2s ease; outline: none;';
                            $selectStyle = $fieldStyle . ' appearance: none;';
                        @endphp

                        <!-- Type of Divorce -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 16px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                            <label
                                style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; letter-spacing: 0.3px;">Type
                                of Divorce *</label>
                            <div style="position: relative;">
                                <select name="divorce_type" style="{{ $selectStyle }}" data-required="true"
                                    onfocus="this.style.borderColor='#ffffff'; this.style.boxShadow='0 0 0 4px rgba(255,255,255,0.15)';"
                                    onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                                    <option value="">Select Type</option>
                                    <option value="talaq">Talaq</option>
                                    <option value="khul">Khul</option>
                                    <option value="faskh">Faskh</option>
                                </select>
                                <div
                                    style="position: absolute; right: 15px; top: 22px; pointer-events: none; width: 0; height: 0; border-left: 5px solid transparent; border-right: 5px solid transparent; border-top: 5px solid #1e293b;">
                                </div>
                            </div>
                        </div>

                        <!-- Number of Talaq Pronounced -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 16px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                            <label
                                style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; letter-spacing: 0.3px;">Number
                                of Talaq Pronounced *</label>
                            <div style="position: relative;">
                                <select name="talaq_count" style="{{ $selectStyle }}" data-required="true"
                                    onfocus="this.style.borderColor='#ffffff'; this.style.boxShadow='0 0 0 4px rgba(255,255,255,0.15)';"
                                    onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                                    <option value="">Select Number</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                                <div
                                    style="position: absolute; right: 15px; top: 22px; pointer-events: none; width: 0; height: 0; border-left: 5px solid transparent; border-right: 5px solid transparent; border-top: 5px solid #1e293b;">
                                </div>
                            </div>
                        </div>

                        <!-- Divorce Initiated By -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 16px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                            <label
                                style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; letter-spacing: 0.3px;">Divorce
                                Initiated By *</label>
                            <div style="position: relative;">
                                <select name="divorce_initiated_by" style="{{ $selectStyle }}" data-required="true"
                                    onfocus="this.style.borderColor='#ffffff'; this.style.boxShadow='0 0 0 4px rgba(255,255,255,0.15)';"
                                    onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                                    <option value="">Select Initiator</option>
                                    <option value="husband">Husband</option>
                                    <option value="wife">Wife</option>
                                    <option value="court">Court</option>
                                </select>
                                <div
                                    style="position: absolute; right: 15px; top: 22px; pointer-events: none; width: 0; height: 0; border-left: 5px solid transparent; border-right: 5px solid transparent; border-top: 5px solid #1e293b;">
                                </div>
                            </div>
                        </div>

                        <!-- Place of Divorce Pronouncement -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 16px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                            <label
                                style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; letter-spacing: 0.3px;">Place
                                of Divorce Pronouncement *</label>
                            <input type="text" name="divorce_place" placeholder="e.g., UMSC Sharia Court, Kampala"
                                style="{{ $fieldStyle }}" data-required="true"
                                onfocus="this.style.borderColor='#ffffff'; this.style.boxShadow='0 0 0 4px rgba(255,255,255,0.15)';"
                                onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                        </div>

                        <!-- Reason for Divorce -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 16px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08); grid-column: 1 / -1;">
                            <label
                                style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; letter-spacing: 0.3px;">Reason
                                for Divorce *</label>
                            <textarea name="divorce_reason" rows="3" placeholder="Provide a brief explanation..."
                                style="{{ $fieldStyle }} resize: vertical; min-height: 80px;" data-required="true"
                                onfocus="this.style.borderColor='#ffffff'; this.style.boxShadow='0 0 0 4px rgba(255,255,255,0.15)';"
                                onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 6: Official Verification Details -->
            <div class="form-step" id="step6" style="display: none;">
                <div
                    style="background: #21532B; border-radius: 0px; padding: 45px; margin-top: 30px; position: relative; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(26, 58, 38, 0.25); font-family: sans-serif;">
                    <div
                        style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.03); border-radius: 50%;">
                    </div>

                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div
                            style="background: #ffffff; color: #21532B; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 18px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            6</div>
                        <div>
                            <h3
                                style="color: #ffffff; font-size: 1.5rem; font-weight: 700; margin: 0; letter-spacing: -0.5px;">
                                Witnesses & Authority</h3>
                            <p style="color: rgba(255,255,255,0.6); margin: 0; font-size: 13px;">Step 6 of 8: Official
                                Verification Details</p>
                        </div>
                    </div>

                    @php
                        $fieldStyle =
                            'width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #cbd5e1; background: #ffffff; color: #1e293b; margin-top: 8px; font-size: 14px; transition: all 0.2s ease; outline: none;';
                        $placeholdersW1 = [
                            'w1_given_name' => 'Enter Given Name',
                            'w1_surname' => 'Enter Surname',
                            'w1_nin' => 'Enter NIN',
                            'w1_phone' => 'Enter Phone Number',
                            'w1_address' => 'Enter Address',
                        ];
                        $placeholdersW2 = [
                            'w2_given_name' => 'Enter Given Name',
                            'w2_surname' => 'Enter Surname',
                            'w2_nin' => 'Enter NIN',
                            'w2_phone' => 'Enter Phone Number',
                            'w2_address' => 'Enter Address',
                        ];
                        $placeholdersAuthority = [
                            'imam_name' => 'Enter Imam Name',
                            'imam_reg' => 'Enter Registration Number',
                            'qadhi_area' => 'Enter Qadhi Area if applicable',
                            'mosque_name' => 'Enter Mosque Name',
                        ];
                    @endphp

                    <!-- Witness 01 -->
                    <h4
                        style="color: #ffffff; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; opacity: 0.8;">
                        Witness 01</h4>
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 30px;">
                        @foreach ($placeholdersW1 as $name => $placeholder)
                            <div
                                style="display: flex; flex-direction: column; background: rgba(255, 255, 255, 0.05); padding: 12px; border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.08);">
                                <label
                                    style="font-size: 11px; color: rgba(255, 255, 255, 0.9); font-weight: 600;">{{ ucfirst(str_replace('_', ' ', $name)) }}
                                    *</label>
                                <input type="text" name="{{ $name }}" placeholder="{{ $placeholder }}"
                                    style="{{ $fieldStyle }}" data-required="true">
                            </div>
                        @endforeach
                    </div>

                    <!-- Witness 02 -->
                    <h4
                        style="color: #ffffff; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; opacity: 0.8;">
                        Witness 02</h4>
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 30px;">
                        @foreach ($placeholdersW2 as $name => $placeholder)
                            <div
                                style="display: flex; flex-direction: column; background: rgba(255, 255, 255, 0.05); padding: 12px; border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.08);">
                                <label
                                    style="font-size: 11px; color: rgba(255, 255, 255, 0.9); font-weight: 600;">{{ ucfirst(str_replace('_', ' ', $name)) }}
                                    *</label>
                                <input type="text" name="{{ $name }}" placeholder="{{ $placeholder }}"
                                    style="{{ $fieldStyle }}" data-required="true">
                            </div>
                        @endforeach
                    </div>

                    <!-- Authority Details -->
                    <h4
                        style="color: #ffffff; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                        Authority Details</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
                        @foreach ($placeholdersAuthority as $name => $placeholder)
                            <div
                                style="display: flex; flex-direction: column; background: rgba(255, 255, 255, 0.05); padding: 12px; border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.08);">
                                <label
                                    style="font-size: 11px; color: rgba(255, 255, 255, 0.9); font-weight: 600;">{{ ucfirst(str_replace('_', ' ', $name)) }}
                                    *</label>
                                <input type="text" name="{{ $name }}" placeholder="{{ $placeholder }}"
                                    style="{{ $fieldStyle }}" data-required="true">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Step 7: Children & Iddah -->
            <div class="form-step" id="step7" style="display: none;">
                <div
                    style="background: #21532B; border-radius: 0px; padding: 45px; margin-top: 30px; position: relative; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(26, 58, 38, 0.25); font-family: sans-serif;">

                    <!-- Header -->
                    <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px;">
                        <div
                            style="background: #ffffff; color: #21532B; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 18px;">
                            7</div>
                        <div>
                            <h3 style="color: #ffffff; font-size: 1.5rem; font-weight: 700; margin: 0;">Children &
                                Iddah</h3>
                            <p style="color: rgba(255,255,255,0.6); margin: 0; font-size: 13px;">Family and Custody
                                Arrangements</p>
                        </div>
                    </div>

                    @php
                        $fieldStyle =
                            'width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #cbd5e1; background: #ffffff; color: #1e293b; margin-top: 8px; font-size: 14px; transition: all 0.2s ease; outline: none;';
                        $placeholders = [
                            'children_involved' => 'Select Option',
                            'num_children' => 'Enter number of children',
                            'custody_arrangement' => 'e.g., With mother, shared custody, etc.',
                        ];
                    @endphp

                    <!-- Form Fields -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">

                        <!-- Children Involved -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255, 255, 255, 0.05); padding: 16px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.08);">
                            <label style="font-size: 12px; color: rgba(255, 255, 255, 0.9); font-weight: 600;">Children
                                Involved? *</label>
                            <select name="children_involved" style="{{ $fieldStyle }} appearance: none;"
                                data-required="true">
                                <option value="">{{ $placeholders['children_involved'] }}</option>
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>

                        <!-- Number of Children -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255, 255, 255, 0.05); padding: 16px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.08);">
                            <label style="font-size: 12px; color: rgba(255, 255, 255, 0.9); font-weight: 600;">Number
                                of Children *</label>
                            <input type="number" name="num_children" min="0"
                                placeholder="{{ $placeholders['num_children'] }}" style="{{ $fieldStyle }}"
                                data-required="true">
                        </div>

                        <!-- Custody Arrangement -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255, 255, 255, 0.05); padding: 16px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.08); grid-column: 1 / -1;">
                            <label style="font-size: 12px; color: rgba(255, 255, 255, 0.9); font-weight: 600;">Custody
                                Arrangement *</label>
                            <input type="text" name="custody_arrangement"
                                placeholder="{{ $placeholders['custody_arrangement'] }}" style="{{ $fieldStyle }}"
                                data-required="true">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 8: Passport Photographs -->
            @php
                $application = $application ?? null;
            @endphp

            <div class="form-step" id="step8" style="display: none;">
                <div
                    style="background: #21532B; border-radius: 0px; padding: 45px; margin-top: 30px; position: relative; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(26, 58, 38, 0.25); font-family: sans-serif;">

                    <!-- Header -->
                    <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px;">
                        <div
                            style="background: #ffffff; color: #21532B; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 18px;">
                            8</div>
                        <div>
                            <h3 style="color: #ffffff; font-size: 1.5rem; font-weight: 700; margin: 0;">Passport
                                Photographs</h3>
                            <p style="color: rgba(255,255,255,0.6); margin: 0; font-size: 13px;">Husband and Wife
                                Identification Photos</p>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">

                        <!-- Husband Photo -->
                        <div
                            style="background: rgba(255,255,255,0.05); border: 2px dashed rgba(255,255,255,0.2); border-radius: 16px; padding: 30px; text-align: center; transition: all 0.3s ease; position: relative;">
                            <h4 style="color: #ffffff; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
                                Husband's Photograph *</h4>

                            <div onclick="document.getElementById('groomPhoto').click()" style="cursor: pointer;">
                                @if ($application && @$application->groom_photo_path)
                                    <img id="groomPhotoPreview" src="{{ Storage::url(@$application->groom_photo_path) }}"
                                        style="width: 150px; height: 180px; object-fit: cover; border-radius: 8px; border: 3px solid #ffffff; margin-bottom: 15px;">
                                @else
                                    <div id="groomPlaceholder"
                                        style="width: 150px; height: 180px; background: rgba(255,255,255,0.1); border-radius: 8px; margin: 0 auto 15px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #ffffff;">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.5">
                                            <rect x="3" y="3" width="18" height="18" rx="2" />
                                            <circle cx="8.5" cy="8.5" r="1.5" />
                                            <path d="M21 15l-5-5L5 21" />
                                        </svg>
                                        <p style="font-size: 11px; margin-top: 10px; opacity: 0.7;">Click to Upload</p>
                                    </div>
                                @endif
                                <img id="groomPhotoPreview"
                                    style="display: none; width: 150px; height: 180px; object-fit: cover; border-radius: 8px; border: 3px solid #ffffff; margin: 0 auto 15px;">
                            </div>

                            <input type="file" id="groomPhoto" name="groomPhoto" accept="image/*" style="display: none;"
                                data-required="true"
                                onchange="previewImage(this, 'groomPhotoPreview', 'groomPlaceholder')">
                            <p style="color: rgba(255,255,255,0.5); font-size: 11px;">Max size 2MB (JPG, PNG)</p>
                        </div>

                        <!-- Wife Photo -->
                        <div
                            style="background: rgba(255,255,255,0.05); border: 2px dashed rgba(255,255,255,0.2); border-radius: 16px; padding: 30px; text-align: center; transition: all 0.3s ease; position: relative;">
                            <h4 style="color: #ffffff; font-size: 14px; font-weight: 600; margin-bottom: 20px;">Wife's
                                Photograph *</h4>

                            <div onclick="document.getElementById('bridePhoto').click()" style="cursor: pointer;">
                                @if ($application && @$application->bride_photo_path)
                                    <img id="bridePhotoPreview" src="{{ Storage::url(@$application->bride_photo_path) }}"
                                        style="width: 150px; height: 180px; object-fit: cover; border-radius: 8px; border: 3px solid #ffffff; margin-bottom: 15px;">
                                @else
                                    <div id="bridePlaceholder"
                                        style="width: 150px; height: 180px; background: rgba(255,255,255,0.1); border-radius: 8px; margin: 0 auto 15px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #ffffff;">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.5">
                                            <rect x="3" y="3" width="18" height="18" rx="2" />
                                            <circle cx="8.5" cy="8.5" r="1.5" />
                                            <path d="M21 15l-5-5L5 21" />
                                        </svg>
                                        <p style="font-size: 11px; margin-top: 10px; opacity: 0.7;">Click to Upload</p>
                                    </div>
                                @endif
                                <img id="bridePhotoPreview"
                                    style="display: none; width: 150px; height: 180px; object-fit: cover; border-radius: 8px; border: 3px solid #ffffff; margin: 0 auto 15px;">
                            </div>

                            <input type="file" id="bridePhoto" name="bridePhoto" accept="image/*" style="display: none;"
                                data-required="true"
                                onchange="previewImage(this, 'bridePhotoPreview', 'bridePlaceholder')">
                            <p style="color: rgba(255,255,255,0.5); font-size: 11px;">Max size 2MB (JPG, PNG)</p>
                        </div>

                    </div>
                </div>
            </div>

            <script>
                function previewImage(input, previewId, placeholderId) {
                    const preview = document.getElementById(previewId);
                    const placeholder = document.getElementById(placeholderId);
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                            if (placeholder) placeholder.style.display = 'none';
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>


            <!-- Navigation Buttons -->
            <div
                style="display: flex; justify-content: space-between; margin-top: 40px; padding-top: 30px; border-top: 1px solid #e2e8f0;">
                <button type="button" id="prevBtn" data-i18n="previous_button" onclick="previousStep()"
                    style="padding: 14px 30px; background: #64748b; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 15px; display: none; align-items: center; gap: 8px;">

                    <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M15 18l-6-6 6-6" />
                    </svg>

                    Previous
                </button>


                <div></div> <!-- Spacer -->

                <button type="button" id="nextBtn" data-i18n="next_step_button" onclick="nextStep()"
                    style="padding: 14px 40px; background: #21532B; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                    Next Step
                    <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </button>

                <button type="submit" id="submitBtn" data-i18n="submit_application_button" data-required="true"
                    style="padding: 14px 40px; background: #10b981; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 15px; display: none; align-items: center; gap: 8px;">
                    Submit Application
                    <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M20 6L9 17l-5-5" />
                    </svg>
                </button>


            </div>
        </form>
    </div>
</div>

<style>
    .step-indicator.active {
        border-color: #21532B !important;
        box-shadow: 0 4px 12px rgba(33, 83, 43, 0.1);
    }

    .step-indicator.active .step-number {
        background: #21532B !important;
        color: white !important;
    }

    .step-indicator.completed {
        border-color: #10b981 !important;
        background: #f0fdf4 !important;
    }

    .step-indicator.completed .step-number {
        background: #10b981 !important;
        color: white !important;
    }

    .step-indicator.locked {
        opacity: 0.6;
        cursor: not-allowed !important;
    }

    .step-indicator.locked:hover {
        background: white !important;
        border-color: #e2e8f0 !important;
    }

    .step-indicator:not(.locked):hover {
        background: #f1f5f9 !important;
        border-color: #cbd5e1 !important;
        transform: translateY(-2px);
    }

    .step-indicator.active .step-status svg {
        color: #21532B !important;
    }

    .step-indicator.completed .step-status svg {
        color: #10b981 !important;
    }

    .form-step {
        animation: slideIn 0.4s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @media (max-width: 1024px) {
        div[style*="display: flex; min-height: 100vh"] {
            flex-direction: column;
        }

        div[style*="flex: 0.4"] {
            flex: none;
            max-width: 100%;
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
            max-height: 50vh;
        }
    }

    /* Responsive styles for right-side form content */
    @media (max-width: 1024px) {

        /* Right side: Form content */
        div[style*="flex: 1; background: white; padding: 40px"] {
            padding: 20px;
        }

        /* Step header */
        div[style*="position: sticky; top: 0; background: white"]>div {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        #stepCompletionStatus {
            align-self: flex-start;
            margin-top: 10px;
        }
    }

    @media (max-width: 768px) {

        /* Form step containers */
        .form-step>div {
            padding: 25px !important;
        }

        /* Step header inside forms */
        .form-step>div>div[style*="display: flex; align-items: center; gap: 20px"] {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 30px !important;
        }

        /* Grid layouts for form fields */
        .form-step>div>div[style*="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr))"] {
            grid-template-columns: 1fr !important;
            gap: 15px !important;
        }

        /* Form field containers */
        .form-step>div>div[style*="display: grid"]>div {
            width: 100%;
        }

        /* Full-width for grid items */
        .form-step>div>div[style*="display: grid"]>div[style*="grid-column: 1 / -1"] {
            grid-column: 1 !important;
        }

        /* Step 6 specific grid adjustments */
        #step6>div>div[style*="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))"] {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)) !important;
        }

        @media (max-width: 480px) {
            #step6>div>div[style*="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))"] {
                grid-template-columns: 1fr !important;
            }
        }

        /* Photo upload step adjustments */
        #step8>div>div[style*="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))"] {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
        }

        /* Navigation buttons */
        div[style*="display: flex; justify-content: space-between; margin-top: 40px;"] {
            flex-direction: column;
            gap: 15px;
            margin-top: 30px !important;
            padding-top: 20px !important;
        }

        div[style*="display: flex; justify-content: space-between; margin-top: 40px;"]>button,
        div[style*="display: flex; justify-content: space-between; margin-top: 40px;"]>div {
            width: 100%;
            justify-content: center;
        }

        /* Button styling for mobile */
        button[style*="padding: 14px 40px"],
        button[style*="padding: 14px 30px"] {
            padding: 12px 20px !important;
            font-size: 14px !important;
            width: 100%;
        }

        /* Fix the spacer div */
        div[style*="display: flex; justify-content: space-between; margin-top: 40px;"]>div:empty {
            display: none;
        }
    }

    @media (max-width: 480px) {

        /* Even smaller screens */
        div[style*="flex: 1; background: white; padding: 40px"] {
            padding: 15px;
        }

        .form-step>div {
            padding: 20px !important;
            border-radius: 8px !important;
        }

        /* Reduce decorative circles on mobile */
        .form-step>div>div[style*="position: absolute;"] {
            display: none;
        }

        /* Step numbers */
        .form-step>div>div[style*="display: flex; align-items: center"]>div[style*="background: #ffffff; color: #21532B; width: 45px; height: 45px"] {
            width: 35px !important;
            height: 35px !important;
            font-size: 16px !important;
        }

        /* Step titles */
        .form-step>div>div[style*="display: flex; align-items: center"]>div>h3 {
            font-size: 1.2rem !important;
        }

        /* Form labels */
        .form-step>div>div[style*="display: grid"]>div>label {
            font-size: 11px !important;
        }

        /* Form inputs */
        input[style*="width: 100%; padding: 12px 16px"],
        select[style*="width: 100%; padding: 12px 16px"],
        textarea[style*="width: 100%; padding: 12px 16px"] {
            padding: 10px 14px !important;
            font-size: 13px !important;
        }
    }

    @media (max-width: 768px) {

        div[style*="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))"],
        div[style*="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))"],
        div[style*="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr))"] {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)) !important;
        }
    }

    @media (max-width: 480px) {
        div[style*="grid-template-columns: repeat(auto-fit, minmax("] {
            grid-template-columns: 1fr !important;
            gap: 12px !important;
        }

        .form-step>div>div[style*="display: grid"]>div {
            padding: 15px !important;
        }
    }
</style>

<script>
    document.getElementById('multiStepForm').addEventListener('submit', function (e) {
        if (!validateCurrentStep()) {
            e.preventDefault();
            return false;
        }
    });
</script>

<script>
    let currentStep = 1;
    const totalSteps = 8;
    const completedSteps = new Set();

    const stepData = {
        1: {
            title: "Husband's Personal Details",
            subtitle: "Step 1 of 8: Primary Identification"
        },
        2: {
            title: "Husband's Residential Address",
            subtitle: "Step 2 of 8: Location Details"
        },
        3: {
            title: "Wife's Personal Details",
            subtitle: "Step 3 of 8: Primary Identification"
        },
        4: {
            title: "Wife's Residential Address",
            subtitle: "Step 4 of 8: Location Details"
        },
        5: {
            title: "Divorce Details",
            subtitle: "Step 5 of 8: Legal Dissolution Information"
        },
        6: {
            title: "Witnesses & Authority",
            subtitle: "Step 6 of 8:Official Verification Details"
        },
        7: {
            title: "Children & Iddah",
            subtitle: "Step 7 of 8:Family and Custody Arrangements"
        },
        8: {
            title: "Passport Photographs",
            subtitle: "Step 8 of 8:Husband and Wife Identification Photos"
        }
    };

    document.querySelectorAll('[data-required="true"]').forEach(field => {

        field.addEventListener('focus', () => {
            if (!field.classList.contains('is-invalid')) {
                field.style.borderColor = '#ffffff';
                field.style.boxShadow = '0 0 0 4px rgba(255,255,255,0.15)';
            }
        });

        field.addEventListener('blur', () => {
            if (!field.classList.contains('is-invalid')) {
                field.style.borderColor = '#cbd5e1';
                field.style.boxShadow = 'none';
            }
        });

    });


    function updateUI() {

        for (let i = 1; i <= totalSteps; i++) {
            const indicator = document.getElementById(`stepIndicator${i}`);
            if (!indicator) continue;

            indicator.classList.remove('active', 'completed', 'locked');

            if (i === currentStep) {
                indicator.classList.add('active');
                indicator.style.cursor = 'default';
            } else if (completedSteps.has(i)) {
                indicator.classList.add('completed');
                indicator.style.cursor = 'pointer';

                const statusIcon = indicator.querySelector('.step-status');
                if (statusIcon) {
                    statusIcon.innerHTML = `
                    <svg style="color: #10b981; width: 100%; height: 100%;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                `;
                }
            } else if (i < currentStep || completedSteps.has(currentStep)) {
                indicator.classList.remove('locked');
                indicator.style.cursor = 'pointer';
            } else {
                indicator.classList.add('locked');
                indicator.style.cursor = 'not-allowed';
            }
        }

        document.getElementById('currentStepTitle').textContent = stepData[currentStep].title;
        document.getElementById('currentStepSubtitle').textContent = stepData[currentStep].subtitle;
        document.getElementById('currentStepNumber').textContent = currentStep;


        document.querySelectorAll('.form-step').forEach((step, index) => {
            step.style.display = (index + 1 === currentStep) ? 'block' : 'none';
        });

        document.getElementById('prevBtn').style.display = currentStep > 1 ? 'flex' : 'none';
        document.getElementById('nextBtn').style.display = currentStep < totalSteps ? 'flex' : 'none';
        document.getElementById('submitBtn').style.display = currentStep === totalSteps ? 'flex' : 'none';

        const progress = (completedSteps.size / totalSteps) * 100;
        document.getElementById('progressBar').style.width = `${progress}%`;
        document.getElementById('progressPercentage').textContent = `${Math.round(progress)}%`;
        document.getElementById('completedSteps').textContent =
            `${completedSteps.size} of ${totalSteps} sections completed`;
    }

    function nextStep() {
        if (validateCurrentStep()) {
            markStepAsCompleted(currentStep);

            if (currentStep < totalSteps) {
                currentStep++;
                updateUI();

                document.querySelector('.form-step.active').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    }

    function previousStep() {
        if (currentStep > 1) {
            currentStep--;
            updateUI();

            document.querySelector('.form-step.active').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    function markStepAsCompleted(step) {
        completedSteps.add(step);

        if (step < totalSteps) {
            const nextIndicator = document.getElementById(`stepIndicator${step + 1}`);
            if (nextIndicator) {
                nextIndicator.classList.remove('locked');
            }
        }
    }

    function validateCurrentStep() {
        const currentStepEl = document.getElementById(`step${currentStep}`);
        const requiredFields = currentStepEl.querySelectorAll('[data-required="true"]');
        let isValid = true;
        let firstInvalidField = null;

        requiredFields.forEach(field => {

            if (field.type === 'file') {
                if (!field.files || !field.files[0]) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    field.style.borderColor = '#ef4444';
                    field.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.15)';
                    if (!firstInvalidField) firstInvalidField = field;
                } else {
                    field.classList.remove('is-invalid');
                    field.style.borderColor = '#cbd5e1';
                    field.style.boxShadow = 'none';
                }
            } else {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    field.style.borderColor = '#ef4444';
                    field.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.15)';
                    if (!firstInvalidField) firstInvalidField = field;
                } else {
                    field.classList.remove('is-invalid');
                    field.style.borderColor = '#cbd5e1';
                    field.style.boxShadow = 'none';
                }
            }
        });

        if (!isValid && firstInvalidField) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Form',
                text: 'Please fill all required fields marked with *',
                confirmButtonText: 'OK, I understand',
                confirmButtonColor: '#21532B',
                allowOutsideClick: false
            }).then(() => {
                firstInvalidField.focus();
                firstInvalidField.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            });
        }

        return isValid;
    }


    function switchStep(step) {

        if (step === currentStep || step > currentStep && !completedSteps.has(step)) {
            return;
        }

        if (step > currentStep && !validateCurrentStep()) {
            return;
        }

        if (step > currentStep) {
            markStepAsCompleted(currentStep);
        }

        currentStep = step;
        updateUI();

        document.querySelector('.form-step.active').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        for (let i = 1; i <= totalSteps; i++) {
            const indicator = document.getElementById(`stepIndicator${i}`);
            if (indicator) {
                indicator.addEventListener('click', function () {

                    if (!this.classList.contains('locked')) {
                        switchStep(i);
                    }
                });
            }
        }


        const form = document.getElementById('multiStepForm');
        form.addEventListener('input', function (e) { });

        updateUI();
    });

    function saveFormData() {
        const formData = new FormData(document.getElementById('multiStepForm'));
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        localStorage.setItem('divorceFormData', JSON.stringify(data));
        localStorage.setItem('divorceFormCurrentStep', currentStep);
        localStorage.setItem('divorceFormCompletedSteps', JSON.stringify([...completedSteps]));
    }

    function loadFormData() {
        const savedData = localStorage.getItem('divorceFormData');
        const savedStep = localStorage.getItem('divorceFormCurrentStep');
        const savedCompleted = localStorage.getItem('divorceFormCompletedSteps');

        if (savedData) {
            const data = JSON.parse(savedData);
            Object.keys(data).forEach(key => {
                const field = document.querySelector(`[name="${key}"]`);
                if (field) field.value = data[key];
            });
        }

        if (savedStep) {
            currentStep = parseInt(savedStep);
        }

        if (savedCompleted) {
            completedSteps.clear();
            JSON.parse(savedCompleted).forEach(step => completedSteps.add(step));
        }
    }

    document.getElementById('multiStepForm').addEventListener('submit', function () {
        localStorage.removeItem('divorceFormData');
        localStorage.removeItem('divorceFormCurrentStep');
        localStorage.removeItem('divorceFormCompletedSteps');
    });
</script>

<script>
    document.getElementById('multiStepForm').addEventListener('submit', function (e) {
        e.preventDefault();

        if (!validateCurrentStep()) return;

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to submit this application?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#ef4444'
        }).then((result) => {
            if (!result.isConfirmed) return;

            // Loading state
            Swal.fire({
                title: 'Submitting...',
                html: 'Please wait while your application is being submitted.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            const form = document.getElementById('multiStepForm');
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {

                    if (!data.success) {
                        throw new Error(data.message || 'Submission failed');
                    }

                    // Success alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Divorce Application Submitted',
                        html: `
                    <p class="mb-2">Your application has been submitted successfully.</p>
                    <p><strong>Application ID:</strong></p>
                    <p style="font-size:18px;color:#10b981;font-weight:600;">
                        ${data.application_id}
                    </p>
                `,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#10b981',
                        allowOutsideClick: false
                    }).then(() => {
                        // Redirect after OK
                        window.location.href = "{{ url('divorce-dashboard') }}";
                    });

                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Failed',
                        text: error.message || 'Something went wrong. Please try again.',
                        confirmButtonColor: '#ef4444'
                    });
                });
        });
    });
</script>


<script src="{{ asset('asset/js/uganda-data.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {

    function populateSelect(select, options) {

        select.innerHTML = `<option value="">-- Select --</option>`;

        options.forEach(opt => {
            let optionEl = document.createElement("option");
            optionEl.value = opt;
            optionEl.textContent = opt;
            select.appendChild(optionEl);
        });

        // Refresh Select2 if applied
        if ($(select).hasClass("select2")) {
            $(select).trigger("change.select2");
        }
    }

    // Initialize Select2 globally
    // $(".select2").select2({
    //     width: "100%"
    // });
    
$(".select2").select2({
    width: "100%",
    tags: true,
    placeholder: "-- Select --",
    allowClear: true,
    tokenSeparators: [','],

    createTag: function (params) {
        let term = $.trim(params.term);
        if (term === "") return null;

        return {
            id: term,
            text: term
        };
    },

    insertTag: function (data, tag) {
        data.push(tag);
    },

    language: {
        noResults: function (params) {
            return "Press Enter to add: " + params.term;
        }
    }
});

    // District list
    const districtsList = window.ugandaData.districts.map(d => d.name);

    // ================================
    // Handle Each Address Block Separately
    // ================================
    document.querySelectorAll(".groom-address, .bride-address").forEach(section => {

        const districtSelect  = section.querySelector(".district-select");
        const countySelect    = section.querySelector(".county-select");
        const subcountySelect = section.querySelector(".subcounty-select");
        const parishSelect    = section.querySelector(".parish-select");
        const villageSelect   = section.querySelector(".village-select");

        // Load districts
        populateSelect(districtSelect, districtsList);

        // ================================
        // District → County
        // ================================
        $(districtSelect).on("change", function () {

            const districtObj = window.ugandaData.districts.find(
                d => d.name === this.value
            );

            populateSelect(countySelect, districtObj ? districtObj.counties : []);
            populateSelect(subcountySelect, []);
            populateSelect(parishSelect, []);
            populateSelect(villageSelect, []);
        });

        // ================================
        // County → Subcounty
        // ================================
        $(countySelect).on("change", function () {

            const subs = subCounties[this.value] || [];
            populateSelect(subcountySelect, subs);

            populateSelect(parishSelect, []);
            populateSelect(villageSelect, []);
        });

        // ================================
        // Subcounty → Parish
        // ================================
        $(subcountySelect).on("change", function () {

            const parishList = parishes[this.value] || [];
            populateSelect(parishSelect, parishList);

            populateSelect(villageSelect, []);
        });

        // ================================
        // Parish → Village
        // ================================
        $(parishSelect).on("change", function () {

            const villageList = villages[this.value] || [];
            populateSelect(villageSelect, villageList);
        });

    });

});
</script>

@include('layouts.form-footers')