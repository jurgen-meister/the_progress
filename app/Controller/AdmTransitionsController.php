<?php

App::uses('AppController', 'Controller');

/**
 * AdmTransitions Controller
 *
 * @property AdmTransition $AdmTransition
 */
class AdmTransitionsController extends AppController {

	public function life_cycles() {
//		debug($this->Session->read('Permission.'.$this->name));
		
		//Ajax
		if ($this->RequestHandler->isAjax()) {
			//Data Catch
			$sSearch = $this->request->data['sSearch'];
//			$findType = $this->request->data['findType'];
			$json = array();
//			if($findType == 'Transition'){
			$json['Transitions'] = $this->_fnFindTransitions($sSearch);
//			}elseif($findType == 'State'){
			$json['States'] = $this->_fnFindStates($sSearch);
//			}elseif($findType == 'Transaction'){
			$json['Transactions'] = $this->_fnFindTransactions($sSearch);
//			}
			//Send data
			return new CakeResponse(array('body' => json_encode($json)));  //convert to json format and send
		}
		//On load
		$this->loadModel('AdmController');
		$controllers = $this->AdmController->find('list', array('order' => array('AdmController.name' => 'ASC')));
		foreach ($controllers as $key => $value) {
			$controllers[$key] = Inflector::camelize($value);
		}
//		$controllers = array(0 => 'CONTROLADORES');
//		if (count($controllersClean) > 0) {
//			foreach ($controllersClean as $key => $value) {
//				$controllers[$key] = $value;
//			}
//		}
		$this->set(compact('controllers'));
	}

	private function _fnFindTransitions($sSearch) {
		$controller = 'AdmTransition'; //only replace this variable will help a lot of work for main controller
		//Query/Search
		$searchConditions = array(
			'AdmTransaction.adm_controller_id' => $sSearch
		);
		$this->paginate = array(
			'order' => array($controller . '.adm_transaction_id' => 'asc', 'AdmFinalState.name'=>'ASC'),
			'limit' => 50,
			'fields' => array(
				'AdmTransition.id'
				, 'AdmState.name'
				, 'AdmTransaction.name'
				, 'AdmFinalState.name'
			),
			'conditions' => $searchConditions
		);
		$data = $this->paginate($controller);

		//Data Json Formating
		$json["aaData"] = array();
		$counter = 1;
		foreach ($data as $key => $value) {
			$editButton = '<a href="#" class="btn btn-primary btnEditRow" title="Editar"><i class="icon-pencil icon-white"></i></a> ';
			$deleteButton = '<a href="#" class="btn btn-danger btnDeleteRow" title="Eliminar"><i class="icon-trash icon-white"></i></a> ';
			$json["aaData"][$key][0] = 'tr' . $controller . '-' . $value[$controller]["id"];
			$json["aaData"][$key][1] = $counter;
			$json["aaData"][$key][2] = $value["AdmState"]["name"];
			$json["aaData"][$key][3] = $value["AdmTransaction"]["name"];
			$json["aaData"][$key][4] = $value["AdmFinalState"]["name"];
			$json["aaData"][$key][5] = $editButton . $deleteButton; //must find a another way to create these buttons or not?
//				$json["aaData"][$key]["DT_RowId"] = 'tr'.$controller.'-'.$value[$controller]["id"];
			$counter++;
		}

		return $json;
	}

	private function _fnFindStates($sSearch) {
		$controller = 'AdmState'; //only replace this variable will help a lot of work for main controller
		//Query/Search
		$searchConditions = array(
			'AdmState.adm_controller_id' => $sSearch
		);
		$this->paginate = array(
			'recursive' => -1,
//				'order' => array($controller . '.name' => 'ASC'), //it's not sorting by name ??
			'limit' => 50,
			'fields' => array(
				$controller . '.id'
				, $controller . '.name'
				, $controller . '.description'
			),
			'conditions' => $searchConditions
		);
		$data = $this->paginate($controller);

		//Data Json Formating
		$json["aaData"] = array();
		$counter = 1;
		foreach ($data as $key => $value) {
			$editButton = '<a href="#" class="btn btn-primary btnEditRow" title="Editar"><i class="icon-pencil icon-white"></i></a> ';
			$deleteButton = '<a href="#" class="btn btn-danger btnDeleteRow" title="Eliminar"><i class="icon-trash icon-white"></i></a> ';
			$json["aaData"][$key][0] = 'tr' . $controller . '-' . $value[$controller]["id"];
			$json["aaData"][$key][1] = $counter;
			$json["aaData"][$key][2] = $value[$controller]["name"];
			$json["aaData"][$key][3] = $value[$controller]["description"];
			$json["aaData"][$key][4] = $editButton . $deleteButton; //must find a another way to create these buttons or not?
			$counter++;
		}

		return $json;
	}

