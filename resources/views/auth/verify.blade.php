@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-8">
            <h2 class="text-2xl font-bold text-center mb-6">Verify Your Email Address</h2>

            @if (session('resent'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <p>A fresh verification link has been sent to your email address.</p>
                </div>
            @endif

            <p class="text-gray-600 mb-4">
                Before proceeding, please check your email for a verification link.
                If you did not receive the email,
            </p>

            <form method="POST" action="{{ route('verification.resend') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                    Click here to request another
                </button>
            </form>
        </div>
    </div>
</div>
@endsection