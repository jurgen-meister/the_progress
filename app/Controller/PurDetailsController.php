<?php
App::uses('AppController', 'Controller');
/**
 * PurDetails Controller
 *
 * @property PurDetail $PurDetail
 */
class PurDetailsController extends AppController {

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
		$this->PurDetail->recursive = 0;
		$this->set('purDetails', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->PurDetail->id = $id;
		if (!$this->PurDetail->exists()) {
			throw new NotFoundException(__('Invalid %s', __('pur detail')));
		}
		$this->set('purDetail', $this->PurDetail->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PurDetail->create();
			if ($this->PurDetail->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('pur detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('pur detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		$purPurchases = $this->PurDetail->PurPurchase->find('list');
		$invItems = $this->PurDetail->InvItem->find('list');
		$this->set(compact('purPurchases', 'invItems'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->PurDetail->id = $id;
		if (!$this->PurDetail->exists()) {
			throw new NotFoundException(__('Invalid %s', __('pur detail')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PurDetail->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('pur detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('pur detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->PurDetail->read(null, $id);
		}
		$purPurchases = $this->PurDetail->PurPurchase->find('list');
		$invItems = $this->PurDetail->InvItem->find('list');
		$this->set(compact('purPurchases', 'invItems'));
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
		$this->PurDetail->id = $id;
		if (!$this->PurDetail->exists()) {
			throw new NotFoundException(__('Invalid %s', __('pur detail')));
		}
		if ($this->PurDetail->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('pur detail')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('pur detail')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
