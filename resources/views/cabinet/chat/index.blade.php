@extends('cabinet.layouts.chat')

@section('title', 'Чат')

@section('content')

    <div class="chat-sidebar">

        <div class="chat-sidebar-body">

            <div class="pd-y-20 pd-x-10">
                <div class="d-flex align-items-center justify-content-between pd-x-10 mg-b-10">
                    <span class="tx-10 tx-uppercase tx-medium tx-color-03 tx-sans tx-spacing-1">Все группы</span>
                    <a href="#modalCreateChannel" class="chat-btn-add" data-toggle="modal"><span data-toggle="tooltip" title="Создать группу"><i data-feather="plus-circle"></i></span></a>
                </div>
                <nav id="allChannels" class="nav flex-column nav-chat mg-b-20">
                    @foreach($chatsGroup as $chatGroup)
                        <a href="{{ route('cabinet.chat.view', ['uniq_id' => $chatGroup->uniq_id]) }}" class="nav-link @if ($chatGroup->uniq_id == request()->route()->parameter('uniq_id')) active @endif"># {{ $chatGroup->name }}
                            @if($chatGroup->new_messages)
                                <span class="badge badge-danger">{{ $chatGroup->new_messages }}</span>
                            @endif
                        </a>
                    @endforeach
                </nav>
            </div>

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
                                <div class="avatar avatar-sm {{ $onlineStatus }}"><span class="avatar-initial rounded-circle">{{ mb_substr($directUser->name, 0, 1) }}</span></div>
                            @endif
                            <div class="media-body mg-l-10">
                                <h6 class="mg-b-0">{{ $directUser->fullName() }}</h6>
                                <small class="d-block tx-color-04">{{ $directUser->last_online ? \Carbon\Carbon::parse($directUser->last_online)->format('d.m.Y H:i') : null }}</small>
                            </div>
                            @if($chatPrivate->new_messages)
                                <span class="badge badge-danger">{{ $chatPrivate->new_messages }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <div class="chat-content">
        <div class="chat-content-header">
            <h6 id="channelTitle" class="mg-b-0"></h6>
            <div id="directTitle" class="d-none">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm avatar-online"><span class="avatar-initial rounded-circle"></span></div>
                    <h6 class="mg-l-10 mg-b-0"></h6>
                </div>
            </div>
        </div>

        <div class="chat-content-body">
            <div class="chat-group chat-group-main">
                <div class="alert alert-secondary" role="alert">
                    <h4 class="alert-heading">Добро пожаловать!</h4>
                    <p>Начните индивидуальный чат или создате группу</p>
                    <hr>
                    <p class="mb-0"></p>
                </div>
            </div>
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
    </script>
@endpush
