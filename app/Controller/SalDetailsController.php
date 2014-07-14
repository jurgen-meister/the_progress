<?php
App::uses('AppController', 'Controller');
/**
 * SalDetails Controller
 *
 * @property SalDetail $SalDetail
 */
class SalDetailsController extends AppController {

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
		$this->SalDetail->recursive = 0;
		$this->set('salDetails', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->SalDetail->id = $id;
		if (!$this->SalDetail->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal detail')));
		}
		$this->set('salDetail', $this->SalDetail->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SalDetail->create();
			if ($this->SalDetail->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('sal detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('sal detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		$salSales = $this->SalDetail->SalSale->find('list');
		$invItems = $this->SalDetail->InvItem->find('list');
		$this->set(compact('salSales', 'invItems'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->SalDetail->id = $id;
		if (!$this->SalDetail->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal detail')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SalDetail->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('sal detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('sal detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->SalDetail->read(null, $id);
		}
		$salSales = $this->SalDetail->SalSale->find('list');
		$invItems = $this->SalDetail->InvItem->find('list');
		$this->set(compact('salSales', 'invItems'));
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
		$this->SalDetail->id = $id;
		if (!$this->SalDetail->exists()) {
			throw new NotFoundException(__('Invalid %s', __('sal detail')));
		}
		if ($this->SalDetail->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('sal detail')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('sal detail')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