	private function _fnFindTransactions($sSearch) {
		$controller = 'AdmTransaction'; //only replace this variable will help a lot of work for main controller
		//Query/Search
		$searchConditions = array(
			'AdmTransaction.adm_controller_id' => $sSearch
		);
		$this->paginate = array(
//				'order' => array($controller . '.name' => 'asc'),
			'limit' => 50,
			'fields' => array(
				$controller . '.id'
				, $controller . '.name'
			),
			'conditions' => $searchConditions
		);
		$data = $this->paginate($controller);

		//Data Json Formating
		$json["aaData"] = array();
		$counter = 1;
		foreach ($data as $key => $value) {
			$editButton = '<a href="#" class="btn btn-primary btnEditRow" title="Editar"><i class="icon-pencil icon-white"></i></a> ';
			$deleteButton = '<a href="#" class="btn btn-danger btnDeleteRow" title="Eliminar"><i class="icon-trash icon-white"></i></a> ';
			$json["aaData"][$key][0] = 'tr' . $controller . '-' . $value[$controller]["id"];
			$json["aaData"][$key][1] = $counter;
			$json["aaData"][$key][2] = $value[$controller]["name"];
			$json["aaData"][$key][3] = $editButton . $deleteButton; //must find a another way to create these buttons or not?
			$counter++;
		}

		return $json;
	}

	public function ajax_modal_save_transition() {
		if ($this->RequestHandler->isAjax()) {
			$id = $this->request->data['id'];
			$controllerId = $this->request->data['controllerId'];
			if ($id > 0) {
				$this->request->data = $this->AdmTransition->read(null, $id);
			}

			$admStates = $this->AdmTransition->AdmState->find('list', array('conditions' => array('AdmState.adm_controller_id' => $controllerId)));
			$admFinalStates = $this->AdmTransition->AdmState->find('list', array('conditions' => array('AdmState.adm_controller_id' => $controllerId)));
			$admTransactions = $this->AdmTransition->AdmTransaction->find('list', array('conditions' => array('AdmTransaction.adm_controller_id' => $controllerId)));
			$this->set(compact('admStates', 'admFinalStates', 'admTransactions'));
		} else {
			$this->redirect($this->Auth->logout()); //only accesible through ajax otherwise logout
		}
	}

	public function ajax_modal_save_state() {
		if ($this->RequestHandler->isAjax()) {
			$id = $this->request->data['id'];
			$controllerId = $this->request->data['controllerId'];
			if ($id > 0) {
				$this->request->data = $this->AdmTransition->AdmState->read(null, $id);
			}
			$this->set('controllerId', $controllerId);
//			$this->set(compact('contollerId')); //this way is not working for ajax modal :S ??
		} else {
			$this->redirect($this->Auth->logout()); //only accesible through ajax otherwise logout
		}
	}

	public function ajax_modal_save_transaction() {
		if ($this->RequestHandler->isAjax()) {
			$id = $this->request->data['id'];
			$controllerId = $this->request->data['controllerId'];
			if ($id > 0) {
				$this->request->data = $this->AdmTransition->AdmTransaction->read(null, $id);
			}
			$this->set('controllerId', $controllerId);
		} else {
			$this->redirect($this->Auth->logout()); //only accesible through ajax otherwise logout
		}
	}

	public function fnAjaxSaveFormState() {
		if ($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
//          Configure::write('debug', 0);//To show a clean error for production, comment it when developing
			$model = 'AdmState';
			$this->loadModel($model);
			if ($this->request->data[$model]['id'] == '') {//if true prepare for insert
				unset($this->request->data[$model]['id']);
				$this->$model->create();
			}
			if (!empty($this->request->data)) {
				try {
					$this->$model->save($this->request->data);
					echo 'success';
				} catch (Exception $e) {
					if ($e->getCode() == 23502) {//Not null violation
						echo 'Un campo obligatorio esta vacio.';
					} elseif ($e->getCode() == 23505) {//Unique violation
						echo 'No puede haber duplicados.';
					} elseif ($e->getCode() == 23503) {//children
						echo 'Error al guardar los dependendientes.';
					} else {
						echo 'Ocurrio un error.'; //None of the above errors
					}
				}
			}
		} else {
			$this->redirect($this->Auth->logout()); //only accesible through ajax otherwise logout
		}
	}

