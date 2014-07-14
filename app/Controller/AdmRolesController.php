<?php
App::uses('AppController', 'Controller');
/**
 * AdmRoles Controller
 *
 * @property AdmRole $AdmRole
 */
class AdmRolesController extends AppController {

/**
 *  Layout
 *
 * @var string
 */
//	public $layout = 'default';

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
	/*
	public  function isAuthorized($user){
		return $this->Permission->isAllowed($this->name, $this->action, $this->Session->read('Permission.'.$this->name));
	}
	*/
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->AdmRole->recursive = 0;
		$filter = array('AdmRole.id !='=>1);
		if($this->Session->read('Role.id') == 1){
			$filter = null;
		}
		$this->paginate = array(
			'order'=>array('AdmRole.id'=>'ASC'),
			'conditions'=>$filter
		);
		$this->set('admRoles', $this->paginate());
	}


/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->AdmRole->create();
			$this->request->data['AdmRole']['name'] = strtoupper($this->request->data['AdmRole']['name']);
			if ($this->AdmRole->save($this->request->data)) {
				$this->Session->setFlash(
					__('Rol guardado con exito!', __('')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('No se pudo guardar.', __('adm role')),
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
		$this->AdmRole->id = $id;
		if (!$this->AdmRole->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm role')));
		}
		if($this->Session->read('Role.id') <> 1 AND $id = 1){
			$this->redirect(array('action' => 'index'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['AdmRole']['name'] = strtoupper($this->request->data['AdmRole']['name']);
			if ($this->AdmRole->save($this->request->data)) {
				$this->Session->setFlash(
					__('Cambios guardados', __('adm role')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('No se pudo guardar.', __('adm role')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->AdmRole->read(null, $id);
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
		if($this->Session->read('Role.id') <> 1 AND $id = 1){
			$this->redirect(array('action' => 'index'));
		}
		$this->AdmRole->id = $id;
		if (!$this->AdmRole->exists()) {
			throw new NotFoundException(__('%s invalido', __('Rol')));
		}
		
		try{
			$this->AdmRole->delete();
			$this->Session->setFlash(
				__('Eliminado con exito', __('adm role')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}catch(Exception $e){
			if($e->getCode() == 23503){
				$msge = 'No se puede eliminar este Rol porque tiene dependientes (acciones, menus o restricciones de usuario)';
			}else{
				$msge = 'Ocurrio un problema vuelva a intentarlo';
			}
			$this->Session->setFlash(
			$msge,
			'alert',
			array('plugin' => 'TwitterBootstrap','class' => 'alert-error')
			);
			$this->redirect(array('action' => 'index'));
		}
	}
		
//END CLASS
}
