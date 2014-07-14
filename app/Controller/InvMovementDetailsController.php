<?php
App::uses('AppController', 'Controller');
/**
 * InvMovementDetails Controller
 *
 * @property InvMovementDetail $InvMovementDetail
 */
class InvMovementDetailsController extends AppController {

/**
 *  Layout
 *
 * @var string
 */
	public $layout = 'bootstrap';

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('TwitterBootstrap.BootstrapHtml', 'TwitterBootstrap.BootstrapForm', 'TwitterBootstrap.BootstrapPaginator');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Session');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->InvMovementDetail->recursive = 0;
		$this->set('invMovementDetails', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->InvMovementDetail->id = $id;
		if (!$this->InvMovementDetail->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv movement detail')));
		}
		$this->set('invMovementDetail', $this->InvMovementDetail->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->InvMovementDetail->create();
			if ($this->InvMovementDetail->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('inv movement detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('inv movement detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		$invItems = $this->InvMovementDetail->InvItem->find('list');
		$invWarehouses = $this->InvMovementDetail->InvWarehouse->find('list');
		$invMovements = $this->InvMovementDetail->InvMovement->find('list');
		$this->set(compact('invItems', 'invWarehouses', 'invMovements'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->InvMovementDetail->id = $id;
		if (!$this->InvMovementDetail->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv movement detail')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->InvMovementDetail->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('inv movement detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('inv movement detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->InvMovementDetail->read(null, $id);
		}
		$invItems = $this->InvMovementDetail->InvItem->find('list');
		$invWarehouses = $this->InvMovementDetail->InvWarehouse->find('list');
		$invMovements = $this->InvMovementDetail->InvMovement->find('list');
		$this->set(compact('invItems', 'invWarehouses', 'invMovements'));
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
		$this->InvMovementDetail->id = $id;
		if (!$this->InvMovementDetail->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv movement detail')));
		}
		if ($this->InvMovementDetail->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('inv movement detail')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('inv movement detail')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
