@extends('layouts.app')

@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Notifications</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-dashboard">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-bell me-2"></i>Notifications</h6>
            <div>
                <button id="markAllBtn" class="btn btn-sm btn-outline-primary me-2">Mark all as read</button>
                <button id="deleteAllBtn" class="btn btn-sm btn-outline-danger">Delete all</button>
            </div>
        </div>
        <div class="card-body">
            @if($notifications && $notifications->count())
                <div class="list-group">
                    @foreach($notifications as $n)
                        <div class="list-group-item d-flex justify-content-between align-items-start {{ $n->read_at ? '' : 'list-group-item-warning' }}" data-id="{{ $n->id }}">
                            <a href="{{ $n->data['url'] ?? '#' }}" class="flex-grow-1 text-decoration-none text-dark">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">
                                        <i class="fas fa-{{ $n->data['icon'] ?? 'info-circle' }} me-2"></i>{{ $n->data['title'] ?? 'Notification' }}
                                        @if(!$n->read_at)
                                            <span class="badge bg-primary ms-2">New</span>
                                        @endif
                                    </div>
                                    <div class="small text-muted">{{ $n->created_at->diffForHumans() }}</div>
                                    <div>{{ $n->data['message'] ?? '' }}</div>
                                </div>
                            </a>
                            <div class="d-flex gap-2">
                                @if(!$n->read_at)
                                    <button class="btn btn-sm btn-outline-secondary mark-read">Mark as read</button>
                                @endif
                                <button class="btn btn-sm btn-outline-danger delete-notification" title="Delete notification">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-bell-slash fa-2x mb-2"></i>
                    <div>No notifications yet</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Mark all as read
    document.getElementById('markAllBtn')?.addEventListener('click', function(){
        fetch('{{ route('notifications.readAll') }}', {method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}})
            .then(r=>r.json()).then(()=>location.reload());
    });

    // Delete all notifications
    document.getElementById('deleteAllBtn')?.addEventListener('click', function(){
        if(confirm('Are you sure you want to delete all notifications? This action cannot be undone.')) {
            fetch('{{ route('notifications.destroyAll') }}', {
                method: 'DELETE', 
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}
            })
            .then(r=>r.json())
            .then(data => {
                alert(data.message || 'All notifications deleted successfully');
                location.reload();
            })
            .catch(err => alert('Failed to delete notifications'));
        }
    });

    // Mark individual notification as read
    document.querySelectorAll('.mark-read').forEach(btn=>{
        btn.addEventListener('click', function(e){
            e.preventDefault();
            const item = this.closest('[data-id]');
            const id = item.getAttribute('data-id');
            fetch(`/notifications/${id}/read`, {method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}})
                .then(r=>r.json()).then(()=>location.reload());
        });
    });

    // Delete individual notification
    document.querySelectorAll('.delete-notification').forEach(btn=>{
        btn.addEventListener('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            if(confirm('Are you sure you want to delete this notification?')) {
                const item = this.closest('[data-id]');
                const id = item.getAttribute('data-id');
                fetch(`/notifications/${id}`, {
                    method: 'DELETE', 
                    headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}
                })
                .then(r=>r.json())
                .then(data => {
                    item.remove();
                    // Check if there are no more notifications
                    if(document.querySelectorAll('[data-id]').length === 0) {
                        location.reload();
                    }
                })
                .catch(err => alert('Failed to delete notification'));
            }
        });
    });
</script>
@endpush
