<?php
App::uses('AppModel', 'Model');
/**
 * AdmPeriod Model
 *
 */
class AdmPeriod extends AppModel {

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
	
	
	
	public function saveNewPeriod($lastPeriod, $newPeriod, $creator){
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		////////////////////////////////////////////////
//		$error = 0;
		if($this->save(array('name'=>$newPeriod, 'creator'=> $creator))){
			ClassRegistry::init('AdmArea');
			$AdmArea = new AdmArea();
			$dataAreaUserRestriction = $AdmArea->find('all', array(
				'conditions'=>array('AdmArea.period'=>$lastPeriod),
				'fields'=>array('AdmArea.name', 'AdmArea.parent_area', 'AdmArea.period')
			));
			for($i=0; $i < count($dataAreaUserRestriction); $i++){
				unset($dataAreaUserRestriction[$i]['AdmArea']['id']);
				$dataAreaUserRestriction[$i]['AdmArea']['creator']=$creator;
				$dataAreaUserRestriction[$i]['AdmArea']['period']=$newPeriod;
				for($j=0; $j < count($dataAreaUserRestriction[$i]['AdmUserRestriction']); $j++){
					unset($dataAreaUserRestriction[$i]['AdmUserRestriction'][$j]['id']);
					unset($dataAreaUserRestriction[$i]['AdmUserRestriction'][$j]['adm_area_id']);
					unset($dataAreaUserRestriction[$i]['AdmUserRestriction'][$j]['period']);
					unset($dataAreaUserRestriction[$i]['AdmUserRestriction'][$j]['lc_state']);
					unset($dataAreaUserRestriction[$i]['AdmUserRestriction'][$j]['lc_transaction']);
					unset($dataAreaUserRestriction[$i]['AdmUserRestriction'][$j]['creator']);//
					unset($dataAreaUserRestriction[$i]['AdmUserRestriction'][$j]['date_created']);
					unset($dataAreaUserRestriction[$i]['AdmUserRestriction'][$j]['modifier']);
					unset($dataAreaUserRestriction[$i]['AdmUserRestriction'][$j]['date_modified']);
					$dataAreaUserRestriction[$i]['AdmUserRestriction'][$j]['creator'] = $creator;
					$dataAreaUserRestriction[$i]['AdmUserRestriction'][$j]['selected'] = 0;
					$dataAreaUserRestriction[$i]['AdmUserRestriction'][$j]['active_date'] = ($newPeriod+1).'-01-01 00:00:00';
					$dataAreaUserRestriction[$i]['AdmUserRestriction'][$j]['period'] = $newPeriod;
				}
//				if(!$AdmArea->saveAssociated($dataAreaUserRestriction[$i], array('deep' => true, 'atomic'=>false))){//it works without specifying deep and atomic, but I put it anyway, just in case
//					$error++;
//				}
				try{
					$AdmArea->saveAssociated($dataAreaUserRestriction[$i], array('deep' => true, 'atomic'=>false));
				}catch(Exception $e){
//					debug($e);
					$dataSource->rollback();
					return false;
//					$error++;
				}
			}
			
			$dataSource->commit();
			return true;
		}
		///////////////////////////////////////////////
		
	}
	
	
	
//END MODEL	
}
