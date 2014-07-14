<?php
App::uses('AppController', 'Controller');
/**
 * InvSuppliers Controller
 *
 * @property InvSupplier $InvSupplier
 */
class InvSuppliersController extends AppController {

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
//	public  function isAuthorized($user){
//		return $this->Permission->isAllowed($this->name, $this->action, $this->Session->read('Permission.'.$this->name));
//	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->InvSupplier->recursive = 0;
		$this->set('invSuppliers', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->InvSupplier->id = $id;
		if (!$this->InvSupplier->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv supplier')));
		}
		$this->set('invSupplier', $this->InvSupplier->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->InvSupplier->create();
			if ($this->InvSupplier->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('inv supplier')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('inv supplier')),
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
		$this->InvSupplier->id = $id;
		if (!$this->InvSupplier->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv supplier')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['InvSupplier']['lc_transaction'] = 'MODIFY';
			if ($this->InvSupplier->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('inv supplier')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('inv supplier')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->InvSupplier->read(null, $id);
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
		$this->InvSupplier->id = $id;
		if (!$this->InvSupplier->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv supplier')));
		}
		if ($this->InvSupplier->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('inv supplier')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('inv supplier')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
