@extends('layouts.backend.master')
@section('title')
    Roles
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Roles</h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="btn-group mt-2 mb-2 pull-right">
                        <button onclick="window.location.href='{{ route('roles.create') }}'" class="btn btn-primary">Buat
                            Roles</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Guard</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->guard_name }}</td>
                                        <td>
                                            @can('role-detail')
                                                <a class="btn btn-info" href="{{ route('roles.show', $role->id) }}">Show</a>
                                            @endcan
                                            @can('role-edit')
                                                <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">Edit</a>
                                            @endcan
                                            @can('role-delete')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
