<?php

App::uses('AppModel', 'Model');

/**
 * AdmRolesTransaction Model
 *
 * @property AdmRole $AdmRole
 * @property AdmTransaction $AdmTransaction
 */
class AdmRolesAction extends AppModel {

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
		'adm_action_id' => array(
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
		'AdmAction' => array(
			'className' => 'AdmAction',
			'foreignKey' => 'adm_action_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function saveActions($role, $insert, $delete) {
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		////////////////////////Deletes
		if (count($delete) > 0) {

			$admRolesActionIds = $this->find('list', array(
				'conditions' => array('AdmRolesAction.adm_role_id' => $role, 'AdmRolesAction.adm_action_id' => $delete),
				'fields' => array('AdmRolesAction.id', 'AdmRolesAction.id')
			));

			foreach ($admRolesActionIds as $admRolesActionId) {
				try {
					$this->id = $admRolesActionId;
					$this->delete();
				} catch (Exception $e) {
//				debug($e);
					$dataSource->rollback();
					return false;
				}
			}

		}

		////////////////////////inserts
		if (count($insert) > 0) {
			//Para Insertar, se debe formatear el vector para que reconozca ORM de cake
			$miData = array();
			$cont = 0;
			foreach ($insert as $var) {
				$miData[$cont]['adm_role_id'] = $role;
				$miData[$cont]['adm_action_id'] = $var;
				$cont++;
			}
			//debug($miData);
			try {
				$this->saveMany($miData);
			} catch (Exception $e) {
//				debug($e);
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

