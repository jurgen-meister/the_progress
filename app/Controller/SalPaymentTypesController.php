<?php
App::uses('AppController', 'Controller');
/**
 * SalPaymentTypes Controller
 *
 * @property SalPaymentType $SalPaymentType
 */
class SalPaymentTypesController extends AppController {

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
	public $components = array('Session');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->SalPaymentType->recursive = 0;
		$this->set('salPaymentTypes', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->SalPaymentType->id = $id;
		if (!$this->SalPaymentType->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal payment type')));
		}
		$this->set('salPaymentType', $this->SalPaymentType->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SalPaymentType->create();
			if ($this->SalPaymentType->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('sal payment type')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('sal payment type')),
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
		$this->SalPaymentType->id = $id;
		if (!$this->SalPaymentType->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal payment type')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['SalPaymentType']['lc_transaction']='MODIFY';
			if ($this->SalPaymentType->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('sal payment type')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('sal payment type')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->SalPaymentType->read(null, $id);
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
		$this->SalPaymentType->id = $id;
		if (!$this->SalPaymentType->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal payment type')));
		}
		if ($this->SalPaymentType->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('sal payment type')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('sal payment type')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
