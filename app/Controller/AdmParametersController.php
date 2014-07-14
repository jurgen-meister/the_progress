<?php
App::uses('AppController', 'Controller');
/**
 * AdmParameters Controller
 *
 * @property AdmParameter $AdmParameter
 */
class AdmParametersController extends AppController {

/**
 *  Layout
 *
 * @var string
 */
	public $layout = 'default';

/**
 * Helpers
 *
 * @var array
 */
	//public $helpers = array('TwitterBootstrap.BootstrapHtml', 'TwitterBootstrap.BootstrapForm', 'TwitterBootstrap.BootstrapPaginator');
/**
 * Components
 *
 * @var array
 */
	//public $components = array('Session');
	

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->AdmParameter->recursive = 0;
		$this->set('admParameters', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->AdmParameter->create();
			if ($this->AdmParameter->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('adm parameter')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('adm parameter')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->AdmParameter->id = $id;
		if (!$this->AdmParameter->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm parameter')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['AdmParameter']['lc_transaction']='MODIFY';
			if ($this->AdmParameter->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('adm parameter')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('adm parameter')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->AdmParameter->read(null, $id);
		}
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
		$this->AdmParameter->id = $id;
		if (!$this->AdmParameter->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm parameter')));
		}
		if ($this->AdmParameter->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('adm parameter')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('adm parameter')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}	
}
