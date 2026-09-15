{{-- FAQ Section - Modern Executive Navy Redesign --}}
<style>
    .annur-faq-card {
        background: var(--card-bg);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        margin-bottom: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .annur-faq-card .accordion-button {
        background: transparent !important;
        color: var(--text-main) !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-size: 16px !important;
        font-weight: 700 !important;
        padding: 18px 24px !important;
        box-shadow: none !important;
    }
    .annur-faq-card .accordion-button:not(.collapsed) {
        color: var(--gold-primary) !important;
        border-bottom: 1px solid var(--border-color);
    }
    .annur-faq-card .accordion-body {
        font-size: 14.5px !important;
        color: var(--text-main) !important;
        line-height: 1.7 !important;
        padding: 20px 24px !important;
    }
</style>

<div class="section py-5" style="background: var(--ivory-bg);">
    <div class="container py-3">
        <div class="row g-5 align-items-center">
            <!-- LEFT COLUMN: ACCORDION LIST -->
            <div class="col-lg-6">
                <div class="mb-4">
                    <span class="eyebrow mb-2" style="background: rgba(201, 162, 39, 0.1); padding: 5px 16px; border-radius: 50px; border: 1px solid rgba(201, 162, 39, 0.25);">
                        {{ strtoupper($section->subtitle ?? 'PERTANYAAN POPULER') }}
                    </span>
                    <h2 class="section-title mt-2" style="font-size: 32px; font-weight: 800; letter-spacing: -0.02em;">
                        {!! $section->title ?? 'Pertanyaan Sering Diajukan (FAQ)' !!}
                    </h2>
                </div>

                <div class="accordion" id="accordionExample{{ $section->id }}">
                    @php
                       $faqs = [];
                       if (class_exists('\App\Models\Faq')) {
                           $faqs = \App\Models\Faq::where('is_active', true)->orderBy('order', 'asc')->get();
                       }
                    @endphp

                    @forelse($faqs as $index => $faq)
                    <div class="annur-faq-card">
                        <h2 class="accordion-header" id="heading{{ $faq->id }}">
                            <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $faq->id }}">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordionExample{{ $section->id }}">
                            <div class="accordion-body">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="annur-faq-card">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Bagaimana cara pendaftaran santri baru Pesma An-Nur?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample{{ $section->id }}">
                            <div class="accordion-body">
                                Pendaftaran dapat dilakukan secara online melalui website resmi atau langsung menghubungi sekretariat pendaftaran.
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- RIGHT COLUMN: FAQ IMAGE -->
            <div class="col-lg-6">
                <div class="p-3" style="background: var(--card-bg); border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
                    <div class="overflow-hidden d-flex align-items-center justify-content-center p-2" style="border-radius: var(--radius-md); background: linear-gradient(135deg, rgba(201,162,39,0.06) 0%, rgba(11,31,58,0.06) 100%); min-height: 380px;">
                        @if($section->image)
                            <img src="{{ asset('storage/' . $section->image) }}" alt="FAQ Pesma An-Nur" style="width: 100%; height: auto; max-height: 480px; object-fit: contain; border-radius: var(--radius-md);">
                        @else
                            <div class="text-center px-4 py-5" style="width:100%;">
                                <iconify-icon icon="solar:question-circle-bold-duotone" style="font-size: 96px; color: var(--gold-primary); opacity: 0.7;"></iconify-icon>
                                <p class="mt-3 mb-0" style="font-size: 15px; color: var(--text-muted); font-weight: 600;">Pertanyaan Umum Pesma An-Nur</p>
                                <p style="font-size: 13px; color: var(--text-muted); margin-top: 6px;">Temukan jawaban atas pertanyaan Anda seputar pendaftaran, fasilitas, dan kehidupan di pesantren.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>