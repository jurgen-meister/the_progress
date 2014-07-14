<?php
App::uses('AppModel', 'Model');
/**
 * PurPurchase Model
 *
 * @property InvSupplier $InvSupplier
 * @property PurPrice $PurPrice
 * @property PurPayment $PurPayment
 * @property PurDetail $PurDetail
 */
class PurPurchase extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
//		'inv_supplier_id' => array(
//			'notempty' => array(
//				'rule' => array('notempty'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
		'code' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'date' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'InvWarehouse' => array(
			'className' => 'InvWarehouse',
			'foreignKey' => 'inv_warehouse_id',
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
		'PurPrice' => array(
			'className' => 'PurPrice',
			'foreignKey' => 'pur_purchase_id',
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
		'PurPayment' => array(
			'className' => 'PurPayment',
			'foreignKey' => 'pur_purchase_id',
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
		'PurDetail' => array(
			'className' => 'PurDetail',
			'foreignKey' => 'pur_purchase_id',
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

	public function saveMovement($dataPurchase, $dataPurchaseDetail, $dataMovement, $dataMovementDetail, $dataMovementHeadsUpd, $OPERATION, $ACTION, $STATE, $dataPayDetail, $dataCostDetail, $arrayFobPrices, $arrayCifPrices){
		$dataSource = $this->getDataSource();
		$dataSource->begin();
	
		///////////////////////////////////////Start - Save Purchase////////////////////////////////////////////
		/*Saving Order*/
		if(!$this->saveAll($dataPurchase[0])){
			$dataSource->rollback();
			return 'ERROR';
		}else{
			$idPurchase1 = $this->id;
			$dataPurchaseDetail[0]['PurDetail']['pur_purchase_id']=$idPurchase1;
			if($dataPayDetail != array()){
				$dataPayDetail['PurPayment']['pur_purchase_id']=$idPurchase1;
			}
			if($dataCostDetail != array()){
				$dataCostDetail['PurPrice']['pur_purchase_id']=$idPurchase1;
			}
		}
		if($ACTION=='save_order' && $STATE != 'ORDER_CANCELLED'){
			/*Saving Invoice*/
			if(!$this->saveAll($dataPurchase[1])){
				$dataSource->rollback();
				return 'ERROR';
			}else{
				$idPurchase2 = $this->id;
				$dataPurchaseDetail[1]['PurDetail']['pur_purchase_id']=$idPurchase2;
			}
		}	
		if($OPERATION != 'ADD_PAY' && $OPERATION != 'EDIT_PAY' && $OPERATION != 'DELETE_PAY' && $OPERATION != 'ADD_COST' && $OPERATION != 'EDIT_COST' && $OPERATION != 'DELETE_COST' && $STATE != 'ORDER_CANCELLED'){
			/*Saving Movement*/
			if(!ClassRegistry::init('InvMovement')->saveAll($dataMovement)){
				$dataSource->rollback();
				return 'ERROR';
			}else{
				$idMovement = ClassRegistry::init('InvMovement')->id;
				$dataMovementDetail['InvMovementDetail']['inv_movement_id']=$idMovement;
			}
		}	
			
		/*Updating Movement Heads*/
		if($dataMovementHeadsUpd <> array()){
			if(!ClassRegistry::init('InvMovement')->saveAll($dataMovementHeadsUpd)){
				$dataSource->rollback();
				return 'ERROR';
			}
		}	
					
		///////////////////////////////////////End - Save Movement////////////////////////////////////////////
		
			switch ($OPERATION) {
				case 'ADD':
					if(!$this->PurDetail->saveAll($dataPurchaseDetail[0])){
						$dataSource->rollback();
						return 'ERROR';
					}
					if($ACTION=='save_order'){
						if(!$this->PurDetail->saveAll($dataPurchaseDetail[1])){
							$dataSource->rollback();
							return 'ERROR';
						}
					}	
					if(!ClassRegistry::init('InvMovement')->InvMovementDetail->saveAll($dataMovementDetail)){
						$dataSource->rollback();
						return 'ERROR';
					}
					
					break;
				case 'ADD_PAY':	
					if($dataPayDetail != array()){
						if(!$this->PurPayment->saveAll($dataPayDetail)){
							$dataSource->rollback();
							return 'ERROR';
						}
					}
					break;
				case 'ADD_COST':	
					if($dataCostDetail != array()){
						if(!$this->PurPrice->saveAll($dataCostDetail)){
							$dataSource->rollback();
							return 'ERROR';
						}
					}
					break;	
				case 'EDIT':							//array fields
//					if($this->PurDetail->updateAll(array(/*'PurDetail.lc_transaction'=>"'MODIFY'",*/
//															'PurDetail.ex_fob_price'=>$dataPurchaseDetail[0]['PurDetail']['ex_fob_price'], 
//															'PurDetail.quantity'=>$dataPurchaseDetail[0]['PurDetail']['quantity'], 
//															'PurDetail.fob_price'=>$dataPurchaseDetail[0]['PurDetail']['fob_price'],
//															'PurDetail.ex_subtotal'=>$dataPurchaseDetail[0]['PurDetail']['ex_subtotal']/*,
//															'PurDetail.fob_price'=>$dataMovementDetail['PurDetail']['fob_price'],
//															'PurDetail.ex_fob_price'=>$dataMovementDetail['PurDetail']['ex_fob_price'],
//															'PurDetail.cif_price'=>$dataMovementDetail['PurDetail']['cif_price'],
//															'PurDetail.ex_cif_price'=>$dataMovementDetail['PurDetail']['ex_cif_price']*/), 
//								/*array conditions*/array('PurDetail.pur_purchase_id'=>$dataPurchaseDetail[0]['PurDetail']['pur_purchase_id'], 
//														'PurDetail.inv_supplier_id'=>$dataPurchaseDetail[0]['PurDetail']['inv_supplier_id'], 
//														'PurDetail.inv_item_id'=>$dataPurchaseDetail[0]['PurDetail']['inv_item_id']))){
//						$rowsAffected = $this->getAffectedRows();//must do this because updateAll always return true
//					}
//					if($rowsAffected == 0){
//						$dataSource->rollback();
//						return 'ERROR';
//					}

					$purDetailsIds = $this->PurDetail->find('list', array(
							'conditions'=>array(
								'PurDetail.pur_purchase_id'=>$dataPurchaseDetail[0]['PurDetail']['pur_purchase_id'], 
								'PurDetail.inv_supplier_id'=>$dataPurchaseDetail[0]['PurDetail']['inv_supplier_id'], 
								'PurDetail.inv_item_id'=>$dataPurchaseDetail[0]['PurDetail']['inv_item_id']
							),
							'fields'=>array('PurDetail.id', 'PurDetail.id')
						));
						
					foreach ($purDetailsIds as $purDetailsId) {
						try {
								$this->PurDetail->save(array(
									'id'=>$purDetailsId, 
									'ex_fob_price'=>$dataPurchaseDetail[0]['PurDetail']['ex_fob_price'], 
									'quantity'=>$dataPurchaseDetail[0]['PurDetail']['quantity'], 
									'fob_price'=>$dataPurchaseDetail[0]['PurDetail']['fob_price'],
									'ex_subtotal'=>$dataPurchaseDetail[0]['PurDetail']['ex_subtotal'])
								);
						} catch (Exception $e) {
//								debug($e);
							$dataSource->rollback();
							return 'ERROR';
						}
					}			
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					if($ACTION=='save_order'){
//						if($this->PurDetail->updateAll(array(/*'PurDetail.lc_transaction'=>"'MODIFY'",*/
//																'PurDetail.ex_fob_price'=>$dataPurchaseDetail[1]['PurDetail']['ex_fob_price'], 
//																'PurDetail.quantity'=>$dataPurchaseDetail[1]['PurDetail']['quantity'], 
//																'PurDetail.fob_price'=>$dataPurchaseDetail[1]['PurDetail']['fob_price'],
//																'PurDetail.ex_subtotal'=>$dataPurchaseDetail[1]['PurDetail']['ex_subtotal']/*,
//																'PurDetail.fob_price'=>$dataMovementDetail['PurDetail']['fob_price'],
//																'PurDetail.ex_fob_price'=>$dataMovementDetail['PurDetail']['ex_fob_price'],
//																'PurDetail.cif_price'=>$dataMovementDetail['PurDetail']['cif_price'],
//																'PurDetail.ex_cif_price'=>$dataMovementDetail['PurDetail']['ex_cif_price']*/), 
//									/*array conditions*/array('PurDetail.pur_purchase_id'=>$dataPurchaseDetail[1]['PurDetail']['pur_purchase_id'], 
//															'PurDetail.inv_supplier_id'=>$dataPurchaseDetail[1]['PurDetail']['inv_supplier_id'], 
//															'PurDetail.inv_item_id'=>$dataPurchaseDetail[1]['PurDetail']['inv_item_id']))){
//							$rowsAffected = $this->getAffectedRows();//must do this because updateAll always return true
//						}
//						if($rowsAffected == 0){
//							$dataSource->rollback();
//							return 'ERROR';
//						}	
														
						$purDetailsIds = $this->PurDetail->find('list', array(
							'conditions'=>array(
								'PurDetail.pur_purchase_id'=>$dataPurchaseDetail[1]['PurDetail']['pur_purchase_id'], 
								'PurDetail.inv_supplier_id'=>$dataPurchaseDetail[1]['PurDetail']['inv_supplier_id'], 
								'PurDetail.inv_item_id'=>$dataPurchaseDetail[1]['PurDetail']['inv_item_id']
							),
							'fields'=>array('PurDetail.id', 'PurDetail.id')
						));

						foreach ($purDetailsIds as $purDetailsId) {
							try {
									$this->PurDetail->save(array(
										'id'=>$purDetailsId, 
										'ex_fob_price'=>$dataPurchaseDetail[1]['PurDetail']['ex_fob_price'], 
										'quantity'=>$dataPurchaseDetail[1]['PurDetail']['quantity'], 
										'fob_price'=>$dataPurchaseDetail[1]['PurDetail']['fob_price'],
										'ex_subtotal'=>$dataPurchaseDetail[1]['PurDetail']['ex_subtotal'])
									);
							} catch (Exception $e) {
	//								debug($e);
								$dataSource->rollback();
								return 'ERROR';
							}
						}
					}		
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------					
					
//					if(ClassRegistry::init('InvMovement')->InvMovementDetail->updateAll(array(/*'InvMovementDetail.lc_transaction'=>"'MODIFY'", */'InvMovementDetail.quantity'=>$dataMovementDetail['InvMovementDetail']['quantity']), 
//																						array('InvMovementDetail.inv_movement_id'=>$dataMovementDetail['InvMovementDetail']['inv_movement_id'],	
//																							'InvMovementDetail.inv_item_id'=>$dataMovementDetail['InvMovementDetail']['inv_item_id']))){
//							$rowsAffected = $this->getAffectedRows();//must do this because updateAll always return true
//					}
//					if($rowsAffected == 0){
//						$dataSource->rollback();
//						return 'ERROR';
//					}
					
					$invMovementDetailsIds = ClassRegistry::init('InvMovement')->InvMovementDetail->find('list', array(
						'conditions'=>array(
							'InvMovementDetail.inv_movement_id'=>$dataMovementDetail['InvMovementDetail']['inv_movement_id'],
							'InvMovementDetail.inv_item_id'=>$dataMovementDetail['InvMovementDetail']['inv_item_id']
						),
						'fields'=>array('InvMovementDetail.id', 'InvMovementDetail.id')
					));

					foreach ($invMovementDetailsIds as $invMovementDetailsId) {
						try {
								ClassRegistry::init('InvMovement')->InvMovementDetail->save(array(
									'id'=>$invMovementDetailsId, 
									'quantity'=>$dataMovementDetail['InvMovementDetail']['quantity'])
								);
						} catch (Exception $e) {
//								debug($e);
							$dataSource->rollback();
							return 'ERROR';
						}
					}
						
					break;
					
				case 'EDIT_PAY':
//					if($this->PurPayment->updateAll(array(/*'PurPayment.lc_transaction'=>"'MODIFY'", */'PurPayment.amount'=>$dataPayDetail['PurPayment']['amount'], 
//															'PurPayment.description'=>"'".$dataPayDetail['PurPayment']['description']."'", 
//															'PurPayment.ex_amount'=>$dataPayDetail['PurPayment']['ex_amount']),
//								/*array conditions*/array('PurPayment.pur_purchase_id'=>$dataPayDetail['PurPayment']['pur_purchase_id'], 
//														'PurPayment.pur_payment_type_id'=>$dataPayDetail['PurPayment']['pur_payment_type_id'],	
//														'PurPayment.date'=>$dataPayDetail['PurPayment']['date']))){
//						$rowsAffected = $this->getAffectedRows();//must do this because updateAll always return true
//					}
//					if($rowsAffected == 0){
//						$dataSource->rollback();
//						return 'ERROR';
//					}
					
					$purPaymentsIds = $this->PurPayment->find('list', array(
						'conditions'=>array(
							'PurPayment.pur_purchase_id'=>$dataPayDetail['PurPayment']['pur_purchase_id'], 
							'PurPayment.pur_payment_type_id'=>$dataPayDetail['PurPayment']['pur_payment_type_id'],	
							'PurPayment.date'=>$dataPayDetail['PurPayment']['date']
						),
						'fields'=>array('PurPayment.id', 'PurPayment.id')
					));

					foreach ($purPaymentsIds as $purPaymentsId) {
						try {
								$this->PurPayment->save(array(
									'id'=>$purPaymentsId, 
									'amount'=>$dataPayDetail['PurPayment']['amount'], 
									'description'=>"'".$dataPayDetail['PurPayment']['description']."'", 
									'ex_amount'=>$dataPayDetail['PurPayment']['ex_amount'])
								);
						} catch (Exception $e) {
//								debug($e);
							$dataSource->rollback();
							return 'ERROR';
						}
					}
					break;
				case 'EDIT_COST':
//					if($this->PurPrice->updateAll(array(/*'PurPrice.lc_transaction'=>"'MODIFY'",*/ 'PurPrice.amount'=>$dataCostDetail['PurPrice']['amount'], 				
//															'PurPrice.ex_amount'=>$dataCostDetail['PurPrice']['ex_amount']),
//								/*array conditions*/array('PurPrice.pur_purchase_id'=>$dataCostDetail['PurPrice']['pur_purchase_id'], 
//														'PurPrice.inv_price_type_id'=>$dataCostDetail['PurPrice']['inv_price_type_id']))){
//						$rowsAffected = $this->getAffectedRows();//must do this because updateAll always return true
//					}
//					if($rowsAffected == 0){
//						$dataSource->rollback();
//						return 'ERROR';
//					}
					$purPricesIds = $this->PurPrice->find('list', array(
						'conditions'=>array(
							'PurPrice.pur_purchase_id'=>$dataCostDetail['PurPrice']['pur_purchase_id'], 
							'PurPrice.inv_price_type_id'=>$dataCostDetail['PurPrice']['inv_price_type_id']
						),
						'fields'=>array('PurPrice.id', 'PurPrice.id')
					));

					foreach ($purPricesIds as $purPricesId) {
						try {
								$this->PurPrice->save(array(
									'id'=>$purPricesId, 
									'amount'=>$dataCostDetail['PurPrice']['amount'], 				
									'ex_amount'=>$dataCostDetail['PurPrice']['ex_amount'])
								);
						} catch (Exception $e) {
//								debug($e);
							$dataSource->rollback();
							return 'ERROR';
						}
					}
					
					break;	
				case 'DELETE':
//					if(!$this->PurDetail->deleteAll(array('PurDetail.pur_purchase_id'=>$dataPurchaseDetail[0]['PurDetail']['pur_purchase_id'],	
//															'PurDetail.inv_supplier_id'=>$dataPurchaseDetail[0]['PurDetail']['inv_supplier_id'], 
//															'PurDetail.inv_item_id'=>$dataPurchaseDetail[0]['PurDetail']['inv_item_id']))){
					$purDetailsIds = $this->PurDetail->find('list', array(
						'conditions' => array(
							'PurDetail.pur_purchase_id'=>$dataPurchaseDetail[0]['PurDetail']['pur_purchase_id'],	
							'PurDetail.inv_supplier_id'=>$dataPurchaseDetail[0]['PurDetail']['inv_supplier_id'], 
							'PurDetail.inv_item_id'=>$dataPurchaseDetail[0]['PurDetail']['inv_item_id']
						),
						'fields' => array('PurDetail.id', 'PurDetail.id')
					));
					
					foreach ($purDetailsIds as $purDetailsId) {
						try {
							$this->PurDetail->id = $purDetailsId;	
							$this->PurDetail->delete();
						} catch (Exception $e) {
//								debug($e);
							$dataSource->rollback();
							return 'ERROR';
						}
					}	
					if($ACTION=='save_order'){
//						if(!$this->PurDetail->deleteAll(array('PurDetail.pur_purchase_id'=>$dataPurchaseDetail[1]['PurDetail']['pur_purchase_id'],	
//																'PurDetail.inv_supplier_id'=>$dataPurchaseDetail[1]['PurDetail']['inv_supplier_id'], 
//																'PurDetail.inv_item_id'=>$dataPurchaseDetail[1]['PurDetail']['inv_item_id']))){
//							$dataSource->rollback();
//							return 'ERROR';
//						}
					
						$purDetailsIds = $this->PurDetail->find('list', array(
							'conditions' => array(
								'PurDetail.pur_purchase_id'=>$dataPurchaseDetail[1]['PurDetail']['pur_purchase_id'],	
								'PurDetail.inv_supplier_id'=>$dataPurchaseDetail[1]['PurDetail']['inv_supplier_id'], 
								'PurDetail.inv_item_id'=>$dataPurchaseDetail[1]['PurDetail']['inv_item_id']
							),
							'fields' => array('PurDetail.id', 'PurDetail.id')
						));
						
						foreach ($purDetailsIds as $purDetailsId) {
							try {
								$this->PurDetail->id = $purDetailsId;	
								$this->PurDetail->delete();
							} catch (Exception $e) {
//								debug($e);
								$dataSource->rollback();
								return 'ERROR';
							}
						}	
					}
//					if(!ClassRegistry::init('InvMovement')->InvMovementDetail->deleteAll(array('InvMovementDetail.inv_movement_id'=>$dataMovementDetail['InvMovementDetail']['inv_movement_id'],	
//																									'InvMovementDetail.inv_item_id'=>$dataMovementDetail['InvMovementDetail']['inv_item_id']))){
//						$dataSource->rollback();
//						return 'ERROR';
//					}
					
					$invMovementDetailsIds = ClassRegistry::init('InvMovement')->InvMovementDetail->find('list', array(
						'conditions' => array(
							'InvMovementDetail.inv_movement_id' => $dataMovementDetail['InvMovementDetail']['inv_movement_id'],
							'InvMovementDetail.inv_item_id' => $dataMovementDetail['InvMovementDetail']['inv_item_id']
						),
						'fields' => array('InvMovementDetail.id', 'InvMovementDetail.id')
					));

					foreach ($invMovementDetailsIds as $invMovementDetailsId) {
						try {
							ClassRegistry::init('InvMovement')->InvMovementDetail->id = $invMovementDetailsId;	
							ClassRegistry::init('InvMovement')->InvMovementDetail->delete();
						} catch (Exception $e) {
//								debug($e);
							$dataSource->rollback();
							return 'ERROR';
						}
					}
					break;
				case 'DELETE_PAY':
//					if(!$this->PurPayment->deleteAll(array('PurPayment.pur_purchase_id'=>$dataPayDetail['PurPayment']['pur_purchase_id'], 
//															'PurPayment.date'=>$dataPayDetail['PurPayment']['date']))){
//						$dataSource->rollback();
//						return 'ERROR';
//					}
					
					$purPaymentsIds = $this->PurPayment->find('list', array(
						'conditions'=>array(
							'PurPayment.pur_purchase_id'=>$dataPayDetail['PurPayment']['pur_purchase_id'], 
							'PurPayment.pur_payment_type_id'=>$dataPayDetail['PurPayment']['pur_payment_type_id'],	
							'PurPayment.date'=>$dataPayDetail['PurPayment']['date']
						),
						'fields'=>array('PurPayment.id', 'PurPayment.id')
					));

					foreach ($purPaymentsIds as $purPaymentsId) {
						try {
							$this->PurPayment->id = $purPaymentsId;	
							$this->PurPayment->delete();
						} catch (Exception $e) {
//								debug($e);
							$dataSource->rollback();
							return 'ERROR';
						}
					}
					break;
				case 'DELETE_COST':
//					if(!$this->PurPrice->deleteAll(array('PurPrice.pur_purchase_id'=>$dataCostDetail['PurPrice']['pur_purchase_id'], 
//															'PurPrice.inv_price_type_id'=>$dataCostDetail['PurPrice']['inv_price_type_id']))){
//						$dataSource->rollback();
//						return 'ERROR';
//					}
					
					$purPricesIds = $this->PurPrice->find('list', array(
							'conditions'=>array(
								'PurPrice.pur_purchase_id'=>$dataCostDetail['PurPrice']['pur_purchase_id'], 
								'PurPrice.inv_price_type_id'=>$dataCostDetail['PurPrice']['inv_price_type_id']
							),
							'fields'=>array('PurPrice.id', 'PurPrice.id')
						));
						foreach ($purPricesIds as $purPricesId) {
							try {
								$this->PurPrice->id = $purPricesId;	
								$this->PurPrice->delete();
							} catch (Exception $e) {
//								debug($e);
								$dataSource->rollback();
								return 'ERROR';
							}
						}
					break;	
			}	
			
			if ($ACTION == 'save_invoice' && $STATE == 'PINVOICE_APPROVED' &&  $arrayCifPrices != array()){
			
				if(!ClassRegistry::init('InvPrice')->saveAll($arrayCifPrices)){
					$dataSource->rollback();
					return 'error';
				}
				
			}	
			
			if ($ACTION == 'save_invoice' && $STATE == 'PINVOICE_APPROVED' &&  $arrayFobPrices != array()){
			
				if(!ClassRegistry::init('InvPrice')->saveAll($arrayFobPrices)){
					$dataSource->rollback();
					return 'error';
				}
				
			}	
		$dataSource->commit();
		return array('SUCCESS', $STATE.'|'.$idPurchase1);
	}
	
	public function updateMovement($dataPurchase, $dataMovement){
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		if($dataPurchase[0] != array()){
			if(!$this->saveAll($dataPurchase[0])){
				$dataSource->rollback();
				return 'ERROR';
			}else{
				$idPurchase = $this->id;
			}
		}	
		if($dataPurchase[1] != array()){
			if(!$this->saveAll($dataPurchase[1])){
				$dataSource->rollback();
				return 'ERROR';
			}else{
				$idPurchase = $this->id;
			}
		}	
		if($dataMovement != array()){
			if(!ClassRegistry::init('InvMovement')->saveAll($dataMovement)){
				$dataSource->rollback();
				return 'ERROR';
			}else{
				$idMovement = ClassRegistry::init('InvMovement')->id;
			}
		}	
		$dataSource->commit();
		if(($dataPurchase[0] != array() || $dataPurchase[1] != array()) && $dataMovement != array()){
			return array('SUCCESS', $idPurchase);
		}elseif($dataPurchase[0] != array() || $dataPurchase[1] != array() ){
			return array('SUCCESS', $idPurchase);
		}elseif ($dataMovement != array()) {
			return array('SUCCESS', $idMovement);
		}
			
	}
}
