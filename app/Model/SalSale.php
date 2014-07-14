<?php
App::uses('AppModel', 'Model');
/**
 * SalSale Model
 *
 * @property SalEmployee $SalEmployee
 * @property SalTaxNumber $SalTaxNumber
 * @property SalPayment $SalPayment
 * @property SalDetail $SalDetail
 */
class SalSale extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'sal_employee_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'sal_tax_number_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
//		'doc_code' => array(
//			'notempty' => array(
//				'rule' => array('notempty'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
		'date' => array(
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
		'SalEmployee' => array(
			'className' => 'SalEmployee',
			'foreignKey' => 'sal_employee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SalTaxNumber' => array(
			'className' => 'SalTaxNumber',
			'foreignKey' => 'sal_tax_number_id',
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
		'SalPayment' => array(
			'className' => 'SalPayment',
			'foreignKey' => 'sal_sale_id',
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
		'SalDetail' => array(
			'className' => 'SalDetail',
			'foreignKey' => 'sal_sale_id',
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
//		,'SalInvoice' => array(
//			'className' => 'SalInvoice',
//			'foreignKey' => 'sal_sale_id',
//			'dependent' => false,
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'exclusive' => '',
//			'finderQuery' => '',
//			'counterQuery' => ''
//		)
	);
	
	public function saveSale($dataSale, $dataSaleDetail, $OPERATION, $ACTION, $STATE, $dataPayDetail, $arraySalePrices, $dataInvoiceDetail, $dataMovement){
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		
		///////////////////////////////////////Start - Save Sale////////////////////////////////////////////
		/*Saving Note*/
		if(!$this->saveAll($dataSale[0])){
			$dataSource->rollback();
			return 'ERROR';
		}else{
			$idSale1 = $this->id;
			$dataSaleDetail[0]['SalDetail']['sal_sale_id']=$idSale1;
			if($dataPayDetail != null){
				$dataPayDetail['SalPayment']['sal_sale_id']=$idSale1;
			}
			if($dataInvoiceDetail[0] != 'delete' AND $dataInvoiceDetail[0] != 'empty' ){
				if($dataInvoiceDetail[0] == 'new'){
//					$dataInvoiceDetail['SalInvoice']['sal_sale_id']=$idSale1;
					if(!ClassRegistry::init('SalInvoice')->saveAll($dataInvoiceDetail)){
						$dataSource->rollback();
						return 'error';
					}
				}else{
					$salInvoicesIds = ClassRegistry::init('SalInvoice')->find('list', array(
							'conditions'=>array(
								'SalInvoice.sal_code'=>$dataInvoiceDetail['SalInvoice']['sal_code']
							),
							'fields'=>array('SalInvoice.id', 'SalInvoice.id')
						));
					if($salInvoicesIds == array()){
						if(!ClassRegistry::init('SalInvoice')->saveAll($dataInvoiceDetail)){
							$dataSource->rollback();
							return 'error';
						}
					}else{	
						foreach ($salInvoicesIds as $salInvoicesId) {
							try {
									ClassRegistry::init('SalInvoice')->save(array(
										'id'=>$salInvoicesId, 
										'invoice_number'=>$dataInvoiceDetail['SalInvoice']['invoice_number'],
										'description'=>$dataInvoiceDetail['SalInvoice']['description'])									
									);
							} catch (Exception $e) {
	//								debug($e);
								$dataSource->rollback();
								return 'ERROR';
							}
						}
					}
				}		
			}
		}
		
	if($dataInvoiceDetail[0] == 'delete'){
				$salInvoicesIds = ClassRegistry::init('SalInvoice')->find('list', array(
						'conditions' => array(
							'SalInvoice.sal_code'=>$dataInvoiceDetail['SalInvoice']['sal_code']
						),
						'fields' => array('SalInvoice.id', 'SalInvoice.id')
					));
				if($salInvoicesIds != array()){
					foreach ($salInvoicesIds as $salInvoicesId) {
						try {
							ClassRegistry::init('SalInvoice')->id = $salInvoicesId;	
							ClassRegistry::init('SalInvoice')->delete();
						} catch (Exception $e) {
//								debug($e);
							$dataSource->rollback();
							return 'ERROR';
						}
					}
				}	
			}
//			debug(isset($dataSale[0]['SalSale']['id']));
//			debug(isset($dataSale[1]['SalSale']['id']));
//			die();
		if (($ACTION == 'save_order') || ($ACTION == 'save_invoice' && isset($dataSale[0]['SalSale']['id']) == true && isset($dataSale[1]['SalSale']['id']) == true)){
//		if($ACTION=='save_order'){
			if(!$this->saveAll($dataSale[1])){
				$dataSource->rollback();
				return 'ERROR';
			}else{
				$idSale2 = $this->id;
				$dataSaleDetail[1]['SalDetail']['sal_sale_id']=$idSale2;
//				if($dataInvoiceDetail != 'delete'){
//					if($dataInvoiceDetail[0] == 'new'){
//	//					$dataInvoiceDetail['SalInvoice']['sal_sale_id']=$idSale1;
//						if(!ClassRegistry::init('SalInvoice')->saveAll($dataInvoiceDetail)){
//								$dataSource->rollback();
//								return 'error';
//							}
//					}else{
//						$salInvoicesIds = ClassRegistry::init('SalInvoice')->find('list', array(
//								'conditions'=>array(
//									'SalInvoice.sal_code'=>$dataInvoiceDetail[1]['SalInvoice']['sal_code']
//								),
//								'fields'=>array('SalInvoice.id', 'SalInvoice.id')
//							));
//
//						foreach ($salInvoicesIds as $salInvoicesId) {
//							try {
//									ClassRegistry::init('SalInvoice')->save(array(
//										'id'=>$salInvoicesId, 
//										'invoice_number'=>$dataInvoiceDetail[1]['SalInvoice']['invoice_number'],
//										'description'=>$dataInvoiceDetail[1]['SalInvoice']['description'])									
//									);
//							} catch (Exception $e) {
//	//								debug($e);
//								$dataSource->rollback();
//								return 'ERROR';
//							}
//						}
//					}		
//				}
			}
			
//			if($dataInvoiceDetail == 'delete'){
//				$salInvoicesIds = ClassRegistry::init('SalInvoice')->find('list', array(
//						'conditions' => array(
//							'SalInvoice.sal_sale_id'=>$idSale2
//						),
//						'fields' => array('SalInvoice.id', 'SalInvoice.id')
//					));
//
//					foreach ($salInvoicesIds as $salInvoicesId) {
//						try {
//							ClassRegistry::init('SalInvoice')->id = $salInvoicesId;	
//							ClassRegistry::init('SalInvoice')->delete();
//						} catch (Exception $e) {
////								debug($e);
//							$dataSource->rollback();
//							return 'ERROR';
//						}
//					}	
//			}
		
		}	
		
//		print_r($dataSaleDetail);
//		die();
		
			switch ($OPERATION) {
				case 'ADD':
					if(!$this->SalDetail->saveAll($dataSaleDetail[0])){
						$dataSource->rollback();
						return 'error';
					}
					if (($ACTION == 'save_order') || ($ACTION == 'save_invoice' && isset($dataSale[0]['SalSale']['id']) == true && isset($dataSale[1]['SalSale']['id']) == true)){
//					if($ACTION=='save_order'){
						if(!$this->SalDetail->saveAll($dataSaleDetail[1])){
							$dataSource->rollback();
							return 'ERROR';
						}
					}	
					break;
				case 'ADD_PAY':	
					if($dataPayDetail != null){
						if(!$this->SalPayment->saveAll($dataPayDetail)){
							$dataSource->rollback();
							return 'error';
						}
					}
					break;
				case 'EDIT':							//array fields
//					if($this->SalDetail->updateAll(array(/*'SalDetail.lc_transaction'=>"'MODIFY'",*/ 'SalDetail.sale_price'=>$dataMovementDetail[0]['SalDetail']['sale_price'], 
//															'SalDetail.quantity'=>$dataMovementDetail[0]['SalDetail']['quantity'], 
//															'SalDetail.ex_sale_price'=>$dataMovementDetail[0]['SalDetail']['ex_sale_price']
//															/*'SalDetail.fob_price'=>$dataMovementDetail['SalDetail']['fob_price'],
//															'SalDetail.ex_fob_price'=>$dataMovementDetail['SalDetail']['ex_fob_price'],
//															'SalDetail.cif_price'=>$dataMovementDetail['SalDetail']['cif_price'],
//															'SalDetail.ex_cif_price'=>$dataMovementDetail['SalDetail']['ex_cif_price']*/), 
//								/*array conditions*/array('SalDetail.sal_sale_id'=>$dataMovementDetail[0]['SalDetail']['sal_sale_id'], 
//														'SalDetail.inv_warehouse_id'=>$dataMovementDetail[0]['SalDetail']['inv_warehouse_id'], 
//														'SalDetail.inv_item_id'=>$dataMovementDetail[0]['SalDetail']['inv_item_id']
//													))){
//						$rowsAffected = $this->getAffectedRows();//must do this because updateAll always return true
//					}
//					if($rowsAffected == 0){
//						$dataSource->rollback();
//						return 'error';
//					}
					//--------------------------------------------------------------------------------------------------------------
					$salDetailsIds = $this->SalDetail->find('list', array(
							'conditions'=>array(
								'SalDetail.sal_sale_id'=>$dataSaleDetail[0]['SalDetail']['sal_sale_id'], 
								'SalDetail.inv_warehouse_id'=>$dataSaleDetail[0]['SalDetail']['last_warehouse'], 
								'SalDetail.inv_item_id'=>$dataSaleDetail[0]['SalDetail']['inv_item_id']
							),
							'fields'=>array('SalDetail.id', 'SalDetail.id')
						));
					
					foreach ($salDetailsIds as $salDetailsId) {
						try {
								$this->SalDetail->save(array(
									'id'=>$salDetailsId, 
									'inv_warehouse_id'=>$dataSaleDetail[0]['SalDetail']['inv_warehouse_id'],
									'sale_price'=>$dataSaleDetail[0]['SalDetail']['sale_price'], 
									'quantity'=>$dataSaleDetail[0]['SalDetail']['quantity'], 
									'backorder'=>$dataSaleDetail[0]['SalDetail']['backorder'], 
									'ex_sale_price'=>$dataSaleDetail[0]['SalDetail']['ex_sale_price'])
								);
						} catch (Exception $e) {
//								debug($e);
							$dataSource->rollback();
							return 'ERROR';
						}
					}
					//--------------------------------------------------------------------------------------------------------------
					if (($ACTION == 'save_order') || ($ACTION == 'save_invoice' && isset($dataSale[0]['SalSale']['id']) == true && isset($dataSale[1]['SalSale']['id']) == true)){
//					if($ACTION=='save_order'){
//						if($this->SalDetail->updateAll(array(/*'SalDetail.lc_transaction'=>"'MODIFY'",*/'SalDetail.sale_price'=>$dataMovementDetail[1]['SalDetail']['sale_price'], 
//															'SalDetail.quantity'=>$dataMovementDetail[1]['SalDetail']['quantity'], 
//															'SalDetail.ex_sale_price'=>$dataMovementDetail[1]['SalDetail']['ex_sale_price']				
//															/*'SalDetail.fob_price'=>$dataMovementDetail['SalDetail']['fob_price'],
//															'SalDetail.ex_fob_price'=>$dataMovementDetail['SalDetail']['ex_fob_price'],
//															'SalDetail.cif_price'=>$dataMovementDetail['SalDetail']['cif_price'],
//															'SalDetail.ex_cif_price'=>$dataMovementDetail['SalDetail']['ex_cif_price']*/), 
//								/*array conditions*/array('SalDetail.sal_sale_id'=>$dataMovementDetail[1]['SalDetail']['sal_sale_id'], 
//														'SalDetail.inv_warehouse_id'=>$dataMovementDetail[1]['SalDetail']['inv_warehouse_id'], 
//														'SalDetail.inv_item_id'=>$dataMovementDetail[1]['SalDetail']['inv_item_id']
//													))){
//							$rowsAffected = $this->getAffectedRows();//must do this because updateAll always return true
//						}
//						if($rowsAffected == 0){
//							$dataSource->rollback();
//							return 'error';
//						}
						//--------------------------------------------------------------------------------------------------------------
						$salDetailsIds = $this->SalDetail->find('list', array(
							'conditions'=>array(
								'SalDetail.sal_sale_id'=>$dataSaleDetail[1]['SalDetail']['sal_sale_id'], 
								'SalDetail.inv_warehouse_id'=>$dataSaleDetail[1]['SalDetail']['last_warehouse'], 
								'SalDetail.inv_item_id'=>$dataSaleDetail[1]['SalDetail']['inv_item_id']
							),
							'fields'=>array('SalDetail.id', 'SalDetail.id')
						));

						foreach ($salDetailsIds as $salDetailsId) {
							try {
									$this->SalDetail->save(array(
										'id'=>$salDetailsId, 
										'inv_warehouse_id'=>$dataSaleDetail[1]['SalDetail']['inv_warehouse_id'],
										'sale_price'=>$dataSaleDetail[1]['SalDetail']['sale_price'], 
										'quantity'=>$dataSaleDetail[1]['SalDetail']['quantity'], 
										'backorder'=>$dataSaleDetail[1]['SalDetail']['backorder'], 
										'ex_sale_price'=>$dataSaleDetail[1]['SalDetail']['ex_sale_price'])
									);
							} catch (Exception $e) {
	//								debug($e);
								$dataSource->rollback();
								return 'ERROR';
							}
						}
						//--------------------------------------------------------------------------------------------------------------
					}					
					
					break;
				case 'EDIT_PAY':
//					if($this->SalPayment->updateAll(array(/*'SalPayment.lc_transaction'=>"'MODIFY'",*/ 'SalPayment.amount'=>$dataPayDetail['SalPayment']['amount'], 
//															'SalPayment.description'=>"'".$dataPayDetail['SalPayment']['description']."'", 
//															'SalPayment.ex_amount'=>$dataPayDetail['SalPayment']['ex_amount']),
//								/*array conditions*/array('SalPayment.sal_sale_id'=>$dataPayDetail['SalPayment']['sal_sale_id'], 
//														'SalPayment.sal_payment_type_id'=>$dataPayDetail['SalPayment']['sal_payment_type_id'],
//														'SalPayment.date'=>$dataPayDetail['SalPayment']['date']))){
//						$rowsAffected = $this->getAffectedRows();//must do this because updateAll always return true
//					}
//					if($rowsAffected == 0){
//						$dataSource->rollback();
//						return 'error';
//					}
					//--------------------------------------------------------------------------------------------------------------
					$salPaymentsIds = $this->SalPayment->find('list', array(
						'conditions'=>array(
							'SalPayment.sal_sale_id'=>$dataPayDetail['SalPayment']['sal_sale_id'], 
							'SalPayment.sal_payment_type_id'=>$dataPayDetail['SalPayment']['sal_payment_type_id'],
							'SalPayment.date'=>$dataPayDetail['SalPayment']['date']
						),
						'fields'=>array('SalPayment.id', 'SalPayment.id')
					));
					
					foreach ($salPaymentsIds as $salPaymentsId) {
						try {
								$this->SalPayment->save(array(
									'id'=>$salPaymentsId, 
									'amount'=>$dataPayDetail['SalPayment']['amount'], 
									'description'=>$dataPayDetail['SalPayment']['description'], 
									'ex_amount'=>$dataPayDetail['SalPayment']['ex_amount'])
								);
						} catch (Exception $e) {
//								debug($e);
							$dataSource->rollback();
							return 'ERROR';
						}
					}
					//--------------------------------------------------------------------------------------------------------------
					break;
				case 'DELETE':
//					if(!$this->SalDetail->deleteAll(array('SalDetail.sal_sale_id'=>$dataMovementDetail[0]['SalDetail']['sal_sale_id'],	
//															'SalDetail.inv_warehouse_id'=>$dataMovementDetail[0]['SalDetail']['inv_warehouse_id'], 
//															'SalDetail.inv_item_id'=>$dataMovementDetail[0]['SalDetail']['inv_item_id']))){
//						$dataSource->rollback();
//						return 'error';
//					}
					//--------------------------------------------------------------------------------------------------------------
					$salDetailsIds = $this->SalDetail->find('list', array(
						'conditions' => array(
							'SalDetail.sal_sale_id'=>$dataSaleDetail[0]['SalDetail']['sal_sale_id'],	
							'SalDetail.inv_warehouse_id'=>$dataSaleDetail[0]['SalDetail']['inv_warehouse_id'], 
							'SalDetail.inv_item_id'=>$dataSaleDetail[0]['SalDetail']['inv_item_id']
						),
						'fields' => array('SalDetail.id', 'SalDetail.id')
					));

					foreach ($salDetailsIds as $salDetailsId) {
						try {
							$this->SalDetail->id = $salDetailsId;	
							$this->SalDetail->delete();
						} catch (Exception $e) {
//								debug($e);
							$dataSource->rollback();
							return 'ERROR';
						}
					}	
					//--------------------------------------------------------------------------------------------------------------
					if (($ACTION == 'save_order') || ($ACTION == 'save_invoice' && isset($dataSale[0]['SalSale']['id']) == true && isset($dataSale[1]['SalSale']['id']) == true)){
//					if($ACTION=='save_order'){
//						if(!$this->SalDetail->deleteAll(array('SalDetail.sal_sale_id'=>$dataMovementDetail[1]['SalDetail']['sal_sale_id'],	
//																'SalDetail.inv_warehouse_id'=>$dataMovementDetail[1]['SalDetail']['inv_warehouse_id'], 
//																'SalDetail.inv_item_id'=>$dataMovementDetail[1]['SalDetail']['inv_item_id']))){
//							$dataSource->rollback();
//							return 'error';
//						}
					
						//--------------------------------------------------------------------------------------------------------------
						$salDetailsIds = $this->SalDetail->find('list', array(
							'conditions' => array(
								'SalDetail.sal_sale_id'=>$dataSaleDetail[1]['SalDetail']['sal_sale_id'],	
								'SalDetail.inv_warehouse_id'=>$dataSaleDetail[1]['SalDetail']['inv_warehouse_id'], 
								'SalDetail.inv_item_id'=>$dataSaleDetail[1]['SalDetail']['inv_item_id']
							),
							'fields' => array('SalDetail.id', 'SalDetail.id')
						));

						foreach ($salDetailsIds as $salDetailsId) {
							try {
								$this->SalDetail->id = $salDetailsId;	
								$this->SalDetail->delete();
							} catch (Exception $e) {
//								debug($e);
								$dataSource->rollback();
								return 'ERROR';
							}
						}	
						//--------------------------------------------------------------------------------------------------------------
					}	
					break;
				case 'DELETE_PAY':
//					if(!$this->SalPayment->deleteAll(array('SalPayment.sal_sale_id'=>$dataPayDetail['SalPayment']['sal_sale_id'], 
//															'SalPayment.date'=>$dataPayDetail['SalPayment']['date']))){
//						$dataSource->rollback();
//						return 'error';
//					}
					//--------------------------------------------------------------------------------------------------------------
//					print_r($dataPayDetail);
//					die();
					$salPaymentsIds = $this->SalPayment->find('list', array(
						'conditions' => array(
							'SalPayment.sal_sale_id'=>$dataPayDetail['SalPayment']['sal_sale_id'], 
							'SalPayment.date'=>$dataPayDetail['SalPayment']['date']
						),
						'fields' => array('SalPayment.id', 'SalPayment.id')
					));
					foreach ($salPaymentsIds as $salPaymentsId) {
						try {
							$this->SalPayment->id = $salPaymentsId;	
							$this->SalPayment->delete();
						} catch (Exception $e) {
//								debug($e);
							$dataSource->rollback();
							return 'ERROR';
						}
					}	
					//--------------------------------------------------------------------------------------------------------------	
					break;
				case 'DISTRIB':	
					//--------------------------------------------------------------------------------------------------------------
					$salDetailsIds = $this->SalDetail->find('list', array(
							'conditions'=>array(
								'SalDetail.sal_sale_id'=>$dataSaleDetail[0]['SalDetail']['sal_sale_id'], 
								'SalDetail.inv_warehouse_id'=>$dataSaleDetail[0]['SalDetail']['inv_warehouse_id'], 
								'SalDetail.inv_item_id'=>$dataSaleDetail[0]['SalDetail']['inv_item_id']
							),
							'fields'=>array('SalDetail.id', 'SalDetail.id')
						));
					
					foreach ($salDetailsIds as $salDetailsId) {
						try {
								$this->SalDetail->save(array(
									'id'=>$salDetailsId, 
									'inv_warehouse_id'=>$dataSaleDetail[0]['SalDetail']['inv_warehouse_id'],
//									'sale_price'=>$dataSaleDetail[0]['SalDetail']['sale_price'], 
									'quantity'=>$dataSaleDetail[0]['SalDetail']['quantity']
										,'backorder'=>$dataSaleDetail[0]['SalDetail']['backorder'])
//									'ex_sale_price'=>$dataSaleDetail[0]['SalDetail']['ex_sale_price'])
								);
						} catch (Exception $e) {
//								debug($e);
							$dataSource->rollback();
							return 'ERROR';
						}
					}
					$salDetailsDistribIds = $this->SalDetail->find('list', array(
							'conditions'=>array(
								'SalDetail.sal_sale_id'=>$dataSaleDetail[0]['SalDetail']['sal_sale_id'], 
								'SalDetail.inv_warehouse_id'=>$dataSaleDetail[2]['SalDetail']['inv_warehouse_id'], 
								'SalDetail.inv_item_id'=>$dataSaleDetail[2]['SalDetail']['inv_item_id']
							),
							'fields'=>array(/*'SalDetail.id', 'SalDetail.id',*/ 'SalDetail.quantity', 'SalDetail.id')
						));
						
					if($salDetailsDistribIds != array()){
						$lastQuantity = key($salDetailsDistribIds);
						foreach ($salDetailsDistribIds as $salDetailsDistribId) {
							try {
									$this->SalDetail->save(array(
										'id'=>$salDetailsDistribId, 
										'inv_warehouse_id'=>$dataSaleDetail[2]['SalDetail']['inv_warehouse_id'],
//											'sale_price'=>$dataSaleDetail[2]['SalDetail']['sale_price'], 
										'quantity'=>$dataSaleDetail[2]['SalDetail']['quantity']+$lastQuantity
											,'backorder'=>$dataSaleDetail[2]['SalDetail']['backorder'])
//											'ex_sale_price'=>$dataSaleDetail[2]['SalDetail']['ex_sale_price'])
									);
							} catch (Exception $e) {
	//								debug($e);
								$dataSource->rollback();
								return 'ERROR';
							}
						}
					}else{
						$dataSaleDetail[2]['SalDetail']['sal_sale_id'] = $dataSaleDetail[0]['SalDetail']['sal_sale_id']; 
						if(!$this->SalDetail->saveAll($dataSaleDetail[2])){
							$dataSource->rollback();
							return 'error';
						}
					}
					//--------------------------------------------------------------------------------------------------------------
					if (($ACTION == 'save_order') || ($ACTION == 'save_invoice' && isset($dataSale[0]['SalSale']['id']) == true && isset($dataSale[1]['SalSale']['id']) == true)){
						//--------------------------------------------------------------------------------------------------------------
						$salDetailsIds = $this->SalDetail->find('list', array(
							'conditions'=>array(
								'SalDetail.sal_sale_id'=>$dataSaleDetail[1]['SalDetail']['sal_sale_id'], 
								'SalDetail.inv_warehouse_id'=>$dataSaleDetail[1]['SalDetail']['inv_warehouse_id'], 
								'SalDetail.inv_item_id'=>$dataSaleDetail[1]['SalDetail']['inv_item_id']
							),
							'fields'=>array('SalDetail.id', 'SalDetail.id')
						));

						foreach ($salDetailsIds as $salDetailsId) {
							try {
									$this->SalDetail->save(array(
										'id'=>$salDetailsId, 
										'inv_warehouse_id'=>$dataSaleDetail[1]['SalDetail']['inv_warehouse_id'],
//										'sale_price'=>$dataSaleDetail[1]['SalDetail']['sale_price'], 
										'quantity'=>$dataSaleDetail[1]['SalDetail']['quantity']
											,'backorder'=>$dataSaleDetail[1]['SalDetail']['backorder'])
//										'ex_sale_price'=>$dataSaleDetail[1]['SalDetail']['ex_sale_price'])
									);
							} catch (Exception $e) {
	//								debug($e);
								$dataSource->rollback();
								return 'ERROR';
							}
						}
						
						$salDetailsDistribIds = $this->SalDetail->find('list', array(
							'conditions'=>array(
								'SalDetail.sal_sale_id'=>$dataSaleDetail[1]['SalDetail']['sal_sale_id'], 
								'SalDetail.inv_warehouse_id'=>$dataSaleDetail[3]['SalDetail']['inv_warehouse_id'], 
								'SalDetail.inv_item_id'=>$dataSaleDetail[3]['SalDetail']['inv_item_id']
							),
							'fields'=>array(/*'SalDetail.id', 'SalDetail.id',*/ 'SalDetail.quantity', 'SalDetail.id')
						));
					
						if($salDetailsDistribIds != array()){
							$lastQuantity = key($salDetailsDistribIds);
							foreach ($salDetailsDistribIds as $salDetailsDistribId) {
								try {
										$this->SalDetail->save(array(
											'id'=>$salDetailsDistribId, 
											'inv_warehouse_id'=>$dataSaleDetail[3]['SalDetail']['inv_warehouse_id'],
//												'sale_price'=>$dataSaleDetail[2]['SalDetail']['sale_price'], 
											'quantity'=>$dataSaleDetail[3]['SalDetail']['quantity']+$lastQuantity
												,'backorder'=>$dataSaleDetail[3]['SalDetail']['backorder'])
//												'ex_sale_price'=>$dataSaleDetail[2]['SalDetail']['ex_sale_price'])
										);
								} catch (Exception $e) {
		//								debug($e);
									$dataSource->rollback();
									return 'ERROR';
								}
							}
						}else{
							$dataSaleDetail[3]['SalDetail']['sal_sale_id'] = $dataSaleDetail[1]['SalDetail']['sal_sale_id']; 
							if(!$this->SalDetail->saveAll($dataSaleDetail[3])){
								$dataSource->rollback();
								return 'error';
							}
						}
						//--------------------------------------------------------------------------------------------------------------
					}	
					break;
			}		
			
			if ($ACTION == 'save_invoice' && $STATE == 'SINVOICE_APPROVED' && $dataMovement != null){
				foreach($dataMovement AS $row) { 
					if(!ClassRegistry::init('InvMovement')->saveAll($row)){
						$dataSource->rollback();
						return 'error';
					}else{
						$idMovement[] = ClassRegistry::init('InvMovement')->id;
					}
				} 	
				
			}	
			
			if ($ACTION == 'save_invoice' && $STATE == 'SINVOICE_APPROVED' && $arraySalePrices != array()){
			
				if(!ClassRegistry::init('InvPrice')->saveAll($arraySalePrices)){
					$dataSource->rollback();
					return 'error';
				}
				
			}		
		$dataSource->commit();
		return array('SUCCESS', $STATE.'|'.$idSale1);
	}
	
	public function updateMovement($dataSale, $dataMovement){
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		if($dataSale[0] != array()){
			if(!$this->saveAll($dataSale[0])){
				$dataSource->rollback();
				return 'ERROR';
			}else{
				$idSale = $this->id;
			}
		}	
		if($dataSale[1] != array()){
			if(!$this->saveAll($dataSale[1])){
				$dataSource->rollback();
				return 'ERROR';
			}else{
				$idSale = $this->id;
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
		if(($dataSale[0] != array() || $dataSale[1] != array()) && $dataMovement != array()){
			return array('SUCCESS', $idSale);
		}elseif($dataSale[0] != array() || $dataSale[1] != array() ){
			return array('SUCCESS', $idSale);
		}elseif ($dataMovement != array()) {
			return array('SUCCESS', $idMovement);
		}
			
	}
	
	public function saveGeneratedMovements(/*$idsToDelete,*/ $data){
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		
//		if(!ClassRegistry::init('InvMovement')->deleteAll($idsToDelete, true)){
//			$dataSource->rollback();
//			return 'error';
//		}
		
		foreach($data AS $row) { 
			if(!ClassRegistry::init('InvMovement')->saveAll($row)){
				$dataSource->rollback();
				return 'error';
			}else{
				$idMovement[] = ClassRegistry::init('InvMovement')->id;
			}
		} 	
		$dataSource->commit();
		return array('SUCCESS', implode("|",$idMovement));
	}	
}
