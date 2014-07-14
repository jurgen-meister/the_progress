<?php

/**
 * Description of BittionMainComponent: Generic function that could be used in every controller
 *
 * @author rey
 */
class BittionMainComponent extends Component {

	public function connectDatabaseDynamically($login = null, $password = null) {
		App::uses('ConnectionManager', 'Model');
		//the key to avoid initial user_login config, it will avoid double load to get the dynamic config.
		
//		ConnectionManager::getDataSource('default')->close();
		
		try{//sucess
			ConnectionManager::drop('default');
//			return true;
		}catch(Exception $e){//fail
//			debug($e);
			return false;
		}
		//if it's not declared it will initiate a loop to always have the intial login and password parameters wich have logged in succesfully
		if($login == null && $password == null){
			$dataSource = ConnectionManager::getDataSource('default');//get database object with parameters
			$login = $dataSource->config['login'];
			$password = $dataSource->config['password'];
		}
		
		$config = array(
			'datasource' => 'Database/Postgres',
			'persistent' => false,
			'host' => 'localhost',
			'login' => $login,
			'password' => $password,
			'database' => 'imexport',
			'prefix' => '',
			'schema' => 'public'
			//'encoding' => 'utf8',
		);
		try{//sucess
			ConnectionManager::create('default', $config);
			return true;
		}catch(Exception $e){//fail
//			debug($e);
			return false;
		}
		
	}

	
}

?>
