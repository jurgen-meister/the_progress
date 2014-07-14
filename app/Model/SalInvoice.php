<?php
App::uses('AppModel', 'Model');
/**
 * SalInvoice Model
 *
 * @property SalSale $SalSale
 */
class SalInvoice extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'sal_sale_id' => array(
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
//	public $belongsTo = array(
//		'SalSale' => array(
//			'className' => 'SalSale',
//			'foreignKey' => 'sal_sale_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
//	);
}
