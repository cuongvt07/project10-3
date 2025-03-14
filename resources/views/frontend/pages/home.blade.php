@extends('frontend.layout')

@section('content')
@include('frontend.note')
<!-- Start Slider Area -->
<div class="slider__container slider--one bg__cat--3">
    <div class="slide__container slider__activation__wrap owl-carousel">
        @foreach ($dataSilde as $slide)
        <!-- Start Single Slide -->
        <div class="single__slide animation__style01 slider__fixed--height">
            <div class="slide__thumb">
                <img src="{{$slide->image}}"
                    alt="slider images VINANEON">
            </div>
        </div>
        <!-- End Single Slide -->
        @endforeach
    </div>
</div>
<!-- Start Slider Area -->
<!-- Start Product new Area -->
<div class="block_strengths strengths-_strengths strengths_0 block" id="block_id_182">
    <div class="strengths_block_default">
        <div class="item">
            <div class="svg">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M16 25C20.9706 25 25 20.9706 25 16C25 11.0294 20.9706 7 16 7C11.0294 7 7 11.0294 7 16C7 20.9706 11.0294 25 16 25Z" fill="white" stroke="white" stroke-width="2" stroke-miterlimit="10"></path>
                    <path d="M16 11V16H21" stroke="#FDAF17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M11 8.51597L11.851 3.82162C11.8928 3.5911 12.0142 3.38257 12.1941 3.23241C12.3739 3.08225 12.6007 3 12.835 3H19.165C19.3993 3 19.6261 3.08225 19.8059 3.23241C19.9858 3.38257 20.1072 3.5911 20.149 3.82162L21 8.516" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M11 23.484L11.851 28.1784C11.8928 28.4089 12.0142 28.6174 12.1941 28.7676C12.3739 28.9178 12.6007 29 12.835 29H19.165C19.3993 29 19.6261 28.9178 19.8059 28.7676C19.9858 28.6174 20.1072 28.4089 20.149 28.1784L21 23.484" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>
            <div class="content-right">
                <div class="title_ctn">Mẫu mã đa dạng nhất</div>
                <p>Hoàn tiền nếu phát hiện bán hàng giả</p>
            </div>
        </div>
        <div class="item">
            <div class="svg">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M5.72973 26.1991L5.71678 26.2834L10.8086 22.7549L10.8679 22.7747C10.8679 22.7747 10.8679 22.7747 10.8679 22.7747C10.9465 22.5388 11.1157 22.3438 11.3381 22.2326C11.5605 22.1214 11.8179 22.1031 12.0538 22.1817C12.2897 22.2603 12.4847 22.4295 12.5959 22.6519C12.7071 22.8742 12.7254 23.1317 12.6468 23.3676C11.9723 25.3906 10.3649 26.8805 7.98801 27.6728C6.92122 28.0255 5.80861 28.2204 4.68545 28.2512C4.43711 28.251 4.199 28.1523 4.02338 27.9766C3.84777 27.801 3.74902 27.5629 3.74878 27.3146C3.77965 26.1914 3.97453 25.0788 4.32725 24.012C5.1196 21.6351 6.60939 20.0276 8.63244 19.3533L8.63248 19.3532C8.7493 19.3142 8.87266 19.2986 8.99553 19.3073C9.11839 19.3159 9.23834 19.3487 9.34853 19.4038C9.45871 19.4588 9.55697 19.535 9.63769 19.628C9.71841 19.7211 9.78001 19.8291 9.81896 19.9459C9.85792 20.0628 9.87347 20.1862 9.86472 20.309C9.85598 20.4319 9.82311 20.5518 9.768 20.662C9.71289 20.7721 9.63661 20.8703 9.54353 20.951C9.45044 21.0317 9.34238 21.0932 9.22551 21.1321L9.22548 21.1321C7.97783 21.5479 7.16244 22.4328 6.63035 23.4029C6.09865 24.3723 5.84799 25.4298 5.72973 26.1991Z" fill="white" stroke="white" stroke-width="0.125"></path>
                    <path d="M28.4514 5.22757C28.3899 4.80408 28.1932 4.4118 27.8906 4.10922C27.588 3.80664 27.1957 3.60995 26.7722 3.54849C25.3615 3.33798 21.6946 3.23434 18.1211 6.80765L16.9998 7.92898H9.34302C9.08027 7.92829 8.81998 7.9797 8.57722 8.08024C8.33446 8.18079 8.11404 8.32846 7.92872 8.51473L3.88599 12.5575C3.63004 12.8135 3.44836 13.1342 3.36033 13.4853C3.2723 13.8364 3.28122 14.2048 3.38613 14.5513C3.49104 14.8978 3.68802 15.2092 3.95605 15.4525C4.22408 15.6958 4.55312 15.8618 4.90809 15.9328L9.84995 16.9212L15.0787 22.1499L16.067 27.0918C16.1379 27.4469 16.3039 27.776 16.5472 28.0441C16.7905 28.3122 17.102 28.5093 17.4486 28.6142C17.7951 28.7191 18.1636 28.728 18.5148 28.6398C18.8659 28.5517 19.1866 28.3699 19.4425 28.1138L23.4852 24.071C23.6715 23.8857 23.8192 23.6653 23.9197 23.4226C24.0203 23.1799 24.0716 22.9196 24.0709 22.6569V15L25.1923 13.8787C28.7658 10.3052 28.662 6.63833 28.4514 5.22757ZM9.34302 9.92898H14.9998L10.0143 14.9145L5.3003 13.9717L9.34302 9.92898ZM22.0709 22.6569L18.0282 26.6996L17.0854 21.9856L22.0709 17.0001L22.0709 22.6569Z" fill="white"></path>
                </svg>
            </div>
            <div class="content-right">
                <div class="title_ctn">Miễn phí vận chuyển</div>
                <p>Giao hàng nhanh, đóng gói cẩn thận</p>
            </div>
        </div>
        <div class="item">
            <div class="svg">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M24 7.06252H24.0625V7.00002V5.00002C24.0625 4.81459 24.1175 4.63333 24.2205 4.47915C24.3236 4.32498 24.47 4.20481 24.6413 4.13386C24.8126 4.0629 25.0011 4.04434 25.183 4.08052C25.3648 4.1167 25.5319 4.206 25.663 4.33712L25.7071 4.29301L25.663 4.33712L28.663 7.33712C28.8388 7.51293 28.9376 7.75138 28.9376 8.00002C28.9376 8.24865 28.8388 8.4871 28.663 8.66291L25.663 11.6629C25.5319 11.794 25.3648 11.8833 25.183 11.9195C25.0011 11.9557 24.8126 11.9371 24.6413 11.8662C24.47 11.7952 24.3236 11.6751 24.2205 11.5209C24.1175 11.3667 24.0625 11.1854 24.0625 11V9.00002V8.93752H24H12H12C10.1275 8.93963 8.33241 9.68438 7.0084 11.0084C5.6844 12.3324 4.93964 14.1275 4.93753 15.9999V16C4.93753 16.2487 4.83876 16.4871 4.66295 16.6629C4.48713 16.8387 4.24867 16.9375 4.00003 16.9375C3.75139 16.9375 3.51294 16.8387 3.33712 16.6629C3.16131 16.4871 3.06254 16.2487 3.06253 16.0001C3.06521 13.6305 4.0077 11.3588 5.68323 9.68322C7.35878 8.00768 9.63053 7.06518 12.0001 7.06252H24ZM20 23.0625H20.0001C21.8725 23.0604 23.6677 22.3157 24.9917 20.9916C26.3157 19.6676 27.0604 17.8725 27.0625 16.0001V16C27.0625 15.7514 27.1613 15.5129 27.3371 15.3371C27.5129 15.1613 27.7514 15.0625 28 15.0625C28.2487 15.0625 28.4871 15.1613 28.6629 15.3371C28.8387 15.5129 28.9375 15.7513 28.9375 15.9999C28.9349 18.3695 27.9924 20.6413 26.3168 22.3168C24.6413 23.9924 22.3695 24.9348 20 24.9375H8.00003H7.93753V25V27C7.93753 27.1854 7.88255 27.3667 7.77953 27.5209C7.67651 27.6751 7.53009 27.7952 7.35878 27.8662C7.18746 27.9371 6.99896 27.9557 6.8171 27.9195C6.63523 27.8833 6.46819 27.794 6.33707 27.6629L3.33707 24.6629C3.16127 24.4871 3.0625 24.2486 3.0625 24C3.0625 23.7514 3.16127 23.5129 3.33707 23.3371L6.33707 20.3371C6.46819 20.206 6.63523 20.1167 6.8171 20.0805C6.99896 20.0443 7.18746 20.0629 7.35878 20.1339C7.53009 20.2048 7.67651 20.325 7.77953 20.4792C7.88255 20.6333 7.93753 20.8146 7.93753 21V23V23.0625H8.00003H20Z" fill="white" stroke="white" stroke-width="0.125"></path>
                </svg>
            </div>
            <div class="content-right">
                <div class="title_ctn">Đổi hàng 7 ngày</div>
                <p>1 đổi 1 trong 7 ngày với sản phẩm lỗi</p>
            </div>
        </div>
        <div class="item">
            <div class="svg">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M15.3991 29.7943L15.3987 29.7942C13.5007 29.1654 4.06262 25.4711 4.06262 14.333V7.00004C4.0633 6.48638 4.26765 5.99396 4.63086 5.63074C4.99409 5.26752 5.48653 5.06317 6.0002 5.0625L26.0001 5.0625C26.5137 5.06318 27.0062 5.26753 27.3694 5.63074C27.7326 5.99396 27.937 6.48641 27.9376 7.00008V14.333C27.9376 25.472 18.4985 29.1654 16.6016 29.7942L16.6011 29.7943C16.2114 29.9266 15.7889 29.9266 15.3991 29.7943ZM22.3322 13.6611C22.3885 13.5904 22.4357 13.5126 22.4724 13.4296C22.529 13.302 22.5598 13.1644 22.5631 13.0248C22.5665 12.8852 22.5423 12.7463 22.4919 12.6161C22.4415 12.4859 22.366 12.3668 22.2696 12.2658C22.1732 12.1648 22.0579 12.0837 21.9302 12.0273C21.8024 11.9709 21.6648 11.9402 21.5252 11.937C21.3856 11.9338 21.2468 11.9581 21.1166 12.0086C20.9864 12.0591 20.8674 12.1347 20.7665 12.2312L14.1661 18.5308L11.2337 15.7312C11.2337 15.7312 11.2337 15.7312 11.2337 15.7312C11.1328 15.6347 11.0138 15.5591 10.8836 15.5086C10.7535 15.4581 10.6146 15.4338 10.475 15.437C10.3354 15.4402 10.1978 15.4709 10.0701 15.5273C9.94236 15.5837 9.82701 15.6648 9.73062 15.7658C9.63423 15.8668 9.55869 15.9859 9.50833 16.1161C9.45797 16.2463 9.43377 16.3852 9.43711 16.5248C9.44045 16.6644 9.47127 16.802 9.5278 16.9296C9.58433 17.0573 9.66548 17.1726 9.76659 17.2689L13.4325 20.7688L13.4326 20.7689C13.6303 20.9574 13.893 21.0625 14.1661 21.0625C14.4393 21.0625 14.702 20.9574 14.8997 20.7689L14.8997 20.7688L22.2337 13.7688L22.3466 13.6611H22.3322Z" fill="white" stroke="white" stroke-width="0.125"></path>
                </svg>
            </div>
            <div class="content-right">
                <div class="title_ctn">Bảo hành 5 năm</div>
                <p>Thụ tục nhanh gọn, thay pin miễn phí</p>
            </div>
        </div>
        <div class="item">
            <div class="svg">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M6.80761 25.1924C5.65711 24.0419 6.42019 21.6265 5.8346 20.2111C5.22755 18.744 3 17.5631 3 16C3 14.4368 5.22756 13.256 5.8346 11.7888C6.4202 10.3735 5.65711 7.95811 6.80761 6.80761C7.95811 5.65711 10.3735 6.42019 11.7889 5.8346C13.256 5.22755 14.4369 3 16 3C17.5632 3 18.744 5.22756 20.2112 5.8346C21.6265 6.4202 24.0419 5.65711 25.1924 6.80761C26.3429 7.95811 25.5798 10.3735 26.1654 11.7889C26.7725 13.256 29 14.4369 29 16C29 17.5632 26.7724 18.744 26.1654 20.2112C25.5798 21.6265 26.3429 24.0419 25.1924 25.1924C24.0419 26.3429 21.6265 25.5798 20.2111 26.1654C18.744 26.7725 17.5631 29 16 29C14.4368 29 13.256 26.7724 11.7888 26.1654C10.3735 25.5798 7.95811 26.3429 6.80761 25.1924Z" fill="white" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M21.5 13L14.1666 20L10.5 16.5" stroke="#EBB039" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>
            <div class="content-right">
                <div class="title_ctn">Đeo trước trả sau</div>
                <p>Trả trước 1 phần, 2 phần còn lại trả sau</p>
            </div>
        </div>
    </div>
