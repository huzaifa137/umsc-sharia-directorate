@include('layouts.form-headers')

<script>
    const stepTranslations = {
        en: {
            step1_number: "Step 1",
            step1_title: "Deceased Person Details",
            step2_number: "Step 2",
            step2_title: "Estate Inventory & Valuation",
            step3_number: "Step 3",
            step3_title: "Heirs Information",
            step4_number: "Step 4",
            step4_title: "Shariah Verification"
        },
        ar: {
            step1_number: "الخطوة 1",
            step1_title: "تفاصيل الشخص المتوفى",
            step2_number: "الخطوة 2",
            step2_title: "جرد الممتلكات وتقييمها",
            step3_number: "الخطوة 3",
            step3_title: "معلومات الورثة",
            step4_number: "الخطوة 4",
            step4_title: "التحقق الشرعي"
        },
        sw: {
            step1_number: "Hatua 1",
            step1_title: "Maelezo ya Marehemu",
            step2_number: "Hatua 2",
            step2_title: "Orodha na Thamani ya Mali",
            step3_number: "Hatua 3",
            step3_title: "Taarifa za Warithi",
            step4_number: "Hatua 4",
            step4_title: "Uthibitisho wa Shariah"
        }
    };

    // Example: Function to update step titles dynamically
    function updateStepTranslations(lang = 'en') {
        document.querySelectorAll("[data-i18n]").forEach(el => {
            const key = el.getAttribute("data-i18n");
            if (stepTranslations[lang][key]) {
                el.textContent = stepTranslations[lang][key];
            }
        });
    }

    const translations = {
        en: {
            prev_btn: "Previous",
            next_step_btn: "Next Step",
            submit_btn: "Submit Application",
            back_to_dashboard: "Back to Dashboard",
            inheritance_title: "Inheritance",
            inheritance_subtitle: "Complete all 4 sections to submit your inheritance claim according to Shariah law",
            application_progress_label: "Application Progress",
            step4_title: "Shariah Verification",
            step4_subtitle: "Official verification by religious authority",
            imam_name_label: "Imam Name *",
            imam_name_placeholder: "Full name of verifying Imam",
            imam_reg_label: "Imam Registration Number",
            imam_reg_placeholder: "Official registration number",
            mosque_name_label: "Mosque Name *",
            mosque_name_placeholder: "Name of mosque",
            verification_date_label: "Verification Date",
            verification_date_placeholder: "",
            verification_notes_label: "Verification Notes",
            verification_notes_placeholder: "Any additional notes or observations...",
            declaration_label: "Declaration",
            declaration_text: "I hereby declare that all information provided in this inheritance application is true and accurate to the best of my knowledge. I understand that any false information may lead to legal consequences according to Shariah law and Ugandan legislation.",
            step_number: "3",
            step3_title: "Heirs Information",
            step3_subtitle: "List all heirs according to Shariah inheritance rules",
            // Spouse Section
            heirs_spouse_title: "SPOUSE",
            spouse_name_label: "Spouse Name (If applicable)",
            spouse_name_placeholder: "Full name of spouse",
            spouse_nin_label: "Spouse NIN",
            spouse_nin_placeholder: "14-digit NIN",

            // Children Section
            heirs_children_title: "CHILDREN",
            sons_count_label: "Number of Sons *",
            daughters_count_label: "Number of Daughters *",

            // Parents Section
            heirs_parents_title: "PARENTS",
            father_alive_label: "Father Alive? *",
            father_name_label: "Father's Name",
            father_name_placeholder: "If alive",
            mother_alive_label: "Mother Alive? *",
            mother_name_label: "Mother's Name",
            mother_name_placeholder: "If alive",

            // Siblings Section
            heirs_siblings_title: "SIBLINGS",
            full_brothers_label: "Full Brothers",
            full_sisters_label: "Full Sisters",
            uterine_brothers_label: "Uterine Brothers (Same mother)",
            uterine_sisters_label: "Uterine Sisters (Same mother)",

            // Special Cases Section
            special_cases_title: "SPECIAL CASES",
            pregnant_heir_label: "Pregnant Heir? *",
            minor_heirs_label: "Minor Heirs? (Under 18) *",

            // Select Options
            yes: "Yes",
            no: "No",
            step_number: "2",
            step2_title: "Estate Inventory & Valuation",
            step2_subtitle: "List all assets and liabilities of the deceased",

            // Total Estate Value
            total_estate_value_label: "Total Estimated Estate Value (UGX) *",
            total_estate_value_placeholder: "Enter total value in UGX",
            total_estate_value_note: "This should equal the sum of all properties minus liabilities",

            // Liabilities & Debts Section
            liabilities_title: "Liabilities & Debts",
            outstanding_debts_label: "Outstanding Debts (UGX)",
            funeral_expenses_label: "Funeral Expenses (UGX) *",
            unpaid_zakat_label: "Unpaid Zakat (UGX)",
            other_liabilities_label: "Other Liabilities (UGX)",

            // Property Details Section
            properties_title: "Property Details",
            properties_instruction: "List all properties owned by the deceased at the time of death",
            add_property_btn: "Add Another Property",
            remove_property_btn: "Remove Property",
            property_number: "Property",
            property_type_label: "Type *",
            property_type_options: {
                land: "Land",
                house: "House/Apartment",
                commercial: "Commercial Building",
                agricultural: "Agricultural Land",
                vehicle: "Vehicle",
                bank_account: "Bank Account",
                investment: "Investment",
                jewelry: "Jewelry/Gold",
                livestock: "Livestock",
                other: "Other"
            },
            property_description_label: "Description *",
            property_description_placeholder: "e.g., 3-bedroom house, Toyota Premio",
            property_value_label: "Value (UGX) *",
            property_value_placeholder: "e.g., 50000000",
            property_location_label: "Location",
            property_location_placeholder: "e.g., Kampala, Kololo",
            total_properties_label: "Total Properties Value:",
            step1_title: "Deceased Person Details",
            step1_subtitle: "Please provide accurate information about the deceased person",
            personal_info_header: "Personal Information",
            deceased_name_label: "Full Name of Deceased *",
            deceased_name_placeholder: "Enter full legal name",
            gender_label: "Gender *",
            select_gender_option: "Select Gender",
            gender_male: "Male",
            gender_female: "Female",
            date_of_death_label: "Date of Death *",
            place_of_death_label: "Place of Death *",
            place_of_death_placeholder: "City, District, Country",
            cause_of_death_label: "Cause of Death",
            cause_of_death_placeholder: "If known",
            nin_label: "National ID (NIN) *",
            nin_placeholder: "14-digit NIN number",
            marital_status_label: "Marital Status at Death *",
            select_marital_status_option: "Select Status",
            status_single: "Single",
            status_married: "Married",
            status_divorced: "Divorced",
            status_widowed: "Widowed",
            occupation_label: "Occupation/Profession",
            occupation_placeholder: "Profession or trade",
            last_residence_label: "Last Residence Address *",
            last_residence_placeholder: "Complete residential address",
            death_certificate_header: "Death Certificate",
            upload_certificate_text: "Upload Death Certificate",
            upload_certificate_note: "Upload a clear image of the death certificate (JPG, PNG, max 2MB)",
            applicant_info_header: "Applicant Information",
            applicant_name_label: "Applicant Name",
            applicant_name_placeholder: "Your full name",
            relationship_label: "Relationship to Deceased *",
            select_relationship_option: "Select Relationship",
            relationship_spouse: "Spouse",
            relationship_child: "Child",
            relationship_parent: "Parent",
            relationship_sibling: "Sibling",
            relationship_other_relative: "Other Relative",
            relationship_executor: "Executor",
            applicant_nin_label: "Applicant NIN *",
            applicant_nin_placeholder: "Your 14-digit NIN",
            applicant_phone_label: "Telephone Number *",
            applicant_phone_placeholder: "+256 XXX XXX XXX",
            instructions_title: "Important Instructions",
            instructions_step1: "Complete each step in order",
            instructions_step2: "All required fields (*) must be filled",
            instructions_step3: "Upload clear documents in JPG/PNG format",
            instructions_step4: "Values should be in Ugandan Shillings (UGX)",
            support_text: "Need help?",
            support_link: "Contact Support",
            completed_steps_text: "0 of 4 sections completed"

        },
        ar: {
            prev_btn: "السابق",
            next_step_btn: "الخطوة التالية",
            submit_btn: "إرسال الطلب",
            back_to_dashboard: "العودة إلى لوحة التحكم",
            inheritance_title: "الميراث",
            inheritance_subtitle: "أكمل جميع الأقسام الأربعة لتقديم طلب الميراث وفقًا للشريعة",
            application_progress_label: "تقدم الطلب",
            step4_title: "التحقق الشرعي",
            step4_subtitle: "التحقق الرسمي من قبل السلطة الدينية",
            imam_name_label: "اسم الإمام *",
            imam_name_placeholder: "الاسم الكامل للإمام الذي يقوم بالتحقق",
            imam_reg_label: "رقم تسجيل الإمام",
            imam_reg_placeholder: "الرقم الرسمي للتسجيل",
            mosque_name_label: "اسم المسجد *",
            mosque_name_placeholder: "اسم المسجد",
            verification_date_label: "تاريخ التحقق",
            verification_date_placeholder: "",
            verification_notes_label: "ملاحظات التحقق",
            verification_notes_placeholder: "أي ملاحظات أو ملاحظات إضافية...",
            declaration_label: "إقرار",
            declaration_text: "أقر بموجب هذا أن جميع المعلومات المقدمة في طلب الميراث هذه صحيحة ودقيقة حسب معرفتي. أفهم أن أي معلومات كاذبة قد تؤدي إلى عواقب قانونية وفقًا للشريعة والقانون الأوغندي.",
            step_number: "٣",
            step3_title: "معلومات الورثة",
            step3_subtitle: "سرد جميع الورثة وفقاً لقواعد الميراث الشرعي",

            heirs_spouse_title: "الزوج/الزوجة",
            spouse_name_label: "اسم الزوج/الزوجة (إن وجد)",
            spouse_name_placeholder: "الاسم الكامل للزوج/الزوجة",
            spouse_nin_label: "الرقم الوطني للزوج/الزوجة",
            spouse_nin_placeholder: "14 رقماً",

            heirs_children_title: "الأبناء",
            sons_count_label: "عدد الأبناء *",
            daughters_count_label: "عدد البنات *",

            heirs_parents_title: "الوالدان",
            father_alive_label: "هل الأب على قيد الحياة؟ *",
            father_name_label: "اسم الأب",
            father_name_placeholder: "إذا كان على قيد الحياة",
            mother_alive_label: "هل الأم على قيد الحياة؟ *",
            mother_name_label: "اسم الأم",
            mother_name_placeholder: "إذا كانت على قيد الحياة",

            heirs_siblings_title: "الأشقاء",
            full_brothers_label: "الإخوة الكاملون",
            full_sisters_label: "الأخوات الكاملات",
            uterine_brothers_label: "الإخوة لأم واحدة",
            uterine_sisters_label: "الأخوات لأم واحدة",

            special_cases_title: "حالات خاصة",
            pregnant_heir_label: "وريثة حامل؟ *",
            minor_heirs_label: "ورثة قاصرين؟ (تحت 18 سنة) *",

            yes: "نعم",
            no: "لا",
            step_number: "٢",
            step2_title: "جرد وتقييم الممتلكات",
            step2_subtitle: "سرد جميع الأصول والخصوم للمتوفى",

            total_estate_value_label: "إجمالي قيمة التركة المقدرة (UGX) *",
            total_estate_value_placeholder: "أدخل القيمة الإجمالية بالعملة UGX",
            total_estate_value_note: "يجب أن تساوي مجموع جميع الممتلكات ناقص الخصوم",

            liabilities_title: "الخصوم والديون",
            outstanding_debts_label: "الديون المستحقة (UGX)",
            funeral_expenses_label: "مصاريف الجنازة (UGX) *",
            unpaid_zakat_label: "الزكاة غير المدفوعة (UGX)",
            other_liabilities_label: "خصوم أخرى (UGX)",

            properties_title: "تفاصيل الممتلكات",
            properties_instruction: "سرد جميع الممتلكات المملوكة للمتوفى عند الوفاة",
            add_property_btn: "إضافة ممتلك آخر",
            remove_property_btn: "إزالة الممتلك",
            property_number: "الممتلك",
            property_type_label: "النوع *",
            property_type_options: {
                land: "أرض",
                house: "منزل/شقة",
                commercial: "مبنى تجاري",
                agricultural: "أرض زراعية",
                vehicle: "مركبة",
                bank_account: "حساب بنكي",
                investment: "استثمار",
                jewelry: "مجوهرات/ذهب",
                livestock: "ماشية",
                other: "أخرى"
            },
            property_description_label: "الوصف *",
            property_description_placeholder: "مثل: منزل من 3 غرف، تويوتا بريمو",
            property_value_label: "القيمة (UGX) *",
            property_value_placeholder: "مثل: 50000000",
            property_location_label: "الموقع",
            property_location_placeholder: "مثل: كمبالا، كولولو",
            total_properties_label: "إجمالي قيمة الممتلكات:",
            step1_title: "بيانات الشخص المتوفى",
            step1_subtitle: "يرجى تقديم معلومات دقيقة عن الشخص المتوفى",
            personal_info_header: "المعلومات الشخصية",
            deceased_name_label: "الاسم الكامل للمتوفى *",
            deceased_name_placeholder: "أدخل الاسم القانوني الكامل",
            gender_label: "الجنس *",
            select_gender_option: "اختر الجنس",
            gender_male: "ذكر",
            gender_female: "أنثى",
            date_of_death_label: "تاريخ الوفاة *",
            place_of_death_label: "مكان الوفاة *",
            place_of_death_placeholder: "المدينة، المنطقة، الدولة",
            cause_of_death_label: "سبب الوفاة",
            cause_of_death_placeholder: "إذا كان معروفًا",
            nin_label: "الرقم الوطني (NIN) *",
            nin_placeholder: "رقم NIN مكون من 14 رقمًا",
            marital_status_label: "الحالة الاجتماعية عند الوفاة *",
            select_marital_status_option: "اختر الحالة",
            status_single: "أعزب",
            status_married: "متزوج",
            status_divorced: "مطلق",
            status_widowed: "أرمل",
            occupation_label: "المهنة/الوظيفة",
            occupation_placeholder: "المهنة أو العمل",
            last_residence_label: "آخر عنوان إقامة *",
            last_residence_placeholder: "العنوان الكامل للإقامة",
            death_certificate_header: "شهادة الوفاة",
            upload_certificate_text: "رفع شهادة الوفاة",
            upload_certificate_note: "قم بتحميل صورة واضحة لشهادة الوفاة (JPG، PNG، الحد الأقصى 2 ميغابايت)",
            applicant_info_header: "معلومات مقدم الطلب",
            applicant_name_label: "اسم مقدم الطلب",
            applicant_name_placeholder: "الاسم الكامل الخاص بك",
            relationship_label: "العلاقة بالشخص المتوفى *",
            select_relationship_option: "اختر العلاقة",
            relationship_spouse: "زوج/زوجة",
            relationship_child: "ابن/ابنة",
            relationship_parent: "والد/والدة",
            relationship_sibling: "أخ/أخت",
            relationship_other_relative: "قريب آخر",
            relationship_executor: "المنفذ",
            applicant_nin_label: "رقم NIN لمقدم الطلب *",
            applicant_nin_placeholder: "رقم NIN الخاص بك المكون من 14 رقمًا",
            applicant_phone_label: "رقم الهاتف *",
            applicant_phone_placeholder: "+256 XXX XXX XXX",
            instructions_title: "تعليمات مهمة",
            instructions_step1: "أكمل كل خطوة بالترتيب",
            instructions_step2: "يجب تعبئة جميع الحقول المطلوبة (*)",
            instructions_step3: "قم بتحميل مستندات واضحة بصيغة JPG/PNG",
            instructions_step4: "يجب أن تكون القيم بالشفلنغ الأوغندي (UGX)",
            support_text: "هل تحتاج إلى مساعدة؟",
            support_link: "اتصل بالدعم",
            completed_steps_text: "0 من 4 أقسام مكتملة"

        },
        sw: {
            prev_btn: "Iliyopita",
            next_step_btn: "Hatua Ifuatayo",
            submit_btn: "Tuma Maombi",
            back_to_dashboard: "Rudi kwenye Dashibodi",
            inheritance_title: "Urithi",
            inheritance_subtitle: "Kamilisha sehemu zote 4 ili kuwasilisha dai la urithi kulingana na Sheria ya Sharia",
            application_progress_label: "Maendeleo ya Ombi",
            step4_title: "Uthibitisho wa Shariah",
            step4_subtitle: "Uthibitisho rasmi na mamlaka ya kidini",
            imam_name_label: "Jina la Imam *",
            imam_name_placeholder: "Jina kamili la Imam anayethibitisha",
            imam_reg_label: "Nambari ya Usajili wa Imam",
            imam_reg_placeholder: "Nambari rasmi ya usajili",
            mosque_name_label: "Jina la Msikiti *",
            mosque_name_placeholder: "Jina la msikiti",
            verification_date_label: "Tarehe ya Uthibitisho",
            verification_date_placeholder: "",
            verification_notes_label: "Maelezo ya Uthibitisho",
            verification_notes_placeholder: "Maelezo au maoni ya ziada...",
            declaration_label: "Tamko",
            declaration_text: "Ninaeleza hapa kwamba taarifa zote zilizotolewa kwenye maombi haya ya urithi ni sahihi na zinaaminika kadiri ilivyojulikana kwangu. Ninaelewa kuwa taarifa zisizo sahihi zinaweza kusababisha matokeo ya kisheria kulingana na Sheria ya Shariah na sheria za Uganda.",
            step_number: "3",
            step3_title: "Taarifa za Warithi",
            step3_subtitle: "Orodhesha warithi wote kulingana na sheria za urithi za Shariah",

            heirs_spouse_title: "MKE/MUME",
            spouse_name_label: "Jina la Mke/Mume (Kama linapatikana)",
            spouse_name_placeholder: "Jina kamili la mke/mume",
            spouse_nin_label: "NIN ya Mke/Mume",
            spouse_nin_placeholder: "Nambari ya NIN yenye tarakimu 14",

            heirs_children_title: "WATOTO",
            sons_count_label: "Idadi ya Wavulana *",
            daughters_count_label: "Idadi ya Wasichana *",

            heirs_parents_title: "WAZAZI",
            father_alive_label: "Baba Anaishi? *",
            father_name_label: "Jina la Baba",
            father_name_placeholder: "Ikiwa anaishi",
            mother_alive_label: "Mama Anaishi? *",
            mother_name_label: "Jina la Mama",
            mother_name_placeholder: "Ikiwa anaishi",

            heirs_siblings_title: "NDUGU",
            full_brothers_label: "Ndugu wa Kijamii",
            full_sisters_label: "Dada wa Kijamii",
            uterine_brothers_label: "Ndugu wa Kike (Iliyo na mama mmoja)",
            uterine_sisters_label: "Dada wa Kike (Iliyo na mama mmoja)",

            special_cases_title: "Hali Maalum",
            pregnant_heir_label: "Warithi Mjamzito? *",
            minor_heirs_label: "Warithi Wadogo? (Chini ya 18) *",

            yes: "Ndiyo",
            no: "Hapana",
            step_number: "2",
            step2_title: "Orodhesha na Thamani ya Mali",
            step2_subtitle: "Orodhesha mali na madeni yote ya marehemu",

            total_estate_value_label: "Jumla ya Thamani ya Mali (UGX) *",
            total_estate_value_placeholder: "Weka jumla ya thamani kwa UGX",
            total_estate_value_note: "Hii inapaswa kuwa sawa na jumla ya mali yote pungufu madeni",

            liabilities_title: "Madeni & Deni",
            outstanding_debts_label: "Madeni Yanayolipika (UGX)",
            funeral_expenses_label: "Gharama za Mazishi (UGX) *",
            unpaid_zakat_label: "Zakat Isiyolipwa (UGX)",
            other_liabilities_label: "Madeni Mengine (UGX)",

            properties_title: "Maelezo ya Mali",
            properties_instruction: "Orodhesha mali zote zilizomilikiwa na marehemu wakati wa kifo",
            add_property_btn: "Ongeza Mali Nyingine",
            remove_property_btn: "Ondoa Mali",
            property_number: "Mali",
            property_type_label: "Aina *",
            property_type_options: {
                land: "Ardhi",
                house: "Nyumba/Apartment",
                commercial: "Jengo la Kibiashara",
                agricultural: "Shamba la Kilimo",
                vehicle: "Gari",
                bank_account: "Akaunti ya Benki",
                investment: "Uwekezaji",
                jewelry: "Vito/Zahabu",
                livestock: "Mifugo",
                other: "Nyingine"
            },
            property_description_label: "Maelezo *",
            property_description_placeholder: "Mfano: nyumba ya vyumba 3, Toyota Premio",
            property_value_label: "Thamani (UGX) *",
            property_value_placeholder: "Mfano: 50000000",
            property_location_label: "Eneo",
            property_location_placeholder: "Mfano: Kampala, Kololo",
            total_properties_label: "Jumla ya Thamani ya Mali:",
            step1_title: "Maelezo ya Mafu",
            step1_subtitle: "Tafadhali toa taarifa sahihi kuhusu mtu aliyefariki",
            personal_info_header: "Taarifa Binafsi",
            deceased_name_label: "Jina Kamili la Marehemu *",
            deceased_name_placeholder: "Weka jina kamili la kisheria",
            gender_label: "Jinsia *",
            select_gender_option: "Chagua Jinsia",
            gender_male: "Mwanaume",
            gender_female: "Mwanamke",
            date_of_death_label: "Tarehe ya Kifo *",
            place_of_death_label: "Mahali pa Kifo *",
            place_of_death_placeholder: "Jiji, Wilaya, Nchi",
            cause_of_death_label: "Sababu ya Kifo",
            cause_of_death_placeholder: "Kama inajulikana",
            nin_label: "Namba ya Utambulisho (NIN) *",
            nin_placeholder: "Nambari ya NIN yenye tarakimu 14",
            marital_status_label: "Hali ya Kijamii Wakati wa Kifo *",
            select_marital_status_option: "Chagua Hali",
            status_single: "Bila Ndoa",
            status_married: "Ameolewa/Ameolewa",
            status_divorced: "Talak",
            status_widowed: "Mjane/Mjane",
            occupation_label: "Kazi/Mfumo wa Kitaaluma",
            occupation_placeholder: "Kazi au taaluma",
            last_residence_label: "Anwani ya Mwisho ya Makazi *",
            last_residence_placeholder: "Anwani kamili ya makazi",
            death_certificate_header: "Cheti cha Kifo",
            upload_certificate_text: "Pakia Cheti cha Kifo",
            upload_certificate_note: "Pakia picha wazi ya cheti cha kifo (JPG, PNG, ukubwa wa juu 2MB)",
            applicant_info_header: "Taarifa za Mwombaji",
            applicant_name_label: "Jina la Mwombaji",
            applicant_name_placeholder: "Jina lako kamili",
            relationship_label: "Uhusiano na Marehemu *",
            select_relationship_option: "Chagua Uhusiano",
            relationship_spouse: "Mke/Mume",
            relationship_child: "Mtoto",
            relationship_parent: "Mzazi",
            relationship_sibling: "Ndugu",
            relationship_other_relative: "Ndugu Mwingine",
            relationship_executor: "Mtekelezaji",
            applicant_nin_label: "NIN ya Mwombaji *",
            applicant_nin_placeholder: "Nambari yako ya NIN yenye tarakimu 14",
            applicant_phone_label: "Nambari ya Simu *",
            applicant_phone_placeholder: "+256 XXX XXX XXX",
            instructions_title: "Maelekezo Muhimu",
            instructions_step1: "Kamilisha kila hatua kwa mpangilio",
            instructions_step2: "Mashamba yote muhimu (*) lazima yajazwe",
            instructions_step3: "Pakia nyaraka zilizo wazi kwa fomati ya JPG/PNG",
            instructions_step4: "Thamani zinapaswa kuwa kwa Shilingi za Uganda (UGX)",
            support_text: "Unahitaji msaada?",
            support_link: "Wasiliana na Support",
            completed_steps_text: "0 kati ya sehemu 4 zimekamilika"
        }
    };
