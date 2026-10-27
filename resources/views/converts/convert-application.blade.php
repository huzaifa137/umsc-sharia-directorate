@include('layouts.form-headers')

<script>
    const translations = {
        en: {

            preview_former_names_label: "Former Names",
            preview_former_religion_label: "Former Religion",
            preview_dob_label: "Date of Birth",
            preview_occupation_label: "Occupation",
            preview_current_residence_label: "Current Residence",
            preview_contact_label: "Contact Information",
            preview_father_name_label: "Father's Name",
            preview_mother_name_label: "Mother's Name",
            preview_home_address_label: "Home Address",
            preview_district_label: "District",
            preview_county_label: "County",
            preview_new_names_label: "New Muslim Names",
            preview_conversion_date_label: "Date of Conversion",
            preview_conversion_place_label: "Place of Entry to Islam",
            preview_guardian_name_label: "Guardian's Name",
            preview_guardian_occupation_label: "Guardian's Occupation",
            preview_guardian_declaration_date_label: "Guardian's Declaration Date",
            preview_conversion_reasons_label: "Reasons for Joining Islam",
            preview_guardian_declaration_label: "Guardian's Declaration",
            preview_declaration_agreement_label: "Declaration Agreement",
            preview_officer_name_label: "Verifying Officer's Name",
            preview_officer_position_label: "Officer's Position",
            preview_registration_number_label: "Registration Number",
            preview_verification_date_label: "Date of Verification",
            preview_officer_remarks_label: "Remarks/Additional Notes",
            section_a_heading: "SECTION A: CONVERT'S DECLARATION",
            section_b_heading: "SECTION B: UPON CONVERSION",
            section_c_heading: "SECTION C: DECLARATION OF FAITH",
            section_d_heading: "OFFICER VERIFICATION",
            declaration_accepted_text: "✓ Accepted",

            preview_btn: "Preview Declaration",
            prev_btn: "Previous",
            next_btn: "Next Step",
            submit_btn: "Submit Application",
            back_to_dashboard: "Back to Dashboard",
            convert_title: "Convert Declaration",
            convert_subtitle: "Complete all 4 sections to declare your conversion to Islam",
            application_progress_label: "Application Progress",
            step_number: "Step",
            convert_step1_title: "Section A: Convert's Declaration",
            convert_step2_title: "Section B: Upon Conversion",
            convert_step3_title: "Section C: Declaration",
            convert_step4_title: "Officer Verification",
            instructions_title: "Important Instructions",
            convert_instruction1: "• Provide accurate personal information",
            convert_instruction2: "• All required fields (*) must be filled",
            convert_instruction3: "• Read declaration carefully before signing",
            convert_instruction4: "• Officer verification is mandatory",
            step_text: "Step",
            of_text: "of",

            // Convert Declaration form translations
            step1_description: "Step 1 of 4: Personal Information & Background",
            section_a_title: "SECTION A: CONVERT'S DECLARATION",
            section_a_description: "Personal information before conversion",
            section_b_title: "SECTION B: UPON CONVERSION",
            section_b_description: "Information after conversion to Islam",
            section_c_title: "SECTION C: DECLARATION",
            section_c_description: "Official declaration of faith",
            section_d_title: "OFFICER VERIFICATION",
            section_d_description: "Official verification and processing",

            // Step 1 fields
            former_names_label: "Former Names *",
            former_names_placeholder: "Enter your former names",
            former_religion_label: "Former Religion *",
            select_religion: "Select Religion",
            christianity: "Christianity",
            hinduism: "Hinduism",
            buddhism: "Buddhism",
            traditional: "Traditional African Religion",
            atheist: "Atheist/Agnostic",
            other: "Other",
            dob_label: "Date of Birth *",
            occupation_label: "Occupation *",
            occupation_placeholder: "Your current occupation",
            current_residence_label: "Current Residence *",
            current_residence_placeholder: "Your current place of residence",
            contact_label: "Contact Information *",
            contact_placeholder: "Phone number (e.g., +256 XXX XXX XXX)",
            father_name_label: "Father's Name *",
            father_name_placeholder: "Your father's full name",
            mother_name_label: "Mother's Name *",
            mother_name_placeholder: "Your mother's full name",
            home_address_label: "Home Address *",
            home_address_placeholder: "Complete home address",
            county_label: "County *",
            select_county: "Select County",
            district_label: "District *",
            select_district: "Select District",

            // Step 2 fields
            new_names_label: "New Muslim Names *",
            new_names_placeholder: "Your new Islamic names",
            conversion_date_label: "Date of Conversion *",
            conversion_place_label: "Place of Entry to Islam *",
            conversion_place_placeholder: "Where you accepted Islam",
            guardian_name_label: "Guardian's Name *",
            guardian_name_placeholder: "Name of your Islamic guardian",
            guardian_occupation_label: "Guardian's Occupation *",
            guardian_occupation_placeholder: "Guardian's occupation",
            guardian_declaration_date_label: "Guardian's Declaration Date *",
            conversion_reasons_label: "Reasons for Joining Islam *",
            conversion_reasons_placeholder: "Explain why you decided to embrace Islam...",
            guardian_declaration_label: "Guardian's Declaration *",
            guardian_declaration_placeholder: "Guardian's statement regarding your conversion...",

            // Step 3 fields
            declaration_title: "DECLARATION OF FAITH (SHAHADA)",
            shahada_transliteration: '"Ash-hadu an la ilaha illa Allah, wa ash-hadu anna Muhammadan rasulu Allah."',
            shahada_translation: '"I bear witness that there is no god but Allah, and I bear witness that Muhammad is the Messenger of Allah."',
            full_declaration_title: "FULL DECLARATION:",
            declaration_intro: "I, [Your Name Will Appear Here], do hereby solemnly declare and affirm that:",
            declaration_point1: "I have willingly and consciously embraced Islam as my faith and way of life",
            declaration_point2: "I believe in the Oneness of Allah (God) and accept Muhammad (peace be upon him) as the final Messenger",
            declaration_point3: "I accept all the pillars of Islam and articles of faith",
            declaration_point4: "I renounce all previous beliefs and practices contrary to Islamic teachings",
            declaration_point5: "I commit to following the teachings of the Holy Quran and Sunnah",
            declaration_point6: "This declaration is made voluntarily, without any coercion or undue influence",
            signature_label: "Digital Signature *",
            signature_note: "Upload a clear image of your handwritten signature (PNG or JPG)",
            upload_signature_btn: "Upload Signature",
            no_file_chosen: "No file chosen",
            signature_preview: "Signature Preview:",
            declaration_date_label: "Date of Declaration *",
            declaration_agreement_label: "Declaration Agreement *",
            declaration_agreement_text: "I hereby solemnly and sincerely declare that the information provided in this declaration is true and correct to the best of my knowledge. I understand that providing false information may invalidate this declaration. I acknowledge that this declaration constitutes my formal conversion to Islam.",

            // Step 4 fields
            officer_name_label: "Verifying Officer's Name *",
            officer_name_placeholder: "Full name of verifying officer",
            officer_position_label: "Officer's Position *",
            officer_position_placeholder: "Position/Rank of officer",
            registration_number_label: "Registration Number *",
            registration_number_placeholder: "Official registration number",
            verification_date_label: "Date of Verification *",
            certification_label: "Certification Statement",
            certification_text: '"I hereby certify that I have verified the identity of the applicant and witnessed their declaration of faith. The conversion has been conducted in accordance with Islamic principles and requirements."',
            officer_signature_label: "Officer's Signature *",
            upload_officer_signature_btn: "Upload Officer Signature",
            official_stamp_label: "Official Stamp *",
            upload_official_stamp_btn: "Upload Official Stamp",
            remarks_label: "Remarks/Additional Notes",
            remarks_placeholder: "Any additional notes or observations...",

            // Navigation
            of_fields: "of",
            fields_completed: "fields completed",
            submit_declaration_btn: "Submit Declaration",
        },
        ar: {

            preview_former_names_label: "الأسماء السابقة",
            preview_former_religion_label: "الدين السابق",
            preview_dob_label: "تاريخ الميلاد",
            preview_occupation_label: "المهنة",
            preview_current_residence_label: "محل الإقامة الحالي",
            preview_contact_label: "معلومات الاتصال",
            preview_father_name_label: "اسم الوالد",
            preview_mother_name_label: "اسم الوالدة",
            preview_home_address_label: "عنوان المنزل",
            preview_district_label: "المنطقة",
            preview_county_label: "المقاطعة",
            preview_new_names_label: "الأسماء الإسلامية الجديدة",
            preview_conversion_date_label: "تاريخ اعتناق الإسلام",
            preview_conversion_place_label: "مكان الدخول في الإسلام",
            preview_guardian_name_label: "اسم الوصي",
            preview_guardian_occupation_label: "مهنة الوصي",
            preview_guardian_declaration_date_label: "تاريخ إقرار الوصي",
            preview_conversion_reasons_label: "أسباب اعتناق الإسلام",
            preview_guardian_declaration_label: "إقرار الوصي",
            preview_declaration_agreement_label: "الموافقة على الإقرار",
            preview_officer_name_label: "اسم الموظف المُحقِّق",
            preview_officer_position_label: "منصب الموظف",
            preview_registration_number_label: "رقم التسجيل",
            preview_verification_date_label: "تاريخ التحقق",
            preview_officer_remarks_label: "ملاحظات إضافية",
            section_a_heading: "القسم أ: إقرار المعتنق",
            section_b_heading: "القسم ب: بعد اعتناق الإسلام",
            section_c_heading: "القسم ج: الشهادتان",
            section_d_heading: "تحقق الموظف",
            declaration_accepted_text: "✓ مقبول",

            preview_btn: "معاينة الإقرار",
            prev_btn: "السابق",
            next_btn: "الخطوة التالية",
            submit_btn: "إرسال الطلب",

            convert_title: "إعلان المهتدي",
            convert_subtitle: "أكمل جميع الأقسام الأربعة للإعلان عن تحولك إلى الإسلام",
            application_progress_label: "تقدم الطلب",
            step_number: "الخطوة",
            convert_step1_title: "القسم أ: إعلان المهتدي",
            convert_step2_title: "القسم ب: عند التحول",
            convert_step3_title: "القسم ج: الإعلان",
            convert_step4_title: "تحقق الضابط",
            instructions_title: "تعليمات مهمة",
            convert_instruction1: "• قدم معلومات شخصية دقيقة",
            convert_instruction2: "• يجب تعبئة جميع الحقول المطلوبة (*)",
            convert_instruction3: "• اقرأ الإعلان بعناية قبل التوقيع",
            convert_instruction4: "• تحقق الضابط إلزامي",
            step_text: "الخطوة",
            of_text: "من",

            // Convert Declaration form translations in Arabic
            step1_description: "الخطوة 1 من 4: المعلومات الشخصية والخلفية",
            section_a_title: "القسم أ: إعلان المهتدي",
            section_a_description: "المعلومات الشخصية قبل التحول",
            section_b_title: "القسم ب: عند التحول",
            section_b_description: "المعلومات بعد التحول إلى الإسلام",
            section_c_title: "القسم ج: الإعلان",
            section_c_description: "الإعلان الرسمي للإيمان",
            section_d_title: "تحقق الضابط",
            section_d_description: "التحقق الرسمي والمعالجة",

            // Step 1 fields in Arabic
            former_names_label: "الأسماء السابقة *",
            former_names_placeholder: "أدخل أسماءك السابقة",
            former_religion_label: "الدين السابق *",
            select_religion: "اختر الدين",
            christianity: "المسيحية",
            hinduism: "الهندوسية",
            buddhism: "البوذية",
            traditional: "الدين الأفريقي التقليدي",
            atheist: "ملحد/لاأدري",
            other: "آخر",
            dob_label: "تاريخ الميلاد *",
            occupation_label: "المهنة *",
            occupation_placeholder: "مهنتك الحالية",
            current_residence_label: "مكان الإقامة الحالي *",
            current_residence_placeholder: "مكان إقامتك الحالي",
            contact_label: "معلومات الاتصال *",
            contact_placeholder: "رقم الهاتف (مثل، +256 XXX XXX XXX)",
            father_name_label: "اسم الأب *",
            father_name_placeholder: "الاسم الكامل لوالدك",
            mother_name_label: "اسم الأم *",
            mother_name_placeholder: "الاسم الكامل لوالدتك",
            home_address_label: "عنوان المنزل *",
            home_address_placeholder: "عنوان المنزل الكامل",
            county_label: "المقاطعة *",
            select_county: "اختر المقاطعة",
            district_label: "المقاطعة الفرعية *",
            select_district: "اختر المقاطعة الفرعية",

            // Step 2 fields in Arabic
            new_names_label: "الأسماء الإسلامية الجديدة *",
            new_names_placeholder: "أسماءك الإسلامية الجديدة",
            conversion_date_label: "تاريخ التحول *",
            conversion_place_label: "مكان الدخول في الإسلام *",
            conversion_place_placeholder: "حيث قبلت الإسلام",
            guardian_name_label: "اسم الوصي *",
            guardian_name_placeholder: "اسم الوصي الإسلامي الخاص بك",
            guardian_occupation_label: "مهنة الوصي *",
            guardian_occupation_placeholder: "مهنة الوصي",
            guardian_declaration_date_label: "تاريخ إعلان الوصي *",
            conversion_reasons_label: "أسباب الانضمام إلى الإسلام *",
            conversion_reasons_placeholder: "اشرح لماذا قررت اعتناق الإسلام...",
            guardian_declaration_label: "إعلان الوصي *",
            guardian_declaration_placeholder: "بيان الوصي بشأن تحولك...",

            // Step 3 fields in Arabic
            declaration_title: "إعلان الإيمان (الشهادة)",
            shahada_transliteration: '"أشهد أن لا إله إلا الله وأشهد أن محمدا رسول الله."',
            shahada_translation: '"أشهد أن لا إله إلا الله وأشهد أن محمداً رسول الله."',
            full_declaration_title: "الإعلان الكامل:",
            declaration_intro: "أنا، [اسمك سيظهر هنا]، أعلن وأؤكد رسمياً بأن:",
            declaration_point1: "لقد اعتنقت الإسلام طواعية ووعياً كدين وأسلوب حياة",
            declaration_point2: "أؤمن بوحدانية الله وأقبل محمد (صلى الله عليه وسلم) كخاتم الرسل",
            declaration_point3: "أقبل جميع أركان الإسلام وعقائده",
            declaration_point4: "أتخلى عن جميع المعتقدات والممارسات السابقة المخالفة للتعاليم الإسلامية",
            declaration_point5: "أتعهد باتباع تعاليم القرآن الكريم والسنة النبوية",
            declaration_point6: "هذا الإعلان تم طواعية، دون أي إكراه أو تأثير غير لائق",
            signature_label: "التوقيع الرقمي *",
            signature_note: "قم بتحميل صورة واضحة لتوقيعك بخط اليد (PNG أو JPG)",
            upload_signature_btn: "رفع التوقيع",
            no_file_chosen: "لم يتم اختيار ملف",
            signature_preview: "معاينة التوقيع:",
            declaration_date_label: "تاريخ الإعلان *",
            declaration_agreement_label: "اتفاقية الإعلان *",
            declaration_agreement_text: "أعلن رسمياً وبصدق أن المعلومات المقدمة في هذا الإعلان صحيحة وصادقة حسب علمي. أفهم أن تقديم معلومات خاطئة قد يبطل هذا الإعلان. أقر بأن هذا الإعلان يشكل تحولي الرسمي إلى الإسلام.",

            // Step 4 fields in Arabic
            officer_name_label: "اسم الضابط المحقق *",
            officer_name_placeholder: "الاسم الكامل للضابط المحقق",
            officer_position_label: "منصب الضابط *",
            officer_position_placeholder: "المنصب/الرتبة للضابط",
            registration_number_label: "رقم التسجيل *",
            registration_number_placeholder: "رقم التسجيل الرسمي",
            verification_date_label: "تاريخ التحقق *",
            certification_label: "بيان التصديق",
            certification_text: '"أقر بأنني قد تحققت من هوية مقدم الطلب وشهدت إعلان إيمانه. تم إجراء التحول وفقاً للمبادئ والمتطلبات الإسلامية."',
            officer_signature_label: "توقيع الضابط *",
            upload_officer_signature_btn: "رفع توقيع الضابط",
            official_stamp_label: "الختم الرسمي *",
            upload_official_stamp_btn: "رفع الختم الرسمي",
            remarks_label: "ملاحظات/ملاحظات إضافية",
            remarks_placeholder: "أي ملاحظات أو ملاحظات إضافية...",

            // Navigation in Arabic
            of_fields: "من",
            fields_completed: "حقول مكتملة",
            submit_declaration_btn: "إرسال الإعلان",
            back_to_dashboard: "العودة إلى لوحة التحكم",
        },
        sw: {

            preview_former_names_label: "Majina ya Awali",
            preview_former_religion_label: "Dini ya Awali",
            preview_dob_label: "Tarehe ya Kuzaliwa",
            preview_occupation_label: "Kazi",
            preview_current_residence_label: "Makazi ya Sasa",
            preview_contact_label: "Taarifa za Mawasiliano",
            preview_father_name_label: "Jina la Baba",
            preview_mother_name_label: "Jina la Mama",
            preview_home_address_label: "Anwani ya Nyumbani",
            preview_district_label: "Wilaya",
            preview_county_label: "Kaunti",
            preview_new_names_label: "Majina Mapya ya Kiislamu",
            preview_conversion_date_label: "Tarehe ya Kusilimu",
            preview_conversion_place_label: "Mahali pa Kuingia Uislamu",
            preview_guardian_name_label: "Jina la Mlezi",
            preview_guardian_occupation_label: "Kazi ya Mlezi",
            preview_guardian_declaration_date_label: "Tarehe ya Tamko la Mlezi",
            preview_conversion_reasons_label: "Sababu za Kujiunga na Uislamu",
            preview_guardian_declaration_label: "Tamko la Mlezi",
            preview_declaration_agreement_label: "Kukubali Tamko",
            preview_officer_name_label: "Jina la Afisa Aliyethibitisha",
            preview_officer_position_label: "Wadhifa wa Afisa",
            preview_registration_number_label: "Namba ya Usajili",
            preview_verification_date_label: "Tarehe ya Uthibitisho",
            preview_officer_remarks_label: "Maelezo ya Ziada",
            section_a_heading: "SEHEMU A: TAMKO LA MSILIMU",
            section_b_heading: "SEHEMU B: BAADA YA KUSILIMU",
            section_c_heading: "SEHEMU C: SHAHADA",
            section_d_heading: "UTHIBITISHO WA AFISA",
            declaration_accepted_text: "✓ Imekubaliwa",

            preview_btn: "Hakiki Tamko",
            prev_btn: "Iliyopita",
            next_btn: "Hatua Inayofuata",
            submit_btn: "Wasilisha Maombi",
            back_to_dashboard: "Rudi kwenye Dashibodi",
            convert_title: "Tamko la Mgeuzi",
            convert_subtitle: "Kamilisha sehemu zote 4 kutangaza mageuzi yako kwa Uislamu",
            application_progress_label: "Maendeleo ya Maombi",
            step_number: "Hatua",
            convert_step1_title: "Sehemu A: Tamko la Mgeuzi",
            convert_step2_title: "Sehemu B: Wakati wa Mageuzi",
            convert_step3_title: "Sehemu C: Tamko",
            convert_step4_title: "Uthibitisho wa Afisa",
            instructions_title: "Maelekezo Muhimu",
            convert_instruction1: "• Toa taarifa sahihi za kibinafsi",
            convert_instruction2: "• Mazingira yote muhimu (*) lazima yajazwe",
            convert_instruction3: "• Soma tamko kwa makini kabla ya kusaini",
            convert_instruction4: "• Uthibitisho wa afisa ni lazima",
            step_text: "Hatua",
            of_text: "ya",

            // Convert Declaration form translations in Swahili
            step1_description: "Hatua ya 1 ya 4: Taarifa Binafsi na Historia",
            section_a_title: "SEHEMU A: TAMKO LA MGEUZI",
            section_a_description: "Taarifa binafsi kabla ya mageuzi",
            section_b_title: "SEHEMU B: WAKATI WA MAGEUZI",
            section_b_description: "Taarifa baada ya mageuzi kwa Uislamu",
            section_c_title: "SEHEMU C: TAMKO",
            section_c_description: "Tamko rasmi la imani",
            section_d_title: "UTHIBITISHO WA AFISA",
            section_d_description: "Uthibitisho rasmi na usindikaji",

            // Step 1 fields in Swahili
            former_names_label: "Majina ya Zamani *",
            former_names_placeholder: "Ingiza majina yako ya zamani",
            former_religion_label: "Dini ya Zamani *",
            select_religion: "Chagua Dini",
            christianity: "Ukristo",
            hinduism: "Uhindu",
            buddhism: "Ubuddha",
            traditional: "Dini ya Kiafrika ya Jadi",
            atheist: "Mkanamungu/Mtovuamini",
            other: "Nyingine",
            dob_label: "Tarehe ya Kuzaliwa *",
            occupation_label: "Kazi *",
            occupation_placeholder: "Kazi yako ya sasa",
            current_residence_label: "Mahali pa Makazi ya Sasa *",
            current_residence_placeholder: "Mahali pa makazi yako ya sasa",
            contact_label: "Mawasiliano *",
            contact_placeholder: "Namba ya simu (mfano, +256 XXX XXX XXX)",
            father_name_label: "Jina la Baba *",
            father_name_placeholder: "Jina kamili la baba yako",
            mother_name_label: "Jina la Mama *",
            mother_name_placeholder: "Jina kamili la mama yako",
            home_address_label: "Anuani ya Nyumbani *",
            home_address_placeholder: "Anuani kamili ya nyumbani",
            county_label: "Kaunti *",
            select_county: "Chagua Kaunti",
            district_label: "Wilaya *",
            select_district: "Chagua Wilaya",

            // Step 2 fields in Swahili
            new_names_label: "Majina Mapya ya Kiislamu *",
            new_names_placeholder: "Majina yako mapya ya Kiislamu",
            conversion_date_label: "Tarehe ya Mageuzi *",
            conversion_place_label: "Mahali pa Kuingia Uislamu *",
            conversion_place_placeholder: "Ambapo ulikubali Uislamu",
            guardian_name_label: "Jina la Mlezi *",
            guardian_name_placeholder: "Jina la mlezi wako wa Kiislamu",
            guardian_occupation_label: "Kazi ya Mlezi *",
            guardian_occupation_placeholder: "Kazi ya mlezi",
            guardian_declaration_date_label: "Tarehe ya Tamko la Mlezi *",
            conversion_reasons_label: "Sababu za Kujiunga na Uislamu *",
            conversion_reasons_placeholder: "Eleza kwanini uliamua kukubali Uislamu...",
            guardian_declaration_label: "Tamko la Mlezi *",
            guardian_declaration_placeholder: "Kauli ya mlezi kuhusu mageuzi yako...",

            // Step 3 fields in Swahili
            declaration_title: "TAMKO LA IMANI (SHAHADA)",
            shahada_transliteration: '"Ash-hadu an la ilaha illa Allah, wa ash-hadu anna Muhammadan rasulu Allah."',
            shahada_translation: '"Ninashuhudia kwamba hakuna mungu ila Allah, na ninashuhudia kwamba Muhammad ni Mtume wa Allah."',
            full_declaration_title: "TAMKO KAMILI:",
            declaration_intro: "Mimi, [Jina Lako Litaonekana Hapa], ninatamka na kuthibitisha kwa dhati kwamba:",
            declaration_point1: "Nimekubali Uislamu kwa hiari na ufahamu kama dini yangu na njia ya maisha",
            declaration_point2: "Ninaamini katika Umoja wa Allah (Mungu) na nikakubali Muhammad (amani iwe juu yake) kama Mtume wa mwisho",
            declaration_point3: "Ninakubali nguzo zote za Uislamu na misingi ya imani",
            declaration_point4: "Ninatoka kwa imani na mazoea yote ya zamani yanayokinzana na mafundisho ya Kiislamu",
            declaration_point5: "Ninajikita kufuata mafundisho ya Quran Takatifu na Sunnah",
            declaration_point6: "Tamko hili limetolewa kwa hiari, bila ushirikishi wowote au ushawishi usiofaa",
            signature_label: "Sahihi ya Dijitali *",
            signature_note: "Pakia picha wazi ya sahihi yako iliyoandikwa kwa mkono (PNG au JPG)",
            upload_signature_btn: "Pakia Sahihi",
            no_file_chosen: "Hakuna faili iliyochaguliwa",
            signature_preview: "Hakiki ya Sahihi:",
            declaration_date_label: "Tarehe ya Tamko *",
            declaration_agreement_label: "Makubaliano ya Tamko *",
            declaration_agreement_text: "Ninatangaza kwa dhati na uaminifu kwamba taarifa zilizotolewa katika tamko hili ni za kweli na sahihi kadiri ya ujuzi wangu. Ninaelewa kuwa kutoa taarifa potofu kunaweza kuhatarisha tamko hili. Ninatambua kwamba tamko hili linajenga mageuzi yangu rasmi ya Uislamu.",

            // Step 4 fields in Swahili
            officer_name_label: "Jina la Afisa Anayethibitisha *",
            officer_name_placeholder: "Jina kamili la afisa anayethibitisha",
            officer_position_label: "Cheo cha Afisa *",
            officer_position_placeholder: "Cheo/Cheo cha afisa",
            registration_number_label: "Namba ya Usajili *",
            registration_number_placeholder: "Namba rasmi ya usajili",
            verification_date_label: "Tarehe ya Uthibitisho *",
            certification_label: "Kauli ya Udhibitisho",
            certification_text: '"Ninathibitisha kwamba nimehakiki utambulisho wa mteja na nimehudhuria tamko lao la imani. Mageuzi yamefanywa kwa mujibu wa kanuni na mahitaji ya Kiislamu."',
            officer_signature_label: "Sahihi ya Afisa *",
            upload_officer_signature_btn: "Pakia Sahihi ya Afisa",
            official_stamp_label: "Muhuri Rasmi *",
            upload_official_stamp_btn: "Pakia Muhuri Rasmi",
            remarks_label: "Maelezo/Maelezo ya Ziada",
            remarks_placeholder: "Maelezo yoyote ya ziada au uchunguzi...",

            // Navigation in Swahili
            of_fields: "ya",
            fields_completed: "sehemu zimekamilika",
            submit_declaration_btn: "Wasilisha Tamko"
        }
    };
