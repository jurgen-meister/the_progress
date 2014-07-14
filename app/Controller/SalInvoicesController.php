<?php
App::uses('AppController', 'Controller');
/**
 * SalInvoices Controller
 *
 * @property SalInvoice $SalInvoice
 */
class SalInvoicesController extends AppController {

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
		$this->SalInvoice->recursive = 0;
		$this->set('salInvoices', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->SalInvoice->id = $id;
		if (!$this->SalInvoice->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal invoice')));
		}
		$this->set('salInvoice', $this->SalInvoice->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SalInvoice->create();
			if ($this->SalInvoice->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('sal invoice')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('sal invoice')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		$salSales = $this->SalInvoice->SalSale->find('list');
		$this->set(compact('salSales'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->SalInvoice->id = $id;
		if (!$this->SalInvoice->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal invoice')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SalInvoice->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('sal invoice')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('sal invoice')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->SalInvoice->read(null, $id);
		}
		$salSales = $this->SalInvoice->SalSale->find('list');
		$this->set(compact('salSales'));
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
		$this->SalInvoice->id = $id;
		if (!$this->SalInvoice->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal invoice')));
		}
		if ($this->SalInvoice->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('sal invoice')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('sal invoice')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
