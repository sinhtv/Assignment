<?php
class ControllerCheckoutCheckoutSimple extends Controller {
	public function index() {
		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->response->redirect($this->url->link('checkout/cart'));
		}

		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$this->response->redirect($this->url->link('checkout/cart'));
			}
		}

		$this->load->language('checkout/checkout');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		// Required by klarna
		if ($this->config->get('klarna_account') || $this->config->get('klarna_invoice')) {
			$this->document->addScript('http://cdn.klarna.com/public/kitt/toc/v1.0/js/klarna.terms.min.js');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_cart'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('checkout/checkout_simple', '', 'SSL')
		);

		$text = array(
			'heading_title',
			'text_checkout_option',
			'text_checkout_account',
			'text_checkout_payment_address',
			'text_checkout_shipping_address',
			'text_checkout_shipping_method',
			'text_checkout_payment_method',
			'text_checkout_confirm',
			'text_step_1',
			'text_step_2',
			'button_order',
			'text_comments',
			'text_loading',
		);

		foreach ($text as $row) {
			$data[$row] = $this->language->get($row);
		}

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}

		$data['logged'] = $this->customer->isLogged();

		if (isset($this->session->data['account'])) {
			$data['account'] = $this->session->data['account'];
		} else {
			$data['account'] = '';
		}

		if (isset($this->session->data['comment'])) {
			$data['comment'] = $this->session->data['comment'];
		} else {
			$data['comment'] = '';
		}

		$data['shipping_required'] = $this->cart->hasShipping();

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout_simple.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/checkout_simple.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/checkout/checkout_simple.tpl', $data));
		}
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function customfield() {
		$json = array();

		$this->load->model('account/custom_field');

		// Customer Group
		if (isset($this->request->get['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->get['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->get['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

		foreach ($custom_fields as $custom_field) {
			$json[] = array(
				'custom_field_id' => $custom_field['custom_field_id'],
				'required'        => $custom_field['required']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}



	/**
	 * Final order place
	 * step 2 end
	 */
	public function place_order()
	{
		$json = array();
		// Validate if shipping is required. If not the customer should not have reached this page.
		if (!$this->cart->hasShipping()) {
			$json['redirect'] = $this->url->link('checkout/checkout_simple', '', 'SSL');
		}

		// Validate if shipping address has been set.
		if (!isset($this->session->data['shipping_address'])) {
			$json['redirect'] = $this->url->link('checkout/checkout_simple', '', 'SSL');
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}

		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$json['redirect'] = $this->url->link('checkout/cart');

				break;
			}
		}

		// Save shipping method
		if( isset($this->request->post['shipping_method']) )
		{
			$shipping_method = $this->request->post['shipping_method'];
			$json_shipping = $this->shipping_save( $shipping_method );
		}
		else
			$json_shipping = array();
		
		// Save payment method
		$json_payment = $this->payment_save( $this->request->post );

		$json = array_merge($json_payment,$json_shipping);


		$this->session->data['comment'] = $this->request->post['comment'];

		// Update payment method and shipping method to order
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		if ( $this->customer->isLogged() )
		{
			$this->load->model('account/customer');
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
			$order_info['customer_group_id'] = $customer_info['customer_group_id'];
		} else if (isset($this->session->data['guest']['customer_group_id'])) {
			$order_info['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
		} else {
			$order_info['customer_group_id'] = $this->config->get('config_customer_group_id');
		}
		
		if( isset($this->session->data['shipping_method']) )
		{
			$order_info['shipping_method'] 	= $this->session->data['shipping_method']['title'];
			$order_info['shipping_code'] 	= $this->session->data['shipping_method']['code'];
		}
		if( isset($this->session->data['payment_method']) )
		{
			$order_info['payment_method'] 	= $this->session->data['payment_method']['title'];
			$order_info['payment_code'] 	= $this->session->data['payment_method']['code'];
		}

		// Gift Voucher
		$order_info['vouchers'] = array();

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $voucher) {
				$order_info['vouchers'][] = array(
					'description'      => $voucher['description'],
					'code'             => token(10),
					'to_name'          => $voucher['to_name'],
					'to_email'         => $voucher['to_email'],
					'from_name'        => $voucher['from_name'],
					'from_email'       => $voucher['from_email'],
					'voucher_theme_id' => $voucher['voucher_theme_id'],
					'message'          => $voucher['message'],
					'amount'           => $voucher['amount']
				);
			}
		}

		// Recalcualte Total price if shipping change
		$order_info['totals'] = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();
		$this->load->model('extension/extension');
		$sort_order = array();
		$results = $this->model_extension_extension->getExtensions('total');
		foreach ($results as $key => $value) {
			$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
		}
		array_multisort($sort_order, SORT_ASC, $results);
		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('total/' . $result['code']);
				$this->{'model_total_' . $result['code']}->getTotal($order_info['totals'], $total, $taxes);
			}
		}
		$sort_order = array();
		foreach ($order_info['totals'] as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}
		array_multisort($sort_order, SORT_ASC, $order_info['totals']);

		$order_info['total'] = $total;

		$this->load->model('checkout/order_simple');
		$this->model_checkout_order_simple->editOrder($order_info['order_id'], $order_info);


		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}



	/**
	 * Save the shipping method selected in step 2
	 *
	 */
	public function shipping_save( $shipping_method ) {
		$this->load->language('checkout/checkout');

		$json = array();

		if ( empty($shipping_method) ) {
			$json['error']['shipping_warning'] = $this->language->get('error_shipping');
		} else {
			$shipping = explode('.', $shipping_method);

			if ( !isset($shipping[0]) || !isset($shipping[1]) || !isset( $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]] ) ) {
				$json['error']['shipping_warning'] = $this->language->get('error_shipping');
			}
		}

		if (!$json) {
			$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
		}

		return $json;
	}


	/**
	 * Save the payment method selected in step 2
	 * 
	 */
	public function payment_save( $post ) {
		$this->load->language('checkout/checkout');

		$json = array();

		if ( empty($post['payment_method']) ) {
			$json['error']['payment_warning'] = $this->language->get('error_payment');
		} elseif (! isset($this->session->data['payment_methods'][$post['payment_method']]) ) {
			$json['error']['payment_warning'] = $this->language->get('error_payment');
		}

		if ($this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));

			if ( $information_info && empty($post['agree']) ) {
				$json['error']['payment_warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			}
		}

		if (!$json) {
			$this->session->data['payment_method'] = $this->session->data['payment_methods'][$post['payment_method']];
		}

		return $json;
	}
}