</div>
<section class="htc__category__area ptb--40">
    <div class="container product-container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section__title--2 text-center">
                    <h2 class="title__line">
                        <a>FLASH SALE</a>
                    </h2>
                    <img class="img-title"src="https://www.watchstore.vn/images/block/compress/banner-xu-huong-home_1733460990.webp" alt="">
                </div>
            </div>
        </div>
        <div class="htc__product__container">
            <!-- Owl Carousel wrapper -->
            <div class="owl-carousel product__list mt--30 mb--20" style="height: auto;">
                @foreach ($dataProductSales as $item)
                    <div class="item" style="height: 390px;">
                        @include('frontend.libs.product')
                    </div>
                @endforeach
            </div>
            <div class="vmore mt--40"><a href="/shop">Xem thêm sản phẩm</a></div>
        </div>
    </div>
</section>
<!-- End Product new Area -->
<!-- Start Banner Area -->
@if ($dataBanner)
<section class="htc__category__area">
    <div class="container-fluid" style="padding: 0;">
        <center>
            @if ($dataBanner->count() == 1)
            @foreach ($dataBanner as $banner)
            <a href="{{ $banner->target }}">
                <img src="{{ $banner->image }}" alt="{{ $banner->title }}" style="max-width: 100%; width: 100%;">
            </a>
            @endforeach
            @elseif ($dataBanner->count() == 2)
            <div class="banner-ngang">
                @foreach ($dataBanner as $banner)
                <a href="{{ $banner->target }}" class="banner-item">
                    <img src="{{ $banner->image }}" alt="{{ $banner->title }}" style="max-width: 100%;">
                </a>
                @endforeach
            </div>
            @endif
        </center>
    </div>
