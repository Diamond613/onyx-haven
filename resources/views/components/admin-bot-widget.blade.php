{{-- ── Onyx Haven Admin Bot Widget ── --}}
@php $adminFirstName = auth()->user() ? explode(' ', trim(auth()->user()->name))[0] : ''; @endphp
<div id="admin-bot-widget">

    {{-- Floating Button --}}
    <button id="admin-bot-btn" aria-label="Admin assistant"
        style="position:fixed; bottom:28px; right:28px; z-index:1000; width:56px; height:56px; border-radius:50%; background:var(--color-primary); border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 8px 32px rgba(0,0,0,0.4); transition:transform 0.2s ease;">
        <svg id="admin-bot-icon-chat" style="width:22px;height:22px;color:var(--color-base-100);position:absolute;transition:opacity 0.2s;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M12 2a5 5 0 015 5v1h1a2 2 0 012 2v6a2 2 0 01-2 2h-1v1a2 2 0 01-2 2H9a2 2 0 01-2-2v-1H6a2 2 0 01-2-2v-6a2 2 0 012-2h1V7a5 5 0 015-5z"/>
            <circle cx="9" cy="13" r="1" fill="currentColor" stroke="none"/>
            <circle cx="15" cy="13" r="1" fill="currentColor" stroke="none"/>
        </svg>
        <svg id="admin-bot-icon-close" style="width:22px;height:22px;color:var(--color-base-100);position:absolute;opacity:0;transition:opacity 0.2s;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/>
        </svg>
    </button>

    {{-- Chat Window --}}
    <div id="admin-bot-window"
        style="position:fixed; bottom:96px; right:28px; z-index:999; width:360px; max-height:540px; background:var(--color-base-200); border:1px solid rgba(255,255,255,0.1); display:flex; flex-direction:column; box-shadow:0 24px 64px rgba(0,0,0,0.5); transform:translateY(20px) scale(0.97); opacity:0; pointer-events:none; transition:transform 0.25s cubic-bezier(0.34,1.56,0.64,1), opacity 0.2s ease;">

        {{-- Header --}}
        <div style="padding:16px 18px; border-bottom:1px solid rgba(255,255,255,0.07); display:flex; align-items:center; gap:12px; flex-shrink:0;">
            <div style="width:36px;height:36px;border-radius:50%;background:var(--color-primary);display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:16px;font-weight:600;color:var(--color-base-100);flex-shrink:0;">A</div>
            <div>
                <p style="font-size:14px;font-weight:500;color:var(--color-base-content);">Admin Assistant</p>
                <p style="font-size:10px;color:rgba(255,255,255,0.4);">Say "help" to see what I can do</p>
            </div>
        </div>

        {{-- Messages --}}
        <div id="admin-bot-messages" style="flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px;scroll-behavior:smooth;"></div>

        {{-- Input --}}
        <div style="border-top:1px solid rgba(255,255,255,0.07);padding:12px 14px;display:flex;gap:8px;align-items:center;flex-shrink:0;">
            <input type="text" id="admin-bot-input" placeholder="e.g. create a room"
                autocomplete="off"
                style="flex:1;background:var(--color-base-300,#2d2d2a);border:1px solid rgba(255,255,255,0.08);color:var(--color-base-content);padding:9px 12px;font-family:var(--font-body);font-size:13px;outline:none;"/>
            <button id="admin-bot-send"
                style="width:36px;height:36px;background:var(--color-primary);border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;flex-shrink:0;">
                <svg style="width:16px;height:16px;color:var(--color-base-100);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<style>
    #admin-bot-btn:hover { transform: scale(1.08) !important; }
    #admin-bot-messages::-webkit-scrollbar { width: 3px; }
    #admin-bot-messages::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
    #admin-bot-input:focus { border-color: rgba(212,175,90,0.4) !important; }
    .abot-bubble-bot {
        align-self: flex-start; max-width: 86%;
        background: var(--color-base-300, #2d2d2a);
        color: var(--color-base-content);
        padding: 10px 13px; font-size: 13px; line-height: 1.55;
        border-radius: 0 8px 8px 8px; white-space: pre-line;
    }
    .abot-bubble-user {
        align-self: flex-end; max-width: 86%;
        background: var(--color-primary);
        color: var(--color-base-100);
        padding: 10px 13px; font-size: 13px; line-height: 1.55;
        border-radius: 8px 8px 0 8px; font-weight: 500;
    }
    .abot-time { font-size: 9px; color: rgba(255,255,255,0.25); padding: 0 3px; margin-top: 2px; }
    .abot-msg-wrap { display: flex; flex-direction: column; }
    .abot-msg-wrap.user { align-items: flex-end; }
    .abot-qr-wrap { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px; }
    .abot-qr {
        font-size: 11px; padding: 5px 11px;
        border: 1px solid var(--color-primary);
        color: var(--color-primary); background: transparent;
        cursor: pointer; letter-spacing: 0.05em;
        transition: all 0.15s; border-radius: 2px;
        text-decoration: none; font-family: var(--font-body);
    }
    .abot-qr:hover { background: var(--color-primary); color: var(--color-base-100); }
    .abot-typing {
        display: flex; align-items: center; gap: 4px;
        padding: 12px 13px; background: var(--color-base-300, #2d2d2a);
        width: fit-content; border-radius: 0 8px 8px 8px;
    }
    .abot-typing span {
        width: 6px; height: 6px; border-radius: 50%;
        background: rgba(255,255,255,0.4);
        animation: abot-bounce 1.2s infinite;
    }
    .abot-typing span:nth-child(2) { animation-delay: 0.15s; }
    .abot-typing span:nth-child(3) { animation-delay: 0.3s; }
    @keyframes abot-bounce {
        0%,60%,100% { transform: translateY(0); }
        30% { transform: translateY(-5px); }
    }
    @media (max-width: 767px) {
        #admin-bot-btn { bottom: calc(88px + env(safe-area-inset-bottom, 0px)) !important; right: 16px !important; }
        #admin-bot-window { right: 12px !important; left: 12px !important; width: auto !important; bottom: calc(152px + env(safe-area-inset-bottom, 0px)) !important; }
    }
    @media (max-width: 400px) {
        #admin-bot-window { bottom: calc(152px + env(safe-area-inset-bottom, 0px)) !important; }
    }
</style>

<script>
(function () {
    const btn    = document.getElementById('admin-bot-btn');
    const win    = document.getElementById('admin-bot-window');
    const msgs   = document.getElementById('admin-bot-messages');
    const input  = document.getElementById('admin-bot-input');
    const send   = document.getElementById('admin-bot-send');
    const iconChat  = document.getElementById('admin-bot-icon-chat');
    const iconClose = document.getElementById('admin-bot-icon-close');

    let isOpen  = false;
    let greeted = false;

    function getTime() {
        return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    function scrollBottom() {
        msgs.scrollTop = msgs.scrollHeight;
    }

    function addMessage(text, sender, quickReplies, links) {
        const wrap = document.createElement('div');
        wrap.className = 'abot-msg-wrap' + (sender === 'user' ? ' user' : '');

        const bubble = document.createElement('div');
        bubble.className = sender === 'user' ? 'abot-bubble-user' : 'abot-bubble-bot';
        bubble.textContent = text;
        wrap.appendChild(bubble);

        const time = document.createElement('div');
        time.className = 'abot-time';
        time.textContent = getTime();
        wrap.appendChild(time);

        if (sender === 'bot' && quickReplies && quickReplies.length) {
            const qrWrap = document.createElement('div');
            qrWrap.className = 'abot-qr-wrap';
            quickReplies.forEach(function (label) {
                const matchedLink = links && links.find(function(l) { return l.label === label; });
                const el = document.createElement(matchedLink ? 'a' : 'button');
                el.className = 'abot-qr';
                el.textContent = label;
                if (matchedLink) {
                    el.href = matchedLink.url;
                } else {
                    el.addEventListener('click', function () { sendMessage(label); });
                }
                qrWrap.appendChild(el);
            });
            wrap.appendChild(qrWrap);
        }

        if (sender === 'bot' && links && links.length) {
            links.forEach(function (l) {
                if (quickReplies && quickReplies.includes(l.label)) return;
                const a = document.createElement('a');
                a.href = l.url;
                a.className = 'abot-qr';
                a.textContent = l.label;
                a.style.marginTop = '6px';
                a.style.display = 'inline-block';
                wrap.appendChild(a);
            });
        }

        msgs.appendChild(wrap);
        scrollBottom();
    }

    function showTyping() {
        const el = document.createElement('div');
        el.id = 'admin-bot-typing-indicator';
        el.innerHTML = '<div class="abot-typing"><span></span><span></span><span></span></div>';
        msgs.appendChild(el);
        scrollBottom();
    }

    function removeTyping() {
        const el = document.getElementById('admin-bot-typing-indicator');
        if (el) el.remove();
    }

    function sendMessage(text) {
        if (!text.trim()) return;
        addMessage(text, 'user');
        input.value = '';
        showTyping();

        const csrfToken = document.querySelector('meta[name="csrf-token"]');

        fetch('/admin/bot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken ? csrfToken.content : '',
            },
            body: JSON.stringify({ message: text }),
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            removeTyping();
            addMessage(data.answer, 'bot', data.replies, data.links);
            if (data.refreshStats) {
                window.dispatchEvent(new CustomEvent('onyx-admin-stats-changed'));
            }
        })
        .catch(function() {
            removeTyping();
            addMessage("Sorry, something went wrong. Please try again.", 'bot');
        });
    }

    btn.addEventListener('click', function () {
        isOpen = !isOpen;
        iconChat.style.opacity  = isOpen ? '0' : '1';
        iconClose.style.opacity = isOpen ? '1' : '0';
        win.style.transform  = isOpen ? 'translateY(0) scale(1)'    : 'translateY(20px) scale(0.97)';
        win.style.opacity    = isOpen ? '1' : '0';
        win.style.pointerEvents = isOpen ? 'all' : 'none';

        if (isOpen && !greeted) {
            greeted = true;
            setTimeout(function () {
                addMessage(
                    "Hi{{ $adminFirstName ? ', '.$adminFirstName : '' }}! I'm your admin assistant. I can create/delete rooms, update prices, and manage bookings — just tell me what you need. I'll always confirm before changing anything.",
                    'bot',
                    ['Create a room', 'List rooms', 'List bookings', 'Stats']
                );
            }, 300);
        }

        if (isOpen) setTimeout(function() { input.focus(); }, 350);
    });

    send.addEventListener('click', function () { sendMessage(input.value); });
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') sendMessage(input.value);
    });
})();
</script>