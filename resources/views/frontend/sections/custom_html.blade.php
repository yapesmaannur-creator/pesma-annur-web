{{-- Custom HTML Section --}}
@if($section->content)
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if($section->title || $section->subtitle)
                <div class="center mb--30">
                    @if($section->subtitle)
                    <span class="eyebrow">{{ $section->subtitle }}</span>
                    @endif
                    @if($section->title)
                    <h2 class="section-title">{!! $section->title !!}</h2>
                    @endif
                </div>
                @endif
                <div class="post-content">
                    {!! $section->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endif
