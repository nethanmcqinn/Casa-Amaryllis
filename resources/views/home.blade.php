@extends('layouts.main')

@push('head')
<!-- Load Font Awesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@endpush

@section('content')
<!-- Modern Hero Section -->
<section class="relative h-screen flex items-center justify-center bg-gradient-to-br from-pink-50 to-purple-50 overflow-hidden">
    @if(file_exists(public_path('images/floral-pattern.png')))
    <div class="absolute inset-0 bg-[url('/images/floral-pattern.png')] opacity-10"></div>
    @endif
    <div class="container mx-auto px-6 relative z-10 text-center">
        <h1 class="text-5xl md:text-7xl font-bold text-gray-800 mb-6 animate-fade-in">Casa Amaryllis</h1>
        <p class="text-xl md:text-2xl text-gray-600 mb-8 max-w-2xl mx-auto">Where every bloom tells a story</p>
        <div class="flex gap-4 justify-center">
            <a href="{{ route('shop.index') }}" class="btn-primary">Shop Now</a>
            <a href="#services" class="btn-secondary">Our Services</a>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Our Signature Blooms</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Product 1 -->
            <div class="product-card group">
                <div class="overflow-hidden rounded-lg mb-4">
                    @if(file_exists(public_path('images/roses.jpg')))
                    <img src="/images/roses.jpg" alt="Elegant Roses" 
                         class="w-full h-80 object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                    <div class="w-full h-80 bg-gray-100 flex items-center justify-center">
                        <span class="text-gray-400">Roses Image</span>
                    </div>
                    @endif
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Elegant Roses</h3>
                <p class="text-gray-600 mb-4">Classic long-stemmed roses in various colors</p>
                <a href="{{ route('shop.index') }}" class="btn-primary">View Details</a>
            </div>

            <!-- Product 2 -->
            <div class="product-card group">
                <div class="overflow-hidden rounded-lg mb-4">
                    @if(file_exists(public_path('images/tulips.jpg')))
                    <img src="/images/tulips.jpg" alt="Spring Tulips"
                         class="w-full h-80 object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                    <div class="w-full h-80 bg-gray-100 flex items-center justify-center">
                        <span class="text-gray-400">Tulips Image</span>
                    </div>
                    @endif
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Spring Tulips</h3>
                <p class="text-gray-600 mb-4">Vibrant tulips to brighten any space</p>
                <a href="{{ route('shop.index') }}" class="btn-primary">View Details</a>
            </div>

            <!-- Product 3 -->
            <div class="product-card group">
                <div class="overflow-hidden rounded-lg mb-4">
                    @if(file_exists(public_path('images/orchids.jpg')))
                    <img src="/images/orchids.jpg" alt="Exotic Orchids"
                         class="w-full h-80 object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                    <div class="w-full h-80 bg-gray-100 flex items-center justify-center">
                        <span class="text-gray-400">Orchids Image</span>
                    </div>
                    @endif
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Exotic Orchids</h3>
                <p class="text-gray-600 mb-4">Sophisticated orchids for elegant spaces</p>
                <a href="{{ route('shop.index') }}" class="btn-primary">View Details</a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Our Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="service-card">
                <div class="text-5xl text-pink-500 mb-4">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Event Floristry</h3>
                <p class="text-gray-600">Custom arrangements for weddings and special occasions</p>
            </div>
            <div class="service-card">
                <div class="text-5xl text-pink-500 mb-4">
                    <i class="fas fa-home"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Home Delivery</h3>
                <p class="text-gray-600">Fresh flowers delivered to your doorstep</p>
            </div>
            <div class="service-card">
                <div class="text-5xl text-pink-500 mb-4">
                    <i class="fas fa-seedling"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Plant Care</h3>
                <p class="text-gray-600">Expert advice for keeping your plants thriving</p>
            </div>
        </div>
    </div>
</section>

<!-- About Us -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="md:w-1/2">
                @if(file_exists(public_path('images/florist-shop.jpg')))
                <img src="/images/florist-shop.jpg" alt="Our Flower Shop" class="rounded-lg shadow-xl">
                @else
                <div class="w-full h-64 bg-gray-100 flex items-center justify-center rounded-lg">
                    <span class="text-gray-400">Shop Image</span>
                </div>
                @endif
            </div>
            <div class="md:w-1/2">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Our Story</h2>
                <p class="text-gray-600 mb-4">Founded in 2010, Casa Amaryllis brings passion and creativity to every floral arrangement.</p>
                <p class="text-gray-600 mb-6">Our team of expert florists hand-selects each bloom to ensure the highest quality and freshness.</p>
                <a href="/about" class="btn-primary">Learn More</a>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">What Our Customers Say</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="testimonial-card p-8 bg-white rounded-lg shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400 mr-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-gray-600 italic mb-4">"The most beautiful flowers I've ever received! The arrangement was stunning and lasted over two weeks."</p>
                <p class="font-semibold text-gray-800">Maria Gonzalez</p>
            </div>
            <div class="testimonial-card p-8 bg-white rounded-lg shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400 mr-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-gray-600 italic mb-4">"Exceptional service and quality. The wedding flowers were beyond my expectations!"</p>
                <p class="font-semibold text-gray-800">James Wilson</p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* Reset and base styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Container styles */
    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* Hero section */
    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #fdf2f8 0%, #f3e8ff 100%);
        position: relative;
        overflow: hidden;
    }

    /* Typography */
    h1 {
        font-size: 4rem;
        color: #1f2937;
        margin-bottom: 1.5rem;
    }

    h2 {
        font-size: 2rem;
        color: #1f2937;
        margin-bottom: 2rem;
        text-align: center;
    }

    h3 {
        font-size: 1.25rem;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    /* Button styles */
    .btn-primary {
        display: inline-block;
        background-color: #db2777;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #be185d;
        transform: translateY(-2px);
    }

    .btn-secondary {
        display: inline-block;
        border: 2px solid #db2777;
        color: #db2777;
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #fdf2f8;
    }

    /* Grid layouts */
    .grid {
        display: grid;
        gap: 2rem;
        margin: 2rem 0;
    }

    @media (min-width: 768px) {
        .grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* Card styles */
    .product-card, .service-card, .testimonial-card {
        background: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .product-card:hover, .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    /* Image styles */
    img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
    }

    /* Section spacing */
    section {
        padding: 5rem 0;
    }

    section:nth-child(even) {
        background-color: #f9fafb;
    }

    /* Testimonials */
    .testimonial-card {
        text-align: left;
    }

    .star-rating {
        color: #fbbf24;
        margin-bottom: 1rem;
    }

    /* Animation */
    .animate-fade-in {
        animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        h1 {
            font-size: 2.5rem;
        }

        .grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
// Ensure animations work even with Turbolinks/SPA
document.addEventListener('DOMContentLoaded', function() {
    // Animation initialization code if needed
});
</script>
@endpush
