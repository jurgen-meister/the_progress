<?php

App::uses('AppController', 'Controller');

/**
 * InvMovements Controller
 *
 * @property InvMovement $InvMovement
 */
class InvMovementsController extends AppController {

    //*******************************************************************************************************//
    ///////////////////////////////////////// START - FUNCTIONS ///////////////////////////////////////////////
    //*******************************************************************************************************//
    //////////////////////////////////////////// START - PDF ///////////////////////////////////////////////
    public function view_document_movement_pdf($id = null) {

        $this->InvMovement->id = $id;

        if (!$this->InvMovement->exists()) {
            throw new NotFoundException(__('Invalid post'));
        }
        // increase memory limit in PHP 
        ini_set('memory_limit', '512M');
        $movement = $this->InvMovement->read(null, $id);

        if ($movement['InvMovement']['inv_movement_type_id'] == 4) {
            $this->redirect(array('action' => 'index_warehouses_transfer'));
        }

        if ($movement['InvMovement']['inv_movement_type_id'] == 3) {

            $movementIdOut = $this->InvMovement->find('all', array(
                'conditions' => array(
                    'InvMovement.document_code' => $movement['InvMovement']['document_code'],
                    'InvMovement.inv_movement_type_id =' => 4
            ))); //Out Origin
            $movement['Transfer']['code'] = $movementIdOut[0]['InvMovement']['code'];
            $movement['Transfer']['warehouseName'] = $movementIdOut[0]['InvWarehouse']['name'];
        }


        $details = $this->_get_movements_details_without_stock($id);
        $this->set('movement', $movement);
        $this->set('details', $details);
    }

    //////////////////////////////////////////// END - PDF /////////////////////////////////////////////////
    //////////////////////////////////////////// START - REPORT ////////////////////////////////////////////////
    public function vreport_generator() {
        $this->loadModel("InvWarehouse");


        $warehouseClean = $this->InvWarehouse->find('list');
        //Comment this because in this case I want to show option Todos at the end
        $warehouse[0] = "TODOS";
        foreach ($warehouseClean as $key => $value) {
            $warehouse[$key] = $value;
        }

        //$warehouse = $warehouseClean;
        //$warehouse[0] = "TODOS";
        $item = $this->_find_items();
        $this->set(compact("warehouse", "item", "warehouseClean"));
    }

    private function _find_items($type = 'none', $selected = array()) {
        $conditions = array();
        $order = array('InvItem.code');

        switch ($type) {
            case 'category':
                $conditions = array('InvItem.inv_category_id' => $selected);
                //$order = array('InvCategory.name');
                break;
            case 'brand':
                $conditions = array('InvItem.inv_brand_id' => $selected);
                //$order = array('InvBrand.name');
                break;
        }

        $this->loadModel("InvItem");
        $this->InvItem->unbindModel(array('hasMany' => array('InvPrice', 'InvCategory', 'InvMovementDetail', 'InvItemsSupplier')));
        return $this->InvItem->find("all", array(
                    "fields" => array('InvItem.code', 'InvItem.name', 'InvCategory.name', 'InvBrand.name', 'InvItem.id'),
                    "conditions" => $conditions,
                    "order" => $order
        ));
    }

    public function ajax_get_group_items_and_filters() {
        if ($this->RequestHandler->isAjax()) {
            $type = $this->request->data['type'];
            $group = array();
            switch ($type) {
                case 'category':
                    $this->loadModel("InvCategory");
                    $group = $this->InvCategory->find("list", array("order" => array("InvCategory.name")));
                    $this->set('group', $group);
                    break;
                case 'brand':
                    $this->loadModel("InvBrand");
                    $group = $this->InvBrand->find("list", array("order" => array("InvBrand.name")));
                    $this->set('group', $group);
                    break;
            }
//			$item = $this->_find_items($type, array_keys($group));
            $item = $this->_find_items($type, array_keys(array()));
            $this->set(compact("item"));
        }
    }

    public function ajax_get_group_items() {
        if ($this->RequestHandler->isAjax()) {
            $type = $this->request->data['type'];
            if (isset($this->request->data['selected'])) {
                $selected = $this->request->data['selected'];
            } else {
                $selected = array();
            }
            $item = $this->_find_items($type, $selected);
            $this->set(compact("item"));
        }
    }

    public function ajax_generate_warehouses_by_location() {
        if ($this->RequestHandler->isAjax()) {
            $location = $this->request->data["location"];
            $warehousesClean = $this->InvMovement->InvWarehouse->find("list", array("conditions" => array("InvWarehouse.location" => $location)));
//            if (count($warehousesClean) > 0) {
            $warehouses[0] = "TODOS";
            foreach ($warehousesClean as $key => $value) {
                $warehouses[$key] = $value;
            }
//            } else {
//                $warehouses[9999] = "VACIO";
//            }
            return new CakeResponse(array('body' => json_encode($warehouses)));  //converts to json format and send it
        } else {
            $this->redirect($this->Auth->logout()); //only accesible through ajax otherwise logout
        }
    }

    public function ajax_generate_report() {
        if ($this->RequestHandler->isAjax()) {
            //SETTING DATA
            $this->Session->write('ReportMovement.startDate', $this->request->data['startDate']);
            $this->Session->write('ReportMovement.finishDate', $this->request->data['finishDate']);
            $this->Session->write('ReportMovement.movementType', $this->request->data['movementType']);
            $this->Session->write('ReportMovement.movementTypeName', $this->request->data['movementTypeName']);
            $this->Session->write('ReportMovement.warehouse', $this->request->data['warehouse']);
            $this->Session->write('ReportMovement.warehouseName', $this->request->data['warehouseName']);
            $this->Session->write('ReportMovement.currency', $this->request->data['currency']);
            $this->Session->write('ReportMovement.detail', $this->request->data['detail']);
            //for transfer
            $this->Session->write('ReportMovement.warehouse2', $this->request->data['warehouse2']);
            $this->Session->write('ReportMovement.warehouseName2', $this->request->data['warehouseName2']);
            //array items
            $this->Session->write('ReportMovement.items', $this->request->data['items']);

            //to send data response to ajax success so it can choose the report view
            echo $this->request->data['movementType'];
            ///END AJAX
        }
    }

    public function vreport_ins_or_outs() {
        $this->_generate_report();
    }

    public function vreport_ins_and_outs() {
        $this->_generate_report();
    }

    public function vreport_transfers() {
        $this->_generate_report();
    }

    private function _generate_report() {
        //special ctp template for printing due DOMPdf colapses generating too many pages
        $this->layout = 'print';

        //Check if session variables are set otherwise redirect
        if (!$this->Session->check('ReportMovement')) {
            $this->redirect(array('action' => 'vreport_generator'));
        }

        //put session data sent data into variables
        $initialData = $this->Session->read('ReportMovement');

        //debug($initialData);
        //////////In case option all warehouses selected and report type = ins and outs
        $kardexWarehouses = array();
        if ($initialData["movementType"] == 1000) {
            if ($initialData["warehouse"] == 0) {
                $this->loadModel("InvWarehouse");
                $kardexWarehouses = $this->InvWarehouse->find("list", array(
                    "order" => array("InvWarehouse.id" => "DESC") //is in the order required for IMEXPORT :\
                ));
            }
        }

        $this->set("kardexWarehouses", $kardexWarehouses);



        $settings = $this->_generate_report_settings($initialData);

        //debug($settings);

        $movements = $this->_generate_report_movements($settings['values'], $settings['conditions'], $settings['fields']);
        //debug($movements);

        $currencyFieldPrefix = '';
        $currencyAbbreviation = '(Bs)';
        if (trim($initialData['currency']) == 'DOLARES') {
            $currencyFieldPrefix = 'ex_';
            $currencyAbbreviation = '($us)';
        }


        $itemsComplete = $this->_generate_report_items_complete($initialData['items'], $initialData['finishDate'], $currencyFieldPrefix);
        //debug($itemsComplete);
        $itemsMovements = $this->_generate_report_items_movements($itemsComplete, $movements, $currencyFieldPrefix);
        //debug($itemsMovements);
        //debug($itemsComplete);
        //debug($movements);

        $initialData['currencyAbbreviation'] = $currencyAbbreviation; //setting currency abbreviation before send
        //$initialData['items']='';//cleaning items ids 'cause won't be needed begore send
        //debug($initialData);
        $this->set('initialData', $initialData);
        $this->set('itemsMovements', $itemsMovements);
        //debug($itemsMovements);
        //debug($settings['initialStocks']);
        $varStocks = $settings['initialStocks'];
        if ($initialData["movementType"] == 1000) {
            if ($initialData["warehouse"] == 0) {
                //for($i=0; $i < count($kardexWarehouses); $i++){
                //$counter = 0;
                //debug($kardexWarehouses);
                //debug($initialData['items']);
                //debug($initialData['startDate']);
                foreach ($kardexWarehouses as $key => $value) {
                    $varStocks[$key] = $this->_get_stocks($initialData['items'], $key, $initialData['startDate'], '<');
                    //debug($varStocks);
                    //$counter++;
                }
            }
        }
        $this->set('initialStocks', $varStocks);
        //debug($varStocks);
        $this->Session->delete('ReportMovement');
        //END FUNCTION	
    }

    private function _generate_report_items_movements($itemsComplete, $movements, $currencyFieldPrefix) {
        //I'll not calculate totals 'cause will be easier in the view and specially cleaner due the variation of calculation in every report
        $auxArray = array();
        foreach ($itemsComplete as $item) {
            $fobQuantityTotal = 0;
            $cifQuantityTotal = 0;
            $saleQuantityTotal = 0;
            $counter = 0;

            $forPricesSubQuery = 0; //before 'InvMovementDetail'
            //movements
            foreach ($movements as $movement) {
                if ($item['InvItem']['id'] == $movement['InvMovementDetail']['inv_item_id']) {
                    $fobQuantity = $movement['InvMovementDetail']['quantity'] * $movement[$forPricesSubQuery][$currencyFieldPrefix . 'fob_price'];
                    $cifQuantity = $movement['InvMovementDetail']['quantity'] * $movement[$forPricesSubQuery][$currencyFieldPrefix . 'cif_price'];
                    $saleQuantity = $movement['InvMovementDetail']['quantity'] * $movement[$forPricesSubQuery][$currencyFieldPrefix . 'sale_price'];
                    $fobQuantityTotal = $fobQuantityTotal + $fobQuantity;
                    $cifQuantityTotal = $cifQuantityTotal + $cifQuantity;
                    $saleQuantityTotal = $saleQuantityTotal + $saleQuantity;
                    $auxArray[$item['InvItem']['id']]['Movements'][$counter] = array(
                        'warehouse' => $movement['InvMovement']['inv_warehouse_id'],
                        'code' => $movement['InvMovement']['code'],
                        'document_code' => $movement['InvMovement']['document_code'],
                        'note_code' => $movement[$forPricesSubQuery]['note_code'],
                        'quantity' => $movement['InvMovementDetail']['quantity'],
                        'date' => date("d/m/Y", strtotime($movement['InvMovement']['date'])),
                        'fob' => $movement[$forPricesSubQuery][$currencyFieldPrefix . 'fob_price'],
                        'cif' => $movement[$forPricesSubQuery][$currencyFieldPrefix . 'cif_price'],
                        'sale' => $movement[$forPricesSubQuery][$currencyFieldPrefix . 'sale_price'],
                        'fobQuantity' => $fobQuantity,
                        'cifQuantity' => $cifQuantity,
                        'saleQuantity' => $saleQuantity,
                        'warehouse' => $movement['InvMovement']['inv_warehouse_id']
                    );
                    if (isset($movement['InvMovementType']['status'])) {
                        $auxArray[$item['InvItem']['id']]['Movements'][$counter]['status'] = $movement['InvMovementType']['status'];
                    }
                    $counter++;
                }
            }
            //Items
//			debug($item['InvItem']['id']);
            $auxArray[$item['InvItem']['id']]['Item']['codeName'] = '[ ' . $item['InvItem']['code'] . ' ] ' . $item['InvItem']['name'];
            $auxArray[$item['InvItem']['id']]['Item']['brand'] = $item['InvBrand']['name'];
            $auxArray[$item['InvItem']['id']]['Item']['category'] = $item['InvCategory']['name'];
            $auxArray[$item['InvItem']['id']]['Item']['id'] = $item['InvItem']['id'];

            //Items last price registered 
            $auxArray[$item['InvItem']['id']] ['Item']['last_fob'] = $item[0]['last_fob'];
            ;
            $auxArray[$item['InvItem']['id']] ['Item']['last_cif'] = $item[0]['last_cif'];
            ;
            $auxArray[$item['InvItem']['id']] ['Item']['last_sale'] = $item[0]['last_sale'];
            ;

            //Totals
            $auxArray[$item['InvItem']['id']]['TotalMovements']['fobQuantityTotal'] = $fobQuantityTotal;
            $auxArray[$item['InvItem']['id']]['TotalMovements']['cifQuantityTotal'] = $cifQuantityTotal;
            $auxArray[$item['InvItem']['id']]['TotalMovements']['saleQuantityTotal'] = $saleQuantityTotal;
            ////I don't calculate total quantity here 'cause could vary in every report, it will be done in the report views
        }
        return $auxArray;
    }