</section>
@endif
<!-- End Banner Area -->
<!-- Start Product sale Area -->
<section class="htc__category__area ptb--40">
    <div class="container product-container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section__title--2 text-center">
                    <h2 class="title__line">
                        <a>SẢN PHẨM MỚI</a>
                    </h2>
                    <img class="img-title" src="https://www.titanwatches.vn/cdn/shop/files/Edge-Hero-Banner-1920px_x_640px_-_Desktop.png?v=1729497478&width=1900" alt="">
                </div>
            </div>
        </div>
        <div class="htc__product__container">
            <!-- Owl Carousel wrapper -->
            <div class="owl-carousel product__list mt--30 mb--20" style="height: auto;">
                @foreach ($dataProductNews as $item)
                    <div class="item" style="height: 390px;">
                        @include('frontend.libs.product')
                    </div>
                @endforeach
            </div>
            <div class="vmore mt--40"><a href="/shop">Xem thêm sản phẩm</a></div>
        </div>
    </div>
</section>
<!-- End Product sale Area -->
<!-- Start Comment Area -->
<section class="home-testimonial">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center testimonial-pos">
            <div class="col-12 text-center">
                <div class="section__title--2">
                    <h2 class="title__line">
                        <a>Bình luận về sản phẩm</a>
                    </h2>
                </div>
            </div>
        </div>
        <section class="home-testimonial-bottom">
            <div class="container testimonial-inner">
                <div class="owl-carousel product-review-slider">
                    @foreach($dataComment as $item)
                    <div class="item">
                        <div class="tour-item">
                            <div class="tour-desc bg-white" style="height: 200px">
                                <div class="link-name text-center">
                                    {{ $item->user->user_name === "admin" 
                                                    ? collect(['John Doe', 'Jane Smith', 'Alice Johnson', 'Bob Brown'])->random() 
                                                    : $item->user->user_name }}
                                </div>
                                <div class="row justify-content-center pt-2 pb-2">
                                    <div class="col-md-6 col-sm-8 col-12">
                                        <img class="tm-people img-fluid" src="{{ $item->product->product_image }}" alt="">
                                    </div>
                                </div>
                                <div class="tour-text color-grey-3">
                                    &ldquo;{{ $item->comment_customer }}&ldquo;
                                </div>
                                <br>
                                <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" id="star{{ $item->id }}-{{ $i }}" name="rating_{{ $item->id }}" value="{{ $i }}"
                                        @if($i==$item->comment_rating) checked @endif />
                                        <label for="star{{ $item->id }}-{{ $i }}" title="{{ $i }} star"
                                            style="color: @if($i <= $item->comment_rating) yellow @else gray @endif;"></label>
                                        @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</section>
