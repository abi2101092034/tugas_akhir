@extends('landing.master_layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-body px-4 py-4">
                        <h1>Verify Email</h1>
                        <p class="text-muted">Please check your email for a verification link. If you did not receive the
                            email, you can request
                            another one below.</p>
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Resend Verification Email</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