</script>

<div style="display: flex; min-height: 100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <!-- Left Side: Step Navigation -->
    <div
        style="flex: 0.4; background: #f8fafc; padding: 40px; overflow-y: auto; border-right: 1px solid #e2e8f0;">
        <div style="position: sticky; top: 0; background: transparent; padding-bottom: 20px; z-index: 10;">
            <h1 data-i18n="convert_title"
                style="color: #2C5C36; margin-bottom: 5px; font-size: 2rem; font-weight: 800;">
                Convert Declaration</h1>
            <p data-i18n="convert_subtitle"
                style="color: #2C5C36; font-size: 14px; margin-bottom: 30px; line-height: 1.5;">Complete all 4 sections
                to
                declare your conversion to Islam</p>

            <!-- Progress Tracker -->
            <div
                style="margin-bottom: 40px; background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e5e7eb;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span data-i18n="application_progress_label"
                        style="font-size: 14px; color: #2C5C36; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Application
                        Progress</span>
                    <span id="progressPercentage"
                        style="font-size: 20px; color: #2C5C36; font-weight: bold; font-family: monospace;">0%</span>
                </div>
                <div
                    style="height: 10px; background: #f3f4f6; border-radius: 5px; overflow: hidden; margin-bottom: 8px;">
                    <div id="progressBar"
                        style="height: 100%; background: #2C5C36; width: 0%; transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);">
                    </div>
                </div>
                <p id="completedSteps"
                    style="font-size: 13px; color: #9ca3af; margin-top: 10px; text-align: center; font-weight: 500;">0
                    of 4 sections completed</p>
            </div>

            <!-- Step Indicators -->
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @php
                    $stepTitles = [
                        1 => 'convert_step1_title',
                        2 => 'convert_step2_title',
                        3 => 'convert_step3_title',
                        4 => 'convert_step4_title',
                    ];
                    $stepIcons = ['📝', '🕌', '📄', '👮'];
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
                            <div data-i18n="step_number"
                                style="font-size: 15px; font-weight: 700; color: #2C5C36; letter-spacing: -0.2px;">Step
                                {{ $i }}
                            </div>
                            <div data-i18n="{{ $stepTitles[$i] }}"
                                style="font-size: 13px; color: #9ca3af; margin-top: 4px; font-weight: 500;">
                                {{-- Text will be filled by JavaScript --}}
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
                style="margin-top: 40px; background: #f3e8ff; padding: 24px; border-radius: 14px; border-left: 4px solid #2C5C36;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <div
                        style="width: 32px; height: 32px; background: #2C5C36; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 18px; height: 18px; color: white;" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <h4 data-i18n="instructions_title"
                        style="color: #2C5C36; margin: 0; font-size: 15px; font-weight: 700;">Important Instructions
                    </h4>
                </div>
                <ul style="color: #2C5C36; font-size: 13px; padding-left: 24px; margin: 0; list-style-type: none;">
                    <li data-i18n="convert_instruction1"
                        style="margin-bottom: 8px; position: relative; padding-left: 8px;">• Provide accurate personal
                        information</li>
                    <li data-i18n="convert_instruction2"
                        style="margin-bottom: 8px; position: relative; padding-left: 8px;">• All required fields (*)
                        must be filled</li>
                    <li data-i18n="convert_instruction3"
                        style="margin-bottom: 8px; position: relative; padding-left: 8px;">• Read declaration carefully
                        before signing</li>
                    <li data-i18n="convert_instruction4" style="position: relative; padding-left: 8px;">• Officer
                        verification is mandatory</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Right Side: Form Content -->
    <div
        style="flex: 1; background: #ffffff; padding: 40px; overflow-y: auto;">
        <div
            style="position: sticky; top: 0; background: #ffffff; padding-bottom: 20px; z-index: 10; border-bottom: 1px solid #e5e7eb; margin-bottom: 30px; backdrop-filter: blur(10px);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 id="currentStepTitle" data-i18n="convert_step1_title"
                    style="color: #2C5C36; margin: 0; font-size: 1.8rem; font-weight: 800; letter-spacing: -0.5px;">
                    Section A: Convert's Declaration</h2>
                <div id="stepCompletionStatus"
                    style="background: #2C5C36; padding: 8px 20px; border-radius: 20px; font-size: 14px; color: white; font-weight: 600; box-shadow: 0 2px 8px rgba(124, 58, 237, 0.2);">
                    <span data-i18n="step_text">Step</span> <span id="currentStepNumber"
                        style="font-weight: 800;">1</span> <span data-i18n="of_text">of</span> 4
                </div>
            </div>
            <p id="currentStepSubtitle" data-i18n="step1_description"
                style="color: #2C5C36; margin: 10px 0 0 0; font-size: 15px; font-weight: 500;">
                Step 1 of 4: Personal Information & Background</p>
        </div>

        <form method="POST" action="{{ route('save.convert.application') }}" enctype="multipart/form-data"
            id="multiStepForm">
            @csrf

            <!-- Step 1: Section A - Convert's Declaration -->
            <div class="form-step active" id="step1">
                <div
                    style="background: #2C5C36; border-radius: 20px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(124, 58, 237, 0.15);">
                    <!-- Background Pattern -->
                    <div
                        style="position: absolute; top: -100px; right: -100px; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; filter: blur(20px);">
                    </div>
                    <div
                        style="position: absolute; bottom: -150px; left: -150px; width: 400px; height: 400px; background: rgba(255,255,255,0.03); border-radius: 50%; filter: blur(30px);">
                    </div>

                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div
                            style="background: white; color: #2C5C36; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 24px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
                            A</div>
                        <div>
                            <h3 data-i18n="section_a_title"
                                style="color: white; font-size: 1.8rem; font-weight: 800; margin: 0; letter-spacing: -0.5px;">
                                SECTION A: CONVERT'S DECLARATION</h3>
                            <p data-i18n="section_a_description"
                                style="color: rgba(255,255,255,0.8); margin: 8px 0 0 0; font-size: 15px; font-weight: 500;">
                                Personal information before conversion</p>
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

                        <!-- Former Names -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="former_names_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Former
                                Names *</label>
                            <input type="text" name="former_names" data-i18n-placeholder="former_names_placeholder"
                                style="{{ $fieldStyle }}" data-required="true">
                        </div>

                        <!-- Former Religion -->
                        <div style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08);
    padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);">

                            <label data-i18n="former_religion_label" style="font-size: 13px; color: rgba(255,255,255,0.95);
        font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">
                                Former Religion *
                            </label>

                            <!-- Dropdown -->
                            <select id="formerReligionSelect" style="{{ $selectStyle }}" data-required="true">
                                <option value="" data-i18n="select_religion">Select Religion</option>
                                <option value="christianity" data-i18n="christianity">Christianity</option>
                                <option value="hinduism" data-i18n="hinduism">Hinduism</option>
                                <option value="buddhism" data-i18n="buddhism">Buddhism</option>
                                <option value="traditional" data-i18n="traditional">Traditional African Religion
                                </option>
                                <option value="atheist" data-i18n="atheist">Atheist/Agnostic</option>
                                <option value="other" data-i18n="other">Other</option>
                            </select>

                            <!-- Other text input (custom style, no selectStyle) -->
                            <input type="text" id="formerReligionOther" placeholder="Enter Former Religion" style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #cbd5e1;
               margin-top: 12px; display: none; background: #fff; color: #000;" data-required="true" />

                            <!-- Hidden field that always submits -->
                            <input type="hidden" name="former_religion" id="formerReligionHidden" />
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                const select = document.getElementById("formerReligionSelect");
                                const otherInput = document.getElementById("formerReligionOther");
                                const hiddenField = document.getElementById("formerReligionHidden");

                                function updateFormerReligion() {
                                    if (select.value === "other") {
                                        otherInput.style.display = "block";
                                        hiddenField.value = "";
                                        otherInput.setAttribute("data-required", "true");
                                    } else {
                                        otherInput.style.display = "none";
                                        hiddenField.value = select.value;
                                        otherInput.removeAttribute("data-required");
                                        otherInput.value = "";
                                    }
                                }

                                select.addEventListener("change", updateFormerReligion);
                                otherInput.addEventListener("input", function () {
                                    hiddenField.value = otherInput.value;
                                });

                                updateFormerReligion();
                            });
                        </script>


                        <!-- Date of Birth -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="dob_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Date
                                of Birth *</label>
                            <input type="date" name="date_of_birth" style="{{ $fieldStyle }}" data-required="true">
                        </div>

                        <!-- Occupation -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="occupation_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Occupation
                                *</label>
                            <input type="text" name="occupation" data-i18n-placeholder="occupation_placeholder"
                                style="{{ $fieldStyle }}" data-required="true">
                        </div>

                        <!-- Current Residence -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="current_residence_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Current
                                Residence *</label>
                            <input type="text" name="current_residence"
                                data-i18n-placeholder="current_residence_placeholder" style="{{ $fieldStyle }}"
                                data-required="true">
                        </div>

                        <!-- Contact Information -->
                        <div style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); 
                            padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); 
                            backdrop-filter: blur(10px);">

                            <label data-i18n="contact_label" style="font-size: 13px; color: rgba(255,255,255,0.95); 
                                font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">
                                Contact Information *
                            </label>

                            <div style="display: flex; gap: 12px;">
                                <!-- Country Code Dropdown -->
                                <select name="contact_country_code" style="flex: 0 0 100px; /* fixed width */ 
                       padding: 12px 16px; border-radius: 8px; border: 1px solid #cbd5e1; {{ $fieldStyle }};">
                                    <option value="">Code</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->calling_code }}">
                                            {{ $country->name }} (+{{ $country->calling_code }})
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Telephone Input -->
                                <input type="tel" name="contact" data-i18n-placeholder="contact_placeholder"
                                    style="flex: 1 1 auto; min-width: 0; {{ $fieldStyle }}; padding: 12px 16px;"
                                    data-required="true" maxlength="15" />
                            </div>
                        </div>

                        <!-- Father's Name -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="father_name_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Father's
                                Name *</label>
                            <input type="text" name="father_name" data-i18n-placeholder="father_name_placeholder"
                                style="{{ $fieldStyle }}" data-required="true">
                        </div>

                        <!-- Mother's Name -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="mother_name_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Mother's
                                Name *</label>
                            <input type="text" name="mother_name" data-i18n-placeholder="mother_name_placeholder"
                                style="{{ $fieldStyle }}" data-required="true">
                        </div>

                        <!-- Home Address -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); grid-column: span 2;">
                            <label data-i18n="home_address_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Home
                                Address *</label>
                            <textarea name="home_address" rows="2" data-i18n-placeholder="home_address_placeholder"
                                style="{{ $fieldStyle }} min-height: 80px;" data-required="true"></textarea>
                        </div>

                        <!-- County (Dynamic Dropdown) -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="county_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">District
                                *</label>
                            <select name="county" class="county-select" style="{{ $selectStyle }}" data-required="true">
                                <option value="" data-i18n="select_county">Select County</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>

                        <!-- District (Dynamic Dropdown) -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="district_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">County
                                *</label>
                            <select name="district" class="district-select" style="{{ $selectStyle }}"
                                data-required="true">
                                <option value="" data-i18n="select_district">Select District</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Section B - Upon Conversion -->
            <div class="form-step" id="step2" style="display: none;">
                <div
                    style="background: #2C5C36; border-radius: 20px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(5, 150, 105, 0.15);">
                    <!-- Background Pattern -->
                    <div
                        style="position: absolute; top: -100px; left: -100px; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; filter: blur(20px);">
                    </div>

                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div
                            style="background: white; color: #2C5C36; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 24px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
                            B</div>
                        <div>
                            <h3 data-i18n="section_b_title"
                                style="color: white; font-size: 1.8rem; font-weight: 800; margin: 0; letter-spacing: -0.5px;">
                                SECTION B: UPON CONVERSION</h3>
                            <p data-i18n="section_b_description"
                                style="color: rgba(255,255,255,0.8); margin: 8px 0 0 0; font-size: 15px; font-weight: 500;">
                                Information after conversion to Islam</p>
                        </div>
                    </div>

                    <!-- Form Grid -->
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; position: relative; z-index: 1;">
                        <!-- New Names -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="new_names_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">New
                                Muslim Names *</label>
                            <input type="text" name="new_names" data-i18n-placeholder="new_names_placeholder"
                                style="{{ $fieldStyle }}" data-required="true">
                        </div>

                        <!-- Date of Conversion -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="conversion_date_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Date
                                of Conversion *</label>
                            <input type="date" name="conversion_date" style="{{ $fieldStyle }}" data-required="true">
                        </div>

                        <!-- Place of Entry to Islam -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="conversion_place_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Place
                                of Entry to Islam *</label>
                            <input type="text" name="conversion_place"
                                data-i18n-placeholder="conversion_place_placeholder" style="{{ $fieldStyle }}"
                                data-required="true">
                        </div>

                        <!-- Guardian's Name -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="guardian_name_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Guardian's
                                Name *</label>
                            <input type="text" name="guardian_name" data-i18n-placeholder="guardian_name_placeholder"
                                style="{{ $fieldStyle }}" data-required="true">
                        </div>

                        <!-- Guardian's Occupation -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="guardian_occupation_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Guardian's
                                Occupation *</label>
                            <input type="text" name="guardian_occupation"
                                data-i18n-placeholder="guardian_occupation_placeholder" style="{{ $fieldStyle }}"
                                data-required="true">
                        </div>

                        <!-- Guardian's Declaration Date -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="guardian_declaration_date_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Guardian's
                                Declaration Date *</label>
                            <input type="date" name="guardian_declaration_date" style="{{ $fieldStyle }}"
                                data-required="true">
                        </div>

                        <!-- Reasons for Joining Islam -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); grid-column: span 2;">
                            <label data-i18n="conversion_reasons_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Reasons
                                for Joining Islam *</label>
                            <textarea name="conversion_reasons" rows="3"
                                data-i18n-placeholder="conversion_reasons_placeholder"
                                style="{{ $fieldStyle }} min-height: 100px;" data-required="true"></textarea>
                        </div>

                        <!-- Guardian's Declaration -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); grid-column: span 2;">
                            <label data-i18n="guardian_declaration_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Guardian's
                                Declaration *</label>
                            <textarea name="guardian_declaration" rows="3"
                                data-i18n-placeholder="guardian_declaration_placeholder"
                                style="{{ $fieldStyle }} min-height: 100px;" data-required="true"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Section C - Declaration -->
            <div class="form-step" id="step3" style="display: none;">
                <div
                    style="background: #2C5C36; border-radius: 20px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(79, 70, 229, 0.15);">
                    <!-- Background Pattern -->
                    <div
                        style="position: absolute; top: -100px; right: -100px; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; filter: blur(20px);">
                    </div>

                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div
                            style="background: white; color: #2C5C36; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 24px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
                            C</div>
                        <div>
                            <h3 data-i18n="section_c_title"
                                style="color: white; font-size: 1.8rem; font-weight: 800; margin: 0; letter-spacing: -0.5px;">
                                SECTION C: DECLARATION</h3>
                            <p data-i18n="section_c_description"
                                style="color: rgba(255,255,255,0.8); margin: 8px 0 0 0; font-size: 15px; font-weight: 500;">
                                Official declaration of faith</p>
                        </div>
                    </div>

                    <!-- Declaration Text -->
                    <div
                        style="background: rgba(255,255,255,0.08); padding: 30px; border-radius: 16px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                        <div
                            style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 12px; border-left: 4px solid #2C5C36;">
                            <h4 data-i18n="declaration_title"
                                style="color: white; font-size: 18px; font-weight: 700; margin-bottom: 20px; text-align: center;">
                                DECLARATION OF FAITH (SHAHADA)</h4>

                            <div style="text-align: center; margin-bottom: 30px;">
                                <div
                                    style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                                    <p
                                        style="color: white; font-size: 24px; font-weight: 700; margin: 0; direction: rtl; font-family: 'Traditional Arabic', 'Scheherazade', serif;">
                                        أَشْهَدُ أَنْ لَا إِلَٰهَ إِلَّا ٱللَّٰهُ وَأَشْهَدُ أَنَّ مُحَمَّدًا رَسُولُ
                                        ٱللَّٰهِ
                                    </p>
                                </div>
                                <p data-i18n="shahada_transliteration"
                                    style="color: rgba(255,255,255,0.9); font-size: 18px; font-weight: 600; margin-bottom: 10px;">
                                    "Ash-hadu an la ilaha illa Allah, wa ash-hadu anna Muhammadan rasulu Allah."
                                </p>
                                <p data-i18n="shahada_translation"
                                    style="color: rgba(255,255,255,0.8); font-size: 16px; font-style: italic;">
                                    "I bear witness that there is no god but Allah, and I bear witness that Muhammad is
                                    the Messenger of Allah."
                                </p>
                            </div>

                            <div
                                style="background: rgba(255,255,255,0.1); padding: 25px; border-radius: 10px; margin-bottom: 25px;">
                                <h5 data-i18n="full_declaration_title"
                                    style="color: white; font-size: 16px; font-weight: 700; margin-bottom: 15px;">FULL
                                    DECLARATION:</h5>
                                <p data-i18n="declaration_intro"
                                    style="color: rgba(255,255,255,0.9); line-height: 1.6; margin-bottom: 15px;">
                                    I, <span id="declarationName" style="font-weight: 700; color: white;">[Your Name
                                        Will Appear Here]</span>, do hereby solemnly declare and affirm that:
                                </p>
                                <ul style="color: rgba(255,255,255,0.9); padding-left: 20px; line-height: 1.6;">
                                    <li data-i18n="declaration_point1" style="margin-bottom: 10px;">I have willingly
                                        and consciously embraced Islam as
                                        my faith and way of life</li>
                                    <li data-i18n="declaration_point2" style="margin-bottom: 10px;">I believe in the
                                        Oneness of Allah (God) and accept
                                        Muhammad (peace be upon him) as the final Messenger</li>
                                    <li data-i18n="declaration_point3" style="margin-bottom: 10px;">I accept all the
                                        pillars of Islam and articles of
                                        faith</li>
                                    <li data-i18n="declaration_point4" style="margin-bottom: 10px;">I renounce all
                                        previous beliefs and practices
                                        contrary to Islamic teachings</li>
                                    <li data-i18n="declaration_point5" style="margin-bottom: 10px;">I commit to
                                        following the teachings of the Holy
                                        Quran and Sunnah</li>
                                    <li data-i18n="declaration_point6">This declaration is made voluntarily, without
                                        any coercion or undue influence
                                    </li>
                                </ul>
                            </div>
                            <div style="display: none;">
                                <div
                                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                                    <!-- Signature Upload -->
                                    <div
                                        style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; border: 1px dashed rgba(255,255,255,0.2);">
                                        <label data-i18n="signature_label"
                                            style="font-size: 13px; color: white; font-weight: 600; margin-bottom: 10px; display: block;">Digital
                                            Signature *</label>
                                        <p data-i18n="signature_note"
                                            style="color: rgba(255,255,255,0.7); font-size: 12px; margin-bottom: 15px;">
                                            Upload a clear image of your handwritten signature (PNG or JPG)</p>
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <input type="file" name="signature" accept="image/*" style="display: none;"
                                                id="signatureUpload" data-required="true">
                                            <button type="button"
                                                onclick="document.getElementById('signatureUpload').click()"
                                                style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 12px 20px; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 500; transition: all 0.3s; display: flex; align-items: center; gap: 8px;">
                                                <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                    <polyline points="17 8 12 3 7 8"></polyline>
                                                    <line x1="12" y1="3" x2="12" y2="15">
                                                    </line>
                                                </svg>
                                                <span data-i18n="upload_signature_btn">Upload Signature</span>
                                            </button>
                                            <span id="signatureFileName" data-i18n="no_file_chosen"
                                                style="color: rgba(255,255,255,0.7); font-size: 14px; font-weight: 500;">No
                                                file chosen</span>
                                        </div>
                                        <div id="signaturePreview" style="margin-top: 15px; display: none;">
                                            <div
                                                style="background: rgba(255,255,255,0.1); padding: 10px; border-radius: 5px;">
                                                <p data-i18n="signature_preview"
                                                    style="color: rgba(255,255,255,0.8); font-size: 12px; margin-bottom: 5px;">
                                                    Signature Preview:</p>
                                                <img id="signatureImagePreview"
                                                    style="max-width: 200px; max-height: 80px; border: 1px solid rgba(255,255,255,0.2); border-radius: 4px;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Date of Declaration -->
                                    <div
                                        style="display: flex; flex-direction: column; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; border: 1px dashed rgba(255,255,255,0.2);">
                                        <label data-i18n="declaration_date_label"
                                            style="font-size: 13px; color: white; font-weight: 600; margin-bottom: 10px;">Date
                                            of Declaration *</label>
                                        <input type="date" name="declaration_date" style="{{ $fieldStyle }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Agreement Checkbox -->
                        <div
                            style="background: rgba(255,255,255,0.08); padding: 25px; border-radius: 16px; margin-top: 30px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <div style="display: flex; align-items: flex-start; gap: 15px;">
                                <input type="checkbox" name="declaration_agreement" id="declarationAgreement"
                                    style="width: 20px; height: 20px; cursor: pointer; accent-color: #2C5C36; flex-shrink: 0; margin-top: 3px;"
                                    data-required="true">
                                <div>
                                    <label for="declarationAgreement" data-i18n="declaration_agreement_label"
                                        style="color: white; font-size: 15px; font-weight: 600; margin-bottom: 8px; display: block;">Declaration
                                        Agreement *</label>
                                    <p data-i18n="declaration_agreement_text"
                                        style="color: rgba(255,255,255,0.8); font-size: 14px; line-height: 1.5; margin: 0;">
                                        I hereby solemnly and sincerely declare that the information provided in this
                                        declaration is true and correct to the best of my knowledge. I understand that
                                        providing false information may invalidate this declaration. I acknowledge that
                                        this declaration constitutes my formal conversion to Islam.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Officer Verification -->
            <div class="form-step" id="step4" style="display: none;">
                <div
                    style="background: #2C5C36; border-radius: 20px; padding: 45px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(220, 38, 38, 0.15);">
                    <!-- Background Pattern -->
                    <div
                        style="position: absolute; top: -100px; left: -100px; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; filter: blur(20px);">
                    </div>

                    <!-- Header -->
                    <div
                        style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; position: relative; z-index: 1;">
                        <div
                            style="background: white; color: #2C5C36; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 24px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
                            D</div>
                        <div>
                            <h3 data-i18n="section_d_title"
                                style="color: white; font-size: 1.8rem; font-weight: 800; margin: 0; letter-spacing: -0.5px;">
                                OFFICER VERIFICATION</h3>
                            <p data-i18n="section_d_description"
                                style="color: rgba(255,255,255,0.8); margin: 8px 0 0 0; font-size: 15px; font-weight: 500;">
                                Official verification and processing</p>
                        </div>
                    </div>

                    <!-- Form Grid -->
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; position: relative; z-index: 1;">
                        <!-- Officer's Name -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="officer_name_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Verifying
                                Officer's Name *</label>
                            <input type="text" name="officer_name" data-i18n-placeholder="officer_name_placeholder"
                                style="{{ $fieldStyle }}" value="{{ Helper::fullname() }}" data-required="true"
                                disabled>
                        </div>

                        <!-- Officer's Position -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="officer_position_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Officer's
                                Position *</label>
                            <input type="text" name="officer_position"
                                data-i18n-placeholder="officer_position_placeholder" style="{{ $fieldStyle }}"
                                value="{{ Helper::activerUSerRole() }}" data-required="true" disabled>
                        </div>

                        <!-- Registration Number -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="registration_number_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Registration
                                Number *</label>
                            <input type="text" name="registration_number"
                                data-i18n-placeholder="registration_number_placeholder" style="{{ $fieldStyle }}"
                                data-required="true" value="001" disabled>
                        </div>

                        <!-- Date of Verification -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <label data-i18n="verification_date_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Date
                                of Verification *</label>
                            <input type="date" name="verification_date" style="{{ $fieldStyle }}" data-required="true"
                                value="{{ date('Y-m-d') }}" disabled>
                        </div>

                        <!-- Certification -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); grid-column: span 2;">
                            <label data-i18n="certification_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 10px;">Certification
                                Statement</label>
                            <div
                                style="background: rgba(255,255,255,0.05); padding: 25px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px;">
                                <p data-i18n="certification_text"
                                    style="color: rgba(255,255,255,0.9); font-size: 15px; line-height: 1.6; text-align: center; font-style: italic;">
                                    "I hereby certify that I have verified the identity of the applicant and witnessed
                                    their declaration of faith. The conversion has been conducted in accordance with
                                    Islamic principles and requirements."
                                </p>
                            </div>
                            <div style="display: none;">
                                <div style="display: flex; align-items: center; gap: 20px;">
                                    <div style="flex: 1; display: flex; flex-direction: column; gap: 10px;">
                                        <label data-i18n="officer_signature_label"
                                            style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600;">Officer's
                                            Signature *</label>
                                        <input type="file" name="officer_signature" accept="image/*"
                                            style="display: none;" id="officerSignatureUpload" data-required="true">
                                        <button type="button" data-i18n="upload_officer_signature_btn"
                                            onclick="document.getElementById('officerSignatureUpload').click()"
                                            style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 10px 15px; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 500; transition: all 0.3s; text-align: center;">
                                            Upload Officer Signature
                                        </button>
                                        <span id="officerSignatureFileName" data-i18n="no_file_chosen"
                                            style="color: rgba(255,255,255,0.7); font-size: 13px;">No file chosen</span>
                                    </div>
                                    <div style="flex: 1; display: flex; flex-direction: column; gap: 10px;">
                                        <label data-i18n="official_stamp_label"
                                            style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600;">Official
                                            Stamp *</label>
                                        <input type="file" name="official_stamp" accept="image/*" style="display: none;"
                                            id="officialStampUpload" data-required="true">
                                        <button type="button" data-i18n="upload_official_stamp_btn"
                                            onclick="document.getElementById('officialStampUpload').click()"
                                            style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 10px 15px; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 500; transition: all 0.3s; text-align: center;">
                                            Upload Official Stamp
                                        </button>
                                        <span id="officialStampFileName" data-i18n="no_file_chosen"
                                            style="color: rgba(255,255,255,0.7); font-size: 13px;">No file chosen</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div
                            style="display: flex; flex-direction: column; background: rgba(255,255,255,0.08); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); grid-column: span 2;">
                            <label data-i18n="remarks_label"
                                style="font-size: 13px; color: rgba(255,255,255,0.95); font-weight: 600; letter-spacing: 0.3px; margin-bottom: 5px;">Remarks/Additional
                                Notes</label>
                            <textarea name="officer_remarks" rows="3" data-i18n-placeholder="remarks_placeholder"
                                style="{{ $fieldStyle }} min-height: 100px;"></textarea>
                        </div>
                    </div>
                </div>
            </div>

