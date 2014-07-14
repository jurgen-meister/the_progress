<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $helpers = array(
		'Session',
		'Js',
		'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
		'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
		'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
	);
	public $components = array(
		'RequestHandler',
		'Session',
		'BittionMain',
//		'BittionPermission',
		'BittionSecurity',
		'Auth' => array(
			'authenticate' => array(
				'Form' => array(
					'userModel' => 'AdmUser',
					 'fields' => array('username' => 'login')
				)
			)
			, 'loginRedirect' => array('controller' => 'admUsers', 'action' => 'welcome')
			, 'logoutRedirect' => array('controller' => 'admUsers', 'action' => 'login')//this is used for login and logout
			, 'loginAction' => array(
				'controller' => 'admUsers',
				'action' => 'login',
			)
			, 'authError' => 'Auth Error'
			, 'authorize' => array('Controller') // para que sirva la function isAuthorized sino naranjas
		)
	);

	public function beforeFilter() {

		if (!isset($_SESSION))session_start(); //If session didn't start, then start it
//$this->Auth->allow('login');$this->Auth->allow();//// other methods to allow action without isAuthorized. Leave it here for future reference
		if ($this->name == 'AdmUsers' && $this->action == 'login') {
			//nothing
		} else {
			if ($this->Session->check('User')) {//START check session, to avoid error on checking on database when there is no session and somebody want to enter when is not login
				// not using due only one db-user on heroku
				/*
				//[1]///////////////////////////Connects dynamically to the DB/////////////////////////////////
				$login = $this->Session->read('User.username');
				$password = $this->Session->read('User.password');
				$passwordDecrypted = $this->BittionSecurity->decryptUserSessionPassword($password);
				if (!$this->BittionMain->connectDatabaseDynamically($login, $passwordDecrypted)) {
					$this->Session->setFlash('<strong>Error!</strong> fallo la conexión a la base de datos.', 'alert', array('plugin' => 'TwitterBootstrap', 'class' => 'alert-error'));
					$this->redirect(array('controller' => 'AdmUsers', 'action' => 'login'));
				}
				*/
				//[2]////////////////////////////////Checks live if user/role is active
				$userRestrictionId = $this->Session->read('UserRestriction.id');
				$checkUserRoleActive = $this->BittionSecurity->liveCheckUserRoleActive($userRestrictionId);
				if ($checkUserRoleActive <> '') {
					$flashMessageName = 'flash_check_active';
					if ($checkUserRoleActive == 'role inactive') {
						$message = 'El rol fue desactivado!';
						$this->Session->write('currentRoleActive', $checkUserRoleActive);
						$this->Session->setFlash('<strong>' . $message . '</strong>', 'alert', array('plugin' => 'TwitterBootstrap', 'class' => 'alert-error'), $flashMessageName);
					} elseif ($checkUserRoleActive == 'role expired') {
						$message = 'El tiempo de duración del rol terminó!';
						$this->Session->write('currentRoleActive', $checkUserRoleActive);
						$this->Session->setFlash('<strong>' . $message . '</strong>', 'alert', array('plugin' => 'TwitterBootstrap', 'class' => 'alert-error'), $flashMessageName);
					} elseif ($checkUserRoleActive == 'unselected') {
						$message = 'Se cambio de rol principal! Vuelva a iniciar sessión.';
						$this->Session->setFlash('<strong>' . $message . '</strong>', 'alert', array('plugin' => 'TwitterBootstrap', 'class' => 'alert-error'));
						$this->redirect($this->Auth->logout());
					} elseif ($checkUserRoleActive == 'user inactive') {
						$message = 'El usuario fue desactivado!';
						$this->Session->setFlash('<strong>' . $message . '</strong>', 'alert', array('plugin' => 'TwitterBootstrap', 'class' => 'alert-error'));
						$this->redirect($this->Auth->logout());
					} elseif ($checkUserRoleActive == 'user expired') {
						$message = 'La cuenta de usuario expiró!';
						$this->Session->setFlash('<strong>' . $message . '</strong>', 'alert', array('plugin' => 'TwitterBootstrap', 'class' => 'alert-error'));
						$this->redirect($this->Auth->logout());
					} elseif ($checkUserRoleActive == 'empty') {
						$message = 'El rol fue eliminado!';
						$this->Session->setFlash('<strong>' . $message . '</strong>', 'alert', array('plugin' => 'TwitterBootstrap', 'class' => 'alert-error'));
						$this->redirect($this->Auth->logout());
					}
				} else {
//				CakeSession::delete('Message.flash_check_active'); //also works to clear flash message
					if ($this->Session->read('currentRoleActive') <> 'yes') {
						$this->Session->write('currentRoleActive', 'yes');
					}
					$this->Session->delete('Message.flash_check_active');
				}
			}//END check session
		}
		//End Before Filter
	}

	public function isAuthorized($user) {
		return true; //when is true there aren't permissions
//		return $this->BittionSecurity->allowPermission($this->name, $this->action, $this->Session->read('Permission.'.$this->name)); //it activates permission for all controllers
	}

}

