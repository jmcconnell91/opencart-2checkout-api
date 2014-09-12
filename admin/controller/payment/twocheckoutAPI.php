<?php 
class ControllerPaymentTwoCheckoutAPI extends Controller {
	private $error = array(); 

	public function index() {
		$this->language->load('payment/twocheckoutAPI');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('twocheckoutAPI', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		
		$this->data['entry_account'] = $this->language->get('entry_account');
		$this->data['entry_public_key'] = $this->language->get('entry_public_key');
        $this->data['entry_private_key'] = $this->language->get('entry_private_key');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_total'] = $this->language->get('entry_total');	
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		 
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['account'])) {
			$this->data['error_account'] = $this->error['account'];
		} else {
			$this->data['error_account'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/twocheckoutAPI', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = $this->url->link('payment/twocheckoutAPI', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['twocheckoutAPI_account'])) {
			$this->data['twocheckoutAPI_account'] = $this->request->post['twocheckoutAPI_account'];
		} else {
			$this->data['twocheckoutAPI_account'] = $this->config->get('twocheckoutAPI_account');
		}

        if (isset($this->request->post['twocheckoutAPI_public_key'])) {
            $this->data['twocheckoutAPI_public_key'] = $this->request->post['twocheckoutAPI_public_key'];
        } else {
            $this->data['twocheckoutAPI_public_key'] = $this->config->get('twocheckoutAPI_public_key');
        }

        if (isset($this->request->post['twocheckoutAPI_private_key'])) {
            $this->data['twocheckoutAPI_private_key'] = $this->request->post['twocheckoutAPI_private_key'];
        } else {
            $this->data['twocheckoutAPI_private_key'] = $this->config->get('twocheckoutAPI_private_key');
        }
		
		if (isset($this->request->post['twocheckoutAPI_test'])) {
			$this->data['twocheckoutAPI_test'] = $this->request->post['twocheckoutAPI_test'];
		} else {
			$this->data['twocheckoutAPI_test'] = $this->config->get('twocheckoutAPI_test');
		}
		
		if (isset($this->request->post['twocheckoutAPI_total'])) {
			$this->data['twocheckoutAPI_total'] = $this->request->post['twocheckoutAPI_total'];
		} else {
			$this->data['twocheckoutAPI_total'] = $this->config->get('twocheckoutAPI_total'); 
		} 
				
		if (isset($this->request->post['twocheckoutAPI_order_status_id'])) {
			$this->data['twocheckoutAPI_order_status_id'] = $this->request->post['twocheckoutAPI_order_status_id'];
		} else {
			$this->data['twocheckoutAPI_order_status_id'] = $this->config->get('twocheckoutAPI_order_status_id'); 
		}
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['twocheckoutAPI_geo_zone_id'])) {
			$this->data['twocheckoutAPI_geo_zone_id'] = $this->request->post['twocheckoutAPI_geo_zone_id'];
		} else {
			$this->data['twocheckoutAPI_geo_zone_id'] = $this->config->get('twocheckoutAPI_geo_zone_id'); 
		}
		
		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['twocheckoutAPI_status'])) {
			$this->data['twocheckoutAPI_status'] = $this->request->post['twocheckoutAPI_status'];
		} else {
			$this->data['twocheckoutAPI_status'] = $this->config->get('twocheckoutAPI_status');
		}
		
		if (isset($this->request->post['twocheckoutAPI_sort_order'])) {
			$this->data['twocheckoutAPI_sort_order'] = $this->request->post['twocheckoutAPI_sort_order'];
		} else {
			$this->data['twocheckoutAPI_sort_order'] = $this->config->get('twocheckoutAPI_sort_order');
		}

		$this->template = 'payment/twocheckoutAPI.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/twocheckoutAPI')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['twocheckoutAPI_account']) {
			$this->error['account'] = $this->language->get('error_account');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>