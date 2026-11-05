/* UMSC staff chat (Patch 12). Same endpoints and payloads as before; rewritten for
   safety (everything from the server is escaped), accessibility, and quieter polling. */
(function () {
    'use strict';

    var root = document.getElementById('chat');
    if (!root) return;

    var D = root.dataset;
    var csrf = (document.querySelector('#chatSendForm input[name="_token"]') || {}).value
        || (document.querySelector('meta[name="csrf-token"]') || {}).content;
    var me = D.userId ? Number(D.userId) : null;
    var rtl = document.documentElement.dir === 'rtl';
    var small = window.matchMedia('(max-width: 767.98px)');
    var $ = function (id) { return document.getElementById(id); };

    var current = null;          // open conversation id
    var shown = new Set();       // message ids already on screen
    var lastTs = null;
    var lastMsg = null;          // {sender, ts, day} of the last rendered message
    var tab = '';
    var pollTimer = null, listTimer = null, failures = 0;
    var mode = 'direct', picked = {};

    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }
    function toast(type, msg) { if (window.UMSC) window.UMSC.toast(type, msg); }
    function initials(n) { return (n || '?').split(' ').filter(Boolean).slice(0, 2).map(function (w) { return w[0].toUpperCase(); }).join(''); }
    function avatar(name, url, cls) {
        return '<span class="chat-avatar ' + (cls || '') + '">' + (url
            ? '<img src="' + esc(url) + '" alt="" loading="lazy">' : esc(initials(name))) + '</span>';
    }

    /* ---------- network ---------- */
    function api(url, opts) {
        opts = opts || {};
        opts.headers = Object.assign({ 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, opts.headers || {});
        return fetch(url, opts).then(function (r) {
            return r.json().then(function (d) {
                if (!r.ok || d.status === false) { var e = new Error(d.message || 'Request failed'); e.server = true; throw e; }
                return d;
            }, function () { throw new Error(r.status === 401 || r.status === 419 ? 'session' : 'bad-response'); });
        });
    }
    function post(url, body) {
        var isForm = body instanceof FormData;
        return api(url, {
            method: 'POST', body: isForm ? body : JSON.stringify(body),
            headers: Object.assign({ 'X-CSRF-TOKEN': csrf }, isForm ? {} : { 'Content-Type': 'application/json' })
        });
    }
    function banner(msg) { var b = $('chatBanner'); b.textContent = msg || ''; b.hidden = !msg; }
    function fail(err, fallback) {
        if (err && err.message === 'session') toast('warning', 'Your session expired. Reload the page and sign in again.');
        else toast('error', (err && err.server && err.message) || fallback);
    }

    /* ---------- conversation list ---------- */
    function loadList() {
        api(D.conversations + (tab ? '?type=' + encodeURIComponent(tab) : '')).then(function (d) {
            failures = 0; banner('');
            renderList(d.conversations || []);
        }).catch(function (e) {
            failures++;
            banner(e.message === 'session' ? 'Your session expired. Reload the page.' : 'Connection problem. Retrying…');
        });
    }
    function renderList(list) {
        var ul = $('conversationList');
        if (!list.length) {
            ul.innerHTML = '<li class="chat-none"><i class="bx bx-message-dots" aria-hidden="true"></i>No conversations yet</li>';
            return;
        }
        ul.innerHTML = list.map(function (c) {
            var unread = c.unread > 0;
            return '<li><button type="button" class="chat-item' + (String(c.id) === String(current) ? ' is-active' : '') + (unread ? ' has-unread' : '') +
                '" data-id="' + esc(c.id) + '" data-name="' + esc((c.name || '').toLowerCase()) + '"' +
                (String(c.id) === String(current) ? ' aria-current="true"' : '') + '>' +
                avatar(c.name, c.avatar) +
                '<span class="chat-item__body"><span class="chat-item__row"><span class="chat-item__name" dir="auto">' + esc(c.name) + '</span>' +
                '<span class="chat-item__time">' + esc(c.last_message_at || '') + '</span></span>' +
                '<span class="chat-item__row"><span class="chat-item__last" dir="auto">' + esc(c.last_message) + '</span>' +
                (unread ? '<span class="chat-badge" aria-label="' + esc(c.unread) + ' unread">' + esc(c.unread) + '</span>' : '') +
                '</span></span></button></li>';
        }).join('');
        applyFilter();
    }
    function applyFilter() {
        var t = ($('chatListFilter').value || '').toLowerCase();
        document.querySelectorAll('#conversationList .chat-item').forEach(function (b) {
            b.parentNode.hidden = t && b.dataset.name.indexOf(t) === -1;
        });
    }
    $('conversationList').addEventListener('click', function (e) {
        var b = e.target.closest('.chat-item');
        if (b) openConversation(b.dataset.id, true);
    });
    $('chatListFilter').addEventListener('input', applyFilter);

    document.querySelectorAll('.chat-list .chat-tab').forEach(function (t) {
        t.addEventListener('click', function () {
            document.querySelectorAll('.chat-list .chat-tab').forEach(function (x) { x.classList.remove('is-on'); x.setAttribute('aria-pressed', 'false'); });
            t.classList.add('is-on'); t.setAttribute('aria-pressed', 'true');
            tab = t.dataset.type; loadList();
        });
    });

    /* ---------- open a conversation ---------- */
    function openConversation(id, userAction) {
        current = id; lastTs = null; lastMsg = null; shown = new Set();
        clearInterval(pollTimer);
        $('chatWindowEmpty').hidden = true;
        $('chatWindowActive').hidden = false;
        $('chatMessages').innerHTML = '';
        if (window.UMSC) window.UMSC.skeleton($('chatMessages'), true, 5);
        root.classList.add('is-open');
        if (small.matches && userAction) history.pushState({ chat: id }, '');

        api(D.base + '/' + encodeURIComponent(id) + '/messages').then(function (d) {
            if (String(current) !== String(id)) return;
            if (window.UMSC) window.UMSC.skeleton($('chatMessages'), false);
            $('chatMessages').innerHTML = '';
            $('chatHeaderAvatar').innerHTML = avatar(d.header.name, d.header.avatar);
            $('chatHeaderName').textContent = d.header.name;
            $('chatHeaderSubtitle').textContent = d.header.subtitle || '';
            d.messages.forEach(append);
            toBottom();
            if (d.messages.length) lastTs = d.messages[d.messages.length - 1].created_ts;
            loadList();
            startPolling(id);
            if (userAction && !small.matches) $('chatBodyInput').focus();
        }).catch(function (e) {
            if (window.UMSC) window.UMSC.skeleton($('chatMessages'), false);
            $('chatMessages').innerHTML = '<p class="chat-none">Could not load this conversation.</p>';
            fail(e, 'Could not load this conversation.');
        });
    }
    function startPolling(id) {
        clearInterval(pollTimer);
        pollTimer = setInterval(function () { if (!document.hidden) poll(id); }, 4000);
    }
    function poll(id) {
        api(D.base + '/' + encodeURIComponent(id) + '/poll' + (lastTs ? '?since=' + encodeURIComponent(lastTs) : '')).then(function (d) {
            if (String(current) !== String(id) || !d.messages.length) return;
            var pinned = nearBottom();
            d.messages.forEach(append);
            lastTs = d.messages[d.messages.length - 1].created_ts;
            if (pinned) toBottom();
            loadList();
        }).catch(function () { /* the list banner already reports connectivity */ });
    }
    function closeConversation() {
        root.classList.remove('is-open');
        clearInterval(pollTimer);
        current = null;
        $('chatWindowActive').hidden = true;
        $('chatWindowEmpty').hidden = false;
        applyActive();
    }
    function applyActive() {
        document.querySelectorAll('#conversationList .chat-item').forEach(function (b) {
            var on = current != null && String(b.dataset.id) === String(current);
            b.classList.toggle('is-active', on);
            if (on) b.setAttribute('aria-current', 'true'); else b.removeAttribute('aria-current');
        });
    }
    $('chatMobileBack').addEventListener('click', function () {
        if (history.state && history.state.chat) history.back(); else closeConversation();
    });
    window.addEventListener('popstate', function () { if (root.classList.contains('is-open')) closeConversation(); });

    /* ---------- messages ---------- */
    function dayKey(ts) { var d = new Date(ts * 1000); return d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate(); }
    function dayLabel(ts) {
        var d = new Date(ts * 1000), now = new Date(), y = new Date(); y.setDate(now.getDate() - 1);
        if (dayKey(ts) === dayKey(now / 1000)) return 'Today';
        if (dayKey(ts) === dayKey(y / 1000)) return 'Yesterday';
        try { return d.toLocaleDateString(document.documentElement.lang || undefined, { day: 'numeric', month: 'short', year: 'numeric' }); }
        catch (e) { return d.toDateString(); }
    }
    function nearBottom() { var s = $('chatMessages'); return s.scrollHeight - s.scrollTop - s.clientHeight < 120; }
    function toBottom() { var s = $('chatMessages'); s.scrollTop = s.scrollHeight; }

    function attachment(m) {
        if (!m.attachment) return '';
        var u = esc(m.attachment);
        if (m.attachment_type === 'image') return '<a href="' + u + '" target="_blank" rel="noopener"><img src="' + u + '" alt="Image attachment" loading="lazy"></a>';
        if (m.attachment_type === 'video') return '<video src="' + u + '" controls preload="metadata"></video>';
        if (m.attachment_type === 'audio') return '<audio src="' + u + '" controls preload="none"></audio>';
        return '<a class="chat-dl" href="' + u + '" target="_blank" rel="noopener"><i class="bx bx-file" aria-hidden="true"></i> Download attachment</a>';
    }
    function append(m) {
        if (shown.has(m.id)) return;   // a message can arrive from both the send response and the next poll
        shown.add(m.id);

        var wrap = $('chatMessages'), mine = Number(m.sender_id) === me;
        var key = dayKey(m.created_ts);
        if (!lastMsg || lastMsg.day !== key) {
            var sep = document.createElement('div');
            sep.className = 'chat-day'; sep.textContent = dayLabel(m.created_ts);
            wrap.appendChild(sep);
        }
        var follow = lastMsg && lastMsg.day === key && lastMsg.sender === m.sender_id && (m.created_ts - lastMsg.ts) < 300;
        lastMsg = { sender: m.sender_id, ts: m.created_ts, day: key };

        var row = document.createElement('div');
        row.className = 'chat-msg ' + (mine ? 'is-mine' : 'is-theirs') + (follow ? ' is-follow' : '');
        row.innerHTML =
            (!mine && !follow ? '<div class="chat-msg__name" dir="auto">' + esc(m.sender_name) + '</div>' : '') +
            '<div class="chat-bubble" dir="auto">' + (m.body ? esc(m.body) : '') + attachment(m) + '</div>' +
            '<div class="chat-msg__time">' + esc(m.created_at) + '</div>';
        wrap.appendChild(row);
    }

    /* ---------- composer ---------- */
    var body = $('chatBodyInput'), fileIn = $('chatAttachmentInput'), sendBtn = $('chatSendBtn'), sending = false;
    function canSend() { return !sending && (body.value.trim() !== '' || fileIn.files.length > 0); }
    function syncSend() { sendBtn.disabled = !canSend(); }
    function grow() { body.style.height = 'auto'; body.style.height = Math.min(body.scrollHeight, 140) + 'px'; }
    body.addEventListener('input', function () { grow(); syncSend(); });
    body.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey && !e.isComposing) { e.preventDefault(); $('chatSendForm').requestSubmit(); }
    });

    fileIn.addEventListener('change', function () {
        var f = fileIn.files[0], p = $('chatAttachPreview');
        if (f && f.size > 25 * 1024 * 1024) { toast('error', 'That file is over 25 MB.'); fileIn.value = ''; f = null; }
        if (f) p.querySelector('span').textContent = f.name;
        p.hidden = !f; syncSend();
    });
    $('chatAttachRemove').addEventListener('click', function () { fileIn.value = ''; $('chatAttachPreview').hidden = true; syncSend(); });

    $('chatSendForm').addEventListener('submit', function (e) {
        e.preventDefault();
        if (!current || !canSend()) return;
        var fd = new FormData(), text = body.value.trim();
        if (text) fd.append('body', text);
        if (fileIn.files[0]) fd.append('attachment', fileIn.files[0]);
        sending = true; syncSend();
        post(D.base + '/' + encodeURIComponent(current) + '/messages', fd).then(function (d) {
            append(d.message); lastTs = d.message.created_ts; toBottom();
            body.value = ''; grow(); fileIn.value = ''; $('chatAttachPreview').hidden = true;
            loadList();
        }).catch(function (err) { fail(err, 'Could not send the message.'); })
          .then(function () { sending = false; syncSend(); body.focus(); });
    });

    /* ---------- voice notes ---------- */
    var rec = null, chunks = [], recT0 = 0, recTimer = null, starting = false, pending = null, cancelled = false, startX = 0;
    var mic = $('chatMicBtn');

    function recUi(on) {
        $('chatRecordingBar').hidden = !on;
        $('chatSendForm').hidden = on;
        if (!on) clearInterval(recTimer);
    }
    function tick() {
        var s = Math.floor((Date.now() - recT0) / 1000);
        $('chatRecordingTimer').textContent = Math.floor(s / 60) + ':' + String(s % 60).padStart(2, '0');
    }
    function startRec() {
        if (!current || starting || (rec && rec.state === 'recording')) return;
        if (!navigator.mediaDevices || !window.MediaRecorder) { toast('warning', 'Voice notes are not supported in this browser.'); return; }
        starting = true; pending = null; cancelled = false;
        navigator.mediaDevices.getUserMedia({ audio: true }).then(function (stream) {
            starting = false; chunks = [];
            rec = new MediaRecorder(stream);
            rec.ondataavailable = function (e) { if (e.data && e.data.size) chunks.push(e.data); };
            rec.start(); recT0 = Date.now(); recUi(true); tick(); recTimer = setInterval(tick, 250);
            if (pending === 'send') finishRec(true); else if (pending === 'cancel') finishRec(false);
            pending = null;
        }).catch(function () { starting = false; toast('error', 'Microphone access was denied or is unavailable.'); });
    }
    function finishRec(send) {
        if (!rec || rec.state === 'inactive') return;
        var r = rec;
        r.onstop = function () {
            r.stream.getTracks().forEach(function (t) { t.stop(); });
            if (!send) { chunks = []; return; }
            var fd = new FormData();
            fd.append('attachment', new Blob(chunks, { type: 'audio/webm' }), 'voice-note.webm');
            post(D.base + '/' + encodeURIComponent(current) + '/messages', fd).then(function (d) {
                append(d.message); lastTs = d.message.created_ts; toBottom(); loadList();
            }).catch(function (err) { fail(err, 'Could not send the voice note.'); });
        };
        r.stop(); recUi(false);
    }
    mic.addEventListener('pointerdown', function (e) {
        if (e.button > 0) return;
        e.preventDefault(); startX = e.clientX; startRec();
    });
    document.addEventListener('pointermove', function (e) {
        if ((!starting && !(rec && rec.state === 'recording')) || cancelled) return;
        if (((startX - e.clientX) * (rtl ? -1 : 1)) > 80) {
            cancelled = true;
            if (rec && rec.state === 'recording') finishRec(false); else pending = 'cancel';
        }
    });
    document.addEventListener('pointerup', function (e) {
        if (e.target !== mic && !starting && !(rec && rec.state === 'recording')) return;
        if (cancelled) return;
        // Released over the mic after a hold: send. A quick tap leaves the bar open so the buttons can be used.
        if (rec && rec.state === 'recording') { if (Date.now() - recT0 > 700) finishRec(true); }
        else if (starting) pending = 'send';
    });
    mic.addEventListener('click', function (e) {
        if (e.detail === 0) startRec();   // keyboard activation: start, then use the Send / Discard buttons
    });
    $('chatRecordingCancel').addEventListener('click', function () { finishRec(false); });
    $('chatRecordingSend').addEventListener('click', function () { finishRec(true); });

    /* ---------- details ---------- */
    $('chatHeaderInfo').addEventListener('click', function () {
        if (!current) return;
        api(D.base + '/' + encodeURIComponent(current) + '/profile').then(function (d) {
            var det = $('profileDetails'), mem = $('profileMembers');
            det.innerHTML = ''; mem.hidden = true;
            if (d.type === 'direct') {
                var u = d.user;
                $('profileAvatar').innerHTML = avatar(u.name, u.avatar, 'chat-avatar--lg');
                $('profileName').textContent = u.name; $('profileSubtitle').textContent = u.role || '';
                det.innerHTML = [['Email', u.email], ['Phone', u.phone], ['District', u.district], ['Mosque', u.mosque]]
                    .filter(function (r) { return r[1]; })
                    .map(function (r) { return '<div><dt>' + r[0] + '</dt><dd>' + esc(r[1]) + '</dd></div>'; }).join('')
                    || '<p class="text-muted text-center">No further details on file.</p>';
            } else {
                $('profileAvatar').innerHTML = avatar(d.group.name, d.group.avatar, 'chat-avatar--lg');
                $('profileName').textContent = d.group.name;
                $('profileSubtitle').textContent = d.group.members_count + ' members';
                mem.hidden = false;
                $('profileMembersList').innerHTML = d.members.map(function (m) {
                    return '<li class="chat-person is-static">' + avatar(m.name, m.avatar, 'chat-avatar--sm') +
                        '<span class="chat-person__text"><strong>' + esc(m.name) + (m.is_admin ? ' <span class="badge bg-label-secondary">Admin</span>' : '') +
                        '</strong><small>' + esc(m.role || '') + '</small></span></li>';
                }).join('');
            }
            bootstrap.Modal.getOrCreateInstance($('profileModal')).show();
        }).catch(function (e) { fail(e, 'Could not load details.'); });
    });

    /* ---------- new chat ---------- */
    var modal = $('newChatModal');
    if (modal) {
        document.querySelectorAll('#newChatModeTabs .chat-tab').forEach(function (b) {
            b.addEventListener('click', function () {
                document.querySelectorAll('#newChatModeTabs .chat-tab').forEach(function (x) { x.classList.remove('is-on'); x.setAttribute('aria-pressed', 'false'); });
                b.classList.add('is-on'); b.setAttribute('aria-pressed', 'true');
                mode = b.dataset.mode; picked = {};
                $('groupNameWrap').hidden = mode !== 'group';
                $('groupCreateFooter').hidden = mode !== 'group';
                searchUsers($('userSearchInput').value);
            });
        });
        var deb;
        $('userSearchInput').addEventListener('input', function () {
            clearTimeout(deb); var v = this.value; deb = setTimeout(function () { searchUsers(v); }, 250);
        });
        modal.addEventListener('show.bs.modal', function () { searchUsers(''); });
        modal.addEventListener('shown.bs.modal', function () { $('userSearchInput').focus(); });

        $('userSearchResults').addEventListener('click', function (e) {
            var row = e.target.closest('.chat-person'); if (!row) return;
            var id = row.dataset.id;
            if (mode === 'direct') { startDirect(id); return; }
            var cb = row.querySelector('input');
            if (e.target !== cb) cb.checked = !cb.checked;
            if (cb.checked) picked[id] = true; else delete picked[id];
        });
        $('createGroupBtn').addEventListener('click', function () {
            var name = $('groupNameInput').value.trim(), ids = Object.keys(picked);
            if (!name) { toast('warning', 'Please name the group.'); $('groupNameInput').focus(); return; }
            if (!ids.length) { toast('warning', 'Select at least one member.'); return; }
            var btn = this; if (window.UMSC) window.UMSC.busy(btn, true, 'Creating…');
            post(D.createGroup, { name: name, user_ids: ids }).then(function (d) {
                bootstrap.Modal.getInstance(modal).hide();
                $('groupNameInput').value = ''; picked = {};
                loadList(); openConversation(d.conversation_id, true);
            }).catch(function (e) { fail(e, 'Could not create the group.'); })
              .then(function () { if (window.UMSC) window.UMSC.busy(btn, false); });
        });
    }
    function searchUsers(term) {
        api(D.userSearch + '?q=' + encodeURIComponent(term || '')).then(function (d) {
            var ul = $('userSearchResults');
            if (!d.users.length) { ul.innerHTML = '<li class="chat-none">No staff found.</li>'; return; }
            ul.innerHTML = d.users.map(function (u) {
                return '<li><button type="button" class="chat-person" data-id="' + esc(u.id) + '">' + avatar(u.name, u.avatar, 'chat-avatar--sm') +
                    '<span class="chat-person__text"><strong>' + esc(u.name) + '</strong><small>' + esc(u.role || '') + '</small></span>' +
                    (mode === 'group' ? '<input type="checkbox" class="form-check-input" tabindex="-1" aria-label="Select ' + esc(u.name) + '"' + (picked[u.id] ? ' checked' : '') + '>' : '') +
                    '</button></li>';
            }).join('');
        }).catch(function (e) { fail(e, 'Could not search staff.'); });
    }
    function startDirect(id) {
        post(D.startDirect, { user_id: id }).then(function (d) {
            bootstrap.Modal.getInstance(modal).hide();
            loadList(); openConversation(d.conversation_id, true);
        }).catch(function (e) { fail(e, 'Could not start the chat.'); });
    }

    /* ---------- housekeeping ---------- */
    function schedule() { clearInterval(listTimer); listTimer = setInterval(function () { if (!document.hidden) loadList(); }, failures > 2 ? 30000 : 10000); }
    document.addEventListener('visibilitychange', function () {
        if (!document.hidden) { loadList(); if (current) poll(current); }
    });
    window.addEventListener('pagehide', function () { clearInterval(pollTimer); clearInterval(listTimer); });

    loadList(); schedule(); setInterval(schedule, 30000);
})();
