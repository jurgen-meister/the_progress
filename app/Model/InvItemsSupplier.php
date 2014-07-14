<?php
App::uses('AppModel', 'Model');
/**
 * InvItemsSupplier Model
 *
 * @property InvSupplier $InvSupplier
 * @property InvItem $InvItem
 */
class InvItemsSupplier extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'InvSupplier' => array(
			'className' => 'InvSupplier',
			'foreignKey' => 'inv_supplier_id',
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
		)
	);
}
