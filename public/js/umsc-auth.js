(function () {
    'use strict';

    // Show / hide password buttons: <button data-toggle="#fieldId">
    document.querySelectorAll('[data-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.querySelector(btn.getAttribute('data-toggle'));
            if (!input) return;
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.textContent = show ? btn.getAttribute('data-hide') : btn.getAttribute('data-show');
            btn.setAttribute('aria-pressed', show ? 'true' : 'false');
        });
    });

    // Caps Lock warning on password fields
    document.querySelectorAll('input[type="password"], [data-caps]').forEach(function (input) {
        var hint = document.querySelector('[data-caps-for="#' + input.id + '"]');
        if (!hint) return;
        function check(e) {
            if (e.getModifierState) hint.classList.toggle('is-on', e.getModifierState('CapsLock'));
        }
        input.addEventListener('keydown', check);
        input.addEventListener('keyup', check);
        input.addEventListener('blur', function () { hint.classList.remove('is-on'); });
    });

    // Live password checklist: <ul class="a-rules" data-for="#password" data-confirm="#confirm">
    document.querySelectorAll('.a-rules[data-for]').forEach(function (list) {
        var input = document.querySelector(list.getAttribute('data-for'));
        var confirm = list.getAttribute('data-confirm') ? document.querySelector(list.getAttribute('data-confirm')) : null;
        var tests = {
            min6: function (v) { return v.length >= 6; },
            min8: function (v) { return v.length >= 8; },
            upper: function (v) { return /[A-Z]/.test(v); },
            lower: function (v) { return /[a-z]/.test(v); },
            digit: function (v) { return /[0-9]/.test(v); },
            symbol: function (v) { return /[^a-zA-Z0-9]/.test(v); },
            special: function (v) { return /[@$!%*?&#]/.test(v); },
            match: function (v) { return confirm ? (v.length > 0 && v === confirm.value) : false; }
        };
        function run() {
            list.querySelectorAll('li[data-rule]').forEach(function (li) {
                var fn = tests[li.getAttribute('data-rule')];
                li.classList.toggle('is-ok', !!fn && fn(input.value));
            });
        }
        input.addEventListener('input', run);
        if (confirm) confirm.addEventListener('input', run);
        run();
    });

    window.umscAuth = {
        csrf: function () {
            var m = document.querySelector('meta[name="csrf-token"]');
            return m ? m.getAttribute('content') : '';
        },
        post: function (url, data) {
            return fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': this.csrf()
                },
                credentials: 'same-origin',
                body: JSON.stringify(data)
            }).then(function (r) {
                return r.json().catch(function () { return {}; }).then(function (body) {
                    return { ok: r.ok, status: r.status, body: body };
                });
            });
        },
        setError: function (name, msg) {
            var input = document.getElementById(name);
            var out = document.getElementById(name + '-error');
            if (input) input.classList.toggle('is-invalid', !!msg);
            if (out) out.textContent = msg || '';
        }
    };
})();
