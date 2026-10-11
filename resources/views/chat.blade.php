@extends('layouts.chat')

@section('links')
<style>
    /* ===== Reset the global * rule from style.css that breaks flexbox ===== */
    .chat-page *,
    .chat-page *::before,
    .chat-page *::after {
        position: static !important;
        height: auto !important;
        box-sizing: border-box !important;
    }
    .chat-page {
        position: relative !important;
        height: auto !important;
    }

    /* ===== Chat Container ===== */
    .chat-page {
        position: relative !important;
        min-height: calc(100vh - 140px) !important;
    }

    .chat-wrapper {
        display: flex !important;
        flex-direction: row !important;
        height: calc(100vh - 140px) !important;
        width: calc(100% - 30px) !important;
        background: #fff !important;
        border-radius: 10px !important;
        overflow: hidden !important;
        box-shadow: 0 2px 16px rgba(0,0,0,0.10) !important;
        border: 1px solid #ddd !important;
        margin: 15px !important;
        max-width: none !important;
    }

    /* ===== Sidebar ===== */
    .chat-sidebar {
        width: 360px !important;
        min-width: 300px !important;
        max-width: 360px !important;
        display: flex !important;
        flex-direction: column !important;
        border-right: 1px solid #ddd !important;
        background: #fff !important;
        height: 100% !important;
        overflow: hidden !important;
    }
    .chat-sb-head {
        padding: 14px 18px !important;
        background: #075e54 !important;
        color: #fff !important;
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between !important;
        min-height: 56px !important;
        flex-shrink: 0 !important;
    }
    .chat-sb-head h5 {
        margin: 0 !important;
        padding: 0 !important;
        font-weight: 700 !important;
        font-size: 17px !important;
        color: #fff !important;
    }
    .chat-sb-badge {
        background: rgba(255,255,255,0.2) !important;
        padding: 3px 10px !important;
        border-radius: 12px !important;
        font-size: 11px !important;
        color: #fff !important;
    }
    .chat-sb-badge i {
        color: #25d366 !important;
        font-size: 8px !important;
        margin-right: 4px !important;
    }
    .chat-sb-search {
        padding: 8px 12px !important;
        background: #f6f6f6 !important;
        border-bottom: 1px solid #e0e0e0 !important;
        flex-shrink: 0 !important;
    }
    .chat-sb-search input {
        width: 100% !important;
        border: none !important;
        background: #fff !important;
        border-radius: 20px !important;
        padding: 9px 16px !important;
        font-size: 13px !important;
        outline: none !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06) !important;
        color: #333 !important;
    }
    .chat-sb-contacts {
        flex: 1 1 0% !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        height: 0 !important; /* trick to make flex scroll work */
    }
    .chat-ct {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        padding: 12px 16px !important;
        cursor: pointer !important;
        border-bottom: 1px solid #f0f0f0 !important;
        transition: background 0.15s !important;
        background: #fff !important;
    }
    .chat-ct:hover {
        background: #f5f5f5 !important;
    }
    .chat-ct.active {
        background: #ebebeb !important;
    }
    .chat-ct-avatar {
        width: 46px !important;
        height: 46px !important;
        min-width: 46px !important;
        min-height: 46px !important;
        border-radius: 50% !important;
        background: linear-gradient(135deg, #25d366, #128c7e) !important;
        color: #fff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 20px !important;
        font-weight: 700 !important;
        margin-right: 14px !important;
        flex-shrink: 0 !important;
    }
    .chat-ct-info {
        flex: 1 1 0% !important;
        min-width: 0 !important;
        overflow: hidden !important;
    }
    .chat-ct-unread {
        background: #075e54 !important;
        color: #fff !important;
        font-size: 11px !important;
        line-height: 1 !important;
        padding: 4px 8px !important;
        border-radius: 999px !important;
        margin-left: 10px !important;
        white-space: nowrap !important;
        flex-shrink: 0 !important;
    }
    .chat-ct-name {
        font-weight: 600 !important;
        font-size: 15px !important;
        color: #111 !important;
        margin: 0 0 2px 0 !important;
        padding: 0 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    .chat-ct-sub {
        font-size: 13px !important;
        color: #999 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* ===== Main Chat Area ===== */
    .chat-main {
        flex: 1 1 0% !important;
        display: flex !important;
        flex-direction: column !important;
        background: #e5ddd5 !important;
        min-width: 0 !important;
        height: 100% !important;
        overflow: hidden !important;
    }

    /* Chat Header */
    .chat-hd {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        padding: 10px 16px !important;
        background: #ededed !important;
        border-bottom: 1px solid #ccc !important;
        min-height: 56px !important;
        flex-shrink: 0 !important;
    }
    .chat-hd-avatar {
        width: 40px !important;
        height: 40px !important;
        min-width: 40px !important;
        min-height: 40px !important;
        border-radius: 50% !important;
        background: linear-gradient(135deg, #25d366, #128c7e) !important;
        color: #fff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 18px !important;
        font-weight: 700 !important;
        margin-right: 12px !important;
        flex-shrink: 0 !important;
    }
    .chat-hd-name {
        font-weight: 700 !important;
        font-size: 15px !important;
        color: #111 !important;
        margin: 0 !important;
    }
    .chat-hd-status {
        font-size: 12px !important;
        color: #999 !important;
        margin: 0 !important;
    }

    /* Messages */
    .chat-msgs {
        flex: 1 1 0% !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        padding: 16px 50px !important;
        display: none;
        flex-direction: column !important;
        height: 0 !important;
    }
    .chat-msgs.visible {
        display: flex !important;
    }
    .chat-row {
        display: flex !important;
        flex-direction: row !important;
        margin-bottom: 5px !important;
    }
    .chat-row-sent {
        justify-content: flex-end !important;
    }
    .chat-row-recv {
        justify-content: flex-start !important;
    }
    .chat-bubble {
        max-width: 65% !important;
        padding: 7px 12px !important;
        border-radius: 8px !important;
        font-size: 14px !important;
        line-height: 1.45 !important;
        word-wrap: break-word !important;
        box-shadow: 0 1px 1px rgba(0,0,0,0.10) !important;
    }
    .chat-row-sent .chat-bubble {
        background: #dcf8c6 !important;
        border-top-right-radius: 0 !important;
    }
    .chat-row-recv .chat-bubble {
        background: #fff !important;
        border-top-left-radius: 0 !important;
    }
    .chat-bubble img {
        max-width: 100% !important;
        max-height: 220px !important;
        border-radius: 6px !important;
        display: block !important;
        margin-bottom: 4px !important;
        height: auto !important;
    }
    .chat-meta {
        font-size: 11px !important;
        color: #999 !important;
        text-align: right !important;
        margin-top: 3px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 4px !important;
    }

    /* Input bar */
    .chat-input-bar {
        display: none;
        flex-direction: row !important;
        align-items: center !important;
        padding: 8px 14px !important;
        background: #ededed !important;
        border-top: 1px solid #ccc !important;
        gap: 6px !important;
        flex-shrink: 0 !important;
    }
    .chat-input-bar.visible {
        display: flex !important;
    }
    .chat-input-bar input[type="text"] {
        flex: 1 1 0% !important;
        border: none !important;
        border-radius: 20px !important;
        padding: 10px 18px !important;
        font-size: 14px !important;
        outline: none !important;
        background: #fff !important;
        color: #333 !important;
        height: auto !important;
    }
    .chat-ibtn {
        width: 38px !important;
        height: 38px !important;
        min-width: 38px !important;
        min-height: 38px !important;
        border: none !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        font-size: 16px !important;
        transition: background 0.15s !important;
        padding: 0 !important;
        background: transparent !important;
        color: #919191 !important;
    }
    .chat-ibtn:hover {
        color: #555 !important;
    }
    .chat-ibtn-send {
        background: #075e54 !important;
        color: #fff !important;
    }
    .chat-ibtn-send:hover {
        background: #064e46 !important;
        color: #fff !important;
    }

    /* Attachment preview strip */
    .chat-att-preview {
        display: none;
        flex-direction: row !important;
        align-items: center !important;
        padding: 5px 14px !important;
        background: #f0f0f0 !important;
        border-top: 1px solid #ddd !important;
        gap: 8px !important;
        font-size: 13px !important;
        color: #555 !important;
        flex-shrink: 0 !important;
    }
    .chat-att-preview.visible {
        display: flex !important;
    }
    .chat-att-fname {
        flex: 1 1 0% !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }
    .chat-att-rm {
        cursor: pointer !important;
        color: #999 !important;
    }
    .chat-att-rm:hover {
        color: #e74c3c !important;
    }

    /* Loading */
    .chat-loader {
        text-align: center !important;
        padding: 25px !important;
        color: #999 !important;
        font-size: 14px !important;
    }

    /* Mobile back button */
    .chat-back-btn {
        display: none !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .chat-sidebar {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
        }
        .chat-main {
            display: none !important;
        }
        .chat-wrapper.open .chat-sidebar {
            display: none !important;
        }
        .chat-wrapper.open .chat-main {
            display: flex !important;
        }
        .chat-msgs {
            padding: 10px 14px !important;
        }
        .chat-bubble {
            max-width: 85% !important;
        }
        .chat-back-btn {
            display: flex !important;
        }
    }
</style>
@endsection

@section('content')
<div class="chat-page">
    <div class="chat-wrapper" id="chatWrapper">

        {{-- ===== Sidebar ===== --}}
        <div class="chat-sidebar">
            <div class="chat-sb-head">
                <h5><i class="fas fa-comments"></i> Chats</h5>
                <span class="chat-sb-badge"><i class="fas fa-circle"></i> Online</span>
            </div>
            <div class="chat-sb-search">
                <input type="text" placeholder="Search contacts..." id="searchContacts">
            </div>
            <div class="chat-sb-contacts" id="contactList">
                <div class="chat-loader" id="contactsLoader">
                    <i class="fas fa-spinner fa-spin"></i> Loading contacts...
                </div>
            </div>
        </div>

        {{-- ===== Main ===== --}}
        <div class="chat-main">

            {{-- Header --}}
            <div class="chat-hd" id="chatHeader">
                <button class="chat-ibtn chat-back-btn" id="backBtn"><i class="fas fa-arrow-left"></i></button>
                <div class="chat-hd-avatar" id="chatAvatar">U</div>
                <div>
                    <div class="chat-hd-name" id="chatName">User</div>
                    <div class="chat-hd-status" id="chatStatus">Active</div>
                </div>
            </div>

            {{-- Messages --}}
            <div class="chat-msgs" id="chatMessages"></div>

            {{-- Attachment preview --}}
            <div class="chat-att-preview" id="attPreview">
                <i class="fas fa-file-alt"></i>
                <span class="chat-att-fname" id="attName">file.png</span>
                <span class="chat-att-rm" id="attRemove"><i class="fas fa-times"></i></span>
            </div>

            {{-- Input --}}
            <div class="chat-input-bar" id="chatInputBar">
                <button type="button" class="chat-ibtn" id="btnLoc" title="Share Location"><i class="fas fa-map-marker-alt"></i></button>
                <label class="chat-ibtn" style="margin:0 !important;" title="Attach File">
                    <i class="fas fa-paperclip"></i>
                    <input type="file" style="display:none !important;" id="attInput" accept="image/*,.pdf,.doc,.docx,.zip">
                </label>
                <input type="text" placeholder="Type a message..." id="msgInput" autocomplete="off">
                <button type="button" class="chat-ibtn chat-ibtn-send" id="btnSend"><i class="fas fa-paper-plane"></i></button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var isVendor = {{ Auth::guard('vendor')->check() ? 'true' : 'false' }};
    var currentUserId = {{ Auth::guard('vendor')->check() ? Auth::guard('vendor')->id() : (Auth::check() ? Auth::id() : 'null') }};
    if (currentUserId === null || currentUserId === 'null') return;

    var activeId = null, activeType = null, allContacts = [];

    var $ = function(id){ return document.getElementById(id); };
    var contactList = $('contactList');
    var chatMessages = $('chatMessages');
    var msgInput = $('msgInput');
    var attInput = $('attInput');
    var attPreview = $('attPreview');
    var attName = $('attName');

    function setError(text) {
        contactList.innerHTML = '<div class="chat-loader">'+text+'</div>';
    }

    var initialContact = @json($initialContact ?? null);

    fetch('/chat/contacts')
        .then(function(r){ return r.ok ? r.json() : Promise.reject(); })
        .then(function(data){
            $('contactsLoader').style.display = 'none';
            allContacts = Array.isArray(data) ? data : [];

            if (initialContact && initialContact.id) {
                var found = allContacts.find(function(c){ return c.id === initialContact.id; });
                if (!found) {
                    allContacts.unshift({
                        id: initialContact.id,
                        name: initialContact.name,
                        unread_count: 0,
                        last_message_at: null
                    });
                }
            }

            drawContacts(allContacts);

            if (initialContact && initialContact.id) {
                openChat(initialContact.id, initialContact.name, initialContact.type);
            }
        })
        .catch(function(){
            if (initialContact && initialContact.id) {
                $('contactsLoader').style.display = 'none';
                allContacts = [{
                    id: initialContact.id,
                    name: initialContact.name,
                    unread_count: 0,
                    last_message_at: null
                }];
                drawContacts(allContacts);
                openChat(initialContact.id, initialContact.name, initialContact.type);
            } else {
                setError('Unable to load contacts.');
            }
        });

    $('searchContacts').addEventListener('input', function(){
        var q = this.value.toLowerCase();
        drawContacts(allContacts.filter(function(c){ return c.name.toLowerCase().indexOf(q) !== -1; }));
    });

    function drawContacts(list) {
        list = list.slice();
        list.sort(function(a, b) {
            if (!a.last_message_at && !b.last_message_at) return 0;
            if (!a.last_message_at) return 1;
            if (!b.last_message_at) return -1;
            return new Date(b.last_message_at) - new Date(a.last_message_at);
        });
        var old = contactList.querySelectorAll('.chat-ct');
        for(var i=0;i<old.length;i++) old[i].remove();
        if (!list.length) {
            setError('No contacts found.');
            return;
        }
        list.forEach(function(c){
            var d = document.createElement('div');
            d.className = 'chat-ct' + (c.id === activeId ? ' active' : '');
            d.innerHTML = '<div class="chat-ct-avatar">'+c.name.charAt(0).toUpperCase()+'</div>'
                +'<div class="chat-ct-info"><div class="chat-ct-name">'+c.name+'</div><div class="chat-ct-sub">Tap to chat</div></div>'
                + (c.unread_count ? '<span class="chat-ct-unread">'+c.unread_count+'</span>' : '');
            d.onclick = function(){
                var items = contactList.querySelectorAll('.chat-ct');
                for(var j=0;j<items.length;j++) items[j].classList.remove('active');
                d.classList.add('active');
                openChat(c.id, c.name, isVendor ? 'user' : 'vendor');
            };
            contactList.appendChild(d);
        });
    }

    function openChat(id, name, type) {
        activeId = id; activeType = type;
        $('chatHeader').classList.add('visible');
        chatMessages.classList.add('visible');
        $('chatInputBar').classList.add('visible');
        $('chatWrapper').classList.add('open');
        $('chatName').textContent = name;
        $('chatAvatar').textContent = name.charAt(0).toUpperCase();
        $('chatStatus').textContent = 'Active';

        allContacts = allContacts.map(function(c){
            if (c.id === id) c.unread_count = 0;
            return c;
        });
        drawContacts(allContacts);

        loadMessages();
    }

    function loadMessages() {
        if (!activeId) return;
        chatMessages.innerHTML = '<div class="chat-loader"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';
        fetch('/chat/messages/'+activeType+'/'+activeId)
            .then(function(r){ return r.ok ? r.json() : Promise.reject(); })
            .then(function(msgs){
                chatMessages.innerHTML = '';
                msgs.forEach(function(m){ addMsg(m); });
                chatMessages.scrollTop = chatMessages.scrollHeight;
                markSeen(activeId);
            })
            .catch(function(){
                chatMessages.innerHTML = '<div class="chat-loader">Unable to load messages.</div>';
            });
    }

    $('backBtn').addEventListener('click', function(){ $('chatWrapper').classList.remove('open'); });

    function addMsg(m) {
        var mine = m.sender_id == currentUserId && (isVendor ? m.sender_type.indexOf('Vendor')!==-1 : m.sender_type.indexOf('User')!==-1);
        var row = document.createElement('div');
        row.className = 'chat-row ' + (mine ? 'chat-row-sent' : 'chat-row-recv');
        row.dataset.messageId = m.id;
        var html = '';
        if (m.attachment) {
            if (m.attachment_type==='image') html='<img src="'+m.attachment_url+'">';
            else if (m.attachment_type==='location') html='<a href="'+m.attachment_url+'" target="_blank" style="color:#075e54;"><i class="fas fa-map-marker-alt" style="color:#e74c3c;"></i> View Location</a>';
            else html='<a href="'+m.attachment_url+'" target="_blank" style="color:#075e54;"><i class="fas fa-file-download"></i> Download File</a>';
        }
        if (m.message) html += '<div>'+m.message+'</div>';
        var t = new Date(m.created_at).toLocaleTimeString([],{hour:'2-digit',minute:'2-digit'});
        var seen = mine ? (m.is_seen ? '<i class="seen-icon fas fa-check-double" style="color:#34b7f1;"></i>' : '<i class="seen-icon fas fa-check" style="color:#999;"></i>') : '';
        row.innerHTML = '<div class="chat-bubble">'+html+'<div class="chat-meta">'+t+' '+seen+'</div></div>';
        chatMessages.appendChild(row);
    }

    function updateSeenStatus(messageIds) {
        if (!messageIds || !messageIds.length) return;
        messageIds.forEach(function(id) {
            var row = chatMessages.querySelector('[data-message-id="'+id+'"]');
            if (!row) return;
            var icon = row.querySelector('.seen-icon');
            if (icon) {
                icon.className = 'seen-icon fas fa-check-double';
                icon.style.color = '#34b7f1';
            }
        });
    }

    $('btnSend').addEventListener('click', doSend);
    msgInput.addEventListener('keydown', function(e){ if(e.key==='Enter'){e.preventDefault();doSend();} });

    function doSend() {
        var msg = msgInput.value.trim(), file = attInput.files[0];
        if(!msg && !file) return;
        if(!activeId) return;
        msgInput.value = '';
        var fd = new FormData();
        fd.append('receiver_id', activeId);
        fd.append('receiver_type', activeType);
        if(msg) fd.append('message', msg);
        if(file) fd.append('attachment', file);
        $('btnSend').disabled = true;
        fetch('/chat/send',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},body:fd})
            .then(function(r){ return r.ok ? r.json() : Promise.reject(); })
            .then(function(d){
                addMsg(d);
                chatMessages.scrollTop = chatMessages.scrollHeight;
                clearAtt();
                var contact = allContacts.find(function(c){ return c.id === activeId; });
                if (contact) {
                    contact.last_message_at = new Date().toISOString();
                }
                drawContacts(allContacts);
                $('btnSend').disabled=false;
            }).catch(function(){ $('btnSend').disabled=false; });
    }

    attInput.addEventListener('change', function(){
        if(this.files[0]){
            attName.textContent = this.files[0].name;
            attPreview.classList.add('visible');
        }
    });

    $('attRemove').addEventListener('click', clearAtt);
    function clearAtt(){
        try {
            attInput.value = '';
        } catch (e) {
            var newInput = attInput.cloneNode(true);
            attInput.parentNode.replaceChild(newInput, attInput);
            attInput = newInput;
            attInput.addEventListener('change', function(){
                if(this.files[0]){
                    attName.textContent = this.files[0].name;
                    attPreview.classList.add('visible');
                }
            });
        }
        attName.textContent = '';
        attPreview.classList.remove('visible');
    }

    function updateTyping(isTypingNow) {
        if (!activeId || !window.Echo) return;
        var targetType = isVendor ? 'user' : 'vendor';
        window.Echo.private('chat.' + targetType + '.' + activeId).whisper('typing', {
            sender_id: currentUserId,
            typing: isTypingNow,
        });
    }

    var typingTimer;
    msgInput.addEventListener('input', function() {
        if (!activeId) return;
        updateTyping(true);
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() {
            updateTyping(false);
        }, 1500);
    });
    msgInput.addEventListener('blur', function() {
        clearTimeout(typingTimer);
        updateTyping(false);
    });

    $('btnLoc').addEventListener('click', function(){
        if(!activeId)return;
        if(!navigator.geolocation){alert('Geolocation not supported');return;}
        this.innerHTML='<i class="fas fa-spinner fa-spin"></i>';
        var self=this;
        navigator.geolocation.getCurrentPosition(function(pos){
            var link='https://www.google.com/maps/search/?api=1&query='+pos.coords.latitude+','+pos.coords.longitude;
            var fd=new FormData();
            fd.append('receiver_id',activeId);fd.append('receiver_type',activeType);fd.append('location',link);
            fetch('/chat/send',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},body:fd})
                .then(function(r){ return r.ok ? r.json() : Promise.reject(); })
                .then(function(d){addMsg(d);chatMessages.scrollTop = chatMessages.scrollHeight;self.innerHTML='<i class="fas fa-map-marker-alt"></i>';})
                .catch(function(){self.innerHTML='<i class="fas fa-map-marker-alt"></i>';});
        },function(){alert('Unable to get location');self.innerHTML='<i class="fas fa-map-marker-alt"></i>';});
    });

    function markSeen(sid){
        fetch('/chat/seen',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'},body:JSON.stringify({sender_id:sid, sender_type: activeType})});
    }

    if(window.Echo){
        var myType=isVendor?'vendor':'user';
        window.Echo.private('chat.'+myType+'.'+currentUserId)
            .listen('MessageSent',function(e){
                if(e.message.sender_id==activeId){
                    addMsg(e.message);
                    chatMessages.scrollTop=chatMessages.scrollHeight;
                    markSeen(activeId);
                } else {
                    var existing = allContacts.find(function(c){ return c.id === e.message.sender_id; });
                    if (existing) {
                        existing.unread_count = (existing.unread_count || 0) + 1;
                        existing.last_message_at = e.message.created_at;
                    } else {
                        allContacts.unshift({
                            id: e.message.sender_id,
                            name: e.message.sender_name || 'Unknown',
                            unread_count: 1,
                            last_message_at: e.message.created_at
                        });
                    }
                    drawContacts(allContacts);
                }
            })
            .listen('MessageSeen', function(e) {
                updateSeenStatus(e.message_ids);
            })
            .listenForWhisper('typing', function(e){
                if (!activeId || e.sender_id !== activeId) return;
                $('chatStatus').textContent = e.typing ? 'Typing...' : 'Active';
                if (e.typing) {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(function(){ $('chatStatus').textContent = 'Active'; }, 1800);
                }
            });
    }

    // Polling fallback every 6 seconds to ensure messages sync smoothly even if WebSockets disconnect
    setInterval(function() {
        if (!activeId || !activeType) return;
        fetch('/chat/messages/' + activeType + '/' + activeId)
            .then(function(r) { return r.ok ? r.json() : null; })
            .then(function(msgs) {
                if (!msgs || !Array.isArray(msgs)) return;
                var currentRows = chatMessages.querySelectorAll('.chat-row');
                if (msgs.length > currentRows.length) {
                    chatMessages.innerHTML = '';
                    msgs.forEach(function(m) { addMsg(m); });
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                    markSeen(activeId);
                }
            })
            .catch(function() {});
    }, 6000);
});
</script>
@endpush