<!-- End Comment Area -->
<!-- Start Top Rated Area -->
@if ($dataProductSell != null)
<section class="htc__category__area ptb--40">
    <div class="container product-container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section__title--2 text-center">
                    <h2 class="title__line">
                        <a>SẢN PHẨM BÁN CHẠY</a>
                    </h2>
                    <img class="img-title" src="https://dongho24h.com/upload/1/resources/l_1446199005_Seiko-5-sports.jpg" alt="">
                </div>
            </div>
        </div>
        <div class="htc__product__container">
            <!-- Owl Carousel wrapper -->
            <div class="owl-carousel product__list mt--30 mb--20" style="height: auto;">
                @foreach ($dataProductSell as $item)
                    <div class="item" style="height: 390px;">
                        @include('frontend.libs.product')
                    </div>
                @endforeach
            </div>
            <div class="vmore mt--40"><a href="/shop">Xem thêm sản phẩm</a></div>
        </div>
    </div>
</section>
@endif
<!-- End Top Rated Area -->
<!-- Start Blog Area -->
<section class="htc__category__area ptb--40">
    <div class="container product-container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section__title--2 text-center">
                    <h2 class="title__line">
                        <a>TIN TỨC</a>
                    </h2>
                </div>
            </div>
        </div>
        <div class="htc__product__container">
            <!-- Owl Carousel wrapper -->
            <div class="owl-carousel product__list mt--30 mb--20" style="height: auto;">
                @foreach ($dataPost as $item)
                <div class="=product" style="height: 390px">
                    <div class="category">
                        <div class="ht__cat__thumb">
                            <span class="sale-span">New</span>
                            <a href="/blog/{{$item->id}}-{{Str::slug($item->post_title, '-')}}.html">
                                <img style="max-width: 260px; height: 260px" src="{{$item->post_image}}"
                                    alt="{{$item->post_title}}">
                            </a>
                        </div>
                        <div class="fr__product__inner" style="margin-top: -15px">
                            <ul class="fr__pro__prize">
                                <li><a style="font-size: 10px"
                                        href="/shop/blog/{{$item->id}}-{{Str::slug($item->post_title, '-')}}.html">Ngày
                                        đăng:
                                        @php
                                        $old_date = strtotime($item->created_at);
                                        $new_date = date('d/m/Y', $old_date);
                                        echo $new_date
                                        @endphp
                                    </a></li>
                            </ul>
                            <h4><a href="/blog/{{$item->id}}-{{Str::slug($item->post_title, '-')}}.html"><i
                                        style="
                                        max-width: 250px;
                                        height: 40px;
                                        line-height: 20px;
                                        word-break: break-all;
                                        display: -webkit-box;
                                        -webkit-box-orient: vertical;
                                        -moz-box-orient: vertical;
                                        -ms-box-orient: vertical;
                                        box-orient: vertical;
                                        -webkit-line-clamp: 2;
                                        -moz-line-clamp: 2;
                                        -ms-line-clamp: 2;
                                        line-clamp: 2;
                                        overflow: hidden;
                                        ">{{$item->post_title}}</i></a></h4>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- End Blog Area -->
