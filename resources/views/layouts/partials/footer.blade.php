<!-- ========== Footer Start ========== -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <script>document.write(new Date().getFullYear())</script> &copy; {{ $settings['footer_copyright'] ?? 'Larkon' }}. 
                @if(!empty($settings['credit_text']))
                Crafted by
                <iconify-icon icon="iconamoon:heart-duotone" class="fs-18 align-middle text-danger"></iconify-icon>
                <a href="{{ $settings['credit_link'] ?? '#' }}" class="fw-bold footer-text" target="_blank">{{ $settings['credit_text'] }}</a>
                @endif
            </div>
        </div>
    </div>
</footer>
<!-- ========== Footer End ========== -->
