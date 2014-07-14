<?php

App::uses('AppController', 'Controller');

/**
 * AdmRolesMenus Controller
 *
 * @property AdmRolesMenu $AdmRolesMenu
 */
class AdmRolesMenusController extends AppController {


	public function save() {
		$admRoles = $this->AdmRolesMenu->AdmRole->find('list', array('order' => array('AdmRole.id' => 'ASC')));
		$parentsMenus = $this->AdmRolesMenu->AdmMenu->find("list", array(
			"conditions" => array(
				"AdmMenu.parent_node" => null, // don't have parent
				"AdmMenu.inside " => null //this will dissapear
			)
			, 'order' => array('AdmMenu.order_menu')
			, "recursive" => -1
		));
		///////////////////////***************************************//////////////////
		$this->set(compact('admRoles', 'parentsMenus'));
	}


	
	private function _fnCreateMenu($roleId, $parentMenuId){
		$menu = array();
		$counter = 0;
		$admMenu = $this->AdmRolesMenu->AdmMenu->find('list', array(
			'conditions'=>array(
				'AdmMenu.parent_node'=>$parentMenuId,
			),
			'order' => array('AdmMenu.order_menu'=>'ASC')
		));
		
		$admRoleMenu = $this->AdmRolesMenu->find('list', array(
			'conditions'=>array(
				'AdmRolesMenu.adm_role_id'=>$roleId,
				'AdmRolesMenu.adm_menu_id'=>  array_keys($admMenu),
			),
			'fields'=>array('AdmRolesMenu.id', 'AdmRolesMenu.adm_menu_id')
		));
		
		foreach ($admMenu as $admMenuId => $admMenuName) {
			$menu[$counter]['menuId'] = $admMenuId;
			$menu[$counter]['menuName'] = $admMenuName;
			$menu[$counter]['checked'] = 0;//unchecked
			foreach($admRoleMenu as $admRoleMenuId => $admRoleMenuMenuId){
				if($admMenuId == $admRoleMenuMenuId){
					$menu[$counter]['checked'] = $admRoleMenuId;
					unset($admRoleMenu[$admRoleMenuId]);
				}
			}
			$counter++;
		}
		return $menu;
	}
	

	public function ajax_list_menus() {
		if ($this->RequestHandler->isAjax()) {
			$roleId = $this->request->data['role'];
			$parentMenuId = $this->request->data['parentMenus'];
			$parentMenuName = $this->request->data['parentMenuName'];

			$menu = $this->_fnCreateMenu($roleId, $parentMenuId);
			
			$checkedParent = $this->AdmRolesMenu->find('count', array(
				'conditions'=>array('AdmRolesMenu.adm_role_id'=>$roleId, 'AdmRolesMenu.adm_menu_id'=>$parentMenuId)
			));
			$empty = 'yes';
			if($checkedParent > 0) $empty = 'no';
			
			$parentMenu = array('id'=>$parentMenuId, 'name'=>$parentMenuName, 'empty'=>$empty);
			$this->set("parentMenu", $parentMenu);
			$this->set("data", $menu);
		} else {
			$this->redirect($this->Auth->logout());
		}
	}


	public function ajax_save() {
		if ($this->RequestHandler->isAjax()) {
			$role = $this->request->data['role'];
			$parentMenu = $this->request->data['parentMenus'];
			$type = $this->request->data['type'];

			if (isset($this->request->data['menu'])) {
				$new = $this->request->data['menu'];
			} else {
				$new = array();
			}
			////check type menu or menu inside
			$valueType = null;
			if ($type == 'inside') {
				$valueType = 1;
			}

			///////////OLD values
			$catchOld = $this->AdmRolesMenu->find('all', array(
				'fields' => array('AdmRolesMenu.adm_menu_id')
				, 'conditions' => array('OR' => array('AdmMenu.parent_node' => $parentMenu, 'AdmMenu.id' => $parentMenu), 'AdmRolesMenu.adm_role_id' => $role, 'AdmMenu.inside' => $valueType)
			));

			$old = array();
			if (count($catchOld) > 0) {
				foreach ($catchOld as $key => $value) {
					$old[$key] = $value['AdmRolesMenu']['adm_menu_id'];
				}
			}

			//debug($old);
			//debug($new);
			/////////////
			if (count($new) == 0 AND count($old) == 0) {
				echo 'successEmpty'; 
			} else {
				$insert = array_diff($new, $old);
				$delete = array_diff($old, $new);
				if($this->AdmRolesMenu->saveMenus($role, $insert, $delete)){
					echo 'success';
				}else{
					echo 'error';
				}
			}
		} else {
			$this->redirect($this->Auth->logout());
		}
	}

//END CLASS
}


