@extends('layouts.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff&size=128" 
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
    </div>
</div>
@endsection