</script>


<div style="display: flex; min-height: 100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <!-- Left Side: Step Navigation -->
    <div
        style="flex: 0.4; background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); padding: 40px; overflow-y: auto; border-right: 1px solid #e2e8f0;">
        <div style="position: sticky; top: 0; background: transparent; padding-bottom: 20px; z-index: 10;">
            <h1 data-i18n="inheritance_title"
                style="color: #2C5C36; margin-bottom: 5px; font-size: 2rem; font-weight: 800; text-align:center;">
                Inheritance
            </h1>

            <p data-i18n="inheritance_subtitle"
                style="color: #4b5563; font-size: 14px; margin-bottom: 30px; line-height: 1.5;">
                Complete all 4 sections to submit your inheritance claim according to Shariah law
            </p>


            <!-- Progress Tracker -->
            <div
                style="margin-bottom: 40px; background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e5e7eb;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span data-i18n="application_progress_label"
                        style="font-size: 14px; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                        Application Progress
                    </span>

                    <span id="progressPercentage"
                        style="font-size: 20px; color: #2C5C36; font-weight: bold; font-family: monospace;">0%</span>
                </div>
                <div
                    style="height: 10px; background: #f3f4f6; border-radius: 5px; overflow: hidden; margin-bottom: 8px;">
                    <div id="progressBar"
                        style="height: 100%; background: linear-gradient(90deg, #2C5C36, #2C5C36); width: 0%; transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);">
                    </div>
                </div>
                <p id="completedSteps"
                    style="font-size: 13px; color: #9ca3af; margin-top: 10px; text-align: center; font-weight: 500;"
                    data-i18n="[text]completed_steps_text">
                    0 of 4 sections completed
                </p>

            </div>

            <!-- Step Indicators -->
            <!-- Step Indicators -->
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @php
                    $stepIcons = ['👤', '💰', '👨‍👩‍👧‍👦', '🕌'];
                    $stepTitles = [
                        'en' => [
                            1 => 'Deceased Person Details',
                            2 => 'Estate Inventory & Valuation',
                            3 => 'Heirs Information',
                            4 => 'Shariah Verification',
                        ],
                        'ar' => [
                            1 => 'تفاصيل الشخص المتوفى',
                            2 => 'جرد الممتلكات وتقييمها',
                            3 => 'معلومات الورثة',
                            4 => 'التحقق الشرعي',
                        ],
                        'sw' => [
                            1 => 'Maelezo ya Marehemu',
                            2 => 'Orodha na Thamani ya Mali',
                            3 => 'Taarifa za Warithi',
                            4 => 'Uthibitisho wa Shariah',
                        ],
                    ];
                @endphp

                @for ($i = 1; $i <= 4; $i++)
                    <div class="step-indicator {{ $i === 1 ? 'active' : '' }} {{ $i > 1 ? 'locked' : '' }}"
                        data-step="{{ $i }}" id="stepIndicator{{ $i }}"
                        style="display: flex; align-items: center; gap: 16px; padding: 20px; background: white; border: 2px solid #e5e7eb; border-radius: 14px; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative; backdrop-filter: blur(10px);">

                        <!-- Step Icon -->
                        <div class="step-icon"
                            style="width: 48px; height: 48px; border-radius: 12px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; transition: all 0.3s;">
                            {{ $stepIcons[$i - 1] }}
                        </div>

                        <!-- Step Info -->
                        <div style="flex: 1;">
                            <div style="font-size: 15px; font-weight: 700; color: #374151; letter-spacing: -0.2px;"
                                data-i18n="step{{ $i }}_number">
                                Step {{ $i }}
                            </div>
                            <div style="font-size: 13px; color: #9ca3af; margin-top: 4px; font-weight: 500;"
                                data-i18n="step{{ $i }}_title">
                                {{ $stepTitles['en'][$i] }}
                            </div>
                        </div>

                        <!-- Status Icon -->
                        <div class="step-status"
                            style="width: 24px; height: 24px; flex-shrink: 0; transition: all 0.3s;">
                            @if ($i === 1)
                                <svg style="color: #2C5C36; width: 100%; height: 100%;" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 8v4l3 3"></path>
                                </svg>
                            @else
                                <svg style="color: #d1d5db; width: 100%; height: 100%;" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 4.5L5 19.5"></path>
                                </svg>
                            @endif
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Instructions -->
            <div
                style="margin-top: 40px; background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%); padding: 24px; border-radius: 14px; border-left: 4px solid #2C5C36;">

                <!-- Header -->
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <div
                        style="width: 32px; height: 32px; background: #2C5C36; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 18px; height: 18px; color: white;" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <h4 style="color: #2C5C36; margin: 0; font-size: 15px; font-weight: 700;"
                        data-i18n="instructions_title">
                        Important Instructions
                    </h4>
                </div>

                <!-- Instruction List -->
                <ul style="color: #4b5563; font-size: 13px; padding-left: 24px; margin: 0; list-style-type: none;">
                    <li style="margin-bottom: 8px; position: relative; padding-left: 8px;"
                        data-i18n="instructions_step1">• Complete each step in order</li>
                    <li style="margin-bottom: 8px; position: relative; padding-left: 8px;"
                        data-i18n="instructions_step2">• All required fields (*) must be filled</li>
                    <li style="margin-bottom: 8px; position: relative; padding-left: 8px;"
                        data-i18n="instructions_step3">• Upload clear documents in JPG/PNG format</li>
                    <li style="position: relative; padding-left: 8px;" data-i18n="instructions_step4">• Values should be
                        in Ugandan Shillings (UGX)</li>
                </ul>
            </div>


            <!-- Contact Support -->
            <div
                style="margin-top: 25px; text-align: center; padding: 16px; background: rgba(30, 58, 138, 0.05); border-radius: 12px;">
                <p style="font-size: 12px; color: #6b7280; margin: 0; font-weight: 500;">
                    <span data-i18n="support_text">Need help?</span>
                    <a href="#" style="color: #2C5C36; text-decoration: none; font-weight: 600;"
                        data-i18n="support_link">Contact Support</a>
                </p>
            </div>

        </div>
    </div>

    <!-- Right Side: Form Content -->
    <div
        style="flex: 1; background: linear-gradient(180deg, #ffffff 0%, #f9fafb 100%); padding: 40px; overflow-y: auto;">
        <div
            style="position: sticky; top: 0; background: linear-gradient(180deg, #ffffff 0%, #ffffff 70%); padding-bottom: 20px; z-index: 10; border-bottom: 1px solid #e5e7eb; margin-bottom: 30px; backdrop-filter: blur(10px);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 id="currentStepTitle"
                    style="color: #2C5C36; margin: 0; font-size: 1.8rem; font-weight: 800; letter-spacing: -0.5px;"
                    data-i18n="step1_title">
                    Deceased Person Details
                </h2>
                <div id="stepCompletionStatus"
                    style="background: linear-gradient(135deg, #2C5C36, #2C5C36); padding: 8px 20px; border-radius: 20px; font-size: 14px; color: white; font-weight: 600; box-shadow: 0 2px 8px rgba(30, 58, 138, 0.2);">
                    Step <span id="currentStepNumber" style="font-weight: 800;">1</span> of 4
                </div>
            </div>
            <p id="currentStepSubtitle" style="color: #6b7280; margin: 10px 0 0 0; font-size: 15px; font-weight: 500;"
                data-i18n="step1_subtitle">
                Please provide accurate information about the deceased person
            </p>
        </div>


        <form method="POST" action="{{ route('save.inheritance.application') }}" enctype="multipart/form-data"
            id="multiStepForm">
            @csrf

            @php
                $fieldStyle =
                    'width: 100%; padding: 14px 18px; border-radius: 12px; border: 2px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.95); color: #111827; margin-top: 8px; font-size: 15px; transition: all 0.3s ease; outline: none; font-weight: 500;';
                $selectStyle =
                    $fieldStyle .
                    " appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"%23111\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M6 9l6 6 6-6\"/></svg>'); background-repeat: no-repeat; background-position: right 18px center; background-size: 16px;";
            @endphp

            <!-- Step 1: Deceased Person Details -->
            <div class="form-step active" id="step1">
                <div
                    style="background: linear-gradient(135deg, #2C5C36 0%, #2C5C36 100%); border-radius: 20px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(30, 58, 138, 0.15);">
                    <!-- Background Patterns -->
                    <div
                        style="position: absolute; top: -100px; right: -100px; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; filter: blur(20px);">
                    </div>
                    <div
                        style="position: absolute; bottom: -150px; left: -150px; width: 400px; height: 400px; background: rgba(255,255,255,0.03); border-radius: 50%; filter: blur(30px);">
                    </div>

                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div style="background: white; color: #2C5C36; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 24px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);"
                            data-i18n="step_number">1</div>
                        <div>
                            <h3 style="color: white; font-size: 1.8rem; font-weight: 800; margin: 0; letter-spacing: -0.5px;"
                                data-i18n="step1_title">Deceased Person Details</h3>
                            <p style="color: rgba(255,255,255,0.8); margin: 8px 0 0 0; font-size: 15px; font-weight: 500;"
                                data-i18n="step1_subtitle">Please provide accurate information about the deceased person
                            </p>
                        </div>
                    </div>

                    <!-- Form Grid -->
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; position: relative; z-index: 1;">

                        <!-- Personal Information Header -->
                        <div style="grid-column: 1 / -1;">
                            <h4 style="color: white; font-size: 16px; font-weight: 700; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid rgba(255,255,255,0.1);"
                                data-i18n="personal_info_header">Personal Information</h4>
                        </div>

                        <!-- Full Name -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="deceased_name_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Full
                                Name of Deceased *</label>
                            <input type="text" name="deceased_name" placeholder=""
                                data-i18n="[placeholder]deceased_name_placeholder" style="{{ $fieldStyle }}"
                                data-required="true">
                        </div>

                        <!-- Gender -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="gender_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Gender
                                *</label>
                            <select name="gender" style="{{ $selectStyle }}" data-required="true">
                                <option value="" data-i18n="select_gender_option">Select Gender</option>
                                <option value="male" data-i18n="gender_male">Male</option>
                                <option value="female" data-i18n="gender_female">Female</option>
                            </select>
                        </div>

                        <!-- Date of Death -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="date_of_death_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Date
                                of Death *</label>
                            <input type="date" name="date_of_death" style="{{ $fieldStyle }}"
                                data-required="true">
                        </div>

                        <!-- Place of Death -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="place_of_death_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Place
                                of Death *</label>
                            <input type="text" name="place_of_death" placeholder=""
                                data-i18n="[placeholder]place_of_death_placeholder" style="{{ $fieldStyle }}"
                                data-required="true">
                        </div>

                        <!-- Cause of Death -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="cause_of_death_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Cause
                                of Death</label>
                            <input type="text" name="cause_of_death" placeholder=""
                                data-i18n="[placeholder]cause_of_death_placeholder" style="{{ $fieldStyle }}"
                                data-required="false">
                        </div>

                        <!-- National ID (NIN) -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="nin_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">National
                                ID (NIN) *</label>
                            <input type="text" name="deceased_nin" placeholder=""
                                data-i18n="[placeholder]nin_placeholder" style="{{ $fieldStyle }}"
                                data-required="true" maxlength="14">
                        </div>

                        <!-- Marital Status -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="marital_status_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Marital
                                Status at Death *</label>
                            <select name="marital_status" style="{{ $selectStyle }}" data-required="true">
                                <option value="" data-i18n="select_marital_status_option">Select Status</option>
                                <option value="single" data-i18n="status_single">Single</option>
                                <option value="married" data-i18n="status_married">Married</option>
                                <option value="divorced" data-i18n="status_divorced">Divorced</option>
                                <option value="widowed" data-i18n="status_widowed">Widowed</option>
                            </select>
                        </div>

                        <!-- Occupation -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="occupation_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Occupation/Profession</label>
                            <input type="text" name="occupation" placeholder=""
                                data-i18n="[placeholder]occupation_placeholder" style="{{ $fieldStyle }}"
                                data-required="false">
                        </div>

                        <!-- Last Residence -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); grid-column: 1 / -1;">
                            <label data-i18n="last_residence_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Last
                                Residence Address *</label>
                            <textarea name="last_residence" rows="2" placeholder="" data-i18n="[placeholder]last_residence_placeholder"
                                style="{{ $fieldStyle }} min-height: 80px;" data-required="true"></textarea>
                        </div>

                        <!-- Death Certificate Upload -->
                        <div style="grid-column: 1 / -1; margin-top: 20px;">
                            <h4 data-i18n="death_certificate_header"
                                style="color: white; font-size: 16px; font-weight: 700; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid rgba(255,255,255,0.1);">
                                Death Certificate</h4>
                            <div
                                style="background: rgba(255,255,255,0.08); padding: 30px; border-radius: 16px; border: 2px dashed rgba(255,255,255,0.2); text-align: center; transition: all 0.3s;">
                                <div onclick="document.getElementById('deathCertificate').click()"
                                    style="cursor: pointer;">
                                    <div id="deathCertificatePlaceholder"
                                        style="width: 200px; height: 140px; background: rgba(255,255,255,0.1); border-radius: 12px; margin: 0 auto 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; transition: all 0.3s;">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" style="opacity: 0.7;">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                            <polyline points="7 10 12 15 17 10" />
                                            <line x1="12" y1="15" x2="12" y2="3" />
                                        </svg>
                                        <p data-i18n="upload_certificate_text"
                                            style="font-size: 14px; margin-top: 12px; font-weight: 600;">Upload Death
                                            Certificate</p>
                                    </div>
                                    <img id="deathCertificatePreview"
                                        style="display: none; width: 200px; height: 140px; object-fit: cover; border-radius: 12px; border: 3px solid white; margin: 0 auto 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.2);">
                                </div>
                                <input type="file" id="deathCertificate" name="death_certificate"
                                    accept="image/*" style="display: none;" data-required="true"
                                    onchange="previewImage(this, 'deathCertificatePreview', 'deathCertificatePlaceholder')">
                                <p data-i18n="upload_certificate_note"
                                    style="color: rgba(255,255,255,0.7); font-size: 13px; margin-top: 15px;">Upload a
                                    clear image of the death certificate (JPG, PNG, max 2MB)</p>
                            </div>
                        </div>

                        <!-- Applicant Information Header -->
                        <div style="grid-column: 1 / -1; margin-top: 30px;">
                            <h4 data-i18n="applicant_info_header"
                                style="color: white; font-size: 16px; font-weight: 700; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid rgba(255,255,255,0.1);">
                                Applicant Information</h4>
                        </div>

                        <!-- Applicant Name -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="applicant_name_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Applicant
                                Name</label>
                            <input type="text" name="applicant_name" placeholder=""
                                data-i18n="[placeholder]applicant_name_placeholder" style="{{ $fieldStyle }}"
                                data-required="true">
                        </div>

                        <!-- Relationship -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="relationship_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Relationship
                                to Deceased *</label>
                            <select name="relationship" style="{{ $selectStyle }}" data-required="true">
                                <option value="" data-i18n="select_relationship_option">Select Relationship
                                </option>
                                <option value="spouse" data-i18n="relationship_spouse">Spouse</option>
                                <option value="child" data-i18n="relationship_child">Child</option>
                                <option value="parent" data-i18n="relationship_parent">Parent</option>
                                <option value="sibling" data-i18n="relationship_sibling">Sibling</option>
                                <option value="other_relative" data-i18n="relationship_other_relative">Other Relative
                                </option>
                                <option value="executor" data-i18n="relationship_executor">Executor</option>
                            </select>
                        </div>

                        <!-- Applicant NIN -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="applicant_nin_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Applicant
                                NIN *</label>
                            <input type="text" name="applicant_nin" placeholder=""
                                data-i18n="[placeholder]applicant_nin_placeholder" style="{{ $fieldStyle }}"
                                data-required="true" maxlength="14">
                        </div>

                        <!-- Telephone -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="applicant_phone_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Telephone
                                Number *</label>
                            <input type="tel" name="applicant_phone" placeholder=""
                                data-i18n="[placeholder]applicant_phone_placeholder" style="{{ $fieldStyle }}"
                                data-required="true">
                        </div>

                    </div>
                </div>
            </div>

            <!-- Step 2: Estate Inventory & Valuation -->
            <div class="form-step" id="step2" style="display: none;">
                <div
                    style="background: linear-gradient(135deg, #2C5C36 0%, #2C5C36 100%); border-radius: 20px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(5, 150, 105, 0.15);">
                    <!-- Background Pattern -->
                    <div
                        style="position: absolute; top: -100px; right: -100px; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; filter: blur(20px);">
                    </div>

                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div style="background: white; color: #2C5C36; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 24px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);"
                            data-i18n="step_number">2
                        </div>
                        <div>
                            <h3 style="color: white; font-size: 1.8rem; font-weight: 800; margin: 0; letter-spacing: -0.5px;"
                                data-i18n="step2_title">Estate Inventory & Valuation
                            </h3>
                            <p style="color: rgba(255,255,255,0.8); margin: 8px 0 0 0; font-size: 15px; font-weight: 500;"
                                data-i18n="step2_subtitle">List all assets and liabilities of the deceased
                            </p>
                        </div>
                    </div>

                    <!-- Total Estimated Value -->
                    <div
                        style="background: rgba(255,255,255,0.1); padding: 30px; border-radius: 16px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.15); backdrop-filter: blur(10px);">
                        <h4 style="color: white; font-size: 18px; font-weight: 700; margin-bottom: 25px; display: flex; align-items: center; gap: 12px;"
                            data-i18n="total_estate_value_label">Total Estimated Estate Value (UGX) *
                        </h4>
                        <input type="number" name="total_estate_value" placeholder=""
                            data-i18n="[placeholder]total_estate_value_placeholder"
                            style="width: 100%; padding: 18px 24px; border-radius: 12px; border: 2px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.95); color: #111827; font-size: 20px; font-weight: 700; text-align: center; outline: none;"
                            data-required="true">
                        <p style="color: rgba(255,255,255,0.7); font-size: 13px; text-align: center; margin-top: 12px;"
                            data-i18n="total_estate_value_note">This should equal the sum of all properties minus
                            liabilities
                        </p>
                    </div>

                    <!-- Liabilities & Debts Section -->
                    <!-- Liabilities & Debts Section -->
                    <div
                        style="background: rgba(255,255,255,0.08); padding: 30px; border-radius: 16px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1);">
                        <h4 style="color: white; font-size: 18px; font-weight: 700; margin-bottom: 25px; display: flex; align-items: center; gap: 12px;"
                            data-i18n="liabilities_title">Liabilities & Debts
                        </h4>

                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; width: 100%; box-sizing: border-box;">
                            <!-- Outstanding Debts -->
                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08); width: 100%; box-sizing: border-box;">
                                <label data-i18n="outstanding_debts_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Outstanding
                                    Debts (UGX)</label>
                                <input type="number" name="outstanding_debts" placeholder="0"
                                    style="{{ $fieldStyle }}; width: 100%; box-sizing: border-box;"
                                    data-required="false">
                            </div>

                            <!-- Funeral Expenses -->
                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08); width: 100%; box-sizing: border-box;">
                                <label data-i18n="funeral_expenses_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Funeral
                                    Expenses (UGX) *</label>
                                <input type="number" name="funeral_expenses" placeholder="0"
                                    style="{{ $fieldStyle }}; width: 100%; box-sizing: border-box;"
                                    data-required="true">
                            </div>

                            <!-- Unpaid Zakat -->
                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08); width: 100%; box-sizing: border-box;">
                                <label data-i18n="unpaid_zakat_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Unpaid
                                    Zakat (UGX)</label>
                                <input type="number" name="unpaid_zakat" placeholder="0"
                                    style="{{ $fieldStyle }}; width: 100%; box-sizing: border-box;"
                                    data-required="false">
                            </div>

                            <!-- Other Liabilities -->
                            <div
                                style="display: flex; flex-direction column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08); width: 100%; box-sizing: border-box;">
                                <label data-i18n="other_liabilities_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Other
                                    Liabilities (UGX)</label>
                                <input type="number" name="other_liabilities" placeholder="0"
                                    style="{{ $fieldStyle }}; width: 100%; box-sizing: border-box;"
                                    data-required="false">
                            </div>
                        </div>
                    </div>

                    <!-- Property Details Section -->
                    <div
                        style="background: rgba(255,255,255,0.08); padding: 30px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                            <h4 style="color: white; font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 12px; margin: 0;"
                                data-i18n="properties_title">Property Details
                            </h4>
                           <button type="button" id="addPropertyBtn" onclick="addProperty()"
    style="background: rgba(255,255,255,0.15); color: white; border: 2px solid rgba(255,255,255,0.3); padding: 12px 24px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 8px; transition: all 0.3s;"
    data-i18n="add_property_btn">
    <i class="bx bx-plus fs-5"></i>
    Add Another Property
