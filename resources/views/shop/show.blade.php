@extends('frontend.layouts.app')

@section('meta_title', $product->meta_title ?? $product->name)
@section('meta_description', $product->meta_description ?? Str::limit(strip_tags($product->description), 160))
@section('meta_keywords', $product->meta_keywords)

@php
    $isBook = $product->isbn || $product->doi || (is_array($product->authors) && count($product->authors) > 0);
@endphp

@if($product->image)
@section('meta_image', asset('storage/' . $product->image))
@endif

@push('meta')
    @if($isBook)
        <meta name="citation_title" content="{{ $product->name }}">
        <meta name="DC.type" content="book">
        <meta name="DC.title" content="{{ $product->name }}">
        <meta property="og:type" content="book">
        <meta property="og:title" content="{{ $product->name }}">
        <meta name="citation_language" content="{{ $product->language ?? 'id' }}">
        <meta name="DC.language" content="{{ $product->language ?? 'id' }}">

        @if(is_array($product->authors) && count($product->authors) > 0)
            @foreach($product->authors as $author)
                <meta name="citation_author" content="{{ $author }}">
                <meta name="DC.creator" content="{{ $author }}">
            @endforeach
        @endif

        @if(is_array($product->editors) && count($product->editors) > 0)
            @foreach($product->editors as $editor)
                <meta name="citation_author" content="{{ $editor }} (Ed.)">
                <meta name="DC.contributor" content="{{ $editor }}">
            @endforeach
        @endif

        @if(is_array($product->translators) && count($product->translators) > 0)
            @foreach($product->translators as $translator)
                <meta name="citation_author" content="{{ $translator }} (Trans.)">
                <meta name="DC.contributor" content="{{ $translator }} (Translator)">
            @endforeach
        @endif

        @if(!empty($product->publisher_imprint))
            <meta name="citation_publisher" content="{{ $product->publisher_imprint }}">
            <meta name="DC.publisher" content="{{ $product->publisher_imprint }}">
        @endif
        @if(!empty($product->publication_date))
            <meta name="citation_publication_date" content="{{ $product->publication_date->format('Y/m/d') }}">
            <meta name="DC.date" content="{{ $product->publication_date->format('Y-m-d') }}">
        @endif
        @if(!empty($product->isbn))
            <meta name="citation_isbn" content="{{ $product->isbn }}">
            <meta name="DC.identifier" content="ISBN:{{ $product->isbn }}">
        @endif
        @if(!empty($product->doi))
            <meta name="citation_doi" content="{{ $product->doi }}">
            <meta name="DC.identifier" content="DOI:{{ $product->doi }}">
        @endif
        @if(!empty($product->preview_url) || !empty($product->preview_document_path))
            <meta name="citation_pdf_url" content="{{ !empty($product->preview_document_path) ? asset('storage/' . $product->preview_document_path) : $product->preview_url }}">
        @endif

        @php
            $schemaAuthors = [];
            if (is_array($product->authors)) {
                foreach ($product->authors as $a) {
                    $schemaAuthors[] = ['@type' => 'Person', 'name' => $a];
                }
            }
            $schemaEditors = [];
            if (is_array($product->editors)) {
                foreach ($product->editors as $e) {
                    $schemaEditors[] = ['@type' => 'Person', 'name' => $e];
                }
            }
            $schemaTranslators = [];
            if (is_array($product->translators)) {
                foreach ($product->translators as $t) {
                    $schemaTranslators[] = ['@type' => 'Person', 'name' => $t];
                }
            }

            $schema = [
                '@context'  => 'https://schema.org',
                '@type'     => 'Book',
                'name'      => $product->name,
                'url'       => url()->current(),
                'inLanguage' => $product->language ?? 'id',
            ];

            if (!empty($schemaAuthors))     $schema['author']      = $schemaAuthors;
            if (!empty($schemaEditors))     $schema['editor']      = $schemaEditors;
            if (!empty($schemaTranslators)) $schema['translator']  = $schemaTranslators;
            if (!empty($product->publisher_imprint)) {
                $schema['publisher'] = [
                    '@type' => 'Organization',
                    'name'  => $product->publisher_imprint,
                ];
            }
            if (!empty($product->publication_date)) {
                $schema['datePublished'] = $product->publication_date->format('Y-m-d');
            }
            if (!empty($product->isbn))  $schema['isbn']          = $product->isbn;
            if (!empty($product->doi))   $schema['sameAs']        = 'https://doi.org/' . ltrim($product->doi, 'https://doi.org/');
            if (!empty($product->pages)) $schema['numberOfPages'] = $product->pages;
            if ($product->image)         $schema['image']         = asset('storage/' . $product->image);
            if (!empty($product->excerpt) || !empty($product->description)) {
                $schema['description'] = Str::limit(strip_tags($product->excerpt ?? $product->description), 300);
            }
            if (!empty($product->preview_document_path)) {
                $schema['associatedMedia'] = [
                    '@type'       => 'MediaObject',
                    'contentUrl'  => asset('storage/' . $product->preview_document_path),
                    'encodingFormat' => 'application/pdf',
                ];
            }
        @endphp
        <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
    @endif
