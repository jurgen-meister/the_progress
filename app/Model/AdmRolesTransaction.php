<?php

App::uses('AppModel', 'Model');

/**
 * AdmRolesTransaction Model
 *
 * @property AdmRole $AdmRole
 * @property AdmTransaction $AdmTransaction
 */
class AdmRolesTransaction extends AppModel {

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
		'adm_transaction_id' => array(
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
		'AdmTransaction' => array(
			'className' => 'AdmTransaction',
			'foreignKey' => 'adm_transaction_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function saveTransactions($role, $insert, $delete) {
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		////////////////////////Deletes
		if (count($delete) > 0) {

			$admRolesTransactionIds = $this->find('list', array(
				'conditions' => array('AdmRolesTransaction.adm_role_id' => $role, 'AdmRolesTransaction.adm_transaction_id' => $delete),
				'fields' => array('AdmRolesTransaction.id', 'AdmRolesTransaction.id')
			));

			foreach ($admRolesTransactionIds as $admRolesTransactionId) {
				try {
					$this->id = $admRolesTransactionId;
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
				$miData[$cont]['adm_transaction_id'] = $var;
				$cont++;
			}
			//debug($miData);
			try{
				$this->saveMany($miData);
			}catch(Exception $e){
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
