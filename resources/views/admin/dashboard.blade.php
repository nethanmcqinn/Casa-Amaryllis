@extends('layouts.admin')
<?php
// dd($orders[0])
?>
@section('admin-content')
<div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
    <div class="border-b border-gray-200 pb-5">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Dashboard Overview</h3>
        <p class="mt-2 text-sm text-gray-500">
            <a href="{{ route('admin.charts.index') }}" class="text-pink-600 hover:text-pink-800 font-medium">
                View detailed analytics <span aria-hidden="true">→</span>
            </a>
        </p>
    </div>
    
    <!-- Stats Grid -->
    <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Orders Stats -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-pink-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Orders</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_orders'] ?? 0 }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Stats -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">${{ number_format($stats['total_revenue'] ?? 0, 2) }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products & Customers Stats -->
        <!-- Similar structure as above for Products and Customers cards -->
    </div>
    
    <!-- Orders Management -->
    <div class="mt-8">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Order Management</h2>
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span id="status-badge-{{ $order->id }}" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $order->status === 'shipped' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                              <form action="{{ route("order.status",$order->id) }}" method="get" class="form-control">
                                <select id="status-select-{{ $order->id }}" name="status"
                                        class="text-sm rounded-md border-gray-300 focus:ring-pink-500 focus:border-pink-500" onchange="this.form.submit()">
                                    <option value="">Change Status</option>
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                              </form>
                                <button onclick="viewOrderDetails({{ $order->id }})" 
                                        class="text-pink-600 hover:text-pink-900">
                                    View Details
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No orders found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
    
    <!-- Orders Chart -->
    @if(isset($ordersChart))
    <div class="mt-8">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Recent Orders Trend</h2>
        <div class="bg-white overflow-hidden shadow rounded-lg p-5">
            {!! $ordersChart->renderHtml() !!}
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
@if(isset($ordersChart))
<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<!-- Chart Rendering Scripts -->
{!! $ordersChart->renderJs() !!}
@endif

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize chart
    initSalesChart();
    initProductChart();
    initUserChart();

    // Add event listeners to all status selects
    document.querySelectorAll('[id^="status-select-"]').forEach(select => {
        select.addEventListener('change', function() {
            const orderId = this.id.split('-').pop();
            const newStatus = this.value;
            if (newStatus) {
                updateOrderStatus(orderId, newStatus);
            }
        });
    });
});

function updateOrderStatus(orderId, newStatus) {
    Swal.fire({
        title: 'Update Order Status',
        text: 'Are you sure you want to change the status to ' + newStatus + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#db2777',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/admin/orders/${orderId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Updated!',
                        text: 'Order status has been updated successfully.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Failed to update status');
                }
            })
            .catch(error => {
                Swal.fire('Error!', error.message, 'error');
                document.getElementById(`status-select-${orderId}`).value = "";
            });
        } else {
            document.getElementById(`status-select-${orderId}`).value = "";
        }
    });
}

function initSalesChart() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesData = {!! json_encode($stats['monthly_sales'] ?? []) !!};

    if (!Array.isArray(salesData) || salesData.length === 0) {
        renderEmptyChart(ctx);
        return;
    }

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesData.map(data => data.month),
            datasets: [{
                label: 'Monthly Sales',
                data: salesData.map(data => data.total),
                borderColor: '#EC4899',
                backgroundColor: 'rgba(236, 72, 153, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: 'Monthly Sales Overview'
                }
            }
        }
    });
}

function renderEmptyChart(ctx, message = 'No sales data available') {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['No Data'],
            datasets: [{
                label: 'Monthly Sales',
                data: [0],
                borderColor: '#EC4899',
                backgroundColor: 'rgba(236, 72, 153, 0.1)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: message
                }
            }
        }
    });
}

function initProductChart() {
    const ctx = document.getElementById('productChart').getContext('2d');
    const productData = {!! json_encode($stats['product_stats'] ?? []) !!};

    if (!Array.isArray(productData) || productData.length === 0) {
        renderEmptyChart(ctx, 'No product data available');
        return;
    }

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: productData.map(data => data.name),
            datasets: [{
                data: productData.map(data => data.count),
                backgroundColor: [
                    '#EC4899', '#8B5CF6', '#3B82F6', '#10B981', '#F59E0B',
                    '#EF4444', '#6366F1', '#14B8A6', '#F97316', '#8B5CF6'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: {
                    display: true,
                    text: 'Products by Category'
                }
            }
        }
    });
}

function initUserChart() {
    const ctx = document.getElementById('userChart').getContext('2d');
    const userData = {!! json_encode($stats['user_stats'] ?? []) !!};

    if (!Array.isArray(userData) || userData.length === 0) {
        renderEmptyChart(ctx, 'No user data available');
        return;
    }

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: userData.map(data => data.month),
            datasets: [{
                label: 'New Users',
                data: userData.map(data => data.count),
                backgroundColor: 'rgba(236, 72, 153, 0.2)',
                borderColor: '#EC4899',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: 'Monthly User Registrations'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
}

// View order details handler
function viewOrderDetails(orderId) {
    if (!orderId) return;
    window.location.href = `/admin/orders/${orderId}`;
}
</script>
@endpush
@endsection