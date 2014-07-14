<?php
App::uses('AppController', 'Controller');
/**
 * SalCustomers Controller
 *
 * @property SalCustomer $SalCustomer
 */
class SalCustomersController extends AppController {

/**
 *  Layout
 *
 * @var string
 */
	public $layout = 'default';

/**
 * Helpers
 *
 * @var array
 */
	//public $helpers = array('TwitterBootstrap.BootstrapHtml', 'TwitterBootstrap.BootstrapForm', 'TwitterBootstrap.BootstrapPaginator');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Session');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$filters = array();
		$name = '';
		////////////////////////////START - WHEN SEARCH IS SEND THROUGH POST//////////////////////////////////////
		if($this->request->is("post")) {
			$url = array('action'=>'index');
			$parameters = array();
			$empty=0;
			if(isset($this->request->data['SalCustomer']['name']) && $this->request->data['SalCustomer']['name']){
				$parameters['name'] = trim(strip_tags($this->request->data['SalCustomer']['name']));
			}else{
				$empty++;
			}
			
			if($empty == 1){
				$parameters['search']='empty';
			}else{
				$parameters['search']='yes';
			}
			$this->redirect(array_merge($url,$parameters));
		}
		////////////////////////////END - WHEN SEARCH IS SEND THROUGH POST//////////////////////////////////////
		
		////////////////////////////START - SETTING URL FILTERS//////////////////////////////////////
		if(isset($this->passedArgs['name'])){
			$filters['upper(SalCustomer.name) LIKE'] = '%'.strtoupper($this->passedArgs['name']).'%';
			$name = $this->passedArgs['name'];
		}		
		////////////////////////////END - SETTING URL FILTERS//////////////////////////////////////
		
		////////////////////////////START - SETTING PAGINATING VARIABLES//////////////////////////////////////	
		
		$this->paginate = array(
			'conditions' => array($filters),
			'order' => array('SalCustomer.name' => 'asc'),
			//'limit' => 15
		);
		////////////////////////////END - SETTING PAGINATING VARIABLES//////////////////////////////////////
		$this->SalCustomer->recursive = 0;
		////////////////////////START - SETTING PAGINATE AND OTHER VARIABLES TO THE VIEW//////////////////
		$this->set('salCustomers', $this->paginate());
		$this->set('name', $name);
		////////////////////////END - SETTING PAGINATE AND OTHER VARIABLES TO THE VIEW//////////////////
	}


/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SalCustomer->create();
			debug($this->request->data);
			if ($this->SalCustomer->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('sal customer')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				//$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('sal customer')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
	}


/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->SalCustomer->id = $id;
		if (!$this->SalCustomer->exists()) {
			throw new NotFoundException(__('Cliente invalido'));
		}
		
		$employees = $this->SalCustomer->SalEmployee->find('count', array(
			'conditions'=>array('SalEmployee.sal_customer_id'=>$id)
		));
		
		$taxNumbers = $this->SalCustomer->SalTaxNumber->find('count', array(
			'conditions'=>array('SalTaxNumber.sal_customer_id'=>$id)
		));
		if($employees > 0 && $taxNumbers > 0){
					$employeesIds = $this->SalCustomer->SalEmployee->find('list', array(
							'conditions' => array(
								'SalEmployee.sal_customer_id'=>$id
							),
							'fields' => array('SalEmployee.id', 'SalEmployee.id')
						));
						foreach ($employeesIds as $employeesId) {
							try {
								$this->SalCustomer->SalEmployee->id = $employeesId;	
								$this->SalCustomer->SalEmployee->delete();
							} catch (Exception $e) {	
									$this->Session->setFlash(
										__('No se puede eliminar el Cliente porque tiene notas ligadas'),
										'alert',
										array(
											'plugin' => 'TwitterBootstrap',
											'class' => 'alert-error'
										)
									);
									$this->redirect(array('action' => 'index'));
							}
						}
					$taxNumbersIds = $this->SalCustomer->SalTaxNumber->find('list', array(
							'conditions' => array(
								'SalTaxNumber.sal_customer_id'=>$id
							),
							'fields' => array('SalTaxNumber.id', 'SalTaxNumber.id')
						));
						foreach ($taxNumbersIds as $taxNumbersId) {
							try {
								$this->SalCustomer->SalTaxNumber->id = $taxNumbersId;	
								$this->SalCustomer->SalTaxNumber->delete();
							} catch (Exception $e) {	
								$this->Session->setFlash(
										__('No se puede eliminar el Cliente porque tiene notas ligadas'),
										'alert',
										array(
											'plugin' => 'TwitterBootstrap',
											'class' => 'alert-error'
										)
									);
									$this->redirect(array('action' => 'index'));
							}		
						}
		}
		
		
