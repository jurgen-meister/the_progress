<?php

App::uses('AppController', 'Controller');

/**
 * AdmUsers Controller
 *
 * @property AdmUser $AdmUser
 */
class AdmUsersController extends AppController {

	/**
	 *  Layout
	 *
	 * @var string
	 */
	public $layout = 'default';

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		////////////////////////////START - SETTING PAGINATING VARIABLES//////////////////////////////////////
		$filters = null;
//		debug($this->Session->read('User.id'));
		if($this->Session->read('Role.id') <> 1){ //to avoid other users to edit SUPER USER imexport
			$filters = array('AdmUser.id !='=>1);
		}
		
		$this->paginate = array(
			'conditions' => array(
				$filters
			),
			'recursive' => 0,
			//'fields'=>array('InvMovement.id', 'InvMovement.code', 'InvMovement.document_code', 'InvMovement.date','InvMovement.inv_movement_type_id','InvMovementType.name', 'InvMovement.inv_warehouse_id', 'InvWarehouse.name', 'InvMovement.lc_state'),
			'order' => array('AdmUser.login' => 'ASC', 'AdmUser.active'=>'ASC'),
			'limit' => 20,
		);
		////////////////////////////END - SETTING PAGINATING VARIABLES//////////////////////////////////////
		$array = $this->_paintUserActiveDateField($this->paginate('AdmUser'));
		//debug($array);
		////////////////////////START - SETTING PAGINATE AND OTHER VARIABLES TO THE VIEW//////////////////
		$this->set('admUsers', $array);
	}

	private function _paintUserActiveDateField($array) {
		for ($i = 0; $i < count($array); $i++) {
			$res = $this->AdmUser->find('count', array(
				'conditions' => array(
					'AdmUser.active_date > now()',
					'AdmUser.id' => $array[$i]['AdmUser']['id'])
			));
			$array[$i]['AdmUser']['token_valide_date'] = $res;
		}
		return $array;
	}

	public function add_user_restriction($id = null) {
		if ($id == null) {
			$this->redirect(array('action' => 'index'));
		}
		if($this->Session->read('Role.id') <> 1 AND $id == 1){
			$this->redirect(array('action' => 'index')); //Only SUPER USER CAN EDIT its own account
		}
		$userInfo = $this->AdmUser->find('all', array(
			'conditions' => array('AdmUser.id' => $id),
			'fields' => array('AdmUser.login'),
			'recursive' => -1
		));

		$this->loadModel('AdmPeriod');
		$periods = $this->AdmPeriod->find('list', array('fields' => array('AdmPeriod.name', 'AdmPeriod.name')));
		$periodInitial = key($periods);
		$areas = $this->AdmUser->AdmUserRestriction->AdmArea->find('list', array('conditions' => array('AdmArea.period' => $periodInitial)));
		$rolesTaken = array();
		

		
		
		$admUserRestriction = $this->AdmUser->AdmUserRestriction->find('all', array(
			'conditions' => array(
				'AdmUserRestriction.adm_user_id' => $id
				, 'AdmUserRestriction.period' => $periodInitial
				, 'AdmUserRestriction.lc_state !=' => 'LOGIC_DELETED'

			),
			'fields' => array('AdmUserRestriction.adm_role_id')
		));
		//debug($admUserRestriction);
		for ($i = 0; $i < count($admUserRestriction); $i++) {
			$rolesTaken[$admUserRestriction[$i]['AdmUserRestriction']['adm_role_id']] = $admUserRestriction[$i]['AdmUserRestriction']['adm_role_id'];
		}
		
		if($this->Session->read('Role.id') <> 1){
			$rolesTaken[1] = 1;
		}
		
		$roles = $this->AdmUser->AdmUserRestriction->AdmRole->find('list', array(
			'conditions' => array('NOT' => array('AdmRole.id' => $rolesTaken))
		));

		$this->set('username', $userInfo[0]['AdmUser']['login']);
		$this->set('userId', $id);
		$this->set('areas', $areas);
		$this->set('roles', $roles);
		$this->set('periods', $periods);
	}

	public function edit_user_restriction() {

		if (!isset($this->passedArgs['idUserRestriction'])) {
			$this->redirect(array('action' => 'index'));
		}

		//$id = $this->passedArgs['id'];
		$idUserRestriction = $this->passedArgs['idUserRestriction'];
		
		if($this->Session->read('Role.id') <> 1 AND $idUserRestriction == 1){
			$this->redirect(array('action' => 'index')); //Only SUPER USER CAN EDIT its own account
		}
		
		$AdmUserRestriction = $this->AdmUser->AdmUserRestriction->find('all', array(
			'conditions' => array('AdmUserRestriction.id' => $idUserRestriction),
			'fields' => array('AdmUserRestriction.selected', 'AdmUser.id', 'AdmUser.login', 'AdmUserRestriction.active_date', 'AdmUserRestriction.active', 'AdmUserRestriction.adm_role_id', 'AdmUserRestriction.adm_area_id', 'AdmUserRestriction.period'),
		));

		$this->loadModel('AdmPeriod');
		$periods = $this->AdmPeriod->find('list', array('fields' => array('AdmPeriod.name', 'AdmPeriod.name')));
		$roles = $this->AdmUser->AdmUserRestriction->AdmRole->find('list');
		$areas = $this->AdmUser->AdmUserRestriction->AdmArea->find('list', array(
			'conditions' => array('AdmArea.period' => $AdmUserRestriction[0]['AdmUserRestriction']['period'])
		));

		$periodId = $AdmUserRestriction[0]['AdmUserRestriction']['period'];
		$roleId = $AdmUserRestriction[0]['AdmUserRestriction']['adm_role_id'];
		$areaId = $AdmUserRestriction[0]['AdmUserRestriction']['adm_area_id'];
		$active = $AdmUserRestriction[0]['AdmUserRestriction']['active'];
		$activeDate = date("d/m/Y", strtotime($AdmUserRestriction[0]['AdmUserRestriction']['active_date']));
		$selected = $AdmUserRestriction[0]['AdmUserRestriction']['selected'];

		$this->set('username', $AdmUserRestriction[0]['AdmUser']['login']);
		$this->set('userId', $AdmUserRestriction[0]['AdmUser']['id']);
		$this->set('areas', $areas);
		$this->set('roles', $roles);
		$this->set('periods', $periods);
		$this->set(compact('periodId', 'roleId', 'areaId', 'active', 'activeDate', 'idUserRestriction', 'selected'));
	}

	public function ajax_list_roles_areas() {
		if ($this->RequestHandler->isAjax()) {
			////////////////////////////////////////////START AJAX/////////////////////////////////////////////
			$period = $this->request->data['period'];
			$userId = $this->request->data['userId'];
			$rolesTaken = array();

			$areas = $this->AdmUser->AdmUserRestriction->AdmArea->find('list', array(
				'conditions' => array(
					'AdmArea.period' => $period
				)
			));

			$admUserRestriction = $this->AdmUser->AdmUserRestriction->find('all', array(
				'conditions' => array(
					'AdmUserRestriction.adm_user_id' => $userId
					, 'AdmUserRestriction.period' => $period
					, 'AdmUserRestriction.lc_state !=' => 'LOGIC_DELETED'
				),
				'fields' => array('AdmUserRestriction.adm_role_id')
			));
//			debug($period);
//			debug($admUserRestriction);
			for ($i = 0; $i < count($admUserRestriction); $i++) {
				$rolesTaken[$admUserRestriction[$i]['AdmUserRestriction']['adm_role_id']] = $admUserRestriction[$i]['AdmUserRestriction']['adm_role_id'];
			}
			if($this->Session->read('Role.id') <> 1){
				$rolesTaken[1] = 1;
			}
//			debug($rolesTaken);
			$roles = $this->AdmUser->AdmUserRestriction->AdmRole->find('list', array(
				'conditions' => array('NOT' => array('AdmRole.id' => $rolesTaken))
			));

			$this->set('roles', $roles);
			$this->set('areas', $areas);
		}else{
			$this->redirect($this->Auth->logout());//only accesable through ajax request
		}
		////////////////////////////////////////////END AJAX///////////////////////////////////////////////
	}

	public function index_user_restriction($id = null) {

		if ($id == null) {
			$this->redirect(array('action' => 'index'));
		}
		
		if($this->Session->read('Role.id') <> 1 AND $id == 1){
			$this->redirect(array('action' => 'index')); //Only SUPER USER CAN EDIT its own account
		}
		
		$filters = array('AdmUserRestriction.adm_user_id' => $id, 'AdmUserRestriction.lc_state !=' => 'LOGIC_DELETED');
		$this->paginate = array(
			'conditions' => array(
				$filters
			),
			'recursive' => 0,
			//'fields'=>array('InvMovement.id', 'InvMovement.code', 'InvMovement.document_code', 'InvMovement.date','InvMovement.inv_movement_type_id','InvMovementType.name', 'InvMovement.inv_warehouse_id', 'InvWarehouse.name', 'InvMovement.lc_state'),
			'order' => array('AdmUserRestriction.period' => 'desc', 'AdmUserRestriction.active' => 'desc', 'AdmRole.name' => 'asc'),
			'limit' => 15,
		);
		//debug($this->paginate('AdmUserRestriction'));
		$userInfo = $this->AdmUser->find('all', array(
			'conditions' => array('AdmUser.id' => $id),
			'fields' => array('AdmUser.login'),
			'recursive' => -1
		));
		$array = $this->_paintUserRestrictionActiveDateField($this->paginate('AdmUserRestriction'));
		//debug($array);
		$this->set('userId', $id);
		$this->set('username', $userInfo[0]['AdmUser']['login']);
		$this->set('admUsers', $array);
	}

	private function _paintUserRestrictionActiveDateField($array) {
		for ($i = 0; $i < count($array); $i++) {
			$res = $this->AdmUser->AdmUserRestriction->find('count', array(
				'conditions' => array(
					'AdmUserRestriction.active_date > now()'/* => date('Y-m-d H:i:s') */,
					'AdmUserRestriction.id' => $array[$i]['AdmUserRestriction']['id'])
			));
			$array[$i]['AdmUserRestriction']['token_valide_date'] = $res;
		}
		return $array;
	}

	public function login() {
//		debug($this->_fnCheckDeviceType()); 
		
		//before everything verify if the browser is IE from windows
		if (eregi("MSIE", getenv("HTTP_USER_AGENT")) || eregi("Internet Explorer", getenv("HTTP_USER_AGENT"))) {
			$this->redirect(array('controller' => 'Pages', 'action' => 'ie_denied'));
		}
		if($this->_fnCheckDeviceType() == 'phone'){
			$this->redirect(array('controller' => 'Pages', 'action' => 'phone_not_ready'));
		}
		
		$this->layout = 'login';
		if ($this->request->is('post')) {
			// not using due only one db-user on heroku
			/*
			//#KEY drop initial database config default, and create the dynamic connection. Other wise it will login with the limited connection
			if (!$this->BittionMain->connectDatabaseDynamically($this->request->data['AdmUser']['login'], $this->request->data['AdmUser']['password'])) {
//				$this->Session->setFlash('<strong>Error!</strong> fallo la conexión a la base de datos.', 'alert', array('plugin' => 'TwitterBootstrap', 'class' => 'alert-error'));
				//More User friendly message when there is no DB user connection
				$this->Session->setFlash('<strong>Usuario o contraseña incorrecto!!!</strong>', 'alert', array('plugin' => 'TwitterBootstrap', 'class' => 'alert-error'));
				$this->redirect(array('controller' => 'AdmUsers', 'action' => 'login'));
			}
			*/
			if ($this->Auth->login()) { //If authentication is valid username and password
				/////////////////////////////////////////////BEGIN OF VALIDATION///////////////////////////////////////////////////
				$userInfo = $this->Auth->user();
				$active = $userInfo['active'];
				$userPassword = $this->request->data['AdmUser']['password'];

				//User active
				if ($active != 1) {
					$this->_createMessage('El usuario esta inactivo');
//					$error++;
					$this->redirect($this->Auth->logout());
				}

				//User date active
				$activeDate = $this->AdmUser->find('count', array('conditions' => array('AdmUser.active_date > now()', 'AdmUser.id' => $userInfo['id']))); //The DB does the comparition between dates, it's simpler than creating a php function for this
				if ($activeDate == 0) {
					$this->_createMessage('La cuenta de usuario expiró!.');
//					$error++;
					$this->redirect($this->Auth->logout());
				}

				//Roles Validation
				$role = $this->AdmUser->AdmUserRestriction->find('count', array('conditions' => array('AdmUserRestriction.adm_user_id' => $userInfo['id'], 'AdmUserRestriction.lc_state !=' => 'LOGIC_DELETED')));
				if ($role == 0) {//No roles found
					$this->_createMessage('El usuario no tiene ningun rol asignado');
//					$error++;
					$this->redirect($this->Auth->logout());
				} else {
					$roleSelected = $this->AdmUser->AdmUserRestriction->find('count', array('conditions' => array('AdmUserRestriction.adm_user_id' => $userInfo['id'], 'AdmUserRestriction.selected' => 1, 'AdmUserRestriction.lc_state !=' => 'LOGIC_DELETED')));
					if ($roleSelected == 0) {
						$this->_createMessage('El usuario no tiene ningun rol principal seleccionado');
						$this->redirect($this->Auth->logout());
					}

					////////////////////////////////////////////////////////////////////////////////////////////////
					$roleActive = $this->AdmUser->AdmUserRestriction->find('count', array('conditions' => array('AdmUserRestriction.adm_user_id' => $userInfo['id'], 'AdmUserRestriction.active' => 1, 'AdmUserRestriction.selected' => 1, 'AdmUserRestriction.lc_state !=' => 'LOGIC_DELETED')));
					$roleActiveDate = $this->AdmUser->AdmUserRestriction->find('count', array('conditions' => array('AdmUserRestriction.adm_user_id' => $userInfo['id'], 'AdmUserRestriction.active_date > now()', 'AdmUserRestriction.selected' => 1, 'AdmUserRestriction.lc_state !=' => 'LOGIC_DELETED')));
					if ($roleActive == 0 OR $roleActiveDate == 0) {

						$otherRoles = $this->AdmUser->AdmUserRestriction->find('all', array(
							'conditions' => array('AdmUserRestriction.adm_user_id' => $userInfo['id'],
								'AdmUserRestriction.active_date > now()',
								'AdmUserRestriction.active' => 1,
								'AdmUserRestriction.lc_state !=' => 'LOGIC_DELETED'
							),
							'fields' => array('AdmUser.id', 'AdmUser.login', 'AdmRole.name', 'AdmUserRestriction.period', 'AdmUserRestriction.id'),
							'order' => array('AdmUserRestriction.adm_role_id', 'AdmUserRestriction.period')
						));
						if (count($otherRoles) == 0) {
							$this->_createMessage('El usuario no tiene ningun rol activo');
							$this->redirect($this->Auth->logout());
						}
					}
					////////////////////////////////////////////////////////////////////////////////////////////////
				}
				///////////////////////////////////////////////END OF VALIDATION////////////////////////////////////////////////////
				//////////////////////////////////////////////START - LOGIN /////////////////////////////////////////////////////////
				$this->_createUserAccountSession($userInfo['id'], 'login', $userPassword);
				//////////////////////////////////////////////END - LOGIN /////////////////////////////////////////////////////////		
			} else {
				$this->_createMessage('Usuario o contraseña incorrecta, intente de nuevo');
			}
		}
	}

	private function _createUserAccountSession($userId, $tipo, $userPassword = null) {
		////////Fill of sessions distinct to auth component users table

		$this->AdmUser->AdmUserRestriction->bindModel(array(
			'hasOne' => array(
				'AdmProfile' => array(
					'foreignKey' => false,
					'conditions' => array('AdmUser.id = AdmProfile.adm_user_id')
				)
			)
		));

		$infoRole = $this->AdmUser->AdmUserRestriction->find('all', array(
			'fields' => array(
				'AdmUser.login'
				, 'AdmRole.name'
				, 'AdmRole.id'
				, 'AdmUserRestriction.period'
				, 'AdmUserRestriction.id'
				, 'AdmProfile.first_name'
				, 'AdmProfile.last_name1'
				, 'AdmProfile.last_name2'
			),
			'conditions' => array(
				'AdmUserRestriction.adm_user_id' => $userId,
				'AdmUserRestriction.active' => 1,
				'AdmUserRestriction.selected' => 1,
				'AdmUserRestriction.lc_state !=' => 'LOGIC_DELETED'
			)
		));

		if ($userPassword <> null) {//for dynamic user password change
			$userPasswordEncrypted = $this->BittionSecurity->encryptUserSessionPassword($userPassword);
			$this->Session->write('User.password', $userPasswordEncrypted);
		}

		$this->Session->write('currentDeviceTyoe', $this->_fnCheckDeviceType());
		
		$this->Session->write('currentRoleActive', 'yes');
		$this->Session->write('UserRestriction.id', $infoRole[0]['AdmUserRestriction']['id']);  //in case there is no trigger postgres user integration, it will help
		$this->Session->write('User.username', $infoRole[0]['AdmUser']['login']);
		$this->Session->write('User.id', $userId);
		$this->Session->write('Role.name', $infoRole[0]['AdmRole']['name']);
		$this->Session->write('Role.id', $infoRole[0]['AdmRole']['id']);
		$this->Session->write('Menu', $this->_createMenu($this->Session->read('Role.id')));
		$this->Session->write('Period.name', $infoRole[0]['AdmUserRestriction']['period']);
		$this->Session->write('Profile.fullname', $infoRole[0]['AdmProfile']['first_name'] . ' ' . $infoRole[0]['AdmProfile']['last_name1'] . ' ' . $infoRole[0]['AdmProfile']['last_name2']);
		$this->Session->delete('Message.auth'); //to avoid bug showing auth messages when you are kickout and do login again
		$this->_createPermissions($this->Session->read('Role.id'));
		//////////////////////////////////////////////////////////////////////////
		/////////////////////////////Create USER,ROLE,PERIOD Session Buttons///////////////////////////////////////////
		$avaliableRoles = $this->_listAvaliableRoles($userId, $infoRole[0]['AdmRole']['id']);
		$avaliableRolePeriods = $this->AdmUser->AdmUserRestriction->find('list', array(
			'fields' => array(
				'AdmUserRestriction.id', 'AdmUserRestriction.period'
			),
			'conditions' => array(
				'AdmUserRestriction.adm_user_id' => $userId,
				'AdmUserRestriction.adm_role_id' => $infoRole[0]['AdmRole']['id'],
				'AdmUserRestriction.period !=' => $infoRole[0]['AdmUserRestriction']['period'],
				'AdmUserRestriction.selected' => 0,
				'AdmUserRestriction.active' => 1,
				'AdmUserRestriction.active_date > now()',
				'AdmUserRestriction.lc_state !=' => 'LOGIC_DELETED'
			)
		));

		$this->Session->write('Avaliable.rolesPeriods', $avaliableRolePeriods);
		$this->Session->write('Avaliable.roles', $avaliableRoles);
		/////////////////////////////Create USER,ROLE,PERIOD Session Buttons///////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////
		$this->redirect($this->Auth->redirect());
		//Insert on table adm_user_log will be disable for now
//		$this->loadModel('AdmUserLog');
//		try {
//			$this->AdmUserLog->save(array('tipo' => $tipo, 'creator' => $infoRole[0]['AdmUserRestriction']['id']));
//			if ($tipo == 'cambio rol') {
//				$this->Session->setFlash(
//						'Se modificó la sessión de usuario, el rol es <strong>' . $infoRole[0]['AdmRole']['name'] . '</strong> y la gestión es <strong>' . $infoRole[0]['AdmUserRestriction']['period'] . '</strong>', 'alert', array(
//					'plugin' => 'TwitterBootstrap',
//					'class' => 'alert-success'
//						), 'flash_change_user_restriction'
//				);
//			}
//			$this->redirect($this->Auth->redirect());
//		} catch (Exception $e) {
//			$this->_createMessage('Ocurrio un problema con el log, vuelva a intentarlo');
////			$this->_createMessage($e);
//			$this->redirect($this->Auth->logout());
//		}
	
	//End function	
	}

	public function change_password() {
		
	}
	
	private function _fnCheckDeviceType(){
		$dirVendors = App::path('Vendor'); //[0] is /app/Vendor and 1 is /vendors
		require_once $dirVendors[0] . 'Mobile_Detect.php';
		$detect = new Mobile_Detect;
		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
		$scriptVersion = $detect->getScriptVersion();
		return $deviceType;
//		debug($deviceType);
//		debug($scriptVersion);
//		debug($_SERVER['HTTP_USER_AGENT']);
	}
	
	public function ajax_change_password() {
		if ($this->RequestHandler->isAjax()) {
			$password = $this->request->data['password'];
			$idUser = $this->Session->read('User.id');
			$usernameArray = $this->AdmUser->find('list', array(
				'conditions' => array('AdmUser.id' => $idUser),
				'fields' => array('AdmUser.id', 'AdmUser.login')
			));
			$username = reset($usernameArray);
//			if($this->AdmUser->save(array('id'=>$idUser,'password'=>$password))){
//			debug($username);
//			debug($idUser);
//			debug($password);
			if ($this->AdmUser->fnChangePassword($idUser, $password, $username)) {
				if ($password <> '') {
					if ($username == $this->Session->read('User.username')) {
						$this->Session->write('User.username', $username);
						$this->Session->write('User.password', $this->BittionSecurity->encryptUserSessionPassword($password));
					}
					echo 'success';
				}
			} else {
				echo 'save error';
			}
		}
	}

	public function change_email() {
		
	}

	public function ajax_change_email() {
		if ($this->RequestHandler->isAjax()) {
			$email = $this->request->data['email'];
			$idUser = $this->Session->read('User.id');
			$idProfile = $this->AdmUser->AdmProfile->find('list', array(
				'conditions' => array('AdmProfile.adm_user_id' => $idUser),
				'fields' => array('AdmProfile.id', 'AdmProfile.id')
			));
			if ($this->AdmUser->AdmProfile->save(array('id' => key($idProfile), 'email' => $email))) {
				echo 'success';
			}
		}
	}

	public function change_user_restriction() {
		$args = $this->passedArgs;
		$idUser = $this->Session->read('User.id');

		if (isset($args['role'])) {
			$idRole = $args['role'];
//			$period = $this->Session->read('Period.name');
			$period = $this->AdmUser->AdmUserRestriction->find('list', array(
				'limit' => 1,
				'order' => array('AdmUserRestriction.period' => 'DESC'),
				'conditions' => array(
					'AdmUserRestriction.adm_user_id' => $idUser,
//					'AdmUserRestriction.selected'=>0, //Redundant
					'AdmUserRestriction.active' => 1,
					'AdmUserRestriction.active_date > now()',
					'AdmUserRestriction.adm_role_id ' => $idRole,
				),
				'fields' => array('AdmUserRestriction.id', 'AdmUserRestriction.period')
			));  //find last period avaliable
		} elseif (isset($args['period'])) {
			$period = $args['period'];
			$idRole = $this->Session->read('Role.id');
		}



		$idUserRestrictionSelected = $this->AdmUser->AdmUserRestriction->find('list', array(
			'conditions' => array(
				'AdmUserRestriction.adm_user_id' => $idUser,
				'AdmUserRestriction.adm_role_id' => $idRole,
				'AdmUserRestriction.period' => $period
			),
			'limit' => 1,
			'fields' => array('AdmUserRestriction.id', 'AdmUserRestriction.id')
		));

//		debug($idUser);
//		debug($idUserRestrictionSelected);
		$chechLogicDeleted = $this->AdmUser->AdmUserRestriction->find('count', array(
			'conditions'=>array(
				'AdmUserRestriction.id'=>key($idUserRestrictionSelected)
				, 'AdmUserRestriction.lc_state'=>'LOGIC_DELETED')
		));
		
		if($chechLogicDeleted > 0){
			$this->Session->setFlash(
						'<strong>El rol fue eliminado!</strong>', 'alert', array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-error'
						)
				);
			$this->redirect($this->Auth->logout());
		}
		
		try {
			if (!$this->AdmUser->change_user_restriction($idUser, key($idUserRestrictionSelected))) {
				$this->Session->setFlash(
						'<strong>Error!</strong> No se pudo cambiar el <strong>Rol / Gestión</strong>', 'alert', array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-error'
						), 'flash_change_user_restriction'
				);
				$this->redirect(array('action' => 'welcome'));
			}
			$this->_createUserAccountSession($idUser, 'cambio rol');
		} catch (Exception $e) {
			$this->Session->setFlash(
//					$e.
					'Ocurrio un problema al cambiar de <strong>Rol / Gestión</strong>', 'alert', array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
					), 'flash_change_user_restriction'
			);
			$this->redirect(array('action' => 'welcome'));
		}
	}


	private function _createMessage($message, $key = 'error') {
		$this->Session->setFlash('<strong>' . $message . '</strong>', 'alert', array('plugin' => 'TwitterBootstrap', 'class' => 'alert-' . $key)
		);
	}

	private function _createMenu($roleId) {
		$this->loadModel('AdmRolesMenu');
		$parents = $this->AdmRolesMenu->find('all', array(
			'fields' => array('AdmMenu.id', 'AdmMenu.name', 'AdmMenu.icon'
//				, 'AdmAction.name', 'AdmController.name', 'AdmMenu.adm_action_id'
			)
			, 'conditions' => array('AdmRolesMenu.adm_role_id' => $roleId, "AdmMenu.parent_node" => null, 'AdmMenu.inside' => null)
			, 'order' => array('AdmMenu.order_menu')
		));


		/////////////////////////////////////////////////////////////////////
		$str = '';
		/////////////////////////////////////START - Parents///////////////////////////////////////////////////////
		$str.='<ul>';
		foreach ($parents as $key2 => $value2) {
			//////must improve this function for 2.0
			$arrLinkContent = $this->_createLink($value2['AdmMenu']['id'], $value2['AdmMenu']['name'], $value2['AdmMenu']['icon']);
			//////////////Check if submenu only for parents/////////////////
			$submenu = 'class="submenu"';
			if ($arrLinkContent['actionEmpty'] == 'no')
				$submenu = '';
			///////////////////////////////////////////////////////////////
			if ($arrLinkContent['idForLi'] <> '') {
				$idForLi = 'id="' . $arrLinkContent['idForLi'] . '"';
			} else {
				$idForLi = '';
			}
			$str.='<li ' . $idForLi . ' ' . $submenu . ' >' . $arrLinkContent['link']; //$value2['AdmMenu']['name'];
			////////////////////////////////////START - Children 1////////////////////////////////////////////////
			$str.='<ul>';
			$children1 = $this->_findMenus($value2['AdmMenu']['id'], $roleId);
			foreach ($children1 as $key3 => $value3) {
				$arrLinkContent = $this->_createLink($key3, $value3, '');
				if ($arrLinkContent['idForLi'] <> '') {
					$idForLi = 'id="' . $arrLinkContent['idForLi'] . '"';
				} else {
					$idForLi = '';
				}
				$str.='<li ' . $idForLi . '>' . $arrLinkContent['link']; //$value3;
				//more children.....
				$str.='</li>';
			}
			$str.='</ul>';
			////////////////////////////////////END - Children 1////////////////////////////////////////////////
			$str.='</li>';
		}
		$str.='</ul>';
		//////////////////////////////////////END - Parents///////////////////////////////////////////////////////
		return $str;
	}

	private function _createLink($idMenu, $nameMenu, $icon) {
		$projectName = 'imexport';
		$this->loadModel('AdmMenu');

		$this->AdmMenu->unbindModel(array(
			'belongsTo' => array('AdmAction', 'AdmModule'),
			'hasMany' => array('AdmRolesMenu')
		));

		$this->AdmMenu->bindModel(array(
			'hasOne' => array(
				'AdmAction' => array(
					'foreignKey' => false,
					'conditions' => array('AdmMenu.adm_action_id = AdmAction.id')
				),
				'AdmController' => array(
					'foreignKey' => false,
					'conditions' => array('AdmAction.adm_controller_id = AdmController.id')
				),
			)
		));

		$vec = $this->AdmMenu->find('all', array('fields' => array('AdmAction.name', 'AdmController.name'), 'conditions' => array("AdmMenu.id" => $idMenu)));
		$link = '';
		$controlerName = $vec[0]['AdmController']['name'];
		$actionName = strtolower($vec[0]['AdmAction']['name']);
		
//		if($_SERVER['REMOTE_ADDR'] == '127.0.0.1') //this doesn't work		
		$serverList = array('localhost', '127.0.0.1');
		if(in_array($_SERVER['HTTP_HOST'], $serverList)) {
			$link = '/' . $projectName . '/' . $controlerName . '/' . $actionName; //for local
		}else{
			$link = '/' . $controlerName . '/' . $actionName;  //for remote
		}
		
		
		$idForLi = $controlerName.'-'. $actionName; 

		$actionEmpty = 'no';
		if ($vec[0]['AdmAction']['name'] == null) {
			$link = '#';
			$actionEmpty = 'yes';
		}
		//debug($vec);
		if ($icon <> '') {
			/*
			  $idName = '';
			  $nameIcon='';
			  switch($nameMenu){
			  case 'ADMINISTRACION':
			  $nameIcon='icon-wrench';
			  $idName = 'adm';
			  break;
			  case 'INVENTARIO':
			  $nameIcon='icon-list-alt';
			  $idName = 'inv';
			  break;
			  case 'COMPRAS':
			  $nameIcon='icon-shopping-cart';
			  $idName = 'pur';
			  break;
			  case 'VENTAS':
			  $nameIcon='icon-tags';
			  $idName = 'sal';
			  break;
			  }
			 * 
			 */
			if ($vec[0]['AdmAction']['name'] == null) {
				$idForLi = 'menu-' . $nameMenu;
			}
			$str = '<a href="' . $link . '"><i class="icon ' . $icon . '"></i> <span>' . $nameMenu . '</span></a>';
		} else {
			if ($vec[0]['AdmAction']['name'] == null) {
				$idForLi = '';
			}
			$str = '<a href="' . $link . '">' . $nameMenu . '</a>';
		}



		//return $str;
		return array('link' => $str, 'idForLi' => $idForLi, 'actionEmpty' => $actionEmpty);
	}

	private function _findMenus($parent, $roleId) {
		$this->loadModel('AdmRolesMenu');
		$vec = $this->AdmRolesMenu->find('all', array('fields' => array('AdmMenu.id', 'AdmMenu.name'), 'order' => array('AdmMenu.order_menu'), 'conditions' => array("AdmMenu.parent_node" => $parent, "AdmRolesMenu.adm_role_id" => $roleId)));
		$found = array();
		if (count($vec) > 0) {
			foreach ($vec as $key => $value) {
				$found[$value['AdmMenu']['id']] = $value['AdmMenu']['name'];
			}
			//debug($found);
		}
		return $found;
	}

	private function _createPermissions($roleId) {
		$this->loadModel('AdmRolesAction');

		//debug($array);
		$this->AdmRolesAction->unbindModel(array(
			'belongsTo' => array('AdmRole', 'AdmMenu'),
		));

		$this->AdmRolesAction->bindModel(array(
			'belongsTo' => array(
				'AdmController' => array(
					'foreignKey' => false,
					'conditions' => array('AdmAction.adm_controller_id = AdmController.id', '')
				)
			)
		));

		$vec = $this->AdmRolesAction->find('all', array(
			'conditions' => array('AdmRolesAction.adm_role_id' => $roleId)
			, 'fields' => array('AdmRolesAction.adm_role_id', 'AdmRolesAction.adm_action_id', 'AdmAction.id', 'AdmAction.name', 'AdmController.name')
		));
		//debug($vec);
		$formated = array();
//		$extra = array();
		if (count($vec) > 0) {
			foreach ($vec as $key => $value) {
				if ($value['AdmAction']['name'] != '') {
					$formated[$key]['controller'] = Inflector::camelize($value['AdmController']['name']);
//					$formated[$key]['action'] = strtolower($value['AdmAction']['name']);
					$formated[$key]['action'] = $value['AdmAction']['name'];
				}
			}
		}
		//debug($formated);

		$formatExtra = array();

		//debug($formatExtra);
		$merge = array_merge($formated, $formatExtra);
		//debug($merge);
		//Initial Session Permision Data
		$this->Session->write('Permission.AdmUsers.welcome', 'welcome');
//		$this->Session->write('Permission.AdmUsers.login', 'login');
		$this->Session->write('Permission.AdmUsers.logout', 'logout');
		$this->Session->write('Permission.AdmUsers.choose_role', 'choose_role');
		$this->Session->write('Permission.AdmUsers.change_password', 'change_password');
		$this->Session->write('Permission.AdmUsers.change_user_restriction', 'change_user_restriction');
		$this->Session->write('Permission.AdmUsers.change_email', 'change_email');
		$this->Session->write('Permission.AdmUsers.view_user_profile', 'view_user_profile');
		$this->Session->write('Permission.AdmUsers.ie_denied', 'ie_denied');

		///// save in session array 
		for ($i = 0; $i < count($merge); $i++) {
			$this->Session->write('Permission.' . $merge[$i]['controller'] . '.' . $merge[$i]['action'], $merge[$i]['action']);
		}
	}

	private function _findControllerActionAjax($parent) {
		$this->loadModel('AdmAction');
		$array = $this->AdmAction->find('all', array(
			'conditions' => array('AdmAction.parent' => $parent)
			, 'fields' => array('AdmAction.name', 'AdmController.name')
		));
		return $array;
	}

	public function welcome() {

		$period = $this->Session->read('Period.name');
//		$this->_countDocuments($period, 'InvMovement', 'APPROVED', 'SAL');//must improve with subquery, for now 82ms with 6000 rows, it's not that bad
		$total = array();
		if ($this->Session->read('Role.id') == 1 OR $this->Session->read('Role.id') == 2) {
			//Movements
			$total['inApproved'] = $this->_countDocuments($period, 'InvMovement', 'APPROVED', 'ENT');
			$total['inPendant'] = $this->_countDocuments($period, 'InvMovement', 'PENDANT', 'ENT');
			$total['inCancelled'] = $this->_countDocuments($period, 'InvMovement', 'CANCELLED', 'ENT');

			$total['outApproved'] = $this->_countDocuments($period, 'InvMovement', 'APPROVED', 'SAL');
			$total['outPendant'] = $this->_countDocuments($period, 'InvMovement', 'PENDANT', 'SAL');
			$total['outCancelled'] = $this->_countDocuments($period, 'InvMovement', 'CANCELLED', 'SAL');
			//Sales
			$total['sinvoiceApproved'] = $this->_countDocuments($period, 'SalSale', 'SINVOICE_APPROVED', 'VEN');
			$total['sinvoicePendant'] = $this->_countDocuments($period, 'SalSale', 'SINVOICE_PENDANT', 'VEN');
			$total['sinvoiceCancelled'] = $this->_countDocuments($period, 'SalSale', 'SINVOICE_CANCELLED', 'VEN');

			$total['snoteApproved'] = $this->_countDocuments($period, 'SalSale', 'NOTE_APPROVED', 'VEN');
			$total['snotePendant'] = $this->_countDocuments($period, 'SalSale', 'NOTE_PENDANT', 'VEN');
			$total['snoteCancelled'] = $this->_countDocuments($period, 'SalSale', 'NOTE_CANCELLED', 'VEN');
			//Purchases
			$total['pinvoiceApproved'] = $this->_countDocuments($period, 'PurPurchase', 'PINVOICE_APPROVED', 'COM');
			$total['pinvoicePendant'] = $this->_countDocuments($period, 'PurPurchase', 'PINVOICE_PENDANT', 'COM');
			$total['pinvoiceCancelled'] = $this->_countDocuments($period, 'PurPurchase', 'PINVOICE_CANCELLED', 'COM');

			$total['porderApproved'] = $this->_countDocuments($period, 'PurPurchase', 'ORDER_APPROVED', 'COM');
			$total['porderPendant'] = $this->_countDocuments($period, 'PurPurchase', 'ORDER_PENDANT', 'COM');
			$total['porderCancelled'] = $this->_countDocuments($period, 'PurPurchase', 'ORDER_CANCELLED', 'COM');
			//debug($total);
		}
		$this->set(compact('total'));
	}

	private function _countDocuments($period, $model, $lcState, $codePrefix) {

		$this->loadModel($model);
		$count = $this->$model->find('count', array(
			'conditions' => array(
				"to_char(" . $model . ".date,'YYYY')" => $period,
				$model . '.lc_state' => $lcState,
				'substring(' . $model . '.code from 1 for 3) =' => $codePrefix
			),
			'recursive' => -1
		));

		return $count;
	}

	private function _listAvaliableRoles($userId, $roleId) {
		$avaliableRoles = $this->AdmUser->AdmUserRestriction->find('all', array(
			'fields' => array(
				'AdmRole.name',
				'AdmRole.id'
			),
			'conditions' => array(
				'AdmUserRestriction.adm_user_id' => $userId,
				'AdmUserRestriction.selected' => 0,
				'AdmUserRestriction.active' => 1,
				'AdmUserRestriction.active_date > now()',
				'AdmUserRestriction.adm_role_id !=' => $roleId,
				'AdmUserRestriction.lc_state !=' => 'LOGIC_DELETED'
			),
			'group' => array(
				'AdmRole.id',
				'AdmRole.name'
			)
		));

		$array = array();
		for ($i = 0; $i < count($avaliableRoles); $i++) {
			$queryRole = $avaliableRoles[$i]['AdmRole']['id'];
			$array[$queryRole] = $avaliableRoles[$i]['AdmRole']['name']; //.' | '.$avaliableRoles[$i]['AdmUserRestriction']['period'];
		}
		return $array;
	}

	public function logout() {
//		$this->Session->destroy(); //Some servers have issues with cakephp session component
		session_destroy(); //Therefore I'll use defaul php session
		$this->_createMessage('La sesión termino!', 'info');
		$this->redirect($this->Auth->logout());
	}

