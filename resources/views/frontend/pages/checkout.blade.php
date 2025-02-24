@extends('frontend.layout')

@section('content')
<!-- cart-main-area start -->
<div class="checkout-wrap ptb--100">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="checkout__inner">
                    <div class="accordion-list">
                        <div class="accordion">
                            <div class="accordion__title ">
                                Thông Tin Đặt Hàng
                            </div>

                            <div class="accordion__body">
                                <div class="bilinfo">
                                    <div class="row">
                                        <form id="paymentForm" action="/payment" method="POST">
                                            @csrf
                                            <div class="col-md-12">
                                                <div class="single-input">
                                                    <select name="city_id" id="city_id">
                                                        <option>Tỉnh/Thành Phố</option>
                                                        @foreach ($dataCity as $item)
                                                        <option value="{{$item->city_id}}"
                                                            @if ($item->city_id == $dataUser->user_city)
                                                            selected
                                                            @endif
                                                            >{{$item->city_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="city_id" id="hidden_city_id" value="{{$dataUser->user_city}}">
                                                    @error('city_id')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="single-input">
                                                    <select name="district_id" id="district_id">
                                                        <option>Quận Huyện</option>
                                                        @if ($dataUser->user_district != null)
                                                        <option value="{{$dataUser->user_district}}" selected>{{$dataUser->District->district_name}}</option>
                                                        @endif
                                                    </select>
                                                    <input type="hidden" name="district_id" id="hidden_district_id" value="{{$dataUser->user_district}}">
                                                    @error('district_id')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="single-input">
                                                    <input type="text" name="order_name" value="{{$dataUser->user_name}}" placeholder="Họ Tên">
                                                    @error('order_name')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-input">
                                                    <input type="email" name="order_email" value="{{$dataUser->user_email}}" placeholder="Email">
                                                    @error('order_email')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-input">
                                                    <input type="text" name="order_phone" value="{{$dataUser->user_phone}}" placeholder="Số điện thoại">
                                                    @error('order_phone')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-input">
                                                    <input type="text" name="order_address" value="{{$dataUser->user_address}}" placeholder="Địa chỉ chi tiết">
                                                    @error('order_address')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-input">
                                                    <input type="text" name="order_note" placeholder="Lời nhắn">
                                                </div>
                                            </div>

                                            <!-- Payment Options -->
                                            <div class="row text-center">
                                                <div class="col-md-9" style="margin-top: 5px">
                                                    <div class="col-3 col-sm-3 text-center">
                                                        <label for="paymentCash" class="payment-option" onclick="selectPaymentOption(event)">
                                                            <div class="image-container">
                                                                <img src="https://nascoexpress.com/getattachment/b8a25cce-6779-4eda-9409-f7912ee05660/dich-vu-cod-tai-nasco-express-(1).jpg.html" alt="Cash Payment" class="img-fluid">
                                                            </div>
                                                            Thanh toán khi nhận hàng
                                                        </label>
                                                        <input class="type_payment" type="radio" id="paymentCash" name="order_pay_type" value="1" required>
                                                    </div>
                                                    <div class="col-3 col-sm-3">
                                                        <label for="paymentVNPAY" class="payment-option" onclick="selectPaymentOption(event)">
                                                            <div class="image-container">
                                                                <img src="https://play-lh.googleusercontent.com/o-_z132f10zwrco4NXk4sFqmGylqXBjfcwR8-wK0lO1Wk4gzRXi4IZJdhwVlEAtpyQ=w240-h480-rw" alt="VNPay" class="img-fluid">
                                                            </div>
                                                            Thanh toán qua VNPay
                                                        </label>
                                                        <input class="type_payment" type="radio" id="paymentVNPAY" name="order_pay_type" value="2" required>
                                                    </div>
                                                    <div class="col-3 col-sm-3">
                                                        <label for="paymentMomo" class="payment-option" onclick="selectPaymentOption(event)">
                                                            <div class="image-container">
                                                                <img src="https://play-lh.googleusercontent.com/dQbjuW6Jrwzavx7UCwvGzA_sleZe3-Km1KISpMLGVf1Be5N6hN6-tdKxE5RDQvOiGRg=w240-h480-rw" alt="MoMo" class="img-fluid">
                                                            </div>
                                                            Thanh toán qua MoMo
                                                        </label>
                                                        <input class="type_payment" type="radio" id="paymentMomo" name="order_pay_type" value="3" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="order-details">
                    <h5 class="order-details__title">Hóa Đơn Mua Hàng</h5>
                    <div class="order-details__item">
                        @foreach ($cart as $item)
                        <div class="single-item">
                            <div class="single-item__thumb">
                                <img src="{{$item['cart_image']}}" alt="ordered item">
                            </div>
                            <div class="single-item__content">
                                <a href="/shop/product/{{$item['cart_id']}}-{{Str::slug($item['cart_product'], '-')}}.html">{{$item['cart_product']}}
                                    x{{$item['cart_quantity']}}</a>
                                <span class="price">{{number_format($item['cart_price_sale'])}} - {{ \App\Helpers\CommonHelper::get_data_weight($item['cart_weight'])}} kg</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="order-details__count">
                        <div class="order-details__count__single">
                            <h5>Giá sản phẩm</h5>
                            <span class="price" id="cart_total">{{number_format($cart_total)}}</span>
                        </div>
                    </div>
                    <div class="order-details__count">
                        <div class="order-details__count__single mb--55">
                            <div id="orderDetailsDiv" class="order-details__count__single" style="display: none;">
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <h5 class="nowrap">Vận chuyển</h5>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="box">
                                            <select class="selectpicker" data-size="4">
                                                <option value="standard" selected>Tiêu chuẩn</option>
                                                <option value="express">Hoả tốc</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="order-details__count__single">
                            <h5>Mã giảm giá</h5>
                            <span class="price" id="coupon_cart">{{ $coupon_cart }}</span>
                            <button id="delete_coupon_cart" type="button" class="btn-sm" style="display: {{ $coupon_cart ? 'inline-block' : 'none' }};">X</button>
                        </div>


                        <div class="order-details__count__single">
                            <h5>Phí Vận Chuyển</h5>
                            <span class="price" id="shipping">25000</span>
                        </div>
                        <div class="order-details__count__single">
                            <h5>Chọn loại vận chuyển</h5>
                            <div>
                                <label>
                                    <input type="radio" name="shipping_option" value="standard" checked> Thường
                                </label>
                                <label>
                                    <input type="radio" name="shipping_option" value="express"> Hỏa tốc
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="ordre-details__total">
                        <h5>Tổng Đơn Hàng</h5>
                        <span class="price" id="cart_totals">{{number_format($cart_totals)}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 mb--10">
                        <div class="ht__coupon__code">
                            <form>
                                @csrf
                                <div class="coupon__box">
                                    <input type="text" name="coupon_code" placeholder="Mã giảm giá">
                                    <div class="ht__cp__btn">
                                        <button id="check_coupon_cart" type="button">Áp Dụng</button>
                                    </div>
                                    <br>
                                </div>
                                <br>
                                <p class="text-success" id="cart_coupon_message"></p>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 mb--10">
                        <ul id="payment_btn" class="payment__btn">
                            <li class="active">
                                <button type="submit" class="form-control">Thanh toán</button>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <div class="buttons-cart--inner">
                            <div class="buttons-cart" style="width: 100%;">
                                <a href="/cart">Quay lại giỏ hàng</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- cart-main-area end -->
@endsection

@section('script')

<script>
    $('#city_id').change(function() {
        var _token = $('input[name=_token]').val();
        var city_id = $('#city_id').val();
        var html = '<option value="select">Quận Huyện</option>';

        $('#hidden_city_id').val(city_id);

        $.ajax({
            url: 'get_district_checkout',
            method: 'POST',
            data: {
                _token: _token,
                city_id: city_id,
            },
            success: function(data) {
                data.forEach(item => {
                    html += `<option value="${item.district_id}">${item.district_name}</option>`;
                });

                $('#district_id').html(html);

                var user_district = $('input[name=user_district]').val();
                if (user_district) {
                    $('#district_id').val(user_district);
                }

                $('#district_id').change(function() {
                    var district_id = $('#district_id').val();
                    $('#hidden_district_id').val(district_id);
                });
            }
        });
    });
</script>

<script>
    function selectPaymentOption(event) {
        const paymentOptions = document.querySelectorAll('.payment-option');
        paymentOptions.forEach(option => {
            option.classList.remove('selected');
        });

        const selectedOption = event.target.closest('.payment-option');
        selectedOption.classList.add('selected');

        const radioButton = selectedOption.querySelector('input[type="radio"]');
        if (radioButton) {
            radioButton.checked = true;
        }

        const orderDetails = document.getElementById('orderDetailsDiv');
        const selectElement = orderDetails.querySelector('select');
        selectElement.selectedIndex = 0;
    }
</script>

<script>
    $(document).ready(function () {
        $("#payment_btn").on("click", function (event) {
            event.preventDefault();
            $("#paymentForm").submit();
        });
    });
</script>

<script>
    $('#check_coupon_cart').click(function () {
        var _token = $('input[name=_token]').val();
        var couponCode = $('input[name=coupon_code]').val();
        $.ajax({
            url: 'add_coupon_cart',
            method: 'POST',
            data: {
                _token: _token,
                coupon_code: couponCode,
            },
            success: function (data) {
                console.log(data);
                if (data.status) {
                    $('#cart_coupon_message').text(data.message);
                    $('#cart_coupon').html(data.coupon_show);
                    $('#coupon_cart').text(data.coupon_show);
                    $('#cart_totals').text(Number(data.cart_totals).toLocaleString('ja-JP') + ' VNĐ');
                    // Hiển thị nút X nếu coupon được áp dụng thành công
                    $('#delete_coupon_cart').show();
                } else {
                    $('#cart_coupon_message').text(data.message);
                    // Ẩn nút X nếu coupon không được áp dụng
                    $('#delete_coupon_cart').hide();
                }
            }
        });
    });



    $("#delete_coupon_cart").click(function () {
        var _token = $('input[name=_token]').val();
        $.ajax({
            url: 'delete_coupon_cart',
            method: 'POST',
            data: {
                _token: _token,
            },
            success: function (data) {
                if (data.status) {
                    $('#cart_coupon_message').text(data.message);
                    $('#cart_coupon').html(data.coupon_show);
                    $('#cart_totals').text(Number(data.cart_totals).toLocaleString('ja-JP') + ' VNĐ');
                    $('#coupon_cart').text('');
                    // Ẩn nút thay vì xóa
                    $('#delete_coupon_cart').hide();
                } else {
                    $('#cart_coupon_message').text(data.message);
                }
            }
        });
    });
</script>
<script>
    document.querySelectorAll('.type_payment').forEach(input => {
        input.addEventListener('change', function(event) {
            const selectedOption = event.target.closest('.payment-option');
            const orderDetailsDiv = document.getElementById("orderDetailsDiv");

            if (event.target.id === "paymentCash" || event.target.id === "paymentVNPAY" || event.target.id === "paymentMomo" &&
                event.target.checked) {
                orderDetailsDiv.style.display = "block";
                var paymentType = $('input[name="order_pay_type"]:checked').val();
                var selectedShippingOption = $('select.selectpicker').val();
                sendShippingFeeRequest(paymentType, selectedShippingOption);
            } else {
                orderDetailsDiv.style.display = "none";
            }
        });
    });

    $(document).ready(function(){
        $('input[name="shipping_option"]').on('change', function(){
            var selectedOption = $(this).val();
            var shippingFee = (selectedOption === 'express') ? 50000 : 25000;
            
            $('#shipping').text(shippingFee);
            
            var _token = $('input[name="_token"]').val();
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('ghtk.getShippingPrice') }}',
                type: 'POST',
                data: {
                    _token: _token,
                    selected_shipping_option: selectedOption,
                },
                success: function(data) {
                    console.log(data);
                    $('#cart_totals').text(data[1].toLocaleString('ja-JP') + '' + ' đ')
                },
                error: function(xhr, status, error) {
                    console.error("Lỗi cập nhật phí vận chuyển:", error);
                }
            });
        });
    }); 

</script>
@endsection