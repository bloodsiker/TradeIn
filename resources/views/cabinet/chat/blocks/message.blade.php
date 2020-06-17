<div class="media">
    @if ($message->user->avatar)
        <div class="avatar avatar-sm avatar-online"><img src="{{ asset($message->user->avatar) }}" class="rounded-circle" alt=""></div>
    @else
        <div class="avatar avatar-sm avatar-online"><span class="avatar-initial rounded-circle">k</span></div>
    @endif

    <div class="media-body">
        <h6>{{ $message->user->fullName() }} <small>{{ $message->created_at->format('H:i:m') }}</small></h6>

        <p>{{ $message->message }}</p>
    </div>
</div>
