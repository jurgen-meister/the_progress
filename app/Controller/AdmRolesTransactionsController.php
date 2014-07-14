<?php

App::uses('AppController', 'Controller');

/**
 * AdmRolesTransactions Controller
 *
 * @property AdmRolesTransaction $AdmRolesTransaction
 */
class AdmRolesTransactionsController extends AppController {

	/**
	 *  Layout
	 *
	 * @var string
	 */
	public $layout = 'default';

	public function ajax_save() {
		if ($this->RequestHandler->isAjax()) {
			////////////////INICIO/////////////////
			$role = $this->request->data['role'];
			$module = $this->request->data['module'];
			//Captura los valores nuevos enviados por el checkbox
			if (isset($this->request->data['transaction'])) {//Soluciona problema "Undefined index: action", porque la accion post no esta definida cuando el vector esta vacio
				$transaction = $this->request->data['transaction'];
			} else {
				$transaction = array();
			}

			//Buscar los valor antiguos guardados, uso unbind y bind para que todo salga en un solo query
			$this->AdmRolesTransaction->unbindModel(array('belongsTo' => array('AdmTransaction', 'AdmRole')));
			$this->AdmRolesTransaction->bindModel(array(
				'belongsTo' => array(
					'AdmTransaction' => array(
						'foreignKey' => false,
						'conditions' => array('AdmRolesTransaction.adm_transaction_id = AdmTransaction.id')
					),
					'AdmController' => array(
						'foreignKey' => false,
						'conditions' => array('AdmTransaction.adm_controller_id = AdmController.id', '')
					)
				)
			));
			$catchOld = $this->AdmRolesTransaction->find('all', array(
				'conditions' => array('AdmRolesTransaction.adm_role_id' => $role, 'AdmController.adm_module_id' => $module),
				'fields' => array('id', 'adm_role_id', 'AdmController.id', 'AdmController.name', 'AdmTransaction.id', 'AdmTransaction.name')));
			$old = array();
			for ($i = 0; $i < count($catchOld); $i++) {
				$old[$i] = (string) $catchOld[$i]['AdmTransaction']['id'];
			}

			//Compare New and Old values
			if (count($transaction) == 0 AND count($old) == 0) {
				echo 'successEmpty'; // when there is no new or old values to save
			} else {
				$new = $transaction;

				$insert = array_diff($new, $old);
				//echo "<br>insert";
				//debug($insert);
				$delete = array_diff($old, $new);
				//echo "delete";
				//debug($delete);
				//Aqui se elimina los antiguos valores
				if ($this->AdmRolesTransaction->saveTransactions($role, $insert, $delete)) {
					echo 'success'; // envia al data del js de jquery
				} else {
					echo 'error';
				}
			}
			////////////////FIN/////////////////
		} else {
			$this->redirect($this->Auth->logout());
		}
	}

	public function ajax_list_transactions() {
		if ($this->RequestHandler->isAjax()) {

			$role = $this->request->data['role'];
			$module = $this->request->data['module'];

			$chkTree = $this->_fnCreateCheckboxTree($role, $module);
			///////////////////////***************************************//////////////////
			$this->set('data', $chkTree['data']);
			$this->set('allChecked', $chkTree['allChecked']);
		} else {
			$this->redirect($this->Auth->logout());
		}
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function save() {
		$admRoles = $this->AdmRolesTransaction->AdmRole->find('list', array('order' => array('AdmRole.id' => 'ASC')));
		$this->loadModel("AdmModule");
		$admModules = $this->AdmModule->find('list');
		$this->set(compact('admRoles', 'admModules'));
	}

	private function _fnCreateCheckboxTree($role, $module) {
		//PART 1
		$transactions = $this->AdmRolesTransaction->AdmTransaction->find('all', array(
			'fields' => array('AdmTransaction.id', 'AdmTransaction.name', 'AdmController.id', 'AdmController.name'),
//			'order' => array()
			'conditions' => array('AdmController.adm_module_id' => $module)
		));
		//debug($transactions);

		$this->loadModel("AdmController");
		$controllers = $this->AdmController->find("list", array("conditions" => array('AdmController.adm_module_id' => $module)));
		//debug($controllers);
		$data = array();
		$transactionClean = array();
		//debug($transactions);
		foreach ($transactions as $keyAction => $transaction) {
			$transactionClean[$keyAction] = $transaction["AdmTransaction"]["id"];
		}
		$checked = $this->AdmRolesTransaction->find("list", array(
			"fields" => array("id", "adm_transaction_id"),
			"conditions" => array("adm_transaction_id" => $transactionClean, "adm_role_id" => $role)
		));

		foreach ($transactions as $keyAction => $transaction) {
			foreach ($controllers as $keyController => $controller) {
				if ($transaction["AdmController"]["id"] == $keyController) {
					$transactionId = $transaction["AdmTransaction"]["id"];
					$data[$keyController]["controllerName"] = Inflector::camelize($controller);
					$data[$keyController]["controllerId"] = $keyController;
					$data[$keyController]["transactions"][$transactionId]["transactionId"] = $transactionId;
					$data[$keyController]["transactions"][$transactionId]["transactionName"] = $transaction["AdmTransaction"]["name"];
					$data[$keyController]["transactions"][$transactionId]["transactionChecked"] = $this->_fnCreateCheckTransaction($checked, $transactionId);
				}
			}
		}
		$allChecked = '';
		foreach ($data as $key => $value) {
			$checked = $this->_fnCreateCheckController($value['transactions']);
			$data[$key]["controllerChecked"] = $checked;
			if ($checked <> '') {
				$allChecked = 'checked = "checked"';
			}
		}
		return array('data' => $data, 'allChecked' => $allChecked);
	}

	private function _fnCreateCheckTransaction($checked, $transactionId) {
		$str = '';
		if (count($checked) > 0) {
			foreach ($checked as $value) {
				if ($value == $transactionId) {
					$str = 'checked = "checked"';
//					return true;
				}
			}
		}
//		return false;
		return $str;
	}

	private function _fnCreateCheckController($array) {
		if (count($array) > 0) {
			foreach ($array as $key => $value) {
				if ($value['transactionChecked'] <> '') {
					return $value['transactionChecked'];
				}
			}
		}
		return '';
	}

//END CLASS	
}