<!-- Navigation Buttons (MUST BE HERE - AFTER ALL STEPS BUT BEFORE CLOSING FORM) -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 50px; padding-top: 25px; border-top: 1px solid #e5e7eb;">
    <div>
        <button type="button" id="prevBtn"
            style="display: none; background: #f3f4f6; color: #2C5C36; border: 2px solid #d1d5db; padding: 14px 30px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 15px; display: flex; align-items: center; gap: 8px;"
            onclick="prevStep()">
            <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5">
                <path d="M19 12H5"></path>
                <path d="M12 19l-7-7 7-7"></path>
            </svg>
            <span data-i18n="prev_btn">Previous Step</span>
        </button>
    </div>

    <div style="display: flex; align-items: center; gap: 15px;">
        <span id="stepStatus"
            style="font-size: 14px; color: #2C5C36; font-weight: 500; background: #f9fafb; padding: 8px 16px; border-radius: 20px; border: 1px solid #e5e7eb;">
            <span id="completedFields">0</span> <span data-i18n="of_text">of</span> <span
                id="totalFields">0</span> <span data-i18n="fields_completed">fields completed</span>
        </span>

        <!-- Preview Button Container -->
        <div id="previewButtonContainer" style="display: none;">
            <button type="button" id="previewBtn"
                style="background: #3b82f6; color: white; border: none; padding: 14px 30px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 15px; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2); display: flex; align-items: center; gap: 8px;"
                onclick="showPreview()">
                <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <span data-i18n="preview_btn">Preview Declaration</span>
            </button>
        </div>

        <!-- Next/Submit Button Container -->
        <div style="display: flex; gap: 10px;">
            <button type="button" id="nextBtn"
                style="background: #2C5C36; color: white; border: none; padding: 14px 40px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 15px; box-shadow: 0 4px 15px rgba(124, 58, 237, 0.2); display: flex; align-items: center; gap: 8px;"
                onclick="nextStep()">
                <span data-i18n="next_btn">Next Step</span>
                <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <path d="M5 12h14"></path>
                    <path d="M12 5l7 7-7 7"></path>
                </svg>
            </button>

            <button type="submit" id="submitBtn"
                style="display: none; background: #2C5C36; color: white; border: none; padding: 14px 40px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 15px; box-shadow: 0 4px 15px rgba(5, 150, 105, 0.2);">
                <span data-i18n="submit_declaration_btn">Submit Declaration</span>
            </button>
        </div>
    </div>
