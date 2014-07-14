<?php
App::uses('AppController', 'Controller');
/**
 * InvPriceTypes Controller
 *
 * @property InvPriceType $InvPriceType
 */
class InvPriceTypesController extends AppController {

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
	//public $components = array('Session');
//	public  function isAuthorized($user){
//		return $this->Permission->isAllowed($this->name, $this->action, $this->Session->read('Permission.'.$this->name));
//	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->InvPriceType->recursive = 0;
		$this->set('invPriceTypes', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->InvPriceType->id = $id;
		if (!$this->InvPriceType->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv price type')));
		}
		$this->set('invPriceType', $this->InvPriceType->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->InvPriceType->create();
			if ($this->InvPriceType->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('inv price type')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('inv price type')),
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
		$this->InvPriceType->id = $id;
		if (!$this->InvPriceType->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv price type')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['InvPriceType']['lc_transaction']='MODIFY';
			if ($this->InvPriceType->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('inv price type')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('inv price type')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->InvPriceType->read(null, $id);
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
		$this->InvPriceType->id = $id;
		if (!$this->InvPriceType->exists()) {
			throw new NotFoundException(__('Invalid %s', __('inv price type')));
		}
		if ($this->InvPriceType->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('inv price type')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('inv price type')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
