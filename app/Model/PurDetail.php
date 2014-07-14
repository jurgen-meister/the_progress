<?php
App::uses('AppModel', 'Model');
/**
 * PurDetail Model
 *
 * @property PurPurchase $PurPurchase
 * @property InvItem $InvItem
 */
class PurDetail extends AppModel {

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
		'inv_item_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'quantity' => array(
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
		'InvItem' => array(
			'className' => 'InvItem',
			'foreignKey' => 'inv_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'InvSupplier' => array(
			'className' => 'InvSupplier',
			'foreignKey' => 'inv_supplier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
