@extends('layouts.backend.master')
@section('title')
    Detail User
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Detail Users</h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail User</h4>
                    <div class="mb-3">
                        <label>Name</label>
                        <p>{{ $user->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <p>{{ $user->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label>Akses</label>
                        @if (!empty($user->roles))
                            @foreach ($user->roles as $v)
                                @switch($v->name)
                                    @case('Administrator')
                                        <span class="badge bg-info">{{ $v->name }}</span>
                                    @break

                                    @case('Admin')
                                        <span class="badge bg-info">{{ $v->name }}</span>
                                    @break

                                    @case('User')
                                        <span class="badge bg-success">{{ $v->name }}</span>
                                    @break

                                    @default
                                @endswitch
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
