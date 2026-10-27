@include('layouts.form-headers')

<script>
    const translations = {
        en: {
            select_relationship_type: "-- Select Relationship --",
            back_to_dashboard: "Back to Dashboard",
            application_progress_label: "Application Progress",
            completed_steps_text: "0 of 4 sections completed",
            prev_btn: "Previous",
            ward_step_title: "Guardianship Application",
            ward_step_subtitle: "Complete all 4 sections to apply for legal guardianship according to Shariah law",
            step_text: "Step",
            of_text: "of",
            step1_title: "Ward (Majhour) Details",
            step2_title: "Parental Information",
            step3_title: "Guardian Applicant Details",
            step4_title: "Guardianship Terms",
            instructions_title: "Important Instructions",
            instructions_step1: "• Complete each step in order",
            instructions_step2: "• All required fields (*) must be filled",
            instructions_step3: "• Upload clear documents in JPG/PNG format",
            instructions_step4: "• Provide accurate parental information",
            ward_name_label: "Full Name of Ward *",
            ward_gender_label: "Gender *",
            ward_dob_label: "Date of Birth *",
            ward_age_label: "Age *",
            birth_certificate_label: "Birth Certificate Number",
            ward_type_label: "Type of Ward *",
            guardianship_type_label: "Type of Guardianship *",
            health_conditions_label: "Any Health Conditions",
            education_level_label: "Education Level",
            ward_photo_label: "Ward Photograph *",
            // Placeholders
            ward_name_placeholder: "Enter full legal name",
            ward_age_placeholder: "Will be auto-calculated",
            birth_certificate_placeholder: "If available",
            health_conditions_placeholder: "Describe any known health conditions or special needs",
            // Select Options
            select_gender: "Select Gender",
            male: "Male",
            female: "Female",
            select_ward_type: "-- Select Type --",
            orphan: "Orphan (Both parents deceased)",
            abandoned: "Abandoned/Foundling",
            special_needs: "Special Needs/Incapacitated",
            normal: "Normal (Parents alive but need guardian)",
            select_guardianship_type: "-- Select Type --",
            minor: "Guardianship of Minor",
            incapacitated: "Guardianship of Incapacitated Adult",
            testamentary: "Testamentary Guardianship (by will)",
            emergency: "Emergency Guardianship",
            select_education_level: "-- Select --",
            none: "Not in School",
            nursery: "Nursery School",
            primary: "Primary School",
            secondary: "Secondary School",
            vocational: "Vocational Training",
            university: "University",
            upload_photo_text: "Upload Ward Photo",
            upload_photo_note: "Upload a clear passport photo of the ward (JPG, PNG, max 2MB)",
            // Step 2 specific translations
            step2_title: "Parental/Biographical Information",
            step2_description: "Information about the ward's biological parents",
            father_info: "FATHER'S INFORMATION",
            father_name_label: "Father's Full Name *",
            father_name_placeholder: "Enter father's full name",
            father_status_label: "Father's Status *",
            mother_info: "MOTHER'S INFORMATION",
            mother_name_label: "Mother's Full Name",
            mother_name_placeholder: "Enter mother's full name",
            mother_status_label: "Mother's Status *",
            birth_certificate_title: "BIRTH CERTIFICATE",
            upload_birth_cert: "Upload Birth Certificate",
            birth_cert_description: "Upload a clear image of the birth certificate (JPG, PNG, max 2MB)",
            select_status: "-- Select Status --",
            alive: "Alive",
            deceased: "Deceased",
            unknown: "Unknown",
            incapacitated: "Incapacitated",
            step3_title: "Guardian (Wali) Applicant Details",
            step3_description: "Information about the prospective guardian",
            personal_info_title: "PERSONAL INFORMATION",
            guardian_name_label: "Full Name *",
            guardian_name_placeholder: "Guardian's full name",
            guardian_gender_label: "Gender",
            guardian_dob_label: "Date of Birth *",
            guardian_nin_label: "National ID (NIN) *",
            guardian_nin_placeholder: "14-digit NIN",
            relationship_label: "Relationship to Ward *",
            select_relationship: "-- Select Relationship --",
            father_rel: "Father",
            mother_rel: "Mother",
            paternal_grandfather: "Paternal Grandfather",
            paternal_grandmother: "Paternal Grandmother",
            maternal_grandfather: "Maternal Grandfather",
            maternal_grandmother: "Maternal Grandmother",
            paternal_uncle: "Paternal Uncle",
            maternal_uncle: "Maternal Uncle",
            brother_rel: "Brother",
            sister_rel: "Sister",
            aunt_rel: "Aunt",
            nephew_rel: "Nephew",
            other_relative: "Other Relative",
            family_friend: "Family Friend",
            court_appointed: "Court Appointed",
            marital_status_label: "Marital Status",
            select_marital_status: "-- Select --",
            single: "Single",
            married: "Married",
            divorced: "Divorced",
            widowed: "Widowed",
            occupation_label: "Occupation *",
            occupation_placeholder: "Current occupation",
            phone_label: "Telephone Number *",
            phone_placeholder: "+256 XXX XXX XXX",
            address_label: "Residential Address *",
            address_placeholder: "Complete residential address",

            assessment_title: "GUARDIAN ASSESSMENT",
            experience_label: "Previous Guardianship Experience (if any)",
            experience_placeholder: "Describe any previous guardianship or childcare experience",
            criminal_record_label: "Criminal Record? *",
            select_criminal_record: "Select",
            yes: "Yes",
            no: "No",
            health_status_label: "Health Status",
            health_status_placeholder: "General health condition",
            religious_background_label: "Religious Knowledge/Background",
            religious_background_placeholder: "Describe religious knowledge and practice",
            motivation_label: "Motivation for Guardianship *",
            motivation_placeholder: "Explain why you want to be the guardian",

            guardian_photo_title: "GUARDIAN PHOTOGRAPH *",
            upload_guardian_photo: "Upload Guardian Photo",
            guardian_photo_description: "Upload a clear passport photo of the guardian (JPG, PNG, max 2MB)",
            step4_title: "Guardianship Terms & Verification",
            step4_description: "Terms of guardianship and official verification",
            duration_title: "DURATION",
            duration_label: "Duration *",
            select_duration: "-- Select --",
            until_majority: "Until Ward Reaches Majority (18 years)",
            specific_period: "Specific Period",
            indefinite: "Indefinite (for incapacitated adults)",
            reporting_frequency_label: "Reporting Frequency",
            select_reporting: "-- Select --",
            monthly: "Monthly",
            quarterly: "Quarterly",
            annually: "Annually",
            no_reporting: "No Regular Reporting",

            powers_title: "POWERS GRANTED TO GUARDIAN *",
            financial_power: "Financial Decisions",
            medical_power: "Medical Decisions",
            educational_power: "Educational Decisions",
            travel_power: "Travel Permissions",
            marriage_power: "Marriage Consent (for female wards)",
            powers_note: "Select all applicable powers to be granted to the guardian",

            restrictions_title: "RESTRICTIONS/LIMITATIONS",
            restrictions_placeholder: "Describe any restrictions or limitations on the guardian's powers...",

            shariah_title: "SHARIAH VERIFICATION",
            imam_name_label: "Imam Name *",
            imam_name_placeholder: "Verifying Imam's name",
            imam_reg_label: "Imam Registration Number *",
            imam_reg_placeholder: "Official registration number",
            mosque_name_label: "Mosque Name *",
            mosque_name_placeholder: "Name of mosque",
            verification_date_label: "Verification Date *",

            witnesses_title: "WITNESSES",
            witness1_subtitle: "Witness 1",
            witness1_name_label: "Witness 1 Name *",
            witness1_nin_label: "Witness 1 NIN *",
            witness2_subtitle: "Witness 2",
            witness2_name_label: "Witness 2 Name *",
            witness2_nin_label: "Witness 2 NIN *",
            witness_name_placeholder: "Full name of witness",
            witness_nin_placeholder: "14-digit NIN",
            prev_btn: "Previous",
            next_btn: "Next Step",
            submit_btn: "Submit Application"
        },
        ar: {
            select_relationship_type: "-- اختر العلاقة --",
            back_to_dashboard: "العودة إلى لوحة التحكم",
            application_progress_label: "تقدم الطلب",
            completed_steps_text: "0 من 4 أقسام مكتملة",
            prev_btn: "السابق",
            ward_step_title: "تفاصيل الوصي (مجهول الهوية)",
            ward_step_subtitle: "الخطوة 1 من 4: معلومات الوصي والصورة",
            step_text: "الخطوة",
            of_text: "من",
            step1_title: "تفاصيل الوصي (المجهول)",
            step2_title: "معلومات الوالدين",
            step3_title: "تفاصيل مقدم طلب الوصاية",
            step4_title: "شروط الوصاية",
            instructions_title: "تعليمات مهمة",
            instructions_step1: "• أكمل كل خطوة بالترتيب",
            instructions_step2: "• يجب تعبئة جميع الحقول المطلوبة (*)",
            instructions_step3: "• قم بتحميل مستندات واضحة بصيغة JPG/PNG",
            instructions_step4: "• قدم معلومات دقيقة عن الوالدين",
            ward_name_label: "الاسم الكامل للقاصر *",
            ward_gender_label: "الجنس *",
            ward_dob_label: "تاريخ الميلاد *",
            ward_age_label: "العمر *",
            birth_certificate_label: "رقم شهادة الميلاد",
            ward_type_label: "نوع القاصر *",
            guardianship_type_label: "نوع الوصاية *",
            health_conditions_label: "أي حالات صحية",
            education_level_label: "المستوى التعليمي",
            ward_photo_label: "صورة القاصر *",
            // Placeholders
            ward_name_placeholder: "أدخل الاسم القانوني الكامل",
            ward_age_placeholder: "سيتم حسابه تلقائيًا",
            birth_certificate_placeholder: "إذا كانت متوفرة",
            health_conditions_placeholder: "صف أي حالات صحية أو احتياجات خاصة معروفة",
            // Select Options
            select_gender: "اختر الجنس",
            male: "ذكر",
            female: "أنثى",
            select_ward_type: "-- اختر النوع --",
            orphan: "يتيم (وفاة كلا الوالدين)",
            abandoned: "مهجور / وجدت طفل",
            special_needs: "احتياجات خاصة / عاجز",
            normal: "طبيعي (الوالدان على قيد الحياة ولكن يحتاج إلى وصي)",
            select_guardianship_type: "-- اختر النوع --",
            minor: "وصاية على قاصر",
            incapacitated: "وصاية على بالغ عاجز",
            testamentary: "وصاية بموجب الوصية",
            emergency: "وصاية طارئة",
            select_education_level: "-- اختر --",
            none: "ليس في المدرسة",
            nursery: "روضة أطفال",
            primary: "المدرسة الابتدائية",
            secondary: "المدرسة الثانوية",
            vocational: "تدريب مهني",
            university: "جامعة",
            upload_photo_text: "رفع صورة القاصر",
            upload_photo_note: "قم بتحميل صورة جواز سفر واضحة للقاصر (JPG، PNG، الحد الأقصى 2MB)",
            step2_title: "معلومات الوالدين",
            step2_description: "معلومات عن والدي القاصر",
            father_info: "معلومات الأب",
            father_name_label: "اسم الأب الكامل *",
            father_name_placeholder: "أدخل اسم الأب الكامل",
            father_status_label: "حالة الأب *",
            mother_info: "معلومات الأم",
            mother_name_label: "اسم الأم الكامل",
            mother_name_placeholder: "أدخل اسم الأم الكامل",
            mother_status_label: "حالة الأم *",
            birth_certificate_title: "شهادة الميلاد",
            upload_birth_cert: "رفع شهادة الميلاد",
            birth_cert_description: "قم بتحميل صورة واضحة لشهادة الميلاد (JPG، PNG، الحد الأقصى 2MB)",
            select_status: "-- اختر الحالة --",
            alive: "على قيد الحياة",
            deceased: "متوفى",
            unknown: "غير معروف",
            incapacitated: "عاجز",
            step3_title: "تفاصيل مقدم طلب الوصاية (ولي)",
            step3_description: "معلومات عن الوصي المرشح",
            personal_info_title: "المعلومات الشخصية",
            guardian_name_label: "الاسم الكامل *",
            guardian_name_placeholder: "الاسم الكامل للوصي",
            guardian_gender_label: "الجنس",
            guardian_dob_label: "تاريخ الميلاد *",
            guardian_nin_label: "الهوية الوطنية (NIN) *",
            guardian_nin_placeholder: "14 رقم الهوية الوطنية",
            relationship_label: "العلاقة بالقاصر *",
            select_relationship: "-- اختر العلاقة --",
            father_rel: "الأب",
            mother_rel: "الأم",
            paternal_grandfather: "الجد الأبوي",
            paternal_grandmother: "الجدة الأبوية",
            maternal_grandfather: "الجد الأمومي",
            maternal_grandmother: "الجدة الأمومية",
            paternal_uncle: "العم الأبوي",
            maternal_uncle: "العم الأمومي",
            brother_rel: "الأخ",
            sister_rel: "الأخت",
            aunt_rel: "العمة/الخالة",
            nephew_rel: "ابن الأخ/الأخت",
            other_relative: "قريب آخر",
            family_friend: "صديق العائلة",
            court_appointed: "مُعيّن من المحكمة",
            marital_status_label: "الحالة الاجتماعية",
            select_marital_status: "-- اختر --",
            single: "أعزب",
            married: "متزوج",
            divorced: "مطلق",
            widowed: "أرمل",
            occupation_label: "المهنة *",
            occupation_placeholder: "المهنة الحالية",
            phone_label: "رقم الهاتف *",
            phone_placeholder: "+256 XXX XXX XXX",
            address_label: "العنوان السكني *",
            address_placeholder: "العنوان السكني الكامل",

            assessment_title: "تقييم الوصي",
            experience_label: "خبرة الوصاية السابقة (إن وجدت)",
            experience_placeholder: "صف أي خبرة سابقة في الوصاية أو رعاية الأطفال",
            criminal_record_label: "سجل جنائي؟ *",
            select_criminal_record: "اختر",
            yes: "نعم",
            no: "لا",
            health_status_label: "الحالة الصحية",
            health_status_placeholder: "الحالة الصحية العامة",
            religious_background_label: "المعرفة الدينية/الخلفية",
            religious_background_placeholder: "صف المعرفة والممارسة الدينية",
            motivation_label: "الدافع للوصاية *",
            motivation_placeholder: "اشرح سبب رغبتك في أن تكون الوصي",

            guardian_photo_title: "صورة الوصي *",
            upload_guardian_photo: "رفع صورة الوصي",
            guardian_photo_description: "قم بتحميل صورة جواز سفر واضحة للوصي (JPG، PNG، الحد الأقصى 2MB)",
            step4_title: "شروط الوصاية والتحقق",
            step4_description: "شروط الوصاية والتحقق الرسمي",
            duration_title: "المدة",
            duration_label: "المدة *",
            select_duration: "-- اختر --",
            until_majority: "حتى يصل القاصر إلى سن الرشد (18 سنة)",
            specific_period: "فترة محددة",
            indefinite: "غير محددة (للبالغين العاجزين)",
            reporting_frequency_label: "تردد التقرير",
            select_reporting: "-- اختر --",
            monthly: "شهريًا",
            quarterly: "ربع سنوي",
            annually: "سنويًا",
            no_reporting: "لا توجد تقارير منتظمة",

            powers_title: "الصلاحيات الممنوحة للوصي *",
            financial_power: "القرارات المالية",
            medical_power: "القرارات الطبية",
            educational_power: "القرارات التعليمية",
            travel_power: "أذونات السفر",
            marriage_power: "موافقة الزواج (للقاصرات)",
            powers_note: "حدد جميع الصلاحيات المطبقة الممنوحة للوصي",

            restrictions_title: "القيود/الحدود",
            restrictions_placeholder: "صف أي قيود أو حدود على صلاحيات الوصي...",

            shariah_title: "التحقق الشرعي",
            imam_name_label: "اسم الإمام *",
            imam_name_placeholder: "اسم الإمام المُحقق",
            imam_reg_label: "رقم تسجيل الإمام *",
            imam_reg_placeholder: "رقم التسجيل الرسمي",
            mosque_name_label: "اسم المسجد *",
            mosque_name_placeholder: "اسم المسجد",
            verification_date_label: "تاريخ التحقق *",

            witnesses_title: "الشهود",
            witness1_subtitle: "الشاهد 1",
            witness1_name_label: "اسم الشاهد 1 *",
            witness1_nin_label: "رقم هوية الشاهد 1 *",
            witness2_subtitle: "الشاهد 2",
            witness2_name_label: "اسم الشاهد 2 *",
            witness2_nin_label: "رقم هوية الشاهد 2 *",
            witness_name_placeholder: "الاسم الكامل للشاهد",
            witness_nin_placeholder: "14 رقم الهوية الوطنية",
            prev_btn: "السابق",
            next_btn: "الخطوة التالية",
            submit_btn: "إرسال الطلب"
        },
        sw: {
            select_relationship_type: "-- Chagua Uhusiano --",
            upload_photo_text: "Pakia Picha ya Mlezwa",
            upload_photo_note: "Pakia picha wazi ya pasipoti ya mlezwa (JPG, PNG, upeo 2MB)",
            back_to_dashboard: "Rudi kwenye Dashibodi",
            application_progress_label: "Maendeleo ya Maombi",
            completed_steps_text: "0 kati ya sehemu 4 zimekamilika",
            prev_btn: "Iliyopita",
            ward_step_title: "Maelezo ya Mlezi (Majhūr)",
            ward_step_subtitle: "Hatua ya 1 kati ya 4: Taarifa za Mlezi na Picha",
            step_text: "Hatua",
            of_text: "ya",
            step1_title: "Maelezo ya Mlezi (Majhour)",
            step2_title: "Taarifa za Wazazi",
            step3_title: "Maelezo ya Mteja wa Utunzaji",
            step4_title: "Masharti ya Utunzaji",
            instructions_title: "Maelekezo Muhimu",
            instructions_step1: "• Kamilisha kila hatua kwa mpangilio",
            instructions_step2: "• Mazingira yote muhimu (*) lazima yajazwe",
            instructions_step3: "• Pakia nyaraka zilizo wazi kwa JPG/PNG",
            instructions_step4: "• Toa taarifa sahihi za wazazi",
            ward_name_label: "Jina Kamili la Mtoto/Mleziwa *",
            ward_gender_label: "Jinsia *",
            ward_dob_label: "Tarehe ya Kuzaliwa *",
            ward_age_label: "Umri *",
            birth_certificate_label: "Namba ya Cheti cha Kuzaliwa",
            ward_type_label: "Aina ya Mleziwa *",
            guardianship_type_label: "Aina ya Ulezi *",
            health_conditions_label: "Hali za Afya (ikiwa zipo)",
            education_level_label: "Kiwango cha Elimu",
            ward_photo_label: "Picha ya Mleziwa *",
            // Placeholders
            ward_name_placeholder: "Ingiza jina kamili la kisheria",
            ward_age_placeholder: "Itahesabiwa kiotomatiki",
            birth_certificate_placeholder: "Ikiwa inapatikana",
            health_conditions_placeholder: "Eleza hali zozote za kiafya au mahitaji maalum",
            // Select Options
            select_gender: "Chagua Jinsia",
            male: "Mwanaume",
            female: "Mwanamke",
            select_ward_type: "-- Chagua Aina --",
            orphan: "Yatima (Wazazi wote wamefariki)",
            abandoned: "Aliyeachwa / Mtoto Aliyepatikana",
            special_needs: "Mwenye Mahitaji Maalum / Asiyejiweza",
            normal: "Kawaida (Wazazi wapo lakini anahitaji mlezi)",
            select_guardianship_type: "-- Chagua Aina --",
            minor: "Ulezi wa Mtoto Mdogo",
            incapacitated: "Ulezi wa Mtu Mzima Asiyejiweza",
            testamentary: "Ulezi wa Wosia",
            emergency: "Ulezi wa Dharura",
            select_education_level: "-- Chagua --",
            none: "Hasomi",
            nursery: "Chekechea",
            primary: "Shule ya Msingi",
            secondary: "Shule ya Sekondari",
            vocational: "Mafunzo ya Ufundi",
            university: "Chuo Kikuu",
            step2_title: "Taarifa za Wazazi",
            step2_description: "Taarifa kuhusu wazazi wa kizazi cha mleziwa",
            father_info: "TAARIFA ZA BABA",
            father_name_label: "Jina Kamili la Baba *",
            father_name_placeholder: "Ingiza jina kamili la baba",
            father_status_label: "Hali ya Baba *",
            mother_info: "TAARIFA ZA MAMA",
            mother_name_label: "Jina Kamili la Mama",
            mother_name_placeholder: "Ingiza jina kamili la mama",
            mother_status_label: "Hali ya Mama *",
            birth_certificate_title: "CHETI CHA KUZALIWA",
            upload_birth_cert: "Pakia Cheti cha Kuzaliwa",
            birth_cert_description: "Pakia picha wazi ya cheti cha kuzaliwa (JPG, PNG, kiwango cha juu 2MB)",
            select_status: "-- Chagua Hali --",
            alive: "Aishi",
            deceased: "Amekufa",
            unknown: "Haijulikani",
            incapacitated: "Hana uwezo",
            step3_title: "Maelezo ya Mteja wa Utunzaji (Wali)",
            step3_description: "Taarifa kuhusu mlezi anayetarajia",
            personal_info_title: "TAARIFA BINAFSI",
            guardian_name_label: "Jina Kamili *",
            guardian_name_placeholder: "Jina kamili la mlezi",
            guardian_gender_label: "Jinsia",
            guardian_dob_label: "Tarehe ya Kuzaliwa *",
            guardian_nin_label: "Kitambulisho cha Kitaifa (NIN) *",
            guardian_nin_placeholder: "Namba ya NIN yenye tarakimu 14",
            relationship_label: "Uhusiano na Mleziwa *",
            select_relationship: "-- Chagua Uhusiano --",
            father_rel: "Baba",
            mother_rel: "Mama",
            paternal_grandfather: "Babu wa Upande wa Baba",
            paternal_grandmother: "Bibi wa Upande wa Baba",
            maternal_grandfather: "Babu wa Upande wa Mama",
            maternal_grandmother: "Bibi wa Upande wa Mama",
            paternal_uncle: "Mjomba wa Upande wa Baba",
            maternal_uncle: "Mjomba wa Upande wa Mama",
            brother_rel: "Kaka",
            sister_rel: "Dada",
            aunt_rel: "Shangazi",
            nephew_rel: "Mtoto wa Kaka au Dada",
            other_relative: "Jamaa Mwingine",
            family_friend: "Rafiki wa Familia",
            court_appointed: "Mteuliwa na Mahakama",
            marital_status_label: "Hali ya Ndoa",
            select_marital_status: "-- Chagua --",
            single: "Sijaoa",
            married: "Omeoa",
            divorced: "Talaka",
            widowed: "Mjane",
            occupation_label: "Kazi *",
            occupation_placeholder: "Kazi ya sasa",
            phone_label: "Namba ya Simu *",
            phone_placeholder: "+256 XXX XXX XXX",
            address_label: "Anuani ya Makazi *",
            address_placeholder: "Anuani kamili ya makazi",

            assessment_title: "TATHMINI YA MLEZI",
            experience_label: "Uzoefu wa Ulezi Uliopita (ikiwa upo)",
            experience_placeholder: "Eleza uzoefu wowote uliopita wa ulezi au utunzaji wa watoto",
            criminal_record_label: "Rekodi ya Jinai? *",
            select_criminal_record: "Chagua",
            yes: "Ndiyo",
            no: "Hapana",
            health_status_label: "Hali ya Afya",
            health_status_placeholder: "Hali ya jumla ya afya",
            religious_background_label: "Ujuzi wa Dini/Mazingira",
            religious_background_placeholder: "Eleza ujuzi na mazoea ya kidini",
            motivation_label: "Motisha ya Ulezi *",
            motivation_placeholder: "Eleza kwanini unataka kuwa mlezi",

            guardian_photo_title: "PICHA YA MLEZI *",
            upload_guardian_photo: "Pakia Picha ya Mlezi",
            guardian_photo_description: "Pakia picha wazi ya pasipoti ya mlezi (JPG, PNG, kiwango cha juu 2MB)",
            step4_title: "Masharti ya Ulezi na Uthibitisho",
            step4_description: "Masharti ya ulezi na uthibitisho rasmi",
            duration_title: "MUDA",
            duration_label: "Muda *",
            select_duration: "-- Chagua --",
            until_majority: "Hadi Mleziwa Afikie Umri wa Ubani (miaka 18)",
            specific_period: "Muda Maalum",
            indefinite: "Isiyo na Mwisho (kwa watu wazima wasiojiweza)",
            reporting_frequency_label: "Mara ya Kuripoti",
            select_reporting: "-- Chagua --",
            monthly: "Kila Mwezi",
            quarterly: "Kila Robo",
            annually: "Kila Mwaka",
            no_reporting: "Hakuna Ripoti ya Kawaida",

            powers_title: "MAMLKA ZILIZOTOLETWA KWA MLEZI *",
            financial_power: "Maamuzi ya Kifedha",
            medical_power: "Maamuzi ya Matibabu",
            educational_power: "Maamuzi ya Elimu",
            travel_power: "Idhini za Kusafiri",
            marriage_power: "Idhini ya Ndoa (kwa walezi wa kike)",
            powers_note: "Chagua mamlaka yote inayotumika itolewe kwa mlezi",

            restrictions_title: "VIZUIAJI/VIKWAZO",
            restrictions_placeholder: "Eleza vizuizi au vikwazo vyovyote kwa mamlaka ya mlezi...",

            shariah_title: "UTHIBITISHO WA SHARIA",
            imam_name_label: "Jina la Imam *",
            imam_name_placeholder: "Jina la Imam anayethibitisha",
            imam_reg_label: "Namba ya Usajili ya Imam *",
            imam_reg_placeholder: "Namba rasmi ya usajili",
            mosque_name_label: "Jina la Msikiti *",
            mosque_name_placeholder: "Jina la msikiti",
            verification_date_label: "Tarehe ya Uthibitisho *",

            witnesses_title: "MASHAHIDI",
            witness1_subtitle: "Shahidi 1",
            witness1_name_label: "Jina la Shahidi 1 *",
            witness1_nin_label: "NIN ya Shahidi 1 *",
            witness2_subtitle: "Shahidi 2",
            witness2_name_label: "Jina la Shahidi 2 *",
            witness2_nin_label: "NIN ya Shahidi 2 *",
            witness_name_placeholder: "Jina kamili la shahidi",
            witness_nin_placeholder: "NIN yenye tarakimu 14",
            prev_btn: "Iliyopita",
            next_btn: "Hatua Inayofuata",
            submit_btn: "Wasilisha Maombi"
        }
    };

    function applyTranslations(lang = 'en') {
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (translations[lang][key]) {
                el.textContent = translations[lang][key];
            }
        });

        document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
            const key = el.getAttribute('data-i18n-placeholder');
            if (translations[lang][key]) {
                el.setAttribute('placeholder', translations[lang][key]);
            }
        });
    }

    // Example: switch to English
    applyTranslations('en');
