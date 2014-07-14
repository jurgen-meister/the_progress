<?php
App::uses('AppController', 'Controller');
/**
 * AdmModules Controller
 *
 * @property AdmModule $AdmModule
 */
class AdmModulesController extends AppController {

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
		$this->AdmModule->recursive = 0;
		$this->set('admModules', $this->paginate());
	}

	


/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->AdmModule->create();
			$this->request->data['AdmModule']['initials'] = strtolower($this->request->data['AdmModule']['initials']);
			if ($this->AdmModule->save($this->request->data)) {
				$this->Session->setFlash(
					__('Módulo creado con exito!', __('adm module')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('No se pudo crear!', __('adm module')),
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
		$this->AdmModule->id = $id;
		if (!$this->AdmModule->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm module')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['AdmModule']['initials'] = strtolower($this->request->data['AdmModule']['initials']);
			if ($this->AdmModule->save($this->request->data)) {
				$this->Session->setFlash(
					__('Módulo editado con exito!', __('adm module')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('No se pudo editar!', __('adm module')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->AdmModule->read(null, $id);
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
		$this->AdmModule->id = $id;
		if (!$this->AdmModule->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm module')));
		}
		
		$controllers = $this->AdmModule->AdmController->find('count', array('conditions'=>array('AdmController.adm_module_id'=>$id)));
		
		if($controllers > 0){
			$this->Session->setFlash(
				__('No se puede eliminar porque tiene controladores dependientes'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-error'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		
		if ($this->AdmModule->delete()) {
			$this->Session->setFlash(
				__('Módulo eliminado con exito!', __('adm module')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('No se pudo eliminar!', __('adm module')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