<section class="order-process custom-order-process">
    <div class="container">
        <h2>Quy trình đặt hàng tại Rolex Shop</h2>
        <div class="process-steps">
            <div class="step">
                <div class="step-icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <p>Bước 1: Đặt hàng</p>
            </div>
            <div class="step">
                <div class="step-icon">
                    <i class="fa fa-check"></i>
                </div>
                <p>Bước 2: Xác nhận</p>
            </div>
            <div class="step">
                <div class="step-icon">
                    <i class="fa fa-truck"></i>
                </div>
                <p>Bước 3: Vận chuyển</p>
            </div>
            <div class="step">
                <div class="step-icon">
                    <i class="fa fa-envelope"></i>
                </div>
                <p>Bước 4: Giao hàng</p>
            </div>
            <div class="step">
                <div class="step-icon">
                    <i class="fa fa-check-circle"></i>
                </div>
                <p>Bước 5: Hoàn thành</p>
            </div>
        </div>
    </div>
</section>
<section class="order-with-us">
    <div class="info-container">
        <div class="info-column">
            <div class="icon-box order-icon-box">
                <div class="icon">&#x1F6D2;</div>
                <h3 class="order-heading">Đặt Hàng 24/7</h3>
                <p class="order-contact">********8</p>
            </div>
        </div>

        <div class="info-column delivery-column">
            <div class="icon">&#x1F69A;</div>
            <h3 class="delivery-heading">Giao Hàng Tận Nơi
                <br>Nhanh Chóng - An Toàn - Tin Cậy
            </h3>
        </div>

        <div class="info-column">
            <div class="icon-box email-icon-box">
                <div class="icon">&#x1F4E7;</div>
                <h3 class="email-heading">Email</h3>
                <p class="email-contact">*****@gmail.com</p>
            </div>
        </div>
    </div>
    </div>
