        <!-- Start Shop Area -->
        <style>
            .annur-shop-card {
                padding: 20px;
                border-radius: var(--radius-md);
                background: var(--card-bg);
                border: 1px solid var(--border-color);
                box-shadow: var(--card-shadow);
                transition: transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.3s ease;
            }
            .annur-shop-card:hover {
                transform: translateY(-4px);
                box-shadow: var(--card-shadow-hover);
                border-color: rgba(201, 162, 39, 0.4);
            }
            .annur-shop-thumb {
                position: relative;
                width: 100%;
                height: 200px;
                border-radius: var(--radius-sm);
                overflow: hidden;
                background: rgba(7, 21, 38, 0.03);
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .annur-shop-thumb img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                transition: transform 0.35s ease;
            }
            .annur-shop-card:hover .annur-shop-thumb img {
                transform: scale(1.05);
            }
            @media (max-width: 576px) {
                .annur-shop-card {
                    padding: 14px;
                }
                .annur-shop-thumb {
                    height: 160px;
                }
            }
        </style>
        <div class="section">
            <div class="container">
                <div class="center mb--40">
                    <span class="eyebrow">{{ $section->subtitle ?? 'PRODUK & JURNAL' }}</span>
                    <h2 class="section-title">{!! $section->title ?? 'Koleksi <span class="theme-gradient">Produk & Publikasi</span>' !!}</h2>
                    <p class="section-desc">Temukan layanan, merchandise, publikasi ilmiah, dan produk edukasi unggulan kami.</p>
                </div>

                <div class="row g-4 justify-content-center">
                    @php
                       $productsList = [];
                       if (class_exists('\App\Models\Product')) {
                           $productsList = \App\Models\Product::where('is_active', true)->orderBy('id', 'desc')->limit(4)->get();
                       }
                    @endphp

                    @forelse($productsList as $product)
                    <!-- Start Single Product  -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="annur-shop-card rbt-default-card style-three rbt-hover h-100 d-flex flex-column">
                            <div class="inner d-flex flex-column flex-grow-1">
                                <div class="annur-shop-thumb mb-3">
                                    <a href="{{ route('shop.show', $product->slug) }}" class="w-100 h-100 d-block">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/product/1.jpg') }}" alt="{{ $product->name }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="content pt--0 pb--10 flex-grow-1">
                                    <h4 class="title" style="font-family: var(--font-body); font-size: 15px; font-weight: 700; line-height: 1.4; margin-bottom: 8px;">
                                        <a href="{{ route('shop.show', $product->slug) }}" style="color: var(--text-main); text-decoration: none;">{{ $product->name }}</a>
                                    </h4>
                                     @if($product->author_name)
                                     <span class="d-block" style="font-size: 13px; color: var(--text-muted);">
                                         <iconify-icon icon="solar:user-bold-duotone" class="me-1" style="color: var(--gold-primary); vertical-align: middle;"></iconify-icon> {{ $product->author_name }}
                                     </span>
                                     @endif
                                </div>
                                <div class="content mt-auto pt-3 border-top" style="border-color: var(--border-color) !important;">
                                    <div class="rbt-price justify-content-center mb-3">
                                        @if($product->discount_price > 0 && $product->discount_price < $product->price)
                                            <span class="current-price theme-gradient" style="font-size: 17px; font-weight: 800;">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                            <span class="off-price text-muted ms-2" style="font-size: 13px; text-decoration: line-through;">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        @else
                                            <span class="current-price theme-gradient" style="font-size: 17px; font-weight: 800;">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                     <div class="addto-cart-btn text-center">
                                         <a class="btn-gold w-100" style="min-height: 40px; font-size: 13px; padding: 0 16px;" href="{{ route('shop.show', $product->slug) }}">
                                             Lihat Detail
                                             <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-1" style="vertical-align: middle;"></iconify-icon>
                                         </a>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Product  -->
                    @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">Belum ada produk yang tersedia.</p>
                    </div>
                    @endforelse
                </div>

                @if($section->button_text && $section->button_url)
                <div class="row mt--40 text-center">
                    <div class="col-lg-12">
                        <a class="btn-outline-navy" href="{{ $section->button_url }}">
                            {{ $section->button_text }}
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-1" style="vertical-align: middle;"></iconify-icon>
                        </a>
                    </div>
                </div>
                @else
                <div class="row mt--40 text-center">
                    <div class="col-lg-12">
                        <a class="btn-outline-navy" href="{{ url('/shop') }}">
                            Lihat Semua Produk & Jurnal
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-1" style="vertical-align: middle;"></iconify-icon>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!-- End Shop Area -->