    private function _generate_report_settings($initialData) {
        ///////////////////VALUES, FIELDS, CONDITIONS////////////////////////
        $values = array();
        $conditions = array();
        $fields = array();
        $initialStocks = array();
        //debug($initialData['warehouse']);

        $values['startDate'] = $initialData['startDate'];
        $values['finishDate'] = $initialData['finishDate'];
        $warehouses = array(0 => $initialData['warehouse']);
        //debug($initialData);
        switch ($initialData['movementType']) {
            case 998://TODAS LAS ENTRADAS
                $conditions['InvMovement.inv_movement_type_id'] = array(1, 4, 5, 6);
                break;
            case 999://TODAS LAS SALIDAS
                $conditions['InvMovement.inv_movement_type_id'] = array(2, 3, 7);
                break;
            case 1000://ENTRADAS Y SALIDAS
                $values['bindMovementType'] = 1;
                if ($initialData['warehouse'] > 0) {
                    $initialStocks = $this->_get_stocks($initialData['items'], $initialData['warehouse'], $initialData['startDate'], '<'); //before starDate, 'cause it will be added or substracted with movements quantities
                }
                break;
            case 1001://TRASPASOS ENTRE ALMACENES
                $values['bindMovementType'] = 1;
                $conditions['InvMovement.inv_movement_type_id'] = array(3, 4);
                $warehouses[1] = $initialData['warehouse2'];
                break;
            default:
                $conditions['InvMovement.inv_movement_type_id'] = $initialData['movementType'];
                break;
        }
        //debug($warehouses);
        if ($warehouses[0] > 0) {
            $conditions['InvMovement.inv_warehouse_id'] = $warehouses; //necessary to be here
        }
        $values['items'] = $initialData['items']; //just for order
        switch ($initialData['currency']) {
            case 'BOLIVIANOS':
                //$fields = array('InvMovementDetail.fob_price', 'InvMovementDetail.cif_price', 'InvMovementDetail.sale_price');
                $fields[] = '(SELECT price FROM inv_prices where inv_item_id = "InvMovementDetail"."inv_item_id" AND date <= "InvMovement"."date" AND inv_price_type_id=1 order by date DESC, date_created DESC LIMIT 1) AS "fob_price"';
                $fields[] = '(SELECT price FROM inv_prices where inv_item_id = "InvMovementDetail"."inv_item_id" AND date <= "InvMovement"."date" AND inv_price_type_id=8 order by date DESC, date_created DESC LIMIT 1) AS "cif_price"';
                $fields[] = '(SELECT price FROM inv_prices where inv_item_id = "InvMovementDetail"."inv_item_id" AND date <= "InvMovement"."date" AND inv_price_type_id=9 order by date DESC, date_created DESC LIMIT 1) AS "sale_price"';
                break;
            case 'DOLARES':
                //$fields = array('InvMovementDetail.ex_fob_price', 'InvMovementDetail.ex_cif_price', 'InvMovementDetail.ex_sale_price');
                $fields[] = '(SELECT ex_price FROM inv_prices where inv_item_id = "InvMovementDetail"."inv_item_id" AND date <= "InvMovement"."date" AND inv_price_type_id=1 order by date DESC, date_created DESC LIMIT 1) AS "ex_fob_price"';
                $fields[] = '(SELECT ex_price FROM inv_prices where inv_item_id = "InvMovementDetail"."inv_item_id" AND date <= "InvMovement"."date" AND inv_price_type_id=8 order by date DESC, date_created DESC LIMIT 1) AS "ex_cif_price"';
                $fields[] = '(SELECT ex_price FROM inv_prices where inv_item_id = "InvMovementDetail"."inv_item_id" AND date <= "InvMovement"."date" AND inv_price_type_id=9 order by date DESC, date_created DESC LIMIT 1) AS "ex_sale_price"';
                break;
        }

        return array('values' => $values, 'conditions' => $conditions, 'fields' => $fields, 'initialStocks' => $initialStocks);
    }

    private function _generate_report_movements($values, $conditions, $fields) {
        $staticFields = array(
            'InvMovement.id',
            'InvMovement.code',
            'InvMovement.document_code',
            'InvMovement.date',
            'InvMovement.inv_warehouse_id',
            'InvMovementDetail.inv_item_id',
            'InvMovementDetail.quantity'
        );

        //Field to get note_code from Sales and Purchases
        $fieldNoteCode = '(CASE "InvMovementType"."id" WHEN 1 THEN (SELECT note_code FROM pur_purchases WHERE code = "InvMovement"."document_code" LIMIT 1 )
			      WHEN 2 THEN (SELECT note_code FROM sal_sales WHERE code = "InvMovement"."document_code" LIMIT 1 ) 
			      ELSE \'NO\'
		      END) as "note_code"';
        $staticFields[] = $fieldNoteCode;