</script>

<div style="display: flex; min-height: 100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <!-- Left Side: Step Navigation -->
    <div
        style="flex: 0.4; background: #f8fafc; padding: 40px; overflow-y: auto; border-right: 1px solid #e2e8f0;">

        <!-- Header: Title & Subtitle -->
        <div style="position: sticky; top: 0; background: #FFF; padding-bottom: 20px; z-index: 10;">
            <h1 id="guardianshipTitle" data-i18n="ward_step_title"
                style="color: #2C5C36; margin-bottom: 5px; font-size: 2rem; font-weight: 800;">
                Guardianship Application
            </h1>
            <p id="wardStepSubtitle" data-i18n="ward_step_subtitle"
                style="color: #4b5563; font-size: 14px; margin-bottom: 30px; line-height: 1.5;">
                Complete all 4 sections to apply for legal guardianship according to Shariah law
            </p>

            <!-- Progress Tracker -->
            <div
                style="margin-bottom: 40px; background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e5e7eb;">

                <!-- Label & Percentage -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span id="applicationProgressLabel" data-i18n="application_progress_label"
                        style="font-size: 14px; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                        Application Progress
                    </span>
                    <span id="progressPercentage"
                        style="font-size: 20px; color: #2C5C36; font-weight: bold; font-family: monospace;">0%</span>
                </div>

                <!-- Progress Bar -->
                <div
                    style="height: 10px; background: #f3f4f6; border-radius: 5px; overflow: hidden; margin-bottom: 8px;">
                    <div id="progressBar"
                        style="height: 100%; background: #2C5C36; width: 0%; transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);">
                    </div>
                </div>

                <!-- Completed Steps Text -->
                <p id="completedSteps" data-i18n="completed_steps_text"
                    style="font-size: 13px; color: #9ca3af; margin-top: 10px; text-align: center; font-weight: 500;">
                    0 of 4 sections completed
                </p>
            </div>
        </div>

        <!-- Step Indicators -->
        <div style="display: flex; flex-direction: column; gap: 12px;">
            @php
                $stepIcons = ['👶', '👪', '👨‍⚖️', '📝'];
            @endphp

            @for ($i = 1; $i <= 4; $i++)
                <div class="step-indicator {{ $i === 1 ? 'active' : '' }} {{ $i > 1 ? 'locked' : '' }}" data-step="{{ $i }}"
                    id="stepIndicator{{ $i }}"
                    style="display: flex; align-items: center; gap: 16px; padding: 20px; background: white; border: 2px solid #e5e7eb; border-radius: 14px; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative; backdrop-filter: blur(10px);">

                    <!-- Step Icon -->
                    <div class="step-icon"
                        style="width: 48px; height: 48px; border-radius: 12px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; transition: all 0.3s;">
                        {{ $stepIcons[$i - 1] }}
                    </div>

                    <!-- Step Info -->
                    <div style="flex: 1;">
                        <div style="font-size: 15px; font-weight: 700; color: #374151; letter-spacing: -0.2px;">
                            <span data-i18n="step_text">Step</span> {{ $i }}
                        </div>
                        <div style="font-size: 13px; color: #9ca3af; margin-top: 4px; font-weight: 500;"
                            data-i18n="step{{ $i }}_title">
                            {{ ['Ward Details', 'Parental Info', 'Guardian Applicant', 'Guardianship Terms'][$i - 1] }}
                        </div>
                    </div>

                    <!-- Status Icon -->
                    <div class="step-status" style="width: 24px; height: 24px; flex-shrink: 0; transition: all 0.3s;">
                        @if ($i === 1)
                            <svg style="color: #2C5C36; width: 100%; height: 100%;" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 8v4l3 3"></path>
                            </svg>
                        @else
                            <svg style="color: #d1d5db; width: 100%; height: 100%;" viewBox="0 0 24 24" fill="none"
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
            style="margin-top: 40px; background: #e0e7ff; padding: 24px; border-radius: 14px; border-left: 4px solid #2C5C36;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div
                    style="width: 32px; height: 32px; background: #2C5C36; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 18px; height: 18px; color: white;" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <h4 data-i18n="instructions_title"
                    style="color: #2C5C36; margin: 0; font-size: 15px; font-weight: 700;">
                    Important Instructions
                </h4>
            </div>
            <ul style="color: #4b5563; font-size: 13px; padding-left: 24px; margin: 0; list-style-type: none;">
                <li data-i18n="instructions_step1" style="margin-bottom: 8px; position: relative; padding-left: 8px;">
                    • Complete each step in order
                </li>
                <li data-i18n="instructions_step2" style="margin-bottom: 8px; position: relative; padding-left: 8px;">
                    • All required fields (*) must be filled
                </li>
                <li data-i18n="instructions_step3" style="margin-bottom: 8px; position: relative; padding-left: 8px;">
                    • Upload clear documents in JPG/PNG format
                </li>
                <li data-i18n="instructions_step4" style="position: relative; padding-left: 8px;">
                    • Provide accurate parental information
                </li>
            </ul>
        </div>
    </div>


    <!-- Right Side: Form Content -->
    <div
        style="flex: 1; background: #ffffff; padding: 40px; overflow-y: auto;">
        <div
            style="position: sticky; top: 0; background: #ffffff; padding-bottom: 20px; z-index: 10; border-bottom: 1px solid #e5e7eb; margin-bottom: 30px; backdrop-filter: blur(10px);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 id="currentStepTitle" data-i18n="ward_step_title"
                    style="color: #2C5C36; margin: 0; font-size: 1.8rem; font-weight: 800; letter-spacing: -0.5px;">
                    Ward (Majhour) Details
                </h2>
                <div id="stepCompletionStatus"
                    style="background: #2C5C36; padding: 8px 20px; border-radius: 20px; font-size: 14px; color: white; font-weight: 600; box-shadow: 0 2px 8px rgba(79, 70, 229, 0.2);">
                    <span data-i18n="step_text">Step</span>
                    <span id="currentStepNumber" style="font-weight: 800;">1</span>
                    <span data-i18n="of_text">of</span> 4
                </div>
            </div>
            <p id="currentStepSubtitle" data-i18n="ward_step_subtitle"
                style="color: #6b7280; margin: 10px 0 0 0; font-size: 15px; font-weight: 500;">
                Step 1 of 4: Ward Information & Photograph
            </p>
        </div>


        <form method="POST" action="{{ route('save.guardianship.application') }}" enctype="multipart/form-data"
            id="multiStepForm">
            @csrf

            <!-- Step 1: Ward Details -->
            <div class="form-step active" id="step1">
                <div
                    style="background: #2C5C36; border-radius: 20px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(79, 70, 229, 0.15);">
                    <!-- Background Pattern -->
                    <div
                        style="position: absolute; top: -100px; right: -100px; width: 300px; height: 300px; background: #2C5C36; border-radius: 50%; filter: blur(20px);">
                    </div>
                    <div
                        style="position: absolute; bottom: -150px; left: -150px; width: 400px; height: 400px; background: rgba(255,255,255,0.03); border-radius: 50%; filter: blur(30px);">
                    </div>

                    @php
                        $fieldStyle =
                            'width: 100%; padding: 14px 18px; border-radius: 12px; border: 2px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.95); color: #111827; margin-top: 8px; font-size: 15px; transition: all 0.3s ease; outline: none; font-weight: 500;';
                        $selectStyle =
                            $fieldStyle .
                            " appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"%23111\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M6 9l6 6 6-6\"/></svg>'); background-repeat: no-repeat; background-position: right 18px center; background-size: 16px;";
                    @endphp
                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div
                            style="background: white; color: #2C5C36; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 24px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
                            1
                        </div>
                        <div>
                            <h3 data-i18n="ward_step_title"
                                style="color: white; font-size: 1.8rem; font-weight: 800; margin: 0; letter-spacing: -0.5px;">
                                Ward (Majhour) Details
                            </h3>
                            <p data-i18n="ward_step_subtitle"
                                style="color: rgba(255,255,255,0.8); margin: 8px 0 0 0; font-size: 15px; font-weight: 500;">
                                Please provide accurate information about the ward
                            </p>

                            <p><span style="color:#beb7b7;"><i>"ward" is typically a child or person who is in need of
                                        care, protection, and guidance.</i></span></p>
                        </div>
                    </div>

                    <!-- Form Grid -->
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; position: relative; z-index: 1;">

                        @php
                            $fieldStyle =
                                'width: 100%; padding: 14px 18px; border-radius: 12px; border: 2px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.95); color: #111827; margin-top: 8px; font-size: 15px; transition: all 0.3s ease; outline: none; font-weight: 500;';
                            $selectStyle =
                                $fieldStyle .
                                " appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"%23111\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M6 9l6 6 6-6\"/></svg>'); background-repeat: no-repeat; background-position: right 18px center; background-size: 16px;";
                        @endphp

                        <!-- Full Name -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="ward_name_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">
                                Full Name of Ward *
                            </label>
                            <input type="text" name="ward_name" data-i18n-placeholder="ward_name_placeholder"
                                placeholder="Enter full legal name" style="{{ $fieldStyle }}" data-required="true">
                        </div>

                        <!-- Gender -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="ward_gender_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">
                                Gender *
                            </label>
                            <select name="ward_gender" style="{{ $selectStyle }}" data-required="true">
                                <option value="" data-i18n="select_gender">Select Gender</option>
                                <option value="male" data-i18n="male">Male</option>
                                <option value="female" data-i18n="female">Female</option>
                            </select>
                        </div>

                        <!-- Date of Birth -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="ward_dob_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">
                                Date of Birth *
                            </label>
                            <input type="date" name="ward_dob" style="{{ $fieldStyle }}" data-required="true"
                                onchange="calculateAge()">
                        </div>

                        <!-- Age -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="ward_age_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">
                                Age *
                            </label>
                            <input type="number" name="ward_age" data-i18n-placeholder="ward_age_placeholder"
                                placeholder="Will be auto-calculated" style="{{ $fieldStyle }}" data-required="true"
                                readonly>
                        </div>

                        <!-- Birth Certificate Number -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="birth_certificate_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">
                                Birth Certificate Number
                            </label>
                            <input type="text" name="birth_certificate_number"
                                data-i18n-placeholder="birth_certificate_placeholder" placeholder="If available"
                                style="{{ $fieldStyle }}" data-required="false">
                        </div>

                        <!-- Type of Ward -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="ward_type_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">
                                Type of Ward *
                            </label>
                            <select name="ward_type" style="{{ $selectStyle }}" data-required="true">
                                <option value="" data-i18n="select_ward_type">-- Select Type --</option>
                                <option value="orphan" data-i18n="orphan">Orphan (Both parents deceased)</option>
                                <option value="abandoned" data-i18n="abandoned">Abandoned/Foundling</option>
                                <option value="special_needs" data-i18n="special_needs">Special Needs/Incapacitated
                                </option>
                                <option value="normal" data-i18n="normal">Normal (Parents alive but need guardian)
                                </option>
                            </select>
                        </div>

                        <!-- Type of Guardianship -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="guardianship_type_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">
                                Type of Guardianship *
                            </label>
                            <select name="guardianship_type" style="{{ $selectStyle }}" data-required="true">
                                <option value="" data-i18n="select_guardianship_type">-- Select Type --</option>
                                <option value="minor" data-i18n="minor">Guardianship of Minor</option>
                                <option value="incapacitated" data-i18n="incapacitated">Guardianship of Incapacitated
                                    Adult</option>
                                <option value="testamentary" data-i18n="testamentary">Testamentary Guardianship (by
                                    will)</option>
                                <option value="emergency" data-i18n="emergency">Emergency Guardianship</option>
                            </select>
                        </div>

                        <!-- Type of Guardianship Relationship to Ward -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="guardianship_type_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">
                                Relationship to Ward *
                            </label>
                            <select name="relationship_type" style="{{ $selectStyle }}" data-required="true">
                                <option value="" data-i18n="select_relationship_type">-- Select Relationship --</option>
                                <option value="Relative" data-i18n="minor">Relative</option>
                                <option value="Not Relative" data-i18n="minor">Not a Relative to Ward</option>
                            </select>
                        </div>

                        <!-- Health Conditions -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); grid-column: span 2;">
                            <label data-i18n="health_conditions_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">
                                Any Health Conditions
                            </label>
                            <textarea name="health_conditions" rows="2"
                                data-i18n-placeholder="health_conditions_placeholder"
                                placeholder="Describe any known health conditions or special needs"
                                style="{{ $fieldStyle }} min-height: 80px;" data-required="false"></textarea>
                        </div>

                        <!-- Education Level -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="education_level_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">
                                Education Level
                            </label>
                            <select name="ward_education_level" style="{{ $selectStyle }}" data-required="false">
                                <option value="" data-i18n="select_education_level">-- Select --</option>
                                <option value="none" data-i18n="none">Not in School</option>
                                <option value="nursery" data-i18n="nursery">Nursery School</option>
                                <option value="primary" data-i18n="primary">Primary School</option>
                                <option value="secondary" data-i18n="secondary">Secondary School</option>
                                <option value="vocational" data-i18n="vocational">Vocational Training</option>
                                <option value="university" data-i18n="university">University</option>
                            </select>
                        </div>

                        <!-- Ward Photograph -->
                        <div style="grid-column: 1 / -1; margin-top: 20px;">
                            <h4 data-i18n="ward_photo_label"
                                style="color: white; font-size: 16px; font-weight: 700; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid rgba(255,255,255,0.1);">
                                Ward Photograph *
                            </h4>
                            <div
                                style="background: rgba(255,255,255,0.08); padding: 30px; border-radius: 16px; border: 2px dashed rgba(255,255,255,0.2); text-align: center; transition: all 0.3s;">
                                <div onclick="document.getElementById('wardPhoto').click()" style="cursor: pointer;">
                                    <div id="wardPhotoPlaceholder"
                                        style="width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%; margin: 0 auto 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; transition: all 0.3s; overflow: hidden;">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" style="opacity: 0.7;">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <p data-i18n="upload_photo_text"
                                            style="font-size: 14px; margin-top: 12px; font-weight: 600;">Upload Ward
                                            Photo</p>
                                    </div>
                                    <img id="wardPhotoPreview"
                                        style="display: none; width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: 3px solid white; margin: 0 auto 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.2);">
                                </div>
                                <input type="file" id="wardPhoto" name="ward_photo" accept="image/*"
                                    style="display: none;" data-required="true"
                                    onchange="previewImage(this, 'wardPhotoPreview', 'wardPhotoPlaceholder')">
                                <p data-i18n="upload_photo_note"
                                    style="color: rgba(255,255,255,0.7); font-size: 13px; margin-top: 15px;">Upload a
                                    clear passport photo of the ward (JPG, PNG, max 2MB)</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Step 2: Parental Information -->
            <div class="form-step" id="step2" style="display: none;">
                <div
                    style="background: #2C5C36; border-radius: 20px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(5, 150, 105, 0.15);">
                    <!-- Background Pattern -->
                    <div
                        style="position: absolute; top: -100px; left: -100px; width: 300px; height: 300px; background: #2C5C36; border-radius: 50%; filter: blur(20px);">
                    </div>

                    <!-- Header -->
                    <div style="
    display: flex; 
    flex-wrap: wrap; 
    align-items: center; 
    gap: 20px; 
    margin-bottom: 40px; 
    position: relative; 
    z-index: 1;">

                        <div style="
        background: white; 
        color: #2C5C36; 
        width: 60px; 
        height: 60px; 
        flex-shrink: 0; 
        border-radius: 16px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-weight: 900; 
        font-size: 24px; 
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
                            2
                        </div>

                        <div style="flex: 1; min-width: 250px;">
                            <h3 data-i18n="step2_title" style="
            color: white; 
            font-size: clamp(1.4rem, 5vw, 1.8rem); 
            font-weight: 800; 
            margin: 0; 
            letter-spacing: -0.5px; 
            line-height: 1.2;">
                                Parental/Biographical Information
                            </h3>
                            <p data-i18n="step2_description" style="
            color: rgba(255,255,255,0.8); 
            margin: 8px 0 0 0; 
            font-size: 15px; 
            font-weight: 500; 
            line-height: 1.4;">
                                Information about the ward's biological parents
                            </p>
                        </div>
                    </div>

                    <!-- Father's Information -->
                    <div
                        style="background: rgba(255,255,255,0.08); padding: 30px; border-radius: 16px; margin-bottom: 40px; border: 1px solid #2C5C36; backdrop-filter: blur(10px);">
                        <h4
                            style="color: white; font-size: 18px; font-weight: 700; margin-bottom: 25px; display: flex; align-items: center; gap: 12px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="opacity: 0.8;">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span data-i18n="father_info">FATHER'S INFORMATION</span>
                        </h4>

                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                            <!-- Father's Full Name -->
                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 20px; border-radius: 12px; border: 1px solid #2C5C36;">
                                <label data-i18n="father_name_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Father's
                                    Full Name *</label>
                                <input type="text" name="father_name" data-i18n-placeholder="father_name_placeholder"
                                    style="{{ $fieldStyle }}" data-required="true">
                            </div>

                            <!-- Father's Status -->
                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 20px; border-radius: 12px; border: 1px solid #059367;">
                                <label data-i18n="father_status_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Father's
                                    Status *</label>
                                <select name="father_status" style="{{ $selectStyle }}" data-required="true">
                                    <option value="" data-i18n="select_status">-- Select Status --</option>
                                    <option value="alive" data-i18n="alive">Alive</option>
                                    <option value="deceased" data-i18n="deceased">Deceased</option>
                                    <option value="unknown" data-i18n="unknown">Unknown</option>
                                    <option value="incapacitated" data-i18n="incapacitated">Incapacitated</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Mother's Information -->
                    <div
                        style="background: rgba(255,255,255,0.08); padding: clamp(15px, 5vw, 30px); border-radius: 16px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                        <h4
                            style="color: white; font-size: 18px; font-weight: 700; margin-bottom: 25px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="opacity: 0.8; flex-shrink: 0;">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span data-i18n="mother_info"><span>MOTHER'S INFORMATION</span></span>
                        </h4>

                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr)); gap: 20px;">

                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="mother_name_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Mother's
                                    Full Name</label>
                                <input type="text" name="mother_name" data-i18n-placeholder="mother_name_placeholder"
                                    style="{{ $fieldStyle }}; width: 100%; box-sizing: border-box;"
                                    data-required="false">
                            </div>

                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="mother_status_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Mother's
                                    Status *</label>
                                <select name="mother_status"
                                    style="{{ $selectStyle }}; width: 100%; box-sizing: border-box;"
                                    data-required="true">
                                    <option value="" data-i18n="select_status">-- Select Status --</option>
                                    <option value="alive" data-i18n="alive">Alive</option>
                                    <option value="deceased" data-i18n="deceased">Deceased</option>
                                    <option value="unknown" data-i18n="unknown">Unknown</option>
                                    <option value="incapacitated" data-i18n="incapacitated">Incapacitated</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div
                        style="background: rgba(255,255,255,0.08); padding: clamp(15px, 5vw, 30px); border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px;">

                        <h4
                            style="color: white; font-size: clamp(16px, 4vw, 18px); font-weight: 700; margin-bottom: 25px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; justify-content: center;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="opacity: 0.8; flex-shrink: 0;">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            <span data-i18n="birth_certificate_title"><span style="text-align: center;">BIRTH CERTIFICATE</span></span>
                        </h4>

                        <div
                            style="background: #2C5C36; padding: clamp(15px, 4vw, 30px); border-radius: 16px; border: 2px dashed rgba(255,255,255,0.2); text-align: center; display: flex; flex-direction: column; align-items: center;">

                            <div onclick="document.getElementById('birthCertificate').click()"
                                style="cursor: pointer; width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center;">

                                <div id="birthCertificatePlaceholder"
                                    style="width: 100%; max-width: 200px; height: 140px; background: rgba(255,255,255,0.1); border-radius: 12px; margin-left: auto; margin-right: auto; display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; transition: all 0.3s; padding: 15px; box-sizing: border-box;">

                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.5" style="opacity: 0.7; margin-bottom: 12px; flex-shrink: 0;">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>

                                    <p data-i18n="upload_birth_cert"
                                        style="font-size: 13px; margin: 0; font-weight: 600; line-height: 1.2; text-align: center;">
                                        Upload Birth Certificate
                                    </p>
                                </div>

                                <img id="birthCertificatePreview"
                                    style="display: none; width: 100%; max-width: 200px; height: auto; aspect-ratio: 200/140; object-fit: cover; border-radius: 12px; border: 3px solid white; margin: 0 auto; box-shadow: 0 8px 25px rgba(0,0,0,0.2);">
                            </div>

                            <input type="file" id="birthCertificate" name="birth_certificate" accept="image/*"
                                style="display: none;" data-required="true"
                                onchange="previewImage(this, 'birthCertificatePreview', 'birthCertificatePlaceholder')">

                            <p data-i18n="birth_cert_description"
                                style="color: rgba(255,255,255,0.7); font-size: 12px; margin-top: 15px; line-height: 1.4; max-width: 240px; text-align: center;">
                                Upload a clear image of the birth certificate (JPG, PNG, max 2MB)
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Guardian Applicant Details -->
            <div class="form-step" id="step3" style="display: none;">
                <div
                    style="background: #2C5C36; border-radius: 20px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 20px 40px #2C5C36;">
                    <!-- Background Pattern -->
                    <div
                        style="position: absolute; top: -100px; right: -100px; width: 300px; height: 300px; background: #2C5C36; border-radius: 50%; filter: blur(20px);">
                    </div>

                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div
                            style="background: white; color: #2C5C36; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 24px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
                            3</div>
                        <div>
                            <h3 data-i18n="step3_title"
                                style="color: white; font-size: 1.8rem; font-weight: 800; margin: 0; letter-spacing: -0.5px;">
                                Guardian (Wali) Applicant Details</h3>
                            <p data-i18n="step3_description"
                                style="color: rgba(255,255,255,0.8); margin: 8px 0 0 0; font-size: 15px; font-weight: 500;">
                                Information about the prospective guardian</p>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div
                        style="background: rgba(255,255,255,0.08); padding: 15px 10px; border-radius: 12px; margin-bottom: 25px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); width: 100%; box-sizing: border-box;">

                        <h4
                            style="color: white; font-size: 16px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; padding-left: 5px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="opacity: 0.8; flex-shrink: 0;">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span data-i18n="personal_info_title"><span style="letter-spacing: 0.5px;">PERSONAL INFORMATION</span></span>
                        </h4>

                        <div style="display: flex; flex-direction: column; gap: 15px;">

                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 15px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                                <label data-i18n="guardian_name_label"
                                    style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; margin-bottom: 6px;">Full
                                    Name *</label>
                                <input type="text" name="guardian_name"
                                    data-i18n-placeholder="guardian_name_placeholder"
                                    style="{{ $fieldStyle }} width: 100%; box-sizing: border-box; height: 45px; font-size: 14px;"
                                    data-required="true">
                            </div>

                            <div
                                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 15px;">
                                <div
                                    style="display: flex; flex-direction: column; background: #2C5C36; padding: 15px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                                    <label data-i18n="guardian_gender_label"
                                        style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; margin-bottom: 6px;">Gender</label>
                                    <select name="guardian_gender"
                                        style="{{ $selectStyle }} width: 100%; box-sizing: border-box; height: 45px;"
                                        data-required="false">
                                        <option value="" data-i18n="select_gender">Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>

                                <div
                                    style="display: flex; flex-direction: column; background: #2C5C36; padding: 15px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                                    <label data-i18n="guardian_dob_label"
                                        style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; margin-bottom: 6px;">Date
                                        of Birth *</label>
                                    <input type="date" name="guardian_dob"
                                        style="{{ $fieldStyle }} width: 100%; box-sizing: border-box; height: 45px;"
                                        data-required="true">
                                </div>
                            </div>

                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 15px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                                <label data-i18n="guardian_nin_label"
                                    style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; margin-bottom: 6px;">National
                                    ID (NIN) *</label>
                                <input type="text" name="guardian_nin" data-i18n-placeholder="guardian_nin_placeholder"
                                    style="{{ $fieldStyle }} width: 100%; box-sizing: border-box; height: 45px;"
                                    data-required="true" maxlength="14">
                            </div>

                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 15px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                                <label data-i18n="relationship_label"
                                    style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; margin-bottom: 6px;">Relationship
                                    to Ward *</label>
                                <select name="relationship_to_ward"
                                    style="{{ $selectStyle }} width: 100%; box-sizing: border-box; height: 45px;"
                                    data-required="true">
                                    <option value="" data-i18n="select_relationship">-- Select --</option>
                                    <option value="father">Father</option>
                                    <option value="mother">Mother</option>
                                </select>
                            </div>

                            <div style="display: flex; flex-direction: column;
                                    background: #2C5C36;
                                    padding: 15px;
                                    border-radius: 10px;
                                    border: 1px solid rgba(255,255,255,0.05);">

                                <label data-i18n="phone_label" style="font-size: 12px;
                                        color: rgba(255,255,255,0.9);
                                        font-weight: 600;
                                        margin-bottom: 6px;">
                                    Telephone Number *
                                </label>

                                <!-- ✅ Phone Input Group -->
                                <div style="
                                        display: flex;
                                        gap: 10px;
                                        align-items: center;
                                        width: 100%;
                                    ">

                                    <!-- Country Code Dropdown -->
                                    <select name="guardian_country_code" class="select2" style="
                                                width: 35%;
                                                height: 45px;
                                                border-radius: 8px;
                                                border: 1px solid #cbd5e1;
                                                padding: 8px;
                                                font-size: 14px;
                                            " required>

                                        <option value="">Code</option>

                                        @foreach ($countries as $country)
                                            <option value="{{ $country->calling_code }}">
                                                {{ $country->name }} (+{{ $country->calling_code }})
                                            </option>
                                        @endforeach
                                    </select>

                                    <!-- Phone Number Input -->
                                    <input type="tel" name="guardian_phone" data-i18n-placeholder="phone_placeholder" class="form-control"
                                        maxlength="15" style="{{ $fieldStyle }} width: 65%; height: 45px;"
                                        data-required="true" placeholder="Phone number" required>
                                </div>

                            </div>


                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 15px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                                <label data-i18n="address_label"
                                    style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; margin-bottom: 6px;">Residential
                                    Address *</label>
                                <textarea name="guardian_address" rows="2" data-i18n-placeholder="address_placeholder"
                                    style="{{ $fieldStyle }} width: 100%; box-sizing: border-box; min-height: 70px; font-size: 14px;"
                                    data-required="true"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Guardian Assessment -->
                    <div
                        style="background: rgba(255,255,255,0.08); padding: 30px; border-radius: 16px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                        <h4
                            style="color: white; font-size: 18px; font-weight: 700; margin-bottom: 25px; display: flex; align-items: center; gap: 12px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="opacity: 0.8;">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span data-i18n="assessment_title">GUARDIAN ASSESSMENT</span>
                        </h4>

                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                            <!-- Previous Guardianship Experience -->
                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08); grid-column: span 2;">
                                <label data-i18n="experience_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Previous
                                    Guardianship Experience (if any)</label>
                                <textarea name="previous_experience" rows="3"
                                    data-i18n-placeholder="experience_placeholder"
                                    style="{{ $fieldStyle }} min-height: 100px;" data-required="false"></textarea>
                            </div>

                            <!-- Criminal Record -->
                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="criminal_record_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Criminal
                                    Record? *</label>
                                <select name="criminal_record" style="{{ $selectStyle }}" data-required="true">
                                    <option value="" data-i18n="select_criminal_record">Select</option>
                                    <option value="yes" data-i18n="yes">Yes</option>
                                    <option value="no" data-i18n="no">No</option>
                                </select>
                            </div>

                            <!-- Health Status -->
                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                                <label data-i18n="health_status_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Health
                                    Status</label>
                                <input type="text" name="health_status"
                                    data-i18n-placeholder="health_status_placeholder" style="{{ $fieldStyle }}"
                                    data-required="false">
                            </div>

                            <!-- Religious Knowledge -->
                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08); grid-column: span 2;">
                                <label data-i18n="religious_background_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Religious
                                    Knowledge/Background</label>
                                <textarea name="religious_background" rows="2"
                                    data-i18n-placeholder="religious_background_placeholder"
                                    style="{{ $fieldStyle }} min-height: 80px;" data-required="false"></textarea>
                            </div>

                            <!-- Motivation -->
                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08); grid-column: span 2;">
                                <label data-i18n="motivation_label"
                                    style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 8px;">Motivation
                                    for Guardianship *</label>
                                <textarea name="motivation" rows="3" data-i18n-placeholder="motivation_placeholder"
                                    style="{{ $fieldStyle }} min-height: 100px;" data-required="true"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Guardian Photograph -->
                    <div
                        style="background: rgba(255,255,255,0.08); padding: 30px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
                        <h4
                            style="color: white; font-size: 18px; font-weight: 700; margin-bottom: 25px; display: flex; align-items: center; gap: 12px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="opacity: 0.8;">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2">
                                </rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <span data-i18n="guardian_photo_title">GUARDIAN PHOTOGRAPH *</span>
                        </h4>

                        <div
                            style="background: #2C5C36; padding: 30px; border-radius: 16px; border: 2px dashed rgba(255,255,255,0.2); text-align: center;">
                            <div onclick="document.getElementById('guardianPhoto').click()" style="cursor: pointer;">
                                <div id="guardianPhotoPlaceholder"
                                    style="width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%; margin: 0 auto 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; transition: all 0.3s; overflow: hidden;">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.5" style="opacity: 0.7;">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <p data-i18n="upload_guardian_photo"
                                        style="font-size: 14px; margin-top: 12px; font-weight: 600;">Upload Guardian
                                        Photo</p>
                                </div>
                                <img id="guardianPhotoPreview"
                                    style="display: none; width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: 3px solid white; margin: 0 auto 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.2);">
                            </div>
                            <input type="file" id="guardianPhoto" name="guardian_photo" accept="image/*"
                                style="display: none;" data-required="true"
                                onchange="previewImage(this, 'guardianPhotoPreview', 'guardianPhotoPlaceholder')">
                            <p data-i18n="guardian_photo_description"
                                style="color: rgba(255,255,255,0.7); font-size: 13px; margin-top: 15px;">Upload a clear
                                passport photo of the guardian (JPG, PNG, max 2MB)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Guardianship Terms -->
            <div class="form-step" id="step4" style="display: none;">
                <div
                    style="background: #2C5C36; border-radius: 20px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(234, 88, 12, 0.15);">
                    <!-- Background Pattern -->
                    <div
                        style="position: absolute; bottom: -100px; right: -100px; width: 300px; height: 300px; background: #2C5C36; border-radius: 50%; filter: blur(20px);">
                    </div>

                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div
                            style="background: white; color: #2C5C36; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 24px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
                            4</div>
                        <div>
                            <h3 data-i18n="step4_title"
                                style="color: white; font-size: 1.8rem; font-weight: 800; margin: 0; letter-spacing: -0.5px;">
                                Guardianship Terms & Verification</h3>
                            <p data-i18n="step4_description"
                                style="color: rgba(255,255,255,0.8); margin: 8px 0 0 0; font-size: 15px; font-weight: 500;">
                                Terms of guardianship and official verification</p>
                        </div>
                    </div>

                    <!-- Duration -->
                    <div
                        style="background: rgba(255,255,255,0.08); padding: 15px 10px; border-radius: 12px; margin-bottom: 25px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); width: 100%; box-sizing: border-box;">

                        <h4
                            style="color: white; font-size: 16px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; padding-left: 5px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="opacity: 0.8; flex-shrink: 0;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span data-i18n="duration_title"><span style="letter-spacing: 0.5px;">DURATION</span></span>
                        </h4>

                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 260px), 1fr)); gap: 15px;">

                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 15px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                                <label data-i18n="duration_label"
                                    style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; margin-bottom: 6px;">
                                    Duration * <span style="color:#beb7b7;"><i>Period under Guardianship</i></span>
                                </label>
                                <select name="guardianship_duration"
                                    style="{{ $selectStyle }} width: 100%; box-sizing: border-box; height: 45px; font-size: 14px;"
                                    data-required="true">
                                    <option value="" data-i18n="select_duration">-- Select --</option>
                                    <option value="until_majority" data-i18n="until_majority">Until Ward Reaches
                                        Majority (18 years)</option>
                                    <option value="specific_period" data-i18n="specific_period">Specific Period
                                    </option>
                                    <option value="indefinite" data-i18n="indefinite">Indefinite (for incapacitated
                                        adults)</option>
                                </select>
                            </div>

                            <div
                                style="display: flex; flex-direction: column; background: #2C5C36; padding: 15px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                                <label data-i18n="reporting_frequency_label"
                                    style="font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; margin-bottom: 6px;">
                                    Reporting Frequency <span style="color:#beb7b7;"><i>Guardianship Reporting Interval</i></span>
                                </label>
                                <select name="reporting_frequency"
                                    style="{{ $selectStyle }} width: 100%; box-sizing: border-box; height: 45px; font-size: 14px;"
                                    data-required="false">
                                    <option value="" data-i18n="select_reporting">-- Select --</option>
                                    <option value="monthly" data-i18n="monthly">Monthly</option>
                                    <option value="quarterly" data-i18n="quarterly">Quarterly</option>
                                    <option value="annually" data-i18n="annually">Annually</option>
                                    <option value="none" data-i18n="no_reporting">No Regular Reporting</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div
                        style="background: rgba(255,255,255,0.08); padding: 15px 10px; border-radius: 12px; margin-bottom: 25px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); width: 100%; box-sizing: border-box;">
                        <h4
                            style="color: white; font-size: 16px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; padding-left: 5px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="opacity: 0.8; flex-shrink: 0;">
                                <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path>
                                <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                                <line x1="12" y1="19" x2="12" y2="23"></line>
                                <line x1="8" y1="23" x2="16" y2="23"></line>
                            </svg>
                            <span data-i18n="powers_title"><span style="letter-spacing: 0.5px;">POWERS GRANTED *</span></span>
                        </h4>

                        <div
                            style="background: #2C5C36; padding: 15px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                            <div style="display: grid; grid-template-columns: 1fr; gap: 10px;">
                                @php
                                    $powers = [
                                        'financial' => 'Financial Decisions',
                                        'medical' => 'Medical Decisions',
                                        'educational' => 'Educational Decisions',
                                        'travel' => 'Travel Permissions',
                                        'marriage' => 'Marriage Consent',
                                    ];
                                @endphp

                                @foreach ($powers as $value => $label)
                                    <label
                                        style="display: flex; align-items: flex-start; gap: 12px; padding: 12px; background: rgba(255,255,255,0.03); border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); cursor: pointer; box-sizing: border-box;">
                                        <input type="checkbox" name="powers_granted[]" value="{{ $value }}"
                                            style="width: 18px; height: 18px; accent-color: #ffffff; margin-top: 2px; flex-shrink: 0;">
                                        <span data-i18n="{{ $value }}_power"
                                            style="color: white; font-size: 13px; font-weight: 500; line-height: 1.4;">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <p data-i18n="powers_note"
                                style="color: rgba(255,255,255,0.6); font-size: 11px; margin-top: 12px; font-style: italic; line-height: 1.3;">
                                Select all applicable powers to be granted.
                            </p>
                        </div>
                    </div>

                    <div
                        style="background: rgba(255,255,255,0.08); padding: 15px 10px; border-radius: 12px; margin-bottom: 25px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); width: 100%; box-sizing: border-box;">
                        <h4
                            style="color: white; font-size: 16px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; padding-left: 5px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="opacity: 0.8;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <span data-i18n="restrictions_title">RESTRICTIONS</span>
                        </h4>
                        <div style="background: #2C5C36; padding: 15px; border-radius: 10px;">
                            <textarea name="restrictions" rows="3"
                                style="{{ $fieldStyle }} width: 100%; box-sizing: border-box; min-height: 80px; font-size: 14px;"></textarea>
                        </div>
                    </div>

                    <div
                        style="background: rgba(255,255,255,0.08); padding: 15px 10px; border-radius: 12px; margin-bottom: 25px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); width: 100%; box-sizing: border-box;display:none;">
                        <h4
                            style="color: white; font-size: 16px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; padding-left: 5px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="opacity: 0.8;">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            <span>VERIFICATION</span>
                        </h4>

                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="background: #2C5C36; padding: 15px; border-radius: 10px;">
                                <label style="font-size: 12px; color: white; display: block; margin-bottom: 5px;">Imam
                                    Name *</label>
                                <input type="text" name="imam_name"
                                    style="{{ $fieldStyle }} width: 100%; box-sizing: border-box; height: 45px;">
                            </div>

                            <div
                                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                                <div style="background: #2C5C36; padding: 15px; border-radius: 10px;">
                                    <label
                                        style="font-size: 12px; color: white; display: block; margin-bottom: 5px;">Reg
                                        Number *</label>
                                    <input type="text" name="imam_reg_number"
                                        style="{{ $fieldStyle }} width: 100%; box-sizing: border-box; height: 45px;">
                                </div>
                                <div style="background: #2C5C36; padding: 15px; border-radius: 10px;">
                                    <label
                                        style="font-size: 12px; color: white; display: block; margin-bottom: 5px;">Mosque
                                        *</label>
                                    <input type="text" name="mosque_name"
                                        style="{{ $fieldStyle }} width: 100%; box-sizing: border-box; height: 45px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        style="background: rgba(255,255,255,0.08); padding: 15px 10px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); width: 100%; box-sizing: border-box;">
                        <h4
                            style="color: white; font-size: 16px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; padding-left: 5px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="opacity: 0.8;">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                            </svg>
                            <span>WITNESSES</span>
                        </h4>

                        <div
                            style="margin-bottom: 15px; padding: 12px; background: rgba(255,255,255,0.03); border-radius: 10px;">
                            <p
                                style="color: white; font-size: 13px; font-weight: 600; margin-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 5px;">
                                Witness 1</p>
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <input type="text" name="witness1_name" placeholder="Full Name"
                                    style="{{ $fieldStyle }} width: 100%; box-sizing: border-box; height: 42px;">
                                <input type="text" name="witness1_nin" placeholder="NIN"
                                    style="{{ $fieldStyle }} width: 100%; box-sizing: border-box; height: 42px;">
                            </div>
                        </div>

                        <div style="padding: 12px; background: rgba(255,255,255,0.03); border-radius: 10px;">
                            <p
                                style="color: white; font-size: 13px; font-weight: 600; margin-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 5px;">
                                Witness 2</p>
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <input type="text" name="witness2_name" placeholder="Full Name"
                                    style="{{ $fieldStyle }} width: 100%; box-sizing: border-box; height: 42px;">
                                <input type="text" name="witness2_nin" placeholder="NIN"
                                    style="{{ $fieldStyle }} width: 100%; box-sizing: border-box; height: 42px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <!-- Navigation Buttons -->
