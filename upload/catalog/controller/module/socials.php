<?php
class ControllerModuleSocials extends Controller {
	public function index($setting) {
		$this->load->model('extension/module');

		$socials = $this->model_extension_module->getModulesByCode('socials');
		foreach ($socials as $row) {
 			if( $row['name'] == $setting['name'] )
 			{
 				$info = $row;
 				$info['setting'] = (array)json_decode($info['setting']);
 			}
 		}

 		if(! empty($info['setting']['page_url']) )
 		{
 			$data['page_url'] = $info['setting']['page_url'];
 		}
 		if(! empty($info['setting']['appId']) )
 		{
 			$data['appId'] = $info['setting']['appId'];
 		}
 		if(! empty($info['setting']['width']) )
 		{
 			$data['width'] = $info['setting']['width'];
 		}
 		if(! empty($info['setting']['height']) )
 		{
 			$data['height'] = $info['setting']['height'];
 		}

 		if( $setting['name'] == 'Facebook Page' )
 			$tpl = 'social_facebook';
 		if( $setting['name'] == 'Google Plus' )
 			$tpl = 'social_google';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/'.$tpl.'.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/'.$tpl.'.tpl', $data);
		} else {
			return $this->load->view('default/template/module/'.$tpl.'.tpl', $data);
		}
	}

}