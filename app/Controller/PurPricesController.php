<?php
App::uses('AppController', 'Controller');
/**
 * PurPrices Controller
 *
 * @property PurPrice $PurPrice
 */
class PurPricesController extends AppController {

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
		$this->PurPrice->recursive = 0;
		$this->set('purPrices', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->PurPrice->id = $id;
		if (!$this->PurPrice->exists()) {
			throw new NotFoundException(__('Invalid %s', __('pur price')));
		}
		$this->set('purPrice', $this->PurPrice->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PurPrice->create();
			if ($this->PurPrice->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('pur price')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('pur price')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		$invPriceTypes = $this->PurPrice->InvPriceType->find('list');
		$purPurchases = $this->PurPrice->PurPurchase->find('list');
		$this->set(compact('invPriceTypes', 'purPurchases'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->PurPrice->id = $id;
		if (!$this->PurPrice->exists()) {
			throw new NotFoundException(__('Invalid %s', __('pur price')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PurPrice->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('pur price')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('pur price')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->PurPrice->read(null, $id);
		}
		$invPriceTypes = $this->PurPrice->InvPriceType->find('list');
		$purPurchases = $this->PurPrice->PurPurchase->find('list');
		$this->set(compact('invPriceTypes', 'purPurchases'));
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
		$this->PurPrice->id = $id;
		if (!$this->PurPrice->exists()) {
			throw new NotFoundException(__('Invalid %s', __('pur price')));
		}
		if ($this->PurPrice->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('pur price')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('pur price')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
