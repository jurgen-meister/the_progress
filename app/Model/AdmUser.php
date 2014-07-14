<?php

App::uses('AppModel', 'Model');

/**
 * AdmUser Model
 *
 * @property AdmProfile $AdmProfile
 * @property AdmLogin $AdmLogin
 * @property AdmUserRestriction $AdmUserRestriction
 */
class AdmUser extends AppModel {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'login' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'active' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'active_date' => array(
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

	public $hasOne = array(
		'AdmProfile' => array(
			'className' => 'AdmProfile',
			'foreignKey' => 'adm_user_id',
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
	public $hasMany = array(
		'AdmUserRestriction' => array(
			'className' => 'AdmUserRestriction',
			'foreignKey' => 'adm_user_id',
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

	public function change_user_restriction($idUser, $idUserRestrictionSelected) {
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		////////////////////////////////////////////////
		$exist = $this->AdmUserRestriction->find('count', array(
			'conditions' => array(
				'AdmUserRestriction.id' => $idUserRestrictionSelected
			)
		));
		
		if ($exist == 0) {
			$dataSource->rollback();
			return false;
		}


		$UserRestrictionIds = $this->AdmUserRestriction->find('list', array(
			'conditions' => array(
				'AdmUserRestriction.adm_user_id' => $idUser,
				'AdmUserRestriction.lc_transaction !=' => 'LOGIC_DELETED',
//				'AdmUserRestriction.id !='=>$idUserRestrictionSelected
			),
			'fields' => array('AdmUserRestriction.id', 'AdmUserRestriction.id')
		));
				
//debug($exist);
		if (count($UserRestrictionIds) > 0) {
			foreach ($UserRestrictionIds as $value) {
				if (!$this->AdmUserRestriction->save(array('id' => $value, 'selected' => 0))) {
					$dataSource->rollback();
					return false;
				}
			}
		}
		
		if (!$this->AdmUserRestriction->save(array('id' => $idUserRestrictionSelected, 'selected' => 1))){
			$dataSource->rollback();
			return false;
		}

		$dataSource->commit();
		return true;
		///////////////////////////////////////////////
	}

	public function fnChangePassword($idUser, $password, $username) {
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		////////////////////////////////////////////
		if (!$this->save(array('id' => $idUser, 'password' => AuthComponent::password($password)))) {
			$dataSource->rollback();
			return false;
		}
		//For db-users version
//		$sql = "ALTER USER " . $username . " WITH PASSWORD '" . $password . "';";
//		try {
//			$this->query($sql);
//		} catch (Exception $e) {
////			debug($e);
//			$dataSource->rollback();
//			return false;
//		}
		///////////////////////////////////////////
		$dataSource->commit();
		return true;
	}

	public function fnAddUserProfile($data, $username, $password) {
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		////////////////////////////////////////////
		if (!$this->saveAssociated($data)) {
			$dataSource->rollback();
			return false;
		}
		//For db-users version
//		$sql = "CREATE USER " . $username . " WITH PASSWORD '" . $password . "';";
//		try {
//			$this->query($sql);
//		} catch (Exception $e) {
////			debug($e);
//			$dataSource->rollback();
//			return false;
//		}
//		//every user can create a role, this is not good, but to fix this without depending on a DBA need to build a grant permission interface per user
//		$sql = "ALTER ROLE " . $username . " WITH CREATEROLE;";
//		try {
//			$this->query($sql);
//		} catch (Exception $e) {
////			debug($e);
//			$dataSource->rollback();
//			return false;
//		}
//		$sql = "GRANT group_average_users to " . $username . ";";
//		try {
//			$this->query($sql);
//		} catch (Exception $e) {
//			debug($e);
//			$dataSource->rollback();
//			return false;
//		}
		///////////////////////////////////////////
		$dataSource->commit();
		return true;
	}

	public function fnSaveUserRestriction($data, $ownUserRestriction = 'no') {
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		////////////////////////////////////////////
		$existUserForUpdate = $this->find('count', array('conditions' => array('AdmUser.id' => $data['adm_user_id'])));

		if ($existUserForUpdate == 0) {
			$dataSource->rollback();
			return false;
		}
		$selected = 0;
		if (isset($data['selected']))
			$selected = $data['selected'];

		if ($ownUserRestriction == 'no') {//to avoid own userUserRestriction lyfe cycle bug
			if ($selected == 1) {
				$UserRestrictionIds = $this->AdmUserRestriction->find('list', array(
					'conditions' => array(
						'AdmUserRestriction.adm_user_id' => $data['adm_user_id'],
						'AdmUserRestriction.lc_state !=' => 'LOGIC_DELETED'
					),
					'fields' => array('AdmUserRestriction.id', 'AdmUserRestriction.id')
				));
//				debug($UserRestrictionIds);
				if (count($UserRestrictionIds) > 0) {

					foreach ($UserRestrictionIds as $value) {
						if (!$this->AdmUserRestriction->save(array('id' => $value, 'selected' => 0))) {
							$dataSource->rollback();
							return false;
						}
//						debug('exito');
					}
				}
			}
		}

		if (!isset($data['id'])) {
			$this->AdmUserRestriction->create(); //without it doesn't insert NEVER FORGET!!
		}


		if (!$this->AdmUserRestriction->save($data)) {
			$dataSource->rollback();
			return false;
		}

		///////////////////////////////////////////
		$dataSource->commit();
		return true;
	}

///////////
}