</button>

                        </div>

                        <p style="color: rgba(255,255,255,0.7); font-size: 14px; margin-bottom: 25px;"
                            data-i18n="properties_instruction">
                            List all properties owned by the deceased at the time of death
                        </p>

                        <!-- Properties Container -->
                        <div id="propertiesContainer">
                            <!-- Property 1 (Default) -->
                            <div class="property-item"
                                style="background: rgba(255,255,255,0.05); padding: 25px; border-radius: 14px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.1); position: relative;">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                    <h5 style="color: white; font-size: 16px; font-weight: 700; margin: 0;"
                                        data-i18n="property_number">Property 1
                                    </h5>
                                    <button type="button" class="remove-property-btn" onclick="removeProperty(this)"
                                        style="background: rgba(239, 68, 68, 0.2); color: #fecaca; border: 1px solid rgba(239, 68, 68, 0.3); width: 32px; height: 32px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 18px; transition: all 0.3s;"
                                        data-i18n="remove_property_btn">×
                                    </button>
                                </div>

                                <div
                                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                                    <!-- Property Type -->
                                    <div style="display: flex; flex-direction: column;">
                                        <label data-i18n="property_type_label"
                                            style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">
                                            Type *
                                        </label>
                                        <select name="property_type[]" class="property-type"
                                            style="{{ $selectStyle }}" data-required="true">
                                            <option value="" data-i18n="-- Select Type --">-- Select Type --
                                            </option>
                                            <option value="land" data-i18n="property_type_options.land">Land
                                            </option>
                                            <option value="house" data-i18n="property_type_options.house">
                                                House/Apartment</option>
                                            <option value="commercial" data-i18n="property_type_options.commercial">
                                                Commercial Building</option>
                                            <option value="agricultural"
                                                data-i18n="property_type_options.agricultural">Agricultural Land
                                            </option>
                                            <option value="vehicle" data-i18n="property_type_options.vehicle">Vehicle
                                            </option>
                                            <option value="bank_account"
                                                data-i18n="property_type_options.bank_account">Bank Account</option>
                                            <option value="investment" data-i18n="property_type_options.investment">
                                                Investment</option>
                                            <option value="jewelry" data-i18n="property_type_options.jewelry">
                                                Jewelry/Gold</option>
                                            <option value="livestock" data-i18n="property_type_options.livestock">
                                                Livestock</option>
                                            <option value="other" data-i18n="property_type_options.other">Other
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Description -->
                                    <div style="display: flex; flex-direction: column;">
                                        <label data-i18n="property_description_label"
                                            style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">
                                            Description *
                                        </label>
                                        <input type="text" name="property_description[]" placeholder=""
                                            data-i18n="[placeholder]property_description_placeholder"
                                            style="{{ $fieldStyle }}" data-required="true">
                                    </div>

                                    <!-- Value -->
                                    <div style="display: flex; flex-direction: column;">
                                        <label data-i18n="property_value_label"
                                            style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">
                                            Value (UGX) *
                                        </label>
                                        <input type="number" name="property_value[]" placeholder=""
                                            data-i18n="[placeholder]property_value_placeholder"
                                            style="{{ $fieldStyle }}" data-required="true">
                                    </div>

                                    <!-- Location -->
                                    <div style="display: flex; flex-direction: column;">
                                        <label data-i18n="property_location_label"
                                            style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">
                                            Location
                                        </label>
                                        <input type="text" name="property_location[]" placeholder=""
                                            data-i18n="[placeholder]property_location_placeholder"
                                            style="{{ $fieldStyle }}" data-required="false">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Properties Value -->
                        <div
                            style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 12px; margin-top: 30px; border: 1px solid rgba(255,255,255,0.15);">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span data-i18n="total_properties_label"
                                    style="color: white; font-size: 16px; font-weight: 600;">Total Properties
                                    Value:</span>
                                <span id="totalPropertiesValue"
                                    style="color: white; font-size: 24px; font-weight: 800;">UGX 0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Step 3: Heirs Information -->
            <div class="form-step" id="step3" style="display: none;">
                <div
                    style="background: linear-gradient(135deg, #2C5C36 0%, #2C5C36 100%); border-radius: 20px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(124, 58, 237, 0.15);">

                    <!-- Background Pattern -->
                    <div
                        style="position: absolute; top: -100px; left: -100px; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; filter: blur(20px);">
                    </div>

                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div style="background: white; color: #2C5C36; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 24px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);"
                            data-i18n="step_number">
                            3
                        </div>
                        <div>
                            <h3 data-i18n="step3_title"
                                style="color: white; font-size: 1.8rem; font-weight: 800; margin: 0; letter-spacing: -0.5px;">
                                Heirs Information
                            </h3>
                            <p data-i18n="step3_subtitle"
                                style="color: rgba(255,255,255,0.8); margin: 8px 0 0 0; font-size: 15px; font-weight: 500;">
                                List all heirs according to Shariah inheritance rules
                            </p>
                        </div>
                    </div>

                    <!-- SPOUSE Section -->
                    <div
                        style="background: rgba(255,255,255,0.08); padding: 30px; border-radius: 16px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1);">
                        <h4 data-i18n="heirs_spouse_title"
                            style="color: white; font-size: 18px; font-weight: 700; margin-bottom: 25px; display: flex; align-items: center; gap: 12px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" style="opacity: 0.8;">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            SPOUSE
                        </h4>

                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="spouse_name_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">
                                    Spouse Name (If applicable)
                                </label>
                                <input type="text" name="spouse_name"
                                    data-i18n-placeholder="spouse_name_placeholder" style="{{ $fieldStyle }}"
                                    data-required="false">
                            </div>

                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="spouse_nin_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">
                                    Spouse NIN
                                </label>
                                <input type="text" name="spouse_nin"
                                    data-i18n-placeholder="spouse_nin_placeholder" style="{{ $fieldStyle }}"
                                    data-required="false" maxlength="14">
                            </div>
                        </div>
                    </div>

                    <!-- CHILDREN Section -->
                    <div
                        style="background: rgba(255,255,255,0.08); padding: 30px; border-radius: 16px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1);">
                        <h4 data-i18n="heirs_children_title"
                            style="color: white; font-size: 18px; font-weight: 700; margin-bottom: 25px;">
                            CHILDREN
                        </h4>

                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="sons_count_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">
                                    Number of Sons *
                                </label>
                                <input type="number" name="sons_count" min="0" value="0"
                                    style="{{ $fieldStyle }}" data-required="true">
                            </div>

                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="daughters_count_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">
                                    Number of Daughters *
                                </label>
                                <input type="number" name="daughters_count" min="0" value="0"
                                    style="{{ $fieldStyle }}" data-required="true">
                            </div>
                        </div>
                    </div>

                    <!-- PARENTS Section -->
                    <div
                        style="background: rgba(255,255,255,0.08); padding: 30px; border-radius: 16px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1);">
                        <h4 data-i18n="heirs_parents_title"
                            style="color: white; font-size: 18px; font-weight: 700; margin-bottom: 25px;">PARENTS</h4>

                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;">
                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="father_alive_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Father
                                    Alive? *</label>
                                <select name="father_alive" data-i18n-options="yes,no" style="{{ $selectStyle }}"
                                    data-required="true">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>

                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="father_name_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Father's
                                    Name</label>
                                <input type="text" name="father_name"
                                    data-i18n-placeholder="father_name_placeholder" style="{{ $fieldStyle }}"
                                    data-required="false">
                            </div>
                        </div>

                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="mother_alive_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Mother
                                    Alive? *</label>
                                <select name="mother_alive" data-i18n-options="yes,no" style="{{ $selectStyle }}"
                                    data-required="true">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>

                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="mother_name_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Mother's
                                    Name</label>
                                <input type="text" name="mother_name"
                                    data-i18n-placeholder="mother_name_placeholder" style="{{ $fieldStyle }}"
                                    data-required="false">
                            </div>
                        </div>
                    </div>

                    <!-- SIBLINGS Section -->
                    <div
                        style="background: rgba(255,255,255,0.08); padding: 30px; border-radius: 16px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1);">
                        <h4 data-i18n="heirs_siblings_title"
                            style="color: white; font-size: 18px; font-weight: 700; margin-bottom: 25px;">SIBLINGS</h4>

                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="full_brothers_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Full
                                    Brothers</label>
                                <input type="number" name="full_brothers" min="0" value="0"
                                    style="{{ $fieldStyle }}" data-required="true">
                            </div>

                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="full_sisters_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Full
                                    Sisters</label>
                                <input type="number" name="full_sisters" min="0" value="0"
                                    style="{{ $fieldStyle }}" data-required="true">
                            </div>

                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="uterine_brothers_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Uterine
                                    Brothers (Same mother)</label>
                                <input type="number" name="uterine_brothers" min="0" value="0"
                                    style="{{ $fieldStyle }}" data-required="true">
                            </div>

                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="uterine_sisters_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Uterine
                                    Sisters (Same mother)</label>
                                <input type="number" name="uterine_sisters" min="0" value="0"
                                    style="{{ $fieldStyle }}" data-required="true">
                            </div>
                        </div>
                    </div>

                    <!-- SPECIAL CASES Section -->
                    <div
                        style="background: rgba(255,255,255,0.08); padding: 30px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
                        <h4 data-i18n="special_cases_title"
                            style="color: white; font-size: 18px; font-weight: 700; margin-bottom: 25px;">SPECIAL CASES
                        </h4>

                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="pregnant_heir_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Pregnant
                                    Heir? *</label>
                                <select name="pregnant_heir" data-i18n-options="yes,no" style="{{ $selectStyle }}"
                                    data-required="true">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>

                            <div
                                style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="minor_heirs_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Minor
                                    Heirs? (Under 18) *</label>
                                <select name="minor_heirs" data-i18n-options="yes,no" style="{{ $selectStyle }}"
                                    data-required="true">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Shariah Verification -->
            <div class="form-step" id="step4" style="display: none;">
                <div class="verification-container">
                    <!-- Background Pattern -->
                    <div class="background-pattern"></div>

                    <!-- Header -->
                    <div class="verification-header">
                        <div class="step-number" data-i18n="step_number">
                            4
                        </div>
                        <div class="header-content">
                            <h3 data-i18n="step4_title" class="step-title">
                                Shariah Verification
                            </h3>
                            <p data-i18n="step4_subtitle" class="step-subtitle">
                                Official verification by religious authority
                            </p>
                        </div>
                    </div>

                    <!-- Verification Form -->
                    <div class="verification-form">
                        <div class="form-grid">
                            <!-- Imam Name -->
                            <div class="form-field">
                                <label data-i18n="imam_name_label" class="field-label">
                                    Imam Name *
                                </label>
                                <input type="text" name="imam_name" data-i18n-placeholder="imam_name_placeholder"
                                    class="form-input" data-required="true">
                            </div>

                            <!-- Imam Registration Number -->
                            <div class="form-field">
                                <label data-i18n="imam_reg_label" class="field-label">
                                    Imam Registration Number
                                </label>
                                <input type="text" name="imam_reg_number"
                                    data-i18n-placeholder="imam_reg_placeholder" class="form-input"
                                    data-required="false">
                            </div>

                            <!-- Mosque Name -->
                            <div class="form-field">
                                <label data-i18n="mosque_name_label" class="field-label">
                                    Mosque Name *
                                </label>
                                <input type="text" name="mosque_name"
                                    data-i18n-placeholder="mosque_name_placeholder" class="form-input"
                                    data-required="true">
                            </div>

                            <!-- Verification Date -->
                            <div class="form-field">
                                <label data-i18n="verification_date_label" class="field-label">
                                    Verification Date
                                </label>
                                <input type="date" name="verification_date"
                                    data-i18n-placeholder="verification_date_placeholder" class="form-input"
                                    data-required="false">
                            </div>

                            <!-- Verification Notes -->
                            <div class="form-field full-width">
                                <label data-i18n="verification_notes_label" class="field-label">
                                    Verification Notes
                                </label>
                                <textarea name="verification_notes" rows="4" data-i18n-placeholder="verification_notes_placeholder"
                                    class="form-textarea" data-required="false"></textarea>
                            </div>
                        </div>

                        <!-- Declaration -->
                        <div class="declaration-section">
                            <div class="declaration-content">
                                <input type="checkbox" id="declaration" name="declaration"
                                    class="declaration-checkbox" data-required="true">
                                <div class="declaration-text">
                                    <label for="declaration" data-i18n="declaration_label" class="declaration-label">
                                        Declaration
                                    </label>
                                    <p data-i18n="declaration_text" class="declaration-description">
                                        I hereby declare that all information provided in this inheritance application
                                        is true and accurate to the best of my knowledge, and the marriage has been
                                        verified according to Islamic Shariah principles by the authorized Imam.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Navigation Buttons -->
