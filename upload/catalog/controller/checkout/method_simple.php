<?php
class ControllerCheckoutMethodSimple extends Controller {
	public function index() {
		$this->load->language('checkout/checkout');
		
		// Shipping
		if (isset($this->session->data['shipping_address'])) {
			// Shipping Methods
			$method_data = array();

			$this->load->model('extension/extension');

			$results = $this->model_extension_extension->getExtensions('shipping');

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('shipping/' . $result['code']);

					$quote = $this->{'model_shipping_' . $result['code']}->getQuote($this->session->data['shipping_address']);

					if ($quote) {
						$method_data[$result['code']] = array(
							'title'      => $quote['title'],
							'quote'      => $quote['quote'],
							'sort_order' => $quote['sort_order'],
							'error'      => $quote['error']
						);
					}
				}
			}

			$sort_order = array();

			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $method_data);

			$this->session->data['shipping_methods'] = $method_data;
		}

		$text = array(
			'text_shipping_method_title',
			'text_shipping_method',
			'text_comments',
			'text_loading',
			'button_continue',
		);

		foreach ($text as $row) {
			$shipping[$row] = $this->language->get($row);
		}

		if (empty($this->session->data['shipping_methods'])) {
			$shipping['error_warning'] = sprintf($this->language->get('error_no_shipping'), $this->url->link('information/contact'));
		} else {
			$shipping['error_warning'] = '';
		}

		if (isset($this->session->data['shipping_methods'])) {
			$shipping['shipping_methods'] = $this->session->data['shipping_methods'];
		} else {
			$shipping['shipping_methods'] = array();
		}

		if (isset($this->session->data['shipping_method']['code'])) {
			$shipping['code'] = $this->session->data['shipping_method']['code'];
		} else {
			$shipping['code'] = '';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/shipping_method_simple.tpl')) {
			$html['shipping'] = $this->load->view($this->config->get('config_template') . '/template/checkout/shipping_method_simple.tpl', $shipping);
		} else {
			$html['shipping'] = $this->load->view('default/template/checkout/shipping_method_simple.tpl', $shipping);
		}


		// Payment
		if (isset($this->session->data['payment_address'])) {
			// Totals
			$total_data = array();
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

					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}

			// Payment Methods
			$method_data = array();

			$this->load->model('extension/extension');

			$results = $this->model_extension_extension->getExtensions('payment');

			$recurring = $this->cart->hasRecurringProducts();

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('payment/' . $result['code']);

					$method = $this->{'model_payment_' . $result['code']}->getMethod($this->session->data['payment_address'], $total);

					if ($method) {
						if ($recurring) {
							if (method_exists($this->{'model_payment_' . $result['code']}, 'recurringPayments') && $this->{'model_payment_' . $result['code']}->recurringPayments()) {
								$method_data[$result['code']] = $method;
							}
						} else {
							$method_data[$result['code']] = $method;
						}
					}
				}
			}

			$sort_order = array();

			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $method_data);

			$this->session->data['payment_methods'] = $method_data;
		}

		$text = array(
			'text_payment_method_title',
			'text_payment_method',
			'text_comments',
			'text_loading',
			'button_continue',
		);

		foreach ($text as $row) {
			$payment[$row] = $this->language->get($row);
		}

		if (empty($this->session->data['payment_methods'])) {
			$payment['error_warning'] = sprintf($this->language->get('error_no_payment'), $this->url->link('information/contact'));
		} else {
			$payment['error_warning'] = '';
		}

		if (isset($this->session->data['payment_methods'])) {
			$payment['payment_methods'] = $this->session->data['payment_methods'];
		} else {
			$payment['payment_methods'] = array();
		}

		if (isset($this->session->data['payment_method']['code'])) {
			$payment['code'] = $this->session->data['payment_method']['code'];
		} else {
			$payment['code'] = '';
		}

		$payment['scripts'] = $this->document->getScripts();

		if ($this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));

			if ($information_info) {
				$payment['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('config_checkout_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$payment['text_agree'] = '';
			}
		} else {
			$payment['text_agree'] = '';
		}

		if (isset($this->session->data['agree'])) {
			$payment['agree'] = $this->session->data['agree'];
		} else {
			$payment['agree'] = '';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/payment_method_simple.tpl')) {
			$html['payment'] = $this->load->view($this->config->get('config_template') . '/template/checkout/payment_method_simple.tpl', $payment);
		} else {
			$html['payment'] = $this->load->view('default/template/checkout/payment_method_simple.tpl', $payment);
		}

		$this->response->setOutput( json_encode($html) );
	}

	public function load_payment()
	{
		if(! empty($this->request->post['payment_method']) )
		{
			$payment_method = $this->load->controller('payment/' . $this->request->post['payment_method']);
			$this->response->setOutput( $payment_method );
		}
	}

	
}
