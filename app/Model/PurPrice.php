<?php
App::uses('AppModel', 'Model');
/**
 * PurPrice Model
 *
 * @property InvPriceType $InvPriceType
 * @property PurPurchase $PurPurchase
 */
class PurPrice extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'inv_price_type_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'InvPriceType' => array(
			'className' => 'InvPriceType',
			'foreignKey' => 'inv_price_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PurPurchase' => array(
			'className' => 'PurPurchase',
			'foreignKey' => 'pur_purchase_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
