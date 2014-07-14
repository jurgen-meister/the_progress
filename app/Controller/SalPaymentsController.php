<?php
App::uses('AppController', 'Controller');
/**
 * SalPayments Controller
 *
 * @property SalPayment $SalPayment
 */
class SalPaymentsController extends AppController {

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
		$this->SalPayment->recursive = 0;
		$this->set('salPayments', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->SalPayment->id = $id;
		if (!$this->SalPayment->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal payment')));
		}
		$this->set('salPayment', $this->SalPayment->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//Section where the controls of the page are loaded		
		$salPaymentTypes = $this->SalPayment->SalPaymentType->find('list', array('order' => 'SalPaymentType.name'));		
		$salSales = $this->SalPayment->SalSale->find('list');
		if(count($salPaymentTypes) == 0)
		{
			$salPaymentTypes[""] = '--- Vacio ---';
		}
		if(count($salSales) == 0)
		{
			$salSales[""] = '--- Vacio ---';
		}
		
		$this->set(compact('salPaymentTypes', 'salSales'));
		
		//Section where information is saved into the database
		if ($this->request->is('post')) {
			$this->SalPayment->create();
			if ($this->SalPayment->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('sal payment')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('sal payment')),
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
		//Section where the controls of the page are loaded		
		$salPaymentTypes = $this->SalPayment->SalPaymentType->find('list', array('order' => 'SalPaymentType.name'));		
		$salSales = $this->SalPayment->SalSale->find('list');
		if(count($salPaymentTypes) == 0)
		{
			$salPaymentTypes[""] = '--- Vacio ---';
		}
		if(count($salSales) == 0)
		{
			$salSales[""] = '--- Vacio ---';
		}
		
		$this->set(compact('salPaymentTypes', 'salSales'));
		
		//Section where information is saved into the database
		$this->SalPayment->id = $id;
		if (!$this->SalPayment->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal payment')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['SalPayment']['lc_transaction']='MODIFY';
			if ($this->SalPayment->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('sal payment')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('sal payment')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->SalPayment->read(null, $id);
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
		$this->SalPayment->id = $id;
		if (!$this->SalPayment->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal payment')));
		}
		if ($this->SalPayment->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('sal payment')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('sal payment')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
