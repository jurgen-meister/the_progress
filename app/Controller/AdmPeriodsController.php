<?php
App::uses('AppController', 'Controller');
/**
 * AdmPeriods Controller
 *
 * @property AdmPeriod $AdmPeriod
 */
class AdmPeriodsController extends AppController {

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
		$this->AdmPeriod->recursive = 0;
		$this->set('admPeriods', $this->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->AdmPeriod->create();
			if ($this->AdmPeriod->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('adm period')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('adm period')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		$lastPeriod = $this->AdmPeriod->find('first', array(
			'order'=>array('AdmPeriod.id'=>'desc'),
			'fields'=>array('AdmPeriod.name')
		));
		$this->set('newPeriod', $lastPeriod['AdmPeriod']['name'] + 1);
		
		
		//$lastPeriod = $newPeriod - 1;
		//$this->_generate_new_period_data(2014, 2015);
	}

	public function ajax_add_period(){
		if($this->RequestHandler->isAjax()){
			$newPeriod = $this->request->data['period'];
			$lastPeriod = $newPeriod - 1;
			$creator = $this->Session->read('UserRestriction.id');

			if($this->AdmPeriod->saveNewPeriod($lastPeriod, $newPeriod, $creator)){//My own transac function, is in the model
				echo 'success|'.($newPeriod+1);
			}else{
				echo 'error';
			}

		}
	}

//END CONTROLLER
}