        //if(isset($values['bindMovementType']) AND $values['bindMovementType'] == 1){
        $this->InvMovement->InvMovementDetail->bindModel(array(
            'hasOne' => array(
                'InvMovementType' => array(
                    'foreignKey' => false,
                    'conditions' => array('InvMovement.inv_movement_type_id = InvMovementType.id')
                )
            )
        ));
        $fields[] = 'InvMovementType.status';
        //}
        $this->InvMovement->InvMovementDetail->unbindModel(array('belongsTo' => array('InvItem')));
        return $this->InvMovement->InvMovementDetail->find('all', array(
                    'conditions' => array(
                        'InvMovementDetail.inv_item_id' => $values['items'],
                        'InvMovement.lc_state' => 'APPROVED',
                        'InvMovement.date BETWEEN ? AND ?' => array($values['startDate'], $values['finishDate']),
                        $conditions
                    ),
                    'fields' => array_merge($staticFields, $fields),
                    'order' => array('InvMovement.date', 'InvMovementDetail.id')
        ));
    }

    private function _generate_report_items_complete($items, $limitDate, $currency) {
        $this->loadModel('InvItem');
        $this->InvItem->unbindModel(array('hasMany' => array('InvMovementDetail', 'PurDetail', 'SalDetail', 'InvItemsSupplier', 'InvPrice')));
        return $this->InvItem->find('all', array(
                    'fields' => array(
                        'InvItem.id'
                        , 'InvItem.code'
                        , 'InvItem.name'
                        , 'InvBrand.name'
                        , 'InvCategory.name'
                        , '(SELECT ' . $currency . 'price FROM inv_prices where inv_item_id = "InvItem"."id" AND date <= \'' . $limitDate . '\' AND inv_price_type_id=1 order by date DESC, date_created DESC LIMIT 1) AS "last_fob"'
                        , '(SELECT ' . $currency . 'price FROM inv_prices where inv_item_id = "InvItem"."id" AND date <= \'' . $limitDate . '\' AND inv_price_type_id=8 order by date DESC, date_created DESC LIMIT 1) AS "last_cif"'
                        , '(SELECT ' . $currency . 'price FROM inv_prices where inv_item_id = "InvItem"."id" AND date <= \'' . $limitDate . '\' AND inv_price_type_id=9 order by date DESC, date_created DESC LIMIT 1) AS "last_sale"'
                    ),
                    'conditions' => array('InvItem.id' => $items),
                    'order' => array('InvItem.code')
        ));
    }

    //////////////////////////////////////////// END - REPORT /////////////////////////////////////////////////
    //////////////////////////////////////////// START - GRAPHICS /////////////////////////////////////////////////
    ///////////////////////////////////NEW GRAPHICS SINCE MAY 2014///////////////////////////////////////////////////
    //First view graphics of warehouse movements starting with catgories(more easy for the user)
    public function graphics_movements_products() {
        $this->loadModel("AdmPeriod");
        $years = $this->AdmPeriod->find("list", array(
            "order" => array("name" => "desc"),
            "fields" => array("name", "name")
                )
        );
//        $months = array(0 => "Todos", 1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");
        $months = array("01" => "Ene", "02" => "Feb", "03" => "Mar", "04" => "Abr", "05" => "May", "06" => "Jun", "07" => "Jul", "08" => "Ago", "09" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dic");
        $movementTypesClean = $this->InvMovement->InvMovementType->find("all", array("recursive" => -1, "fields" => array("id", "name", "status"), "order" => array("status", "id")));
        $movementTypes = array();
        $out = 0;
        $movementTypes['entrada-0'] = "ENTRADAS";
        foreach ($movementTypesClean as $value) {
            if ($value["InvMovementType"]["status"] == "salida") {
                if ($out == 0) {
                    $movementTypes['salida-0'] = "SALIDAS";
                }
                $out++;
            }
            $movementTypes[$value["InvMovementType"]["status"] . "-" . $value["InvMovementType"]["id"]] = strtoupper($value["InvMovementType"]["status"]) . " - " . $value["InvMovementType"]["name"];
        }

//        $departaments = array("La Paz" => "La Paz", "Cochabamba" => "Cochabamba", "Santa Cruz" => "Santa Cruz", "Oruro" => "Oruro", "Potosi" => "Potosi", "Chuquisaca" => "Chuquisaca", "Tarija" => "Tarija", "Beni" => "Beni", "Pando" => "Pando");
        $departamentsClean = $this->InvMovement->InvWarehouse->find("list", array(
            "fields" => array("InvWarehouse.location", "InvWarehouse.location"),
            "group" => array("InvWarehouse.location"),
        ));
        $departaments = array_merge(array("TODOS" => "TODOS"), $departamentsClean);

        $warehousesClean = $this->InvMovement->InvWarehouse->find("list", array(
            'conditions' => array('InvWarehouse.location' => key($departaments))
        ));
//        if (count($warehousesClean) > 0) {
        $warehouses[0] = "TODOS";
        foreach ($warehousesClean as $key => $value) {
            $warehouses[$key] = $value;
        }
//        } else {
//            $warehouses[9999] = "VACIO";
//        }
        $groups = array();
        if (!isset($this->passedArgs['groupId'])) {
            $groups = array('brand' => 'Marca', 'category' => 'Categoria');
        }
        $this->set(compact("warehouses", "departaments", "years", "months", "movementTypes", "groups"));
//        debug($this->_get_pie_movements_by_groups('2014', array("02","03","04","05"), 0, "entrada", "La Paz", 1, "InvCategory", "0", "include"));
    }

    /////////////////////////////////OLD GRAPHICS//////////////////////////////////////////////
    public function vgraphics() {
        $warehousesClean = $this->InvMovement->InvWarehouse->find("list");
        //array_unshift($warehouses, "TODOS");// doesn't work 'cause change key values to an order 1,2,3,etc
        //$warehouses[0]="TODOS";
        foreach ($warehousesClean as $key => $value) {
            $warehouses[$key] = $value;
        }
        //debug($warehouses);
        $this->loadModel("AdmPeriod");
        $years = $this->AdmPeriod->find("list", array(
            "order" => array("name" => "desc"),
            "fields" => array("name", "name")
                )
        );
        $movementTypesClean = $this->InvMovement->InvMovementType->find("all", array("recursive" => -1, "fields" => array("id", "name", "status"), "order" => array("status", "id")));
        $movementTypes = array();
        foreach ($movementTypesClean as $value) {
            $movementTypes[$value["InvMovementType"]["id"]] = strtoupper($value["InvMovementType"]["status"]) . " - " . $value["InvMovementType"]["name"];
        }
        //debug($movementTypes);
        /*
          $this->loadModel("InvItem");

          $itemsClean = $this->InvItem->find("list", array('order'=>array('InvItem.code')));
          $items[0]="TODOS";
          foreach ($itemsClean as $key => $value) {
          $items[$key] = $value;
          }
         */
        $item = $this->_find_items();
//		debug($items);
        //array_unshift($items, "TODOS"); // doesn't work 'cause change key values to an order 1,2,3,etc
        $this->set(compact("warehouses", "years", "item", "movementTypes"));
        //debug($this->_get_bars_items_quantity_and_time("entrada", "2013", 0, 0));
    }

    public function vgraphics_historical_prices() {
        //$item = $this->_find_items();
        $this->loadModel("InvItem");
        $items = $this->InvItem->find("list", array(
            "fields" => array("InvItem.id", "InvItem.full_name"),
            "order" => array("InvItem.code")
        ));
        $this->set(compact("items"));
    }

    public function ajax_get_graphics_data_historical_prices() {
        if ($this->RequestHandler->isAjax()) {
            $startDate = $this->request->data['startDate'];
            $finishDate = $this->request->data['finishDate'];
            $currency = $this->request->data['currency'];
            $item = $this->request->data['item'];
            //$string = $this->_get_bars_historical_prices($startDate, $finishDate, $item, $currency, 1);
            //debug($currency);
            /*
              $string = $this->_get_pie_items_quantity_and_type("entrada", $year, $warehouse, $item, $month).",";
              $string .= $this->_get_pie_items_quantity_and_type("salida", $year, $warehouse, $item, $month).",";
              $string .= $this->_get_bars_items_quantity_and_time("entrada", $year, $warehouse, $item).",";
              $string .= $this->_get_bars_items_quantity_and_time("salida", $year, $warehouse, $item);
             */
            //debug($string);
            $fob = $this->_get_bars_historical_prices($startDate, $finishDate, $item, $currency, 1); // FOB
            //debug($fob);
            $cif = $this->_get_bars_historical_prices($startDate, $finishDate, $item, $currency, 8); // CIF
            $sale = $this->_get_bars_historical_prices($startDate, $finishDate, $item, $currency, 9); // SALE
            $string = $fob["time"] . ",";
            $string .= $fob["price"] . ",";
            $string .= $cif["time"] . ",";
            $string .= $cif["price"] . ",";
            $string .= $sale["time"] . ",";
            $string .= $sale["price"];
            echo $string;
        }
    }

    private function _get_bars_historical_prices($startDate, $finishDate, $item, $currency, $priceType) {
        $currencyAbbr = "";
        if ($currency == "DOLARES") {
            $currencyAbbr = "ex_";
        }
        $this->loadModel("InvPrice");
        $array = $this->InvPrice->find("all", array(
            "fields" => array("InvPrice." . $currencyAbbr . "price", 'to_char("InvPrice"."date", \' dd/mm/YYYY \') as date'),
            "conditions" => array(
                "InvPrice.inv_item_id" => $item
                , "InvPrice.inv_price_type_id" => $priceType
                , 'InvPrice.date BETWEEN ? AND ?' => array($startDate, $finishDate)
            ),
            "order" => array("InvPrice.date" => "asc")
        ));
        $time = "";
        $price = "";
        //debug($array);
        //debug(count($array));
        for ($i = 0; $i < count($array); $i++) {
            $time .= $array[$i][0]["date"] . "|";
            $price .= $array[$i]["InvPrice"][$currencyAbbr . "price"] . "|";
        }
        //debug(substr($time, 0, -1));
        //debug($price);
        return array("time" => substr($time, 0, -1), "price" => substr($price, 0, -1));

        //debug($array);
    }

    public function ajax_get_graphics_data() {
        if ($this->RequestHandler->isAjax()) {
            $year = $this->request->data['year'];
            //$month = $this->request->data['month'];
            $warehouse = $this->request->data['warehouse'];
            $item = $this->request->data['item'];
            $movementType = $this->request->data['movementType'];
            //$string = $this->_get_pie_items_quantity_and_type("entrada", $year, $warehouse, $item, $month).",";
            //$string .= $this->_get_pie_items_quantity_and_type("salida", $year, $warehouse, $item, $month).",";
            //$string .= $this->_get_bars_items_quantity_and_time("entrada", $year, $warehouse, $item).",";
            //$string = $this->_get_bars_items_quantity_and_time("salida", $year, $warehouse, $item, $movementType);
            $string = $this->_get_bars_items_quantity_and_time($year, $warehouse, $item, $movementType);
            echo $string;
        }
//		$string = 'Compras-88|Traspasos-33|Aperturas-45|Otros-225,';
//		$string .= 'Compras-50|Traspasos-25|Aperturas-75|Otros-15,';
//		$string .= '45|133|12|54|64|22|31|45|87|600|543|34,';
//		$string .= '30|54|12|114|64|100|98|80|10|50|169|222';
    }

    public function ajax_get_graphics_movements_products() {
        if ($this->RequestHandler->isAjax()) {
            $year = $this->request->data['year'];
            $month = $this->request->data['month'];
            $movementType = $this->request->data['movementType'];
            list($movementTypeStatus, $movementTypeId) = split('-', $movementType);
            $location = $this->request->data['location'];
            $warehouse = $this->request->data['warehouse'];
            $group = $this->request->data['group']; //category or brand
            $selectedIds = $this->request->data['selectedIds'];
            $groupId = $this->request->data['groupId'];
            $json = array();
/////////////////SWITCH BETWEEN GROUPS OR PRODUCTS BY GROUP           
            $model = "InvBrand";
            $productsCondition = null;
            if ($group == "category") {
                $model = "InvCategory";
            }
            if ($groupId > 0){
                $model = "InvItem";
                if ($group == "category") {
                    $productsCondition = array($model.".inv_category_id"=>$groupId);
                }else{
                    $productsCondition = array($model.".inv_brand_id"=>$groupId);
                }
            }
///////////////////
        //PIE (CORE) and also included data
        $pieDataCompleteIncluded = $this->_get_pie_movements_by_groups($year, $month, $movementTypeId, $movementTypeStatus, $location, $warehouse, $model, $selectedIds, "include", $productsCondition); //array plus Ids
        $pieDataFormatedIncluded = $this->_formatDataPieToJson($pieDataCompleteIncluded, $model); //Here divides in two = [json, selectedIds]
        $json["Pie"] = $pieDataFormatedIncluded["json"]; //$pieDataDivided["selectedIds"]
        $listIncludedSums = $pieDataFormatedIncluded["listDatatableIdsSums"];
        $listIncludedSelectedIds = $pieDataFormatedIncluded["selectedIds"]; //always will work because capture selected checkboxes ids or limit 5 order DESC (never nulls)
        if ($selectedIds[0] > 0) {//selected checkedbox value from datatable
            $listIncludedSelectedIds = $selectedIds;
        }

        //LINES BARS
        $linesBarsDataComplete = $this->_get_bars_lines_movements_by_products($year, $month, $movementTypeId, $movementTypeStatus, $location, $warehouse, $model, $pieDataFormatedIncluded["selectedIds"], $productsCondition);
        $linesBarsDataFormated = $this->_formatDataLinesBarsToJson($linesBarsDataComplete, $model, $pieDataFormatedIncluded["selectedIds"]);
        $json["LinesBars"] = $linesBarsDataFormated;

        //excluded data
        $pieDataCompleteExcluded = $this->_get_pie_movements_by_groups($year, $month, $movementTypeId, $movementTypeStatus, $location, $warehouse, $model, $selectedIds, "exclude", $productsCondition); //array plus Ids
        $pieDataFormatedExcluded = $this->_formatDataPieToJson($pieDataCompleteExcluded, $model);
        $listExcludedSums = $pieDataFormatedExcluded["listDatatableIdsSums"];
////            $listExcludedSelectedIds = $pieDataFormatedExcluded["selectedIds"]; //won't work 'cause could exclude nulls
        $listExcludedSelectedIds = $this->_getExcludedIds($model, $listIncludedSelectedIds, $productsCondition); //must overload this function to get excluded
        
        //COMPLETE LIST for datatable = with checkboxes, colors, label and quantities. Union, ordered and 0 quanties
        $listGroups = $this->_getList($model, $productsCondition);
        $json["DataTable"] = $this->_get_list_groups_graphics_datatable($listIncludedSums, $listExcludedSums, $listIncludedSelectedIds, $listExcludedSelectedIds, $listGroups);
        $json["LastSelectedGroup"] = $group;
        return new CakeResponse(array('body' => json_encode($json)));  //convert to json format and send
        
        } else {
            $this->redirect($this->Auth->logout()); //only accesible through ajax otherwise logout
        }
    }

    private function _get_list_groups_graphics_datatable($listIncludedSums, $listExcludedSums, $listIncludedSelectedIds, $listExcludedSelectedIds, $listGroups) {
        //****$listIncludedSums, $listExcludedSums  have => ids, label, data  
        //put labels to selected ids
        $listIncludedSelectedIdsPlusLabels = $this->_set_labels_to_selected_ids($listIncludedSelectedIds, $listGroups);
        $listExcludedSelectedIdsPlusLabels = $this->_set_labels_to_selected_ids($listExcludedSelectedIds, $listGroups);

        //put zero values to selected ids when null
        $listIncludedPlusZeros = $this->_add_zero_to_selected_ids($listIncludedSelectedIdsPlusLabels, $listIncludedSums, "included");
        $listExcludedPlusZeros = $this->_add_zero_to_selected_ids($listExcludedSelectedIdsPlusLabels, $listExcludedSums, "excluded");

        //merges included and excluded 
        return array_merge($listIncludedPlusZeros, $listExcludedPlusZeros);
    }

    private function _add_zero_to_selected_ids($listSelectedIdsPlusLabels, $listSums, $type) {
        //this function will add zero value if null 
        $listIncludedPlusZeros = array();
        $tempSortBySumArray = array(); //to order multidimension array by sum value
        $tempSortByLabelArray = array();

        for ($i = 0; $i < count($listSelectedIdsPlusLabels); $i++) {

            $listIncludedPlusZeros[$i]["id"] = $listSelectedIdsPlusLabels[$i]["id"];
            $listIncludedPlusZeros[$i]["checked"] = false;
            if ($type == "included") {
                $listIncludedPlusZeros[$i]["checked"] = true;
            }
            $listIncludedPlusZeros[$i]["label"] = $listSelectedIdsPlusLabels[$i]["label"];

            $sumValue = 0;
            for ($j = 0; $j < count($listSums); $j++) {
                if ($listSelectedIdsPlusLabels[$i]["id"] == $listSums[$j]["id"]) {
                    $sumValue = $listSums[$j]["data"];
//                    unset($listSums[$j]["id"]);//unset not working 'cause nested array moves index and counter does not match anymore
                }
            }
            $listIncludedPlusZeros[$i]["data"] = $sumValue;
            $tempSortBySumArray[$i] = $sumValue;
            $tempSortByLabelArray[$i] = $listSelectedIdsPlusLabels[$i]["label"];
        }

        //sort by sum DESC, label ASC
        $res = array_multisort($tempSortBySumArray, SORT_DESC, $tempSortByLabelArray, SORT_ASC, $listIncludedPlusZeros); //Important array_multisort return true or false, must send the original sorted array anyway

        return $listIncludedPlusZeros;
    }

    private function _set_labels_to_selected_ids($selectedIds, $completeList) {
        $data = array();
        $counter = 0;
//        debug($selectedIds);
//        debug($completeList);
//        for ($i = 0; $i < count($selectedIds); $i++) {
        foreach ($selectedIds as $keySelectedId => $varSelectedId) {
            foreach ($completeList as $id => $label) { //id=>label
                if ($varSelectedId == $id) {
                    $data[$counter]["id"] = $id;
                    $data[$counter]["label"] = $label;
                    unset($completeList[$id]);
                }
            }
            $counter++;
        }
        return $data;
    }

    private function _get_pie_movements_by_groups($year, $month, $movementTypeId, $movementTypeStatus, $location, $warehouse, $model, $selectedIds, $rule, $productsCondition) { //group could be by Category or Brand
        if ($movementTypeId == 0) {
            $movementTypeId = null;
        } else {
            $movementTypeId = array("InvMovementType.id" => $movementTypeId);
        }
        if ($location == "TODOS") {
            $location = null;
            $warehouse = null;
        } else {
            $location = array("InvWarehouse.location" => $location);
            if ($warehouse == 0) {
                $warehouse = null;
            } else {
                $warehouse = array("InvWarehouse.id" => $warehouse);
            }
        }

        $exceptionBind = array();
        if ($model == "InvBrand") {
            $exceptionBind[$model] = array('foreignKey' => false, 'conditions' => array('InvItem.inv_brand_id = InvBrand.id'));
        } elseif ($model == "InvCategory") {
            $exceptionBind[$model] = array('foreignKey' => false, 'conditions' => array('InvItem.inv_category_id = InvCategory.id'));
        }
        $fieldName = $model . ".name";
        $fieldId = $model . ".id";

        $limit = null;
        $offset = null;
        if ($selectedIds == 0) {
            $selectedIds = null;
            if ($rule == "include") {//include
                $limit = 5;
            }else{//exclude
                $offset = 5;
            }
        } else {
            if ($rule == "include") {//include
                $selectedIds = array($model . ".id" => $selectedIds);
            } else {//exclude
                $selectedIds = array("NOT" => array($model . ".id" => $selectedIds));
            }
        }

        $genericBind = array(
            "InvMovementType" => array('foreignKey' => false, 'conditions' => array("InvMovement.inv_movement_type_id = InvMovementType.id")),
            "InvWarehouse" => array('foreignKey' => false, 'conditions' => array("InvMovement.inv_warehouse_id = InvWarehouse.id"))
        );
        $this->InvMovement->InvMovementDetail->bindModel(array(
            "hasOne" => array_merge($genericBind, $exceptionBind)
        ));
        $data = $this->InvMovement->InvMovementDetail->find('all', array(
            "fields" => array($fieldId, $fieldName, "COALESCE(SUM(InvMovementDetail.quantity),0) as sum"), //COALESCE NOT WORKING BUT STILL WORK
            "group" => array($fieldId, $fieldName),
            "conditions" => array(
                "InvMovement.lc_state" => "APPROVED",
                "to_char(InvMovement.date,'YYYY')" => $year,
                "to_char(InvMovement.date,'mm')" => $month,
                $movementTypeId,
                "InvMovementType.status" => $movementTypeStatus,
                $location,
                $warehouse,
                $selectedIds,
                $productsCondition
            ),
            "order" => array("sum" => "DESC"),
            "limit" => $limit,
            "offset" => $offset
        ));
        return $data;
    }

    private function _getList($model, $productsCondition) {
        $this->loadModel($model);
        $data = $this->$model->find("list", array(
            "conditions"=>array($productsCondition)
        ));
        return $data;
    }

    private function _getExcludedIds($model, $excludes, $productsCondition) {
        $this->loadModel($model);
        $data = $this->$model->find("list", array(
            "fields" => array($model . ".id", $model . ".id")
            , "conditions" => array(
                "NOT" => array($model . ".id" => $excludes)
                ,$productsCondition
                )
            , "order" => array($model . ".name" => "ASC")
        ));
        return $data;
    }

    private function _formatDataPieToJson($data, $model) {
        //Format Data to Json (data[i] = { label: "Name", data: number })
        $json = array();
        $selectedIds = array();
        $listDatatableIdsSums = array(); //to fill graphics datatable
        for ($i = 0; $i < count($data); $i++) {
            $json[$i]["label"] = $data[$i][$model]["name"];
            $json[$i]["data"] = (int) $data[$i][0]["sum"]; //Convert to int, otherwise plotchart.js won't recognize
            $selectedIds[$i] = $data[$i][$model]["id"];
            $listDatatableIdsSums[$i]["id"] = $data[$i][$model]["id"];
            $listDatatableIdsSums[$i]["label"] = $data[$i][$model]["id"];
            $listDatatableIdsSums[$i]["data"] = (int) $data[$i][0]["sum"];
        }
        return array("json" => $json, "selectedIds" => $selectedIds, "listDatatableIdsSums" => $listDatatableIdsSums); //$data;
        //////////////////////////////////////////////////////////////////////////////////
    }

    private function _formatDataLinesBarsToJson($data, $model, $selectedIds) {
        //Format Data to Json (data[i] = { label: "Name", data: number })
        $dataGrouped = array();
        $json = array();
        $counter = 0;

        for ($i = 0; $i < count($data); $i++) {
            $label = $data[$i][$model]["name"];
            $id = $data[$i][$model]["id"]; //
            $month = (int) $data[$i][0]["month"];
            $quantity = (int) $data[$i][0]["sum"];

//            $dataGrouped[$label][$month] = array($month,$quantity); //Ej: 'Accesorios' => array('01'=>array(1,888), '02'=>array(2,543)) | 'Aceites' => array('01'=>array(1,78))
            $dataGrouped[$id . "-" . $label][$month] = array($month, $quantity); //Ej: 'Accesorios' => array('01'=>array(1,888), '02'=>array(2,543)) | 'Aceites' => array('01'=>array(1,78))
        }
        foreach ($selectedIds as $valueSelectedIds) {//order elements as pie chart DESC values
            foreach ($dataGrouped as $keyDataGrouped => $valueDataGrouped) {
                list($id, $label) = split("-", $keyDataGrouped);
                if ($valueSelectedIds == $id) {
                    $json[$counter]["label"] = $label;
                    $json[$counter]["data"] = array_values($valueDataGrouped); //use array_values to reset keys. Ej: "04" to 0, "08" to 1 in sequencial order. For fit plotchart format
                    unset($dataGrouped[$keyDataGrouped]); //if matches remove the element from array for better perfomance
                }
            }
            $counter++;
        }
//        foreach ($dataGrouped as $key => $value) {//Ej: $key='Accesorios', $value=array('04'=>array(4,22))
//            $json[$counter]["label"] = $key;
//            $json[$counter]["data"] = array_values($value);//use array_values to reset keys. Ej: "04" to 0, "08" to 1 in sequencial order. For fit plotchart format
//            $counter++;
//        }
//        return $selectedIds; 
        return $json;
    }

    private function _get_bars_lines_movements_by_products($year, $month, $movementTypeId, $movementTypeStatus, $location, $warehouse, $model, $selectedIds, $productsCondition) {
        if ($movementTypeId == 0) {
            $movementTypeId = null;
        } else {
            $movementTypeId = array("InvMovementType.id" => $movementTypeId);
        }
        if ($location == "TODOS") {
            $location = null;
            $warehouse = null;
        } else {
            $location = array("InvWarehouse.location" => $location);
            if ($warehouse == 0) {
                $warehouse = null;
            } else {
                $warehouse = array("InvWarehouse.id" => $warehouse);
            }
        }
        $exceptionBind = array();
        if ($model == "InvBrand") {
            $exceptionBind[$model] = array('foreignKey' => false, 'conditions' => array('InvItem.inv_brand_id = InvBrand.id'));
        } elseif ($model == "InvCategory") {
            $exceptionBind[$model] = array('foreignKey' => false, 'conditions' => array('InvItem.inv_category_id = InvCategory.id'));
        }
        $fieldId = $model . ".id";
        $fieldName = $model . ".name";

        $genericBind = array(
            "InvMovementType" => array('foreignKey' => false, 'conditions' => array("InvMovement.inv_movement_type_id = InvMovementType.id")),
            "InvWarehouse" => array('foreignKey' => false, 'conditions' => array("InvMovement.inv_warehouse_id = InvWarehouse.id"))
        );
        $this->InvMovement->InvMovementDetail->bindModel(array(
            "hasOne" => array_merge($genericBind, $exceptionBind)
        ));
        $data = $this->InvMovement->InvMovementDetail->find('all', array(
            "fields" => array(
                $fieldId
                , $fieldName
                , "to_char(\"InvMovement\".\"date\",'mm') AS month"
                , "SUM(InvMovementDetail.quantity) as sum"
//                ,'(CASE WHEN SUM(InvMovementDetail.quantity) > 0 THEN SUM(InvMovementDetail.quantity) ELSE 0 END)  AS sum' //do not work
            ),
            "group" => array($fieldId, $fieldName, "month"),
            "conditions" => array(
                "InvMovement.lc_state" => "APPROVED",
                "to_char(InvMovement.date,'YYYY')" => $year,
                "to_char(InvMovement.date,'mm')" => $month,
                $model . ".id" => $selectedIds,
                $movementTypeId,
                "InvMovementType.status" => $movementTypeStatus,
//                "InvWarehouse.location" => $location,
                $location,
                $warehouse,
                $productsCondition
            ),
            "order" => array("month" => "ASC")
        ));

        return $data;
    }

    /////////////////////////////////////////old

    private function _get_pie_items_quantity_and_type($status, $year, $warehouse, $item, $month) {
        $conditionWarehouse = null;
        $conditionItem = null;
        $conditionMonth = null;
        $dataString = "";

        if ($warehouse > 0) {
            $conditionWarehouse = array("InvMovement.inv_warehouse_id" => $warehouse);
        }

//        if ($item > 0) {
//            $conditionItem = array("InvMovementDetail.inv_item_id" => $item);
//        }

        if ($month > 0) {
            if (count($month) == 1) {
                $conditionMonth = array("to_char(InvMovement.date,'mm')" => "0" . $month);
            } else {
                $conditionMonth = array("to_char(InvMovement.date,'mm')" => $month);
            }
        }

        // get types
        $types = $this->InvMovement->InvMovementType->find("list", array(
            "conditions" => array("InvMovementType.status" => $status)
        ));


        //get items, types and sum quantities
        $this->InvMovement->InvMovementDetail->bindModel(array(
            'hasOne' => array(
                'InvMovementType' => array(
                    'foreignKey' => false,
                    'conditions' => array('InvMovement.inv_movement_type_id = InvMovementType.id')
                )
            )
        ));
        $this->InvMovement->InvMovementDetail->unbindModel(array('belongsTo' => array('InvItem')));
        $data = $this->InvMovement->InvMovementDetail->find('all', array(
            "fields" => array("InvMovementType.name", "SUM(InvMovementDetail.quantity)"),
            'group' => array('InvMovementType.name'),
            "conditions" => array(
                "InvMovementType.status" => $status,
                "to_char(InvMovement.date,'YYYY')" => $year,
                "InvMovement.lc_state" => "APPROVED",
                $conditionWarehouse,
                $conditionItem,
                $conditionMonth
            )
        ));

        //format data on string to response ajax request
        foreach ($types as $type) {
            $exist = 0;
            foreach ($data as $value) {
                if ($type == $value['InvMovementType']['name']) {
                    $dataString .= $type . "-" . $value[0]['sum'] . "|";
                    //debug($dataString);
                    $exist++;
                }
            }
            if ($exist == 0) {
                $dataString .= $type . "-0|";
            }
        }

        return substr($dataString, 0, -1); // remove last character "|"
    }

    private function _add_left_zero_to_one_digit_number($number) {
        if ($number > 0) {
            if (count($number) == 1) {
                return "0" . $number;
            }
        }
        return $number;
    }

    private function _get_bars_items_quantity_and_time($year, $warehouse, $item, $movementType) {
        $conditionWarehouse = null;
        $conditionItem = null;
        $dataString = "";

        if ($warehouse > 0) {
            $conditionWarehouse = array("InvMovement.inv_warehouse_id" => $warehouse);
        }

        if ($item > 0) {
            $conditionItem = array("InvMovementDetail.inv_item_id" => $item);
        }

        //get items, types and sum quantities
        /*
          $this->InvMovement->InvMovementDetail->bindModel(array(
          'hasOne'=>array(
          'InvMovementType'=>array(
          'foreignKey'=>false,
          'conditions'=> array('InvMovement.inv_movement_type_id = InvMovementType.id')
          )
          )
          ));
         */
        $this->InvMovement->InvMovementDetail->unbindModel(array('belongsTo' => array('InvItem')));
        $data = $this->InvMovement->InvMovementDetail->find('all', array(
            "fields" => array("to_char(\"InvMovement\".\"date\",'mm') AS month", "SUM(InvMovementDetail.quantity)"),
            'group' => array("to_char(InvMovement.date,'mm')"),
            "conditions" => array(
                //"InvMovementType.status"=>$status,
                "InvMovement.inv_movement_type_id" => $movementType,
                "to_char(InvMovement.date,'YYYY')" => $year,
                "InvMovement.lc_state" => "APPROVED",
                $conditionWarehouse,
                $conditionItem
            )
        ));

        //format data on string to response ajax request
        $months = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);

        foreach ($months as $month) {
            $exist = 0;
            foreach ($data as $value) {
                if ($month == (int) $value[0]['month']) {
                    $dataString .= $value[0]['sum'] . "|";
                    //debug($dataString);
                    $exist++;
                }
            }
            if ($exist == 0) {
                $dataString .= "0|";
            }
        }

        return substr($dataString, 0, -1);
    }

    //////////////////////////////////////////// END - GRAPHICS  /////////////////////////////////////////////////
    //////////////////////////////////////////// START - INDEX ///////////////////////////////////////////////

    public function index_in() {
        //debug($this->request->params);
        //debug($this->passedArgs);
        ///////////////////////////////////////START - CREATING VARIABLES//////////////////////////////////////
        $filters = array();
        $code = '';
        $document_code = '';
        $searchDate = '';
        $period = $this->Session->read('Period.name');
        ///////////////////////////////////////END - CREATING VARIABLES////////////////////////////////////////
        ////////////////////////////START - WHEN SEARCH IS SEND THROUGH POST//////////////////////////////////////
        if ($this->request->is("post")) {
            $url = array('action' => 'index_in');
            $parameters = array();
            $empty = 0;
            if (isset($this->request->data['InvMovement']['code']) && $this->request->data['InvMovement']['code']) {
                $parameters['code'] = trim(strip_tags($this->request->data['InvMovement']['code']));
            } else {
                $empty++;
            }
            if (isset($this->request->data['InvMovement']['document_code']) && $this->request->data['InvMovement']['document_code']) {
                $parameters['document_code'] = trim(strip_tags($this->request->data['InvMovement']['document_code']));
            } else {
                $empty++;
            }
            if (isset($this->request->data['InvMovement']['searchDate']) && $this->request->data['InvMovement']['searchDate']) {
                $parameters['searchDate'] = trim(strip_tags(str_replace("/", "", $this->request->data['InvMovement']['searchDate'])));
            } else {
                $empty++;
            }
            if ($empty == 3) {
                $parameters['search'] = 'empty';
            } else {
                $parameters['search'] = 'yes';
            }
            $this->redirect(array_merge($url, $parameters));
        }
        ////////////////////////////END - WHEN SEARCH IS SEND THROUGH POST//////////////////////////////////////
        ////////////////////////////START - SETTING URL FILTERS//////////////////////////////////////
        if (isset($this->passedArgs['code'])) {
            $filters['InvMovement.code LIKE'] = '%' . strtoupper($this->passedArgs['code']) . '%';
            $code = $this->passedArgs['code'];
        }
        if (isset($this->passedArgs['document_code'])) {
            $filters['InvMovement.document_code LIKE'] = '%' . strtoupper($this->passedArgs['document_code']) . '%';
            $document_code = $this->passedArgs['document_code'];
        }

        if (isset($this->passedArgs['searchDate'])) {
            $catchDate = $this->passedArgs['searchDate'];
            $finalDate = substr($catchDate, 0, 2) . "/" . substr($catchDate, 2, 2) . "/" . substr($catchDate, 4, 4);
            $filters['InvMovement.date'] = $finalDate;
            $searchDate = $finalDate;
        }
        ////////////////////////////END - SETTING URL FILTERS//////////////////////////////////////
        ////////////////////////////START - SETTING PAGINATING VARIABLES//////////////////////////////////////
        $this->paginate = array(
            "conditions" => array(
                //"InvMovement.lc_state !="=>"LOGIC_DELETED",

                "NOT" => array("InvMovementType.id" => array(1, 2)), // new
//				"NOT"=>array("InvMovement.lc_state" => array("LOGIC_DELETED", "DRAFT")), //it denies the first NOT :S
                "InvMovement.lc_state" => array("PENDANT", "APPROVED", "CANCELLED"),
                "to_char(InvMovement.date,'YYYY')" => $period,
                "InvMovementType.status" => "entrada",
                $filters
            ),
            "recursive" => 0,
            "fields" => array("InvMovement.id", "InvMovement.code", "InvMovement.document_code", "InvMovement.date", "InvMovement.inv_movement_type_id", "InvMovementType.name", "InvMovement.inv_warehouse_id", "InvWarehouse.name", "InvMovement.lc_state"),
            "order" => array("InvMovement.id" => "desc"),
            "limit" => 15,
        );
        ////////////////////////////END - SETTING PAGINATING VARIABLES//////////////////////////////////////
        ////////////////////////START - SETTING PAGINATE AND OTHER VARIABLES TO THE VIEW//////////////////
        $this->set('invMovements', $this->paginate('InvMovement'));
        $this->set('code', $code);
        $this->set('document_code', $document_code);
        $this->set('searchDate', $searchDate);
        ////////////////////////END - SETTING PAGINATE AND OTHER VARIABLES TO THE VIEW//////////////////
    }

    public function index_out() {

        //debug($this->request->params);
        //debug($this->passedArgs);
        ///////////////////////////////////////START - CREATING VARIABLES//////////////////////////////////////
        $filters = array();
        $code = '';
        $document_code = '';
        $searchDate = '';
        $period = $this->Session->read('Period.name');
        ///////////////////////////////////////END - CREATING VARIABLES////////////////////////////////////////
        ////////////////////////////START - WHEN SEARCH IS SEND THROUGH POST//////////////////////////////////////
        if ($this->request->is("post")) {
            $url = array('action' => 'index_out');
            $parameters = array();
            $empty = 0;
            if (isset($this->request->data['InvMovement']['code']) && $this->request->data['InvMovement']['code']) {
                $parameters['code'] = trim(strip_tags($this->request->data['InvMovement']['code']));
            } else {
                $empty++;
            }
            if (isset($this->request->data['InvMovement']['document_code']) && $this->request->data['InvMovement']['document_code']) {
                $parameters['document_code'] = trim(strip_tags($this->request->data['InvMovement']['document_code']));
            } else {
                $empty++;
            }
            if (isset($this->request->data['InvMovement']['searchDate']) && $this->request->data['InvMovement']['searchDate']) {
                $parameters['searchDate'] = trim(strip_tags(str_replace("/", "", $this->request->data['InvMovement']['searchDate'])));
            } else {
                $empty++;
            }
            if ($empty == 3) {
                $parameters['search'] = 'empty';
            } else {
                $parameters['search'] = 'yes';
            }
            $this->redirect(array_merge($url, $parameters));
        }
        ////////////////////////////END - WHEN SEARCH IS SEND THROUGH POST//////////////////////////////////////
        ////////////////////////////START - SETTING URL FILTERS//////////////////////////////////////
        if (isset($this->passedArgs['code'])) {
            $filters['InvMovement.code LIKE'] = '%' . strtoupper($this->passedArgs['code']) . '%';
            $code = $this->passedArgs['code'];
        }
        if (isset($this->passedArgs['document_code'])) {
            $filters['InvMovement.document_code LIKE'] = '%' . strtoupper($this->passedArgs['document_code']) . '%';
            $document_code = $this->passedArgs['document_code'];
        }
        if (isset($this->passedArgs['searchDate'])) {
            $catchDate = $this->passedArgs['searchDate'];
            $finalDate = substr($catchDate, 0, 2) . "/" . substr($catchDate, 2, 2) . "/" . substr($catchDate, 4, 4);
            $filters['InvMovement.date'] = $finalDate;
            $searchDate = $finalDate;
        }
        ////////////////////////////END - SETTING URL FILTERS//////////////////////////////////////
        ////////////////////////////START - SETTING PAGINATING VARIABLES//////////////////////////////////////
        $this->paginate = array(
            "conditions" => array(
                //"InvMovement.lc_state !="=>"LOGIC_DELETED",
                "NOT" => array("InvMovementType.id" => array(1, 2)), // new
//				"NOT"=>array("InvMovement.lc_state" => array("LOGIC_DELETED", "DRAFT")), //it denies the first NOT :S
                "InvMovement.lc_state" => array("PENDANT", "APPROVED", "CANCELLED"),
                "to_char(InvMovement.date,'YYYY')" => $period,
                "InvMovementType.status" => "salida",
                $filters
            ),
            "recursive" => 0,
            "fields" => array("InvMovement.id", "InvMovement.code", "InvMovement.document_code", "InvMovement.date", "InvMovement.inv_movement_type_id", "InvMovementType.name", "InvMovement.inv_warehouse_id", "InvWarehouse.name", "InvMovement.lc_state"),
            "order" => array("InvMovement.id" => "desc"),
            "limit" => 15,
        );
        ////////////////////////////END - SETTING PAGINATING VARIABLES//////////////////////////////////////
        ////////////////////////START - SETTING PAGINATE AND OTHER VARIABLES TO THE VIEW//////////////////
        $this->set('invMovements', $this->paginate('InvMovement'));
        $this->set('code', $code);
        $this->set('document_code', $document_code);
        $this->set('searchDate', $searchDate);
        ////////////////////////END - SETTING PAGINATE AND OTHER VARIABLES TO THE VIEW//////////////////
    }

    public function index_purchase_in() {

        ///////////////////////////////////////START - CREATING VARIABLES//////////////////////////////////////
        $filters = array();
        $code = "";
        $document_code = '';  //seria code de pur_purchases
        $note_code = "";
        $searchDate = '';
        $period = $this->Session->read('Period.name');
        ///////////////////////////////////////END - CREATING VARIABLES////////////////////////////////////////
        ////////////////////////////START - WHEN SEARCH IS SEND THROUGH POST//////////////////////////////////////
        if ($this->request->is("post")) {
            $url = array('action' => 'index_purchase_in');
            $parameters = array();
            $empty = 0;
            if (isset($this->request->data['InvMovement']['code']) && $this->request->data['InvMovement']['code']) {
                $parameters['code'] = trim(strip_tags($this->request->data['InvMovement']['code']));
            } else {
                $empty++;
            }
            if (isset($this->request->data['InvMovement']['document_code']) && $this->request->data['InvMovement']['document_code']) {
                $parameters['document_code'] = trim(strip_tags($this->request->data['InvMovement']['document_code']));
            } else {
                $empty++;
            }
            if (isset($this->request->data['InvMovement']['note_code']) && $this->request->data['InvMovement']['note_code']) {
                $parameters['note_code'] = trim(strip_tags($this->request->data['InvMovement']['note_code']));
            } else {
                $empty++;
            }
            if (isset($this->request->data['InvMovement']['searchDate']) && $this->request->data['InvMovement']['searchDate']) {
                $parameters['searchDate'] = trim(strip_tags(str_replace("/", "", $this->request->data['InvMovement']['searchDate'])));
            } else {
                $empty++;
            }
            if ($empty == 4) {
                $parameters['search'] = 'empty';
            } else {
                $parameters['search'] = 'yes';
            }
            $this->redirect(array_merge($url, $parameters));
        }
        ////////////////////////////END - WHEN SEARCH IS SEND THROUGH POST//////////////////////////////////////
        ////////////////////////////START - SETTING URL FILTERS//////////////////////////////////////
        if (isset($this->passedArgs['code'])) {
            $filters['InvMovement.code LIKE'] = '%' . strtoupper($this->passedArgs['code']) . '%';
            $code = $this->passedArgs['code'];
        }
        if (isset($this->passedArgs['document_code'])) {
            $filters['InvMovement.document_code LIKE'] = '%' . strtoupper($this->passedArgs['document_code']) . '%';
            $document_code = $this->passedArgs['document_code'];
        }
        if (isset($this->passedArgs['searchDate'])) {
            $catchDate = $this->passedArgs['searchDate'];
            $finalDate = substr($catchDate, 0, 2) . "/" . substr($catchDate, 2, 2) . "/" . substr($catchDate, 4, 4);
            $filters['InvMovement.date'] = $finalDate;
            $searchDate = $finalDate;
        }
        // Filter by NoteCode, doing like this because there isn't association between movements and sales :( => 2.0 =)
        /////////////////////////////////////////////

        if (isset($this->passedArgs['note_code'])) {
//			$note_code = strtoupper($this->passedArgs['note_code']);
            $note_code = $this->passedArgs['note_code'];
            $this->loadModel('PurPurchase');
            $noteCodeCondition = $note_code;
            $conditions = array("PurPurchase.note_code LIKE" => '%' . $noteCodeCondition . '%');
            if ($note_code == "NO") {
                $noteCodeCondition = "";
                $conditions = array("PurPurchase.note_code" => $noteCodeCondition);
            }
            //debug($noteCodeCondition);

            $speciallyDocumentCode = $this->PurPurchase->find("list", array("conditions" => $conditions, "fields" => array("PurPurchase.note_code", "PurPurchase.code")));
            //debug($speciallyDocumentCode);
            //debug($noteCodeCondition);
            if (count($speciallyDocumentCode) == 1) {
                $filters['InvMovement.document_code LIKE'] = '%' . strtoupper(reset($speciallyDocumentCode)) . '%';
            } elseif (count($speciallyDocumentCode) == 0) {
                $filters['InvMovement.document_code LIKE'] = '%' . strtoupper("TOKENEMPTY") . '%';
            } else {
                $filters['InvMovement.document_code'] = $speciallyDocumentCode;
            }
        }
        ////////////////////////////END - SETTING URL FILTERS//////////////////////////////////////
//		$this->InvMovement->bindModel(array('hasOne'=>array('SalCustomer'=>array('foreignKey'=>false,'conditions'=> array('SalEmployee.sal_customer_id = SalCustomer.id')))));
        ////////////////////////////////START - LIST ONLY SALES MOVEMENTS (easier) /////////////////////////////////////////
        $this->paginate = array(
            "conditions" => array(
                //"InvMovement.lc_state !="=>"LOGIC_DELETED",
                "NOT" => array("InvMovement.lc_state" => array("LOGIC_DELETED", "DRAFT")),
                "InvMovementType.id" => array(1), //only purchases
                "to_char(InvMovement.date,'YYYY')" => $period,
                //"InvMovementType.status"=> "salida",
                $filters
            ),
            "recursive" => 0,
            "fields" => array("InvMovement.id", "InvMovement.code", "InvMovement.document_code", "InvMovement.date", "InvMovement.inv_movement_type_id", "InvMovementType.name", "InvMovement.inv_warehouse_id", "InvWarehouse.name", "InvMovement.lc_state"
//				, '(SELECT CASE note_code WHEN \'\' THEN \'NO\' ELSE note_code END FROM pur_purchases WHERE code = "InvMovement"."document_code" LIMIT 1 ) AS note_code'),
                , '(SELECT CASE note_code WHEN \'\' THEN \'NO\' ELSE note_code END FROM pur_purchases WHERE code = "InvMovement"."document_code" ORDER BY date_created DESC LIMIT 1)  AS note_code'
                , '(SELECT array_to_string(array(
					SELECT name FROM inv_suppliers 
					JOIN pur_details ON pur_details.inv_supplier_id = inv_suppliers.id 
					JOIN pur_purchases ON pur_purchases.id = pur_details.pur_purchase_id 
					WHERE pur_purchases.code = "InvMovement"."document_code" GROUP BY name), \' / \')) AS sup_name'
            ),
            "order" => array("InvMovement.id" => "desc"),
            "limit" => 15,
        );

        $movements = $this->paginate('InvMovement');
