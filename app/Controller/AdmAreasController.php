<?php
App::uses('AppController', 'Controller');
/**
 * AdmAreas Controller
 *
 * @property AdmArea $AdmArea
 */
class AdmAreasController extends AppController {

/**
 *  Layout
 *
 * @var string
 */
//	public $layout = 'bootstrap';

/**
 * Helpers
 *
 * @var array
 */
//	public $helpers = array('TwitterBootstrap.BootstrapHtml', 'TwitterBootstrap.BootstrapForm', 'TwitterBootstrap.BootstrapPaginator');
/**
 * Components
 *
 * @var array
 */
//	public $components = array('Session');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$filters = '';
		$this->paginate = array(
			'conditions'=>array(
				$filters
			 ),
			'recursive'=>0,
			'order'=> array('AdmArea.period'=>'desc'),
			'limit' => 20,
		);
		$this->set('admAreas', $this->paginate('AdmArea'));
		
		$parentAreas = $this->AdmArea->find('list');
		$parentAreas[0] = "Ninguno";
		$this->set(compact('parentAreas'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
				
		if ($this->request->is('post')) {
			//debug($this->request->data);
		
			$this->AdmArea->create();
//			$this->request->data['AdmArea']['creator']=$this->Session->read('UserRestriction.id');
			if ($this->AdmArea->save($this->request->data)) {
				$this->Session->setFlash(
					__('Se creo el area de la empresa.'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('No se pudo crear, intentelo de nuevo.'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		$this->loadModel('AdmPeriod');
		$admPeriods = $this->AdmPeriod->find('list', array(
			'fields'=>array('AdmPeriod.name', 'AdmPeriod.name'),
			'order'=>array('AdmPeriod.id'=>'DESC')
		));
		$parentAreas = $this->AdmArea->find('list', array(
			'conditions'=>array('AdmArea.period'=>key($admPeriods))
		));
		$parentAreas[0] = "Ninguno";
		$this->set(compact('admPeriods', 'parentAreas'));
		
	}
	
	public function ajax_list_periods_areas(){
		if($this->RequestHandler->isAjax()){
			$period = $this->request->data['period'];
			$parentAreas = $this->AdmArea->find('list', array(
				'conditions'=>array('AdmArea.period'=>$period)
			));
			$parentAreas[0] = "Ninguno";
			$this->set(compact('parentAreas'));
		}
	}
	
/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->AdmArea->id = $id;
		if (!$this->AdmArea->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm node')));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
//			debug($this->request->data);
		
//		$this->request->data['AdmArea']['lc_transaction']='MODIFY';
			if ($this->AdmArea->save($this->request->data)) {
				$this->Session->setFlash(
					__('Los cambios fueron guardados'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('Ocurrio un problema intente de nuevo'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		 
		} else {
			$this->request->data = $this->AdmArea->read(null, $id);
		}
		//debug($this->request->data);
		$this->loadModel('AdmPeriod');
		$admPeriods = $this->AdmPeriod->find('list', array(
			'order'=>array('AdmPeriod'=>'DESC'),
			'fields'=>array('AdmPeriod.name', 'AdmPeriod.name')
			));
		///////////////////////////////////////////////////////////
		$childrenAux = $this->AdmArea->find('list', array(
			'fields'=>array('AdmArea.id', 'AdmArea.id') ,
			'conditions'=>array("AdmArea.parent_area"=>$id)
		));
		//debug($childrenAux);

		if(count($childrenAux)>0){ //fix bug last child
			$children = array_merge(array(intval($id)), $childrenAux); //array();
			do{
				$childrenAux = $this->AdmArea->find('list', array('fields'=>array('AdmArea.id', 'AdmArea.id') ,'conditions'=>array("AdmArea.parent_area"=>$childrenAux)));
				$children = array_merge($children, (array)$childrenAux);
			}while(count($childrenAux) > 0);
		}else{
			$children = intval($id);
		}
		//debug($children);

		$parentAreas = $this->AdmArea->find('list', array(
			'conditions'=>array('AdmArea.period'=>$this->request->data['AdmArea']['period'], "NOT"=>array("AdmArea.id"=>$children))
		));
		
		//$parentAreas = $this->AdmArea->find('list', array("conditions"=>array("NOT"=>array("AdmArea.id"=>$children))));
		//debug($parentAreas);
		$parentAreas[0] = "Ninguno";

		//$parentAreas = $this->AdmArea->find('list');
		//////////////////////////////////////////////////////////
//debug($parentAreas);
		$this->set(compact('admPeriods', 'parentAreas'));
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
		$this->AdmArea->id = $id;
		if (!$this->AdmArea->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm area')));
		}
		
		//verify if exist child
		$child = $this->AdmArea->find('count', array('conditions'=>array("AdmArea.parent_area"=>$id)));
		if($child > 0){
			$this->Session->setFlash(
				__('Tiene dependientes no se puede eliminar', __('adm menu')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-error'
				)
			);
			$this->redirect(array('action' => 'index'));
		}

		
		try{
			$this->AdmArea->delete();
			$this->Session->setFlash(
				__('Se elimino el area con exito'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}catch(Exception $e){
			if($e->getCode() == 23503){
				$msge = 'No se puede eliminar porque Usuarios y Roles dependen de esta Area';
			}else{
				$msge = 'Ocurrio un problema vuelva a intentarlo';
			}
			$this->Session->setFlash(
			$msge,
			'alert',
			array('plugin' => 'TwitterBootstrap','class' => 'alert-error')
			);
			$this->redirect(array('action' => 'index'));
		}
		/*
		if ($this->AdmArea->delete()) {
			$this->Session->setFlash(
				__('Se elimino el area con exito'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('Ocurrio un problema vuelva a intentarlo'),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	*/
		
	}
}
