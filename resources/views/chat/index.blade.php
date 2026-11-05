@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/umsc-chat.css') }}">

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="chat card" id="chat"
        data-conversations="{{ route('chat.conversations') }}"
        data-user-search="{{ route('chat.users.search') }}"
        data-start-direct="{{ route('chat.start.direct') }}"
        data-create-group="{{ route('chat.create.group') }}"
        data-base="{{ url('chat') }}"
        data-user-id="{{ optional(\App\Services\AccessControl::user())->id }}">

        {{-- ===== Conversation list ===== --}}
        <aside class="chat-list" aria-label="Conversations">
            <div class="chat-list__head">
                <h1 class="chat-title">Messages</h1>
                @can_permission('chat.create')
                <button type="button" class="chat-iconbtn chat-iconbtn--solid" data-bs-toggle="modal"
                    data-bs-target="#newChatModal" aria-label="Start a new chat">
                    <i class="bx bx-edit-alt" aria-hidden="true"></i>
                </button>
                @endcan_permission
            </div>

            <div class="chat-tabs" role="group" aria-label="Filter conversations">
                <button type="button" class="chat-tab is-on" data-type="" aria-pressed="true">All</button>
                <button type="button" class="chat-tab" data-type="direct" aria-pressed="false">Direct</button>
                <button type="button" class="chat-tab" data-type="group" aria-pressed="false">Groups</button>
            </div>

            <div class="chat-search">
                <label for="chatListFilter" class="u-sr">Search conversations</label>
                <i class="bx bx-search" aria-hidden="true"></i>
                <input type="search" id="chatListFilter" placeholder="Search conversations" autocomplete="off">
            </div>

            <p class="chat-banner" id="chatBanner" role="status" hidden></p>
            <ul class="chat-items" id="conversationList" aria-live="polite"></ul>
        </aside>

        {{-- ===== Conversation ===== --}}
        <section class="chat-pane" aria-label="Conversation">
            <div class="chat-blank" id="chatWindowEmpty">
                <i class="bx bx-conversation" aria-hidden="true"></i>
                <h2>Select a conversation</h2>
                <p>Pick a chat from the list, or start a new one with a colleague.</p>
            </div>

            <div class="chat-live" id="chatWindowActive" hidden>
                <header class="chat-head">
                    <button type="button" class="chat-iconbtn chat-back" id="chatMobileBack" aria-label="Back to conversations">
                        <i class="bx bx-arrow-back" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="chat-who" id="chatHeaderInfo" aria-label="View details">
                        <span class="chat-avatar" id="chatHeaderAvatar" aria-hidden="true"></span>
                        <span class="chat-who__text">
                            <strong id="chatHeaderName" dir="auto">&nbsp;</strong>
                            <small id="chatHeaderSubtitle">&nbsp;</small>
                        </span>
                    </button>
                </header>

                <div class="chat-scroll" id="chatMessages" role="log" aria-live="polite" aria-relevant="additions" tabindex="0" aria-label="Messages"></div>

                <form id="chatSendForm" class="chat-compose" novalidate>
                    @csrf
                    <label class="chat-iconbtn chat-attach" title="Attach a file">
                        <i class="bx bx-paperclip" aria-hidden="true"></i>
                        <span class="u-sr">Attach a file</span>
                        <input type="file" name="attachment" id="chatAttachmentInput" hidden>
                    </label>
                    <label for="chatBodyInput" class="u-sr">Message</label>
                    <textarea id="chatBodyInput" dir="auto" rows="1" placeholder="Message" autocomplete="off"></textarea>
                    <button type="button" class="chat-iconbtn" id="chatMicBtn" aria-label="Record a voice note (hold, or press Enter to start)">
                        <i class="bx bx-microphone" aria-hidden="true"></i>
                    </button>
                    <button type="submit" class="chat-iconbtn chat-iconbtn--solid" id="chatSendBtn" aria-label="Send" disabled>
                        <i class="bx bx-send rtl-flip" aria-hidden="true"></i>
                    </button>
                </form>

                <div class="chat-file" id="chatAttachPreview" hidden>
                    <i class="bx bx-file" aria-hidden="true"></i><span></span>
                    <button type="button" id="chatAttachRemove" aria-label="Remove attachment"><i class="bx bx-x" aria-hidden="true"></i></button>
                </div>

                <div class="chat-rec" id="chatRecordingBar" hidden>
                    <button type="button" class="chat-iconbtn chat-iconbtn--bad" id="chatRecordingCancel" aria-label="Discard recording"><i class="bx bx-trash" aria-hidden="true"></i></button>
                    <div class="chat-rec__info"><span class="chat-rec__dot" aria-hidden="true"></span><span id="chatRecordingTimer">0:00</span>
                        <small>Slide to cancel</small></div>
                    <button type="button" class="chat-iconbtn chat-iconbtn--solid" id="chatRecordingSend" aria-label="Send voice note"><i class="bx bx-send rtl-flip" aria-hidden="true"></i></button>
                </div>
            </div>
        </section>
    </div>
</div>

{{-- ===== New chat ===== --}}
@can_permission('chat.create')
<div class="modal fade" id="newChatModal" tabindex="-1" aria-labelledby="newChatTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="newChatTitle">New chat</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="chat-tabs chat-tabs--wide" id="newChatModeTabs" role="group" aria-label="Chat type">
                    <button type="button" class="chat-tab is-on" data-mode="direct" aria-pressed="true">Direct message</button>
                    <button type="button" class="chat-tab" data-mode="group" aria-pressed="false">Group chat</button>
                </div>
                <div id="groupNameWrap" class="mb-3" hidden>
                    <label for="groupNameInput" class="form-label">Group name</label>
                    <input type="text" id="groupNameInput" class="form-control" maxlength="80">
                </div>
                <div class="chat-search chat-search--flush">
                    <label for="userSearchInput" class="u-sr">Search staff</label>
                    <i class="bx bx-search" aria-hidden="true"></i>
                    <input type="search" id="userSearchInput" placeholder="Search staff by name or username" autocomplete="off">
                </div>
                <ul id="userSearchResults" class="chat-people" aria-live="polite"></ul>
            </div>
            <div class="modal-footer" id="groupCreateFooter" hidden>
                <button type="button" class="ui-btn" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="ui-btn ui-btn--primary" id="createGroupBtn">Create group</button>
            </div>
        </div>
    </div>
</div>
@endcan_permission

{{-- ===== Details ===== --}}
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="profileModalTitle">Details</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="chat-avatar chat-avatar--lg mx-auto" id="profileAvatar" aria-hidden="true"></div>
                <h3 class="chat-pname" id="profileName">&nbsp;</h3>
                <p class="chat-psub" id="profileSubtitle">&nbsp;</p>
                <dl class="chat-pdl" id="profileDetails"></dl>
                <div class="chat-members" id="profileMembers" hidden>
                    <h4>Members</h4>
                    <ul class="chat-people" id="profileMembersList"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/umsc-chat.js') }}" defer></script>
@endsection
