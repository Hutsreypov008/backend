@extends('admin.layout')

@section('title', 'Users')
@section('page-title', 'Users')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="card-title mb-0">Users</h5>
    </div>

    <div class="content-card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        @php
                            $isAdmin = (bool) $user->is_admin;
                        @endphp
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $isAdmin ? 'bg-primary' : 'bg-secondary' }}">
                                    {{ $isAdmin ? 'Admin' : 'Customer' }}
                                </span>
                            </td>
                            <td class="text-muted">{{ optional($user->created_at)->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection