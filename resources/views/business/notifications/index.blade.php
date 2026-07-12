@extends('layouts.business')
@section('title')
    Alerts Center
@endsection
@section('content')
    <style>
        body,
        .content-wrapper {
            background: #f8fafc !important;
            font-family: 'DM Sans', sans-serif;
        }

        .pt-page {
            padding: 1.5rem;
        }

        .pt-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .pt-sub {
            color: #64748b;
            font-size: .82rem;
            margin-top: 2px;
        }

        .card-pt {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 18px;
            padding: 1.25rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        .notif-item {
            padding: .9rem 1rem;
            border-radius: 12px;
            margin-bottom: .5rem;
            border: 1px solid #f1f5f9;
            transition: .2s;
            background: #fff;
        }

        .notif-item:hover {
            background: #f8fafc;
            border-color: #e2e8f0;
        }

        .notif-item.unread {
            border-left: 3px solid #6366f1;
            background: rgba(99, 102, 241, 0.03);
        }

        .notif-title {
            font-size: .85rem;
            font-weight: 600;
            color: #0f172a;
        }

        .notif-title.unread-text {
            font-weight: 700;
        }

        .notif-time {
            font-size: .72rem;
            color: #94a3b8;
            margin-top: 2px;
        }

        .notif-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            flex-shrink: 0;
        }

        .badge-unread {
            background: #e0e7ff;
            color: #4338ca;
            font-size: .65rem;
            font-weight: 700;
            padding: .2rem .55rem;
            border-radius: 6px;
        }
    </style>

    <div class="pt-page">
        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
            <div>
                <div class="pt-title"><i class="fas fa-bell me-2 text-primary"></i>Alerts Center</div>
                <div class="pt-sub">All your notifications in one place</div>
            </div>
            <div class="d-flex gap-2">
                @if ($unreadCount > 0)
                    <form method="POST" action="{{ route('notifications.markAllRead') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary"
                            style="border-radius:8px;font-size:.8rem;">
                            <i class="fas fa-check-double me-1"></i>Mark All Read
                        </button>
                    </form>
                @endif
                <form method="DELETE" action="{{ route('notifications.clearAll') }}"
                    onsubmit="event.preventDefault(); clearAll();">
                    <button type="button" onclick="clearAll()" class="btn btn-sm btn-outline-danger"
                        style="border-radius:8px;font-size:.8rem;">
                        <i class="fas fa-trash me-1"></i>Clear All
                    </button>
                </form>
            </div>
        </div>

        <div class="card-pt">
            @if ($notifications->count())
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span style="font-size:.82rem;color:#64748b;">
                        Showing {{ $notifications->firstItem() }}–{{ $notifications->lastItem() }} of
                        {{ $notifications->total() }} notifications
                        @if ($unreadCount > 0)
                            &nbsp;<span class="badge-unread">{{ $unreadCount }} unread</span>
                        @endif
                    </span>
                </div>

                @foreach ($notifications as $n)
                    <div class="notif-item {{ !$n->is_read ? 'unread' : '' }}" id="notif-{{ $n->id }}">
                        <div class="d-flex align-items-start gap-3">
                            {{-- Icon --}}
                            <div class="notif-icon"
                                style="background:{{ !$n->is_read ? '#e0e7ff' : '#f1f5f9' }};color:{{ !$n->is_read ? '#6366f1' : '#94a3b8' }};">
                                <i class="fas fa-bell"></i>
                            </div>

                            {{-- Content --}}
                            <div class="flex-grow-1">
                                <div class="notif-title {{ !$n->is_read ? 'unread-text' : '' }}">
                                    {{ $n->notification }}
                                </div>
                                <div class="notif-time">
                                    <i class="far fa-clock me-1"></i>{{ $n->created_at->diffForHumans() }}
                                    &nbsp;·&nbsp; {{ $n->created_at->format('M d, Y h:i A') }}
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="d-flex gap-2 align-items-center">
                                @if (!$n->is_read)
                                    <a href="{{ route('notifications.read', $n->id) }}" class="btn btn-sm btn-light border"
                                        style="font-size:.72rem;border-radius:7px;" title="Mark as read">
                                        <i class="fas fa-check"></i>
                                    </a>
                                @endif
                                <button onclick="removeNotif({{ $n->id }})"
                                    class="btn btn-sm btn-light border text-danger"
                                    style="font-size:.72rem;border-radius:7px;" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Pagination --}}
                <div class="mt-3 d-flex justify-content-center">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bell-slash fa-2x mb-3" style="color:#cbd5e1;"></i>
                    <div style="color:#94a3b8;font-size:.85rem;">No notifications yet.</div>
                </div>
            @endif
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

        function removeNotif(id) {
            fetch(`/notifications/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            }).then(r => r.json()).then(() => {
                document.getElementById('notif-' + id)?.remove();
            });
        }

        function clearAll() {
            Swal.fire({
                title: 'Clear all notifications?',
                text: 'This cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Yes, clear all'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch("{{ route('notifications.clearAll') }}", {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        }
                    }).then(() => location.reload());
                }
            });
        }
    </script>
@endsection
