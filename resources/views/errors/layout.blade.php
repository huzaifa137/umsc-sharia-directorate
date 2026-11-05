{{--
    Standalone error page (Patch 12). Deliberately does not extend layouts.app or call
    Helper/DB: a 500 or 503 must still render when the database or session is down.
--}}
@php
    $locale = in_array(app()->getLocale(), ['en', 'sw', 'ar'], true) ? app()->getLocale() : 'en';
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';

    $staff = false;
    try { $staff = (bool) session('LoggedAdmin'); } catch (\Throwable $e) { /* session store may be what failed */ }

    $copy = [
        403 => [
            'en' => ['Access restricted', 'Your role does not have permission to open this page. If you think this is a mistake, contact your District Khadhi or the Directorate of Sharia.'],
            'sw' => ['Ufikiaji umezuiwa', 'Wadhifa wako hauna ruhusa ya kufungua ukurasa huu. Ukiona kuna kosa, wasiliana na Khadhi wa Wilaya au Idara ya Sharia.'],
            'ar' => ['الوصول مقيّد', 'صلاحيات دورك لا تسمح بفتح هذه الصفحة. إذا كنت تعتقد أن هذا خطأ، فتواصل مع قاضي المنطقة أو مديرية الشريعة.'],
        ],
        404 => [
            'en' => ['Page not found', 'The page you asked for does not exist or has moved. Check the address, or go back to a page you know.'],
            'sw' => ['Ukurasa haujapatikana', 'Ukurasa uliouomba haupo au umehamishwa. Angalia anwani, au rudi kwenye ukurasa unaoujua.'],
            'ar' => ['الصفحة غير موجودة', 'الصفحة المطلوبة غير موجودة أو تم نقلها. تحقق من العنوان أو عد إلى صفحة تعرفها.'],
        ],
        419 => [
            'en' => ['Your session has expired', 'For your security the page timed out before it was submitted. Nothing was saved. Sign in again and repeat the last step.'],
            'sw' => ['Kipindi chako kimeisha', 'Kwa usalama wako ukurasa uliisha muda kabla ya kutumwa. Hakuna kilichohifadhiwa. Ingia tena na urudie hatua ya mwisho.'],
            'ar' => ['انتهت جلستك', 'حفاظًا على أمانك انتهت مهلة الصفحة قبل إرسالها. لم يتم حفظ شيء. سجّل الدخول مرة أخرى وكرّر الخطوة الأخيرة.'],
        ],
        429 => [
            'en' => ['Too many requests', 'You have made a lot of requests in a short time. Wait a minute, then try again.'],
            'sw' => ['Maombi mengi mno', 'Umetuma maombi mengi ndani ya muda mfupi. Subiri dakika moja kisha ujaribu tena.'],
            'ar' => ['طلبات كثيرة جدًا', 'أرسلت طلبات كثيرة في وقت قصير. انتظر دقيقة ثم حاول مجددًا.'],
        ],
        500 => [
            'en' => ['Something went wrong on our side', 'The system could not complete your request. It has been logged. Please try again shortly, and if it keeps happening quote the reference below to support.'],
            'sw' => ['Hitilafu imetokea upande wetu', 'Mfumo haukuweza kukamilisha ombi lako. Tukio limerekodiwa. Jaribu tena baadaye, na likiendelea toa namba ya kumbukumbu iliyo hapa chini kwa msaada.'],
            'ar' => ['حدث خطأ من جانبنا', 'تعذّر على النظام إكمال طلبك. تم تسجيل الخطأ. حاول مجددًا بعد قليل، وإذا استمر فاذكر الرقم المرجعي أدناه للدعم.'],
        ],
        503 => [
            'en' => ['Back shortly', 'The system is being updated. Your records are safe. Please try again in a few minutes.'],
            'sw' => ['Tutarudi hivi punde', 'Mfumo unasasishwa. Kumbukumbu zako ziko salama. Jaribu tena baada ya dakika chache.'],
            'ar' => ['سنعود قريبًا', 'يجري تحديث النظام. سجلاتك آمنة. حاول مجددًا بعد دقائق.'],
        ],
    ];

    $ui = [
        'en' => ['dash' => 'Back to dashboard', 'home' => 'Public website', 'login' => 'Sign in', 'retry' => 'Try again', 'ref' => 'Reference', 'org' => 'Directorate of Sharia'],
        'sw' => ['dash' => 'Rudi kwenye dashibodi', 'home' => 'Tovuti ya umma', 'login' => 'Ingia', 'retry' => 'Jaribu tena', 'ref' => 'Kumbukumbu', 'org' => 'Idara ya Sharia'],
        'ar' => ['dash' => 'العودة إلى لوحة التحكم', 'home' => 'الموقع العام', 'login' => 'تسجيل الدخول', 'retry' => 'حاول مجددًا', 'ref' => 'الرقم المرجعي', 'org' => 'مديرية الشريعة'],
    ][$locale];

    $code = $code ?? 500;
    [$title, $text] = $copy[$code][$locale] ?? $copy[500][$locale];

    // Deliberate abort(403, '…') messages are written for people; framework defaults and model-not-found text are not.
    $custom = isset($exception) && $code === 403 ? trim((string) $exception->getMessage()) : '';
    if ($custom !== '' && !str_starts_with($custom, 'This action is unauthorized') && mb_strlen($custom) < 160) {
        $text = $custom;
    }

    $retry = in_array($code, [429, 500, 503], true);
    $reference = $code >= 500 ? now()->format('Ymd-His') . '-' . $code : null;
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <meta name="theme-color" content="#0a3320">
    <title>{{ $code }} · {{ $title }} | {{ $ui['org'] }}</title>
    <link rel="icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=IBM+Plex+Sans:wght@400;500;600&family=Source+Serif+4:opsz,wght@8..60,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/umsc-error.css') }}">
</head>
<body>
    <main class="err" id="main">
        <a class="err-brand" href="{{ url('/') }}" aria-label="{{ $ui['org'] }}">
            <img src="{{ asset('asset/images/logo.png') }}" alt="" width="44" height="44">
            <span>{{ $ui['org'] }}<small>Uganda Muslim Supreme Council</small></span>
        </a>

        <section class="err-card" aria-labelledby="err-title">
            <p class="err-code" aria-hidden="true">{{ $code }}</p>
            <h1 id="err-title">{{ $title }}</h1>
            <p class="err-text">{{ $text }}</p>

            <div class="err-actions">
                @if ($retry)
                    <a class="err-btn err-btn--primary" href="{{ url()->current() }}">{{ $ui['retry'] }}</a>
                @endif
                @if ($staff && $code !== 419)
                    <a class="err-btn {{ $retry ? '' : 'err-btn--primary' }}" href="{{ url('/users/dashboard') }}">{{ $ui['dash'] }}</a>
                @elseif ($code === 419 || $code === 403 || $code === 404)
                    <a class="err-btn err-btn--primary" href="{{ url('/users/login') }}">{{ $ui['login'] }}</a>
                @endif
                <a class="err-btn" href="{{ url('/') }}">{{ $ui['home'] }}</a>
            </div>

            @if ($reference)
                <p class="err-ref">{{ $ui['ref'] }}: <code dir="ltr">{{ $reference }}</code></p>
            @endif
        </section>
    </main>
</body>
</html>
