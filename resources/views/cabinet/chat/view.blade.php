@extends('cabinet.layouts.chat')

@section('title', 'Чат')

@section('content')

    <div class="chat-sidebar">


        <div class="chat-sidebar-body">

            <div class="flex-fill pd-y-20 pd-x-10">
                <div class="d-flex align-items-center justify-content-between pd-x-10 mg-b-10">
                    <span class="tx-10 tx-uppercase tx-medium tx-color-03 tx-sans tx-spacing-1">Все группы</span>
                    <a href="#modalCreateChannel" class="chat-btn-add" data-toggle="modal"><span data-toggle="tooltip" title="Создать группу"><i data-feather="plus-circle"></i></span></a>
                </div>
                <nav id="allChannels" class="nav flex-column nav-chat mg-b-20">
                    @foreach($chatsGroup as $chatGroup)
                        <a href="{{ route('cabinet.chat.view', ['uniq_id' => $chatGroup->uniq_id]) }}" class="nav-link @if ($chatGroup->uniq_id == request()->route()->parameter('uniq_id')) active @endif"># {{ $chatGroup->name }}</a>
                    @endforeach
                    <a href="#products" class="nav-link"># products <span class="badge badge-danger">2</span></a>
                </nav>
            </div>

            <div class="flex-fill pd-y-20 pd-x-10 bd-t">
                <p class="tx-10 tx-uppercase tx-medium tx-color-03 tx-sans tx-spacing-1 pd-l-10 mg-b-10">Direct Messages</p>
                <div id="chatDirectMsg" class="chat-msg-list">
                    <a href="#" class="media">
                        <div class="avatar avatar-sm avatar-online"><span class="avatar-initial bg-dark rounded-circle">b</span></div>
                        <div class="media-body mg-l-10">
                            <h6 class="mg-b-0">dfbot</h6>
                            <small class="d-block tx-color-04">5 mins ago</small>
                        </div><!-- media-body -->
                    </a><!-- media -->
                    <a href="#" class="media">
                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/350" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-10">
                            <h6 class="mg-b-0">situmay</h6>
                            <small class="d-block tx-color-04">1 hour ago</small>
                        </div><!-- media-body -->
                        <span class="badge badge-danger">3</span>
                    </a><!-- media -->
                    <a href="#" class="media">
                        <div class="avatar avatar-sm avatar-offline"><img src="../https://via.placeholder.com/600" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-10">
                            <h6 class="mg-b-0">acantones</h6>
                            <small class="d-block tx-color-04">2 hours ago</small>
                        </div><!-- media-body -->
                    </a><!-- media -->
                    <a href="#" class="media">
                        <div class="avatar avatar-sm avatar-offline"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-10">
                            <h6 class="mg-b-0">rlabares</h6>
                            <small class="d-block tx-color-04">2 hours ago</small>
                        </div><!-- media-body -->
                    </a><!-- media -->
                    <a href="#" class="media">
                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-10">
                            <h6 class="mg-b-0">h.owen</h6>
                            <small class="d-block tx-color-04">3 hours ago</small>
                        </div><!-- media-body -->
                    </a><!-- media -->
                    <a href="#" class="media">
                        <div class="avatar avatar-sm avatar-online"><span class="avatar-initial bg-primary rounded-circle">k</span></div>
                        <div class="media-body mg-l-10">
                            <h6 class="mg-b-0">k.billie</h6>
                            <small class="d-block tx-color-04">3 hours ago</small>
                        </div><!-- media-body -->
                    </a><!-- media -->
                    <a href="#" class="media">
                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-10">
                            <h6 class="mg-b-0">m.audrey</h6>
                            <small class="d-block tx-color-04">4 hours ago</small>
                        </div><!-- media-body -->
                    </a><!-- media -->
                    <a href="#" class="media">
                        <div class="avatar avatar-sm avatar-online"><span class="avatar-initial bg-indigo rounded-circle">m</span></div>
                        <div class="media-body mg-l-10">
                            <h6 class="mg-b-0">macasindil</h6>
                            <small class="d-block tx-color-04">4 hours ago</small>
                        </div><!-- media-body -->
                    </a><!-- media -->
                    <a href="#" class="media">
                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/350" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-10">
                            <h6 class="mg-b-0">e.ocaba</h6>
                            <small class="d-block tx-color-04">4 hours ago</small>
                        </div><!-- media-body -->
                    </a><!-- media -->
                    <a href="#" class="media">
                        <div class="avatar avatar-sm avatar-online"><span class="avatar-initial bg-info rounded-circle">k</span></div>
                        <div class="media-body mg-l-10">
                            <h6 class="mg-b-0">avendula</h6>
                            <small class="d-block tx-color-04">5 hours ago</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="chat-content">
        <div class="chat-content-header">
            <h6 id="channelTitle" class="mg-b-0"># {{ $chat->name }}</h6>
            <div id="directTitle" class="d-none">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm avatar-online"><span class="avatar-initial rounded-circle">b</span></div>
                    <h6 class="mg-l-10 mg-b-0">@dfbot</h6>
                </div>
            </div>
            <div class="d-flex">
                <nav id="channelNav">
                    <a href="#modalInvitePeople" data-toggle="modal"><span data-toggle="tooltip" title="Invite People"><i data-feather="user-plus"></i></span></a>
                    <a id="showMemberList" href="" data-toggle="tooltip" title="Member list" class="d-flex align-items-center">
                        <i data-feather="users"></i>
                        <span class="tx-medium mg-l-5">25</span>
                    </a>
                </nav>
                <nav id="directNav" class="d-none">
                    <a href="" data-toggle="tooltip" title="Call User"><i data-feather="phone"></i></a>
                    <a href="" data-toggle="tooltip" title="User Details"><i data-feather="info"></i></a>
                    <a href="" data-toggle="tooltip" title="Add to Favorites"><i data-feather="star"></i></a>
                    <a href="" data-toggle="tooltip" title="Flag User"><i data-feather="flag"></i></a>
                </nav>
                <div class="search-form mg-l-15 d-none d-sm-flex">
                    <input type="search" class="form-control" placeholder="Search">
                    <button class="btn" type="button"><i data-feather="search"></i></button>
                </div>
            </div>
        </div><!-- chat-content-header -->

        <div class="chat-content-body" id="container-messages">
            <div class="chat-group">
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
                <div class="container-message d-none"></div>
            </div>
        </div>

        <div class="chat-sidebar-right">
            <div class="pd-y-20 pd-x-10">
                <div class="tx-10 tx-uppercase tx-medium tx-color-03 tx-sans tx-spacing-1 pd-l-10">Участники группы</div>
                <div class="chat-member-list">
                    @foreach($chat->users as $chatUser)
                        <a href="#" class="media">
                            <div class="avatar avatar-sm avatar-online">
                                @if ($chatUser->avatar)
                                    <img src="{{ asset($chatUser->avatar) }}" class="rounded-circle" alt="">
                                @else
                                    <span class="avatar-initial rounded-circle">b</span>
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

                    <h6 class="tx-18 tx-sm-20 mg-b-5">Пригласить пользователя</h6>
                    <p class="tx-color-03 mg-b-20">Share this link to your friend to grant access and join to this channel</p>
                    <form action="{{ route('cabinet.chat.invite_user') }}" method="post" novalidate>
                        @csrf
                        <div class="input-group mg-b-5">
                            <input type="hidden" name="chat_id" value="{{ $chat->id }}">
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
                    $('.container-message').before(response);
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
    </script>
@endpush