//		if($employees > 0 && $taxNumbers > 0){
//			$this->Session->setFlash(
//				__('No se puede eliminar el Cliente porque tiene Empleados y Nits registrados, primero debe eliminarlos'),
//				'alert',
//				array(
//					'plugin' => 'TwitterBootstrap',
//					'class' => 'alert-danger'
//				)
//			);
//			$this->redirect(array('action' => 'index'));
//		}
		
		if ($this->SalCustomer->delete()) {
			$this->Session->setFlash(
				__('Se elimino el cliente con exito'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('No se pudo eliminar el cliente!', __('sal customer')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
	
	////////////////////////////////////////////////////////////BEGINS MULTI INTERFACE/////////////////////////////////////////////////////////////////////////////////
	
	public function vsave(){
		
//		debug($this->passedArgs);
		$idCostumer = '';
		$customer [0]['SalCustomer']['name'] = '';
		$employees [0]['SalEmployee']['id'] = '';
		$employees [0]['SalEmployee']['name'] = '';
		$taxNumbers [0]['SalTaxNumber']['id'] = '';
		$taxNumbers [0]['SalTaxNumber']['name'] = '';
		$taxNumbers [0]['SalTaxNumber']['nit'] = '';
		$customer [0]['SalCustomer']['address'] = '';
		$customer [0]['SalCustomer']['phone'] = '';
		$customer [0]['SalCustomer']['email'] = '';
		$customer [0]['SalCustomer']['description'] = '';
		if(isset($this->passedArgs['id'])){
			$idCostumer = $this->passedArgs['id'];
			
			$customer = $this->SalCustomer->find('all', array(
				'conditions' => array(
					'SalCustomer.id' => $idCostumer
				),
				'fields'=>array('SalCustomer.name', 'SalCustomer.phone', 'SalCustomer.address', 'SalCustomer.email', 'SalCustomer.description'),
				'recursive' => -1
			));
			
			$employees = $this->SalCustomer->SalEmployee->find('all', array(
				"conditions"=>array(
					'SalEmployee.sal_customer_id'=>$idCostumer
				),
				'fields'=>array('SalEmployee.id', 'SalEmployee.name'),
				'recursive' => -1,
				'order'=>array('SalEmployee.id'=>'asc')
				, 'limit' => 1
			));

			$taxNumbers = $this->SalCustomer->SalTaxNumber->find('all', array(
				"conditions" => array(
					'SalTaxNumber.sal_customer_id' => $idCostumer
				),
				'fields'=>array('SalTaxNumber.id', 'SalTaxNumber.name', 'SalTaxNumber.nit'),
				'recursive' => -1,
				'order' => array('SalTaxNumber.id' => 'asc')
				, 'limit' => 1
			));
		
		}
		
//		debug($customer);
//		debug($employees);
//		debug($taxNumbers);
		
		$this->set(compact('idCostumer', 'customer', 'employees', 'taxNumbers'));
		
	}
	
//	public function ajax_save_customer(){
//		if($this->RequestHandler->isAjax()){
//			$data = array();
//			if(isset($this->request->data['id']) && $this->request->data['id'] <> ""){
//				$data["SalCustomer"]["id"] = $this->request->data['id'];
//			}else{
//				$this->SalCustomer->create();
//			}
//			$data["SalCustomer"]["name"] = $this->request->data['name'];
//			$data["SalCustomer"]["address"] = $this->request->data['address'];
//			$data["SalCustomer"]["phone"] = $this->request->data['phone'];
//			$data["SalCustomer"]["email"] = $this->request->data['email'];
//			
//			//debug($data);
//			
//			if($this->SalCustomer->save($data)){
//				echo "success|".$this->SalCustomer->id;
//			}
//		}
//	}
	
	public function ajax_save_customer(){
		if($this->RequestHandler->isAjax()){
			$data = array();
			if(isset($this->request->data['id']) && $this->request->data['id'] <> ""){
				$action = "edit";
				$data["SalCustomer"]["id"] = $this->request->data['id'];//modify
			}else{
				$action = "add";
				$this->SalCustomer->create();
			}
			$data["SalCustomer"]["name"] = $this->request->data['name'];
//			$data["SalEmployee"]["name"] = $this->request->data['employeeName'];
//			$data["SalTaxNumber"]["nit"] = $this->request->data['nit'];
			$data["SalCustomer"]["address"] = $this->request->data['address'];
			$data["SalCustomer"]["phone"] = $this->request->data['phone'];
			$data["SalCustomer"]["email"] = $this->request->data['email'];
			$data["SalCustomer"]["description"] = $this->request->data['description'];
			//debug($data);
			
			if(isset($this->request->data['id']) && $this->request->data['id'] <> ""){
				if($this->SalCustomer->save($data)){
					$salCustomerId = $this->SalCustomer->id;
			
					$this->SalCustomer->SalEmployee->create();
					$data["SalEmployee"]["id"] = $this->request->data['employeeId'];
					$data["SalEmployee"]["sal_customer_id"] = $salCustomerId;
					$data["SalEmployee"]["name"] = $this->request->data['employeeName'];
//					$data["SalEmployee"]["phone"] = '';
//					$data["SalEmployee"]["email"] = '';
					$this->SalCustomer->SalEmployee->save($data);
						
					$this->SalCustomer->SalTaxNumber->create();
					$data["SalTaxNumber"]["id"] = $this->request->data['nitId'];
					$data["SalTaxNumber"]["sal_customer_id"] = $salCustomerId;
					if($this->request->data['nitName'] == ''){
						$data["SalTaxNumber"]["name"] = 'N/A';
					}else{
						$data["SalTaxNumber"]["name"] = $this->request->data['nitName'];
					}
					if($this->request->data['nit'] == ''){
						$data["SalTaxNumber"]["nit"] = 'N/A';
					}else{
						$data["SalTaxNumber"]["nit"] = $this->request->data['nit'];
					}
//					$data["SalTaxNumber"]["name"] = 'N/a';
					$this->SalCustomer->SalTaxNumber->save($data);
					
					echo "success|".$action."|".$this->SalCustomer->id."|".$this->SalCustomer->SalEmployee->id."|".$this->SalCustomer->SalTaxNumber->id;
				}
			}else{
				if($this->SalCustomer->save($data)){
					//echo "success|".$this->SalCustomer->id;
					$salCustomerId = $this->SalCustomer->id;
			
					$this->SalCustomer->SalEmployee->create();
					$data["SalEmployee"]["sal_customer_id"] = $salCustomerId;
					$data["SalEmployee"]["name"] = $this->request->data['employeeName'];
//					$data["SalEmployee"]["phone"] = '';
//					$data["SalEmployee"]["email"] = '';
					$this->SalCustomer->SalEmployee->save($data);
						
					$this->SalCustomer->SalTaxNumber->create();
					$data["SalTaxNumber"]["sal_customer_id"] = $salCustomerId;
					if($this->request->data['nitName'] == ''){
						$data["SalTaxNumber"]["name"] = 'N/A';
					}else{
						$data["SalTaxNumber"]["name"] = $this->request->data['nitName'];
					}
					if($this->request->data['nit'] == ''){
						$data["SalTaxNumber"]["nit"] = 'N/A';
					}else{
						$data["SalTaxNumber"]["nit"] = $this->request->data['nit'];
					}
//					$data["SalTaxNumber"]["name"] = 'N/a';
					$this->SalCustomer->SalTaxNumber->save($data);
					
					echo "success|".$action."|".$salCustomerId."|".$this->SalCustomer->SalEmployee->id."|".$this->SalCustomer->SalTaxNumber->id;
				}
			}
		}
	}
	
	public function ajax_save_employee(){
		if($this->RequestHandler->isAjax()){
			$data = array();
			$action = "add";
			if(isset($this->request->data['id']) && $this->request->data['id'] <> ""){
				$data["SalEmployee"]["id"] = $this->request->data['id'];
				$action = "edit";
			}else{
				$this->SalCustomer->SalEmployee->create();
			}
			$data["SalEmployee"]["sal_customer_id"] = $this->request->data['idCustomer'];
			$data["SalEmployee"]["name"] = $this->request->data['name'];
			$data["SalEmployee"]["phone"] = $this->request->data['phone'];
			$data["SalEmployee"]["email"] = $this->request->data['email'];
			
			//debug($data);
			
			if($this->SalCustomer->SalEmployee->save($data)){
				echo "success|".$this->SalCustomer->SalEmployee->id."|".$action;
			}
		}
	}
	
	public function ajax_delete_employee(){
		if($this->RequestHandler->isAjax()){
			$id = $this->request->data['id'];
			
			$children = $this->SalCustomer->SalEmployee->SalSale->find("count", array("conditions"=>array("SalSale.sal_employee_id"=>$id)));
			if($children == 0){
				$this->SalCustomer->SalEmployee->id = $id;
				if($this->SalCustomer->SalEmployee->delete()){
					echo "success";
				}else{
					echo "error";
				}
			}else{
				echo "children";
			}
			
		}
	}
	
	
	public function ajax_save_tax_number(){
		if($this->RequestHandler->isAjax()){
			$data = array();
			$action = "add";
			if(isset($this->request->data['id']) && $this->request->data['id'] <> ""){
				$data["SalTaxNumber"]["id"] = $this->request->data['id'];
				$action = "edit";
			}else{
				$this->SalCustomer->SalTaxNumber->create();
			}
			$data["SalTaxNumber"]["sal_customer_id"] = $this->request->data['idCustomer'];
			$data["SalTaxNumber"]["nit"] = $this->request->data['nit'];
			$data["SalTaxNumber"]["name"] = $this->request->data['name'];
			
			if($this->SalCustomer->SalTaxNumber->save($data)){
				echo "success|".$this->SalCustomer->SalTaxNumber->id."|".$action;
			}
		}
	}
	
	public function ajax_delete_tax_number(){
		if($this->RequestHandler->isAjax()){
			$id = $this->request->data['id'];
			
			$children = $this->SalCustomer->SalTaxNumber->SalSale->find("count", array("conditions"=>array("SalSale.sal_tax_number_id"=>$id)));
			if($children == 0){
				$this->SalCustomer->SalTaxNumber->id = $id;
				if($this->SalCustomer->SalTaxNumber->delete()){
					echo "success";
				}else{
					echo "error";
				}
			}else{
				echo "children";
			}
			
		}
	}
	
	
//END OF THE CLASS	
}
