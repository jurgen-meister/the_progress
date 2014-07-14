<?php
App::uses('AppController', 'Controller');
/**
 * PurPaymentTypes Controller
 *
 * @property PurPaymentType $PurPaymentType
 */
class PurPaymentTypesController extends AppController {

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
		$this->PurPaymentType->recursive = 0;
		$this->set('purPaymentTypes', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->PurPaymentType->id = $id;
		if (!$this->PurPaymentType->exists()) {
			throw new NotFoundException(__('Invalid %s', __('pur payment type')));
		}
		$this->set('purPaymentType', $this->PurPaymentType->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PurPaymentType->create();
			if ($this->PurPaymentType->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('pur payment type')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('pur payment type')),
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
		$this->PurPaymentType->id = $id;
		if (!$this->PurPaymentType->exists()) {
			throw new NotFoundException(__('Invalid %s', __('pur payment type')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PurPaymentType->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('pur payment type')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('pur payment type')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->PurPaymentType->read(null, $id);
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
		$this->PurPaymentType->id = $id;
		if (!$this->PurPaymentType->exists()) {
			throw new NotFoundException(__('Invalid %s', __('pur payment type')));
		}
		if ($this->PurPaymentType->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('pur payment type')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('pur payment type')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