</section>

@endsection

@section('script')
<script>
    $('.add_to_cart').click(function() {
        var id = $(this).data('id');
        var type = 'add-to-cart';
        var _token = $('input[name=_token]').val();
        var cart_product = $('.cart_product_' + id).val();
        var cart_price = $('.cart_price_' + id).val();
        var cart_price_sale = $('.cart_price_sale_' + id).val();
        var cart_amount = $('.cart_amount_' + id).val();
        var cart_quantity = $('.cart_quantity_' + id).val();
        var cart_image = $('.cart_image_' + id).val();
        var cart_brand = $('.cart_brand_' + id).val();

        $.ajax({
            url: 'add_to_cart',
            method: 'POST',
            data: {
                _token: _token,
                cart_id: id,
                type: type,
                cart_product: cart_product,
                cart_price: cart_price,
                cart_price_sale: cart_price_sale,
                cart_amount: cart_amount,
                cart_quantity: cart_quantity,
                cart_image: cart_image,
                cart_brand: cart_brand,

            },
            success: function(data) {
                //
                Swal.fire(data)
                //
            }
        })

    })

    $('.handle_wishlist').click(function() {
        var product_id = $(this).data('product_id');
        var _token = $('input[name=_token]').val();

        $.ajax({
            url: 'handle-wishlist',
            method: 'POST',
            data: {
                _token: _token,
                product_id: product_id,
            },
            success: function(data) {
                Swal.fire(data)
            }
        })
    })
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endsection