</div>
        </form>
    </div>
    <!-- Preview Modal -->
    <div id="previewModal"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); z-index: 9999; overflow-y: auto; padding: 20px; backdrop-filter: blur(5px);">
        <div
            style="max-width: 1200px; margin: 40px auto; background: #1a1a2e; border-radius: 24px; box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5); overflow: hidden; position: relative;">

            <!-- Decorative Elements -->
            <div
                style="position: absolute; top: 0; right: 0; width: 300px; height: 300px; background: rgba(44, 92, 54, 0.15);">
            </div>
            <div
                style="position: absolute; bottom: 0; left: 0; width: 400px; height: 400px; background: rgba(44, 92, 54, 0.1);">
            </div>

            <!-- Modal Header -->
            <div
                style="background: #2C5C36; padding: 35px 40px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); position: relative;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <div
                            style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border-radius: 16px; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(255, 255, 255, 0.2);">
                            <svg style="width: 32px; height: 32px;" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M21 2H3a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z">
                                </path>
                                <path d="M2 7h20M2 12h20M2 17h20"></path>
                            </svg>
                        </div>
                        <div>
                            <h2
                                style="color: white; font-size: 2rem; font-weight: 800; margin: 0; letter-spacing: -0.5px;">
                                DECLARATION PREVIEW</h2>
                            <p style="color: rgba(255, 255, 255, 0.8); margin: 8px 0 0 0; font-size: 16px;">Review all
                                information before submission</p>
                        </div>
                    </div>
                    <button onclick="closePreview()"
                        style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: white; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; font-size: 20px;">
                        ×
                    </button>
                </div>

                <!-- Status Badges -->
                <div style="display: flex; gap: 15px;">
                    <span
                        style="background: rgba(255, 255, 255, 0.1); color: white; padding: 8px 20px; border-radius: 20px; font-size: 14px; font-weight: 600; border: 1px solid rgba(255, 255, 255, 0.2);">
                        📝 Draft Preview
                    </span>
                    <span
                        style="background: rgba(34, 197, 94, 0.2); color: #4ade80; padding: 8px 20px; border-radius: 20px; font-size: 14px; font-weight: 600; border: 1px solid rgba(34, 197, 94, 0.3);">
                        ✅ All Sections Complete
                    </span>
                    <span id="previewTimestamp"
                        style="background: rgba(59, 130, 246, 0.2); color: #60a5fa; padding: 8px 20px; border-radius: 20px; font-size: 14px; font-weight: 600; border: 1px solid rgba(59, 130, 246, 0.3);">
                        🕒 Preview generated just now
                    </span>
                </div>
            </div>

            <!-- Preview Content -->
            <div style="padding: 40px; max-height: 70vh; overflow-y: auto;">
                <!-- Section A -->
                <div style="margin-bottom: 50px;">
                    <div
                        style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid rgba(44, 92, 54, 0.3);">
                        <div
                            style="width: 50px; height: 50px; background: #2C5C36; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 22px; box-shadow: 0 8px 20px rgba(44, 92, 54, 0.3);">
                            A
                        </div>
                        <h3 style="color: white; font-size: 1.5rem; font-weight: 700; margin: 0;" data-i18n="section_a_heading">SECTION A: CONVERT'S
                            DECLARATION</h3>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                        <div class="preview-field">
                            <label data-i18n="preview_former_names_label">Former Names</label>
                            <div id="preview-former_names" class="preview-value">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_former_religion_label">Former Religion</label>
                            <div id="preview-former_religion" class="preview-value">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_dob_label">Date of Birth</label>
                            <div id="preview-date_of_birth" class="preview-value">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_occupation_label">Occupation</label>
                            <div id="preview-occupation" class="preview-value">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_current_residence_label">Current Residence</label>
                            <div id="preview-current_residence" class="preview-value">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_contact_label">Contact Information</label>
                            <div id="preview-contact" class="preview-value">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_father_name_label">Father's Name</label>
                            <div id="preview-father_name" class="preview-value">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_mother_name_label">Mother's Name</label>
                            <div id="preview-mother_name" class="preview-value">-</div>
                        </div>
                        <div class="preview-field" style="grid-column: span 2;">
                            <label data-i18n="preview_home_address_label">Home Address</label>
                            <div id="preview-home_address" class="preview-value">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_district_label">District</label>
                            <div id="preview-county" class="preview-value">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_county_label">County</label>
                            <div id="preview-district" class="preview-value">-</div>
                        </div>
                    </div>
                </div>

                <!-- Section B -->
                <div style="margin-bottom: 50px;">
                    <div
                        style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid rgba(44, 92, 54, 0.3);">
                        <div
                            style="width: 50px; height: 50px; background: #2C5C36; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 22px; box-shadow: 0 8px 20px rgba(44, 92, 54, 0.3);">
                            B
                        </div>
                        <h3 style="color: white; font-size: 1.5rem; font-weight: 700; margin: 0;" data-i18n="section_b_heading">SECTION B: UPON
                            CONVERSION</h3>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                        <div class="preview-field">
                            <label data-i18n="preview_new_names_label">New Muslim Names</label>
                            <div id="preview-new_names" class="preview-value highlight">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_conversion_date_label">Date of Conversion</label>
                            <div id="preview-conversion_date" class="preview-value highlight">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_conversion_place_label">Place of Entry to Islam</label>
                            <div id="preview-conversion_place" class="preview-value highlight">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_guardian_name_label">Guardian's Name</label>
                            <div id="preview-guardian_name" class="preview-value">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_guardian_occupation_label">Guardian's Occupation</label>
                            <div id="preview-guardian_occupation" class="preview-value">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_guardian_declaration_date_label">Guardian's Declaration Date</label>
                            <div id="preview-guardian_declaration_date" class="preview-value">-</div>
                        </div>
                        <div class="preview-field" style="grid-column: span 2;">
                            <label data-i18n="preview_conversion_reasons_label">Reasons for Joining Islam</label>
                            <div id="preview-conversion_reasons" class="preview-value">-</div>
                        </div>
                        <div class="preview-field" style="grid-column: span 2;">
                            <label data-i18n="preview_guardian_declaration_label">Guardian's Declaration</label>
                            <div id="preview-guardian_declaration" class="preview-value">-</div>
                        </div>
                    </div>
                </div>

                <!-- Section C -->
                <div style="margin-bottom: 50px;">
                    <div
                        style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid rgba(44, 92, 54, 0.3);">
                        <div
                            style="width: 50px; height: 50px; background: #2C5C36; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 22px; box-shadow: 0 8px 20px rgba(44, 92, 54, 0.3);">
                            C
                        </div>
                        <h3 style="color: white; font-size: 1.5rem; font-weight: 700; margin: 0;" data-i18n="section_c_heading">SECTION C: DECLARATION
                            OF FAITH</h3>
                    </div>

                    <div
                        style="background: rgba(255, 255, 255, 0.05); border-radius: 16px; padding: 30px; margin-bottom: 30px; border: 1px solid rgba(255, 255, 255, 0.1);">
                        <div style="text-align: center; margin-bottom: 25px;">
                            <div
                                style="background: rgba(44, 92, 54, 0.2); padding: 20px; border-radius: 12px; margin-bottom: 20px; border: 1px solid rgba(44, 92, 54, 0.3);">
                                <p
                                    style="color: white; font-size: 24px; font-weight: 700; margin: 0; direction: rtl; font-family: 'Traditional Arabic', 'Scheherazade', serif;">
                                    أَشْهَدُ أَنْ لَا إِلَٰهَ إِلَّا ٱللَّٰهُ وَأَشْهَدُ أَنَّ مُحَمَّدًا رَسُولُ
                                    ٱللَّٰهِ
                                </p>
                            </div>
                            <p
                                style="color: rgba(255, 255, 255, 0.9); font-size: 18px; font-weight: 600; margin-bottom: 10px;">
                                "Ash-hadu an la ilaha illa Allah, wa ash-hadu anna Muhammadan rasulu Allah."
                            </p>
                            <p style="color: rgba(255, 255, 255, 0.8); font-size: 16px; font-style: italic;">
                                "I bear witness that there is no god but Allah, and I bear witness that Muhammad is the
                                Messenger of Allah."
                            </p>
                        </div>

                        <div class="preview-field">
                            <label data-i18n="preview_declaration_agreement_label">Declaration Agreement</label>
                            <div id="preview-declaration_agreement" class="preview-value highlight">
                                <span style="color: #4ade80;" data-i18n="declaration_accepted_text">✓ Accepted</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Officer Verification -->
                <div>
                    <div
                        style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid rgba(44, 92, 54, 0.3);">
                        <div
                            style="width: 50px; height: 50px; background: #2C5C36; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 22px; box-shadow: 0 8px 20px rgba(44, 92, 54, 0.3);">
                            D
                        </div>
                        <h3 style="color: white; font-size: 1.5rem; font-weight: 700; margin: 0;" data-i18n="section_d_heading">OFFICER VERIFICATION
                        </h3>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                        <div class="preview-field">
                            <label data-i18n="preview_officer_name_label">Verifying Officer's Name</label>
                            <div id="preview-officer_name" class="preview-value">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_officer_position_label">Officer's Position</label>
                            <div id="preview-officer_position" class="preview-value">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_registration_number_label">Registration Number</label>
                            <div id="preview-registration_number" class="preview-value">-</div>
                        </div>
                        <div class="preview-field">
                            <label data-i18n="preview_verification_date_label">Date of Verification</label>
                            <div id="preview-verification_date" class="preview-value">-</div>
                        </div>
                        <div class="preview-field" style="grid-column: span 2;">
                            <label data-i18n="preview_officer_remarks_label">Remarks/Additional Notes</label>
                            <div id="preview-officer_remarks" class="preview-value">-</div>
                        </div>
                    </div>
                </div>

                <!-- Signature Preview (if uploaded) -->
                <div id="signaturePreviewSection"
                    style="display: none; margin-top: 50px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.1);">
                    <h4 style="color: white; font-size: 1.2rem; font-weight: 700; margin-bottom: 20px;">📝 SIGNATURE
                        PREVIEW</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                        <div
                            style="background: rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 20px; border: 1px dashed rgba(255, 255, 255, 0.2);">
                            <div style="color: rgba(255, 255, 255, 0.7); font-size: 14px; margin-bottom: 10px;">
                                Convert's Signature</div>
                            <img id="previewSignatureImage"
                                style="max-width: 200px; max-height: 80px; border-radius: 4px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div
                style="background: rgba(255, 255, 255, 0.05); padding: 25px 40px; border-top: 1px solid rgba(255, 255, 255, 0.1); display: flex; justify-content: space-between; align-items: center;">
                <div style="color: rgba(255, 255, 255, 0.7); font-size: 14px;">
                    <strong>Note:</strong> Please verify all information is correct before submission
                </div>
                <div style="display: flex; gap: 15px;">
                    <button onclick="closePreview()"
                        style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.3); color: white; padding: 12px 30px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s; font-size: 15px;">
                        Close Preview
                    </button>
                    <button onclick="closePreview(); document.querySelector('#submitBtn').click();"
                        style="background: #2C5C36; color: white; border: none; padding: 12px 40px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s; font-size: 15px; box-shadow: 0 4px 15px rgba(44, 92, 54, 0.3);">
                        Submit Declaration
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Preview Field Styles */
    .preview-field {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .preview-field:hover {
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .preview-field label {
        color: rgba(255, 255, 255, 0.7);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .preview-value {
        color: white;
        font-size: 16px;
        font-weight: 500;
        line-height: 1.5;
        word-break: break-word;
    }

    .preview-value.highlight {
        color: #4ade80;
        font-weight: 600;
        font-size: 17px;
    }

    /* Empty state styling */
    .preview-value:empty::before {
        content: "Not provided";
        color: rgba(255, 255, 255, 0.4);
        font-style: italic;
    }

    /* Modal animations */
    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(-20px);
        }

        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    #previewModal>div {
        animation: modalFadeIn 0.4s ease-out;
    }

    /* Scrollbar styling for modal */
    #previewModal>div>div:nth-child(2) {
        scrollbar-width: thin;
        scrollbar-color: rgba(44, 92, 54, 0.5) transparent;
    }

    #previewModal>div>div:nth-child(2)::-webkit-scrollbar {
        width: 8px;
    }

    #previewModal>div>div:nth-child(2)::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 4px;
    }

    #previewModal>div>div:nth-child(2)::-webkit-scrollbar-thumb {
        background: rgba(44, 92, 54, 0.5);
        border-radius: 4px;
    }

    #previewModal>div>div:nth-child(2)::-webkit-scrollbar-thumb:hover {
        background: rgba(44, 92, 54, 0.7);
    }

    /* Responsive modal */
    @media (max-width: 768px) {
        #previewModal>div {
            margin: 20px auto;
            border-radius: 16px;
        }

        #previewModal>div>div:first-child {
            padding: 25px;
        }

        #previewModal>div>div:nth-child(2) {
            padding: 25px;
        }

        .preview-field {
            grid-column: span 1 !important;
        }
    }
