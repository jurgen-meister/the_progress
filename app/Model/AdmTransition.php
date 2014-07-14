<?php
App::uses('AppModel', 'Model');
/**
 * AdmTransition Model
 *
 * @property AdmState $AdmState
 * @property AdmAction $AdmAction
 */
class AdmTransition extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'AdmState' => array(
			'className' => 'AdmState',
			'foreignKey' => 'adm_state_id',
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
		),
            'AdmFinalState' => array(
			'className' => 'AdmState',
			'foreignKey' => 'adm_final_state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
