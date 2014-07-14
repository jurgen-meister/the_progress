<?php
App::uses('AppController', 'Controller');
/**
 * InvSupplierContacts Controller
 *
 * @property InvSupplierContact $InvSupplierContact
 */
class InvSupplierContactsController extends AppController {

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
		$this->InvSupplierContact->recursive = 0;
		$this->set('invSupplierContacts', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->InvSupplierContact->id = $id;
		if (!$this->InvSupplierContact->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv supplier contact')));
		}
		$this->set('invSupplierContact', $this->InvSupplierContact->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->InvSupplierContact->create();
			if ($this->InvSupplierContact->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('inv supplier contact')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('inv supplier contact')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		$invSuppliers = $this->InvSupplierContact->InvSupplier->find('list');
		$this->set(compact('invSuppliers'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->InvSupplierContact->id = $id;
		if (!$this->InvSupplierContact->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv supplier contact')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['InvSupplierContact']['lc_transaction']='MODIFY';
			if ($this->InvSupplierContact->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('inv supplier contact')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('inv supplier contact')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->InvSupplierContact->read(null, $id);
		}
		$invSuppliers = $this->InvSupplierContact->InvSupplier->find('list');
		$this->set(compact('invSuppliers'));
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
		$this->InvSupplierContact->id = $id;
		if (!$this->InvSupplierContact->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv supplier contact')));
		}
		if ($this->InvSupplierContact->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('inv supplier contact')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('inv supplier contact')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
