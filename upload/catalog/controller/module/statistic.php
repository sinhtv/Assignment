<?php
class ControllerModuleStatistic extends Controller {
	public function index() {
		$this->load->language('module/statistic');
		$this->load->model('module/statistic');

		$text = array('entry_online','entry_today','entry_yesterday','entry_lastmonth','entry_total');
		foreach($text as $t)
			$data[$t] = $this->language->get($t);

		$this->load->model('tool/image');
		$this->load->model('extension/module');
 		$statistic = $this->model_extension_module->getModulesByCode('statistic');
 		$setting_statistic = json_decode($statistic[0]['setting']);
 		$data['module_title'] = $statistic[0]['name'];
		/* COUNTER */
		$this->model_module_statistic->getConfig();
		$this->model_module_statistic->visit();
		$statistic = $this->model_module_statistic->display();
		list($curonl,$todayonl,$yesterdayonl,$lastweek,$lastmonth,$totalvisit) = explode('-',$statistic);

		if($setting_statistic->online_view) $data['online_view'] = $curonl;
		if($setting_statistic->today_view) $data['today_view'] = $todayonl;
		if($setting_statistic->yesterday_view) $data['yesterday_view'] = $yesterdayonl;
		if($setting_statistic->lastmonth_view) $data['lastmonth_view'] = $lastmonth;
		if($setting_statistic->total_view) $data['total_view'] = $totalvisit;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/statistic.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/statistic.tpl', $data);
		} else {
			return $this->load->view('default/template/module/statistic.tpl', $data);
		}
	}

}