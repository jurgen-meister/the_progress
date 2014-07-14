<?php
App::uses('AppController', 'Controller');
/**
 * InvWarehouses Controller
 *
 * @property InvWarehouse $InvWarehouse
 */
class InvWarehousesController extends AppController {

/**
 *  Layout
 *
 * @var string
 */
//	public $layout = 'bootstrap';

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
		$this->InvWarehouse->recursive = 0;
		$this->set('invWarehouses', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->InvWarehouse->id = $id;
		if (!$this->InvWarehouse->exists()) {
			throw new NotFoundException(__('Almacen no encontrado'));
		}
		$this->set('invWarehouse', $this->InvWarehouse->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->InvWarehouse->create();
			if ($this->InvWarehouse->save($this->request->data)) {
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
		$this->InvWarehouse->id = $id;
		if (!$this->InvWarehouse->exists()) {
			throw new NotFoundException(__('Almacen invalido'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['InvWarehouse']['lc_transaction']='MODIFY';
			if ($this->InvWarehouse->save($this->request->data)) {
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
                    $this->InvWarehouse->recursive = -1; //to avoid joins with PurDetails and SalSales
                    $this->request->data = $this->InvWarehouse->read(null, $id);
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
		$this->InvWarehouse->id = $id;
		if (!$this->InvWarehouse->exists()) {
			throw new NotFoundException(__('Almacen invalido'));
		}
		if ($this->InvWarehouse->delete()) {
			$this->Session->setFlash(
				__('Se elimino el almacen'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('No se pudo eliminar el almacen'),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
