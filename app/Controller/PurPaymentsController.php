<?php
App::uses('AppController', 'Controller');
/**
 * PurPayments Controller
 *
 * @property PurPayment $PurPayment
 */
class PurPaymentsController extends AppController {

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
		$this->PurPayment->recursive = 0;
		$this->set('purPayments', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->PurPayment->id = $id;
		if (!$this->PurPayment->exists()) {
			throw new NotFoundException(__('Invalid %s', __('pur payment')));
		}
		$this->set('purPayment', $this->PurPayment->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PurPayment->create();
			if ($this->PurPayment->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('pur payment')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('pur payment')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		$purPurchases = $this->PurPayment->PurPurchase->find('list');
		$purPaymentTypes = $this->PurPayment->PurPaymentType->find('list');
		$this->set(compact('purPurchases', 'purPaymentTypes'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->PurPayment->id = $id;
		if (!$this->PurPayment->exists()) {
			throw new NotFoundException(__('Invalid %s', __('pur payment')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PurPayment->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('pur payment')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('pur payment')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->PurPayment->read(null, $id);
		}
		$purPurchases = $this->PurPayment->PurPurchase->find('list');
		$purPaymentTypes = $this->PurPayment->PurPaymentType->find('list');
		$this->set(compact('purPurchases', 'purPaymentTypes'));
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
		$this->PurPayment->id = $id;
		if (!$this->PurPayment->exists()) {
			throw new NotFoundException(__('Invalid %s', __('pur payment')));
		}
		if ($this->PurPayment->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('pur payment')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('pur payment')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
