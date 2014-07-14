<?php
App::uses('AppModel', 'Model');
/**
 * PurPayment Model
 *
 * @property PurPurchase $PurPurchase
 * @property PurPaymentType $PurPaymentType
 */
class PurPayment extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'pur_purchase_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'pur_payment_type_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'due_date' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'amount' => array(
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
		'PurPurchase' => array(
			'className' => 'PurPurchase',
			'foreignKey' => 'pur_purchase_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PurPaymentType' => array(
			'className' => 'PurPaymentType',
			'foreignKey' => 'pur_payment_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