	public function fnAjaxSaveFormTransaction() {
		if ($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
//          Configure::write('debug', 0);//To show a clean error for production, comment it when developing
			$model = 'AdmTransaction';
			$this->loadModel($model);
			if ($this->request->data[$model]['id'] == '') {//if true prepare for insert
				unset($this->request->data[$model]['id']);
				$this->$model->create();
			}
			if (!empty($this->request->data)) {
				try {
					$this->$model->save($this->request->data);
					echo 'success';
				} catch (Exception $e) {
					if ($e->getCode() == 23502) {//Not null violation
						echo 'Un campo obligatorio esta vacio.';
					} elseif ($e->getCode() == 23505) {//Unique violation
						echo 'No puede haber duplicados.';
					} elseif ($e->getCode() == 23503) {//children
						echo 'Error al guardar los dependendientes.';
					} else {
						echo 'Ocurrio un error.'; //None of the above errors
					}
				}
			}
		} else {
			$this->redirect($this->Auth->logout()); //only accesible through ajax otherwise logout
		}
	}

	public function fnAjaxSaveFormTransition() {
		if ($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
//          Configure::write('debug', 0);//To show a clean error for production, comment it when developing
			$model = 'AdmTransition';
			if ($this->request->data[$model]['id'] == '') {//if true prepare for insert
				unset($this->request->data[$model]['id']);
				$this->$model->create();
			}
			if (!empty($this->request->data)) {
				try {
					$this->$model->save($this->request->data);
					echo 'success';
				} catch (Exception $e) {
					if ($e->getCode() == 23502) {//Not null violation
						echo 'Un campo obligatorio esta vacio.';
					} elseif ($e->getCode() == 23505) {//Unique violation
						echo 'No puede haber duplicados.';
					} elseif ($e->getCode() == 23503) {//children
						echo 'Error al guardar los dependendientes.';
					} else {
						echo 'Ocurrio un error.'; //None of the above errors
					}
				}
			}
		} else {
			$this->redirect($this->Auth->logout()); //only accesible through ajax otherwise logout
		}
	}

	public function fnAjaxDeleteRowTransition() {
		if ($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
			$model = 'AdmTransition';
			$id = $this->request->data['id'];
			$this->$model->id = $id;
			try {
				$this->$model->delete();
				echo 'success';
			} catch (Exception $e) {
				if ($e->getCode() == 23503) {//children
					echo 'Porque tiene dependendientes.';
				} else {
					echo 'Ocurrio un error.'; //None of the above errors
				}
			}
		} else {
			$this->redirect($this->Auth->logout()); //only accesible through ajax otherwise logout
		}
	}
	
	public function fnAjaxDeleteRowState() {
		if ($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
			$model = 'AdmState';
			$this->loadModel($model);
			$id = $this->request->data['id'];
			$this->$model->id = $id;
			try {
				$this->$model->delete();
				echo 'success';
			} catch (Exception $e) {
				if ($e->getCode() == 23503) {//children
					echo 'Porque tiene dependendientes.';
				} else {
					echo 'Ocurrio un error.'; //None of the above errors
				}
			}
		} else {
			$this->redirect($this->Auth->logout()); //only accesible through ajax otherwise logout
		}
	}
	
	public function fnAjaxDeleteRowTransaction() {
		if ($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
			$model = 'AdmTransaction';
			$this->loadModel($model);
			$id = $this->request->data['id'];
			$this->$model->id = $id;
			try {
				$this->$model->delete();
				echo 'success';
			} catch (Exception $e) {
				if ($e->getCode() == 23503) {//children
					echo 'Porque tiene dependendientes.';
				} else {
					echo 'Ocurrio un error.'; //None of the above errors
				}
			}
		} else {
			$this->redirect($this->Auth->logout()); //only accesible through ajax otherwise logout
		}
	}
	
	

}
