<?php
App::uses('AppController', 'Controller');
/**
 * SalEmployees Controller
 *
 * @property SalEmployee $SalEmployee
 */
class SalEmployeesController extends AppController {

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
		$this->SalEmployee->recursive = 0;
		$this->set('salEmployees', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->SalEmployee->id = $id;
		if (!$this->SalEmployee->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal employee')));
		}
		$this->set('salEmployee', $this->SalEmployee->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//Section where the controls of the page are loaded		
		$salCustomers = $this->SalEmployee->SalCustomer->find('list', array('order' => 'SalCustomer.name'));		
		if(count($salCustomers) == 0)
		{
			$salCustomers[""] = '--- Vacio ---';
		}
		
		$this->set(compact('salCustomers'));		
		
		//Section where information is saved into the database
		if ($this->request->is('post')) {
			$this->SalEmployee->create();
			if ($this->SalEmployee->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('sal employee')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('sal employee')),
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
		$salCustomers = $this->SalEmployee->SalCustomer->find('list', array('order' => 'SalCustomer.name'));		
		if(count($salCustomers) == 0)
		{
			$salCustomers[""] = '--- Vacio ---';
		}
		
		$this->set(compact('salCustomers'));		
		
		//Section where information is saved into the database
		$this->SalEmployee->id = $id;
		if (!$this->SalEmployee->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal employee')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['SalEmployee']['lc_transaction']='MODIFY';
			if ($this->SalEmployee->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('sal employee')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('sal employee')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->SalEmployee->read(null, $id);
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
		$this->SalEmployee->id = $id;
		if (!$this->SalEmployee->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal employee')));
		}
		if ($this->SalEmployee->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('sal employee')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('sal employee')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
