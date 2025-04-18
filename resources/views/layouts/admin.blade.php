@extends('layouts.app')

@section('content')
<div class="h-screen flex overflow-hidden bg-gray-100">
    <!-- Sidebar -->
    <div class="hidden md:flex md:flex-shrink-0">
        <div class="flex flex-col w-64">
            <div class="flex flex-col h-0 flex-1">
                <div class="flex items-center justify-between h-16 flex-shrink-0 px-4 bg-pink-600">
                    <h2 class="text-2xl font-semibold text-white">Casa Amaryllis</h2>
                </div>
                <div class="flex-1 flex flex-col overflow-y-auto bg-pink-700">
                    <nav class="flex-1 px-2 py-4 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ Request::routeIs('admin.dashboard') ? 'bg-pink-800' : 'hover:bg-pink-600' }}">
                            <svg class="mr-3 h-6 w-6 text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>

                        <!-- Products Navigation -->
                        <a href="{{ route('admin.products.index') }}" class="text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ Request::routeIs('admin.products.*') ? 'bg-pink-800' : 'hover:bg-pink-600' }}">
                            <svg class="mr-3 h-6 w-6 text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Products
                        </a>

                        <!-- Add this after the Products navigation -->
                        <a href="{{ route('admin.reviews.index') }}" class="text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ Request::routeIs('admin.reviews.*') ? 'bg-pink-800' : 'hover:bg-pink-600' }}">
                            <svg class="mr-3 h-6 w-6 text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            Reviews
                        </a>

                        <!-- Categories Navigation -->
                        <a href="{{ route('admin.categories.index') }}" class="text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ Request::routeIs('admin.categories.*') ? 'bg-pink-800' : 'hover:bg-pink-600' }}">
                            <svg class="mr-3 h-6 w-6 text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Categories
                        </a>

                        <!-- Users Navigation -->
                        <a href="{{ route('admin.users.index') }}" class="text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ Request::routeIs('admin.users.*') ? 'bg-pink-800' : 'hover:bg-pink-600' }}">
                            <svg class="mr-3 h-6 w-6 text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Users
                        </a>

                        <!-- Charts Navigation -->
                        <a href="{{ route('admin.charts.index') }}" class="text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ Request::routeIs('admin.charts.*') ? 'bg-pink-800' : 'hover:bg-pink-600' }}">
                            <svg class="mr-3 h-6 w-6 text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Charts
                        </a>

                        <!-- Navigation items -->
                    </nav>

                    <!-- New Logout Button -->
                    <div class="p-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-pink-700 bg-white rounded-md hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 cursor-pointer transition-all duration-200 hover:shadow-lg group">
                                <i class="fas fa-sign-out-alt mr-2 group-hover:transform group-hover:-rotate-12 transition-transform"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <main class="flex-1 relative overflow-y-auto focus:outline-none">
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    @yield('admin-content')
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endpush

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>