<?php

class BittionSecurityComponent extends Component{
	
	private $userSessionPasswordKey = '495d654f495d654f495d654f495d654f';
	
	public function encryptUserSessionPassword($text){
//		$encrypt = Security::rijndael($auth['login'], '495d654f495d654f495d654f495d654f', 'encrypt');
		return Security::rijndael($text, $this->userSessionPasswordKey, 'encrypt');
	}
	
	public function decryptUserSessionPassword($text){
		return Security::rijndael($text, $this->userSessionPasswordKey, 'decrypt');
	}
	
	public function allowPermission($controllerName, $actionName, $normalActions) {
		//Check all the Ajax actions inside the controller
		App::import('Controller', $controllerName);
		$parentClassMethods = get_class_methods(get_parent_class($controllerName . 'Controller'));
		//debug($parentClassMethods);
		$subClassMethods = get_class_methods($controllerName . 'Controller');
//		debug($subClassMethods);
		$classMethods = array_diff($subClassMethods, $parentClassMethods);
//		debug($classMethods);
		$ajaxActions = array();
		foreach ($classMethods as $value) {
			//to allow bu default ajax view and public fn (functions, commonly use for ajax, private functions don't enter here)
			if (strtolower(substr($value, 0, 4)) == 'ajax' OR strtolower(substr($value, 0, 2)) == 'fn' ) {
				$ajaxActions[$value] = $value;
			}
		}
		if (count($normalActions) == 0) {
			return false;
		}
//		debug($normalActions);
//		debug($ajaxActions);
		$allowed = array_unique(array_merge($normalActions, $ajaxActions));

//		debug($allowed);
		
		if (count($allowed) > 0) {
			if (in_array($actionName, $allowed)) {
				return true;
			}
		}
		return false;
	}
	
	
	public function liveCheckUserRoleActive($idUserRestriction){
//		$this->loadModel('AdmUser');
		$this->AdmUser = ClassRegistry::init('AdmUser');
		$checkActive = $this->AdmUser->AdmUserRestriction->find('all', array(
			'conditions' => array(
				'AdmUserRestriction.id' => $idUserRestriction,
				'AdmUserRestriction.lc_state !='=>'LOGIC_DELETED'
//				'AdmUser.active' => 1,
//				'AdmUser.active_date > now()',
//				'AdmUserRestriction.active' => 1,
//				'AdmUserRestriction.active_date > now()',
//				'AdmUserRestriction.selected' => 1
			),
			'fields' => array(
//				'AdmUserRestriction.id'
				 'AdmUser.active'
				, '(CASE WHEN "AdmUser"."active_date" > now() THEN 1 ELSE 0 END) as user_active_date'
				, 'AdmUserRestriction.active'
				, '(CASE WHEN "AdmUserRestriction"."active_date" > now() THEN 1 ELSE 0 END) as "restriction_active_date"'
				, 'AdmUserRestriction.selected'
			),
//			'order' => array('AdmUserRestriction.adm_role_id', 'AdmUserRestriction.period')
		));

//		debug($checkActive);
		
		if(count($checkActive) == 0) return 'empty';
		if($checkActive[0]['AdmUser']['active'] <> 1)return 'user inactive'; 
		if($checkActive[0]['AdmUserRestriction']['active'] <> 1)return 'role inactive';
		if($checkActive[0][0]['user_active_date'] <> 1)return 'user expired';
		if($checkActive[0][0]['restriction_active_date'] <> 1)return 'role expired';
		if($checkActive[0]['AdmUserRestriction']['selected'] <> 1)return 'unselected';
		
		return '';
	}
//END CLASS	
}
?>