<div style="display: flex; justify-content: space-between; margin-top: 40px; padding-top: 30px; border-top: 1px solid #e5e7eb;">
    <button type="button" id="prevBtn" onclick="previousStep()"
        style="padding: 16px 32px; background: #6b7280; color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: 700; font-size: 16px; display: none; align-items: center; gap: 10px; transition: all 0.3s; box-shadow: 0 4px 12px rgba(107, 114, 128, 0.2);">
        <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2.5">
            <path d="M15 18l-6-6 6-6" />
        </svg>
        <span data-i18n="prev_btn">Previous</span>
    </button>

    <div></div> <!-- Spacer -->

    <div style="display: flex; gap: 10px;">
        <!-- Preview Button -->
        <button type="button" id="previewBtn" onclick="showPreview()"
            style="
                padding: 16px 30px;
                background: #f59e0b;
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
            style="padding: 16px 40px; background: #2C5C36; color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 10px; transition: all 0.3s; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);">
            <span data-i18n="next_btn">Next Step</span>
            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5">
                <path d="M9 18l6-6-6-6" />
            </svg>
        </button>

        <button type="submit" id="submitBtn"
            style="padding: 16px 40px; background: #2C5C36; color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: 700; font-size: 16px; display: none; align-items: center; gap: 10px; transition: all 0.3s; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);">
            <span data-i18n="submit_btn">Submit Application</span>
            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5">
                <path d="M20 6L9 17l-5-5" />
            </svg>
        </button>
    </div>
