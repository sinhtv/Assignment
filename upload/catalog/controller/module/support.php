<?php
class ControllerModuleSupport extends Controller {
	public function index() {
		$this->load->language('module/support');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['id'])) {
			$parts = explode('_', (string)$this->request->get['id']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['support_id'] = $parts[0];
		} else {
			$data['support_id'] = 0;
		}

		$this->load->model('tool/image');
		$this->load->model('extension/module');
 		$support_module = $this->model_extension_module->getModulesByCode('support');
 		$setting_support = json_decode($support_module[0]['setting']);
 		$data['module_title'] = $support_module[0]['name'];
		
		$data['support'] = array();
 		if(! empty($setting_support->support) )
 		{
 			foreach ($setting_support->support as $key => $value) {
 				if( $value->type == 1 )
 				{
 					$data['support'][] = '
 						<a href="tel:'.$value->name.'" class="list-group-item">
 							<img src="image/support-call.png">&nbsp;&nbsp;&nbsp;<strong>'.$value->name.'</strong>
 						</a>';
 				} 
 				else if( $value->type == 2 )
 				{
 					$data['support'][] = '
 						<a href="mailTo:'.$value->name.'" class="list-group-item">
 							<img src="image/support-email.png">&nbsp;&nbsp;&nbsp;<strong>'.$value->name.'</strong>
 						</a>';
 				}
 				else if( $value->type == 3 )
 				{
 					$data['support'][] = '
 						<a href="ymsgr:SendIM?'.$value->name.'" class="list-group-item">
 							<img src="image/support-yahoo.png">&nbsp;&nbsp;&nbsp;<strong>'.$value->name.'</strong>
 						</a>';
 				}
 				else if( $value->type == 4 )
 				{
 					$data['support'][] = '
 						<a href="skype:'.$value->name.'?chat" class="list-group-item">
 							<img src="image/support-skype.png">&nbsp;&nbsp;&nbsp;<strong>'.$value->name.'</strong>
 						</a>';
 				}
 				else if( $value->type == 5 )
 				{
 					$facebook  = array( $value->name );
			 		if(! empty($value->name) && strpos( $value->name, '/' ) !== false )
			 			$facebook = explode( "/", rtrim( $value->name, "/" ) );
 					$data['support'][] = '
 						<a href="'.$value->name.'" class="list-group-item">
 							<img src="image/support-facebook.png">&nbsp;&nbsp;&nbsp;<strong>'.end($facebook).'</strong>
 						</a>';
 				}
 			}
 		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/support.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/support.tpl', $data);
		} else {
			return $this->load->view('default/template/module/support.tpl', $data);
		}
	}

}