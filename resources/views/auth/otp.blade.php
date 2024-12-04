@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                @if(session('message'))
                    <div class="alert alert-{{ session('alert-type', 'success') }}">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="card-header text-center bg-white">
                    <h4>Verify OTP</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('verifyOtp') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" name="id" value="{{auth()->user()->id}}">
                            <label for="otp" class="form-label">Enter OTP</label>
                            <input type="text" class="form-control @error('otp') is-invalid @enderror" id="otp" name="otp" placeholder="Enter your OTP" required>
                            @error('otp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Verify</button>
                        </form>
                        <form method="POST" action="{{ route('resendOtp') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-link p-0">Resend OTP</button>
                        </form>
                        
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    document.getElementById('resendOtp').addEventListener('click', (e) => {
        e.preventDefault();
        console.log('Handle section data via JavaScript.');
    });
</script>