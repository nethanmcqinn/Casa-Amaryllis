@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Product Details Section -->
        <div class="md:flex">
            <div class="md:flex-shrink-0">
                <img class="h-96 w-full object-cover md:w-96" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
            </div>
            <div class="p-8">
                <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>
                <p class="mt-2 text-gray-600">{{ $product->description }}</p>
                <div class="mt-4">
                    <span class="text-xl font-bold text-pink-600">${{ number_format($product->price, 2) }}</span>
                </div>
                
                <div class="mt-6">
                    <form action="{{ route('cart.add') }}" method="POST" class="flex items-center gap-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" value="1" min="1" max="10"
                               class="w-20 rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                        <button type="submit" class="bg-pink-600 text-white px-6 py-2 rounded-md hover:bg-pink-700">
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="border-t border-gray-200 px-8 py-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Customer Reviews</h2>

            @auth
            <!-- Review Form -->
            <form action="{{ route('products.reviews.store', $product) }}" method="POST" class="mb-8">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Rating</label>
                    <select name="rating" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500">
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Your Review</label>
                    <textarea name="comment" rows="3" required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500"></textarea>
                </div>
                <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded-md hover:bg-pink-700">
                    Submit Review
                </button>
            </form>
            @else
            <p class="text-gray-600 mb-8">Please <a href="{{ route('login') }}" class="text-pink-600 hover:text-pink-700">login</a> to leave a review.</p>
            @endauth

            <!-- Reviews List -->
            <div class="space-y-6">
                @forelse($product->reviews as $review)
                    <div class="border-b border-gray-200 pb-6" id="review-{{ $review->id }}">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <div class="flex text-yellow-400">
                                    @for($i = 0; $i < 5; $i++)
                                        @if($i < $review->rating)
                                            <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5 fill-current text-gray-300" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 text-sm text-gray-600">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            @if(auth()->id() === $review->user_id)
                                <div class="flex items-center space-x-3">
                                    <button onclick="editReview({{ $review->id }}, {{ $review->rating }}, '{{ addslashes($review->comment) }}')" 
                                            type="button"
                                            class="text-pink-600 hover:text-pink-900">
                                        Edit
                                    </button>
                                    <form action="{{ route('products.reviews.destroy', $review->id) }}"
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this review?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <p class="text-gray-600">{{ $review->comment }}</p>
                        <p class="mt-2 text-sm font-medium text-gray-900">- {{ $review->user->name }}</p>
                    </div>
                @empty
                    <p class="text-gray-600">No reviews yet. Be the first to review this product!</p>
                @endforelse

@push('scripts')
<script>
function editReview(reviewId, rating, comment) {
    Swal.fire({
        title: 'Edit Review',
        html: `
            <select id="edit-rating" class="block w-full mt-1 rounded-md border-gray-300">
                <option value="5" ${rating === 5 ? 'selected' : ''}>5 Stars</option>
                <option value="4" ${rating === 4 ? 'selected' : ''}>4 Stars</option>
                <option value="3" ${rating === 3 ? 'selected' : ''}>3 Stars</option>
                <option value="2" ${rating === 2 ? 'selected' : ''}>2 Stars</option>
                <option value="1" ${rating === 1 ? 'selected' : ''}>1 Star</option>
            </select>
            <textarea id="edit-comment" class="block w-full mt-4 rounded-md border-gray-300" rows="3">${comment}</textarea>
        `,
        showCancelButton: true,
        confirmButtonText: 'Update',
        confirmButtonColor: '#db2777',
        preConfirm: () => {
            return {
                rating: document.getElementById('edit-rating').value,
                comment: document.getElementById('edit-comment').value
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            updateReview(reviewId, result.value);
        }
    });
}

function updateReview(reviewId, data) {
    fetch(`/products/reviews/${reviewId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            throw new Error('Failed to update review');
        }
    })
    .catch(error => {
        Swal.fire('Error!', error.message, 'error');
    });
}

function deleteReview(reviewId) {
    Swal.fire({
        title: 'Delete Review?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/reviews/${reviewId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`review-${reviewId}`).remove();
                    Swal.fire('Deleted!', 'Your review has been deleted.', 'success');
                } else {
                    throw new Error('Failed to delete review');
                }
            })
            .catch(error => {
                Swal.fire('Error!', error.message, 'error');
            });
        }
    });
}
</script>
@endpush
        </div>
    </div>
</div>
@endsection
