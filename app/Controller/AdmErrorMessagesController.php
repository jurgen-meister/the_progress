<?php
App::uses('AppController', 'Controller');
/**
 * AdmErrorMessages Controller
 *
 * @property AdmErrorMessage $AdmErrorMessage
 */
class AdmErrorMessagesController extends AppController {

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
		$this->AdmErrorMessage->recursive = 0;
		$this->set('admErrorMessages', $this->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//Section where the controls of the page are loaded
		$admModules = $this->AdmErrorMessage->AdmModule->find('list');
		if(count($admModules) != 0)
		{
			
		}
		else
		{
			$admModules[""] = "--- Vacio ---";
		}
		$this->set(compact('admModules'));
		//Section where information is saved into the database
		if ($this->request->is('post')) {
			$this->AdmErrorMessage->create();
			if ($this->AdmErrorMessage->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('adm error message')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('adm error message')),
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
		$this->AdmErrorMessage->id = $id;
		if (!$this->AdmErrorMessage->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm error message')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['AdmErrorMessage']['lc_transaction']='MODIFY';
			if ($this->AdmErrorMessage->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('adm error message')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('adm error message')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->AdmErrorMessage->read(null, $id);
		}
		//Section where the controls of the page are loaded	
		$admModules = $this->AdmErrorMessage->AdmModule->find('list');
		if(count($admModules) != 0)
		{
			
		}
		else
		{
			$admModules[""] = "-- Vacio ---";
		}
		$this->set(compact('admModules'));
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
		$this->AdmErrorMessage->id = $id;
		if (!$this->AdmErrorMessage->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm error message')));
		}
		if ($this->AdmErrorMessage->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('adm error message')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('adm error message')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
