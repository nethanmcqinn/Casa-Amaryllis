<div class="profile-section">
    @auth
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-picture-container">
                    <img src="{{ Auth::user()->profile_picture ? Storage::url(Auth::user()->profile_picture) : asset('images/default-avatar.png') }}" 
                         alt="Profile Picture" 
                         class="profile-picture"
                         id="currentProfilePicture">
                    <div class="profile-picture-overlay">
                        <button type="button" id="changePictureBtn" class="change-picture-btn">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                </div>
                <h2>Welcome, {{ Auth::user()->name }}!</h2>
                <p class="text-muted">{{ Auth::user()->email }}</p>
            </div>
            
            <form id="profilePictureForm" class="hidden">
                @csrf
                <input type="file" name="profile_picture" id="profilePictureInput" accept="image/*" class="hidden">
            </form>

            <div class="profile-content">
                <div class="profile-card">
                    <h3>Recent Orders</h3>
                    @if(Auth::user()->orders->count() > 0)
                        <div class="orders-list">
                            @foreach(Auth::user()->orders->take(3) as $order)
                                <div class="order-item">
                                    <div class="order-header">
                                        <span class="order-id">Order #{{ $order->id }}</span>
                                        <span class="order-date">{{ $order->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="order-details">
                                        <span class="order-status {{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
                                        <span class="order-total">${{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="no-orders">No orders yet. Start shopping now!</p>
                    @endif
                </div>

                <div class="profile-card">
                    <h3>Shipping Information</h3>
                    @if(Auth::user()->orders->count() > 0)
                        @php
                            $latestOrder = Auth::user()->orders->last();
                        @endphp
                        <div class="shipping-details">
                            <p><strong>Address:</strong> {{ $latestOrder->shipping_address }}</p>
                            <p><strong>City:</strong> {{ $latestOrder->shipping_city }}</p>
                            <p><strong>State:</strong> {{ $latestOrder->shipping_state }}</p>
                            <p><strong>Zip Code:</strong> {{ $latestOrder->shipping_zipcode }}</p>
                        </div>
                    @else
                        <p class="no-address">No shipping information available.</p>
                    @endif
                </div>
            </div>
        </div>
    @endauth
</div>

@push('scripts')
<script>
document.getElementById('changePictureBtn').addEventListener('click', function() {
    document.getElementById('profilePictureInput').click();
});

document.getElementById('profilePictureInput').addEventListener('change', function() {
    const form = document.getElementById('profilePictureForm');
    const formData = new FormData(form);

    fetch('{{ route('admin.profile.update-picture') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('currentProfilePicture').src = data.path;
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to update profile picture'
        });
    });
});
</script>
@endpush