<?php
App::uses('AppController', 'Controller');
/**
 * InvBrands Controller
 *
 * @property InvBrand $InvBrand
 */
class InvBrandsController extends AppController {

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
//	public $helpers = array('TwitterBootstrap.BootstrapHtml', 'TwitterBootstrap.BootstrapForm', 'TwitterBootstrap.BootstrapPaginator');
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
		$this->InvBrand->recursive = 0;
		$this->set('invBrands', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->InvBrand->id = $id;
		if (!$this->InvBrand->exists()) {
			throw new NotFoundException(__('Marca no encontrada'));
		}
		$this->set('invBrand', $this->InvBrand->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->InvBrand->create();
			if ($this->InvBrand->save($this->request->data)) {
				$this->Session->setFlash(
					__('Se guardo correctamente'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
				//$this->redirect(array('action' => 'edit', $this->InvBrand->id));
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
		$this->InvBrand->id = $id;
		if (!$this->InvBrand->exists()) {
			throw new NotFoundException(__('Marca invalida'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['InvBrand']['lc_transaction']='MODIFY';
			if ($this->InvBrand->save($this->request->data)) {
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
			$this->request->data = $this->InvBrand->read(null, $id);
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
		$this->InvBrand->id = $id;
		if (!$this->InvBrand->exists()) {
			throw new NotFoundException(__('Marca invalida'));
		}
		if ($this->InvBrand->delete()) {
			$this->Session->setFlash(
				__('Se elimino la marca'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('No se pudo eliminar la marca'),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
