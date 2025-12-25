@extends('user_page.layouts.app')

@section('title', 'Shop')

@section('content')

		<!-- Start Hero Section -->
	<div class="hero">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-5">
					<div class="intro-excerpt">
						<h1>Shop</h1>
					</div>
				</div>
				<div class="col-lg-7">
					
				   </div>				   
			   </div>
			</div>
	</div>
<!-- End Hero Section -->

<div class="untree_co-section product-section before-footer-section" style="margin-bottom: -100px;">
	<div class="container">
		<div class="row">
			@forelse ($products as $product)

			<!-- Start Column 1 -->
				<div class="col-12 col-md-4 col-lg-3 mb-5">
					<a class="product-item" href="#">
						<img src="{{ asset('assets/furni-1.0.0/images/product-3.png') }}" class="img-fluid product-thumbnail">
						<h3 class="product-title">{{ $product->name ?? '-' }}</h3>
						<strong class="product-price">{{ 'Rp ' . number_format($product->price ?? 0, 0, ',', '.') }}</strong>

						<span class="icon-cross">
							 <i class="text-white fas fa-plus"></i>
						</span>
					</a>
				</div> 
				<!-- End Column 1 -->		
			@empty
				<div class="col-12 text-center py-5">
					<h4 class="text-muted">Produk tidak ditemukan.</h4>
					<p class="text-muted">Silakan kembali lagi nanti atau gunakan kata kunci pencarian lain.</p>
				</div>
			@endforelse
			<div class="d-flex justify-content-center mt-5">
					   <nav aria-label="Product pagination">
						   <ul class="pagination pagination-sm">
							   @if ($products->onFirstPage())
								   <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
							   @else
								   <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">&laquo;</a></li>
							   @endif

							   @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
								   @if ($page == $products->currentPage())
									   <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
								   @else
									   <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
								   @endif
							   @endforeach

							   @if ($products->hasMorePages())
								   <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">&raquo;</a></li>
							   @else
								   <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
							   @endif
						   </ul>
					   </nav>
				   </div>

		</div>
	</div>
</div>
@endsection

@push('styles')
<style>
	.icon-cross i {
		font-size: 2rem; /* Ubah sesuai kebutuhan, misal 2.5rem, 32px, dst */
	}
</style>
@endpush
