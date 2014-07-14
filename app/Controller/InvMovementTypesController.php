<?php
App::uses('AppController', 'Controller');
/**
 * InvMovementTypes Controller
 *
 * @property InvMovementType $InvMovementType
 */
class InvMovementTypesController extends AppController {

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
		
	$this->paginate = array(
     //'order' => array('InvMovementType.id DESC'),
	 'conditions'=>array('NOT'=>array('InvMovementType.id' => array(1,2,3,4))),
     'limit' => 10
	);
		
		$this->InvMovementType->recursive = 0;
		$this->set('invMovementTypes', $this->paginate('InvMovementType'));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->InvMovementType->id = $id;
		if (!$this->InvMovementType->exists()) {
			throw new NotFoundException(__('Tipo de movimiento invalido'));
		}
		$this->set('invMovementType', $this->InvMovementType->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->InvMovementType->create();
			//debug($this->request->data);
			$this->request->data['InvMovementType']['document'] = 0;
			if ($this->InvMovementType->save($this->request->data)) {
				$this->Session->setFlash(
					__('Se guardo con exito'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('No se puedo guardar, intentelo de nuevo'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		
		$statuses = array("entrada"=>"entrada","salida"=>"salida");
		//$documents = array(1=>"Si",0=>"No");
		//$this->set(compact("statuses", "documents"));
		$this->set(compact("statuses"));
		
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->InvMovementType->id = $id;
		if (!$this->InvMovementType->exists()) {
			throw new NotFoundException(__('Tipo de movimiento invalido'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['InvMovementType']['lc_transaction']='MODIFY';
			if ($this->InvMovementType->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('inv movement type')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('No se puedo guardar intentelo de nuevo'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->InvMovementType->read(null, $id);
			$statuses = array("entrada"=>"entrada","salida"=>"salida");
			$documents = array(1=>"Si",0=>"No");
			$this->set(compact("statuses", "documents"));
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
		$this->InvMovementType->id = $id;
		if (!$this->InvMovementType->exists()) {
			throw new NotFoundException(__('Tipo de movimiento invalido'));
		}
		if ($this->InvMovementType->delete()) {
			$this->Session->setFlash(
				__('Se elimino correctamente'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('El tipo de movimiento no se elimino'),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
