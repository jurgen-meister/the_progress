<?php
App::uses('AppModel', 'Model');
/**
 * InvPrice Model
 *
 * @property InvItem $InvItem
 * @property InvPriceType $InvPriceType
 */
class InvPrice extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'inv_item_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'inv_price_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'InvItem' => array(
			'className' => 'InvItem',
			'foreignKey' => 'inv_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'InvPriceType' => array(
			'className' => 'InvPriceType',
			'foreignKey' => 'inv_price_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
