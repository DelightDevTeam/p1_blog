@extends('layouts.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body text-center">
                    <img src="{{ asset('profile_picture/' . $user->profile_picture) }}" 
                    class="rounded-circle mb-3" alt="Avatar">
                    <h2 class="card-title mb-1">{{ $user->name }}</h2>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    <hr>
                     <div class="row justify-content-center">
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush text-start">
                                <li class="list-group-item"><strong>User ID:</strong> {{ $user->id }}</li>
                                <li class="list-group-item"><strong>Email Verified:</strong>
                                 {{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : 'Not Verified' }}</li>
                                <li class="list-group-item"><strong>Member Since:</strong> {{ $user->created_at->format('M d, Y') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Update Profile</h5>
                    <!-- profile picture -->
                    <form action="{{ route('updateProfile') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="profile_picture">Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection