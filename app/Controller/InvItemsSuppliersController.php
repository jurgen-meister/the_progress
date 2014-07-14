<?php
App::uses('AppController', 'Controller');
/**
 * InvItemsSuppliers Controller
 *
 * @property InvItemsSupplier $InvItemsSupplier
 */
class InvItemsSuppliersController extends AppController {

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
		$this->InvItemsSupplier->recursive = 0;
		$this->set('invItemsSuppliers', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->InvItemsSupplier->id = $id;
		if (!$this->InvItemsSupplier->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv items supplier')));
		}
		$this->set('invItemsSupplier', $this->InvItemsSupplier->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->InvItemsSupplier->create();
			if ($this->InvItemsSupplier->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('inv items supplier')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('inv items supplier')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		$invSuppliers = $this->InvItemsSupplier->InvSupplier->find('list');
		$invItems = $this->InvItemsSupplier->InvItem->find('list');
		$this->set(compact('invSuppliers', 'invItems'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->InvItemsSupplier->id = $id;
		if (!$this->InvItemsSupplier->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv items supplier')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->InvItemsSupplier->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('inv items supplier')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('inv items supplier')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->InvItemsSupplier->read(null, $id);
		}
		$invSuppliers = $this->InvItemsSupplier->InvSupplier->find('list');
		$invItems = $this->InvItemsSupplier->InvItem->find('list');
		$this->set(compact('invSuppliers', 'invItems'));
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
		$this->InvItemsSupplier->id = $id;
		if (!$this->InvItemsSupplier->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv items supplier')));
		}
		if ($this->InvItemsSupplier->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('inv items supplier')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('inv items supplier')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
