<?php
App::uses('AppController', 'Controller');
/**
 * AdmControllers Controller
 *
 * @property AdmController $AdmController
 */
class AdmControllersController extends AppController {

/**
 *  Layout
 *
 * @var string
 */
//	public $layout = 'default'; 

/**
 * Helpers
 *
 * @var array
 */
	//me dio que no tiene sentido redeclarar porque ya esta en appControllers
	//public $helpers = array('Js','TwitterBootstrap.BootstrapHtml', 'TwitterBootstrap.BootstrapForm', 'TwitterBootstrap.BootstrapPaginator');
/**
 * Components
 *
 * @var array
 */
	//public $components = array('RequestHandler','Session');  // lo puse en appController para que lo usen todos
/*
	public  function isAuthorized($user){
		return $this->Permission->isAllowed($this->name, $this->action, $this->Session->read('Permission.'.$this->name));
	}
*/	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->AdmController->recursive = 0;
		 $this->paginate = array(
			'order'=>array('AdmController.name'=>'asc'),
			'limit' => 20
		);
		$this->set('admControllers', $this->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		if ($this->request->is('post')) {
			//$this->AdmController->create();
			if($this->AdmController->createControlAndLifeCycles($this->request->data)){
				$this->Session->setFlash(
					'Se creo el Controlador y sus Ciclos de Vida predeterminados(Estados, Transacciones y Transiciones).',
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'add'));
			}else{
				$this->Session->setFlash(
					'<strong>OCURRIO UN PROBLEMA!</strong> No se pudo crear el Controlador y sus Ciclos de Vida predeterminados(Estados, Transacciones y Transiciones).',
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
				$this->redirect(array('action' => 'add'));
			}
			
			//$this->redirect(array('action' => 'index'));
			
			////////////////////
	  }
		
		$admModules = $this->AdmController->AdmModule->find('list', array('fields'=>array('initials', 'name'), 'order'=>'AdmModule.id'));
		
		$initialModule = strtolower(key($admModules)); //primera posicion del vector y muestra valor key de esa posicion
		////////

		///////
		$admControllers = $this->_getControllers($initialModule);
		if(count($admControllers) == 0){
			$admControllers[0]="--- Vacio ---";
		}else{
			foreach ($admControllers as $key => $value) {
				$admControllers[$key] = Inflector::camelize($admControllers[$value]);
			}
		}
		

		$this->set(compact('admModules', 'admControllers'/*, 'checkedControllers'*/));
	}
	
	public function ajax_list_controllers(){
		if($this->RequestHandler->isAjax()){
			$initialModule = strtolower($this->request->data['module']);
			$admControllers = $this->_getControllers($initialModule);
			/*
			$catchCheckedControllers = $this->AdmController->find('all', array('recursive'=>0,'fields'=>array('AdmController.name'), 'conditions'=>array('AdmModule.initials'=>$initialModule)));
			$checkedControllers = array();
			foreach ($catchCheckedControllers as $key => $value) {
				$checkedControllers[$key] = $value['AdmController']['name'];
			}
			 */
			if(count($admControllers) == 0){$admControllers[0]="--- Vacio ---";}
			$this->set(compact('admControllers'/*, 'checkedControllers'*/));
		}else{
			$this->redirect($this->Auth->logout());
		}
	}

	private function _getControllers($initialModule){
		//Get all controllers from the APP except for plugins
		$array = App::objects('controller');
		$appControllers=array();
		//$cernir = array();
		foreach ($array as $value) {
			//if($value <> 'AppController'){
			//	if($value <> 'PagesController'){
					if(strtolower(substr($value, 0, 3)) == $initialModule){ //compara iniciales ej: adm(app) = adm(db)
						$clean = substr($value, 0, -10); //quito la palabra Controller del final del string
						$formatTrigger= strtolower(preg_replace("/(?<=[a-zA-Z])(?=[A-Z])/", "_", $clean));//underscore every capital letter, al formato trigger
						$appControllers[$formatTrigger] = $formatTrigger;
					}
				//}
			//}
		}
		
		//Get DB values and format them to compare to the App
		$dbControllers = $this->AdmController->find('all', array('recursive'=>0,'fields'=>array('AdmController.name'), 'conditions'=>array('AdmModule.initials'=>$initialModule)));
		$formatDbControllers = array();
		foreach ($dbControllers as $key => $value) {
			$formatDbControllers[$key] = $value['AdmController']['name'];
		}
		
		
		///////
		/*
		echo 'data base';
		debug($formatDbControllers);
		echo 'controladores cake';
		debug($controllers);
		$array2=array("AdmActions", "AdmControllers");
		echo 'la diferencia es';
		debug(array_diff($controllers, $formatDbControllers));
		 * 
		 */
		return array_diff($appControllers, $formatDbControllers); //comparo controllers de la aplicacion con los de la DB, solo devuelvo los que no estan registrados
		///////
		//return $controllers;
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->AdmController->id = $id;
		if (!$this->AdmController->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm controller')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    $this->request->data['AdmController']['lc_action']='MODIFY';
			if ($this->AdmController->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('adm controller')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('adm controller')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->AdmController->read(null, $id);
			$this->request->data['AdmController']['name'] = Inflector::camelize($this->request->data['AdmController']['name']);
		}
		$admModules = $this->AdmController->AdmModule->find('list');
		$this->set(compact('admModules'));
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
		$this->AdmController->id = $id;
		if (!$this->AdmController->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm controller')));
		}
		
		$actions = $this->AdmController->AdmAction->find('count', array('conditions'=>array('AdmAction.adm_controller_id'=>$id)));
		$transactions = $this->AdmController->AdmTransaction->find('count', array('conditions'=>array('AdmTransaction.adm_controller_id'=>$id)));
		$states = $this->AdmController->AdmState->find('count', array('conditions'=>array('AdmState.adm_controller_id'=>$id)));
		
		$error = $actions + $transactions + $states;
		
		if($error > 0){
			$this->Session->setFlash(
				__('No se puede eliminar porque tiene hijos'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-error'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		
		if ($this->AdmController->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('adm controller')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('adm controller')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
