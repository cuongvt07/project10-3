<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\GhtkController;
use App\Http\Requests\CheckoutRequest;
use App\Helpers\SeoHelper;
use App\Http\Controllers\Controller;
use App\Jobs\NotifyOrder;
use App\Models\SlideModel;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Models\CouponModel;
use App\Models\OrderModel;
use App\Models\UserModel;
use App\Models\OrderdetailModel;
use App\Models\Ship\CityModel;
use App\Models\Ship\DistrictModel;
use App\Models\Ship\ShipModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Session;
use Carbon\Carbon;
use App\Mail\OrderDone;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Http\Services\CartService;

class CartController extends Controller
{
    public $cart;
    public $coupon;
    public $cartService;
    public $request;
    public $shiping;

    const STANDARD = 25000;
    const EXPRESS = 50000;

    public function __construct(CartService $cartService, Request $request){
        $this->cartService = $cartService;
        $this->request = $request;
        $dataCategory = CategoryModel::all();
        $dataBrand = BrandModel::all();
        $dataLogo = SlideModel::where('type', 3)->first();
        $dataLogoFooter = SlideModel::where('type', 4)->first();
        $this->middleware(function ($request, $next) {
            $this->cart = Session::get('cart');
            $this->coupon = Session::get('coupon');
            return $next($request);
        });
        view()->share(['dataCategory' => $dataCategory,
            'dataBrand' => $dataBrand,
            'dataLogo' => $dataLogo,
            'dataLogoFooter' => $dataLogoFooter
        ]);
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    //Hiện thị cart
    public function cart(){
        $coupon_cart = 0;
        if($this->cart){
            if($this->coupon){
                $coupon_cart =  $this->coupon['coupon_show'];
            }
            else {
                $coupon_cart =  0;
            }

            $cart_total = $this->getTotal($this->cart);
            $cart_totals = $this->getTotals($cart_total);

            return view('frontend.pages.cart', [
                'cart' => $this->cart,
                'cart_total' => $cart_total,
                'cart_totals' => $cart_totals,
                'coupon_cart' => $coupon_cart,
            ]);
        }
        else{
            return redirect('/')->with('msgSuccess', 'Giỏ hàng trống');
        }
    }

    //Hàm thủ tục thanh toán
    public function checkout(){
        if(!Auth::check() || !$this->cart){
            return redirect('/')->with('msgError', 'Bạn cần đăng nhập và đặt hàng mới được tiết hành đặt mua');
        }
        $dataCity = CityModel::all();
        $dataUser = Auth::user();
        $coupon_show = 0;
        if($this->coupon){
            $coupon_show = $this->coupon['coupon_show'];
        }
        else {
            $coupon_show = 0;
        }

        $cart_total = $this->getTotal($this->cart);

        $cart_totals = $this->getTotals($cart_total);

        return view('frontend.pages.checkout', [
            'dataCity' => $dataCity,
            'dataUser' => $dataUser,
            'cart' => $this->cart,
            'cart_totals' => $cart_totals,
            'cart_total' => $cart_total,
            'coupon_cart' => $coupon_show,
        ]);
    }

    //Hàm thanh toán đơn hàng
    public function payment(CheckoutRequest $request){
        $today = Carbon::today('Asia/Ho_Chi_Minh');
        $order_profit = 0;
        $user_id = Auth::id();

        foreach($this->cart as $product){
            $data = ProductModel::find($product['cart_id']);
            if($data->product_amount == 0 || $data->product_amount < $product['cart_quantity']){
                $this->deleteSession();
                return redirect('/')->with('msgError', 'Đặt hàng thất bại do sản phẩm đã hết hàng hoặc số lượng hàng không đủ');
            }
        };

        $this->coupon = Session::get('coupon');
        if($this->coupon){
            $dataCoupon = CouponModel::find($this->coupon['coupon_id']);
            $dataCoupon->user_id = $dataCoupon->user_id . $user_id .',';
            $dataCoupon->save();
        }

        $this->shiping = Session::get('priceShip');
        $cart_total = $this->getTotal($this->cart);

        $cart_totals = $this->getTotals($cart_total, $this->shiping);
        $priceProduct = 0;

        foreach ($this->cart as $product) {
            $priceProductSub = ProductModel::find($product['cart_id'])->product_price_buy * $product['cart_quantity'];
            $priceProduct+= $priceProductSub;
        }

        $order_profit = $cart_totals - $priceProduct;

        $dataCity = CityModel::find($request->city_id);
        $dataDistrict = DistrictModel::find($request->district_id);
        $coupon = $this->coupon;
        $dataCustomerOrder = [
            'user_id' => $user_id,
            'order_note' => $request->order_note,
            'order_shipping' =>
                "Tên người nhận: ".$request->order_name .
                " - Email: " . $request->order_email.
                " - Số điện thoại: " . $request->order_phone.
                " - Địa chỉ: " . $request->order_addres.
                " - " . $dataDistrict->district_name.
                " - " . $dataCity->city_name,
            'order_pay_type' => $request->order_pay_type,
            'order_address' => $request->order_addres,
            'order_ward' => $request->order_addres,
            'order_profit' => $order_profit,
            'order_total' => $cart_totals,
            'order_status' => 1,
            'created_at' => $today,
        ];

        Session::put('dataCustomer', $dataCustomerOrder);
        Session::save();
        if($request->order_pay_type == 2){
            return view('frontend.vnpay.index', [
                'order_total' => $cart_totals,
                'order_pay_type' => $request->order_pay_type,
                'dataCustomerOrder' => Session::get('dataCustomer'),
                'cart' => $this->cart,
                'cart_totals' => $cart_totals,
                'cart_total' => $cart_total,
                'priceShip' => $this->shiping,
                'coupon' => $coupon['coupon_show'],
            ]);
        } elseif ($request->order_pay_type == 3){
            return view('frontend.vnpay.index', [
                'order_total' => $cart_totals,
                'order_pay_type' => $request->order_pay_type,
                'dataCustomerOrder' => Session::get('dataCustomer'),
                'cart' => $this->cart,
                'cart_totals' => $cart_totals,
                'cart_total' => $cart_total,
                'priceShip' =>  $this->shiping,
                'coupon' => $coupon['coupon_show'],
            ]);
        }elseif ($request->order_pay_type == 4){
            return view('frontend.vnpay.index', [
                'order_total' => $cart_totals,
                'order_pay_type' => $request->order_pay_type,
                'priceShip' =>  $this->shiping,
                'coupon' => $coupon['coupon_show'],
            ]);
        }
        else {
            $dataOrder = new OrderModel();
            $dataUser = UserModel::find($user_id);
            $dataCustomerOrderShow = Session::get('dataCustomer');

            $dataOrder->user_id = $dataCustomerOrderShow['user_id'];
            $dataOrder->order_note = $dataCustomerOrderShow['order_note'];
            $dataOrder->order_shipping = $dataCustomerOrderShow['order_shipping'];
            $dataOrder->address = $dataCustomerOrderShow['order_address'];
            $dataOrder->ward = $dataCustomerOrderShow['order_ward'];
            $dataOrder->order_pay_type = $dataCustomerOrderShow['order_pay_type'];
            $dataOrder->order_profit = $dataCustomerOrderShow['order_profit'];
            $dataOrder->order_total = $dataCustomerOrderShow['order_total'];
            $dataOrder->order_status = 1;
            $dataOrder->order_note = $request->order_note;
            $dataOrder->created_at = $dataCustomerOrderShow['created_at'];

            $dataOrder->save();

            $order_id = $dataOrder->order_id;//Lấy id order vừa insert vào bảng

            foreach($this->cart as $val){
                $dataProduct = ProductModel::find($val['cart_id']);
                $dataProduct->product_amount = $dataProduct->product_amount - $val['cart_quantity'];
                $dataProduct->save();

                $dataOrderdetail = new OrderdetailModel();
                $dataOrderdetail->order_id = $order_id;
                $dataOrderdetail->product_id = $val['cart_id'];
                $dataOrderdetail->order_detail_quantity = $val['cart_quantity'];
                $dataOrderdetail->order_detail_price = $val['cart_price_sale'];
                $wrist_key = "wrist_measurement_{$val['cart_id']}";
                $dataOrderdetail->wrist_measurement = $request->input($wrist_key, $val['wrist_measurement'] ?? null);
                $dataOrderdetail->save();
            }

           $this->sendMailOrder($request->order_email, $dataOrder, $dataUser, $dataCustomerOrderShow['order_shipping'], $this->cart, $this->coupon, $this->shiping);

            $this->deleteSession();

            return redirect('/')->with('msgSuccess', 'Đặt Hàng Thành Công');
        }
    }

    public function paymentMomo(Request $request)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = "MOMO";
        $accessKey = "F8BBA842ECF85";
        $secretKey = "K951B6PE1waDMi640xX08PD3vg6EkVlz";
        $orderInfo = "Thanh toán đơn hàng";
        $redirectUrl = "http://127.0.0.1:8000/payment/return"; 
        $ipnUrl = "http://127.0.0.1:8000/payment/return"; 
        $requestId = (string)time();
        $orderId = (string)time();
        $extraData = "";
    
        $amount = str_replace(',', '', $request->amount);
        if (!is_numeric($amount) || $amount <= 0) {
            return redirect()->back()->with('msgError', 'Số tiền không hợp lệ.');
        }
    
        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=captureWallet";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
    
        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "MoMo Payment",
            'storeId' => "MOMOStore",
            'requestId' => $requestId,
            'amount' => (int)$amount, 
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => 'captureWallet',
            'signature' => $signature
        ];
    
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);
    
    
        if (!$jsonResult || !isset($jsonResult['payUrl']) || $jsonResult['resultCode'] !== 0) {
            return redirect()->back()->with('msgError', 'Không thể tạo thanh toán MoMo. Vui lòng thử lại.');
        }
        return redirect()->to($jsonResult['payUrl']);
    }

    //Tạo thanh toán bằng vn pay
    public function paymentCreate(Request $request){
        $vnp_TmnCode = "ES8W4TH7";
        $vnp_HashSecret = "BYAOHQMNDPHLWRUFHXGJKPLUXWRCMNBW";
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/payment/return";
        $vnp_TxnRef = rand(1,10000);
        $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = str_replace(',', '', $request->input('amount'));

        // Kiểm tra xem amount có phải là số hợp lệ không
        if (!is_numeric($vnp_Amount) || $vnp_Amount <= 0) {
            return redirect()->back()->with('msgError', 'Số tiền không hợp lệ. Vui lòng kiểm tra lại.');
        }
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
    }

    public function paymentReturn(Request $request){

        if($request->vnp_ResponseCode == "00") {
            $dataOrder = new OrderModel();
            $dataCustomerOrderShow = Session::get('dataCustomer');
            $dataUser = UserModel::find($dataCustomerOrderShow['user_id']);

            $dataOrder->user_id = $dataCustomerOrderShow['user_id'];
            $dataOrder->order_note = $dataCustomerOrderShow['order_note'];
            $dataOrder->order_shipping = $dataCustomerOrderShow['order_shipping'];
            $dataOrder->address = $dataCustomerOrderShow['order_address'];
            $dataOrder->ward = $dataCustomerOrderShow['order_ward'];
            $dataOrder->order_pay_type = $dataCustomerOrderShow['order_pay_type'];
            $dataOrder->order_profit = $dataCustomerOrderShow['order_profit'];
            $dataOrder->order_total = $dataCustomerOrderShow['order_total'];
            $dataOrder->order_status = 1;
            $dataOrder->created_at = $dataCustomerOrderShow['created_at'];

            $dataOrder->save();

            $order_id = $dataOrder->order_id;//Lấy id order vừa insert vào bảng

            foreach($this->cart as $val){
                //Xử lý xóa sản phẩm khi đặt đơn
                $dataProduct = ProductModel::find($val['cart_id']);
                $dataProduct->product_amount = $dataProduct->product_amount - $val['cart_quantity'];
                $dataProduct->save();
                //Kết Thúc Xử lý xóa sản phẩm khi đặt đơn

                $dataOrderdetail = new OrderdetailModel();
                $dataOrderdetail->order_id = $order_id;
                $dataOrderdetail->product_id = $val['cart_id'];
                $dataOrderdetail->order_detail_quantity = $val['cart_quantity'];
                $dataOrderdetail->order_detail_price = $val['cart_price_sale'];
                $dataOrderdetail->wrist_measurement = $val['wrist_measurement'];

                $dataOrderdetail->save();
            }

//            $this->sendMailOrder($dataUser->user_email, $dataOrder, $dataUser, $dataCustomerOrderShow['order_shipping'], $this->cart, $this->coupon, Session::get('priceShip'));

            $this->deleteSession();

            return redirect('/')->with('msgSuccess', 'Đặt Hàng và thanh toán Thành Công');
        }
        return redirect('/')->with('msgError' ,'Thanh toán đã bị huỷ, hãy kiểm tra giỏ hàng để thanh toán cho lần tiếp theo');
    }

    //Hàm gửi mail sau khi đặt hàng thành công
    public function sendMailOrder($email, $dataOrder, $dataUser, $shipping, $cart, $coupon, $priceShip)
    {
        dispatch(new NotifyOrder($email, $dataOrder, $dataUser, $shipping, $cart, $coupon, $priceShip));
    }

    //Hàm xóa session sau khi đặt hàng thành công
    public function deleteSession(){
        Session::forget('cart');
        Session::forget('coupon');
        Session::forget('totalCart');
        Session::forget('priceShip');
        Session::forget('dataCustomer');
    }

    //Hàm thêm cart
    public function addToCart(Request $request){
        $cart_id = $request->cart_id;
        $type = $request->type;
        $dataProduct = ProductModel::find($cart_id);
        if($this->cart){
            $checkIsset = 0;
            foreach($this->cart as $key => $val){
                if($val['cart_id'] == $cart_id){
                    $quantity = $val['cart_quantity'] + 1;
                    if($quantity <= $dataProduct->product_amount){
                    $this->cart[$key]['cart_quantity'] = $quantity;
                    }
                    else {
                        return response()->json('Số lượng sản phẩm đã đến mức tối đa. Bạn không thể thêm vào giỏ nữa');
                    }
                    $checkIsset++;
                }
            }

            if($checkIsset == 0){
                if($request->cart_quantity <= $dataProduct->product_amount){
                    $this->cart[] = array(
                        'cart_id' => $cart_id,
                        'cart_product' => $request->cart_product,
                        'cart_price' => $request->cart_price,
                        'cart_weight' => $request->cart_brand,
                        'cart_price_sale' => $request->cart_price_sale,
                        'cart_amount' => $request->cart_amount,
                        'cart_quantity' => $request->cart_quantity,
                        'cart_image' => $request->cart_image,
                    );
                }
                else {
                    return response()->json('Số lượng sản phẩm đã đến mức tối đa. Bạn không thể thêm vào giỏ nữa');
                }
            }
        }
        else{
            if($request->cart_quantity <= $dataProduct->product_amount){
                $this->cart[] = array(
                    'cart_id' => $cart_id,
                    'cart_product' => $request->cart_product,
                    'cart_price' => $request->cart_price,
                    'cart_weight' => $request->cart_brand,
                    'cart_price_sale' => $request->cart_price_sale,
                    'cart_amount' => $request->cart_amount,
                    'cart_quantity' => $request->cart_quantity,
                    'cart_image' => $request->cart_image,
                );
            }
            else {
                return response()->json('Số lượng sản phẩm đã đến mức tối đa. Bạn không thể thêm vào giỏ nữa');
            }
        }
        Session::put('cart', $this->cart);
        Session::save();
        if($type === 'add-to-cart'){
            return response()->json('Thêm sản phẩm giỏ hàng thành công');
        }else {
            redirect('/checkout');
        }
    }

    //Hàm xử lý tính tổng theo sản phẩmgiỏ hàng
    public function getTotal($cart){
        $cart_total = 0;
        foreach($cart as $key => $val){
            $cart_total += $val['cart_price_sale']*$val['cart_quantity'];
        }
        return $cart_total;
    }

    //Hàm xử lý tính tổng giỏ hàng
    public function getTotals($cart_total, $shipping = 0){
        $cart_totals = 0;
        $this->coupon = Session::get('coupon');
        if($this->coupon){
            if($this->coupon['coupon_status'] == 1){
                // $coupon_cart = $coupon['coupon_value'] . ' %';
                $cart_totals = $cart_total - ($cart_total/100 * $this->coupon['coupon_value']);
            }
            else if($this->coupon['coupon_status'] == 2){
                // $coupon_cart = $coupon['coupon_value'] . ' VNĐ';

                $cart_totals = $cart_total - $this->coupon['coupon_value'];
            }
        }
        else{
            $cart_totals = $cart_total;
        }
        
        $cart_totals = $cart_totals + $shipping;

        return $cart_totals;
    }

    //Hàm cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateQuatityCart(Request $request){
        $cart_id = $request->cart_id;
        $cart_product_total = 0;
        $cart_quantity = $request->cart_quantity;
        $checkProduct = ProductModel::find($cart_id);
        foreach($this->cart as $key => $val){
            if($val['cart_id'] == $cart_id){
                if($cart_quantity <= $checkProduct->product_amount){
                    $this->cart[$key]['cart_quantity'] = $cart_quantity;
                    $cart_product_total = $this->cart[$key]['cart_quantity']*$this->cart[$key]['cart_price_sale'];
                }
                else {
                    $cart_quantity = $this->cart[$key]['cart_quantity'];
                    $cart_product_total = $this->cart[$key]['cart_quantity']*$this->cart[$key]['cart_price_sale'];
                }
            }
        }
        Session::put('cart', $this->cart);

        $cart_total = $this->getTotal($this->cart);

        $cart_totals = $this->getTotals($cart_total);

        return $data = [$cart_product_total, $cart_total, $cart_totals, $cart_quantity];
    }

    //Hàm xóa sản phẩm trong giỏ hàng
    public function deleteProductCart(Request $request){
        foreach($this->cart as $key => $val){
            if($val['cart_id'] == $request->cart_id){
                unset($this->cart[$key]);
            }
        }
        Session::put('cart', $this->cart);

        $cart_total = $this->getTotal($this->cart);

        $cart_totals = $this->getTotals($cart_total);

        return $data = [$cart_total, $cart_totals];
    }

    //Hàm xử lý thêm mã giảm giá và check mã giảm giá
    public function addCouponCart(Request $request){
        $data = CouponModel::where('coupon_code', $request->coupon_code)->first();
        $checkUse = CouponModel::where('coupon_code', $request->coupon_code)->where('user_id', 'LIKE', '%'.Auth::id().'%')->first();
        $today = Carbon::today('Asia/Ho_Chi_Minh');
        $cart_total = $this->getTotal($this->cart);

        $option_transfer = $request->selectedShippingOption;
        if ($option_transfer == 'standard') {
            $shippingPrice = self::STANDARD;
        } elseif ($option_transfer == 'express') {
            $shippingPrice = self::EXPRESS;
        } else {
            return redirect()->back()->with('msgError', 'Invalid shipping option selected');
        }
        $result = [];

        if($data){
            if($data->coupon_status != 3){
                if(!$checkUse){
                    if($today < $data->coupon_expiry){
                        if($data->coupon_status == 1){
                            $coupon_value = [
                                'coupon_status' => $data->coupon_status,
                                'coupon_value' => $data->coupon_value,
                                'coupon_id' => $data->coupon_id,
                                'coupon_show' => $data->coupon_value . ' %',
                            ];
                            Session::put('coupon', $coupon_value);
                        }
                        else{
                            $coupon_value = [
                                'coupon_status' => $data->coupon_status,
                                'coupon_value' => $data->coupon_value,
                                'coupon_id' => $data->coupon_id,
                                'coupon_show' => number_format($data->coupon_value) . ' VNĐ',
                            ];
                            Session::put('coupon', $coupon_value);
                        }
                        //Tính lại tổng khi add mã
                        $cart_totals = $this->getTotals($cart_total, $shippingPrice);

                        $result = ['Bạn đã áp dụng thành công mã '. $data->coupon_name, $data->coupon_value, $cart_totals, Session::get('coupon')['coupon_show']];
                    }
                    else{
                        Session::forget('coupon');
                        $result = ['Mã giảm giá đã hết hạn', 0, $cart_total, 0];
                    }
                }
                else{
                    Session::forget('coupon');
                    $result = ['Bạn đã dùng mã giảm giá này rồi', 0, $cart_total, 0];
                }
            }
            else{
                Session::forget('coupon');
                $result = ['Mã giảm giá đã hết', 0, $cart_total, 0];
            }
        }
        else{
            Session::forget('coupon');
            $result = ['Mã giảm giá không tồn tại', 0, $cart_total, 0];
        }

        return $result;
    }

    //Hàm get sản phẩm trong cart offset ajax
    public function getDataCart(){
        if($this->cart){
            $cart_total = $this->getTotal($this->cart);

            return $data = [$this->cart, $cart_total];
        }
        else{
            return $data = ['Giỏ hàng trống', 0];
        }

    }

    //Hàm xóa sản phẩm trong cart offset
    public function deteleProductCartOffset(Request $request){
        foreach($this->cart as $key => $val){
            if($val['cart_id'] == $request->cart_id){
                unset($this->cart[$key]);
            }
        }
        Session::put('cart', $this->cart);
        $cart_total = $this->getTotal($this->cart);

        return $data = [$cart_total];
    }

    //Hàm get thông tin quận huyện ajax
    public function getDistricCheckout(Request $request){
        $data = DistrictModel::where('city_id',$request->city_id)->get();

        return $data;
    }

    public function getInformatioOrder(): array
    {
        $data_shipping = $this->request->input('formData');
        try {
            $carts = $this->cart;
            $products = [];
            if ($carts && count($carts) > 0) {
                foreach ($carts as $key => $cartItem) {
                    $products[] = $cartItem;
                }
            }
            $ghtkController = new GhtkController();
            $cart_total = $this->getTotal($carts);
            $cart_totals = $this->getTotals($cart_total);
            $address_seller = $ghtkController->getAddressPickUp();
            $fee = [
                "pick_address_id" => $address_seller['data'][0]['pick_address_id'],
                "pick_address" => $address_seller['data'][0]['address'],
                "address" => $data_shipping['order_addres'],
                "province" => $data_shipping['order_city'],
                "district" => $data_shipping['order_district'],
                "weight" => 5,
                "value" => $cart_totals,
                "deliver_option" => "none",
                "tags" => [7]
            ];
            // check dịch vụ xfast
            $address_check_xfast = [
                "customer_district" => "Quận Ba Đình",
                "customer_province" => "Hà Nội",
                "customer_ward" => "Phường Đội Cấn",
//                "customer_first_address" => $data_shipping['order_addres'],
                "pick_province" => "Hà Nội",
                "pick_district" => "Quận Ba Đình",
                "pick_ward" => "Quận Ba Đình"
            ];
            $data = [
                'fee' => $fee,
                'products' => $products,
                'address_seller' => $address_seller,
                'address_check_xfast' => $address_check_xfast
            ];

            Session::put('data', $data);
            return $data;
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e
            ];
        }
    }

    public function getShippingPrice(Request $request)
    {
        $shippingPrice = false;
        $option_transfer = $request->selected_shipping_option;
        if ($option_transfer == 'standard') {
            $shippingPrice = self::STANDARD;
        } elseif ($option_transfer == 'express') {
            $shippingPrice = self::EXPRESS;
        } else {
            return redirect()->back()->with('msgError', 'Invalid shipping option selected');
        }

        Session::put('priceShip', $shippingPrice);
        $cart_price_ship = 0;
        $cart_total = $this->getTotal($this->cart);
        
        $cart_totals = $this->getTotals($cart_total, $shippingPrice);

        return $result = [$cart_price_ship, number_format($cart_totals), $shippingPrice];
    }

    public function deleteCouponCart(Request $request)
    {
        Session::forget('coupon');
        $option_transfer = $request->selectedShippingOption;
        if ($option_transfer == 'standard') {
            $shippingPrice = self::STANDARD;
        } elseif ($option_transfer == 'express') {
            $shippingPrice = self::EXPRESS;
        } else {
            return redirect()->back()->with('msgError', 'Invalid shipping option selected');
        }

        $cart_total = $this->getTotal($this->cart);
        $cart_totals = $this->getTotals($cart_total, $shippingPrice);
        

        return response()->json([
            'status'      => true,
            'message'     => 'Coupon đã được xóa thành công',
            'cart_totals' => $cart_totals,
            'coupon_show' => 0
        ]);
    }

}
