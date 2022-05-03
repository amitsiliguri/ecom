<x-ecommerce::layouts.guest>
    <!-- Slider main container -->
    <div class="swiper" id="banner-swiper">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="swiper-slide">
                <img src="{{asset('image/1.png')}}">
            </div>
            <div class="swiper-slide">
                <img src="{{asset('image/2.png')}}">
            </div>
            <div class="swiper-slide">
                <img src="{{asset('image/3.png')}}">
            </div>
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <!-- If we need scrollbar -->
        <div class="swiper-scrollbar"></div>
    </div>
</x-ecommerce::layouts.guest>