@endpush

@section('content')
@if(isset($isPreview) && $isPreview)
<div style="position: sticky; top: 0; z-index: 9999; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; padding: 12px 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; box-shadow: 0 4px 16px rgba(245,158,11,0.35);">
    <div style="display:flex; align-items:center; gap:10px;">
        <span style="font-size:1.3rem;">🔍</span>
        <div>
            <span style="font-weight: 700; font-size: 15px;">MODE PREVIEW PRODUK</span>
            <span style="margin-left: 10px; font-size: 12px; background: rgba(0,0,0,0.2); padding: 2px 10px; border-radius: 20px; font-weight: 600;">
                {{ $product->is_active ? '✅ AKTIF' : '📦 NON-AKTIF' }}
            </span>
        </div>
    </div>
    <a href="{{ route('admin.products.edit', $product->id) }}" style="background: rgba(0,0,0,0.25); color: #fff; text-decoration: none; padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 14px;">
        ✏️ Kembali ke Editor
    </a>
</div>
@endif

<!-- BRILL.COM ACADEMIC HERO BANNER -->
<div class="brill-hero" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 60%, #102A4C 100%) !important; padding: 50px 0 45px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); color: #FFFFFF;">
    <div class="container">
        <!-- Breadcrumb -->
        <ul style="list-style: none; display: flex; align-items: center; flex-wrap: wrap; gap: 8px; padding: 0; margin-bottom: 16px; font-size: 13.5px; color: rgba(255,255,255,0.7);">
            <li><a href="/" style="color: rgba(255,255,255,0.85); text-decoration: none;">Beranda</a></li>
            <li><iconify-icon icon="solar:alt-arrow-right-linear" style="font-size: 11px; color: rgba(255,255,255,0.5); vertical-align: middle;"></iconify-icon></li>
            <li><a href="{{ route('shop.index') }}" style="color: rgba(255,255,255,0.85); text-decoration: none;">Katalog Publikasi & Buku</a></li>
            <li><iconify-icon icon="solar:alt-arrow-right-linear" style="font-size: 11px; color: rgba(255,255,255,0.5); vertical-align: middle;"></iconify-icon></li>
            <li style="color: #E8C766; font-weight: 600;">{{ Str::limit($product->name, 45) }}</li>
        </ul>

        <!-- Type Badge -->
        <div class="mb-2">
            <span style="padding: 4px 14px; background: rgba(232, 199, 102, 0.15); color: #E8C766; border: 1px solid rgba(232, 199, 102, 0.35); border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; letter-spacing: 0.04em; text-transform: uppercase;">
                BOOK | ACADEMIC MONOGRAPH
            </span>
        </div>

        <!-- Book Main Title -->
        <h1 style="color: #FFFFFF !important; font-size: 32px; font-weight: 800; line-height: 1.3; margin-bottom: 12px; letter-spacing: -0.02em;">
            {{ $product->name }}
        </h1>

        <!-- Author / Contributor Meta Line (Brill Style) -->
        <div class="d-flex flex-wrap align-items-center gap-3" style="font-size: 15px; color: #E8C766; font-weight: 600; margin-bottom: 14px;">
            @if(is_array($product->authors) && count($product->authors) > 0)
                <span><iconify-icon icon="solar:user-bold-duotone" class="me-1" style="vertical-align: middle;"></iconify-icon> <strong>By:</strong> {{ implode(', ', $product->authors) }}</span>
            @endif

            @if(is_array($product->translators) && count($product->translators) > 0)
                <span style="color: rgba(255,255,255,0.85);"><iconify-icon icon="solar:global-bold-duotone" class="me-1" style="vertical-align: middle;"></iconify-icon> <strong>Translated by:</strong> {{ implode(', ', $product->translators) }}</span>
            @endif
        </div>

        <!-- DOI & ISBN Bar (Brill Style Metadata Strip) -->
        <div class="d-flex flex-wrap align-items-center gap-3 pt-2" style="font-size: 13px; color: rgba(255,255,255,0.75); border-top: 1px solid rgba(255,255,255,0.1);">
            @if($product->doi)
                <span><strong>DOI:</strong> <a href="{{ str_starts_with($product->doi, 'http') ? $product->doi : 'https://doi.org/'.$product->doi }}" target="_blank" style="color: #E8C766; text-decoration: underline;">{{ $product->doi }}</a></span>
            @endif

            @if($product->isbn)
                <span><strong>ISBN:</strong> {{ $product->isbn }}</span>
            @endif

            @if($product->publication_date)
                <span><strong>Published:</strong> {{ $product->publication_date->format('d M Y') }}</span>
            @endif
        </div>
    </div>
