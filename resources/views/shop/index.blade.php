@extends('layouts.main')

@section('content')
<div class="shop-container">
    <div class="shop-header">
        <h1>Our Beautiful Flowers</h1>
        <p>Discover our handpicked collection of fresh flowers</p>
    </div>

    <div class="filters">
        <div class="category-filter">
            <select id="category-filter" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request()->category == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="price-filter">
            <h3>Price Range</h3>
            <div class="price-inputs">
                <div class="price-input">
                    <label for="min-price">Min</label>
                    <input type="number" id="min-price" name="min_price" 
                           value="{{ request()->min_price }}" 
                           min="{{ floor($priceRange->min_price) }}" 
                           max="{{ ceil($priceRange->max_price) }}"
                           step="1">
                </div>
                <div class="price-input">
                    <label for="max-price">Max</label>
                    <input type="number" id="max-price" name="max_price" 
                           value="{{ request()->max_price }}" 
                           min="{{ floor($priceRange->min_price) }}" 
                           max="{{ ceil($priceRange->max_price) }}"
                           step="1">
                </div>
            </div>
            <button id="apply-price-filter" class="btn-filter">Apply Filter</button>
        </div>
    </div>

    <div class="products-grid">
        @forelse($products as $product)
            <div class="product-card">
                <a href="{{ route('shop.show', $product) }}" class="product-link">
                    <div class="product-image">
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="product-info">
                        <h3>{{ $product->name }}</h3>
                        <p>{{ Str::limit($product->description, 80) }}</p>
                        <div class="product-price">${{ number_format($product->price, 2) }}</div>
                    </div>
                </a>
                <div class="product-actions">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-add-cart">Add to Cart</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="no-products">
                <p>No products found</p>
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $products->links() }}
    </div>
</div>

<style>
.shop-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.shop-header {
    text-align: center;
    margin-bottom: 3rem;
}

.shop-header h1 {
    font-size: 2.5rem;
    color: #333;
    margin-bottom: 1rem;
}

.shop-header p {
    color: #666;
    font-size: 1.1rem;
}

.filters {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    max-width: 800px;
    margin: 0 auto 2rem;
    padding: 1rem;
}

.category-filter {
    max-width: 300px;
    margin: 0 auto 2rem;
}

.form-select {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.price-filter {
    flex: 1;
    min-width: 250px;
    background: white;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.price-filter h3 {
    margin: 0 0 1rem;
    font-size: 1.1rem;
    color: #333;
}

.price-inputs {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.price-input {
    flex: 1;
}

.price-input label {
    display: block;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    color: #666;
}

.price-input input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.btn-filter {
    width: 100%;
    padding: 0.8rem;
    background: #ec4899;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn-filter:hover {
    background: #d61f69;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.product-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.1);
}

.product-info {
    padding: 1.5rem;
}

.product-info h3 {
    margin: 0 0 0.5rem;
    font-size: 1.2rem;
}

.product-info h3 a {
    color: #333;
    text-decoration: none;
}

.product-info p {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.product-price {
    font-size: 1.25rem;
    font-weight: bold;
    color: #ec4899;
    margin-bottom: 1rem;
}

.btn-add-cart {
    width: 100%;
    padding: 0.8rem;
    background: #ec4899;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn-add-cart:hover {
    background: #d61f69;
}

.no-products {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    color: #666;
}

.pagination {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

.pagination .page-link {
    color: #ec4899;
}

.pagination .active .page-link {
    background-color: #ec4899;
    border-color: #ec4899;
}

.product-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.product-link:hover {
    text-decoration: none;
}

.product-actions {
    padding: 0 1.5rem 1.5rem;
}

@media (max-width: 768px) {
    .shop-container {
        padding: 1rem;
    }

    .filters {
        flex-direction: column;
        gap: 1rem;
    }

    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }

    .shop-header h1 {
        font-size: 2rem;
    }
}
</style>

@push('scripts')
<script>
document.getElementById('category-filter').addEventListener('change', function() {
    let categoryId = this.value;
    let url = new URL(window.location.href);
    
    if (categoryId) {
        url.searchParams.set('category', categoryId);
    } else {
        url.searchParams.delete('category');
    }
    
    window.location.href = url.toString();
});

document.getElementById('apply-price-filter').addEventListener('click', function() {
    let minPrice = document.getElementById('min-price').value;
    let maxPrice = document.getElementById('max-price').value;
    let categoryId = document.getElementById('category-filter').value;
    let url = new URL(window.location.href);
    
    if (minPrice) {
        url.searchParams.set('min_price', minPrice);
    } else {
        url.searchParams.delete('min_price');
    }
    
    if (maxPrice) {
        url.searchParams.set('max_price', maxPrice);
    } else {
        url.searchParams.delete('max_price');
    }
    
    if (categoryId) {
        url.searchParams.set('category', categoryId);
    } else {
        url.searchParams.delete('category');
    }
    
    window.location.href = url.toString();
});
</script>
@endpush
@endsection
