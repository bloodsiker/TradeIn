<div class="media message_chat" data-id="{{ $message->id }}">
    @php
        $onlineStatus = $message->user->statusOnline() ? 'avatar-online' : 'avatar-offline' ;
    @endphp
    @if ($message->user->avatar)
        <div class="avatar avatar-sm {{ $onlineStatus }}"><img src="{{ asset($message->user->avatar) }}" class="rounded-circle" alt=""></div>
    @else
        <div class="avatar avatar-sm {{ $onlineStatus }}"><span class="avatar-initial rounded-circle">{{ substr($message->user->name, 0, 1) }}</span></div>
    @endif

    <div class="media-body">
        <h6>{{ $message->user->fullName() }} <small>{{ $message->created_at->format('H:i:m') }}</small></h6>

        <p>{{ $message->message }}</p>
    </div>
</div>
