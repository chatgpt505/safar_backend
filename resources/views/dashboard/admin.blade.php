@extends('adminlte::page')

@section('title', 'Admin Panel - Safar Backend')

@section('content_header')
    <h1>Admin Panel</h1>
@endsection

@section('content')
<div class="space-y-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Statistics</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Users</span>
                            <span class="info-box-number">{{ $stats['total_users'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-user-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Active</span>
                            <span class="info-box-number">{{ $stats['active_users'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-user-times"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Inactive</span>
                            <span class="info-box-number">{{ $stats['inactive_users'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-purple"><i class="fas fa-user-shield"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Admins</span>
                            <span class="info-box-number">{{ $stats['admin_users'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Users</h3>
            <div class="card-tools">
                <a href="{{ route('dashboard.users') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-users mr-1"></i> Manage Users
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $recent)
                        <tr>
                            <td>{{ $recent->name }}</td>
                            <td>{{ $recent->email }}</td>
                            <td><span class="badge badge-secondary">{{ ucfirst($recent->role) }}</span></td>
                            <td>
                                @if($recent->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $recent->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