<div style="display: flex; justify-content: space-between; margin-top: 40px; padding-top: 30px; border-top: 1px solid #e2e8f0;">
    <button type="button" id="prevBtn" onclick="previousStep()"
        style="padding: 16px 30px; background: #64748b; color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: 600; font-size: 16px; display: none; align-items: center; gap: 8px; transition: all 0.3s;">
        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M15 18l-6-6 6-6" />
        </svg>
        Previous
    </button>

    <div>
        <!-- Preview Button -->
        <button type="button" id="previewBtn" onclick="showPreview()"
            style="
                padding: 16px 30px;
                background: linear-gradient(135deg, #f59e0b, #d97706);
                color: white;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                font-weight: 700;
                font-size: 16px;
                display: none;
                align-items: center;
                gap: 10px;
                transition: all 0.3s;
                box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
                margin-right: 10px;
            "
            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(245, 158, 11, 0.4)'"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(245, 158, 11, 0.3)'">
            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
            Preview Application
        </button>

        <button type="button" id="nextBtn" onclick="nextStep()"
            style="padding: 16px 40px; background: linear-gradient(135deg, #2C5C36, #2C5C36); color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 10px; transition: all 0.3s; box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);">
            Next Step
            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M9 18l6-6-6-6" />
            </svg>
        </button>

        <button type="submit" id="submitBtn"
            style="padding: 16px 40px; background: linear-gradient(135deg, #2C5C36, #10b981); color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: 700; font-size: 16px; display: none; align-items: center; gap: 10px; transition: all 0.3s; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);">
            Submit Application
            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M20 6L9 17l-5-5" />
            </svg>
        </button>
    </div>
</div>
        </form>

        <!-- Preview Modal -->
<div id="previewModal"
    style="
        display: none;
        position: fixed;
        inset: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.7);
        z-index: 99999;
        justify-content: center;
        align-items: center;
        padding: 20px;
    ">

    <!-- Modal Box -->
    <div style="
        background: white;
        border-radius: 16px;
        width: 100%;
        max-width: 950px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 60px rgba(0,0,0,0.35);
    ">

        <!-- Header -->
        <div style="
            padding: 20px 25px;
            background: #2C5C36;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 16px 16px 0 0;
        ">
            <h2 style="margin: 0; font-size: 20px; font-weight: 700;">
                Application Preview
            </h2>

            <button onclick="closePreview()"
                style="
                    border: none;
                    background: transparent;
                    font-size: 28px;
                    color: white;
                    cursor: pointer;
                    padding: 0;
                    width: 30px;
                    height: 30px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                ">
                &times;
            </button>
        </div>

        <!-- Body -->
        <div id="previewContent" style="padding: 25px;">
            <!-- Dynamic Preview Will Be Inserted Here -->
        </div>

        <!-- Footer -->
        <div style="
            padding: 15px 25px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
            border-radius: 0 0 16px 16px;
        ">
            <div style="font-size: 14px; color: #64748b;">
                Review all information before submitting
            </div>
            <div style="display: flex; gap: 10px;">
                <button onclick="closePreview()"
                    style="
                        padding: 10px 18px;
                        background: #64748b;
                        color: white;
                        border: none;
                        border-radius: 8px;
                        cursor: pointer;
                        font-weight: 600;
                        transition: all 0.3s;
                    "
                    onmouseover="this.style.backgroundColor='#475569'"
                    onmouseout="this.style.backgroundColor='#64748b'">
                    Close Preview
                </button>
                {{-- <button onclick="printPreview()"
                    style="
                        padding: 10px 18px;
                        background: #2C5C36;
                        color: white;
                        border: none;
                        border-radius: 8px;
                        cursor: pointer;
                        font-weight: 600;
                        transition: all 0.3s;
                        display: flex;
                        align-items: center;
                        gap: 8px;
                    "
                    onmouseover="this.style.backgroundColor='#1f3d24'"
                    onmouseout="this.style.backgroundColor='#2C5C36'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
                        <path d="M6 14h12v8H6z"/>
                    </svg>
                    Print Preview
                </button> --}}
            </div>
        </div>

    </div>
