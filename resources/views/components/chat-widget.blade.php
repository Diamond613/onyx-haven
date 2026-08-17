{{-- ── Onyx Haven Guest Chat Widget ── --}}
<div id="chat-widget">

    {{-- Floating Button --}}
    <button id="chat-btn" aria-label="Chat with us"
        style="position:fixed; bottom:28px; right:28px; z-index:1000; width:56px; height:56px; border-radius:50%; background:var(--color-primary); border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 8px 32px rgba(0,0,0,0.4); transition:transform 0.2s ease;">
        <svg id="icon-chat" style="width:24px;height:24px;color:var(--color-base-100);position:absolute;transition:opacity 0.2s;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
        </svg>
        <svg id="icon-close-chat" style="width:24px;height:24px;color:var(--color-base-100);position:absolute;opacity:0;transition:opacity 0.2s;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/>
        </svg>
    </button>

    {{-- Chat Window --}}
    <div id="chat-window"
        style="position:fixed; bottom:96px; right:28px; z-index:999; width:340px; max-height:520px; background:var(--color-base-200); border:1px solid rgba(var(--color-base-content),0.1); display:flex; flex-direction:column; box-shadow:0 24px 64px rgba(0,0,0,0.5); transform:translateY(20px) scale(0.97); opacity:0; pointer-events:none; transition:transform 0.25s cubic-bezier(0.34,1.56,0.64,1), opacity 0.2s ease;">

        {{-- Header --}}
        <div style="padding:16px 18px; border-bottom:1px solid rgba(255,255,255,0.07); display:flex; align-items:center; gap:12px; flex-shrink:0;">
            <div style="width:36px;height:36px;border-radius:50%;background:var(--color-primary);display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:16px;font-weight:600;color:var(--color-base-100);flex-shrink:0;">O</div>
            <div>
                <p style="font-size:14px;font-weight:500;color:var(--color-base-content);">Onyx Concierge</p>
                <p style="font-size:10px;color:rgba(255,255,255,0.4);display:flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#4ade80;display:inline-block;"></span>
                    Always here to help
                </p>
            </div>
        </div>

        {{-- Messages --}}
        <div id="chat-messages" style="flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px;scroll-behavior:smooth;"></div>

        {{-- Input --}}
        <div style="border-top:1px solid rgba(255,255,255,0.07);padding:12px 14px;display:flex;gap:8px;align-items:center;flex-shrink:0;">
            <input type="text" id="chat-input" placeholder="Ask me anything..."
                autocomplete="off"
                style="flex:1;background:var(--color-base-300,#2d2d2a);border:1px solid rgba(255,255,255,0.08);color:var(--color-base-content);padding:9px 12px;font-family:var(--font-body);font-size:13px;outline:none;"/>
            <button id="chat-send"
                style="width:36px;height:36px;background:var(--color-primary);border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;flex-shrink:0;">
                <svg style="width:16px;height:16px;color:var(--color-base-100);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<style>
    #chat-btn { animation: chat-pulse 2.5s ease-out infinite; }
    @keyframes chat-pulse {
        0%   { box-shadow: 0 8px 32px rgba(0,0,0,0.4), 0 0 0 0 rgba(212,175,90,0.35); }
        70%  { box-shadow: 0 8px 32px rgba(0,0,0,0.4), 0 0 0 14px rgba(212,175,90,0); }
        100% { box-shadow: 0 8px 32px rgba(0,0,0,0.4), 0 0 0 0 rgba(212,175,90,0); }
    }
    #chat-btn:hover { transform: scale(1.08) !important; }
    #chat-messages::-webkit-scrollbar { width: 3px; }
    #chat-messages::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
    #chat-input:focus { border-color: rgba(212,175,90,0.4) !important; }
    .chat-bubble-bot {
        align-self: flex-start; max-width: 82%;
        background: var(--color-base-300, #2d2d2a);
        color: var(--color-base-content);
        padding: 10px 13px; font-size: 13px; line-height: 1.55;
        border-radius: 0 8px 8px 8px; white-space: pre-line;
    }
    .chat-bubble-user {
        align-self: flex-end; max-width: 82%;
        background: var(--color-primary);
        color: var(--color-base-100);
        padding: 10px 13px; font-size: 13px; line-height: 1.55;
        border-radius: 8px 8px 0 8px; font-weight: 500;
    }
    .chat-time { font-size: 9px; color: rgba(255,255,255,0.25); padding: 0 3px; margin-top: 2px; }
    .chat-msg-wrap { display: flex; flex-direction: column; }
    .chat-msg-wrap.user { align-items: flex-end; }
    .chat-qr-wrap { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px; }
    .chat-qr {
        font-size: 11px; padding: 5px 11px;
        border: 1px solid var(--color-primary);
        color: var(--color-primary); background: transparent;
        cursor: pointer; letter-spacing: 0.05em;
        transition: all 0.15s; border-radius: 2px;
        text-decoration: none; font-family: var(--font-body);
    }
    .chat-qr:hover { background: var(--color-primary); color: var(--color-base-100); }
    .chat-typing {
        display: flex; align-items: center; gap: 4px;
        padding: 12px 13px; background: var(--color-base-300, #2d2d2a);
        width: fit-content; border-radius: 0 8px 8px 8px;
    }
    .chat-typing span {
        width: 6px; height: 6px; border-radius: 50%;
        background: rgba(255,255,255,0.4);
        animation: chat-bounce 1.2s infinite;
    }
    .chat-typing span:nth-child(2) { animation-delay: 0.15s; }
    .chat-typing span:nth-child(3) { animation-delay: 0.3s; }
    @keyframes chat-bounce {
        0%,60%,100% { transform: translateY(0); }
        30% { transform: translateY(-5px); }
    }
    @media (max-width: 400px) {
        #chat-window { right: 12px; left: 12px; width: auto; bottom: 88px; }
        #chat-btn { bottom: 20px; right: 16px; }
    }
</style>

<script>
(function () {
    const btn    = document.getElementById('chat-btn');
    const win    = document.getElementById('chat-window');
    const msgs   = document.getElementById('chat-messages');
    const input  = document.getElementById('chat-input');
    const send   = document.getElementById('chat-send');
    const iconChat  = document.getElementById('icon-chat');
    const iconClose = document.getElementById('icon-close-chat');

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
        wrap.className = 'chat-msg-wrap' + (sender === 'user' ? ' user' : '');

        const bubble = document.createElement('div');
        bubble.className = sender === 'user' ? 'chat-bubble-user' : 'chat-bubble-bot';
        bubble.textContent = text;
        wrap.appendChild(bubble);

        const time = document.createElement('div');
        time.className = 'chat-time';
        time.textContent = getTime();
        wrap.appendChild(time);

        if (sender === 'bot' && quickReplies && quickReplies.length) {
            const qrWrap = document.createElement('div');
            qrWrap.className = 'chat-qr-wrap';
            quickReplies.forEach(function (label) {
                const matchedLink = links && links.find(function(l) { return l.label === label; });
                const el = document.createElement(matchedLink ? 'a' : 'button');
                el.className = 'chat-qr';
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

        msgs.appendChild(wrap);
        scrollBottom();
    }

    function showTyping() {
        const el = document.createElement('div');
        el.id = 'chat-typing-indicator';
        el.innerHTML = '<div class="chat-typing"><span></span><span></span><span></span></div>';
        msgs.appendChild(el);
        scrollBottom();
    }

    function removeTyping() {
        const el = document.getElementById('chat-typing-indicator');
        if (el) el.remove();
    }

    function sendMessage(text) {
        if (!text.trim()) return;
        addMessage(text, 'user');
        input.value = '';
        showTyping();

        const csrfToken = document.querySelector('meta[name="csrf-token"]');

        fetch('/api/chat', {
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
                    "Hello! Welcome to Onyx Haven. 🏨\nI'm your digital concierge — here to help you find the perfect room, understand our booking process, or simply navigate the site.\n\nWhat can I help you with today?",
                    'bot',
                    ['Show me the rooms', 'How do I book?', 'What is Onyx Haven?']
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