</div>

<!-- BRILL 2-COLUMN WORKSPACE -->
<div class="section py-5">
    <div class="container">
        <div class="row g-5">
            <!-- LEFT COLUMN: BOOK COVER & PURCHASE BOX (BRILL STYLE) -->
            <div class="col-lg-4 col-md-5">
                <div class="p-4" style="background: var(--card-bg); border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); text-align: center;">
                    <!-- Cover Box -->
                    <div class="mb-4" style="background: var(--ivory-bg); padding: 20px; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-height: 380px; width: auto; max-width: 100%; object-fit: contain; box-shadow: 0 12px 30px rgba(0,0,0,0.14); border-radius: 6px;">
                        @else
                            <img src="{{ asset('frontend/assets/images/product/1.jpg') }}" alt="{{ $product->name }}" style="max-height: 380px; width: auto; max-width: 100%; object-fit: contain;">
                        @endif
                    </div>

                    <!-- Clean Price Tag -->
                    <div class="mb-4 text-center">
                        @if($product->discount_price > 0 && $product->discount_price < $product->price)
                            <div style="font-size: 26px; font-weight: 800; color: var(--gold-primary); line-height: 1.2;">
                                Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                            </div>
                            <div style="font-size: 14px; color: var(--text-muted); text-decoration: line-through; margin-top: 4px;">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        @else
                            <div style="font-size: 26px; font-weight: 800; color: var(--gold-primary); line-height: 1.2;">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    @php
                        $priceFormatted = ($product->discount_price > 0 && $product->discount_price < $product->price)
                            ? 'Rp ' . number_format($product->discount_price, 0, ',', '.')
                            : 'Rp ' . number_format($product->price, 0, ',', '.');

                        $waMessageTemplate = "Assalamu'alaikum Admin Pesma An-Nur,\n\n"
                            . "Saya tertarik untuk memesan / bertanya mengenai publikasi/produk berikut:\n"
                            . "📌 Judul: " . $product->name . "\n"
                            . "💰 Harga: " . $priceFormatted . "\n"
                            . "🔗 Link: " . url()->current() . "\n\n"
                            . "Mohon informasi stok & ketersediaannya. Terima kasih!";

                        $shopWa = $product->external_link_wa ?: (\App\Models\Setting::getByKey('whatsapp_number') ?: \App\Models\Setting::getByKey('contact_phone'));
                        $shopWaUrl = null;
                        if ($shopWa && str_starts_with($shopWa, 'http')) {
                            if (!str_contains($shopWa, 'text=')) {
                                $connector = str_contains($shopWa, '?') ? '&' : '?';
                                $shopWaUrl = $shopWa . $connector . 'text=' . urlencode($waMessageTemplate);
                            } else {
                                $shopWaUrl = $shopWa;
                            }
                        } elseif ($shopWa) {
                            $cleanShopWa = preg_replace('/[^0-9]/', '', $shopWa);
                            if (str_starts_with($cleanShopWa, '0')) {
                                $cleanShopWa = '62' . substr($cleanShopWa, 1);
                            }
                            $shopWaUrl = 'https://wa.me/' . $cleanShopWa . '?text=' . urlencode($waMessageTemplate);
                        }
                    @endphp

                    <div class="d-flex flex-column gap-2">
                        @if($shopWaUrl)
                        <a class="btn-emerald w-100" href="{{ $shopWaUrl }}" target="_blank" style="min-height: 44px; font-size: 14px;">
                            <iconify-icon icon="solar:chat-round-dots-bold-duotone" class="me-1" style="font-size: 18px; vertical-align: middle;"></iconify-icon>
                            Beli via WhatsApp
                        </a>
                        @endif

                        @if($product->external_link_marketplace)
                        <a class="btn-outline-navy w-100" href="{{ $product->external_link_marketplace }}" target="_blank" style="min-height: 44px; font-size: 14px;">
                            <iconify-icon icon="solar:shop-bold-duotone" class="me-1" style="font-size: 18px; vertical-align: middle;"></iconify-icon>
                            Beli via Marketplace
                        </a>
                        @endif
                        
                        @if(!empty($product->preview_url) || !empty($product->preview_document_path))
                        <a class="btn-gold w-100" href="{{ !empty($product->preview_document_path) ? asset('storage/' . $product->preview_document_path) : $product->preview_url }}" target="_blank" style="min-height: 44px; font-size: 14px;">
                            <iconify-icon icon="solar:file-text-bold-duotone" class="me-1" style="font-size: 18px; vertical-align: middle;"></iconify-icon>
                            Download Preview PDF
                        </a>
                        @endif
                    </div>

                    <!-- Share Bar -->
                    <div class="mt-4 pt-3 border-top" style="border-color: var(--border-color) !important;">
                        <span class="d-block mb-2 text-muted fw-semibold" style="font-size: 12.5px;">Bagikan Publikasi / Produk Ini:</span>
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <a href="https://wa.me/?text={{ urlencode('Lihat ' . $product->name . ' di Pesma An-Nur: ' . url()->current()) }}" target="_blank" class="btn btn-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #25D366; border: none;" title="Bagikan ke WhatsApp">
                                <iconify-icon icon="ri:whatsapp-fill" style="font-size: 18px; color: #FFF;"></iconify-icon>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #1877F2; border: none;" title="Bagikan ke Facebook">
                                <iconify-icon icon="ri:facebook-fill" style="font-size: 18px; color: #FFF;"></iconify-icon>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($product->name) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #1DA1F2; border: none;" title="Bagikan ke Twitter">
                                <iconify-icon icon="ri:twitter-x-fill" style="font-size: 18px; color: #FFF;"></iconify-icon>
                            </a>
                            <button onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('Link produk berhasil disalin!');" class="btn btn-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(7, 21, 38, 0.08); border: 1px solid var(--border-color); color: var(--text-main);" title="Salin Link">
                                <iconify-icon icon="solar:copy-bold-duotone" style="font-size: 18px;"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: BRILL TABS (OVERVIEW, BOOK DETAILS, CITATION) -->
            <div class="col-lg-8 col-md-7">
                <div class="p-4" style="background: var(--card-bg); border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
                    <!-- Brill Style Tab Navigation -->
                    <ul class="nav nav-tabs mb-4" id="brillTab" role="tablist" style="border-bottom: 2px solid var(--border-color); gap: 10px;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true" style="border: none; border-bottom: 3px solid var(--gold-primary); color: var(--navy-primary); font-size: 15px; padding: 10px 16px;">
                                Overview & Ringkasan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false" style="border: none; color: var(--text-muted); font-size: 15px; padding: 10px 16px;">
                                Detail Buku & Metadata
                            </button>
                        </li>
                        @if($isBook)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="cite-tab" data-bs-toggle="tab" data-bs-target="#cite" type="button" role="tab" aria-controls="cite" aria-selected="false" style="border: none; color: var(--text-muted); font-size: 15px; padding: 10px 16px;">
                                Sitasi & Export
                            </button>
                        </li>
                        @endif
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="brillTabContent">
                        <!-- Tab 1: Overview -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            @if($product->description || $product->excerpt)
                            <div class="post-content" style="font-size: 15px; color: var(--text-main); line-height: 1.75;">
                                {!! $product->description ?? $product->excerpt !!}
                            </div>
                            @else
                            <p class="text-muted">Belum ada rincian ringkasan untuk publikasi ini.</p>
                            @endif
                        </div>

                        <!-- Tab 2: Details & Metadata Table -->
                        <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <table class="table table-striped align-middle m-0" style="font-size: 14px; color: var(--text-main);">
                                <tbody>
                                    @if($product->sku)
                                    <tr>
                                        <th style="width: 170px; color: var(--text-muted); font-weight: 600;">SKU</th>
                                        <td style="font-weight: 700;">{{ $product->sku }}</td>
                                    </tr>
                                    @endif
                                    @if($product->subjects)
                                    <tr>
                                        <th style="color: var(--text-muted); font-weight: 600;">Topik / Subjek</th>
                                        <td><span class="badge" style="background: rgba(201, 162, 39, 0.12); color: var(--gold-primary); border-radius: 50px; padding: 6px 14px; font-weight: 700;">{{ $product->subjects }}</span></td>
                                    </tr>
                                    @endif
                                    @if(is_array($product->authors) && count($product->authors) > 0)
                                    <tr>
                                        <th style="color: var(--text-muted); font-weight: 600;">Penulis</th>
                                        <td style="font-weight: 700;">{{ implode(', ', $product->authors) }}</td>
                                    </tr>
                                    @endif
                                    @if(is_array($product->translators) && count($product->translators) > 0)
                                    <tr>
                                        <th style="color: var(--text-muted); font-weight: 600;">Penerjemah</th>
                                        <td style="font-weight: 600;">{{ implode(', ', $product->translators) }}</td>
                                    </tr>
                                    @endif
                                    @if(is_array($product->editors) && count($product->editors) > 0)
                                    <tr>
                                        <th style="color: var(--text-muted); font-weight: 600;">Editor</th>
                                        <td>{{ implode(', ', $product->editors) }}</td>
                                    </tr>
                                    @endif
                                    @if($product->edition)
                                    <tr>
                                        <th style="color: var(--text-muted); font-weight: 600;">Edisi</th>
                                        <td>{{ $product->edition }}</td>
                                    </tr>
                                    @endif
                                    @if($product->publication_date)
                                    <tr>
                                        <th style="color: var(--text-muted); font-weight: 600;">Tanggal Terbit</th>
                                        <td>{{ $product->publication_date->format('d F Y') }}</td>
                                    </tr>
                                    @endif
                                    @if($product->publisher_imprint)
                                    <tr>
                                        <th style="color: var(--text-muted); font-weight: 600;">Penerbit / Imprint</th>
                                        <td style="font-weight: 700;">{{ $product->publisher_imprint }}</td>
                                    </tr>
                                    @endif
                                    @if($product->pages)
                                    <tr>
                                        <th style="color: var(--text-muted); font-weight: 600;">Jumlah Halaman</th>
                                        <td>{{ $product->pages }} hlm.</td>
                                    </tr>
                                    @endif
                                    @if($product->isbn)
                                    <tr>
                                        <th style="color: var(--text-muted); font-weight: 600;">ISBN</th>
                                        <td style="font-weight: 700; font-family: monospace;">{{ $product->isbn }}</td>
                                    </tr>
                                    @endif
                                    @if($product->doi)
                                    <tr>
                                        <th style="color: var(--text-muted); font-weight: 600;">DOI Index</th>
                                        <td><a href="{{ str_starts_with($product->doi, 'http') ? $product->doi : 'https://doi.org/'.$product->doi }}" target="_blank" style="color: var(--gold-primary); font-weight: 700;">{{ $product->doi }}</a></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Tab 3: Citation -->
                        @if($isBook)
                        @php
                            $citeYear      = $product->publication_date ? $product->publication_date->format('Y') : date('Y');
                            $citeAuthors   = is_array($product->authors) && count($product->authors) > 0 ? implode(', ', $product->authors) : 'Anonymous';
                            $citeTitle     = $product->name;
                            $citePublisher = $product->publisher_imprint ?? '';
                            $citeCity      = $product->publication_location ?? '';
                            $editors       = is_array($product->editors) && count($product->editors) > 0 ? $product->editors : [];
                            $translators   = is_array($product->translators) && count($product->translators) > 0 ? $product->translators : [];

                            $editorStrApa     = count($editors) > 0 ? implode(', ', $editors) . (count($editors) > 1 ? ', Eds.' : ', Ed.') : '';
                            $translatorStrApa = count($translators) > 0 ? implode(', ', $translators) . ', Trans.' : '';
                            $extraPartsApa    = array_filter([$editorStrApa, $translatorStrApa]);
                            $extraApa         = count($extraPartsApa) > 0 ? ' (' . implode('; ', $extraPartsApa) . ')' : '';

                            $citeApa     = "{$citeAuthors}. ({$citeYear}). {$citeTitle}{$extraApa}. {$citePublisher}.";
                            $citeMla     = "{$citeAuthors}. {$citeTitle}. {$citePublisher}, {$citeYear}.";
                            $citeChicago = "{$citeAuthors}. {$citeTitle}. " . ($citeCity ? "{$citeCity}: " : "") . "{$citePublisher}, {$citeYear}.";
                            $citeHarvard = "{$citeAuthors}, {$citeYear}. {$citeTitle}. " . ($citeCity ? "{$citeCity}: " : "") . "{$citePublisher}.";
                        @endphp
                        <div class="tab-pane fade" id="cite" role="tabpanel" aria-labelledby="cite-tab">
                            <div class="mb-3">
                                <label for="citation_style_select" class="form-label" style="font-size: 13px; font-weight: 700; color: var(--text-muted);">Pilih Format Sitasi:</label>
                                <select class="form-select" id="citation_style_select" style="border-radius: 8px; border: 1px solid var(--border-color); font-size: 13.5px; padding: 8px 12px;">
                                    <option value="apa">APA Style</option>
                                    <option value="mla">MLA Style</option>
                                    <option value="chicago">Chicago Style</option>
                                    <option value="harvard">Harvard Style</option>
                                </select>
                            </div>

                            <div class="position-relative mb-3">
                                <textarea id="citation_text" class="form-control" rows="3" readonly style="font-size: 13.5px; background: var(--ivory-bg); border-radius: 8px; color: var(--text-main);">{{ $citeApa }}</textarea>
                                <button class="btn-gold mt-2 w-100" type="button" onclick="copyCitation()" style="min-height: 38px; font-size: 13px;">
                                    <iconify-icon icon="solar:copy-bold-duotone" class="me-1" style="font-size: 16px; vertical-align: middle;"></iconify-icon> Salin Teks Sitasi
                                </button>
                            </div>

                            <div id="citation-data" data-apa="{{ $citeApa }}" data-mla="{{ $citeMla }}" data-chicago="{{ $citeChicago }}" data-harvard="{{ $citeHarvard }}"></div>

                            <div class="pt-3 border-top d-flex gap-2 flex-wrap" style="border-color: var(--border-color) !important;">
                                <a href="{{ route('shop.cite.bibtex', $product->slug) }}" class="btn-outline-navy" style="min-height: 36px; font-size: 12px; padding: 0 14px;">
                                    <iconify-icon icon="solar:download-bold-duotone" class="me-1" style="font-size: 16px; vertical-align: middle;"></iconify-icon> Unduh BibTeX
                                </a>
                                <a href="{{ route('shop.cite.ris', $product->slug) }}" class="btn-outline-navy" style="min-height: 36px; font-size: 12px; padding: 0 14px;">
                                    <iconify-icon icon="solar:download-bold-duotone" class="me-1" style="font-size: 16px; vertical-align: middle;"></iconify-icon> RIS (Mendeley / Zotero)
                                </a>
                            </div>

                            <script>
                                document.getElementById('citation_style_select').addEventListener('change', function() {
                                    const dataEl = document.getElementById('citation-data');
                                    if (dataEl) {
                                        const style = this.value;
                                        let text = '';
                                        if (style === 'apa') text = dataEl.getAttribute('data-apa');
                                        else if (style === 'mla') text = dataEl.getAttribute('data-mla');
                                        else if (style === 'chicago') text = dataEl.getAttribute('data-chicago');
                                        else if (style === 'harvard') text = dataEl.getAttribute('data-harvard');
                                        
                                        document.getElementById('citation_text').value = text;
                                    }
                                });
                                
                                function copyCitation() {
                                    var copyText = document.getElementById("citation_text");
                                    copyText.select();
                                    copyText.setSelectionRange(0, 99999);
                                    navigator.clipboard.writeText(copyText.value);
                                    alert("Sitasi berhasil disalin!");
                                }
                            </script>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- RELATED PRODUCTS SECTION -->
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<div class="section py-5" style="background: var(--sand-accent);">
    <div class="container">
        <div class="mb-4">
            <span class="eyebrow">KATALOG LAINNYA</span>
            <h3 class="section-title" style="font-size: 22px; font-weight: 800;">Publikasi & Buku Terkait</h3>
        </div>

        <div class="row g-4">
            @foreach($relatedProducts as $relProduct)
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="rbt-default-card style-three rbt-hover h-100 d-flex flex-column" style="padding: 20px; border-radius: var(--radius-md); background: var(--card-bg); border: 1px solid var(--border-color);">
                    <div class="inner d-flex flex-column flex-grow-1">
                        <div class="thumbnail mb-3">
                            <a href="{{ route('shop.show', $relProduct->slug) }}">
                                @if($relProduct->image)
                                    <img src="{{ asset('storage/' . $relProduct->image) }}" alt="{{ $relProduct->name }}" style="width: 100%; height: 200px; object-fit: contain; border-radius: var(--radius-sm);">
                                @else
                                    <img src="{{ asset('frontend/assets/images/product/1.jpg') }}" alt="{{ $relProduct->name }}" style="width: 100%; height: 200px; object-fit: contain; border-radius: var(--radius-sm);">
                                @endif
                            </a>
                        </div>
                        <div class="content pt--0 pb--10 flex-grow-1">
                            <h4 class="title" style="font-family: var(--font-body); font-size: 15px; font-weight: 700; line-height: 1.4; margin-bottom: 8px;">
                                <a href="{{ route('shop.show', $relProduct->slug) }}" style="color: var(--text-main); text-decoration: none;">{{ $relProduct->name }}</a>
                            </h4>
                        </div>
                        <div class="content mt-auto pt-3 border-top" style="border-color: var(--border-color) !important;">
                            <div class="rbt-price justify-content-center mb-3">
                                @if($relProduct->discount_price > 0 && $relProduct->discount_price < $relProduct->price)
                                    <span class="current-price theme-gradient" style="font-size: 17px; font-weight: 800;">Rp {{ number_format($relProduct->discount_price, 0, ',', '.') }}</span>
                                    <span class="off-price text-muted ms-2" style="font-size: 13px; text-decoration: line-through;">Rp {{ number_format($relProduct->price, 0, ',', '.') }}</span>
                                @else
                                    <span class="current-price theme-gradient" style="font-size: 17px; font-weight: 800;">Rp {{ number_format($relProduct->price, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            <div class="addto-cart-btn text-center">
                                <a class="btn-gold w-100" style="min-height: 40px; font-size: 13.5px; padding: 0 16px;" href="{{ route('shop.show', $relProduct->slug) }}">
                                    Lihat Detail
                                    <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-1" style="vertical-align: middle;"></iconify-icon>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection