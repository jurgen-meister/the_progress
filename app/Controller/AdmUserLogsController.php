<?php
App::uses('AppController', 'Controller');
/**
 * AdmUserLogs Controller
 *
 * @property AdmUserLog $AdmUserLog
 */
class AdmUserLogsController extends AppController {

/**
 *  Layout
 *
 * @var string
 */
//	public $layout = 'bootstrap';

/**
 * Helpers
 *
 * @var array
 */
//	public $helpers = array('TwitterBootstrap.BootstrapHtml', 'TwitterBootstrap.BootstrapForm', 'TwitterBootstrap.BootstrapPaginator');
/**
 * Components
 *
 * @var array
 */
//	public $components = array('Session');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->AdmUserLog->recursive = 0;
		$this->set('admUserLogs', $this->paginate());
	}



/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->AdmUserLog->create();
			if ($this->AdmUserLog->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('adm user log')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('adm user log')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		$admUserRestrictions = $this->AdmUserLog->AdmUserRestriction->find('list');
		$this->set(compact('admUserRestrictions'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->AdmUserLog->id = $id;
		if (!$this->AdmUserLog->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm user log')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->AdmUserLog->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('adm user log')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('adm user log')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->AdmUserLog->read(null, $id);
		}
		$admUserRestrictions = $this->AdmUserLog->AdmUserRestriction->find('list');
		$this->set(compact('admUserRestrictions'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->AdmUserLog->id = $id;
		if (!$this->AdmUserLog->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm user log')));
		}
		if ($this->AdmUserLog->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('adm user log')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('adm user log')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
