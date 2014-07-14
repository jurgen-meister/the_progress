<?php
App::uses('AppController', 'Controller');
/**
 * AdmParameterDetails Controller
 *
 * @property AdmParameterDetail $AdmParameterDetail
 */
class AdmParameterDetailsController extends AppController {

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
	

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->AdmParameterDetail->recursive = 0;
		$this->set('admParameterDetails', $this->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//Section where the controls of the page are loaded	
		$admParameters = $this->AdmParameterDetail->AdmParameter->find('list');
		if(count($admParameters != 0))
		{
			
		}
		else
		{
			$admParameters[""] = "--- Vacio ---";
		}
		$this->set(compact('admParameters'));
		//Section where information is saved into the database
		if ($this->request->is('post')) {
			$this->AdmParameterDetail->create();
			if ($this->AdmParameterDetail->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('adm parameter detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('adm parameter detail')),
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
		$this->AdmParameterDetail->id = $id;
		if (!$this->AdmParameterDetail->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm parameter detail')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['AdmParameterDetail']['lc_transaction']='MODIFY';
			if ($this->AdmParameterDetail->save($this->request->data)) {				
				$this->Session->setFlash(
					__('The %s has been saved', __('adm parameter detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('adm parameter detail')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->AdmParameterDetail->read(null, $id);
		}
//		
		
		//Section where the controls of the page are loaded	
		$admParameters = $this->AdmParameterDetail->AdmParameter->find('list');
		if(count($admParameters != 0))
		{
			
		}
		else
		{
			$admParameters[""] = "--- Vacio ---";
		}
		$this->set(compact('admParameters'));		
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
		$this->AdmParameterDetail->id = $id;
		if (!$this->AdmParameterDetail->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm parameter detail')));
		}
		if ($this->AdmParameterDetail->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('adm parameter detail')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('adm parameter detail')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