//		debug($movements);
        ////////////////////////////////////////////


        $this->set('invMovements', $movements);
        $this->set('code', $code);
        $this->set('document_code', $document_code);
        $this->set('note_code', $note_code);
        $this->set('searchDate', $searchDate);
        ////////////////////////////////END - LIST ONLY SALES MOVEMENTS (easier) /////////////////////////////////////////
    }

    public function index_sale_out() {

        ///////////////////////////////////////START - CREATING VARIABLES//////////////////////////////////////
        $filters = array();
        $code = "";
        $document_code = '';  //seria code de pur_purchases
        $note_code = "";
        $searchDate = "";
        $period = $this->Session->read('Period.name');
        ///////////////////////////////////////END - CREATING VARIABLES////////////////////////////////////////
        ////////////////////////////START - WHEN SEARCH IS SEND THROUGH POST//////////////////////////////////////
        if ($this->request->is("post")) {
            $url = array('action' => 'index_sale_out');
            $parameters = array();
            $empty = 0;
            if (isset($this->request->data['InvMovement']['code']) && $this->request->data['InvMovement']['code']) {
                $parameters['code'] = trim(strip_tags($this->request->data['InvMovement']['code']));
            } else {
                $empty++;
            }
            if (isset($this->request->data['InvMovement']['document_code']) && $this->request->data['InvMovement']['document_code']) {
                $parameters['document_code'] = trim(strip_tags($this->request->data['InvMovement']['document_code']));
            } else {
                $empty++;
            }
            if (isset($this->request->data['InvMovement']['note_code']) && $this->request->data['InvMovement']['note_code']) {
                $parameters['note_code'] = trim(strip_tags($this->request->data['InvMovement']['note_code']));
            } else {
                $empty++;
            }
            if (isset($this->request->data['InvMovement']['searchDate']) && $this->request->data['InvMovement']['searchDate']) {
                $parameters['searchDate'] = trim(strip_tags(str_replace("/", "", $this->request->data['InvMovement']['searchDate'])));
            } else {
                $empty++;
            }
            if ($empty == 4) {
                $parameters['search'] = 'empty';
            } else {
                $parameters['search'] = 'yes';
            }
            $this->redirect(array_merge($url, $parameters));
        }
        ////////////////////////////END - WHEN SEARCH IS SEND THROUGH POST//////////////////////////////////////
        ////////////////////////////START - SETTING URL FILTERS//////////////////////////////////////
        if (isset($this->passedArgs['code'])) {
            $filters['InvMovement.code LIKE'] = '%' . strtoupper($this->passedArgs['code']) . '%';
            $code = $this->passedArgs['code'];
        }
        if (isset($this->passedArgs['document_code'])) {
            $filters['InvMovement.document_code LIKE'] = '%' . strtoupper($this->passedArgs['document_code']) . '%';
            $document_code = $this->passedArgs['document_code'];
        }
        if (isset($this->passedArgs['searchDate'])) {
            $catchDate = $this->passedArgs['searchDate'];
            $finalDate = substr($catchDate, 0, 2) . "/" . substr($catchDate, 2, 2) . "/" . substr($catchDate, 4, 4);
            $filters['InvMovement.date'] = $finalDate;
            $searchDate = $finalDate;
        }
        // Filter by NoteCode, doing like this because there isn't association between movements and sales :( => 2.0 =)
        /////////////////////////////////////////////

        if (isset($this->passedArgs['note_code'])) {
//			$note_code = strtoupper($this->passedArgs['note_code']);
            $note_code = $this->passedArgs['note_code'];
            $this->loadModel('SalSale');
            $noteCodeCondition = $note_code;
            $conditions = array("SalSale.note_code LIKE" => '%' . $noteCodeCondition . '%');
            if ($note_code == "NO") {
                $noteCodeCondition = "";
                $conditions = array("SalSale.note_code" => $noteCodeCondition);
            }
            //debug($noteCodeCondition);

            $speciallyDocumentCode = $this->SalSale->find("list", array("conditions" => $conditions, "fields" => array("SalSale.note_code", "SalSale.code")));
            //debug($speciallyDocumentCode);
            if (count($speciallyDocumentCode) == 1) {
                $value = reset($speciallyDocumentCode);
                $filters['InvMovement.document_code LIKE'] = '%' . strtoupper($value) . '%';
                /*
                  if($note_code == "NO"){
                  $filters['InvMovement.document_code LIKE'] = '%'.strtoupper($speciallyDocumentCode[$noteCodeCondition]).'%';
                  }else{
                  $filters['InvMovement.document_code LIKE'] = '%'.strtoupper($speciallyDocumentCode[$noteCodeCondition]).'%';
                  }
                 * 
                 */
            } elseif (count($speciallyDocumentCode) == 0) {
                $filters['InvMovement.document_code LIKE'] = '%' . strtoupper("TOKENEMPTY") . '%';
            } else {
                $filters['InvMovement.document_code'] = $speciallyDocumentCode;
            }
        }
        ////////////////////////////END - SETTING URL FILTERS//////////////////////////////////////
        ////////////////////////////////START - LIST ONLY SALES MOVEMENTS (easier) /////////////////////////////////////////
        $this->paginate = array(
            "conditions" => array(
                //"InvMovement.lc_state !="=>"LOGIC_DELETED",
                "NOT" => array("InvMovement.lc_state" => array("LOGIC_DELETED", "DRAFT")),
                "InvMovementType.id" => array(2), //only sales
                "to_char(InvMovement.date,'YYYY')" => $period,
                //"InvMovementType.status"=> "salida",
                $filters
            ),
            "recursive" => 0,
            "fields" => array("InvMovement.id", "InvMovement.code", "InvMovement.document_code", "InvMovement.date", "InvMovement.inv_movement_type_id", "InvMovement.type", "InvMovementType.name", "InvMovement.inv_warehouse_id", "InvWarehouse.name", "InvMovement.lc_state"
//				, '(SELECT CASE note_code WHEN \'\' THEN \'NO\' ELSE note_code END FROM sal_sales WHERE code = "InvMovement"."document_code" LIMIT 1 ) AS note_code'),
                , '(SELECT CASE note_code WHEN \'\' THEN \'NO\' ELSE note_code END FROM sal_sales WHERE code = "InvMovement"."document_code" ORDER BY date_created DESC LIMIT 1)  AS note_code'),
            "order" => array("InvMovement.id" => "desc"),
            "limit" => 15,
        );

        $movements = $this->paginate('InvMovement');
        //debug($movements);
        ////////////////////////////////////////////


        $this->set('invMovements', $movements);
        $this->set('code', $code);
        $this->set('document_code', $document_code);
        $this->set('note_code', $note_code);
        $this->set('searchDate', $searchDate);
        ////////////////////////////////END - LIST ONLY SALES MOVEMENTS (easier) /////////////////////////////////////////
    }

    ///////////////////////////////////////////// END - INDEX ////////////////////////////////////////////////
    //////////////////////////////////////////// START - SAVE ///////////////////////////////////////////////

    public function save_in() {
        $id = '';
        if (isset($this->passedArgs['id'])) {
            $id = $this->passedArgs['id'];
        }
        $invWarehouses = $this->InvMovement->InvWarehouse->find('list');
        $invMovementTypes = $this->InvMovement->InvMovementType->find('list', array(
            'conditions' => array('InvMovementType.status' => 'entrada', 'InvMovementType.document' => 0, 'InvMovementType.id !=' => 4)//0 'cause don't have system document
        ));

        $this->InvMovement->recursive = -1;
        $this->request->data = $this->InvMovement->read(null, $id);
        $date = date('d/m/Y');
        //debug($this->request->data);
        $invMovementDetails = array();
        $documentState = '';
        if ($id <> null) {
            $date = date("d/m/Y", strtotime($this->request->data['InvMovement']['date'])); //$this->request->data['InvMovement']['date'];
//			$invMovementDetails = $this->_get_movements_details($id);
            $invMovementDetails = $this->_get_movements_details_date($id, $date);
            $documentState = $this->request->data['InvMovement']['lc_state'];
        }
        $this->set(compact('invMovementTypes', 'invWarehouses', 'id', 'date', 'invMovementDetails', 'documentState'));
    }

    public function save_out() {
        $id = '';
        if (isset($this->passedArgs['id'])) {
            $id = $this->passedArgs['id'];
        }
        $invWarehouses = $this->InvMovement->InvWarehouse->find('list');
        $invMovementTypes = $this->InvMovement->InvMovementType->find('list', array(
            'conditions' => array('InvMovementType.status' => 'salida', 'InvMovementType.document' => 0, 'InvMovementType.id !=' => 3)//0 'cause don't have system document
        ));

        $this->InvMovement->recursive = -1;
        $this->request->data = $this->InvMovement->read(null, $id);
        $date = date('d/m/Y');

        $invMovementDetails = array();
        $documentState = '';
        if ($id <> null) {
            $date = date("d/m/Y", strtotime($this->request->data['InvMovement']['date'])); //$this->request->data['InvMovement']['date'];
            $invMovementDetails = $this->_get_movements_details($id);
            $documentState = $this->request->data['InvMovement']['lc_state'];
        }
        $this->set(compact('invMovementTypes', 'invWarehouses', 'id', 'date', 'invMovementDetails', 'documentState'));
    }

    public function save_purchase_in() {
        //debug($purchase);
        ////////////////////////////////INICIO - VALIDAR SI ID COMPRA NO ESTA VACIO///////////////////////////////////
        $idMovement = '';
        $documentCode = '';
        if (isset($this->passedArgs['id'])) {
            $idMovement = $this->passedArgs['id'];
        }
        if (isset($this->passedArgs['document_code'])) {
            $documentCode = $this->passedArgs['document_code'];
        }

        if ($documentCode == '') {
            $this->redirect(array('action' => 'index_purchase_in'));
            //echo 'codigo vacio';
        }
        ////////////////////////////////FIN - VALIDAR SI ID COMPRA NO ESTA VACIO/////////////////////////////////////
        ////////////////////////////////INICIO - VALIDAR SI CODIGO COMPRA EXISTE///////////////////////////////////
        $this->loadModel('PurPurchase');
        $idPurchase = $this->PurPurchase->field('PurPurchase.id', array('PurPurchase.code' => $documentCode));
        if (!$idPurchase) {
            $this->redirect(array('action' => 'index_purchase_in'));
            //echo 'no existe codigo compra';
        }
        ////////////////////////////////FIN - VALIDAR SI ID COMPRA EXISTE/////////////////////////////////////
        ////////////////////////////////INICIO - DECLARAR VARIABLES///////////////////////////////////
        $arrayAux = array();
        $invWarehouses = $this->InvMovement->InvWarehouse->find('list');
        $firstWarehouse = key($invWarehouses);
        $invMovementDetails = array();
        $documentState = '';
        $id = '';
        $date = date('d/m/Y');
        ////////////////////////////////FIN - DECLARAR VARIABLES///////////////////////////////////



        if ($idMovement <> '') {//Si idMovimiento esta lleno, mostrar todo, hasta cancelados en index_in
            $this->InvMovement->recursive = -1;
            $arrayAux = $this->InvMovement->find('all', array(
                'conditions' => array(
                    'InvMovement.document_code' => $documentCode
                    , 'InvMovement.id' => $idMovement
                ),
                'fields' => array('InvMovement.id', 'InvMovement.inv_warehouse_id', 'InvMovement.inv_movement_type_id', 'InvMovement.document_code'
                    , 'InvMovement.code', 'InvMovement.date', 'InvMovement.description', 'InvMovement.lc_state'
//					,'(SELECT CASE note_code WHEN \'\' THEN \'NO\' ELSE note_code END FROM pur_purchases WHERE code = "InvMovement"."document_code" LIMIT 1 ) AS note_code'
                    , '(SELECT CASE note_code WHEN \'\' THEN \'NO\' ELSE note_code END FROM pur_purchases WHERE code = "InvMovement"."document_code" ORDER BY date_created DESC LIMIT 1)  AS note_code'
                    , '(SELECT array_to_string(array(
					SELECT name FROM inv_suppliers 
					JOIN pur_details ON pur_details.inv_supplier_id = inv_suppliers.id 
					JOIN pur_purchases ON pur_purchases.id = pur_details.pur_purchase_id 
					WHERE pur_purchases.code = "InvMovement"."document_code" GROUP BY name), \' / \')) AS sup_name'
                )
            ));
            if (count($arrayAux) == 0) {//si no existe el movimiento
                $this->redirect(array('action' => 'index_in'));
            }
        } else {//Si idMovimiento esta vacio, mostrar solo (nuevo, pendiente o aprobado) en index_save_in
            $this->InvMovement->recursive = -1;
            $arrayAux = $this->InvMovement->find('all', array(
                'conditions' => array(
                    'InvMovement.document_code' => trim($documentCode), 'InvMovement.lc_state' => array('APPROVED', 'PENDANT')
                ),
                'fields' => array('InvMovement.id', 'InvMovement.inv_warehouse_id', 'InvMovement.inv_movement_type_id', 'InvMovement.document_code'
                    , 'InvMovement.code', 'InvMovement.date', 'InvMovement.description', 'InvMovement.lc_state'
//					,'(SELECT CASE note_code WHEN \'\' THEN \'NO\' ELSE note_code END FROM pur_purchases WHERE code = "InvMovement"."document_code" LIMIT 1 ) AS note_code'
                    , '(SELECT CASE note_code WHEN \'\' THEN \'NO\' ELSE note_code END FROM pur_purchases WHERE code = "InvMovement"."document_code" ORDER BY date_created DESC LIMIT 1)  AS note_code'
                    , '(SELECT array_to_string(array(
					SELECT name FROM inv_suppliers 
					JOIN pur_details ON pur_details.inv_supplier_id = inv_suppliers.id 
					JOIN pur_purchases ON pur_purchases.id = pur_details.pur_purchase_id 
					WHERE pur_purchases.code = "InvMovement"."document_code" GROUP BY name), \' / \')) AS sup_name'
                )
            ));
        }

        //mostrar cancelados
        //mostrar activos
        ////////////////////////////////INICIO - LLENAR VISTA ///////////////////////////////////////////////
        if (count($arrayAux) > 0) { //UPDATE
            $this->request->data = $arrayAux[0];
            //debug($arrayAux[0]);
            $date = date("d/m/Y", strtotime($this->request->data['InvMovement']['date'])); //$this->request->data['InvMovement']['date'];
            $id = $this->request->data['InvMovement']['id'];
            $invMovementDetails = array(); //$this->_get_movements_details($id);
            $documentState = $this->request->data['InvMovement']['lc_state'];

            $arrPurchases = $this->_get_purchases_details($idPurchase, $firstWarehouse, 'editar'); //$firstWarehouse no se usara porque es "editar", sino doble query para stock
            $arrMovementsSaved = $this->_get_movements_details($id);
            foreach ($arrMovementsSaved as $key => $value) {
                $invMovementDetails[$key]['itemId'] = $value['itemId'];
                $invMovementDetails[$key]['item'] = $value['item'];
                //$invMovementDetails[$key]['cantidadCompra']=$arrPurchases[$key]['cantidadCompra'];
//                $invMovementDetails[$key]['stock'] = $value['stock'];   //#2014
                $invMovementDetails[$key]['cantidad'] = $value['cantidad'];
            }
        } else {//INSERT
            $invMovementDetails = $this->_get_purchases_details($idPurchase, $firstWarehouse, 'nuevo');
        }
        $this->set("noteCode", $arrayAux[0][0]['note_code']);
        $this->set("supName", $arrayAux[0][0]['sup_name']);
        $this->set(compact('invWarehouses', 'id', 'documentCode', 'date', 'invMovementDetails', 'documentState', 'idMovement'));
        ////////////////////////////////FIN - LLENAR VISTA //////////////////////////////////////////////////
    }

    public function save_sale_out() {
        //debug($purchase);
        ////////////////////////////////INICIO - VALIDAR SI ID COMPRA NO ESTA VACIO///////////////////////////////////
        $idMovement = '';
        $documentCode = '';
        if (isset($this->passedArgs['id'])) {
            $idMovement = $this->passedArgs['id'];
        }
        if (isset($this->passedArgs['document_code'])) {
            $documentCode = $this->passedArgs['document_code'];
        }

        if ($documentCode == '') {
            $this->redirect(array('action' => 'index_sale_out'));
            //echo 'codigo vacio';
        }
        ////////////////////////////////FIN - VALIDAR SI ID COMPRA NO ESTA VACIO/////////////////////////////////////
        ////////////////////////////////INICIO - VALIDAR SI CODIGO COMPRA EXISTE///////////////////////////////////
        $this->loadModel('SalSale');
        $idSale = $this->SalSale->field('SalSale.id', array('SalSale.code' => $documentCode));
        if (!$idSale) {
            $this->redirect(array('action' => 'index_sale_out'));
            //echo 'no existe codigo compra';
        }
        ////////////////////////////////FIN - VALIDAR SI ID COMPRA EXISTE/////////////////////////////////////
        ////////////////////////////////INICIO - DECLARAR VARIABLES///////////////////////////////////
        $arrayAux = array();
        $invWarehouses = $this->InvMovement->InvWarehouse->find('list');
        $firstWarehouse = key($invWarehouses);
        $invMovementDetails = array();
        $documentState = '';
        $id = '';
        $date = date('d/m/Y');
        ////////////////////////////////FIN - DECLARAR VARIABLES///////////////////////////////////



        if ($idMovement <> '') {//Si idMovimiento esta lleno, mostrar todo, hasta cancelados en index_in
            $this->InvMovement->recursive = -1;
            $arrayAux = $this->InvMovement->find('all', array(
                'conditions' => array(
                    'InvMovement.document_code' => $documentCode
                    , 'InvMovement.id' => $idMovement
                ),
                'fields' => array('InvMovement.id', 'InvMovement.inv_warehouse_id', 'InvMovement.inv_movement_type_id', 'InvMovement.document_code'
                    , 'InvMovement.code', 'InvMovement.date', 'InvMovement.description', 'InvMovement.lc_state'
//					,'(SELECT CASE note_code WHEN \'\' THEN \'NO\' ELSE note_code END FROM sal_sales WHERE code = "InvMovement"."document_code" LIMIT 1 ) AS note_code'
                    , '(SELECT CASE note_code WHEN \'\' THEN \'NO\' ELSE note_code END FROM sal_sales WHERE code = "InvMovement"."document_code" ORDER BY date_created DESC LIMIT 1)  AS note_code'
                )
            ));
            if (count($arrayAux) == 0) {//si no existe el movimiento
                $this->redirect(array('action' => 'index_in'));
            }
        } else {//Si idMovimiento esta vacio, mostrar solo (nuevo, pendiente o aprobado) en index_save_in
            $this->InvMovement->recursive = -1;
            $arrayAux = $this->InvMovement->find('all', array(
                'conditions' => array(
                    'InvMovement.document_code' => trim($documentCode), 'InvMovement.lc_state' => array('APPROVED', 'PENDANT')
                ),
                'fields' => array('InvMovement.id', 'InvMovement.inv_warehouse_id', 'InvMovement.inv_movement_type_id', 'InvMovement.document_code'
                    , 'InvMovement.code', 'InvMovement.date', 'InvMovement.description', 'InvMovement.lc_state'
//					,'(SELECT CASE note_code WHEN \'\' THEN \'NO\' ELSE note_code END FROM sal_sales WHERE code = "InvMovement"."document_code" LIMIT 1 ) AS note_code'
                    , '(SELECT CASE note_code WHEN \'\' THEN \'NO\' ELSE note_code END FROM sal_sales WHERE code = "InvMovement"."document_code" ORDER BY date_created DESC LIMIT 1)  AS note_code'
                )
            ));
        }

        ////////////////////////////////INICIO - LLENAR VISTA ///////////////////////////////////////////////
        if (count($arrayAux) > 0) { //UPDATE
            $this->request->data = $arrayAux[0];
            $date = date("d/m/Y", strtotime($this->request->data['InvMovement']['date'])); //$this->request->data['InvMovement']['date'];
            $id = $this->request->data['InvMovement']['id'];
            $invMovementDetails = array(); //$this->_get_movements_details($id);
            $documentState = $this->request->data['InvMovement']['lc_state'];

            $arrSales = $this->_get_sales_details($idSale, $firstWarehouse, 'editar'); //$firstWarehouse no se usara porque es "editar", sino doble query para stock
            $arrMovementsSaved = $this->_get_movements_details($id);
            foreach ($arrMovementsSaved as $key => $value) {
                $invMovementDetails[$key]['itemId'] = $value['itemId'];
                $invMovementDetails[$key]['item'] = $value['item'];
//				$invMovementDetails[$key]['cantidadVenta']=$arrSales[$key]['cantidadVenta'];
//                $invMovementDetails[$key]['stock'] = $value['stock'];
                $invMovementDetails[$key]['cantidad'] = $value['cantidad'];
            }
        } else {//INSERT
            $invMovementDetails = $this->_get_sales_details($idSale, $firstWarehouse, 'nuevo');
        }

        $this->set("noteCode", $arrayAux[0][0]['note_code']);
        $this->set(compact('invWarehouses', 'id', 'documentCode', 'date', 'invMovementDetails', 'documentState', 'idMovement'));
        ////////////////////////////////FIN - LLENAR VISTA //////////////////////////////////////////////////
    }

    public function save_warehouses_transfer() {
        /////////////////////////////////////////START - VARIABLES DECLARATION///////////////////
        $warehouseIn = '';
        $warehouseOut = '';
        $movementIdIn = '';
        $movementIdOut = '';
        $date = date('d/m/Y');
        $invMovementDetailsOut = array();
        $invMovementDetailsIn = array();
        $documentCode = '';
        $documentState = '';
        ///////////////////////////////////////////END - VARIABLES DECLARATION///////////////////
        /////////////////////////////////////////START - VIEW VALIDATION FOR MODIFY///////////////////
        if (isset($this->passedArgs['document_code'])) {
            $documentCode = $this->passedArgs['document_code'];
            $movementIdIn = $this->InvMovement->field('InvMovement.id', array(
                'InvMovement.document_code' => $documentCode,
                'InvMovement.inv_movement_type_id =' => 4//In Destination
            ));
            $movementIdOut = $this->InvMovement->field('InvMovement.id', array(
                'InvMovement.document_code' => $documentCode,
                'InvMovement.inv_movement_type_id =' => 3//Out Origin
            ));
            $url = '';
            if ($movementIdIn == '' OR $movementIdOut == '') {
                if (isset($this->passedArgs['origin'])) {
                    if ($this->passedArgs['origin'] == 'in') {
                        $url = array('action' => 'index_in');
                    } elseif ($this->passedArgs['origin'] == 'out') {
                        $url = array('action' => 'index_out');
                    }
                    $this->redirect($url);
                } else {
                    $this->redirect(array('action' => 'index_in'));
                }
            }

            $warehouseIn = $this->InvMovement->field('InvMovement.inv_warehouse_id', array('InvMovement.id' => $movementIdIn));
            $this->InvMovement->recursive = -1;
            $this->request->data = $this->InvMovement->read(null, $movementIdOut);
            $date = date("d/m/Y", strtotime($this->request->data['InvMovement']['date']));
            //$warehouseOut = $this->InvMovement->field('InvMovement.inv_warehouse_id', array('InvMovement.id'=>$movementIdOut));
            $warehouseOut = $this->request->data['InvMovement']['inv_warehouse_id'];
            $documentState = $this->request->data['InvMovement']['lc_state'];
            $invMovementDetailsOut = $this->_get_movements_details($movementIdOut);
            $invMovementDetailsIn = $this->_get_movements_details($movementIdIn);
        }
        ///////////////////////////////////////////END - VIEW VALIDATION FOR MODIFY///////////////////
        $warehouses = $this->InvMovement->InvWarehouse->find('list');



        $this->set(compact('warehouses', 'warehouseIn', 'warehouseOut', 'movementIdOut', 'date', 'invMovementDetailsOut', 'invMovementDetailsIn', 'documentState', 'documentCode'));
    }

    public function index_warehouses_transfer() {

        ///////////////////////////////////////START - CREATING VARIABLES//////////////////////////////////////
        $filters = array();
        $document_code = '';
        $searchDate = "";
        $period = $this->Session->read('Period.name');
        ///////////////////////////////////////END - CREATING VARIABLES////////////////////////////////////////
        ////////////////////////////START - WHEN SEARCH IS SEND THROUGH POST//////////////////////////////////////
        if ($this->request->is("post")) {
            $url = array('action' => 'index_warehouses_transfer');
            $parameters = array();
            $empty = 0;
            if (isset($this->request->data['InvMovement']['document_code']) && $this->request->data['InvMovement']['document_code']) {
                $parameters['document_code'] = trim(strip_tags($this->request->data['InvMovement']['document_code']));
            } else {
                $empty++;
            }
            if (isset($this->request->data['InvMovement']['searchDate']) && $this->request->data['InvMovement']['searchDate']) {
                $parameters['searchDate'] = trim(strip_tags(str_replace("/", "", $this->request->data['InvMovement']['searchDate'])));
            } else {
                $empty++;
            }
            if ($empty == 2) {
                $parameters['search'] = 'empty';
            } else {
                $parameters['search'] = 'yes';
            }
            $this->redirect(array_merge($url, $parameters));
        }
        ////////////////////////////END - WHEN SEARCH IS SEND THROUGH POST//////////////////////////////////////
        ////////////////////////////START - SETTING URL FILTERS//////////////////////////////////////
        if (isset($this->passedArgs['document_code'])) {
            $filters['InvMovement.document_code LIKE'] = '%' . strtoupper($this->passedArgs['document_code']) . '%';
            $document_code = $this->passedArgs['document_code'];
        }
        if (isset($this->passedArgs['searchDate'])) {
            $catchDate = $this->passedArgs['searchDate'];
            $finalDate = substr($catchDate, 0, 2) . "/" . substr($catchDate, 2, 2) . "/" . substr($catchDate, 4, 4);
            $filters['InvMovement.date'] = $finalDate;
            $searchDate = $finalDate;
        }
        ////////////////////////////END - SETTING URL FILTERS//////////////////////////////////////
        ////////////////////////////START - SETTING PAGINATING VARIABLES//////////////////////////////////////
        $this->paginate = array(
            'conditions' => array(
                //"InvMovement.lc_state !="=>"LOGIC_DELETED",
                "NOT" => array("InvMovement.lc_state" => array("LOGIC_DELETED", "DRAFT")),
                "to_char(InvMovement.date,'YYYY')" => $period,
                "InvMovement.inv_movement_type_id" => 3, //out
                $filters
            ),
            'recursive' => 0,
            'fields' => array('InvMovement.id', 'InvMovement.document_code', 'InvMovement.date', 'InvMovement.inv_warehouse_id', 'InvWarehouse.name', 'InvMovement.lc_state'),
            'order' => array('InvMovement.id' => 'desc'),
            'limit' => 15,
        );

        $pagination = $this->paginate('InvMovement');
        //debug($pagination);
        $paginatedDocumentCodes = array();
        for ($i = 0; $i < count($pagination); $i++) {
            $paginatedDocumentCodes[$i] = $pagination[$i]['InvMovement']['document_code'];
        }
        $warehouseDestination = $this->InvMovement->find('all', array(
            'conditions' => array(
                //'InvMovement.lc_state !='=>'LOGIC_DELETED',
                "NOT" => array("InvMovement.lc_state" => array("LOGIC_DELETED", "DRAFT")),
                'InvMovement.document_code' => $paginatedDocumentCodes,
                'InvMovement.inv_movement_type_id' => 4, //in
                $filters
            ),
            'recursive' => 0,
            'fields' => array('InvMovement.id', 'InvMovement.inv_warehouse_id', 'InvWarehouse.name', 'InvMovement.document_code')
        ));
        ////////////////////////////END - SETTING PAGINATING VARIABLES//////////////////////////////////////
        //debug($warehouseDestination);
        ////////////////////////START - SETTING PAGINATE AND OTHER VARIABLES TO THE VIEW//////////////////
        $this->set('invMovements', $pagination);
        $this->set('document_code', $document_code);
        $this->set('warehouseDestination', $warehouseDestination);
        $this->set('searchDate', $searchDate);
        ////////////////////////END - SETTING PAGINATE AND OTHER VARIABLES TO THE VIEW//////////////////
    }

    //////////////////////////////////////////// END - SAVE /////////////////////////////////////////////////
    //////////////////////////////////////////// START - AJAX ///////////////////////////////////////////////

    public function ajax_initiate_modal_add_item_in() {
        if ($this->RequestHandler->isAjax()) {

            $itemsAlreadySaved = $this->request->data['itemsAlreadySaved'];
            $warehouse = $this->request->data['warehouse']; //if it's warehouse_transfer is OUT
            $warehouse2 = $this->request->data['warehouse2']; //if it's warehouse_transfer is IN
            $transfer = $this->request->data['transfer'];

            $items = $this->InvMovement->InvMovementDetail->InvItem->find('list', array(
                'conditions' => array(
                    'NOT' => array('InvItem.id' => $itemsAlreadySaved)
                ),
                'recursive' => -1,
                'order' => array('InvItem.code')
            ));
            //debug($items);

            $firstItemListed = key($items);
            /////////////////for new stock method 
//            $stocks = $this->_get_stocks($firstItemListed, $warehouse); //get all the stocks #2014
            //debug($stocks);
            ///////////////////
            //$stock = $this->_find_stock($firstItemListed, $warehouse); //if it's warehouse_transfer is OUT
//            $stock = $this->_find_item_stock($stocks, $firstItemListed); #2014
//            $stock2 = '';
//            if ($transfer == 'warehouses_transfer') {     //all #2014
//                //debug($warehouse2);
//                //debug($firstItemListed);
//                $stocks2 = $this->_get_stocks($firstItemListed, $warehouse2);
//                //debug($stocks2);
//                //$stock2 = $this->_find_stock($firstItemListed, $warehouse2);//if it's warehouse_transfer is IN	
//                $stock2 = $this->_find_item_stock($stocks2, $firstItemListed);
//            }
            //debug($stock2);
            $this->set(compact('items'/*, 'stock', 'stock2'*/, 'transfer')); //#2014
        }
    }

    public function ajax_update_stock_modal() {
        if ($this->RequestHandler->isAjax()) {
            $item = $this->request->data['item'];
            $warehouse = $this->request->data['warehouse']; //if it's warehouse_transfer is OUT
            $warehouse2 = $this->request->data['warehouse2']; //if it's warehouse_transfer is IN
            $transfer = $this->request->data['transfer'];

            /////////////////for new stock method 
            $stocks = $this->_get_stocks($item, $warehouse); //get all the stocks
            ///////////////////
            //$stock = $this->_find_stock($item, $warehouse);//if it's warehouse_transfer is OUT
            $stock = $this->_find_item_stock($stocks, $item);
            $stock2 = '';
            if ($transfer == 'warehouses_transfer') {
                $stocks2 = $this->_get_stocks($item, $warehouse2); //get all the stocks
                //$stock2 = $this->_find_stock($item, $warehouse2);//if it's warehouse_transfer is IN	
                $stock2 = $this->_find_item_stock($stocks2, $item);
            }

            $this->set(compact('stock', 'stock2', 'transfer'));
        }
    }

    public function ajax_save_movement() {
        if ($this->RequestHandler->isAjax()) {
            $arrayMovement = array();
            ////////////////////////////////////////////START - RECIEVE AJAX////////////////////////////////////////////////////////
            //Movement
            $movementId = $this->request->data['movementId'];
            $date = $this->request->data['date'];
            $warehouseId = $this->request->data['warehouseId'];
            $description = $this->request->data['description'];
            $code = $this->request->data['code'];
            $documentCode = '';
            If (isset($this->request->data['documentCode'])) {
                $documentCode = $this->request->data['documentCode'];
            }
            $warehouseId2 = $this->request->data['warehouseId2'];
            //$movementTypeId = 0;
            if (isset($this->request->data['movementTypeId'])) {
                //$movementTypeId = $this->request->data['movementTypeId'];
                $arrayMovement['inv_movement_type_id'] = $this->request->data['movementTypeId'];
            }

            //Movement Details
            $itemId = $this->request->data['itemId'];
            $quantity = $this->request->data['quantity'];
            //For making algorithm
            $ACTION = $this->request->data['ACTION'];
            $OPERATION = $this->request->data['OPERATION'];
            $STATE = $this->request->data['STATE']; //also for Movement
            //For validate before approve OUT or cancelled IN
            $arrayForValidate = array();
            if (isset($this->request->data['arrayForValidate'])) {
                $arrayForValidate = $this->request->data['arrayForValidate'];
            }
//			print_r($arrayForValidate);
            //Internal variables
            $error = 0;
            $movementDestinationId = 0;
            $code2 = '';
            ////////////////////////////////////////////END - RECIEVE AJAX////////////////////////////////////////////////////////
            ////////////////////////////////////////////////START - SET DATA/////////////////////////////////////////////////////
            //$arrayMovement = array('date'=>$date, 'inv_warehouse_id'=>$warehouseId, 'description'=>$description, 'lc_state'=>$STATE);
            $arrayMovement['date'] = $date;
            $arrayMovement['inv_warehouse_id'] = $warehouseId;
            $arrayMovement['description'] = $description;
            $arrayMovement['lc_state'] = $STATE;

            if ($ACTION == 'save_warehouses_transfer') {
                $arrayMovementDestination = $arrayMovement; //IN(destination),OUT(origin)
                $arrayMovementDestination['inv_warehouse_id'] = $warehouseId2;
            }

            $arrayMovementDetails = array('inv_item_id' => $itemId, 'quantity' => $quantity);

            //INSERT OR UPDATE
            if ($movementId == '') {//INSERT
                //$code = 'BORRADOR'.date('Y').'-'.date('mdHis');
                switch ($ACTION) {
                    case 'save_in':
                        $arrayMovement['document_code'] = 'NO';
                        //$arrayMovement['inv_movement_type_id']=$movementTypeId;
                        $code = $this->_generate_code('ENT');
                        $arrayMovement['code'] = $code;
                        break;
                    case 'save_purchase_in':
                        $arrayMovement['document_code'] = $documentCode;
                        $arrayMovement['inv_movement_type_id'] = 1;
                        $code = $this->_generate_code('ENT');
                        $arrayMovement['code'] = $code;
                        $arrayMovementDetails = $arrayForValidate;
                        break;
                    case 'save_out':
                        $arrayMovement['document_code'] = 'NO';
                        //$arrayMovement['inv_movement_type_id']=$movementTypeId;
                        $code = $this->_generate_code('SAL');
                        $arrayMovement['code'] = $code;
                        break;
                    case 'save_sale_out':
                        $arrayMovement['document_code'] = $documentCode;
                        $arrayMovement['inv_movement_type_id'] = 2;
                        $code = $this->_generate_code('SAL');
                        $arrayMovement['code'] = $code;
                        $arrayMovementDetails = $arrayForValidate;
                        break;
                    case 'save_warehouses_transfer':
                        $code = $this->_generate_code('SAL');
                        $arrayMovement['code'] = $code;

                        $code2 = $this->_generate_code('ENT');
                        $arrayMovementDestination['code'] = $code2;

                        $documentCode = $this->_generate_document_code_transfer('TRA');
                        $arrayMovement['document_code'] = $documentCode;
                        $arrayMovementDestination['document_code'] = $documentCode;

                        $arrayMovement['inv_movement_type_id'] = 3; //Origin/Out
                        $arrayMovementDestination['inv_movement_type_id'] = 4; //Destination/In

                        $dataOut = array('InvMovement' => $arrayMovement, 'InvMovementDetail' => array($arrayMovementDetails));
                        $dataIn = array('InvMovement' => $arrayMovementDestination, 'InvMovementDetail' => array($arrayMovementDetails));
                        $dataTransfer = array($dataIn, $dataOut);

                        $tokenTransfer = 'INSERT';
                        break;
                }
                if ($code == 'error') {
                    $error++;
                }
                if ($code2 == 'error') {
                    $error++;
                }
                if ($documentCode == 'error') {
                    $error++;
                }
            } else {//UPDATE
                $arrayMovement['id'] = $movementId;
                if ($ACTION == 'save_warehouses_transfer') {
                    try {
                        $movementDestinationId = $this->InvMovement->field('InvMovement.id', array(
                            'InvMovement.document_code' => $documentCode,
                            'InvMovement.id !=' => $movementId
                        ));
                    } catch (Exception $e) { //IF ERROR
                        $error++;
                    }
                    $tokenTransfer = 'UPDATE';
                }
                $arrayMovementDestination['id'] = $movementDestinationId;
                $dataOut = array('InvMovement' => $arrayMovement);
                $dataIn = array('InvMovement' => $arrayMovementDestination);
                $movementDetails = array('InvMovementDetail' => $arrayMovementDetails);
                $dataTransfer = array($dataIn, $dataOut, $movementDetails);
            }


            if ($ACTION <> 'save_warehouses_transfer') {
                $dataMovement = array('InvMovement' => $arrayMovement);
                $dataMovementDetail = array('InvMovementDetail' => $arrayMovementDetails);
            }
            ////////////////////////////////////////////////END - SET DATA//////////////////////////////////////////////////////
            ////////////////////////////////////////////START- CORE SAVE////////////////////////////////////////////////////////
            if ($error == 0) {
                /////////////////////START - SAVE/////////////////////////////	
                if ($ACTION <> 'save_warehouses_transfer') {
                    $res = $this->InvMovement->saveMovement($dataMovement, $dataMovementDetail, $OPERATION, $ACTION, $arrayForValidate, $code);
                } else {
                    $res = $this->InvMovement->saveMovementTransfer($dataTransfer, $OPERATION, $tokenTransfer, $arrayForValidate, $documentCode);
                }

                switch ($res[0]) {
                    case 'SUCCESS':
                        echo $res[1];
                        break;
                    case 'VALIDATION':
                        echo 'VALIDATION|' . $res[1];
                        break;
                    case 'ERROR':
                        echo 'ERROR|onSaving';
                        break;
                }

                /////////////////////END - SAVE////////////////////////////////	
            } else {
                echo 'ERROR|onGeneratingParameters';
            }
            ////////////////////////////////////////////END-CORE SAVE////////////////////////////////////////////////////////
        }
    }

    public function ajax_update_multiple_stocks() {
        if ($this->RequestHandler->isAjax()) {
            ////////////////////////////////////////////INICIO-CAPTURAR AJAX/////////////////////////////////////////////////////
            $arrayItemsDetails = $this->request->data['arrayItemsDetails'];
            $warehouse = $this->request->data['warehouse'];
            ////////////////////////////////////////////FIN-CAPTURAR AJAX////////////////////////////////////////////////////////
            ////////////////////////////////////////////INICIO-CADENA ITEMS STOCKS///////////////////////////////////////////////
            $strItemsStock = $this->_createStringItemsStocksUpdated($arrayItemsDetails, $warehouse);
            echo $strItemsStock;
        }
    }

    public function ajax_logic_delete() {
        if ($this->RequestHandler->isAjax()) {
            $code = $this->request->data['code'];
            $type = $this->request->data['type'];
            if ($type == 'transfer') {
                $conditions = array('InvMovement.document_code' => $code);
            } else {
                $conditions = array('InvMovement.code' => $code);
            }

            $invMovementIds = $this->InvMovement->find('list', array(
                'conditions' => $conditions,
                'fields' => array('InvMovement.id', 'InvMovement.id')
            ));

            if (count($invMovementIds) == 0) {
                echo 'error-movementNotFound';
            } else {
                if ($this->InvMovement->fnLogicDelete($invMovementIds)) {
                    echo 'success';
                }
            }
        }
    }

    //////////////////////////////////////////// END - AJAX /////////////////////////////////////////////////
    //////////////////////////////////////////// START - PRIVATE ///////////////////////////////////////////////
    private function _get_stocks($items, $warehouse, $limitDate = '', $dateOperator = '<=') {
        $this->InvMovement->InvMovementDetail->unbindModel(array('belongsTo' => array('InvItem')));
        $this->InvMovement->InvMovementDetail->bindModel(array(
            'hasOne' => array(
                'InvMovementType' => array(
                    'foreignKey' => false,
                    'conditions' => array('InvMovement.inv_movement_type_id = InvMovementType.id')
                )
            )
        ));
        $dateRanges = array();
        if ($limitDate <> '') {
            $dateRanges = array('InvMovement.date ' . $dateOperator => $limitDate);
        }

        $movements = $this->InvMovement->InvMovementDetail->find('all', array(
            'fields' => array(
                "InvMovementDetail.inv_item_id",
                "(SUM(CASE WHEN \"InvMovementType\".\"status\" = 'entrada' AND \"InvMovement\".\"lc_state\" = 'APPROVED' THEN \"InvMovementDetail\".\"quantity\" ELSE 0 END))-
				(SUM(CASE WHEN \"InvMovementType\".\"status\" = 'salida' AND \"InvMovement\".\"lc_state\" = 'APPROVED' THEN \"InvMovementDetail\".\"quantity\" ELSE 0 END)) AS stock"
            ),
            'conditions' => array(
                'InvMovement.inv_warehouse_id' => $warehouse,
                'InvMovementDetail.inv_item_id' => $items,
                $dateRanges
            ),
            'group' => array('InvMovementDetail.inv_item_id'),
            'order' => array('InvMovementDetail.inv_item_id')
        ));

        return $movements;
    }

    private function _find_item_stock($stocks, $item) {
        foreach ($stocks as $stock) {//find required stock inside stocks array 
            if ($item == $stock['InvMovementDetail']['inv_item_id']) {
                return $stock[0]['stock'];
            }
        }
        //this fixes in case there isn't any item inside movement_details yet with a determinated warehouse
        return 0;
    }

    private function _get_movements_details_date($idMovement, $date) {
        $movementDetails = $this->InvMovement->InvMovementDetail->find('all', array(
            'conditions' => array('InvMovementDetail.inv_movement_id' => $idMovement),
            'fields' => array('InvItem.name', 'InvItem.code', 'InvMovementDetail.quantity', 'InvItem.id', 'InvMovement.inv_warehouse_id'),
            'order' => array('InvItem.code')
        ));
        ///////////for new stock method
        $items = array();
        foreach ($movementDetails as $value) {//get a clean items arrays
            $items[$value['InvItem']['id']] = $value['InvItem']['id'];
        }
        $stocks = $this->_get_stocks($items, $movementDetails[0]['InvMovement']['inv_warehouse_id'], $date, '<'); //get all the stocks
        ///////////////////
        $formatedMovementDetails = array();
        foreach ($movementDetails as $key => $value) {
            $formatedMovementDetails[$key] = array(
                'itemId' => $value['InvItem']['id'],
                'item' => '[ ' . $value['InvItem']['code'] . ' ] ' . $value['InvItem']['name'],
                //'stock'=> $this->_find_stock($value['InvItem']['id'], $value['InvMovement']['inv_warehouse_id']),//llamar funcion
//                'stock' => $this->_find_item_stock($stocks, $value['InvItem']['id']),  //#2014
                'cantidad' => $value['InvMovementDetail']['quantity']//llamar cantidad
            );
        }
        return $formatedMovementDetails;
    }

    private function _get_movements_details($idMovement) {
        $movementDetails = $this->InvMovement->InvMovementDetail->find('all', array(
            'conditions' => array('InvMovementDetail.inv_movement_id' => $idMovement),
            'fields' => array('InvItem.name', 'InvItem.code', 'InvMovementDetail.quantity', 'InvItem.id', 'InvMovement.inv_warehouse_id'),
            'order' => array('InvItem.code')
        ));
        ///////////for new stock method
        $items = array();
        foreach ($movementDetails as $value) {//get a clean items arrays
            $items[$value['InvItem']['id']] = $value['InvItem']['id'];
        }
//        $stocks = $this->_get_stocks($items, $movementDetails[0]['InvMovement']['inv_warehouse_id']); //get all the stocks   //#2014
        ///////////////////
        $formatedMovementDetails = array();
        foreach ($movementDetails as $key => $value) {
            $formatedMovementDetails[$key] = array(
                'itemId' => $value['InvItem']['id'],
                'item' => '[ ' . $value['InvItem']['code'] . ' ] ' . $value['InvItem']['name'],
                //'stock'=> $this->_find_stock($value['InvItem']['id'], $value['InvMovement']['inv_warehouse_id']),//llamar funcion
//                'stock' => $this->_find_item_stock($stocks, $value['InvItem']['id']),   //#2014
                'cantidad' => $value['InvMovementDetail']['quantity']//llamar cantidad
            );
        }
        return $formatedMovementDetails;
    }

    private function _get_movements_details_without_stock($idMovement) {
        $movementDetails = $this->InvMovement->InvMovementDetail->find('all', array(
            'conditions' => array('InvMovementDetail.inv_movement_id' => $idMovement),
            'fields' => array('InvItem.name', 'InvItem.code', 'InvMovementDetail.quantity', 'InvItem.id', 'InvMovement.inv_warehouse_id')
            , 'order' => array('InvItem.code')
        ));
        $formatedMovementDetails = array();
        foreach ($movementDetails as $key => $value) {
            $formatedMovementDetails[$key] = array(
                'itemId' => $value['InvItem']['id'],
                'item' => '[ ' . $value['InvItem']['code'] . ' ] ' . $value['InvItem']['name'],
                'cantidad' => $value['InvMovementDetail']['quantity']//llamar cantidad
            );
        }

        return $formatedMovementDetails;
    }

    private function _get_purchases_details($idPurchase, $idWarehouse, $state) {
        $stock = 0;
        $this->loadModel('PurDetail');
        $purchaseDetails = $this->PurDetail->find('all', array(
            'conditions' => array('PurDetail.pur_purchase_id' => $idPurchase),
            'fields' => array('InvItem.name', 'InvItem.code', 'PurDetail.quantity', 'InvItem.id')
        ));
        /////////////////for new stock method
        $items = array();
        foreach ($purchaseDetails as $value) {//get a clean items arrays
            $items[$value['InvItem']['id']] = $value['InvItem']['id'];
        }
        $stocks = $this->_get_stocks($items, $idWarehouse); //get all the stocks
        ///////////////////
        $formatedPurchaseDetails = array();
        foreach ($purchaseDetails as $key => $value) {

            if ($state == 'nuevo') {
                //$stock = $this->_find_stock($value['InvItem']['id'], $idWarehouse);
                $stock = $this->_find_item_stock($stocks, $value['InvItem']['id']);
            }
            $formatedPurchaseDetails[$key] = array(
                'itemId' => $value['InvItem']['id'],
                'item' => '[ ' . $value['InvItem']['code'] . ' ] ' . $value['InvItem']['name'],
                'cantidadCompra' => $value['PurDetail']['quantity'],
                'stock' => $stock, //llamar funcion
                'cantidad' => $value['PurDetail']['quantity']
            );
        }
        //debug($formatedPurchaseDetails);
        return $formatedPurchaseDetails;
    }

    private function _get_sales_details($idSale, $idWarehouse, $state) {
        $stock = 0;
        $this->loadModel('SalDetail');
        $saleDetails = $this->SalDetail->find('all', array(
            'conditions' => array('SalDetail.sal_sale_id' => $idSale),
            'fields' => array('InvItem.name', 'InvItem.code', 'SalDetail.quantity', 'InvItem.id')
        ));
        /////////////////for new stock method
        $items = array();
        foreach ($saleDetails as $value) {//get a clean items arrays
            $items[$value['InvItem']['id']] = $value['InvItem']['id'];
        }
        $stocks = $this->_get_stocks($items, $idWarehouse); //get all the stocks
        ///////////////////
        $formatedSaleDetails = array();
        foreach ($saleDetails as $key => $value) {

            if ($state == 'nuevo') {
                //$stock = $this->_find_stock($value['InvItem']['id'], $idWarehouse);
                $stock = $this->_find_item_stock($stocks, $value['InvItem']['id']);
            }
            $formatedSaleDetails[$key] = array(
                'itemId' => $value['InvItem']['id'],
                'item' => '[ ' . $value['InvItem']['code'] . ' ] ' . $value['InvItem']['name'],
                'cantidadVenta' => $value['SalDetail']['quantity'],
                'stock' => $stock, //llamar funcion
                'cantidad' => $value['SalDetail']['quantity']
            );
        }
        //debug($formatedPurchaseDetails);
        return $formatedSaleDetails;
    }

    private function _generate_code($keyword) {
        $period = $this->Session->read('Period.name');
        $movementType = '';
        if ($keyword == 'ENT') {
            $movementType = 'entrada';
        }
        if ($keyword == 'SAL') {
            $movementType = 'salida';
        }
        if ($period <> '') {
            try {
                $movements = $this->InvMovement->find('count', array(
                    'conditions' => array('InvMovementType.status' => $movementType, 'InvMovement.lc_state !=' => 'DRAFT')
                ));
            } catch (Exception $e) {
                return 'error';
            }
        } else {
            return 'error';
        }

        $quantity = $movements + 1;
        $code = $keyword . '-' . $period . '-' . $quantity;
        return $code;
    }

    private function _generate_document_code_transfer($keyword) {
        $period = $this->Session->read('Period.name');
        $idMovementType = 0;
        if ($keyword == 'TRA') {
            $idMovementType = 3;
        }
        if ($period <> '' AND $idMovementType <> 0) {
            try {
                $transfers = $this->InvMovement->find('count', array('conditions' => array('InvMovement.inv_movement_type_id' => $idMovementType)));
            } catch (Exception $e) {
                return 'error';
            }
        } else {
            return 'error';
        }

        $quantity = $transfers + 1;
        $code = $keyword . '-' . $period . '-' . $quantity;
        return $code;
    }

    private function _validateItemsStocksOut($arrayItemsDetails, $warehouse) {
        $strItemsStockErrorSuccess = '';
        /////////////////for new stock method 
        $items = array();
        foreach ($arrayItemsDetails as $value) {//get a clean items arrays
            $items[$value['inv_item_id']] = $value['inv_item_id'];
        }
        $stocks = $this->_get_stocks($items, $warehouse); //get all the stocks
        ///////////////////
        $cont = 0;
        for ($i = 0; $i < count($arrayItemsDetails); $i++) {
            //$updatedStock = $this->_find_stock($arrayItemsDetails[$i]['inv_item_id'], $warehouse);
            $updatedStock = $this->_find_item_stock($stocks, $arrayItemsDetails[$i]['inv_item_id']);
            if ($updatedStock < $arrayItemsDetails[$i]['quantity']) {
                $strItemsStockErrorSuccess .= $arrayItemsDetails[$i]['inv_item_id'] . '=>error:' . $updatedStock . ','; //error
                $cont++;
            } else {
                $strItemsStockErrorSuccess .= $arrayItemsDetails[$i]['inv_item_id'] . '=>success:' . $updatedStock . ','; //success
            }
        }
        return array('error' => $cont, 'itemsStocks' => $strItemsStockErrorSuccess);
    }

    private function _createStringItemsStocksUpdated($arrayItemsDetails, $idWarehouse) {
        ////////////////////////////////////////////INICIO-CREAR CADENA ITEMS STOCK ACUTALIZADOS//////////////////////////////
        $strItemsStock = '';
        /////////////////for new stock method 
        $items = array();
        foreach ($arrayItemsDetails as $value) {//get a clean items arrays
            $items[$value['inv_item_id']] = $value['inv_item_id'];
        }
        $stocks = $this->_get_stocks($items, $idWarehouse); //get all the stocks
        ///////////////////
        for ($i = 0; $i < count($arrayItemsDetails); $i++) {
            //$updatedStock = $this->_find_stock($arrayItemsDetails[$i]['inv_item_id'], $idWarehouse);
            $updatedStock = $this->_find_item_stock($stocks, $arrayItemsDetails[$i]['inv_item_id']);
            $strItemsStock .= $arrayItemsDetails[$i]['inv_item_id'] . '=>' . $updatedStock . ',';
        }
        ////////////////////////////////////////////FIN-CREAR CADENA ITEMS STOCK ACUTALIZADOS/////////////////////////////////
        return $strItemsStock;
    }

    //////////////////////////////////////////// END - PRIVATE /////////////////////////////////////////////////
    //*******************************************************************************************************//
    /////////////////////////////////////////// END - CLASS ///////////////////////////////////////////////
    //*******************************************************************************************************//
}
