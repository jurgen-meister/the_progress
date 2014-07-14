<?php
App::uses('AppController', 'Controller');
/**
 * AdmRolesActions Controller
 *
 * @property AdmRolesAction $AdmRolesAction
 */
class AdmRolesActionsController extends AppController {


	public $layout = 'default';

	public function save() {
		$admRoles = $this->AdmRolesAction->AdmRole->find('list', array('order'=>array('AdmRole.id'=>'ASC')));
		$this->loadModel("AdmModule");
		$admModules = $this->AdmModule->find('list');
		$this->set(compact('admRoles', 'admModules'));
	}
	
	
//	private function _findMenus($var){
//		$vec = $this->AdmRolesMenu->AdmMenu->find('list', array('fields'=>array('AdmMenu.id', 'AdmMenu.id') , 'order'=>array('AdmMenu.order_menu'),'conditions'=>array("AdmMenu.parent_node"=>$var)));;
//		return $vec;
//	}

	
	private function _fnCreateCheckboxTree($role, $module){
		//Til 5 levels, MUST be improved	
		//PART 1
		$this->AdmRolesAction->AdmAction->unbindModel(array('hasMany'=>array('AdmMenu')));
		$actions = $this->AdmRolesAction->AdmAction->find('all', array(
			 'fields'=>array('AdmAction.id', 'AdmAction.name', 'AdmController.id', 'AdmController.name'),
			 'order'=>array('AdmController.name', 'AdmAction.name') 
			,'conditions'=>array('AdmController.adm_module_id'=>$module)
		));

		
		$this->loadModel("AdmController");
		$controllers = $this->AdmController->find("list", array("conditions"=>array('AdmController.adm_module_id'=>$module)));
//		debug($controllers);
		$data = array();
		$actionClean = array();
		//debug($actions);
		foreach ($actions as $keyAction => $action) {
			$actionClean[$keyAction] = $action["AdmAction"]["id"];
		}
		$checked = $this->AdmRolesAction->find("list", array(
			"fields"=>array("id", "adm_action_id"),
			"conditions"=>array("adm_action_id"=>$actionClean, "adm_role_id"=>$role)
		));
//		debug($actions);
		foreach ($actions as $keyAction => $action) {
			foreach ($controllers as $keyController => $controller) {
				if($action["AdmController"]["id"] == $keyController){
					$actionId = $action["AdmAction"]["id"];
					$data[$keyController]["controllerName"] = Inflector::camelize($controller);
					$data[$keyController]["controllerId"] = $keyController;
					$data[$keyController]["actions"][$actionId]["actionId"] = $actionId;
					$data[$keyController]["actions"][$actionId]["actionName"] = $action["AdmAction"]["name"];
					$data[$keyController]["actions"][$actionId]["actionChecked"] = $this->_fnCreateCheckAction($checked, $actionId);
				}
			}
			
		}
		
		$allChecked = '';
		foreach ($data as $key => $value){
			$checked = $this->_fnCreateCheckController($value['actions']);
			$data[$key]["controllerChecked"] = $checked;
			if($checked <> ''){
				$allChecked = 'checked = "checked"';
			}
		}
		return array('data'=>$data, 'allChecked'=>$allChecked);
		
		
	}
	
	
	
	private function _fnCreateCheckAction($checked, $actionId){
		$str = '';
		if(count($checked) > 0){
			foreach ($checked as $key => $value) {
				if($value == $actionId){
					$str = 'checked = "checked"';
				}
			}
		}
		
		return $str;
	}
	
	private function _fnCreateCheckController($actions){
		if(count($actions) > 0){
			foreach ($actions as $key => $value) {
				if($value['actionChecked'] <> ''){
					return $value['actionChecked'];
				}
			}
		}
		return '';
	}
	
	public function ajax_list_actions(){
		if($this->RequestHandler->isAjax()){
			$role = $this->request->data['role'];
			$module = $this->request->data['module'];
			
			$chkTree = $this->_fnCreateCheckboxTree($role, $module);
			///////////////////////***************************************//////////////////
			$this->set('data', $chkTree['data']);
			$this->set('allChecked', $chkTree['allChecked']);
		}else{
			$this->redirect($this->Auth->logout());
		}
	}
	

	
	public function ajax_save(){
		if($this->RequestHandler->isAjax()){
			$role = $this->request->data['role'];
			$module = $this->request->data['module'];
			//Capture checkbox values

			
			if(isset($this->request->data['menu'])){
				$new = $this->request->data['menu']; 
			}else{
				$new = array();
			}
			
			//debug($new);
			
			////check type menu or menu inside

			///////////OLD values
			//$old = $this->AdmRolesMenu->AdmMenu->find('list', array('fields'=>array('AdmMenu.id', 'AdmMenu.id'),'conditions'=>array('AdmRolesMenu.adm_role_id'=>$role, 'AdmMenu.adm_module_id'=>1)));
			$this->AdmRolesAction->bindModel(array(
                    'belongsTo'=>array(
                        'AdmController' => array(
                            'foreignKey' => false,
                            'conditions' => array('AdmAction.adm_controller_id = AdmController.id', '')
                        )
                    )
                ));
			$catchOld = $this->AdmRolesAction->find('all', array(
				'fields'=>array('AdmRolesAction.adm_action_id')
				,'conditions'=>array('AdmRolesAction.adm_role_id'=>$role, 'AdmController.adm_module_id'=>$module)
				));			
			//debug($catchOld);
			
			
			
			$old=array();
			if(count($catchOld) > 0){
				foreach ($catchOld as $key => $value) {
					$old[$key]=$value['AdmRolesAction']['adm_action_id'];
				}
			}
	
			//debug($old);
			//debug($new);
			//echo "old";
			//debug($catchOld);
			//debug($old);
			//echo "new";
			//debug($new);	
			/////////////
			if(count($new) == 0 AND count($old) == 0){
				echo 'successEmpty'; // when there is no new or old values to save
             }else{
				$insert=array_diff($new,$old);
				//echo "insert";
				//debug($insert);
				$delete=array_diff($old,$new);
				//debug($delete);
				if($this->AdmRolesAction->saveActions($role, $insert, $delete)){
					echo 'success'; // envia al data del js de jquery
				}else{
					echo 'error';
				}
			} 
 
		}else{//ajax
			$this->redirect($this->Auth->logout());
		}//ajax

	}//function
	

////// End Controller	
}
