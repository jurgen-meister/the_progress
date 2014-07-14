<?php
App::uses('AppController', 'Controller');
/**
 * AdmMenus Controller
 *
 * @property AdmMenu $AdmMenu
 */
class AdmMenusController extends AppController {

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
//	public $helpers = array('TwitterBootstrap.BootstrapHtml', 'TwitterBootstrap.BootstrapForm', 'TwitterBootstrap.BootstrapPaginator');
/**
 * Components
 *
 * @var array
 */
//	public $components = array('Session');
	/*
	public  function isAuthorized($user){
		return $this->Permission->isAllowed($this->name, $this->action, $this->Session->read('Permission.'.$this->name));
	}
	 * 
	 */
	
	public function index(){
		////////////////////////////////////////////////////////
		$parentsMenus = $this->AdmMenu->find("list", array(
			"conditions"=>array(
				"AdmMenu.parent_node"=>null,// don't have parent
				"AdmMenu.inside "=>null //th
			),
			"order"=>array("AdmMenu.order_menu", "AdmMenu.name"),
			"recursive"=>-1
		));
		//debug($array);
		///////////////////////////////////////////////////////
		//$modules = $this->AdmMenu->AdmModule->find('list');
		if ($this->request->is('post')) {
			$idParentMenu = $this->request->data['formAdmMenuIndexOut']['parentsMenus'];
		}else{
			if(isset($this->passedArgs[0])){
				$idParentMenu = $this->passedArgs[0];
//				debug($this->passedArgs[0]);
			}else{
				$idParentMenu = key($parentsMenus);	
			}
			
		}
		
		$this->AdmMenu->unbindModel(array(
			'hasMany' => array('AdmRolesMenu')
		));
		 
		$this->AdmMenu->bindModel(array(
			'hasOne'=>array(
				'AdmController'=> array(
					'foreignKey' => false,
					'conditions' => array('AdmAction.adm_controller_id = AdmController.id')
				),
			)
		));
		$filters = '';
		$this->paginate = array(
			'conditions'=>array(
				$filters
			 ),
			'conditions'=>array('AdmMenu.inside'=>null, 'AdmMenu.parent_node'=>$idParentMenu),
			'order'=>array('AdmMenu.parent_node'=>'desc', 'AdmMenu.order_menu'=>'asc'),
			'limit' => 50,
		);
		$admMenus = $this->paginate('AdmMenu');
//				debug($admMenus);
		$this->set('admMenus', $admMenus);
		$this->set(compact('parentsMenus', 'idParentMenu'));
		
		//debug($this->paginate('AdmMenu')); //IMPORTANT.- this debug is not capturing de bind and unbind, but is working. Is better if I put it inside an array then do debug
		/////////////////////////////////
		
	}
	
	
/**
 * add method
 *
 * @return void
 */
	public function add($id = null, $idParent = null) {
		if ($this->request->is('post')) {
			/////////////
			$this->AdmMenu->create();
			If($this->request->data['AdmMenu']['adm_action_id'] == 0){
				unset($this->request->data['AdmMenu']['adm_action_id']);
			}
			If($this->request->data['AdmMenu']['parent_node'] == 0){
				unset($this->request->data['AdmMenu']['parent_node']);
			}
			if ($this->AdmMenu->save($this->request->data)) {
				$this->Session->setFlash(
					__('Se creo correctamente'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index', $idParent));
			} else {
				$this->Session->setFlash(
					__('Ocurrio un problema intentelo de nuevo'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
				$this->redirect(array('action' => 'index', $idParent));
			}
			///////////////	
		}
		$parentsMenus = $this->AdmMenu->find("list", array(
			"conditions"=>array(
				"AdmMenu.parent_node"=>null,// don't have parent
				"AdmMenu.inside "=>null
			),
			"order"=>array("AdmMenu.order_menu", "AdmMenu.name"),
			"recursive"=>-1
		));
		$admModules = $this->AdmMenu->AdmModule->find('list');
		$module = key($admModules);
		$admActions = $this->_list_actions($module, 0);
		//$admMenus = $this->AdmMenu->find('list', array("conditions"=>array("AdmMenu.adm_module_id"=>$module)));
		/*
		$admMenus = $this->AdmMenu->find('list', array(
				'conditions'=>array('AdmMenu.adm_module_id'=>$module, 'AdmMenu.inside'=>null),
				'order'=>array('AdmMenu.parent_node'=>'DESC')
		));
		 */
		$parentsMenus[0] = "Ninguno";
		$this->set(compact('admModules', 'admActions', 'parentsMenus'));
	}
	

	private function _list_actions($module, $actionAsigned){
		///////////////////// To filter actions whom have already assgined to a menu/////////////////
		$actionsSaved = $this->AdmMenu->find("list", array(
			"fields"=>array("adm_action_id", "adm_action_id"),
			"conditions"=>array(
				//"adm_action_id"=>34,
				"adm_module_id"=>$module,
				"adm_action_id !="=>null //if there isn't this validation null will corrupt everything
			)
		));
		//debug($as);
		unset($actionsSaved[$actionAsigned] );
		////////////////////////////////////////////////////////////////////////////////////
		//debug($actionsSaved);
		
		$this->AdmMenu->AdmAction->unbindModel(array(
			'hasMany' => array('AdmMenu')
		));
		$admAct = $this->AdmMenu->AdmAction->find('all', array(
			'recursive'=>1, 
			'conditions'=>array(
				'AdmController.adm_module_id'=>$module,
				//array("AdmAction.id"=>$actionsSaved)
				'NOT'=>array("AdmAction.id"=>$actionsSaved)
			),
			'fields'=>array('AdmAction.id', 'AdmAction.name', 'AdmController.name'),
			'order'=>array('AdmController.name'=>'ASC')
			));
		//debug($admAct);
		$admActions = array();
		//if(count($admAct) > 0){
			foreach($admAct as $var){
				$admActions[$var["AdmAction"]["id"]] = Inflector::camelize($var["AdmController"]["name"]) . "->" . $var["AdmAction"]["name"];
			}
			$admActions[0] = "Ninguno";
		//}
		return $admActions;
	}
	
	
	public function ajax_list_actions_out(){
		if($this->RequestHandler->isAjax()){
			$module = $this->request->data['module'];
			$action = $this->request->data['action'];
			$admActions = $this->_list_actions($module, $action);
//			$admMenus = $this->AdmMenu->find('list', array(
//				'conditions'=>array('AdmMenu.adm_module_id'=>$module, 'AdmMenu.inside'=>null),
//				'order'=>array('AdmMenu.parent_node'=>'DESC')
//			));
			$parentsMenus = $this->AdmMenu->find("list", array(
				"conditions"=>array(
					"AdmMenu.parent_node"=>null,// don't have parent
					"AdmMenu.inside "=>null,
					
				),
				"order"=>array("AdmMenu.order_menu", "AdmMenu.name"),
				"recursive"=>-1
			));
			$parentsMenus[0] = "Ninguno";
			$this->set(compact('admActions', 'parentsMenus'));			
		}else{
			$this->redirect($this->Auth->logout());
		}
	}
/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null, $idParent = null) {
		$this->AdmMenu->id = $id;
		if (!$this->AdmMenu->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm menu')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {
			//debug($this->request->data);
			If(!isset($this->request->data['AdmMenu']['adm_action_id'])){
				//hay habilitar allowEmpty en el modelo para guardar con null, para update no hay otra
				$this->request->data['AdmMenu']['adm_action_id'] = null;
			}else{
				if($this->request->data['AdmMenu']['adm_action_id'] == 0){
					$this->request->data['AdmMenu']['adm_action_id'] = null;
				}
			}
			
			If(!isset($this->request->data['AdmMenu']['parent_node'])){
				//unset($this->request->data['AdmMenu']['parent_node']);
				$this->request->data['AdmMenu']['parent_node'] = null;
			}else{
				if($this->request->data['AdmMenu']['parent_node'] == 0){
					$this->request->data['AdmMenu']['parent_node'] = null;
				}
			}

			$this->request->data['AdmMenu']['lc_transaction'] = 'MODIFY';
			//debug($this->request->data);
			
			if ($this->AdmMenu->save($this->request->data)) {
				$this->Session->setFlash(
					__('Se guardo correctamente'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index', $idParent));
			} else {
				$this->Session->setFlash(
					__('Ocurrio un problema intentelo de nuevo'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
				$this->redirect(array('action' => 'index', $idParent));
			}
				
		} else {
			$this->request->data = $this->AdmMenu->read(null, $id);
		}
    	
		//////////////////// Fill edit.ctp
		///Fix Null values in dropdownlist
		if($this->request->data['AdmMenu']['adm_action_id'] == null){
			$this->request->data['AdmMenu']['adm_action_id'] = 0;
		}
		if($this->request->data['AdmMenu']['parent_node'] == null){
			$this->request->data['AdmMenu']['adm_menu_id'] = 0;
		}else{
			//para que reconozca el valor parent_node al inicio update
			$this->request->data['AdmMenu']['adm_menu_id'] = $this->request->data['AdmMenu']['parent_node']; 
		}
	
		$admModules = $this->AdmMenu->AdmModule->find('list');
		$module = $this->request->data['AdmMenu']['adm_module_id'];
		$admActions = $this->_list_actions($module, $this->request->data['AdmMenu']['adm_action_id']);
		
		//***************************************************+*****//
		//no debe mostrar al hijo del hijo del hijo
		$childrenAux = $this->AdmMenu->find('list', array('fields'=>array('AdmMenu.id', 'AdmMenu.id') ,'conditions'=>array("AdmMenu.parent_node"=>$id)));

		if(count($childrenAux)>0){ //fix bug last child
			$children = array_merge(array(intval($id)), $childrenAux); //array();
			do{
				$childrenAux = $this->AdmMenu->find('list', array('fields'=>array('AdmMenu.id', 'AdmMenu.id') ,'conditions'=>array("AdmMenu.parent_node"=>$childrenAux)));
				$children = array_merge($children, (array)$childrenAux);
			}while(count($childrenAux) > 0);
		}else{
			$children = intval($id);
		}
		
		$parentsMenus = $this->AdmMenu->find("list", array(
				"conditions"=>array(
					"AdmMenu.parent_node"=>null,// don't have parent
					"AdmMenu.inside "=>null,
					
				),
				"order"=>array("AdmMenu.order_menu", "AdmMenu.name"),
				"recursive"=>-1
			));
		$parentsMenus[0] = "Ninguno";
		
		$this->set(compact('admModules', 'admActions', 'parentsMenus'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null, $idParent = null) {
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->AdmMenu->id = $id;
		if (!$this->AdmMenu->exists()) {
			throw new NotFoundException('Menu invalido');
		}
		//verify if exist child
		$child = $this->AdmMenu->find('count', array('conditions'=>array("AdmMenu.parent_node"=>$id)));
		if($child > 0){
			$this->Session->setFlash(
				__('Tiene hijos no se puede eliminar'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-error'
				)
			);
			$this->redirect(array('action' => 'index', $idParent));
		}
		/////////////////////////////////////////////////////////
		try{
			$this->AdmMenu->delete();
			$this->Session->setFlash(
				__('Se elimino correctamente'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}catch(Exception $e){
			if($e->getCode() == 23503){
				$msge = 'No se puede eliminar este Menu porque tiene Roles asignados';
			}else{
				$msge = 'Ocurrio un problema vuelva a intentarlo';
			}
			$this->Session->setFlash(
			$msge,
			'alert',
			array('plugin' => 'TwitterBootstrap','class' => 'alert-error')
			);
			$this->redirect(array('action' => 'index', $idParent));
		}
	}
	

	
////////////////////////////////////////
}
