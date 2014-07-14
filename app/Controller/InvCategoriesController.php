<?php
App::uses('AppController', 'Controller');
/**
 * InvCategories Controller
 *
 * @property InvCategory $InvCategory
 */
class InvCategoriesController extends AppController {

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
//	public $components = array('Session');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->InvCategory->recursive = 0;
		$this->set('invCategories', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->InvCategory->id = $id;
		if (!$this->InvCategory->exists()) {
			throw new NotFoundException(__('Categoria no encontrada'));
		}
		$this->set('invCategory', $this->InvCategory->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->InvCategory->create();
			if ($this->InvCategory->save($this->request->data)) {
				$this->Session->setFlash(
					__('Se guardo correctamente'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('No se pudo guardar, intente de nuevo'),
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
		$this->InvCategory->id = $id;
		if (!$this->InvCategory->exists()) {
			throw new NotFoundException(__('Categoria invalida'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['InvCategory']['lc_transaction']='MODIFY';
			if ($this->InvCategory->save($this->request->data)) {
				$this->Session->setFlash(
					__('Se guardo correctamente'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('No se pudo guardar, intente de nuevo'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->InvCategory->read(null, $id);
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
		$this->InvCategory->id = $id;
		if (!$this->InvCategory->exists()) {
			throw new NotFoundException(__('Categoria invalida'));
		}
		if ($this->InvCategory->delete()) {
			$this->Session->setFlash(
				__('Se elimino la categoria'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('No se pudo eliminar la categoria'),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