/////////////////////////////////////////////////////////////////////////////////////

	public function ajax_generate_user_name() {
		if ($this->RequestHandler->isAjax()) {
			////////////////////////////////////////////START AJAX/////////////////////////////////////////////
			return $this->_generate_user_name($this->request->data['first_name'], $this->request->data['last_name']);
			////////////////////////////////////////////END AJAX///////////////////////////////////////////////
		}
	}

	private function _generate_user_name($first_name, $last_name) {

		$firstName = explode(' ', strtolower($first_name));
		//debug($firstName);
		$lastName = explode(' ', strtolower($last_name));
		//debug($lastName);
		$userNameSimple = substr(trim($firstName[0]), 0, 1) . trim($lastName[0]);
		//debug($userNameSimple);
		$userNameFull = '';
		if (isset($lastName[1]) && $lastName[1] <> '') {
			$userNameFull = $userNameSimple . substr(trim($lastName[1]), 0, 1);
			//debug($userNameFull);
		}

		if ($userNameFull == '') {
			$userNameAux = $userNameSimple;
		} else {
			$userNameAux = $userNameFull;
		}
		//debug($userNameAux);
		$userName = $userNameAux;
		$founded = $this->AdmUser->find('count', array('conditions' => array('AdmUser.login LIKE' => '%' . $userNameAux . '%')));
		//debug($founded);

		if ($founded > 0) {
			$userName = $userNameAux . '_' . ($founded + 1);
		}

		return $userName;
	}

	private function _generate_password($length = 10) {
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		//everything is done with ajax thats why is empty
	}

	public function ajax_verify_unique_di_number() {
		if ($this->RequestHandler->isAjax()) {
			$diNumber = $this->request->data['diNumber'];

			$res = $this->AdmUser->AdmProfile->find('count', array(
				'conditions' => array('AdmProfile.di_number' => $diNumber),
				'recursive' => -1
			));
			echo $res;
		}
	}

	public function ajax_reset_password() {
		if ($this->RequestHandler->isAjax()) {
			$idUser = $this->request->data['idUser'];
			$password = $this->_generate_password(8);
//			$this->AdmUser->save(array('id'=>$idUser, 'password'=>$password));
			$usernameArray = $this->AdmUser->find('list', array(
				'conditions' => array('AdmUser.id' => $idUser),
				'fields' => array('AdmUser.id', 'AdmUser.login')
			));
			$username = reset($usernameArray);
			
			if ($this->AdmUser->fnChangePassword($idUser, $password, $username)) {
				if ($password <> '') {
					if ($username == $this->Session->read('User.username')) {
						$this->Session->write('User.username', $username);
						$this->Session->write('User.password', $this->BittionSecurity->encryptUserSessionPassword($password));
					}
					$this->Session->write('Temp.username', $username);
					$this->Session->write('Temp.password', $password);
					echo 'success';
				}
			}
		}
	}

	public function ajax_add_user_restrictions() {
		if ($this->RequestHandler->isAjax()) {
			$AdmUserRestriction['adm_role_id'] = $this->request->data['roleId'];
			$AdmUserRestriction['adm_area_id'] = $this->request->data['areaId'];
			$AdmUserRestriction['adm_user_id'] = $this->request->data['userId'];
			$AdmUserRestriction['period'] = $this->request->data['period'];
			$AdmUserRestriction['active'] = $this->request->data['active'];
			$AdmUserRestriction['active_date'] = $this->request->data['activeDate'];
			$AdmUserRestriction['selected'] = 0;

			if (isset($this->request->data['selected']))
				$AdmUserRestriction['selected'] = $this->request->data['selected'];

			//Check if already exists (LOGIC_DELETED), to active instead of create a new one
			$alreadyExists = $this->AdmUser->AdmUserRestriction->find('list', array(
				'conditions' => array(
					'AdmUserRestriction.adm_user_id' => $AdmUserRestriction['adm_user_id'],
					'AdmUserRestriction.adm_role_id' => $AdmUserRestriction['adm_role_id'],
					'AdmUserRestriction.period' => $AdmUserRestriction['period'],
					'AdmUserRestriction.lc_state' => 'LOGIC_DELETED'
				),
				'fields' => array('AdmUserRestriction.id', 'AdmUserRestriction.id'),
				'limit' => 1
			));
//			debug($alreadyExists);
			if (count($alreadyExists) == 1) {
				$AdmUserRestriction['id'] = reset($alreadyExists);
				$AdmUserRestriction['lc_state'] = 'ELABORATED';
			}

			if ($this->AdmUser->fnSaveUserRestriction($AdmUserRestriction)) {
				echo 'success|' . $this->request->data['roleId'];
			} else {
				echo 'error';
			}
		}
	}

	public function ajax_edit_user_restrictions() {
		if ($this->RequestHandler->isAjax()) {
			$ownUserRestriction = 'no';

			$AdmUserRestriction['id'] = $this->request->data['userRestrictionId'];
			$AdmUserRestriction['adm_area_id'] = $this->request->data['areaId'];
			$AdmUserRestriction['adm_user_id'] = $this->request->data['userId'];

			if (isset($this->request->data['active'])) {
				$AdmUserRestriction['active'] = $this->request->data['active'];
			}

			if (isset($this->request->data['activeDate'])) {
				$AdmUserRestriction['active_date'] = $this->request->data['activeDate'];
			}

			if (isset($this->request->data['selected'])) {
				$AdmUserRestriction['selected'] = $this->request->data['selected'];
//				$ownUserRestriction = 'yes';
			} else {//if the is not selected, it means the owner is editing its own role, because that control is erased when that happens 
				$ownUserRestriction = 'yes';
			}
//			debug($AdmUserRestriction);
			if ($this->AdmUser->fnSaveUserRestriction($AdmUserRestriction, $ownUserRestriction)) {
				echo 'success';
			} else {
				echo 'error';
			}
		}
	}

	public function ajax_add_user_profile() {
		if ($this->RequestHandler->isAjax()) {
			////////////////////////////////////////////START AJAX///////////////////////////////////////////////
			$AdmUser = array();
			$AdmProfile = array();

			$username = $this->_generate_user_name(trim($this->request->data['txtFirstName']), str_replace(' ', '', $this->request->data['txtLastName1']) . ' ' . str_replace(' ', '', $this->request->data['txtLastName2']));
			$password = $this->_generate_password(8);
			$AdmUser['login'] = $username;
			$AdmUser['password'] = AuthComponent::password($password);
			$AdmUser['active'] = $this->request->data['cbxActive'];
			$AdmUser['active_date'] = $this->request->data['txtActiveDate'];
			//$AdmUser['creator'] = $this->Session->read('UserRestriction.id');


			$AdmProfile['di_number'] = $this->request->data['txtDiNumber'];
			$AdmProfile['di_place'] = $this->request->data['txtDiPlace'];
			$AdmProfile['first_name'] = trim($this->request->data['txtFirstName']);
			$AdmProfile['last_name1'] = trim($this->request->data['txtLastName1']);
			$AdmProfile['last_name2'] = trim($this->request->data['txtLastName2']);
			$AdmProfile['email'] = $this->request->data['txtEmail'];
			$AdmProfile['job'] = $this->request->data['txtJob'];
			$AdmProfile['birthdate'] = $this->request->data['txtBirthdate'];
			$AdmProfile['birthplace'] = $this->request->data['txtBirthplace'];
			if ($this->request->data['txtAddress'] <> '') {
				$AdmProfile['address'] = $this->request->data['txtAddress'];
			}
			if ($this->request->data['txtPhone'] <> '') {
				$AdmProfile['phone'] = $this->request->data['txtPhone'];
			}
			//$AdmProfile['creator'] = $this->Session->read('UserRestriction.id');


			$data = array('AdmUser' => $AdmUser, 'AdmProfile' => $AdmProfile);
//			if($this->AdmUser->saveAssociated($data)){
			if ($this->AdmUser->fnAddUserProfile($data, $username, $password)) {
				$this->Session->write('Temp.username', $username);
				$this->Session->write('Temp.password', $password);
				echo 'success';
			}

			////////////////////////////////////////////END AJAX///////////////////////////////////////////////
		}
	}

	public function ajax_edit_user_profile() {
		if ($this->RequestHandler->isAjax()) {
			$AdmUser = array();
			$AdmProfile = array();
			$idUser = $this->request->data['idUser'];
			$AdmUser['id'] = $idUser;
			$idProfile = $this->AdmUser->AdmProfile->find('list', array('conditions' => array('AdmProfile.adm_user_id' => $idUser)));
			$AdmProfile['id'] = key($idProfile); //get first element value
//			debug($AdmProfile['id']);
			$AdmUser['active'] = $this->request->data['cbxActive'];
			$AdmUser['active_date'] = $this->request->data['txtActiveDate'];
			//$AdmUser['creator'] = $this->Session->read('UserRestriction.id');

			$AdmProfile['di_number'] = $this->request->data['txtDiNumber'];
			$AdmProfile['di_place'] = $this->request->data['txtDiPlace'];
			$AdmProfile['first_name'] = trim($this->request->data['txtFirstName']);
			$AdmProfile['last_name1'] = trim($this->request->data['txtLastName1']);
			$AdmProfile['last_name2'] = trim($this->request->data['txtLastName2']);
			$AdmProfile['email'] = $this->request->data['txtEmail'];
			$AdmProfile['job'] = $this->request->data['txtJob'];
			$AdmProfile['birthdate'] = $this->request->data['txtBirthdate'];
			$AdmProfile['birthplace'] = $this->request->data['txtBirthplace'];
			if ($this->request->data['txtAddress'] <> '') {
				$AdmProfile['address'] = $this->request->data['txtAddress'];
			}
			if ($this->request->data['txtPhone'] <> '') {
				$AdmProfile['phone'] = $this->request->data['txtPhone'];
			}
			$AdmProfile['modifier'] = $this->Session->read('UserRestriction.id');
			$AdmProfile['lc_transaction'] = 'MODIFY';

			if ($this->AdmUser->AdmProfile->save($AdmProfile)) {
				if ($this->AdmUser->save($AdmUser)) {
					echo 'success';
				}
			}
			//This is better BUT it doesn't work with the triggers when a user is desactivating its own user
//			if ($this->AdmUser->saveAssociated(array('AdmUser'=>$AdmUser,'AdmProfile'=>$AdmProfile))) {
//				echo 'success';
//			}
		}
	}

	public function view_user_created() {
		if ($this->Session->check('Temp.username') && $this->Session->check('Temp.password')) {
			$this->set('username', $this->Session->read('Temp.username'));
			$this->set('password', $this->Session->read('Temp.password'));
			$this->Session->delete('Temp.username');
			$this->Session->delete('Temp.password');
		} else {
			//throw new NotFoundException(__('Invalid post'));
			$this->redirect(array('action' => 'add'));
		}
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function edit() {
		$id = '';
		if (isset($this->passedArgs['id'])) {
			$id = $this->passedArgs['id'];
		} else {
			$this->redirect(array('action' => 'index'));
		}
		if($this->Session->read('Role.id') <> 1 AND $id == 1){
			$this->redirect(array('action' => 'index')); //Only SUPER USER CAN EDIT its own account
		}
		$this->AdmUser->id = $id;
		if (!$this->AdmUser->exists()) {
			throw new NotFoundException(__('No existe'));
		}
		$this->request->data = $this->AdmUser->read(null, $id);
		$this->set('data', $this->request->data);
	}

	public function view_user_profile() {
		$id = $this->Session->read('User.id');
		;
		$this->AdmUser->id = $id;
		$this->request->data = $this->AdmUser->read(null, $id);
		$this->set('data', $this->request->data);
	}

	/**
	 * delete method
	 *
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
	}

	public function delete_user_restriction($idUserRestriction = null, $idUser = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->AdmUser->AdmUserRestriction->id = $idUserRestriction;
		if (!$this->AdmUser->AdmUserRestriction->exists()) {
			throw new NotFoundException(__('Invalido %s', __('rol usuario')));
		}
		$data = array();
		if ($this->request->is('post') || $this->request->is('put')) {
			$data['AdmUserRestriction']['lc_state'] = 'LOGIC_DELETED';
//			debug($data);
//			$data['AdmUserRestriction']['id']=$idUserRestriction;
//			debug($data);
			
			try{
				$this->AdmUser->AdmUserRestriction->save($data);
				$this->Session->setFlash(
						'Eliminado con exito!', 'alert', array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
						)
				);
				$this->redirect(array('action' => 'index_user_restriction', $idUser));
			}catch(Exception $e){
				if($e->getCode() == 'P0001'){
					$this->Session->setFlash(
							$e->getMessage().
							'Ocurrio un problema, vuelva a intentarlo', 'alert', array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
							)
					);
					$this->redirect(array('action' => 'index_user_restriction', $idUser));
				}
//				debug($e->getCode());
//				debug($e->getMessage());
//				$string = $e->getMessage();
//				debug(explode((string)$string, ' '));
//				debug($string);
				$this->redirect(array('action' => 'index_user_restriction', $idUser));
			}
			
			if ($this->AdmUser->AdmUserRestriction->save($data)) {
				$this->Session->setFlash(
						'Eliminado con exito!', 'alert', array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
						)
				);
				$this->redirect(array('action' => 'index_user_restriction', $idUser));
			} else {
				$this->Session->setFlash(
						'Ocurrio un problema, vuelva a intentarlo', 'alert', array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-error'
						)
				);
				$this->redirect(array('action' => 'index_user_restriction', $idUser));
			}
		}
	}

//END Class	
}