</div>
    </div>
</div>

<style>
    /* Step indicator states */
    .step-indicator.active {
        border-color: #2C5C36 !important;
        box-shadow: 0 8px 25px rgba(30, 58, 138, 0.15);
        transform: translateY(-2px);
    }

    .step-indicator.active .step-icon {
        background: linear-gradient(135deg, #2C5C36, #2C5C36) !important;
        color: white !important;
        transform: scale(1.1);
    }

    .step-indicator.completed {
        border-color: #10b981 !important;
        background: rgba(16, 185, 129, 0.05) !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
    }

    .step-indicator.completed .step-icon {
        background: #10b981 !important;
        color: white !important;
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
        transform: none !important;
    }

    .step-indicator:not(.locked):hover {
        background: #f8fafc !important;
        border-color: #cbd5e1 !important;
        transform: translateY(-2px);
    }

    /* Status icons */
    .step-indicator.active .step-status svg {
        color: #2C5C36 !important;
    }

    .step-indicator.completed .step-status svg {
        color: #10b981 !important;
    }

    /* Form step animation */
    .form-step {
        animation: slideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Input focus styles */
    input:focus,
    select:focus,
    textarea:focus {
        border-color: #2C5C36 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
        outline: none;
    }

    /* Button hover effects */
    button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15) !important;
    }

    button:active {
        transform: translateY(0);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        div[style*="display: flex; min-height: 100vh"] {
            flex-direction: column;
        }

        div[style*="flex: 0.4"] {
            flex: none;
            max-width: 100%;
            border-right: none;
            border-bottom: 1px solid #e5e7eb;
            max-height: 60vh;
        }

        .form-step>div {
            padding: 30px !important;
        }
    }

    @media (max-width: 640px) {
        .form-step>div {
            padding: 20px !important;
        }

        button {
            padding: 12px 24px !important;
            font-size: 14px !important;
        }

        input,
        select,
        textarea {
            padding: 12px 16px !important;
        }
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    html {
        scroll-behavior: smooth;
    }

    /* Fix 2: Remove problematic overflow from background elements */
    div[style*="overflow: hidden;"]:not(.form-step > div) {
        overflow: visible !important;
    }

    /* Fix 3: Ensure form container has proper scrolling */
    div[style*="overflow-y: auto;"] {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        /* For iOS smooth scrolling */
    }

    /* Fix 4: Remove conflicting animations that might block scroll */
    .form-step {
        animation: none !important;
        /* Remove slide animation */
    }

    /* Fix 5: Better scrolling for the main containers */
    div[style*="min-height: 100vh"] {
        overflow: hidden;
    }

    /* Left navigation panel */
    div[style*="flex: 0.4;"] {
        scroll-behavior: smooth;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }

    /* Right form content panel */
    div[style*="flex: 1;"] {
        scroll-behavior: smooth;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }

    /* Fix 6: Prevent animation during scroll */
    .step-indicator,
    .form-step>div {
        transition: all 0.3s ease !important;
    }

    /* Fix 7: Add scroll padding to account for sticky headers */
    @media (max-width: 1024px) {

        div[style*="flex: 0.4;"],
        div[style*="flex: 1;"] {
            scroll-padding-top: 100px;
        }
    }

    /* Fix 8: Ensure step content is visible during scroll */
    .form-step {
        opacity: 1 !important;
        transform: none !important;
        display: block;
    }

    /* Responsive styles for inheritance application */

    /* Tablet and below (1024px) */
    @media (max-width: 1024px) {

        /* Main container layout */
        div[style*="display: flex; min-height: 100vh"] {
            flex-direction: column;
        }

        /* Left navigation panel */
        div[style*="flex: 0.4; background: linear-gradient"] {
            flex: none;
            width: 100%;
            max-width: 100%;
            border-right: none;
            border-bottom: 1px solid #e5e7eb;
            max-height: 50vh;
            padding: 30px !important;
        }

        /* Right form content */
        div[style*="flex: 1; background: linear-gradient"] {
            padding: 30px !important;
        }
    }

    /* Mobile devices (768px) */
    @media (max-width: 768px) {

        /* Header section adjustments */
        div[style*="position: sticky; top: 0; background: linear-gradient"] {
            padding-bottom: 15px !important;
            margin-bottom: 20px !important;
        }

        div[style*="position: sticky; top: 0; background: linear-gradient"]>div {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        #stepCompletionStatus {
            align-self: flex-start;
            margin-top: 5px !important;
        }

        /* Form step containers */
        .form-step>div[style*="background: linear-gradient"] {
            padding: 25px !important;
            border-radius: 16px !important;
        }

        /* Step header inside forms */
        .form-step>div>div[style*="display: flex; align-items: center; gap: 20px"] {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 30px !important;
        }

        /* Hide decorative background elements on mobile */
        .form-step>div>div[style*="position: absolute;"] {
            display: none !important;
        }

        /* Step number circle */
        .form-step>div>div[style*="display: flex; align-items: center"]>div[style*="background: white; color: #2C5C36; width: 60px; height: 60px"] {
            width: 50px !important;
            height: 50px !important;
            font-size: 20px !important;
        }

        /* Step titles */
        .form-step>div>div[style*="display: flex; align-items: center"]>div>h3 {
            font-size: 1.5rem !important;
        }

        /* Grid layouts for form fields */
        .form-step>div>div[style*="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))"],
        .form-step>div>div[style*="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))"],
        .form-step>div>div[style*="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr))"] {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)) !important;
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

        /* Property grid in step 2 */
        #step2>div>div[style*="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))"] {
            grid-template-columns: 1fr !important;
        }

        /* Property item grids */
        .property-item>div[style*="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))"] {
            grid-template-columns: 1fr !important;
        }

        /* Navigation buttons */
        div[style*="display: flex; justify-content: space-between; margin-top: 40px;"] {
            flex-direction: column;
            gap: 15px;
            margin-top: 30px !important;
            padding-top: 20px !important;
        }

        /* Button container in navigation */
        div[style*="display: flex; justify-content: space-between; margin-top: 40px;"]>div {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Button styling for mobile */
        button[style*="padding: 16px 40px"],
        button[style*="padding: 16px 32px"],
        button[style*="padding: 12px 24px"] {
            padding: 14px 20px !important;
            font-size: 15px !important;
            width: 100%;
            justify-content: center;
        }

        /* Add property button in step 2 */
        #addPropertyBtn {
            width: 100%;
            justify-content: center;
        }

        /* Death certificate upload area */
        #step1>div>div[style*="grid-column: 1 / -1; margin-top: 20px;"] {
            padding: 20px !important;
        }

        /* Death certificate placeholder */
        #deathCertificatePlaceholder {
            width: 150px !important;
            height: 100px !important;
        }

        /* Death certificate preview */
        #deathCertificatePreview {
            width: 150px !important;
            height: 100px !important;
        }
    }

    /* Small mobile devices (480px) */
    @media (max-width: 480px) {

        /* Even smaller screens */
        div[style*="flex: 1; background: linear-gradient"] {
            padding: 20px !important;
        }

        div[style*="flex: 0.4; background: linear-gradient"] {
            padding: 20px !important;
        }

        .form-step>div[style*="background: linear-gradient"] {
            padding: 20px !important;
            border-radius: 12px !important;
        }

        /* Grid layouts - single column */
        .form-step>div>div[style*="display: grid;"] {
            grid-template-columns: 1fr !important;
            gap: 12px !important;
        }

        /* All form inputs and selects */
        input[style*="width: 100%; padding: 14px 18px"],
        select[style*="width: 100%; padding: 14px 18px"],
        textarea[style*="width: 100%; padding: 14px 18px"] {
            padding: 12px 16px !important;
            font-size: 14px !important;
            border-radius: 10px !important;
        }

        /* Total estate value input */
        input[style*="width: 100%; padding: 18px 24px"] {
            padding: 14px 18px !important;
            font-size: 18px !important;
        }

        /* Form field containers padding */
        .form-step>div>div[style*="display: grid"]>div,
        .form-step>div>div[style*="display: flex; flex-direction: column"] {
            padding: 15px !important;
        }

        /* Section headers inside forms */
        .form-step>div>h4[style*="color: white; font-size: 16px"] {
            font-size: 15px !important;
        }

        /* Step titles inside forms */
        .form-step>div>div[style*="display: flex; align-items: center"]>div>h3 {
            font-size: 1.3rem !important;
        }

        /* Step subtitles */
        .form-step>div>div[style*="display: flex; align-items: center"]>div>p {
            font-size: 13px !important;
        }

        /* Instructions in left panel */
        div[style*="margin-top: 40px; background: linear-gradient"] {
            padding: 20px !important;
        }

        /* Progress bar height */
        div[style*="height: 10px; background: #f3f4f6;"] {
            height: 8px !important;
        }

        /* Property remove button */
        .remove-property-btn {
            width: 28px !important;
            height: 28px !important;
            font-size: 16px !important;
        }
    }

    /* Very small devices (360px) */
    @media (max-width: 360px) {
        .form-step>div[style*="background: linear-gradient"] {
            padding: 15px !important;
        }

        /* Step number circle */
        .form-step>div>div[style*="display: flex; align-items: center"]>div[style*="background: white; color: #2C5C36; width: 60px; height: 60px"] {
            width: 40px !important;
            height: 40px !important;
            font-size: 18px !important;
        }

        /* Form labels */
        .form-step>div>div[style*="display: grid"]>div>label,
        .form-step>div>div[style*="display: flex; flex-direction: column"]>label {
            font-size: 12px !important;
        }

        /* Textarea height */
        textarea[style*="min-height: 80px"] {
            min-height: 70px !important;
        }

        textarea[style*="min-height: 120px"] {
            min-height: 100px !important;
        }

        /* Total properties value display */
        #totalPropertiesValue {
            font-size: 20px !important;
        }
    }

    /* Fix for Safari on iOS */
    @supports (-webkit-touch-callout: none) {

        input,
        select,
        textarea {
            font-size: 16px !important;
            /* Prevent zoom on focus in iOS */
        }

        /* Fix for date inputs on iOS */
        input[type="date"] {
            min-height: 44px;
            /* Better touch target */
        }
    }

    /* Fix for horizontal scrolling */
    .form-step>div {
        overflow-x: hidden !important;
    }

    /* Ensure proper spacing on all devices */
    @media (max-width: 768px) {

        /* Remove any horizontal margins/padding causing overflow */
        .form-step>div {
            margin-left: 0 !important;
            margin-right: 0 !important;
            width: 100% !important;
        }

        /* Ensure all inputs fit within screen */
        input,
        select,
        textarea {
            max-width: 100% !important;
            box-sizing: border-box !important;
        }
    }

    /* Responsive fix for liabilities grid on small screens */
    @media (max-width: 768px) {

        /* For the liabilities grid specifically */
        #step2>div>div[style*="background: rgba(255,255,255,0.08); padding: 30px;"]>div[style*="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))"] {
            grid-template-columns: 1fr !important;
            gap: 15px !important;
            padding: 0 10px !important;
            margin: 0 auto !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        /* Each grid item */
        #step2>div>div[style*="background: rgba(255,255,255,0.08); padding: 30px;"]>div[style*="display: grid"]>div {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 15px !important;
            box-sizing: border-box !important;
        }

        /* Input fields inside */
        #step2>div>div[style*="background: rgba(255,255,255,0.08); padding: 30px;"]>div[style*="display: grid"]>div input {
            width: 100% !important;
            box-sizing: border-box !important;
            max-width: 100% !important;
        }
    }

    /* Extra small devices */
    @media (max-width: 480px) {

        /* Reduce padding on the container */
        #step2>div>div[style*="background: rgba(255,255,255,0.08); padding: 30px;"] {
            padding: 20px 15px !important;
        }

        /* Even tighter grid spacing */
        #step2>div>div[style*="background: rgba(255,255,255,0.08); padding: 30px;"]>div[style*="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))"] {
            gap: 12px !important;
            padding: 0 5px !important;
        }

        /* Smaller padding on grid items */
        #step2>div>div[style*="background: rgba(255,255,255,0.08); padding: 30px;"]>div[style*="display: grid"]>div {
            padding: 12px !important;
        }
    }

    /* Prevent horizontal overflow on the entire step 2 container */
    @media (max-width: 640px) {
        #step2>div[style*="background: linear-gradient(135deg, #2C5C36 0%, #2C5C36 100%)"] {
            padding: 25px 15px !important;
            overflow-x: hidden !important;
        }

        #step2>div>div[style*="background: rgba(255,255,255,0.08); padding: 30px;"] {
            margin-left: -5px !important;
            margin-right: -5px !important;
            width: calc(100% + 10px) !important;
        }
    }

    /* Responsive Container */
    .verification-container {
        background: linear-gradient(135deg, #2C5C36 0%, #2C5C36 100%);
        border-radius: 20px;
        padding: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(234, 88, 12, 0.15);
        margin: 20px 0;
    }

    /* Background Pattern */
    .background-pattern {
        position: absolute;
        bottom: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        filter: blur(20px);
        z-index: 0;
    }

    /* Header */
    .verification-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        position: relative;
        z-index: 1;
        flex-wrap: wrap;
    }

    .step-number {
        background: white;
        color: #2C5C36;
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 22px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        flex-shrink: 0;
    }

    .header-content {
        flex: 1;
        min-width: 200px;
    }

    .step-title {
        color: white;
        font-size: 1.6rem;
        font-weight: 800;
        margin: 0;
        letter-spacing: -0.5px;
        line-height: 1.2;
    }

    .step-subtitle {
        color: rgba(255, 255, 255, 0.8);
        margin: 8px 0 0 0;
        font-size: 14px;
        font-weight: 500;
        line-height: 1.4;
    }

    /* Verification Form */
    .verification-form {
        background: rgba(255, 255, 255, 0.08);
        padding: 25px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        position: relative;
        z-index: 1;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    /* Form Fields */
    .form-field {
        display: flex;
        flex-direction: column;
        background: rgba(255, 255, 255, 0.05);
        padding: 18px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: all 0.3s ease;
    }

    .form-field:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.15);
    }

    .form-field.full-width {
        grid-column: 1 / -1;
    }

    /* Labels */
    .field-label {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.95);
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }

    /* Inputs and Textareas */
    .form-input,
    .form-textarea {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        padding: 12px 16px;
        color: white;
        font-size: 15px;
        transition: all 0.3s ease;
        width: 100%;
        box-sizing: border-box;
    }

    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        border-color: rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
    }

    .form-input::placeholder,
    .form-textarea::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
        font-family: inherit;
    }

    /* Date input specific styling */
    input[type="date"].form-input {
        color-scheme: dark;
    }

    input[type="date"].form-input::-webkit-calendar-picker-indicator {
        filter: invert(1);
        opacity: 0.7;
        cursor: pointer;
    }

    /* Declaration Section */
    .declaration-section {
        background: rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-radius: 12px;
        margin-top: 25px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .declaration-content {
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .declaration-checkbox {
        width: 20px;
        height: 20px;
        margin-top: 3px;
        cursor: pointer;
        accent-color: #2C5C36;
        flex-shrink: 0;
    }

    .declaration-text {
        flex: 1;
    }

    .declaration-label {
        color: white;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: block;
        margin-bottom: 5px;
    }

    .declaration-description {
        color: rgba(255, 255, 255, 0.8);
        font-size: 13px;
        margin: 0;
        line-height: 1.5;
    }

    /* Responsive Breakpoints */
    @media (max-width: 768px) {
        .verification-container {
            padding: 20px;
            border-radius: 16px;
            margin: 15px 0;
        }

        .verification-header {
            gap: 15px;
            margin-bottom: 25px;
        }

        .step-number {
            width: 45px;
            height: 45px;
            font-size: 20px;
            border-radius: 12px;
        }

        .step-title {
            font-size: 1.4rem;
        }

        .step-subtitle {
            font-size: 13px;
        }

        .verification-form {
            padding: 20px;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .form-field {
            padding: 15px;
        }

        .declaration-section {
            padding: 18px;
            margin-top: 20px;
        }

        .declaration-content {
            gap: 12px;
        }
    }

    @media (max-width: 480px) {
        .verification-container {
            padding: 16px;
            border-radius: 14px;
        }

        .verification-header {
            gap: 12px;
            margin-bottom: 20px;
        }

        .step-number {
            width: 40px;
            height: 40px;
            font-size: 18px;
            border-radius: 10px;
        }

        .step-title {
            font-size: 1.2rem;
        }

        .step-subtitle {
            font-size: 12px;
        }

        .verification-form {
            padding: 16px;
        }

        .form-field {
            padding: 12px;
        }

        .form-input,
        .form-textarea {
            padding: 10px 14px;
            font-size: 14px;
        }

        .field-label {
            font-size: 12px;
        }

        .background-pattern {
            width: 150px;
            height: 150px;
            bottom: -40px;
            right: -40px;
        }

        .declaration-label {
            font-size: 13px;
        }

        .declaration-description {
            font-size: 12px;
        }
    }

    @media (min-width: 1024px) {
        .verification-container {
            padding: 45px;
        }

        .form-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .background-pattern {
            width: 300px;
            height: 300px;
            bottom: -100px;
            right: -100px;
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {

        .form-input,
        .form-textarea {
            color-scheme: dark;
        }
    }

    /* Print styles */
    @media print {
        .verification-container {
            box-shadow: none;
            background: #2C5C36 !important;
        }

        .form-input,
        .form-textarea {
            background: white !important;
            color: #333 !important;
            border: 1px solid #ccc !important;
        }

        .verification-form {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: none !important;
        }
    }
</style>

<script>
    // Mobile navigation enhancement
    function adjustNavigationForMobile() {
        const navigationContainer = document.querySelector(
            'div[style*="display: flex; justify-content: space-between; margin-top: 40px;"]');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');

        if (window.innerWidth <= 768) {
            // Create mobile-friendly navigation layout
            if (navigationContainer) {
                navigationContainer.style.cssText = `
                display: flex !important;
                flex-direction: column !important;
                gap: 15px !important;
                margin-top: 30px !important;
                padding-top: 20px !important;
            `;

                // Style all buttons for mobile
                [prevBtn, nextBtn, submitBtn].forEach(btn => {
                    if (btn) {
                        btn.style.cssText = `
                        padding: 14px 20px !important;
                        font-size: 15px !important;
                        width: 100% !important;
                        justify-content: center !important;
                        display: ${btn.style.display === 'none' ? 'none' : 'flex'} !important;
                        margin: 0 !important;
                    `;
                    }
                });
            }
        }
    }

    // Run on load and resize
    window.addEventListener('load', adjustNavigationForMobile);
    window.addEventListener('resize', adjustNavigationForMobile);

    // Add keyboard navigation for better mobile UX
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
            const activeElement = document.activeElement;
            const form = document.getElementById('multiStepForm');

            if (activeElement && form.contains(activeElement)) {
                // Find next input
                const inputs = Array.from(form.querySelectorAll('input, select, textarea'));
                const currentIndex = inputs.indexOf(activeElement);

                if (currentIndex < inputs.length - 1) {
                    inputs[currentIndex + 1].focus();
                }
            }
        }
    });

    // Auto-resize textareas on mobile
    document.addEventListener('input', function(e) {
        if (e.target.tagName === 'TEXTAREA') {
            e.target.style.height = 'auto';
            e.target.style.height = (e.target.scrollHeight) + 'px';
        }
    });

    // Fix for iOS keyboard closing
    if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
        document.addEventListener('focusout', function(e) {
            window.scrollTo(0, 0);
        });
    }

    // Touch-friendly improvements
    document.addEventListener('touchstart', function() {}, {
        passive: true
    });

    // Prevent zoom on double-tap for better mobile UX
    document.addEventListener('touchend', function(e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.tagName === 'SELECT') {
            const now = Date.now();
            if (now - (this.lastTouchEnd || 0) < 300) {
                e.preventDefault();
            }
            this.lastTouchEnd = now;
        }
    }, {
        passive: false
    });
    // Main Application Logic
    let currentStep = 1;
    const totalSteps = 4;
    const completedSteps = new Set();
    let propertyCount = 1;

    // Step data
    const stepData = {
        1: {
            title: "Deceased Person Details",
            subtitle: "Step 1 of 4: Deceased Information & Death Certificate"
        },
        2: {
            title: "Estate Inventory & Valuation",
            subtitle: "Step 2 of 4: Assets, Liabilities & Property Details"
        },
        3: {
            title: "Heirs Information",
            subtitle: "Step 3 of 4: Heirs According to Shariah Rules"
        },
        4: {
            title: "Shariah Verification",
            subtitle: "Step 4 of 4: Official Religious Authority Verification"
        }
    };

    // Initialize the application
    document.addEventListener('DOMContentLoaded', function() {
        updateUI();
        setupEventListeners();

        // Calculate initial property total
        updatePropertyTotal();
    });

    function updateUI() {
        // Update step indicators
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
                // Update status icon
                const statusIcon = indicator.querySelector('.step-status');
                if (statusIcon) {
                    statusIcon.innerHTML = `
                        <svg style="color: #10b981; width: 100%; height: 100%;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
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

        // Update form title and subtitle
        document.getElementById('currentStepTitle').textContent = stepData[currentStep].title;
        document.getElementById('currentStepSubtitle').textContent = stepData[currentStep].subtitle;
        document.getElementById('currentStepNumber').textContent = currentStep;

        // Show/hide form steps
        document.querySelectorAll('.form-step').forEach((step, index) => {
            step.style.display = (index + 1 === currentStep) ? 'block' : 'none';
        });

        // Update navigation buttons
         document.getElementById('prevBtn').style.display = currentStep > 1 ? 'flex' : 'none';
    document.getElementById('nextBtn').style.display = currentStep < totalSteps ? 'flex' : 'none';
    document.getElementById('submitBtn').style.display = currentStep === totalSteps ? 'flex' : 'none';
      document.getElementById('previewBtn').style.display = currentStep === totalSteps ? 'flex' : 'none';


        // Update progress
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
                scrollToTop();
            }
        }
    }

    function previousStep() {
        if (currentStep > 1) {
            currentStep--;
            updateUI();
            scrollToTop();
        }
    }

    function markStepAsCompleted(step) {
        completedSteps.add(step);
        if (step < totalSteps) {
            const nextIndicator = document.getElementById(`stepIndicator${step + 1}`);
            if (nextIndicator) nextIndicator.classList.remove('locked');
        }
    }

    function switchStep(step) {
        if (step === currentStep || (step > currentStep && !completedSteps.has(step))) return;

        if (step > currentStep && !validateCurrentStep()) return;

        if (step > currentStep) markStepAsCompleted(currentStep);

        currentStep = step;
        updateUI();
        scrollToTop();
    }

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Property Management Functions
    function addProperty() {
        propertyCount++;
        const propertiesContainer = document.getElementById('propertiesContainer');
        const newProperty = document.createElement('div');
        newProperty.className = 'property-item';
        newProperty.style.cssText = `
            background: rgba(255,255,255,0.05); 
            padding: 25px; 
            border-radius: 14px; 
            margin-bottom: 20px; 
            border: 1px solid rgba(255,255,255,0.1); 
            position: relative;
            animation: slideIn 0.3s ease;
        `;

        newProperty.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h5 style="color: white; font-size: 16px; font-weight: 700; margin: 0;">Property ${propertyCount}</h5>
                <button type="button" class="remove-property-btn" onclick="removeProperty(this)" 
                        style="background: rgba(239, 68, 68, 0.2); color: #fecaca; border: 1px solid rgba(239, 68, 68, 0.3); width: 32px; height: 32px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 18px; transition: all 0.3s;">
                    ×
                </button>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div style="display: flex; flex-direction: column;">
                    <label style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Type *</label>
                    <select name="property_type[]" class="property-type" style="${document.querySelector('.property-type').style.cssText}" data-required="true">
                        <option value="">-- Select Type --</option>
                        <option value="land">Land</option>
                        <option value="house">House/Apartment</option>
                        <option value="commercial">Commercial Building</option>
                        <option value="agricultural">Agricultural Land</option>
                        <option value="vehicle">Vehicle</option>
                        <option value="bank_account">Bank Account</option>
                        <option value="investment">Investment</option>
                        <option value="jewelry">Jewelry/Gold</option>
                        <option value="livestock">Livestock</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <label style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Description *</label>
                    <input type="text" name="property_description[]" placeholder="e.g., 3-bedroom house, Toyota Premio" 
                           style="${document.querySelector('input[name="property_description[]"]').style.cssText}" data-required="true">
                </div>
                <div style="display: flex; flex-direction: column;">
                    <label style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Value (UGX) *</label>
                    <input type="number" name="property_value[]" placeholder="e.g., 50000000" 
                           style="${document.querySelector('input[name="property_value[]"]').style.cssText}" data-required="true" class="property-value">
                </div>
                <div style="display: flex; flex-direction: column;">
                    <label style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Location</label>
                    <input type="text" name="property_location[]" placeholder="e.g., Kampala, Kololo" 
                           style="${document.querySelector('input[name="property_location[]"]').style.cssText}" data-required="false">
                </div>
            </div>
        `;

        propertiesContainer.appendChild(newProperty);

        // Add event listener to new property value field
        newProperty.querySelector('.property-value').addEventListener('input', updatePropertyTotal);

        // Show success message
        showToast(`Property ${propertyCount} added successfully!`);
    }

    function removeProperty(button) {
        if (propertyCount <= 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Cannot Remove',
                text: 'At least one property is required',
                confirmButtonColor: '#2C5C36'
            });
            return;
        }

        Swal.fire({
            title: 'Remove Property?',
            text: 'Are you sure you want to remove this property?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, remove it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const propertyItem = button.closest('.property-item');
                propertyItem.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    propertyItem.remove();
                    propertyCount--;
                    updatePropertyTotal();

                    // Update property numbers
                    const propertyItems = document.querySelectorAll('.property-item');
                    propertyItems.forEach((item, index) => {
                        item.querySelector('h5').textContent = `Property ${index + 1}`;
                    });

                    showToast('Property removed successfully!');
                }, 300);
            }
        });
    }

    function updatePropertyTotal() {
        const valueInputs = document.querySelectorAll('input[name="property_value[]"]');
        let total = 0;

        valueInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });

        // Format number with commas
        const formattedTotal = new Intl.NumberFormat('en-UG', {
            style: 'currency',
            currency: 'UGX',
            minimumFractionDigits: 0
        }).format(total);

        document.getElementById('totalPropertiesValue').textContent = formattedTotal;
    }

    // Image Preview Function
    function previewImage(input, previewId, placeholderId) {
        const preview = document.getElementById(previewId);
        const placeholder = document.getElementById(placeholderId);
        const file = input.files[0];

        if (!file) return;

        // Validate file type
        if (!file.type.match('image.*')) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid File',
                text: 'Please select an image file (JPG, PNG)',
                confirmButtonColor: '#ef4444'
            });
            input.value = '';
            return;
        }

        // Validate file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File Too Large',
                text: 'Maximum file size is 2MB',
                confirmButtonColor: '#ef4444'
            });
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
            showToast('Image uploaded successfully!');
        };
        reader.readAsDataURL(file);
    }

    // Validation Functions
    function validateCurrentStep() {
        const currentStepEl = document.getElementById(`step${currentStep}`);
        const requiredFields = currentStepEl.querySelectorAll('[data-required="true"]');
        let isValid = true;
        let firstInvalidField = null;

        requiredFields.forEach(field => {
            // Skip hidden fields
            // if (field.offsetParent === null) return;
            // Skip hidden fields except file inputs
            if (field.offsetParent === null && field.type !== 'file') return;


            let fieldValid = true;

            if (field.type === 'checkbox') {
                fieldValid = field.checked;
            } else if (field.type === 'file') {
                fieldValid = field.files && field.files[0];
            } else if (field.tagName === 'SELECT') {
                fieldValid = field.value.trim() !== '';
            } else {
                fieldValid = field.value.trim() !== '';
            }

            if (!fieldValid) {
                isValid = false;
                field.classList.add('is-invalid');
                field.style.borderColor = '#ef4444';
                field.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.15)';
                if (!firstInvalidField) firstInvalidField = field;
            } else {
                field.classList.remove('is-invalid');
                field.style.borderColor = field.style.borderColor.includes('255,255,255') ?
                    'rgba(255,255,255,0.1)' : '#cbd5e1';
                field.style.boxShadow = 'none';

                // Additional validation for specific fields
                // if (field.name === 'applicant_phone') {
                //     if (!validatePhoneNumber(field.value)) {
                //         isValid = false;
                //         field.classList.add('is-invalid');
                //         field.style.borderColor = '#ef4444';
                //         if (!firstInvalidField) firstInvalidField = field;
                //         showValidationError(field, 'Please enter a valid Ugandan phone number (+256 XXX XXX XXX)');
                //     }
                // }

                // if (field.name === 'deceased_nin' || field.name === 'applicant_nin') {
                //     if (!validateNIN(field.value)) {
                //         isValid = false;
                //         field.classList.add('is-invalid');
                //         field.style.borderColor = '#ef4444';
                //         if (!firstInvalidField) firstInvalidField = field;
                //         showValidationError(field, 'NIN must be 14 characters (letters and numbers)');
                //     }
                // }

                if (field.name.includes('email')) {
                    if (!validateEmail(field.value)) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        field.style.borderColor = '#ef4444';
                        if (!firstInvalidField) firstInvalidField = field;
                        showValidationError(field, 'Please enter a valid email address');
                    }
                }
            }
        });

        if (!isValid && firstInvalidField) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Form',
                html: `
                    <div style="text-align: left;">
                        <p>Please fill all required fields marked with *</p>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Check for empty required fields</li>
                            <li>Ensure file uploads are completed</li>
                            <li>Verify phone and NIN formats</li>
                        </ul>
                    </div>
                `,
                confirmButtonText: 'OK, I\'ll fix it',
                confirmButtonColor: '#2C5C36',
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

    // function validatePhoneNumber(phone) {
    //     // Ugandan phone number validation
    //     const regex = /^(\+256|256|0)?(7|3)\d{8}$/;
    //     return regex.test(phone.replace(/\s+/g, ''));
    // }

    // function validateNIN(nin) {
    //     // NIN validation (14 characters, alphanumeric)
    //     return /^[A-Z0-9]{14}$/.test(nin.toUpperCase());
    // }

    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    function showValidationError(field, message) {
        // Remove existing error message
        let existingError = field.parentNode.querySelector('.validation-error');
        if (existingError) existingError.remove();

        // Add new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'validation-error';
        errorDiv.style.cssText = `
            color: #ef4444;
            font-size: 12px;
            margin-top: 5px;
            font-weight: 500;
        `;
        errorDiv.textContent = message;
        field.parentNode.appendChild(errorDiv);
    }



    function recreateProperties(data) {
        const propertyTypes = data['property_type[]'] || [];
        const descriptions = data['property_description[]'] || [];
        const values = data['property_value[]'] || [];
        const locations = data['property_location[]'] || [];

        // Remove default property
        const defaultProperty = document.querySelector('.property-item');
        if (defaultProperty) defaultProperty.remove();

        // Create properties based on saved data
        for (let i = 0; i < propertyTypes.length; i++) {
            if (i === 0) {
                // First property already exists
                const typeSelect = document.querySelector('select[name="property_type[]"]');
                const descInput = document.querySelector('input[name="property_description[]"]');
                const valueInput = document.querySelector('input[name="property_value[]"]');
                const locationInput = document.querySelector('input[name="property_location[]"]');

                if (typeSelect) typeSelect.value = propertyTypes[i];
                if (descInput) descInput.value = descriptions[i] || '';
                if (valueInput) valueInput.value = values[i] || '';
                if (locationInput) locationInput.value = locations[i] || '';
            } else {
                // Add additional properties
                addProperty();

                // Get the newly added property
                const propertyItems = document.querySelectorAll('.property-item');
                const newProperty = propertyItems[propertyItems.length - 1];

                const typeSelect = newProperty.querySelector('select[name="property_type[]"]');
                const descInput = newProperty.querySelector('input[name="property_description[]"]');
                const valueInput = newProperty.querySelector('input[name="property_value[]"]');
                const locationInput = newProperty.querySelector('input[name="property_location[]"]');

                if (typeSelect) typeSelect.value = propertyTypes[i];
                if (descInput) descInput.value = descriptions[i] || '';
                if (valueInput) valueInput.value = values[i] || '';
                if (locationInput) locationInput.value = locations[i] || '';
            }
        }
    }

    // Form Submission
    document.getElementById('multiStepForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Validate final step
        if (!validateCurrentStep()) return;

        // Confirm submission
        Swal.fire({
            title: 'Submit Application?',
            html: `
                <div style="text-align: left; margin: 20px 0;">
                    <p style="margin-bottom: 10px;">Are you sure you want to submit this inheritance application?</p>
                    <div style="background: #f8fafc; padding: 15px; border-radius: 10px; border-left: 4px solid #2C5C36;">
                        <p style="font-weight: 600; margin: 0 0 5px 0; color: #2C5C36;">Please verify:</p>
                        <ul style="margin: 0; padding-left: 20px; font-size: 14px;">
                            <li>All information is accurate</li>
                            <li>Death certificate is attached</li>
                            <li>Property values are correct</li>
                            <li>Heirs information is complete</li>
                        </ul>
                    </div>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit now',
            cancelButtonText: 'Review again',
            confirmButtonColor: '#2C5C36',
            cancelButtonColor: '#6b7280'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Submitting...',
                    html: 'Please wait while we process your application',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Prepare form data
                const form = document.getElementById('multiStepForm');
                const formData = new FormData(form);

                // Submit via AJAX
                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                ?.content || ''
                        }
                    })
                    .then(async response => {
                        if (!response.ok) {
                            // 🔥 SHOW CONTROLLER OUTPUT (dd, dump, errors)
                            const text = await response.text();
                            document.body.innerHTML = text;
                            return;
                        }

                        // if (!response.ok) {
                        //     const errorData = await response.json();

                        //     // 🔴 CLOSE LOADING ALERT
                        //     Swal.close();

                        //     let errorList = '<ul style="text-align:left">';
                        //     if (errorData.errors) {
                        //         Object.values(errorData.errors).forEach(messages => {
                        //             messages.forEach(msg => {
                        //                 errorList += `<li>${msg}</li>`;
                        //             });
                        //         });
                        //     } else if (errorData.message) {
                        //         errorList += `<li>${errorData.message}</li>`;
                        //     }
                        //     errorList += '</ul>';

                        //     Swal.fire({
                        //         icon: 'error',
                        //         title: 'Submission Error',
                        //         html: errorList,
                        //         confirmButtonColor: '#2C5C36'
                        //     });

                        //     return;
                        // }

                        const data = await response.json();

                        if (data.success) {
                            // ✅ SUCCESS BLOCK (unchanged)
                            Swal.fire({
                                icon: 'success',
                                title: 'Application Submitted!',
                                html: `
    <div style="text-align: center; padding: 24px;">
        <!-- Success Icon -->
        <div style="
            width: 64px;
            height: 64px;
            background: #059568;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px auto;
        ">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3">
                <path d="M20 6L9 17L4 12" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        
        <h3 style="color: #059568; margin-bottom: 8px;">Success!</h3>
        <p style="color: #6b7280; margin-bottom: 32px;">
            Your inheritance application has been submitted successfully.
        </p>
        
        <!-- Reference Card -->
        <div style="
            margin: 32px 0 0 0;
            padding: 20px;
            background: #f8fafc;
            border-radius: 10px;
            border-left: 4px solid #059580;
        ">
            <h3 style="
                color: #059580;
                margin: 0;
                font-weight: 700;
                font-size: 1.5rem;
                font-family: monospace;
            ">
                ${data.reference || 'N/A'}
            </h3>
            <p style="color: #64748b; font-size: 13px; margin-top: 8px; margin-bottom: 0;">
                Save this reference number for future inquiries
            </p>
        </div>
    </div>
`,
                                confirmButtonText: 'Continue',
                                confirmButtonColor: '#2C5C36'
                            }).then(() => {
                                localStorage.removeItem('inheritanceApplicationDraft');
                                if (data.redirect_url) {
                                    window.location.href = data.redirect_url;
                                }
                            });
                        } else {
                            throw new Error(data.message || 'Submission failed');
                        }
                    })
                    .catch(error => {
                        // ❌ Only network-level errors reach here
                        console.error(error);
                    });
            }
        });
    });

    // Setup event listeners
    function setupEventListeners() {
        // Step indicator clicks
        for (let i = 1; i <= totalSteps; i++) {
            const indicator = document.getElementById(`stepIndicator${i}`);
            if (indicator) {
                indicator.addEventListener('click', function() {
                    if (!this.classList.contains('locked')) {
                        switchStep(i);
                    }
                });
            }
        }

        // Auto-save on input
        const form = document.getElementById('multiStepForm');
        let saveTimeout;
        // form.addEventListener('input', function() {
        //     clearTimeout(saveTimeout);
        //     saveTimeout = setTimeout(() => {
        //         saveDraft();
        //     }, 2000);
        // });

        // Property value change listeners
        document.addEventListener('input', function(e) {
            if (e.target.name === 'property_value[]') {
                updatePropertyTotal();
            }
        });

        // Input validation on blur
        document.addEventListener('blur', function(e) {
            if (e.target.dataset.required === 'true') {
                validateField(e.target);
            }
        }, true);
    }

    function validateField(field) {
        if (!field.value.trim() && field.dataset.required === 'true') {
            field.classList.add('is-invalid');
            field.style.borderColor = '#ef4444';
        } else {
            field.classList.remove('is-invalid');
            field.style.borderColor = field.style.borderColor.includes('255,255,255') ?
                'rgba(255,255,255,0.1)' : '#cbd5e1';
        }
    }

    // Toast notification
    function showToast(message) {
        // Remove existing toast
        const existingToast = document.querySelector('.custom-toast');
        if (existingToast) existingToast.remove();

        // Create toast
        const toast = document.createElement('div');
        toast.className = 'custom-toast';
        toast.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #2C5C36;
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(30, 58, 138, 0.3);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            animation: toastIn 0.3s ease;
        `;

        toast.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M20 6L9 17l-5-5"/>
            </svg>
            <span>${message}</span>
        `;

        document.body.appendChild(toast);

        // Remove after 3 seconds
        setTimeout(() => {
            toast.style.animation = 'toastOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(-20px);
            }
        }
        
        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes toastOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(20px);
            }
        }
        
        .is-invalid {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15) !important;
        }
        
        .validation-error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 5px;
            font-weight: 500;
        }
    `;
    document.head.appendChild(style);

    // Preview Modal Functions
function showPreview() {
    const modal = document.getElementById("previewModal");
    
    // Show the modal
    modal.style.display = "flex";
    document.body.style.overflow = 'hidden'; // Prevent scrolling
    
    // Build Preview Content...
    const form = document.getElementById("multiStepForm");
    const formData = new FormData(form);
    
    let html = `
        <div style="
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        ">
    `;
    
    // Group data by step for better organization
    const stepCategories = {
        'Deceased Details': ['deceased_name', 'deceased_id_number', 'date_of_death', 'place_of_death', 'death_certificate_number'],
        'Estate Information': ['total_properties', 'total_assets_value', 'total_liabilities', 'net_estate_value'],
        'Heirs Information': ['heir_name_', 'heir_relationship_', 'heir_share_'],
        'Shariah Verification': ['shariah_authority_name', 'shariah_authority_title', 'verification_date']
    };
    
    // Add header
    html = `
        <div style="margin-bottom: 25px;">
            <h3 style="color: #2C5C36; margin: 0 0 10px 0; font-size: 18px;">
                Estate Distribution Application Summary
            </h3>
            <p style="color: #64748b; margin: 0; font-size: 14px;">
                Review all information below before submitting your application
            </p>
        </div>
        ${html}
    `;
    
    // Process form data
    formData.forEach((value, key) => {
        if (value instanceof File) return;
        if (!value || value.trim() === "") return;
        
        // Skip system fields
        if (key.startsWith('_') || key === 'csrf_token') return;
        
        // Format key for display
        const displayKey = key
            .replace(/_/g, ' ')
            .replace(/\b\w/g, l => l.toUpperCase());
        
        // Format value
        let displayValue = value;
        if (key.includes('date')) {
            displayValue = new Date(value).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
        if (key.includes('value') || key.includes('amount')) {
            displayValue = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(value);
        }
        
        html += `
            <div style="
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 18px;
                transition: all 0.3s;
            "
            onmouseover="this.style.borderColor='#cbd5e1'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.05)'"
            onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                <p style="font-size: 12px; font-weight: 600; color: #64748b; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    ${displayKey}
                </p>
                <p style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">
                    ${displayValue}
                </p>
            </div>
        `;
    });
    
    html += `</div>`;
    
    // Add summary section
    html += `
        <div style="
            margin-top: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border-radius: 12px;
            border-left: 4px solid #2C5C36;
        ">
            <h4 style="color: #2C5C36; margin: 0 0 10px 0; font-size: 16px;">
                Application Summary
            </h4>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                <div>
                    <p style="font-size: 12px; color: #64748b; margin: 0;">Total Steps Completed</p>
                    <p style="font-size: 20px; font-weight: 700; color: #2C5C36; margin: 5px 0 0 0;">
                        ${completedSteps.size} of ${totalSteps}
                    </p>
                </div>
                <div>
                    <p style="font-size: 12px; color: #64748b; margin: 0;">Current Status</p>
                    <p style="font-size: 20px; font-weight: 700; color: #2C5C36; margin: 5px 0 0 0;">
                        ${currentStep === totalSteps ? 'Ready to Submit' : 'In Progress'}
                    </p>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById("previewContent").innerHTML = html;
    
    // Scroll to top of modal content
    document.getElementById("previewContent").scrollTop = 0;
}

function closePreview() {
    document.getElementById("previewModal").style.display = "none";
    document.body.style.overflow = 'auto'; // Restore scrolling
}

function printPreview() {
    const printContent = document.getElementById("previewContent").innerHTML;
    const originalContent = document.body.innerHTML;
    
    document.body.innerHTML = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Application Preview</title>
            <style>
                @media print {
                    body { margin: 0; padding: 20px; }
                    .no-print { display: none !important; }
                    h1, h2, h3 { color: #000 !important; }
                    .summary-box { 
                        border: 1px solid #ddd !important;
                        background: #f9f9f9 !important;
                    }
                }
                body { font-family: Arial, sans-serif; }
                .section { margin-bottom: 20px; }
                .field { margin-bottom: 10px; }
                .field-label { font-weight: bold; color: #333; }
                .field-value { margin-left: 10px; }
            </style>
        </head>
        <body>
            <h1 style="color: #2C5C36; text-align: center; margin-bottom: 30px;">
                Estate Distribution Application - Preview
            </h1>
            ${printContent}
            <div class="no-print" style="margin-top: 30px; text-align: center; font-style: italic; color: #666;">
                Printed on ${new Date().toLocaleDateString()} at ${new Date().toLocaleTimeString()}
            </div>
        </body>
        </html>
    `;
    
    window.print();
    document.body.innerHTML = originalContent;
    updateUI(); // Restore the UI
}

// Add these event listeners after your existing JavaScript functions

// Close modal when clicking outside content
document.getElementById('previewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePreview();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && document.getElementById('previewModal').style.display === 'flex') {
        closePreview();
    }
});

// Prevent form submission when preview modal is open
document.getElementById('multiStepForm').addEventListener('submit', function(e) {
    if (document.getElementById('previewModal').style.display === 'flex') {
        e.preventDefault();
        closePreview();
        return false;
    }
});

// Also update your mobile navigation function to include the preview button
function adjustNavigationForMobile() {
    const navigationContainer = document.querySelector(
        'div[style*="display: flex; justify-content: space-between; margin-top: 40px;"]');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    const previewBtn = document.getElementById('previewBtn'); // Add this line

    if (window.innerWidth <= 768) {
        // Create mobile-friendly navigation layout
        if (navigationContainer) {
            navigationContainer.style.cssText = `
            display: flex !important;
            flex-direction: column !important;
            gap: 15px !important;
            margin-top: 30px !important;
            padding-top: 20px !important;
        `;

            // Style all buttons for mobile (update to include previewBtn)
            [prevBtn, nextBtn, submitBtn, previewBtn].forEach(btn => {
                if (btn) {
                    btn.style.cssText = `
                    padding: 14px 20px !important;
                    font-size: 15px !important;
                    width: 100% !important;
                    justify-content: center !important;
                    display: ${btn.style.display === 'none' ? 'none' : 'flex'} !important;
                    margin: 0 !important;
                    box-shadow: none !important;
                `;
                }
            });
            
            // Adjust the inner button container
            const innerContainer = navigationContainer.querySelector('div');
            if (innerContainer) {
                innerContainer.style.cssText = `
                    display: flex !important;
                    flex-direction: column !important;
                    gap: 15px !important;
                    width: 100% !important;
                `;
            }
        }
    }
}
</script>

<style>
    /* Modal Styles */
#previewModal {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Modal content animations */
#previewModal > div {
    animation: slideUp 0.4s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Mobile responsive for modal */
@media (max-width: 768px) {
    #previewModal {
        padding: 10px !important;
    }
    
    #previewModal > div {
        max-height: 95vh !important;
        max-width: 100% !important;
    }
    
    #previewContent {
        padding: 15px !important;
    }
    
    #previewContent > div[style*="grid-template-columns"] {
        grid-template-columns: 1fr !important;
    }
    
    .modal-footer {
        flex-direction: column !important;
        gap: 10px !important;
    }
    
    .modal-footer button {
        width: 100% !important;
    }
}
</style>
@include('layouts.form-footers')