</div>
        </form>
    </div>
</div>

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
                Guardianship Application Preview
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

<style>
    /* Step indicator states */
    .step-indicator.active {
        border-color: #2C5C36 !important;
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.15);
        transform: translateY(-2px);
    }

    .step-indicator.active .step-icon {
        background: #2C5C36 !important;
        color: white !important;
        transform: scale(1.1);
    }

    .step-indicator.completed {
        border-color: #2C5C36 !important;
        background: rgba(16, 185, 129, 0.05) !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
    }

    .step-indicator.completed .step-icon {
        background: #2C5C36 !important;
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
        color: #2C5C36 !important;
    }

    /* Form step styling */
    .form-step {
        transition: opacity 0.3s ease;
    }

    /* Input focus styles */
    input:focus,
    select:focus,
    textarea:focus {
        border-color: #2C5C36 !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
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

    /* Checkbox styling */
    input[type="checkbox"] {
        cursor: pointer;
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

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    div[style*="overflow-y: auto;"] {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }

    /* Responsive styles for guardianship application form */
    @media (max-width: 768px) {

        /* Step containers */
        .form-step>div {
            padding: 25px !important;
            border-radius: 16px !important;
        }

        /* Header section */
        .form-step>div>div:first-child {
            flex-direction: column !important;
            gap: 15px !important;
            margin-bottom: 30px !important;
            text-align: center !important;
        }

        .form-step>div>div:first-child>div:first-child {
            width: 50px !important;
            height: 50px !important;
            font-size: 20px !important;
        }

        .form-step>div>div:first-child>div:last-child h3 {
            font-size: 1.5rem !important;
        }

        .form-step>div>div:first-child>div:last-child p {
            font-size: 14px !important;
        }

        /* Form grid layouts */
        .form-step>div>div:nth-child(3),
        .form-step>div>div:nth-child(4),
        .form-step>div>div:nth-child(5),
        .form-step>div>div:nth-child(6),
        .form-step>div>div:nth-child(7) {
            grid-template-columns: 1fr !important;
            gap: 16px !important;
        }

        /* Specific grid adjustments */
        [style*="grid-column: span 2"] {
            grid-column: span 1 !important;
        }

        /* Form field containers */
        [style*="display: flex; flex-direction: column"] {
            padding: 16px !important;
            border-radius: 12px !important;
        }

        /* Input fields */
        input,
        select,
        textarea {
            padding: 12px 16px !important;
            font-size: 14px !important;
        }

        /* Photo upload sections */
        #wardPhotoPlaceholder,
        #birthCertificatePlaceholder,
        #guardianPhotoPlaceholder {
            width: 150px !important;
            height: 150px !important;
        }

        /* Health conditions and similar textareas */
        textarea {
            min-height: 60px !important;
        }

        /* Section headers */
        h4 {
            font-size: 16px !important;
            flex-direction: column !important;
            gap: 8px !important;
            text-align: center !important;
        }

        /* Parental information sections */
        #step2>div>div:nth-child(3),
        #step2>div>div:nth-child(5) {
            padding: 20px !important;
            margin-bottom: 30px !important;
        }

        /* Guardian assessment sections */
        #step3>div>div:nth-child(3),
        #step3>div>div:nth-child(4),
        #step3>div>div:nth-child(5) {
            padding: 20px !important;
            margin-bottom: 30px !important;
        }

        /* Powers granted grid */
        #step4>div>div:nth-child(4)>div>div {
            grid-template-columns: 1fr !important;
            gap: 10px !important;
            padding: 20px !important;
        }

        /* Navigation buttons */
        #prevBtn,
        #nextBtn,
        #submitBtn {
            width: 100% !important;
            justify-content: center !important;
            margin-bottom: 10px !important;
            padding: 14px 20px !important;
            font-size: 15px !important;
        }

        /* Button container */
        [style*="display: flex; justify-content: space-between"] {
            flex-direction: column !important;
            gap: 15px !important;
        }

        [style*="display: flex; justify-content: space-between"]>div:last-child {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
        }

        /* Background pattern elements */
        [style*="position: absolute; top: -100px"],
        [style*="position: absolute; bottom: -150px"],
        [style*="position: absolute; bottom: -100px"] {
            display: none !important;
        }
    }

    @media (max-width: 480px) {

        /* Step containers */
        .form-step>div {
            padding: 20px !important;
            margin: 0 -10px !important;
            border-radius: 12px !important;
        }

        /* Header section */
        .form-step>div>div:first-child>div:last-child h3 {
            font-size: 1.3rem !important;
            line-height: 1.4 !important;
        }

        .form-step>div>div:first-child>div:last-child p {
            font-size: 13px !important;
            line-height: 1.4 !important;
        }

        /* Form field containers */
        [style*="display: flex; flex-direction: column"] {
            padding: 12px !important;
        }

        /* Input fields */
        input,
        select,
        textarea {
            padding: 10px 14px !important;
            font-size: 13px !important;
            border-radius: 10px !important;
        }

        /* Labels */
        label {
            font-size: 12px !important;
            margin-bottom: 4px !important;
        }

        /* Photo upload sections */
        #wardPhotoPlaceholder,
        #birthCertificatePlaceholder,
        #guardianPhotoPlaceholder {
            width: 120px !important;
            height: 120px !important;
        }

        /* Photo upload text */
        p[style*="font-size: 14px"] {
            font-size: 13px !important;
        }

        p[style*="font-size: 13px"] {
            font-size: 12px !important;
        }

        /* Section spacing */
        #step2>div>div:nth-child(3),
        #step2>div>div:nth-child(5),
        #step3>div>div:nth-child(3),
        #step3>div>div:nth-child(4),
        #step3>div>div:nth-child(5),
        #step4>div>div:nth-child(2),
        #step4>div>div:nth-child(3),
        #step4>div>div:nth-child(4),
        #step4>div>div:nth-child(5),
        #step4>div>div:nth-child(6) {
            padding: 16px !important;
            margin-bottom: 20px !important;
        }

        /* Witness sections */
        #step4>div>div:nth-child(6)>div {
            margin-bottom: 20px !important;
        }

        h5[style*="font-size: 14px"] {
            font-size: 13px !important;
        }

        /* Checkbox labels */
        label[style*="display: flex; align-items: center; gap: 12px"] {
            padding: 10px !important;
            gap: 8px !important;
        }

        label[style*="display: flex; align-items: center; gap: 12px"] span {
            font-size: 13px !important;
        }

        /* Navigation buttons */
        #prevBtn,
        #nextBtn,
        #submitBtn {
            padding: 12px 16px !important;
            font-size: 14px !important;
            border-radius: 10px !important;
        }

        /* SVG icons in buttons */
        #prevBtn svg,
        #nextBtn svg,
        #submitBtn svg {
            width: 18px !important;
            height: 18px !important;
        }
    }

    /* Additional improvements for very small screens */
    @media (max-width: 360px) {
        .form-step>div {
            padding: 15px !important;
        }

        .form-step>div>div:first-child>div:first-child {
            width: 45px !important;
            height: 45px !important;
            font-size: 18px !important;
        }

        .form-step>div>div:first-child>div:last-child h3 {
            font-size: 1.2rem !important;
        }

        #wardPhotoPlaceholder,
        #birthCertificatePlaceholder,
        #guardianPhotoPlaceholder {
            width: 100px !important;
            height: 100px !important;
        }

        p[style*="font-size: 14px"] {
            font-size: 12px !important;
            margin-top: 8px !important;
        }

        /* Birth certificate specific */
        #birthCertificatePlaceholder {
            height: 100px !important;
        }
    }

    /* Fix for iOS input zoom */
    @media screen and (max-width: 768px) {

        input,
        select,
        textarea {
            font-size: 16px !important;
        }
    }

    /* Ensure proper spacing on all mobile devices */
    @media (max-width: 768px) {
        body {
            padding: 10px !important;
        }

        #multiStepForm {
            margin: 0 auto !important;
            max-width: 100% !important;
        }
    }

    /* Responsive styles for guardianship application form - Steps 2, 3, 4 */
    @media (max-width: 768px) {

        /* Step 2, 3, 4 containers */
        #step2>div,
        #step3>div,
        #step4>div {
            padding: 25px !important;
            border-radius: 16px !important;
            margin: 10px 0 !important;
        }

        /* Header section for all steps */
        #step2>div>div:first-child,
        #step3>div>div:first-child,
        #step4>div>div:first-child {
            flex-direction: column !important;
            gap: 15px !important;
            margin-bottom: 30px !important;
            text-align: center !important;
        }

        /* Step number circles */
        #step2>div>div:first-child>div:first-child,
        #step3>div>div:first-child>div:first-child,
        #step4>div>div:first-child>div:first-child {
            width: 50px !important;
            height: 50px !important;
            font-size: 20px !important;
        }

        /* Step titles */
        #step2>div>div:first-child>div:last-child h3,
        #step3>div>div:first-child>div:last-child h3,
        #step4>div>div:first-child>div:last-child h3 {
            font-size: 1.5rem !important;
            line-height: 1.3 !important;
        }

        /* Step descriptions */
        #step2>div>div:first-child>div:last-child p,
        #step3>div>div:first-child>div:last-child p,
        #step4>div>div:first-child>div:last-child p {
            font-size: 14px !important;
            line-height: 1.4 !important;
        }

        /* ==================== STEP 2 SPECIFIC ==================== */

        /* Father's and Mother's Information Sections */
        #step2>div>div:nth-child(3),
        #step2>div>div:nth-child(5),
        #step2>div>div:nth-child(6) {
            padding: 20px !important;
            margin-bottom: 30px !important;
            border-radius: 14px !important;
        }

        /* Section headers with icons */
        #step2 h4[data-i18n="father_info"],
        #step2 h4[data-i18n="mother_info"],
        #step2 h4[data-i18n="birth_certificate_title"] {
            font-size: 16px !important;
            flex-direction: column !important;
            gap: 8px !important;
            text-align: center !important;
            margin-bottom: 20px !important;
        }

        /* Grid layouts inside sections */
        #step2>div>div:nth-child(3)>div,
        #step2>div>div:nth-child(5)>div {
            grid-template-columns: 1fr !important;
            gap: 16px !important;
        }

        /* Form field containers */
        #step2>div>div:nth-child(3)>div>div,
        #step2>div>div:nth-child(5)>div>div {
            padding: 16px !important;
            border-radius: 12px !important;
        }

        /* Birth Certificate upload section */
        #step2>div>div:nth-child(6)>div {
            padding: 20px !important;
        }

        #birthCertificatePlaceholder {
            width: 150px !important;
            height: 105px !important;
        }

        #birthCertificatePreview {
            width: 150px !important;
            height: 105px !important;
        }

        /* ==================== STEP 3 SPECIFIC ==================== */

        /* Personal Information, Guardian Assessment, Photo sections */
        #step3>div>div:nth-child(3),
        #step3>div>div:nth-child(4),
        #step3>div>div:nth-child(5) {
            padding: 20px !important;
            margin-bottom: 30px !important;
            border-radius: 14px !important;
        }

        /* Section headers */
        #step3 h4[data-i18n="personal_info_title"],
        #step3 h4[data-i18n="assessment_title"],
        #step3 h4[data-i18n="guardian_photo_title"] {
            font-size: 16px !important;
            flex-direction: column !important;
            gap: 8px !important;
            text-align: center !important;
            margin-bottom: 20px !important;
        }

        /* Grid layouts */
        #step3>div>div:nth-child(3)>div,
        #step3>div>div:nth-child(4)>div {
            grid-template-columns: 1fr !important;
            gap: 16px !important;
        }

        /* Span 2 columns adjustment */
        #step3>div>div:nth-child(3)>div>div[style*="grid-column: span 2"],
        #step3>div>div:nth-child(4)>div>div[style*="grid-column: span 2"] {
            grid-column: span 1 !important;
        }

        /* Form field containers */
        #step3>div>div:nth-child(3)>div>div,
        #step3>div>div:nth-child(4)>div>div {
            padding: 16px !important;
            border-radius: 12px !important;
        }

        /* Guardian Photo upload section */
        #step3>div>div:nth-child(5)>div {
            padding: 20px !important;
        }

        #guardianPhotoPlaceholder {
            width: 150px !important;
            height: 150px !important;
        }

        #guardianPhotoPreview {
            width: 150px !important;
            height: 150px !important;
        }

        /* Textareas */
        #step3 textarea {
            min-height: 80px !important;
        }

        /* ==================== STEP 4 SPECIFIC ==================== */

        /* All sections in Step 4 */
        #step4>div>div:nth-child(2),
        #step4>div>div:nth-child(3),
        #step4>div>div:nth-child(4),
        #step4>div>div:nth-child(5),
        #step4>div>div:nth-child(6) {
            padding: 20px !important;
            margin-bottom: 30px !important;
            border-radius: 14px !important;
        }

        /* Section headers */
        #step4 h4[data-i18n="duration_title"],
        #step4 h4[data-i18n="powers_title"],
        #step4 h4[data-i18n="restrictions_title"],
        #step4 h4[data-i18n="shariah_title"],
        #step4 h4[data-i18n="witnesses_title"] {
            font-size: 16px !important;
            flex-direction: column !important;
            gap: 8px !important;
            text-align: center !important;
            margin-bottom: 20px !important;
        }

        /* Grid layouts */
        #step4>div>div:nth-child(2)>div,
        #step4>div>div:nth-child(5)>div,
        #step4>div>div:nth-child(6)>div>div,
        #step4>div>div:nth-child(6)>div+div>div {
            grid-template-columns: 1fr !important;
            gap: 16px !important;
        }

        /* Powers granted checkboxes */
        #step4>div>div:nth-child(3)>div>div {
            grid-template-columns: 1fr !important;
            gap: 10px !important;
            padding: 20px !important;
        }

        /* Checkbox labels */
        #step4 label[style*="display: flex; align-items: center; gap: 12px"] {
            padding: 12px !important;
            gap: 10px !important;
        }

        #step4 label[style*="display: flex; align-items: center; gap: 12px"] span {
            font-size: 13px !important;
            line-height: 1.4 !important;
        }

        /* Witness sections */
        #step4>div>div:nth-child(6)>div,
        #step4>div>div:nth-child(6)>div+div {
            margin-bottom: 25px !important;
        }

        /* Witness subtitles */
        #step4 h5[data-i18n="witness1_subtitle"],
        #step4 h5[data-i18n="witness2_subtitle"] {
            font-size: 14px !important;
            padding-bottom: 10px !important;
            margin-bottom: 15px !important;
        }

        /* Form field containers in Step 4 */
        #step4>div>div:nth-child(2)>div>div,
        #step4>div>div:nth-child(5)>div>div,
        #step4>div>div:nth-child(6)>div>div>div,
        #step4>div>div:nth-child(6)>div+div>div>div {
            padding: 16px !important;
            border-radius: 12px !important;
        }

        /* Restrictions textarea */
        #step4>div>div:nth-child(4)>div {
            padding: 16px !important;
        }

        #step4 textarea[name="restrictions"] {
            min-height: 80px !important;
        }

        /* ==================== COMMON STYLES ==================== */

        /* Background patterns - hide on mobile */
        [style*="position: absolute; top: -100px"],
        [style*="position: absolute; bottom: -100px"],
        [style*="position: absolute; right: -100px"],
        [style*="position: absolute; left: -100px"] {
            display: none !important;
        }

        /* Input fields, selects, textareas */
        input,
        select,
        textarea {
            padding: 12px 16px !important;
            font-size: 14px !important;
            border-radius: 10px !important;
        }

        /* Labels */
        label {
            font-size: 13px !important;
            margin-bottom: 6px !important;
        }

        /* Upload instructions */
        p[style*="color: rgba(255,255,255,0.7)"] {
            font-size: 12px !important;
            margin-top: 12px !important;
            line-height: 1.4 !important;
        }

        /* Icons in headers */
        h4 svg {
            width: 20px !important;
            height: 20px !important;
        }
    }

    @media (max-width: 480px) {

        /* Step 2, 3, 4 containers - smaller screens */
        #step2>div,
        #step3>div,
        #step4>div {
            padding: 20px !important;
            border-radius: 14px !important;
        }

        /* Header section */
        #step2>div>div:first-child>div:last-child h3,
        #step3>div>div:first-child>div:last-child h3,
        #step4>div>div:first-child>div:last-child h3 {
            font-size: 1.3rem !important;
        }

        #step2>div>div:first-child>div:last-child p,
        #step3>div>div:first-child>div:last-child p,
        #step4>div>div:first-child>div:last-child p {
            font-size: 13px !important;
        }

        /* Step number circles */
        #step2>div>div:first-child>div:first-child,
        #step3>div>div:first-child>div:first-child,
        #step4>div>div:first-child>div:first-child {
            width: 45px !important;
            height: 45px !important;
            font-size: 18px !important;
        }

        /* ==================== STEP 2 SPECIFIC - SMALL SCREENS ==================== */

        #step2>div>div:nth-child(3),
        #step2>div>div:nth-child(5),
        #step2>div>div:nth-child(6) {
            padding: 16px !important;
            margin-bottom: 25px !important;
        }

        /* Section headers */
        #step2 h4[data-i18n="father_info"],
        #step2 h4[data-i18n="mother_info"],
        #step2 h4[data-i18n="birth_certificate_title"] {
            font-size: 15px !important;
            margin-bottom: 15px !important;
        }

        /* Form field containers */
        #step2>div>div:nth-child(3)>div>div,
        #step2>div>div:nth-child(5)>div>div {
            padding: 14px !important;
        }

        /* Birth Certificate upload */
        #step2>div>div:nth-child(6)>div {
            padding: 16px !important;
        }

        #birthCertificatePlaceholder {
            width: 130px !important;
            height: 91px !important;
        }

        #birthCertificatePreview {
            width: 130px !important;
            height: 91px !important;
        }

        /* ==================== STEP 3 SPECIFIC - SMALL SCREENS ==================== */

        #step3>div>div:nth-child(3),
        #step3>div>div:nth-child(4),
        #step3>div>div:nth-child(5) {
            padding: 16px !important;
            margin-bottom: 25px !important;
        }

        /* Section headers */
        #step3 h4[data-i18n="personal_info_title"],
        #step3 h4[data-i18n="assessment_title"],
        #step3 h4[data-i18n="guardian_photo_title"] {
            font-size: 15px !important;
            margin-bottom: 15px !important;
        }

        /* Form field containers */
        #step3>div>div:nth-child(3)>div>div,
        #step3>div>div:nth-child(4)>div>div {
            padding: 14px !important;
        }

        /* Guardian Photo upload */
        #step3>div>div:nth-child(5)>div {
            padding: 16px !important;
        }

        #guardianPhotoPlaceholder {
            width: 130px !important;
            height: 130px !important;
        }

        #guardianPhotoPreview {
            width: 130px !important;
            height: 130px !important;
        }

        /* ==================== STEP 4 SPECIFIC - SMALL SCREENS ==================== */

        #step4>div>div:nth-child(2),
        #step4>div>div:nth-child(3),
        #step4>div>div:nth-child(4),
        #step4>div>div:nth-child(5),
        #step4>div>div:nth-child(6) {
            padding: 16px !important;
            margin-bottom: 25px !important;
        }

        /* Section headers */
        #step4 h4[data-i18n="duration_title"],
        #step4 h4[data-i18n="powers_title"],
        #step4 h4[data-i18n="restrictions_title"],
        #step4 h4[data-i18n="shariah_title"],
        #step4 h4[data-i18n="witnesses_title"] {
            font-size: 15px !important;
            margin-bottom: 15px !important;
        }

        /* Powers granted checkboxes */
        #step4>div>div:nth-child(3)>div>div {
            padding: 16px !important;
            gap: 8px !important;
        }

        /* Checkbox labels */
        #step4 label[style*="display: flex; align-items: center; gap: 12px"] {
            padding: 10px !important;
            gap: 8px !important;
        }

        #step4 label[style*="display: flex; align-items: center; gap: 12px"] span {
            font-size: 12px !important;
        }

        /* Form field containers */
        #step4>div>div:nth-child(2)>div>div,
        #step4>div>div:nth-child(5)>div>div,
        #step4>div>div:nth-child(6)>div>div>div,
        #step4>div>div:nth-child(6)>div+div>div>div {
            padding: 14px !important;
        }

        /* Witness subtitles */
        #step4 h5[data-i18n="witness1_subtitle"],
        #step4 h5[data-i18n="witness2_subtitle"] {
            font-size: 13px !important;
            margin-bottom: 12px !important;
        }

        /* ==================== COMMON STYLES - SMALL SCREENS ==================== */

        /* Input fields, selects, textareas */
        input,
        select,
        textarea {
            padding: 10px 14px !important;
            font-size: 13px !important;
            border-radius: 8px !important;
        }

        /* Labels */
        label {
            font-size: 12px !important;
            margin-bottom: 5px !important;
        }

        /* Icons in headers */
        h4 svg {
            width: 18px !important;
            height: 18px !important;
        }

        /* Upload text */
        p[style*="font-size: 14px"] {
            font-size: 13px !important;
        }

        p[style*="color: rgba(255,255,255,0.7)"] {
            font-size: 11px !important;
            margin-top: 10px !important;
        }
    }

    /* Fix for iOS input zoom */
    @media screen and (max-width: 768px) {

        #step2 input,
        #step2 select,
        #step2 textarea,
        #step3 input,
        #step3 select,
        #step3 textarea,
        #step4 input,
        #step4 select,
        #step4 textarea {
            font-size: 16px !important;
        }
    }

    /* Ensure proper spacing on all mobile devices */
    @media (max-width: 768px) {

        #step2,
        #step3,
        #step4 {
            margin: 0 auto !important;
            max-width: 100% !important;
        }
    }
