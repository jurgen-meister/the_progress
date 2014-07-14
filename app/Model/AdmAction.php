<?php
App::uses('AppModel', 'Model');
/**
 * AdmAction Model
 *
 * @property AdmController $AdmController
 * @property AdmMenu $AdmMenu
 */
class AdmAction extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	
	public function myQuery(){
//		$sql = "SELECT * FROM adm_actions";
//		$sql ="INSERT INTO adm_user_logs(tipo, success, creator) VALUES('mylogin', 1, 1)";
//        return $this->query($sql);
		$sql = "ALTER USER icassia WITH PASSWORD 'cualquier';";
		try{
			$this->query($sql);	
			return true;
		}catch(Exception $e){
			return false;
		}
		
//		if($res){
//			return true;
//		}
	}
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
		'description' => array(
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
		'AdmController' => array(
			'className' => 'AdmController',
			'foreignKey' => 'adm_controller_id',
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
		'AdmMenu' => array(
			'className' => 'AdmMenu',
			'foreignKey' => 'adm_action_id',
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
