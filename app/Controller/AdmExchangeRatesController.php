<?php
App::uses('AppController', 'Controller');
/**
 * AdmExchangeRates Controller
 *
 * @property AdmExchangeRate $AdmExchangeRate
 */
class AdmExchangeRatesController extends AppController {

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
		$this->AdmExchangeRate->recursive = 0;
		$this->paginate = array(
			'order' => array('AdmExchangeRate.date' => 'asc', 'AdmExchangeRate.id'=>'desc'),
		);
		$this->set('admExchangeRates', $this->paginate("AdmExchangeRate"));
	}


/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->loadModel('AdmParameterDetail');
		$this->loadModel('AdmParameter');
		$admParameterDetails = $this->AdmParameter->AdmParameterDetail->find('all',array(			
			'order' => 'AdmParameterDetail.id',
			//'contain' => array('AdmParameter' => array('conditions' => array('AdmParameter.name' => 'Lugar Expedicion'))),
			'conditions' => array('AdmParameter.name' => 'Moneda'),
			'fields' => array('AdmParameterDetail.id', 'AdmParameterDetail.par_char1')
		));
		
		if(count($admParameterDetails) != 0)
		{
			
		}
		else
		{
			$admParameterDetails[""] = "--- Vacio ---";
		}
		$this->set(compact('admParameterDetails'));
		if ($this->request->is('post')) {
			$this->AdmExchangeRate->create();
			if ($this->AdmExchangeRate->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('adm exchange rate')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('adm exchange rate')),
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
		$this->AdmExchangeRate->id = $id;
		if (!$this->AdmExchangeRate->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm exchange rate')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->AdmExchangeRate->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('adm exchange rate')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('adm exchange rate')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->AdmExchangeRate->read(null, $id);
			$this->request->data["AdmExchangeRate"]["date"] = date("d/m/Y", strtotime($this->request->data["AdmExchangeRate"]["date"]));
			//debug($this->request->data);
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
		$this->AdmExchangeRate->id = $id;
		if (!$this->AdmExchangeRate->exists()) {
			throw new NotFoundException(__('Invalid %s', __('adm exchange rate')));
		}
		if ($this->AdmExchangeRate->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('adm exchange rate')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('adm exchange rate')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
