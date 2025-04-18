@extends('layouts.admin')

@section('admin-content')
<div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
    <div class="border-b border-gray-200 pb-5">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Order Analytics</h3>
        <p class="mt-2 max-w-4xl text-sm text-gray-500">View detailed analytics about your orders and revenue.</p>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Orders by Day Chart -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h4 class="text-base font-medium text-gray-900 mb-4">Orders by Day (Last 30 Days)</h4>
                {!! $ordersChart->renderHtml() !!}
            </div>
        </div>

        <!-- Orders by Status Chart -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h4 class="text-base font-medium text-gray-900 mb-4">Orders by Status</h4>
                {!! $orderStatusChart->renderHtml() !!}
            </div>
        </div>

        <!-- Monthly Revenue Chart -->
        <div class="bg-white overflow-hidden shadow rounded-lg lg:col-span-2">
            <div class="p-5">
                <h4 class="text-base font-medium text-gray-900 mb-4">Monthly Revenue</h4>
                {!! $revenueChart->renderHtml() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

<!-- Chart Rendering Scripts -->
{!! $ordersChart->renderJs() !!}
{!! $orderStatusChart->renderJs() !!}
{!! $revenueChart->renderJs() !!}
@endsection