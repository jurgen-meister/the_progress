<?php
App::uses('AppModel', 'Model');
/**
 * AdmController Model
 *
 * @property AdmModule $AdmModule
 * @property AdmState $AdmState
 * @property AdmAction $AdmAction
 */
class AdmController extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(		
		'adm_controllers_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'initials' => array(
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
		'AdmModule' => array(
			'className' => 'AdmModule',
			'foreignKey' => 'adm_module_id',
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
		'AdmState' => array(
			'className' => 'AdmState',
			'foreignKey' => 'adm_controller_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'AdmAction' => array(
			'className' => 'AdmAction',
			'foreignKey' => 'adm_controller_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'AdmTransaction' => array(
			'className' => 'AdmTransaction',
			'foreignKey' => 'adm_controller_id',
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
	
	public function createControlAndLifeCycles($controllerData){
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		////////////////////////////////////////////////
		$error = 0;
		$initials = $controllerData['AdmController']['adm_module_id'];
		$numericModuleId=$this->AdmModule->find('all', array('fields'=>'id','recursive'=>-1, 'conditions'=>array('AdmModule.initials'=>  strtolower($initials))));
		//debug($numericModuleId);
		if(count($numericModuleId) == 0){
			//$dataSource->rollback();
			$error++;
		}
		$controllerData['AdmController']['adm_module_id'] = $numericModuleId[0]['AdmModule']['id'];
		
		//Save controller
		if(!$this->save($controllerData)){
			//$dataSource->rollback();
			$error++;
		}
		$idController = $this->getInsertID();
		
		$admTransactions =array(
				array("adm_controller_id"=>$idController, "name"=>"CREATE", "description"=>"Record Creation", "sentence"=>"ADD"),
				array("adm_controller_id"=>$idController, "name"=>"MODIFY", "description"=>"Record Modification", "sentence"=>"EDIT"),
				array("adm_controller_id"=>$idController, "name"=>"ELIMINATE", "description"=>"Record Elimination", "sentence"=>"DELETE")
		);
		//Save transaction
		if(!$this->AdmTransaction->saveMany($admTransactions)){
			//$dataSource->rollback();
			$error++;
		}
		
		
		$admStates =array(
				array("adm_controller_id"=>$idController, "name"=>"INITIAL", "description"=>"Initial state (Non-existent)"),
				array("adm_controller_id"=>$idController, "name"=>"ELABORATED", "description"=>"Elaborated state"),
				array("adm_controller_id"=>$idController, "name"=>"FINAL", "description"=>"Final state (Non-existent)")
		);
		//Save states
		if(!$this->AdmState->saveMany($admStates)){
			//$dataSource->rollback();
			$error++;
		}
		
		$vector = $this->AdmState->find('all', array("recursive"=>-1, "conditions"=>array("adm_controller_id"=>$idController), "fields"=>"id"));
		foreach ($vector as $key => $val){
//			echo $val['AdmState']['id'];
			$vState[$key] = $val['AdmState']['id'];
		}

		$vector2 = $this->AdmTransaction->find('all', array("recursive"=>-1, "conditions"=>array("adm_controller_id"=>$idController), "fields"=>"id"));
		foreach ($vector2 as $key => $val){
//			echo $val['AdmTransaction']['id'];
			$vTransaction[$key] = $val['AdmTransaction']['id'];
		}


		$admTransitions =array(
			array("adm_state_id"=>$vState[0], "adm_transaction_id"=>$vTransaction[0], "adm_final_state_id"=>$vState[1]),
			array("adm_state_id"=>$vState[1], "adm_transaction_id"=>$vTransaction[1], "adm_final_state_id"=>$vState[1]),
			array("adm_state_id"=>$vState[1], "adm_transaction_id"=>$vTransaction[2], "adm_final_state_id"=>$vState[2])
		);
		//Save transitions
		if(!$this->AdmState->AdmTransition->saveMany($admTransitions)){
			//$dataSource->rollback();
			$error++;
		}
		//if everything ok then commit
		if($error == 0){
			$dataSource->commit();
			return true;
		}else{
			$dataSource->rollback();
			return false;
		}
		
		///////////////////////////////////////////////
		//$dataSource->rollback();
		//return false;
	}
	
	
}
