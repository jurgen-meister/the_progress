<?php
App::uses('AppModel', 'Model');
/**
 * SalEmployee Model
 *
 * @property SalCustomer $SalCustomer
 * @property SalSale $SalSale
 */
class SalEmployee extends AppModel {

//	public $virtualFields = array("full_name"=>"CONCAT(SalEmployee.first_name , ' ', SalEmployee.last_name)");
//	public $displayField = 'full_name';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'sal_customer_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
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
		'SalCustomer' => array(
			'className' => 'SalCustomer',
			'foreignKey' => 'sal_customer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'SalSale' => array(
			'className' => 'SalSale',
			'foreignKey' => 'sal_employee_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
