<?php
//Headings
$_['heading_title']                 = 'Đăng nhập và thanh toán với Amazon';

//Text
$_['text_success']                  = 'Mô-dul đăng nhập và thanh toán với Amazon đã được update';
$_['text_ipn_url']					= 'Cron Job\'s URL';
$_['text_ipn_token']				= 'Secret Token';
$_['text_us']						= 'US';
$_['text_germany']                  = 'Germany';
$_['text_uk']                       = 'United Kingdom';
$_['text_live']                     = 'Live';
$_['text_sandbox']                  = 'Sandbox';
$_['text_auth']						= 'Quyền';
$_['text_payment']                  = 'Thanh toán';
$_['text_no_capture']               = '--- No Automatic Capture ---';
$_['text_all_geo_zones']            = 'Tất cả các vùng tính thuế';
$_['text_button_settings']          = 'Nút lện thiết lập thanh toán';
$_['text_colour']                   = 'Màu sắc';
$_['text_orange']                   = 'Màu cam';
$_['text_tan']                      = 'Tan';
$_['text_white']                    = 'Màu trằng';
$_['text_light']                    = 'Màu sáng';
$_['text_dark']                     = 'Màu tối';
$_['text_size']                     = 'Cỡ';
$_['text_medium']                   = 'Trung bình';
$_['text_large']                    = 'Lớn';
$_['text_x_large']                  = 'Extra large';
$_['text_background']               = 'Hình nền';
$_['text_edit']						= 'Chỉnh sửa đăng nhập và thanh toán với Amazon';
$_['text_amazon_login_pay']         = '<a href="http://go.amazonservices.com/opencart.html" target="_blank" title="Sign-up to Login and Pay with Amazon"><img src="view/image/payment/amazon.png" alt="Login and Pay with Amazon" title="Login and Pay with Amazon" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_amazon_join']              = '<a href="http://go.amazonservices.com/opencart.html" target="_blank" title="Sign-up to Login and Pay with Amazon"><u>Sign-up to Login and Pay with Amazon</u></a>';
$_['entry_login_pay_test']          = 'Chế độ test';
$_['entry_login_pay_mode']          = 'Chế độ thanh toán';
$_['text_payment_info']				= 'Thông tin thanh toán';
$_['text_capture_ok']				= 'Capture đã thành công';
$_['text_capture_ok_order']			= 'Capture thành công, Toàn quyền captured';
$_['text_refund_ok']				= 'Yêu cầu hoàn trả thành công';
$_['text_refund_ok_order']			= 'Yêu cầu hoàn trả thành công, số lượng hoàn trả đầy đủ';
$_['text_cancel_ok']				= 'Hủy bỏ thành công, trạng thái hủy bỏ đẫ được cập nhật';
$_['text_capture_status']			= 'Payment captured';
$_['text_cancel_status']			= 'Payment canceled';
$_['text_refund_status']			= 'Payment refunded';
$_['text_order_ref']				= 'Order ref';
$_['text_order_total']				= 'Total authorized';
$_['text_total_captured']			= 'Total captured';
$_['text_transactions']				= 'Transactions';
$_['text_column_authorization_id']	= 'Amazon Authorization ID';
$_['text_column_capture_id']		= 'Amazon Capture ID';
$_['text_column_refund_id']			= 'Amazon Refund ID';
$_['text_column_amount']			= 'Khối lượng';
$_['text_column_type']				= 'Kiểu';
$_['text_column_status']			= 'Trạng thái';
$_['text_column_date_added']		= 'Ngày cập nhật';
$_['text_confirm_cancel']			= 'Bạn có chắc muốn hủy bỏ thanh toán?';
$_['text_confirm_capture']			= 'Are you sure you want to capture the payment?';
$_['text_confirm_refund']			= 'Are you sure you want to refund the payment?';
$_['text_minimum_total']            = 'Tổng số đơn hàng tối thiểu';
$_['text_geo_zone']                 = 'Vùng tính thuế';
$_['text_status']                   = 'Trạng thái';
$_['text_declined_codes']           = 'Từ chối kiểm tra Codes';
$_['text_sort_order']               = 'Thứ tự';
$_['text_amazon_invalid']           = 'InvalidPaymentMethod';
$_['text_amazon_rejected']          = 'AmazonRejected';
$_['text_amazon_timeout']           = 'Hết thời gian giao dịch';
$_['text_amazon_no_declined']       = '--- Không quyền tự động từ chối ---';

// Columns
$_['column_status']                 = 'Trạng thái';

//entry
$_['entry_merchant_id']             = 'Merchant ID';
$_['entry_access_key']              = 'Access Key';
$_['entry_access_secret']           = 'Secret Key';
$_['entry_client_id']               = 'Client ID';
$_['entry_client_secret']           = 'Client Secret';
$_['entry_marketplace']             = 'Marketplace';
$_['entry_capture_status']          = 'Automatic capture status';
$_['entry_pending_status']          = 'Trạng thái đơn hàng đang chờ xử lý';
$_['entry_ipn_url']					= 'IPN\'s URL';
$_['entry_ipn_token']				= 'Secret Token';
$_['entry_debug']					= 'Gỡ lổi đăng nhập';


// Help
$_['help_pay_mode']					= 'Thanh toán chỉ có sẵn cho thị trường Mỹ';
$_['help_capture_status']			= 'Chọn trạng thái đơn hàng, tự động có một thanh toán';
$_['help_ipn_url']					= 'Việc thiết lập này cũng như là tài khoản của bạn đang nằm ở Amazon';
$_['help_ipn_token']				= 'Mất nhiều thời gian và công sức để đoán';
$_['help_debug']					= 'Viecẹ kích hoạt sửa lổi sẽ được ghi vào file lịch sử lổi. Bạn nên tắt đi trừ những hướng dẫn ghi đè';
$_['help_declined_codes']			= 'Điều này chỉ dành cho mục đích test';

// Order Info
$_['tab_order_adjustment']          = 'Điều chỉnh đơn hàng';

// Errors
$_['error_permission']              = 'Bạn không được phép thay đổi mô-dul này';
$_['error_merchant_id']			    = 'Merchant ID được yêu cầu';
$_['error_access_key']			    = 'Access Key được yêu cầu';
$_['error_access_secret']		    = 'Secret Key được yêu cầu';
$_['error_client_id']			    = 'Client ID được yêu cầu';
$_['error_client_secret']			= 'Client Key được yêu cầu';
$_['error_pay_mode']				= 'Thanh toán chỉ có sẵn cho thị trường Mỹ';
$_['error_curreny']                 = 'Cửa hàng của bạn phải có tiền % s cài đặt và kích hoạt';
$_['error_upload']                  = 'Upload thất bại';
$_['error_data_missing'] 			= 'Dữ liệu yêu cầu bị mất';

// Buttons
$_['button_capture']				= 'Capture';
$_['button_refund']					= 'Refund';
$_['button_cancel']					= 'Cancel';

?>