<?php

App::uses('AppModel', 'Model');

/**
 * AdmRolesMenu Model
 *
 * @property AdmRole $AdmRole
 * @property AdmMenu $AdmMenu
 */
class AdmRolesMenu extends AppModel {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'adm_role_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'adm_menu_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'AdmRole' => array(
			'className' => 'AdmRole',
			'foreignKey' => 'adm_role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'AdmMenu' => array(
			'className' => 'AdmMenu',
			'foreignKey' => 'adm_menu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function saveMenus($role, $insert, $delete) {
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		////////////////////////////////////////////////
		if (count($delete) > 0) {
			$admRolesMenuIds = $this->find('list', array(
				'conditions' => array('AdmRolesMenu.adm_role_id' => $role, 'AdmRolesMenu.adm_menu_id' => $delete),
				'fields' => array('AdmRolesMenu.id', 'AdmRolesMenu.id')
			));

			foreach ($admRolesMenuIds as $admRolesMenuId) {
				try {
					$this->id = $admRolesMenuId;
					$this->delete();
				} catch (Exception $e) {
//				debug($e);
					$dataSource->rollback();
					return false;
				}
			}
		}

		if (count($insert) > 0) {
			$data = array();
			$cont = 0;
			foreach ($insert as $var) {
				$data[$cont]['adm_role_id'] = $role;
				$data[$cont]['adm_menu_id'] = $var;
				$cont++;
			}
			try {
				$this->saveMany($data);
			} catch (Exception $e) {
				$dataSource->rollback();
				return false;
			}
		}
		///////////////////////////////////////////
		$dataSource->commit();
		return true;
	}

//END CLASS	
}
