<?php
App::uses('AppController', 'Controller');
/**
 * InvPrices Controller
 *
 * @property InvPrice $InvPrice
 */
class InvPricesController extends AppController {

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
		$this->InvPrice->recursive = 0;
		$this->set('invPrices', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->InvPrice->id = $id;
		if (!$this->InvPrice->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv price')));
		}
		$this->set('invPrice', $this->InvPrice->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->InvPrice->create();			
			if ($this->InvPrice->save($this->request->data)) {
				$this->Session->setFlash(
					__('El precio se guardo exitosamente'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('inv price')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		$invItems = $this->InvPrice->InvItem->find('list');
		$invPriceTypes = $this->InvPrice->InvPriceType->find('list');
		$this->set(compact('invItems', 'invPriceTypes'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->InvPrice->id = $id;
		if (!$this->InvPrice->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv price')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['InvPrice']['lc_transaction']='MODIFY';
			if ($this->InvPrice->save($this->request->data)) {
				$this->Session->setFlash(
					__('El precio se guardo exitosamente'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('inv price')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->InvPrice->read(null, $id);
		}
		$invItems = $this->InvPrice->InvItem->find('list');
		$invPriceTypes = $this->InvPrice->InvPriceType->find('list');
		$this->set(compact('invItems', 'invPriceTypes'));
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
		$this->InvPrice->id = $id;
		if (!$this->InvPrice->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv price')));
		}
		if ($this->InvPrice->delete()) {
			$this->Session->setFlash(
				__('Precio eliminado'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('inv price')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