</style>

<script>
    let currentStep = 1;
    const totalSteps = 4;
    const form = document.getElementById('multiStepForm');
    const steps = document.querySelectorAll('.form-step');

    // District and County data
    const ugandaData = {
        districts: {
            "Kampala": ["Kampala Central", "Kawempe", "Makindye", "Nakawa", "Rubaga"],
            "Wakiso": ["Entebbe", "Kira", "Nansana", "Wakiso Central"],
            "Mukono": ["Mukono Central", "Nama", "Ntenjeru"],
            "Jinja": ["Jinja Central", "Budondo", "Butagaya"],
            "Mbale": ["Mbale Central", "Bungokho", "Nkoma"],
            "Mbarara": ["Mbarara Central", "Kashari", "Rwampara"],
            "Gulu": ["Gulu Central", "Laroo", "Pece"],
            "Lira": ["Lira Central", "Ojwina", "Railways"],
            "Arua": ["Arua Central", "Adumi", "Manibe"],
            "Fort Portal": ["Fort Portal Central", "Karambi", "Kabonero"],
            "Masaka": ["Masaka Central", "Kimaanya", "Nyendo"],
            "Soroti": ["Soroti Central", "Eastern", "Northern"],
            "Hoima": ["Hoima Central", "Kigorobya", "Kitoba"],
            "Kabale": ["Kabale Central", "Northern", "Southern"],
            "Mityana": ["Mityana Central", "Busimbi", "Ssekanyonyi"]
        }
    };

    // Initialize when DOM loads
    document.addEventListener('DOMContentLoaded', function () {
        initializeDistricts();
        updateStepIndicators();
        setupFileUploads();
        setupStepIndicators();
        setupFormSubmission();

        // Initialize field completion status
        updateFieldCompletion();

        // Add input event listeners
        const allInputs = form.querySelectorAll('input, select, textarea');
        allInputs.forEach(input => {
            input.addEventListener('input', updateFieldCompletion);
            input.addEventListener('change', updateFieldCompletion);
        });

        // Update declaration name when new names are entered
        const newNamesInput = document.querySelector('[name="new_names"]');
        if (newNamesInput) {
            newNamesInput.addEventListener('input', function () {
                const declarationName = document.getElementById('declarationName');
                if (declarationName) {
                    declarationName.textContent = this.value || '[Your Name Will Appear Here]';
                }
            });
        }
    });

    function initializeDistricts() {
        const countySelect = document.querySelector('.county-select');
        const districtSelect = document.querySelector('.district-select');

        if (!countySelect || !districtSelect) return;

        // Clear existing options
        countySelect.innerHTML = '<option value="">Select District</option>';
        districtSelect.innerHTML = '<option value="">Select County</option>';

        // Populate counties (districts)
        Object.keys(ugandaData.districts).forEach(district => {
            const option = document.createElement('option');
            option.value = district;
            option.textContent = district;
            countySelect.appendChild(option);
        });

        // Add event listener for county selection
        countySelect.addEventListener('change', function () {
            const selectedDistrict = this.value;
            const counties = ugandaData.districts[selectedDistrict] || [];

            // Clear district options
            districtSelect.innerHTML = '<option value="">Select County</option>';

            // Populate districts (counties)
            counties.forEach(county => {
                const option = document.createElement('option');
                option.value = county;
                option.textContent = county;
                districtSelect.appendChild(option);
            });

            updateFieldCompletion();
        });
    }

