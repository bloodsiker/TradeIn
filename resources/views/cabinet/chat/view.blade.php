@extends('cabinet.layouts.chat')

@section('title', 'Чат')

@section('content')

    <div class="chat-sidebar">


        <div class="chat-sidebar-body">

{{--            <div class="flex-fill pd-y-20 pd-x-10">--}}
            <div class="pd-y-20 pd-x-10">
                <div class="d-flex align-items-center justify-content-between pd-x-10 mg-b-10">
                    <span class="tx-10 tx-uppercase tx-medium tx-color-03 tx-sans tx-spacing-1">Все группы</span>
                    <a href="#modalCreateChannel" class="chat-btn-add" data-toggle="modal"><span data-toggle="tooltip" title="Создать группу"><i data-feather="plus-circle"></i></span></a>
                </div>
                <nav id="allChannels" class="nav flex-column nav-chat mg-b-20">
                    @foreach($chatsGroup as $chatGroup)
                        <a href="{{ route('cabinet.chat.view', ['uniq_id' => $chatGroup->uniq_id]) }}" class="nav-link @if ($chatGroup->uniq_id == request()->route()->parameter('uniq_id')) active @endif"># {{ $chatGroup->name }}</a>
                    @endforeach
                </nav>
            </div>

{{--            <div class="flex-fill pd-y-20 pd-x-10 bd-t">--}}
            <div class="pd-y-20 pd-x-10 bd-t">
                <div class="d-flex align-items-center justify-content-between pd-x-10 mg-b-10">
                    <span class="tx-10 tx-uppercase tx-medium tx-color-03 tx-sans tx-spacing-1">Личные сообщения</span>
                    <a href="#modalDirectUser" class="chat-btn-add" data-toggle="modal"><span data-toggle="tooltip" title="Написать пользователю"><i data-feather="plus-circle"></i></span></a>
                </div>
                <div id="chatDirectMsg" class="chat-msg-list">
                    @foreach($chatsPrivate as $chatPrivate)
                        <a href="{{ route('cabinet.chat.view', ['uniq_id' => $chatPrivate->uniq_id]) }}" class="media @if ($chatPrivate->uniq_id == request()->route()->parameter('uniq_id')) active @endif">
                            @php
                                $directUser = null;
                                $chatPrivate->users->map(function ($item, $key) use (&$directUser) {
                                    if ($item->id !== Auth::id()) {
                                        $directUser = $item;
                                    }

                                    return $item;
                                });
                            @endphp

                            @php
                                $onlineStatus = $directUser->statusOnline() ? 'avatar-online' : 'avatar-offline' ;
                            @endphp

                            @if ($directUser && $directUser->avatar)
                                <div class="avatar avatar-sm {{ $onlineStatus }}"><img src="{{ asset($directUser->avatar) }}" class="rounded-circle" alt=""></div>
                            @else
                                <div class="avatar avatar-sm {{ $onlineStatus }}"><span class="avatar-initial rounded-circle">{{ substr($directUser->name, 0, 1) }}</span></div>
                            @endif
                            <div class="media-body mg-l-10">
                                <h6 class="mg-b-0">{{ $directUser->fullName() }}</h6>
                                <small class="d-block tx-color-04">{{ $directUser->last_online ? \Carbon\Carbon::parse($directUser->last_online)->format('d.m.Y H:i') : null }}</small>
                            </div>
                            <span class="badge badge-danger">3</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <div class="chat-content">
        <div class="chat-content-header">
            @if($chat->type_chat == \App\Models\Chat::TYPE_PRIVATE)
                @php
                    $directUser = null;
                    $chat->users->map(function ($item, $key) use (&$directUser) {
                        if ($item->id !== Auth::id()) {
                            $directUser = $item;
                        }

                        return $item;
                    });
                @endphp

                <h6 id="channelTitle" class="mg-b-0">@ {{ $directUser->fullName() }}</h6>

                <div id="directTitle" class="d-none">
                    <div class="d-flex align-items-center">
                        @php
                            $onlineStatus = $directUser->statusOnline() ? 'avatar-online' : 'avatar-offline' ;
                        @endphp
                        @if ($directUser && $directUser->avatar)
                            <div class="avatar avatar-sm {{ $onlineStatus }}"><img src="{{ asset($directUser->avatar) }}" class="rounded-circle" alt=""></div>
                        @else
                            <div class="avatar avatar-sm {{ $onlineStatus }}"><span class="avatar-initial rounded-circle">{{ substr($directUser->name, 0, 1) }}</span></div>
                        @endif
                        <h6 class="mg-l-10 mg-b-0">{{ $directUser->fullName() }}</h6>
                    </div>
                </div>
            @else
                <h6 id="channelTitle" class="mg-b-0"># {{ $chat->name }}</h6>
            @endif
            <div class="d-flex">
                @if($chat->type_chat == \App\Models\Chat::TYPE_GROUP)
                    <nav id="channelNav">
                        <a href="#modalInvitePeople" data-toggle="modal"><span data-toggle="tooltip" title="Добавить пользователя в группу"><i data-feather="user-plus"></i></span></a>
                        <a id="showMemberList" href="" data-toggle="tooltip" title="Список участников" class="d-flex align-items-center">
                            <i data-feather="users"></i>
                            <span class="tx-medium mg-l-5">25</span>
                        </a>
                    </nav>
                @endif
{{--                <nav id="directNav" class="d-none">--}}
{{--                    <a href="" data-toggle="tooltip" title="Call User"><i data-feather="phone"></i></a>--}}
{{--                    <a href="" data-toggle="tooltip" title="User Details"><i data-feather="info"></i></a>--}}
{{--                    <a href="" data-toggle="tooltip" title="Add to Favorites"><i data-feather="star"></i></a>--}}
{{--                    <a href="" data-toggle="tooltip" title="Flag User"><i data-feather="flag"></i></a>--}}
{{--                </nav>--}}
                <div class="search-form mg-l-15 d-none d-sm-flex">
                    <input type="search" class="form-control" placeholder="Search">
                    <button class="btn" type="button"><i data-feather="search"></i></button>
                </div>
            </div>
        </div><!-- chat-content-header -->

        <div class="chat-content-body" id="container-messages">
            <div class="chat-group" id="chat_load" data-id="{{ $chat->id }}">
                @php
                    $messageDate = null;
                @endphp
                @foreach($messages as $message)
                    @if ($messageDate !== $message->created_at->format('Y-m-d'))
                        <div class="chat-group-divider">{{ Date::parse($message->created_at)->format('j F Y г.') }}</div>
                    @endif

                    @php
                        $messageDate = $message->created_at->format('Y-m-d');
                    @endphp

                    @include('cabinet.chat.blocks.message')
                @endforeach
                <div class="message_chat d-none"></div>
            </div>
        </div>

        <div class="chat-sidebar-right">
            <div class="pd-y-20 pd-x-10">
                <div class="tx-10 tx-uppercase tx-medium tx-color-03 tx-sans tx-spacing-1 pd-l-10">Участники группы</div>
                <div class="chat-member-list">
                    @foreach($chat->users as $chatUser)
                        <a href="#" class="media">
                            @php
                                $onlineStatus = $chatUser->statusOnline() ? 'avatar-online' : 'avatar-offline' ;
                            @endphp
                            <div class="avatar avatar-sm {{ $onlineStatus }}">
                                @if ($chatUser->avatar)
                                    <img src="{{ asset($chatUser->avatar) }}" class="rounded-circle" alt="">
                                @else
                                    <span class="avatar-initial rounded-circle">{{ substr($chatUser->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="media-body mg-l-10">
                                <h6 class="mg-b-0">{{ $chatUser->fullName() }}</h6>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="chat-content-footer">
            <input type="text" name="message" id="message" class="form-control align-self-center bd-0" placeholder="Сообщение">
            <button id="send_message">Отправить</button>
        </div>
    </div>

@endsection

@push('modals')

    <div class="modal fade effect-scale" id="modalCreateChannel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <form action="{{ route('cabinet.chat.group_add') }}" method="post">
                    @csrf
                    <div class="modal-body pd-20">
                        <button type="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i data-feather="x" class="wd-20"></i></span>
                        </button>
                        <h6 class="tx-uppercase tx-spacing-1 tx-semibold mg-b-20">Создать группу</h6>
                        <input type="text" class="form-control" placeholder="Название" name="name" autocomplete="off">
                    </div>
                    <div class="modal-footer pd-x-20 pd-b-20 pd-t-0 bd-t-0">
                        <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Закрыть</button>
                        <button class="btn btn-primary tx-13">Создать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade effect-scale" id="modalInvitePeople" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body pd-20 pd-sm-30">
                    <button type="button" class="close pos-absolute t-20 r-20" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x" class="wd-20"></i></span>
                    </button>

                    <h6 class="tx-18 tx-sm-20 mg-b-15">Пригласить пользователя</h6>
                    <form action="{{ route('cabinet.chat.invite_user') }}" method="post" novalidate>
                        @csrf
                        <div class="input-group mg-b-5">
                            <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                            <input type="hidden" name="type_chat" value="{{ \App\Models\Chat::TYPE_GROUP }}">
                            <select class="custom-select" name="user_id" required>
                                @foreach($users as $inviteUser)
                                    <option value="{{ $inviteUser->id }}">{{ $inviteUser->fullName() }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-light" id="button-addon2">Пригласить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade effect-scale" id="modalDirectUser" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body pd-20 pd-sm-30">
                    <button type="button" class="close pos-absolute t-20 r-20" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x" class="wd-20"></i></span>
                    </button>

                    <h6 class="tx-18 tx-sm-20 mg-b-15">Начать диалог с пользователем</h6>
                    <form action="{{ route('cabinet.chat.invite_user') }}" method="post" novalidate>
                        @csrf
                        <div class="input-group mg-b-5">
                            <input type="hidden" name="type_chat" value="{{ \App\Models\Chat::TYPE_PRIVATE }}">
                            <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                            <select class="custom-select" name="user_id" required>
                                @foreach($users as $inviteUser)
                                    <option value="{{ $inviteUser->id }}">{{ $inviteUser->fullName() }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-light" id="">Начать диалог</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endpush

@push('scripts')
    <script>
        $(function(){
            'use strict'

            if(window.matchMedia('(min-width: 768px)').matches) {
                $('body').addClass('show-sidebar-right');
                $('#showMemberList').addClass('active');
            }
        })

        function scrollToBottom() {
            var chatResult = $('#container-messages');
            chatResult.scrollTop(chatResult.prop('scrollHeight'));
        }

        $(function(){
            scrollToBottom();
        });

        function sendMessage() {
            const id = '{{ $chat->id }}',
                message = $('#message').val();

            $.ajax({
                url: '{{ route('cabinet.chat.view', ['uniq_id' => $chat->uniq_id]) }}',
                type: "POST",
                data: { message: message, id: id },
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#message').val('')
                    $('.message_chat').before(response);
                    scrollToBottom();
                }
            });
        }

        $('#message').on('keypress',function(e) {
            if (e.which == 13) {
                sendMessage();
            }
        });


        $('#send_message').on('click', function (e) {
            e.preventDefault();
            sendMessage();
        })

        function getMessages() {
            const chat_id = '{{ $chat->id }}',
                  last_id = $('#chat_load .media').last().data('id');

            $.ajax({
                url: '{{ route('cabinet.chat.load') }}',
                type: "POST",
                data: { chat_id: chat_id, last_id: last_id },
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#chat_load .message_chat').last().before(response);
                    scrollToBottom();
                }
            });
        }

        setInterval(() => getMessages(), 10000);

    </script>
@endpush