</style>

<script>
    // Main Application Logic
    let currentStep = 1;
    const totalSteps = 4;
    const completedSteps = new Set();

    // Step data
    const stepData = {
        1: {
            title: "Ward (Majhour) Details",
            subtitle: "Step 1 of 4: Ward Information & Photograph"
        },
        2: {
            title: "Parental Information",
            subtitle: "Step 2 of 4: Biological Parents Information"
        },
        3: {
            title: "Guardian Applicant Details",
            subtitle: "Step 3 of 4: Prospective Guardian Information"
        },
        4: {
            title: "Guardianship Terms",
            subtitle: "Step 4 of 4: Terms & Official Verification"
        }
    };

    // Initialize the application
    document.addEventListener('DOMContentLoaded', function () {
        updateUI();
        setupEventListeners();
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
                        <svg style="color: #2C5C36; width: 100%; height: 100%;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
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
    
    // ✅ ADD THIS: Show preview button only on last step
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
        setTimeout(() => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }, 100);
    }

    // Calculate age from date of birth
    function calculateAge() {
        const dobInput = document.querySelector('input[name="ward_dob"]');
        const ageInput = document.querySelector('input[name="ward_age"]');

        if (dobInput.value) {
            const dob = new Date(dobInput.value);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            ageInput.value = age;
        }
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
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }

    // Validation Functions
    function validateCurrentStep() {
        const currentStepEl = document.getElementById(`step${currentStep}`);
        const requiredFields = currentStepEl.querySelectorAll('[data-required="true"]');
        let isValid = true;
        let firstInvalidField = null;

        // Special validation for checkboxes in step 4
        if (currentStep === 4) {
            const checkboxes = currentStepEl.querySelectorAll('input[type="checkbox"][name="powers_granted[]"]');
            let checkboxChecked = false;
            checkboxes.forEach(cb => {
                if (cb.checked) checkboxChecked = true;
            });

            if (!checkboxChecked) {
                isValid = false;
                Swal.fire({
                    icon: 'warning',
                    title: 'Powers Required',
                    text: 'Please select at least one power to grant to the guardian',
                    confirmButtonColor: '#2C5C36'
                });
            }
        }

        requiredFields.forEach(field => {
            let fieldValid = true;

            if (field.type === 'file') {
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

    function validatePhoneNumber(phone) {
        // Ugandan phone number validation
        const regex = /^(\+256|256|0)?(7|3)\d{8}$/;
        return regex.test(phone.replace(/\s+/g, ''));
    }

    function validateNIN(nin) {
        // NIN validation (14 characters, alphanumeric)
        return /^[A-Z0-9]{14}$/.test(nin.toUpperCase());
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

    // Setup event listeners
    function setupEventListeners() {
        // Step indicator clicks
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

        // Input validation on blur
        document.addEventListener('blur', function (e) {
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

    // Form Submission
    document.getElementById('multiStepForm').addEventListener('submit', function (e) {
        e.preventDefault();

        // Validate final step
        if (!validateCurrentStep()) return;

        // Confirm submission
        Swal.fire({
            title: 'Submit Guardianship Application?',
            html: `
                <div style="text-align: left; margin: 20px 0;">
                    <p style="margin-bottom: 10px;">Are you sure you want to submit this guardianship application?</p>
                    <div style="background: #f8fafc; padding: 15px; border-radius: 10px; border-left: 4px solid #2C5C36;">
                        <p style="font-weight: 600; margin: 0 0 5px 0; color: #2C5C36;">Please verify:</p>
                        <ul style="margin: 0; padding-left: 20px; font-size: 14px;">
                            <li>All information is accurate</li>
                            <li>Photos are clear and uploaded</li>
                            <li>Parental information is correct</li>
                            <li>Witness details are complete</li>
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
                            .content
                    }
                })
                    .then(async response => {

                        // 🔥 IF CONTROLLER RETURNS dd(), dump(), validation HTML, etc.
                        if (!response.ok) {
                            const text = await response.text();
                            document.open();
                            document.write(text);
                            document.close();
                            return;
                        }

                        // ✅ ONLY parse JSON when response is OK
                        const data = await response.json();

                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Application Submitted!',
                                html: `
                                    <div style="text-align: center; margin: 20px 0;">
                                        <div style="width: 80px; height: 80px; background: #d1fae5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#2C5C36" stroke-width="3">
                                                <path d="M20 6L9 17l-5-5"/>
                                            </svg>
                                        </div>
                                        <h3 style="color: #2C5C36; margin-bottom: 10px;">Success!</h3>
                                        <p style="color: #6b7280;">Your guardianship application has been submitted successfully.</p>
                                        
                                        <div style="margin: 30px 0 20px 0; padding: 15px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                                            <h3 style="color: #2C5C36; margin: 0 0 8px 0; font-size: 18px; font-weight: 700;">
                                                Reference Number
                                            </h3>
                                            <div style="font-size: 24px; font-weight: 800; color: #2C5C36; letter-spacing: 1px; padding: 5px 0;">
                                                ${data.application_id || 'N/A'}
                                            </div>
                                            <p style="color: #64748b; font-size: 13px; margin: 10px 0 0 0;">
                                                Please save this reference number for tracking
                                            </p>
                                        </div>
                                    </div>
                                `,
                                confirmButtonText: 'Continue',
                                confirmButtonColor: '#2C5C36'
                            }).then(() => {
                                if (data.redirect_url) {
                                    window.location.href = data.redirect_url;
                                }
                            });

                        } else {
                            throw new Error(data.message || 'Submission failed');
                        }
                    })
                    .catch(err => {
                        // ❌ Only network errors reach here
                        console.error('Network error:', err);
                    });

            }
        });
    });

    // Add CSS for validation errors
    const style = document.createElement('style');
    style.textContent = `
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
        'Ward Details': ['ward_name', 'ward_gender', 'ward_dob', 'ward_age', 'ward_type', 'guardianship_type', 'relationship_type'],
        'Parental Information': ['father_name', 'father_status', 'mother_name', 'mother_status', 'birth_certificate_number'],
        'Guardian Details': ['guardian_name', 'guardian_gender', 'guardian_dob', 'guardian_nin', 'relationship_to_ward', 'guardian_phone', 'guardian_address', 'criminal_record', 'motivation'],
        'Guardianship Terms': ['guardianship_duration', 'reporting_frequency', 'restrictions'],
        'Witness Information': ['witness1_name', 'witness1_nin', 'witness2_name', 'witness2_nin']
    };
    
    // Add header
    html = `
        <div style="margin-bottom: 25px;">
            <h3 style="color: #2C5C36; margin: 0 0 10px 0; font-size: 18px;">
                Guardianship Application Summary
            </h3>
            <p style="color: #64748b; margin: 0; font-size: 14px;">
                Review all information below before submitting your application
            </p>
        </div>
        ${html}
    `;
    
    // Process form data
    const processedData = {};
    formData.forEach((value, key) => {
        if (value instanceof File) return;
        if (!value || value.trim() === "") return;
        
        // Skip system fields
        if (key.startsWith('_') || key === 'csrf_token') return;
        
        // Handle arrays (like powers_granted)
        if (key.includes('[]')) {
            if (!processedData[key]) processedData[key] = [];
            processedData[key].push(value);
        } else {
            processedData[key] = value;
        }
    });
    
    // Display data in organized sections
    for (const [section, fields] of Object.entries(stepCategories)) {
        let sectionHtml = '';
        
        fields.forEach(field => {
            let value = processedData[field];
            
            if (value) {
                // Format field name for display
                const displayField = field
                    .replace(/_/g, ' ')
                    .replace(/\b\w/g, l => l.toUpperCase());
                
                // Format value based on field type
                let displayValue = value;
                
                // Handle select fields with special formatting
                if (field.includes('gender')) {
                    displayValue = value === 'male' ? 'Male' : 'Female';
                } else if (field.includes('status')) {
                    displayValue = formatStatus(value);
                } else if (field.includes('type')) {
                    displayValue = formatType(value);
                } else if (field.includes('relationship')) {
                    displayValue = formatRelationship(value);
                } else if (field.includes('duration')) {
                    displayValue = formatDuration(value);
                } else if (field.includes('frequency')) {
                    displayValue = formatFrequency(value);
                } else if (field.includes('dob')) {
                    displayValue = new Date(value).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                } else if (field.includes('criminal_record')) {
                    displayValue = value === 'yes' ? 'Yes' : 'No';
                }
                
                sectionHtml += `
                    <div style="
                        background: #f8fafc;
                        border: 1px solid #e2e8f0;
                        border-radius: 12px;
                        padding: 18px;
                        transition: all 0.3s;
                    ">
                        <p style="font-size: 12px; font-weight: 600; color: #64748b; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">
                            ${displayField}
                        </p>
                        <p style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">
                            ${displayValue}
                        </p>
                    </div>
                `;
            }
        });
        
        if (sectionHtml) {
            html += `
                <div style="grid-column: 1 / -1; margin-top: 20px;">
                    <h4 style="color: #2C5C36; margin: 0 0 15px 0; font-size: 16px; font-weight: 700; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px;">
                        ${section}
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px;">
                        ${sectionHtml}
                    </div>
                </div>
            `;
        }
    }
    
    // Add powers granted section
    if (processedData['powers_granted[]'] && processedData['powers_granted[]'].length > 0) {
        const powersMap = {
            'financial': 'Financial Decisions',
            'medical': 'Medical Decisions',
            'educational': 'Educational Decisions',
            'travel': 'Travel Permissions',
            'marriage': 'Marriage Consent'
        };
        
        let powersHtml = '';
        processedData['powers_granted[]'].forEach(power => {
            if (powersMap[power]) {
                powersHtml += `
                    <div style="
                        background: #f0f9ff;
                        border: 1px solid #e0f2fe;
                        border-radius: 8px;
                        padding: 10px 15px;
                        margin: 5px 0;
                        display: flex;
                        align-items: center;
                        gap: 8px;
                    ">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2C5C36" stroke-width="2">
                            <path d="M20 6L9 17l-5-5"/>
                        </svg>
                        <span style="color: #1e293b; font-weight: 500;">${powersMap[power]}</span>
                    </div>
                `;
            }
        });
        
        html += `
            <div style="grid-column: 1 / -1; margin-top: 20px;">
                <h4 style="color: #2C5C36; margin: 0 0 15px 0; font-size: 16px; font-weight: 700; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px;">
                    Powers Granted to Guardian
                </h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 10px;">
                    ${powersHtml}
                </div>
            </div>
        `;
    }
    
    // Add summary section
    html += `
        <div style="
            grid-column: 1 / -1;
            margin-top: 30px;
            padding: 20px;
            background: #f0f9ff;
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
                <div>
                    <p style="font-size: 12px; color: #64748b; margin: 0;">Ward Age</p>
                    <p style="font-size: 20px; font-weight: 700; color: #2C5C36; margin: 5px 0 0 0;">
                        ${processedData.ward_age || 'N/A'}
                    </p>
                </div>
            </div>
        </div>
    `;
    
    html += `</div>`;
    
    document.getElementById("previewContent").innerHTML = html;
    
    // Scroll to top of modal content
    document.getElementById("previewContent").scrollTop = 0;
}

// Helper functions for formatting values
function formatStatus(status) {
    const statusMap = {
        'alive': 'Alive',
        'deceased': 'Deceased',
        'unknown': 'Unknown',
        'incapacitated': 'Incapacitated'
    };
    return statusMap[status] || status;
}

function formatType(type) {
    const typeMap = {
        'orphan': 'Orphan',
        'abandoned': 'Abandoned/Foundling',
        'special_needs': 'Special Needs/Incapacitated',
        'normal': 'Normal (Parents alive)',
        'minor': 'Guardianship of Minor',
        'incapacitated': 'Guardianship of Incapacitated Adult',
        'testamentary': 'Testamentary Guardianship',
        'emergency': 'Emergency Guardianship',
        'Relative': 'Relative to Ward',
        'Not Relative': 'Not Related to Ward'
    };
    return typeMap[type] || type;
}

function formatRelationship(rel) {
    const relMap = {
        'father': 'Father',
        'mother': 'Mother',
        'paternal_grandfather': 'Paternal Grandfather',
        'paternal_grandmother': 'Paternal Grandmother',
        'maternal_grandfather': 'Maternal Grandfather',
        'maternal_grandmother': 'Maternal Grandmother',
        'paternal_uncle': 'Paternal Uncle',
        'maternal_uncle': 'Maternal Uncle',
        'brother': 'Brother',
        'sister': 'Sister',
        'aunt': 'Aunt',
        'nephew': 'Nephew',
        'other_relative': 'Other Relative',
        'family_friend': 'Family Friend',
        'court_appointed': 'Court Appointed'
    };
    return relMap[rel] || rel;
}

function formatDuration(duration) {
    const durationMap = {
        'until_majority': 'Until Ward Reaches Majority (18 years)',
        'specific_period': 'Specific Period',
        'indefinite': 'Indefinite (for incapacitated adults)'
    };
    return durationMap[duration] || duration;
}

function formatFrequency(freq) {
    const freqMap = {
        'monthly': 'Monthly',
        'quarterly': 'Quarterly',
        'annually': 'Annually',
        'none': 'No Regular Reporting'
    };
    return freqMap[freq] || freq;
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
            <title>Guardianship Application Preview</title>
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
                Guardianship Application - Preview
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

// Add event listeners for modal
document.addEventListener('DOMContentLoaded', function() {
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
});

// If you have a mobile navigation adjustment function, add this
function adjustNavigationForMobile() {
    const previewBtn = document.getElementById('previewBtn');
    // ... existing code ...
    
    if (window.innerWidth <= 768) {
        if (previewBtn) {
            previewBtn.style.cssText = `
                padding: 14px 20px !important;
                font-size: 15px !important;
                width: 100% !important;
                justify-content: center !important;
                display: ${previewBtn.style.display === 'none' ? 'none' : 'flex'} !important;
                margin: 0 !important;
                box-shadow: none !important;
            `;
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
}
</style>
@include('layouts.form-footers')