function updateStepIndicators() {
    for (let i = 1; i <= totalSteps; i++) {
        const indicator = document.getElementById('stepIndicator' + i);
        if (!indicator) continue;

        const statusIcon = indicator.querySelector('.step-status svg');

        if (i < currentStep) {
            indicator.style.borderColor = '#2C5C36';
            indicator.style.background = '#f0f9f0';
            indicator.style.boxShadow = '0 4px 20px rgba(44, 92, 54, 0.1)';

            if (statusIcon) {
                statusIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />';
                statusIcon.style.color = '#2C5C36';
            }
        } else if (i === currentStep) {
            indicator.style.borderColor = '#2C5C36';
            indicator.style.background = '#f0f9f0';
            indicator.style.boxShadow = '0 8px 30px rgba(44, 92, 54, 0.15)';

            if (statusIcon) {
                statusIcon.innerHTML = '<circle cx="12" cy="12" r="10"></circle><path d="M12 8v4l3 3"></path>';
                statusIcon.style.color = '#2C5C36';
            }
        } else {
            indicator.style.borderColor = '#e5e7eb';
            indicator.style.background = 'white';
            indicator.style.boxShadow = 'none';

            if (statusIcon) {
                statusIcon.innerHTML = '<path d="M19 4.5L5 19.5"></path>';
                statusIcon.style.color = '#d1d5db';
            }
        }
    }

    // Update current step title and number
    const stepTitles = {
        1: 'Section A: Convert\'s Declaration',
        2: 'Section B: Upon Conversion',
        3: 'Section C: Declaration',
        4: 'Officer Verification'
    };

    const stepSubtitles = {
        1: 'Step 1 of 4: Personal Information & Background',
        2: 'Step 2 of 4: Conversion Information & Details',
        3: 'Step 3 of 4: Declaration of Faith & Signature',
        4: 'Step 4 of 4: Officer Verification & Processing'
    };

    const currentStepTitle = document.getElementById('currentStepTitle');
    const currentStepSubtitle = document.getElementById('currentStepSubtitle');
    const currentStepNumber = document.getElementById('currentStepNumber');

    if (currentStepTitle) currentStepTitle.textContent = stepTitles[currentStep];
    if (currentStepSubtitle) currentStepSubtitle.textContent = stepSubtitles[currentStep];
    if (currentStepNumber) currentStepNumber.textContent = currentStep;

    // Show/hide navigation buttons
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    const previewBtnContainer = document.getElementById('previewButtonContainer'); // Add this

    if (prevBtn) prevBtn.style.display = currentStep > 1 ? 'flex' : 'none';
    if (nextBtn) nextBtn.style.display = currentStep < totalSteps ? 'flex' : 'none';
    if (submitBtn) submitBtn.style.display = currentStep === totalSteps ? 'inline-flex' : 'none';
    if (previewBtnContainer) previewBtnContainer.style.display = currentStep === totalSteps ? 'block' : 'none'; // Add this

    // Update declaration name
    if (currentStep === 3) {
        const newNames = document.querySelector('[name="new_names"]');
        const declarationName = document.getElementById('declarationName');
        if (newNames && declarationName) {
            declarationName.textContent = newNames.value || '[Your Name Will Appear Here]';
        }
    }

    // Update progress
    updateProgress();
}

    function updateProgress() {
        const completedSteps = currentStep - 1;
        const progressPercentage = Math.round((completedSteps / totalSteps) * 100);

        const progressPercentageEl = document.getElementById('progressPercentage');
        const progressBar = document.getElementById('progressBar');
        const completedStepsEl = document.getElementById('completedSteps');

        if (progressPercentageEl) progressPercentageEl.textContent = progressPercentage + '%';
        if (progressBar) progressBar.style.width = progressPercentage + '%';
        if (completedStepsEl) completedStepsEl.textContent = completedSteps + ' of ' + totalSteps +
            ' sections completed';
    }

    function updateFieldCompletion() {
        const currentStepElement = document.getElementById('step' + currentStep);
        if (!currentStepElement) return;

        const requiredFields = currentStepElement.querySelectorAll('[data-required="true"]');
        const completedFields = Array.from(requiredFields).filter(field => {
            if (field.type === 'checkbox') return field.checked;
            if (field.type === 'file') {
                const fileNameSpan = {
                    'signature': 'signatureFileName',
                    'officer_signature': 'officerSignatureFileName',
                    'official_stamp': 'officialStampFileName'
                }[field.name];
                if (fileNameSpan) {
                    const spanElement = document.getElementById(fileNameSpan);
                    return spanElement && spanElement.textContent !== 'No file chosen';
                }
                return false;
            }
            return field.value.trim() !== '';
        }).length;

        const completedFieldsEl = document.getElementById('completedFields');
        const totalFieldsEl = document.getElementById('totalFields');

        if (completedFieldsEl) completedFieldsEl.textContent = completedFields;
        if (totalFieldsEl) totalFieldsEl.textContent = requiredFields.length;
    }

    function validateStep() {
        const currentStepElement = document.getElementById('step' + currentStep);
        if (!currentStepElement) return false;

        const requiredFields = currentStepElement.querySelectorAll('[data-required="true"]');
        let isValid = true;
        let firstInvalidField = null;

        for (const field of requiredFields) {
            let fieldValid = true;

            if (field.type === 'checkbox') {
                fieldValid = field.checked;
            } else if (field.type === 'file') {
                const fileNameSpan = {
                    'signature': 'signatureFileName',
                    'officer_signature': 'officerSignatureFileName',
                    'official_stamp': 'officialStampFileName'
                }[field.name];
                if (fileNameSpan) {
                    const spanElement = document.getElementById(fileNameSpan);
                    fieldValid = spanElement && spanElement.textContent !== 'No file chosen';
                }
            } else {
                fieldValid = field.value.trim() !== '';
            }

            if (!fieldValid) {
                isValid = false;
                if (!firstInvalidField) firstInvalidField = field;

                // Highlight invalid field
                field.style.borderColor = '#ef4444';
                field.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';

                // Remove highlight when user starts typing
                const removeHighlight = () => {
                    field.style.borderColor = '';
                    field.style.boxShadow = '';
                    field.removeEventListener('input', removeHighlight);
                    field.removeEventListener('change', removeHighlight);
                };
                field.addEventListener('input', removeHighlight, {
                    once: true
                });
                field.addEventListener('change', removeHighlight, {
                    once: true
                });
            }
        }

        if (!isValid) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Information',
                text: 'Please fill in all required fields before proceeding.',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                if (firstInvalidField) {
                    firstInvalidField.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstInvalidField.focus();
                }
            });
        }


        return isValid;
    }

    function nextStep() {
        if (!validateStep()) return;

        // Hide current step
        const currentStepElement = document.getElementById('step' + currentStep);
        if (currentStepElement) {
            currentStepElement.style.display = 'none';
        }

        // Show next step
        currentStep++;
        const nextStepElement = document.getElementById('step' + currentStep);
        if (nextStepElement) {
            nextStepElement.style.display = 'block';
        }

        // Update UI
        updateStepIndicators();
        updateFieldCompletion();
    }

    function prevStep() {
        // Hide current step
        const currentStepElement = document.getElementById('step' + currentStep);
        if (currentStepElement) {
            currentStepElement.style.display = 'none';
        }

        // Show previous step
        currentStep--;
        const prevStepElement = document.getElementById('step' + currentStep);
        if (prevStepElement) {
            prevStepElement.style.display = 'block';
        }

        // Update UI
        updateStepIndicators();
        updateFieldCompletion();
    }

    function setupFileUploads() {
        // Signature upload
        const signatureUpload = document.getElementById('signatureUpload');
        const signatureFileName = document.getElementById('signatureFileName');
        const signaturePreview = document.getElementById('signaturePreview');
        const signatureImagePreview = document.getElementById('signatureImagePreview');

        if (signatureUpload && signatureFileName) {
            signatureUpload.addEventListener('change', function () {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    signatureFileName.textContent = file.name;

                    // Preview image
                    if (signaturePreview && signatureImagePreview) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            signatureImagePreview.src = e.target.result;
                            signaturePreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    }

                    updateFieldCompletion();
                } else {
                    signatureFileName.textContent = 'No file chosen';
                    if (signaturePreview) signaturePreview.style.display = 'none';
                }
            });
        }

        // Officer signature upload
        const officerSignatureUpload = document.getElementById('officerSignatureUpload');
        const officerSignatureFileName = document.getElementById('officerSignatureFileName');

        if (officerSignatureUpload && officerSignatureFileName) {
            officerSignatureUpload.addEventListener('change', function () {
                if (this.files.length > 0) {
                    officerSignatureFileName.textContent = this.files[0].name;
                } else {
                    officerSignatureFileName.textContent = 'No file chosen';
                }
                updateFieldCompletion();
            });
        }

        // Official stamp upload
        const officialStampUpload = document.getElementById('officialStampUpload');
        const officialStampFileName = document.getElementById('officialStampFileName');

        if (officialStampUpload && officialStampFileName) {
            officialStampUpload.addEventListener('change', function () {
                if (this.files.length > 0) {
                    officialStampFileName.textContent = this.files[0].name;
                } else {
                    officialStampFileName.textContent = 'No file chosen';
                }
                updateFieldCompletion();
            });
        }
    }

    function setupStepIndicators() {
        for (let i = 1; i <= totalSteps; i++) {
            const indicator = document.getElementById('stepIndicator' + i);
            if (!indicator) continue;

            indicator.addEventListener('click', function () {
                const step = parseInt(this.dataset.step);

                // Only allow navigation to completed or current steps
                if (step <= currentStep) {
                    // Hide all steps
                    steps.forEach(stepElement => {
                        if (stepElement.style) stepElement.style.display = 'none';
                    });

                    // Show selected step
                    currentStep = step;
                    const stepElement = document.getElementById('step' + currentStep);
                    if (stepElement) stepElement.style.display = 'block';

                    // Update UI
                    updateStepIndicators();
                    updateFieldCompletion();
                }
            });
        }
    }

    function setupFormSubmission() {
        if (!form) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Validate all steps
            let allValid = true;
            for (let i = 1; i <= totalSteps; i++) {
                const stepElement = document.getElementById('step' + i);
                if (!stepElement) continue;

                const requiredFields = stepElement.querySelectorAll('[data-required="true"]');

                for (const field of requiredFields) {
                    let fieldValid = true;

                    if (field.type === 'checkbox') {
                        fieldValid = field.checked;
                    } else if (field.type === 'file') {
                        // Skip file validation in form submission as they're handled separately
                        continue;
                    } else {
                        fieldValid = field.value.trim() !== '';
                    }

                    if (!fieldValid) {
                        allValid = false;
                        // Scroll to first invalid step
                        if (i !== currentStep) {
                            // Hide current step
                            const currentStepElement = document.getElementById('step' + currentStep);
                            if (currentStepElement) currentStepElement.style.display = 'none';
                            // Show invalid step
                            currentStep = i;
                            const invalidStepElement = document.getElementById('step' + currentStep);
                            if (invalidStepElement) invalidStepElement.style.display = 'block';
                            updateStepIndicators();
                        }
                        break;
                    }
                }

                if (!allValid) break;
            }

            if (!allValid) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Form',
                    text: 'Please complete all required fields in all sections before submitting.',
                    confirmButtonText: 'OK'
                });
                return;
            }


            const form = this;
            const formData = new FormData(form);

            // Show confirmation
            Swal.fire({
                icon: 'question',
                title: 'Confirm Submission',
                text: 'Are you sure you want to submit your declaration? This action cannot be undone.',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#2C5C36'
            }).then(async (result) => {
                if (!result.isConfirmed) return;

                // 🔄 Show loading spinner
                Swal.fire({
                    title: 'Submitting...',
                    text: 'Please wait while your declaration is being submitted.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => Swal.showLoading()
                });

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    // 🔥 If controller returned dd(), dump(), HTML, etc.
                    if (!response.ok) {
                        const text = await response.text();
                        document.open();
                        document.write(text);
                        document.close();
                        return;
                    }

                    // ✅ Parse JSON ONLY if response is OK
                    const data = await response.json();

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Application Submitted!',
                            html: `
                        <div style="text-align: center; margin: 20px 0;">
                            <div style="width: 80px; height: 80px; background: #d1fae5; border-radius: 50%;
                                display: flex; align-items: center; justify-content: center;
                                margin: 0 auto 20px;">
                                <svg width="40" height="40" viewBox="0 0 24 24"
                                    fill="none" stroke="#2C5C36" stroke-width="3">
                                    <path d="M20 6L9 17l-5-5"/>
                                </svg>
                            </div>

                            <h3 style="color: #2C5C36; margin-bottom: 10px;">Success!</h3>
                            <p style="color: #6b7280;">
                                Your conversion application has been submitted successfully.
                            </p>

                            <div style="margin: 30px 0 20px 0; padding: 15px;
                                background: #f8fafc; border-radius: 12px;
                                border: 1px solid #e2e8f0;">
                                <h3 style="color: #2C5C36; margin: 0 0 8px 0;
                                    font-size: 18px; font-weight: 700;">
                                    Application ID
                                </h3>
                                <div style="font-size: 24px; font-weight: 800;
                                    color: #2C5C36; letter-spacing: 1px;">
                                    ${data.application_id}
                                </div>
                                <p style="color: #64748b; font-size: 13px; margin-top: 10px;">
                                    Please keep this reference number for tracking
                                </p>
                            </div>
                        </div>
                    `,
                            confirmButtonText: 'Continue',
                            confirmButtonColor: '#2C5C36'
                        }).then(() => {
                            if (data.redirect_url) {
                                window.location.href = data.redirect_url;
                            } else {
                                form.reset();
                            }
                        });

                    } else {
                        throw new Error(data.message || 'Submission failed');
                    }

                } catch (err) {
                    document.open();
                    document.write(err.message);
                    document.close();
                }

            });

        });
    }// Preview functions
    function showPreview() {
        // Update timestamp
        const now = new Date();
        const timestamp = document.getElementById('previewTimestamp');
        if (timestamp) {
            timestamp.innerHTML = `🕒 Preview generated at ${now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
        }

        // Collect all form data
        const formData = new FormData(document.getElementById('multiStepForm'));

        // Populate preview fields
        const fields = [
            'former_names', 'former_religion', 'date_of_birth', 'occupation', 'current_residence',
            'contact', 'father_name', 'mother_name', 'home_address', 'county', 'district',
            'new_names', 'conversion_date', 'conversion_place', 'guardian_name', 'guardian_occupation',
            'guardian_declaration_date', 'conversion_reasons', 'guardian_declaration',
            'officer_name', 'officer_position', 'registration_number', 'verification_date',
            'officer_remarks'
        ];

        fields.forEach(field => {
            const element = document.getElementById(`preview-${field}`);
            if (element) {
                const value = formData.get(field) || '-';
                element.textContent = value;

                // Format dates
                if (field.includes('date') || field.includes('Date')) {
                    try {
                        const date = new Date(value);
                        if (!isNaN(date.getTime())) {
                            element.textContent = date.toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                        }
                    } catch (e) {
                        // Keep original value if date parsing fails
                    }
                }
            }
        });

        // Handle former religion (select + other)
        const formerReligionSelect = document.getElementById('formerReligionSelect');
        const formerReligionOther = document.getElementById('formerReligionOther');
        const formerReligionElement = document.getElementById('preview-former_religion');
        if (formerReligionElement) {
            if (formerReligionSelect && formerReligionSelect.value === 'other' && formerReligionOther) {
                formerReligionElement.textContent = formerReligionOther.value || '-';
            } else if (formerReligionSelect) {
                const selectedOption = formerReligionSelect.options[formerReligionSelect.selectedIndex];
                formerReligionElement.textContent = selectedOption.text || '-';
            }
        }

        // Handle contact (country code + number)
        const contactCountryCode = document.querySelector('[name="contact_country_code"]');
        const contactNumber = document.querySelector('[name="contact"]');
        const contactElement = document.getElementById('preview-contact');
        if (contactElement && contactCountryCode && contactNumber) {
            const countryCode = contactCountryCode.value ? `+${contactCountryCode.value}` : '';
            const number = contactNumber.value || '';
            contactElement.textContent = countryCode ? `${countryCode} ${number}` : number || '-';
        }

        // Handle declaration agreement
        const agreementCheckbox = document.getElementById('declarationAgreement');
        const agreementElement = document.getElementById('preview-declaration_agreement');
        if (agreementElement && agreementCheckbox) {
            agreementElement.innerHTML = agreementCheckbox.checked ?
                '<span style="color: #4ade80;">✓ Accepted</span>' :
                '<span style="color: #ef4444;">✗ Not accepted</span>';
        }

        // Show signature preview if uploaded
        const signatureUpload = document.getElementById('signatureUpload');
        const signaturePreviewSection = document.getElementById('signaturePreviewSection');
        const signatureImagePreview = document.getElementById('signatureImagePreview');
        const previewSignatureImage = document.getElementById('previewSignatureImage');

        if (signatureUpload && signatureUpload.files.length > 0) {
            if (signaturePreviewSection) signaturePreviewSection.style.display = 'block';
            if (previewSignatureImage && signatureImagePreview) {
                previewSignatureImage.src = signatureImagePreview.src;
            }
        } else {
            if (signaturePreviewSection) signaturePreviewSection.style.display = 'none';
        }

        // Show modal
        const modal = document.getElementById('previewModal');
        if (modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    }

    function closePreview() {
        const modal = document.getElementById('previewModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    // Close modal when clicking outside
    document.addEventListener('click', function (event) {
        const modal = document.getElementById('previewModal');
        if (modal && event.target === modal) {
            closePreview();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closePreview();
        }
    });
</script>

<style>
    #previewBtn:hover {
        background: #2563eb !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3) !important;
    }

    /* Add icon animation */
    #previewBtn svg {
        transition: transform 0.3s ease;
    }

    #previewBtn:hover svg {
        transform: scale(1.1);
    }

    .step-indicator:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .step-indicator.active {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 8px 30px rgba(44, 92, 54, 0.15);
        }

        50% {
            box-shadow: 0 8px 30px rgba(44, 92, 54, 0.25);
        }

        100% {
            box-shadow: 0 8px 30px rgba(44, 92, 54, 0.15);
        }
    }

    input:focus,
    select:focus,
    textarea:focus {
        border-color: #2C5C36 !important;
        box-shadow: 0 0 0 3px rgba(44, 92, 54, 0.1) !important;
    }

    button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(44, 92, 54, 0.25) !important;
    }

    #prevBtn:hover {
        background: #e5e7eb !important;
        border-color: #9ca3af !important;
    }

    #submitBtn:hover {
        background: #2C5C36 !important;
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.25) !important;
    }

    /* Scrollbar styling */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    ::-webkit-scrollbar-thumb {
        background: #c7d2fe;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #a5b4fc;
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .container {
            flex-direction: column;
        }

        .left-side,
        .right-side {
            flex: 1;
            width: 100%;
        }

        .left-side {
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
        }
    }

    @media (max-width: 768px) {
        .step-indicator {
            padding: 15px !important;
        }

        .step-icon {
            width: 40px !important;
            height: 40px !important;
            font-size: 18px !important;
        }

        .form-step>div {
            padding: 25px !important;
        }

        .navigation-buttons {
            flex-direction: column;
            gap: 15px;
        }

        .step-status-container {
            order: -1;
            width: 100%;
            justify-content: center;
        }
    }

    /* Base Mobile-First Styles */
    @media screen and (max-width: 768px) {

        /* Overall layout - stack vertically on mobile */
        div[style*="display: flex; min-height: 100vh"] {
            display: flex !important;
            flex-direction: column !important;
            min-height: 100vh !important;
        }

        /* Hide the desktop left sidebar on mobile */
        div[style*="flex: 0.4; background:"] {
            display: none !important;
        }

        /* Show mobile header */
        div[style*="display: none; background: #f8fafc; padding: 16px;"] {
            display: block !important;
        }

        /* Show mobile progress bar */
        div[style*="display: none; background: white; padding: 12px;"] {
            display: block !important;
        }

        /* Right side form content - full width on mobile */
        div[style*="flex: 1; background:"] {
            flex: 1 0 auto !important;
            width: 100% !important;
            padding: 16px !important;
            overflow-x: hidden !important;
        }

        /* Mobile header styling */
        div[style*="position: sticky; top: 0; background:"] {
            padding-bottom: 15px !important;
            margin-bottom: 20px !important;
        }

        /* Step title - smaller font on mobile */
        h2#currentStepTitle[style*="color: #2C5C36; margin: 0;"] {
            font-size: 1.25rem !important;
            line-height: 1.3 !important;
        }

        /* Step completion status - smaller on mobile */
        div#stepCompletionStatus[style*="background:"] {
            padding: 6px 12px !important;
            font-size: 12px !important;
            white-space: nowrap !important;
        }

        /* Step subtitle - smaller on mobile */
        p#currentStepSubtitle[style*="color: #2C5C36; margin: 10px 0 0 0"] {
            font-size: 13px !important;
            margin: 5px 0 0 0 !important;
        }

        /* Form sections - adjust padding and margins for mobile */
        div.form-step[style*="background:"] {
            padding: 20px !important;
            border-radius: 16px !important;
            margin-bottom: 20px !important;
        }

        /* Section header - smaller on mobile */
        div[style*="display: flex; align-items: center; gap: 20px; margin-bottom: 40px"] {
            flex-direction: row !important;
            align-items: flex-start !important;
            gap: 12px !important;
            margin-bottom: 25px !important;
        }

        /* Section letter icon - smaller on mobile */
        div[style*="background: white; color: #2C5C36; width: 60px; height: 60px;"] {
            width: 40px !important;
            height: 40px !important;
            font-size: 18px !important;
            border-radius: 12px !important;
            flex-shrink: 0 !important;
        }

        /* Section title - smaller on mobile */
        h3[style*="color: white; font-size: 1.8rem; font-weight: 800"] {
            font-size: 1.1rem !important;
            line-height: 1.3 !important;
            margin: 0 !important;
        }

        /* Section description - smaller on mobile */
        p[style*="color: rgba(255,255,255,0.8); margin: 8px 0 0 0"] {
            font-size: 12px !important;
            margin: 4px 0 0 0 !important;
            line-height: 1.4 !important;
        }

        /* Form grid - single column on mobile */
        div[style*="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))"] {
            display: flex !important;
            flex-direction: column !important;
            gap: 15px !important;
        }

        /* Form field containers - adjust for mobile */
        div[style*="display: flex; flex-direction: column; background: rgba(255,255,255,0.08)"] {
            padding: 15px !important;
            border-radius: 12px !important;
            width: 100% !important;
        }

        /* Remove grid-column spans on mobile */
        div[style*="grid-column: span 2;"] {
            grid-column: span 1 !important;
        }

        /* Form labels - smaller on mobile */
        label[style*="font-size: 13px; color: rgba(255,255,255,0.95)"] {
            font-size: 12px !important;
            margin-bottom: 4px !important;
        }

        /* Form inputs - better mobile touch targets */
        input[type="text"],
        input[type="tel"],
        input[type="date"],
        select,
        textarea {
            width: 100% !important;
            padding: 12px !important;
            font-size: 14px !important;
            min-height: 44px !important;
            /* Minimum touch target size */
            box-sizing: border-box !important;
        }

        /* Textareas - adjust height for mobile */
        textarea {
            min-height: 80px !important;
            resize: vertical !important;
        }

        /* Remove background patterns on mobile to save performance */
        div[style*="position: absolute; top: -100px;"] {
            display: none !important;
        }

        /* Declaration section - adjust for mobile */
        div[style*="background: rgba(255,255,255,0.08); padding: 30px;"] {
            padding: 15px !important;
        }

        /* Declaration text - smaller font for mobile */
        div[style*="background: rgba(255,255,255,0.05); padding: 30px;"] {
            padding: 15px !important;
        }

        /* Arabic text - smaller on mobile */
        p[style*="color: white; font-size: 24px; font-weight: 700;"] {
            font-size: 18px !important;
        }

        /* Transliteration text - smaller on mobile */
        p[style*="color: rgba(255,255,255,0.9); font-size: 18px;"] {
            font-size: 14px !important;
        }

        /* Declaration points - smaller on mobile */
        ul[style*="color: rgba(255,255,255,0.9); padding-left: 20px;"] {
            padding-left: 16px !important;
        }

        ul[style*="color: rgba(255,255,255,0.9); padding-left: 20px;"] li {
            font-size: 13px !important;
            margin-bottom: 8px !important;
            line-height: 1.4 !important;
        }

        /* File upload buttons - full width on mobile */
        button[style*="background: rgba(255,255,255,0.1); color: white; border: 1px solid"] {
            width: 100% !important;
            justify-content: center !important;
            padding: 12px !important;
            margin-bottom: 8px !important;
        }

        /* File name display - better on mobile */
        span[id$="FileName"][style*="color: rgba(255,255,255,0.7)"] {
            display: block !important;
            text-align: center !important;
            width: 100% !important;
            font-size: 12px !important;
            margin-top: 4px !important;
        }

        /* Navigation buttons - stack on mobile */
        div[style*="display: flex; justify-content: space-between; align-items: center; margin-top: 50px"] {
            flex-direction: column !important;
            gap: 20px !important;
            margin-top: 30px !important;
            padding-top: 20px !important;
        }

        /* Step status - center on mobile */
        span#stepStatus[style*="font-size: 14px; color: #2C5C36"] {
            order: 1 !important;
            width: 100% !important;
            text-align: center !important;
            margin: 10px 0 !important;
        }

        /* Navigation buttons container - column layout on mobile */
        div[style*="display: flex; align-items: center; gap: 15px"] {
            flex-direction: column !important;
            width: 100% !important;
            gap: 10px !important;
        }

        /* Previous/Next buttons - full width on mobile */
        button#prevBtn[style*="background: #f3f4f6; color: #2C5C36"],
        button#nextBtn[style*="background:"],
        button#submitBtn[style*="background:"] {
            width: 100% !important;
            justify-content: center !important;
            padding: 14px !important;
            margin: 5px 0 !important;
        }

        /* Hide desktop step status when mobile is active */
        span#stepStatus:not([style*="order: 1"]) {
            display: none !important;
        }

        /* Checkbox alignment for mobile */
        input[type="checkbox"][style*="width: 20px; height: 20px;"] {
            width: 20px !important;
            height: 20px !important;
            min-width: 20px !important;
            min-height: 20px !important;
        }

        /* Agreement text - smaller on mobile */
        p[style*="color: rgba(255,255,255,0.8); font-size: 14px; line-height: 1.5"] {
            font-size: 13px !important;
            line-height: 1.4 !important;
        }
    }

    /* Extra Small Devices (Phones < 375px) */
    @media screen and (max-width: 374px) {

        /* Even smaller padding */
        div[style*="flex: 1; background:"] {
            padding: 12px !important;
        }

        /* Smaller section header */
        div[style*="display: flex; align-items: center; gap: 20px; margin-bottom: 40px"] {
            gap: 8px !important;
            margin-bottom: 20px !important;
        }

        /* Even smaller section letter */
        div[style*="background: white; color: #2C5C36; width: 60px; height: 60px;"] {
            width: 36px !important;
            height: 36px !important;
            font-size: 16px !important;
        }

        /* Even smaller titles */
        h3[style*="color: white; font-size: 1.8rem; font-weight: 800"] {
            font-size: 1rem !important;
        }

        /* Smaller form field containers */
        div[style*="display: flex; flex-direction: column; background: rgba(255,255,255,0.08)"] {
            padding: 12px !important;
        }

        /* Smaller inputs */
        input[type="text"],
        input[type="tel"],
        input[type="date"],
        select,
        textarea {
            padding: 10px !important;
            font-size: 13px !important;
        }

        /* Hide decorative elements on very small screens */
        div[style*="box-shadow: 0 20px 40px"] {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
        }
    }

    /* Tablet Styles (768px - 1024px) */
    @media screen and (min-width: 768px) and (max-width: 1024px) {

        /* Show sidebar on tablets */
        div[style*="flex: 0.4; background:"] {
            flex: 0 0 35% !important;
            padding: 25px !important;
        }

        /* Adjust form padding */
        div[style*="flex: 1; background:"] {
            padding: 25px !important;
        }

        /* Adjust grid for tablets */
        div[style*="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }

    /* Desktop Styles (1024px and up) */
    @media screen and (min-width: 1025px) {

        /* Hide mobile elements on desktop */
        div[style*="display: none; background: #f8fafc; padding: 16px;"] {
            display: none !important;
        }

        div[style*="display: none; background: white; padding: 12px;"] {
            display: none !important;
        }

        /* Show desktop sidebar */
        div[style*="flex: 0.4; background:"] {
            display: block !important;
            flex: 0 0 35% !important;
        }

        /* Restore flex layout */
        div[style*="display: flex; min-height: 100vh"] {
            flex-direction: row !important;
        }
    }

    /* Fix for mobile viewport */
    @media screen and (max-width: 768px) {

        html,
        body {
            overflow-x: hidden !important;
            width: 100% !important;
            position: relative !important;
        }

        body {
            -webkit-text-size-adjust: 100% !important;
            text-size-adjust: 100% !important;
        }
    }

    /* Touch-friendly improvements */
    @media (hover: none) and (pointer: coarse) {

        /* Larger touch targets for mobile */
        input[type="text"],
        input[type="tel"],
        input[type="date"],
        select,
        textarea,
        button {
            min-height: 44px !important;
            font-size: 16px !important;
            /* Prevents iOS zoom on focus */
        }

        /* Better spacing for touch */
        .step-indicator[style*="display: flex; align-items: center;"] {
            padding: 16px !important;
            margin: 8px 0 !important;
        }
    }

    /* Prevent horizontal scrolling on mobile */
    * {
        max-width: 100% !important;
    }

    /* Improve readability on small screens */
    @media screen and (max-width: 768px) {
        body {
            line-height: 1.4 !important;
        }

        p,
        li,
        span,
        div {
            line-height: 1.4 !important;
        }
    }

    #formerReligionOther {
        -webkit-appearance: none;
        /* Remove dropdown arrow on Chrome/Safari */
        -moz-appearance: none;
        /* Remove arrow on Firefox */
        appearance: none;
    }
</style>

@include('layouts.form-footers')