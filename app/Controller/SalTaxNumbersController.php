<?php
App::uses('AppController', 'Controller');
/**
 * SalTaxNumbers Controller
 *
 * @property SalTaxNumber $SalTaxNumber
 */
class SalTaxNumbersController extends AppController {

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
		$this->SalTaxNumber->recursive = 0;
		$this->set('salTaxNumbers', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->SalTaxNumber->id = $id;
		if (!$this->SalTaxNumber->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal tax number')));
		}
		$this->set('salTaxNumber', $this->SalTaxNumber->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//Section where the controls of the page are loaded		
		$salCustomers = $this->SalTaxNumber->SalCustomer->find('list', array('order' => 'SalCustomer.name'));				
		if(count($salCustomers) == 0)
		{
			$salCustomers[""] = '--- Vacio ---';
		}
		
		$this->set(compact('salCustomers'));
		
		//Section where information is saved into the database
		if ($this->request->is('post')) {
			$this->SalTaxNumber->create();
			if ($this->SalTaxNumber->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('sal tax number')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('sal tax number')),
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
		$salCustomers = $this->SalTaxNumber->SalCustomer->find('list', array('order' => 'SalCustomer.name'));				
		if(count($salCustomers) == 0)
		{
			$salCustomers[""] = '--- Vacio ---';
		}
		
		$this->set(compact('salCustomers'));
		
		//Section where information is saved into the database
		$this->SalTaxNumber->id = $id;
		if (!$this->SalTaxNumber->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal tax number')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['SalTaxNumber']['lc_transaction']='MODIFY';
			if ($this->SalTaxNumber->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('sal tax number')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('sal tax number')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->SalTaxNumber->read(null, $id);
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
		$this->SalTaxNumber->id = $id;
		if (!$this->SalTaxNumber->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal tax number')));
		}
		if ($this->SalTaxNumber->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('sal tax number')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('sal tax number')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
