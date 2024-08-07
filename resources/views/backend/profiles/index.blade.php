@extends('layouts.backend.master')
@section('title')
    Profile
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Profile</h4>
        </div>
    </div>
</div>  
<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="text-center mt-2 mb-3">
                    <h4 class="mt-2 mb-0">{{ auth()->user()->name }}</h4>
                    <h6 class="text-muted fw-normal mt-2 mb-0">{{ auth()->user()->email }}</h6>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <p>{{ auth()->user()->email }}</p>
                </div>
                <div class="mb-3">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" placeholder="New Password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection