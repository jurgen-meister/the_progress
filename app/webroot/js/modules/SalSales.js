$(document).ready(function(){
//START SCRIPT

//	var globalPeriod = $('#globalPeriod').text(); // this value is obtained from the main template AND from MainBittion.css
	
//	var arrayItemsAlreadySaved = []; 
	var arrayItemsWarehousesAlreadySaved = []; 
	var itemsCounter = 0;
//	var arrayWarehouseItemsAlreadySaved = []; 
	startEventsWhenExistsItems();
	
	var arrayPaysAlreadySaved = []; 
	startEventsWhenExistsPays();
	
//	var payDebt = 0;
//	startEventsWhenExistsDebts();
	
	//When exist items of warehouses, it starts its events and fills arrayItemsAlreadySaved
	function startEventsWhenExistsItems() {
		var arrayAux = [];
		arrayAux = getItemsDetails();
//		if(urlAction === 'save_invoice'){
			if (arrayAux[0] !== 0) {
				for (var i = 0; i < arrayAux.length; i++) {
					arrayItemsWarehousesAlreadySaved[i] = arrayAux[i]['inv_item_id']+'w'+arrayAux[i]['inv_warehouse_id'];
					createEventClickEditItemButton(arrayAux[i]['inv_item_id'],arrayAux[i]['inv_warehouse_id']);
					createEventClickDistribItemButton(arrayAux[i]['inv_item_id'],arrayAux[i]['inv_warehouse_id']);
					createEventClickDeleteItemButton(arrayAux[i]['inv_item_id'],arrayAux[i]['inv_warehouse_id']);	
					itemsCounter = itemsCounter + 1;  //like this cause iteration something++ apparently not supported by javascript, gave me NaN error
				}
			}
//		}else{
//			if (arrayAux[0] !== 0) {
//				for (var i = 0; i < arrayAux.length; i++) {
//	//				arrayItemsAlreadySaved[i] = arrayAux[i]['inv_item_id'];
//	//				arrayWarehouseItemsAlreadySaved[i] = arrayAux[i]['inv_warehouse_id'];
//					arrayItemsWarehousesAlreadySaved[i] = arrayAux[i]['inv_item_id']+'w'+arrayAux[i]['inv_warehouse_id'];
//					createEventClickEditItemButton(arrayAux[i]['inv_item_id'],arrayAux[i]['inv_warehouse_id']);
//					createEventClickDeleteItemButton(arrayAux[i]['inv_item_id'],arrayAux[i]['inv_warehouse_id']);	
//					itemsCounter = itemsCounter + 1;  //like this cause iteration something++ apparently not supported by javascript, gave me NaN error
//				}
//			}
//		}
		
	}
	
//	function startEventsWhenExistsDebts(){		
//		payDebt =0;
//		var discount = $('#txtDiscount').val();
//		var	payPaid = getTotalPay();
//		var payTotal = getTotal();
//		var payTotalPlusDisc = Number(payTotal) - ((Number(payTotal) * Number(discount))/100);
//		var payDebtDirt = Number(payTotalPlusDisc) - Number(payPaid);
//		payDebt = parseFloat(payDebtDirt).toFixed(2);
//		return payDebt;
//	}
	
	//gets a list of the item ids in the document details
//	function itemsListWhenExistsItems(){
//		var arrayAux = [];
//		arrayItemsAlreadySaved = [];
//		arrayAux = getItemsDetails();
//		if(arrayAux[0] !== 0){
//			for(var i=0; i< arrayAux.length; i++){
//				 arrayItemsAlreadySaved[i] = arrayAux[i]['inv_item_id'];
//			}
//		}
//		if(arrayItemsAlreadySaved.length === 0){  //For fix undefined index
//			arrayItemsAlreadySaved = [0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
//		}
//		
//		return arrayItemsAlreadySaved; //NOT SURE TO PUT THIS LINE	
//	}
	
	//gets a list of the warehouse ids in the document details
//	function warehouseListWhenExistsItems(){
//		var arrayAux = [];
//		arrayWarehouseItemsAlreadySaved = [];
//		arrayAux = getItemsDetails();
//		if(arrayAux[0] !== 0){
//			for(var i=0; i< arrayAux.length; i++){
//				 arrayWarehouseItemsAlreadySaved[i] = arrayAux[i]['inv_warehouse_id'];
//			}
//		}
//		if(arrayWarehouseItemsAlreadySaved.length === 0){  //For fix undefined index
//			arrayWarehouseItemsAlreadySaved = [0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
//		}
//		
//		return arrayWarehouseItemsAlreadySaved; //NOT SURE TO PUT THIS LINE	
//	}
	
//	//When exist items, it starts its events and fills arrayItemsAlreadySaved
//	function startEventsWhenExistsItems(){
//		var arrayAux = [];
//		arrayAux = getItemsDetails();
//		if(arrayAux[0] !== 0){
//			for(var i=0; i< arrayAux.length; i++){
//				arrayItemsAlreadySaved[i] = arrayAux[i]['inv_item_id'];
//				arrayWarehouseItemsAlreadySaved[i] = arrayAux[i]['inv_warehouse_id'];
//				createEventClickEditItemButton(arrayAux[i]['inv_item_id'],arrayAux[i]['inv_warehouse_id']);
//				createEventClickDeleteItemButton(arrayAux[i]['inv_item_id'],arrayAux[i]['inv_warehouse_id']);	
//				itemsCounter = itemsCounter + 1;  //like this cause iteration something++ apparently not supported by javascript, gave me NaN error							 
//			}
//		}
//	}
	
	//When exist pays, it starts its events and fills arrayPaysAlreadySaved
	function startEventsWhenExistsPays(){		/*STANDBY*/
		var arrayAux = [];
		arrayAux = getPaysDetails();
		if(arrayAux[0] !== 0){
			for(var i=0; i< arrayAux.length; i++){
				 arrayPaysAlreadySaved[i] = arrayAux[i]['date'];
				 createEventClickEditPayButton(arrayAux[i]['date']);
				 createEventClickDeletePayButton(arrayAux[i]['date']);			 
			}
		}
	}
	//validates before add item warehouse price and quantity
	function validateItem(warehouse, item, salePrice, quantity, backorder, lastBackorder, virtualStock, lastQuantity){
		var error = '';
		if(warehouse === ''){error+='<li>El campo "Almacen" no puede estar vacio</li>';}
		if(item === ''){error+='<li>El campo "Item" no puede estar vacio</li>';}
		if(quantity === ''){
			error+='<li>El campo "Cantidad" no puede estar vacio</li>'; 
		}else{
			if(parseInt(quantity, 10) == 0){//CREO Q SE DEBE USAR Number()
				error+='<li>El campo "Cantidad" no puede ser cero</li>'; 
			}
		}
		if(salePrice === ''){
			error+='<li>El campo "Precio Unitario" no puede estar vacio</li>'; 
		}
//		if(backorder !== lastBackorder){
//			if(Number(backorder) > Number(quantity)){
//				error+='<li>El campo "Backorder" no puede ser mayor a cantidad</li>'; 
//			}
//			if(Number(backorder) < (Number(lastBackorder) - Number(stockVirtual))){
//				error+='<li>El campo "Backorder" no puede ser menor a backorder</li>'; 
//			}
//		}
		
		
		
		 if((quantity !== lastQuantity) && (backorder !== lastBackorder)){//CAMBIO DE cantidad y backorder
			var rest = Number(lastQuantity) - Number(lastBackorder); 	
			var rest2 = Number(quantity) - Number(rest) - Number(virtualStock); 	
			if(Number(backorder) > Number(quantity) || Number(backorder) < Number(rest2)){
				error+='<li>El campo "Backorder" no puede ser menor a rest2 ni mayor a la cantidad</li>'; 
			}
		}
//		else if(quantity !== lastQuantity){//CAMBIO DE cantidad 
//			
//		}
		else if(backorder !== lastBackorder){//CAMBIO DE backorder
			if(Number(backorder) > Number(quantity)){
				error+='<li>El campo "Backorder" no puede ser mayor a cantidad</li>'; 
			}
			if(Number(backorder) < (Number(lastBackorder) - Number(virtualStock))){
				error+='<li>El campo "Backorder" no puede ser menor a backorder</li>'; 
			}
		}
		
		
//		else{ //o si puede ser cero el precio?	
//			if(parseFloat(salePrice).toFixed(2) === 0.00){
//				error+='<li>El campo "Precio Unitario" no puede ser cero</li>'; 
//			}	
//		}
		return error;
	}
	
	//validates before add item warehouse price and quantity
	function validateItemDistrib(warehouse, item, quantity, quantityToDistrib){
		var error = '';
		if(warehouse === ''){error+='<li>El campo "Almacen" no puede estar vacio</li>';}
		if(item === ''){error+='<li>El campo "Item" no puede estar vacio</li>';}
		if(quantity === ''){
			error+='<li>El campo "Cantidad" no puede estar vacio</li>'; 
		}else{
			if(parseInt(quantity, 10) == 0){//CREO Q SE DEBE USAR Number()
				error+='<li>El campo "Cantidad" no puede ser cero</li>'; 
			}
		}
		if(quantityToDistrib === ''){
			error+='<li>El campo "Cantidad a Pasar" no puede estar vacio</li>'; 
		}else{
			if(parseInt(quantityToDistrib, 10) == 0){//CREO Q SE DEBE USAR Number()
				error+='<li>El campo "Cantidad a Pasar" no puede ser cero</li>'; 
			}
			if(parseInt(quantityToDistrib, 10) >= parseInt(quantity, 10)){
				error+='<li>El campo "Cantidad a Pasar" no puede mayor o igual a "Cantidad"</li>'; 
			}
		}
		return error;
	}
	
	function validateAddPay(payDate, payAmount, payDebt){
		var error = '';
		if(payDate === ''){
			error+='<li>El campo "Fecha" no puede estar vacio</li>'; 
		}else{
			var arrayAux = [];
			var myDate = payDate.split('/');
			var dateId = myDate[2]+"-"+myDate[1]+"-"+myDate[0];
			arrayAux = getPaysDetails();
			if(arrayAux[0] !== 0){
				for(var i=0; i< arrayAux.length; i++){
					if(dateId === (arrayAux[i]['date'])){
						error+='<li>La "Fecha" ya existe</li>'; 
					}  
				}
			}
		}
		
		if(payAmount === ''){
			error+='<li>El campo "Monto a Pagar" no puede estar vacio</li>'; 
		}else{
			if(Number(payAmount) > Number(payDebt)){
				error+='<li>El campo "Monto a Pagar" no puede ser mayor a la deuda</li>'; 
			}
			if(parseFloat(payAmount).toFixed(2) == 0){//CREO Q SE DEBE USAR Number()
				error+='<li>El campo "Monto a Pagar" no puede ser cero</li>'; 
			}
		}
		return error;
	}
	
	function validateEditPay(payDate, payAmount, payHiddenAmount, payDebt){
		var error = '';
		if(payDate === ''){
			error+='<li>El campo "Fecha" no puede estar vacio</li>'; 
		}		
		if(payAmount === ''){
			error+='<li>El campo "Monto a Pagar" no puede estar vacio</li>'; 
		}else{
			var payDebt2 = Number(payDebt) + Number(payHiddenAmount);
			if(parseFloat(payAmount).toFixed(2) == 0){//CREO Q SE DEBE USAR Number()
				error+='<li>El campo "Monto a Pagar" no puede ser cero</li>'; 
			}else if (payAmount > payDebt2){
				error+='<li>El campo "Monto a Pagar" no puede ser mayor a la deuda</li>'; 
			}
		}
		return error;
	}
	
	function validateBeforeSaveAll(arrayItemsDetails, result){
		var error = '';
		var noteCode = $('#txtNoteCode').val();
		var date = $('#txtDate').val();
		var dateYear = date.split('/');
		var clients = $('#cbxCustomers').text();
		var clientVal = $('#cbxCustomers option:selected').val();
		var employees = $('#cbxEmployees').text();
		var taxNumbers = $('#cbxTaxNumbers').text();
		var salesmen = $('#cbxSalesman').text();
		var salesmenVal = $('#cbxSalesman option:selected').val();
		var discount = $('#txtDiscount').val();
		var exRate = $('#txtExRate').val();
		
		if(noteCode === ''){	error+='<li> El campo "No. Nota de Remisión" no puede estar vacio </li>'; }
		if(date === ''){	error+='<li> El campo "Fecha" no puede estar vacio </li>'; }
		if(dateYear[2] !== globalPeriod){	error+='<li> El año '+dateYear[2]+' de la fecha del documento no es valida, ya que se encuentra en la gestión '+ globalPeriod +'.</li>'; }
		if(clientVal === '0'){	error+='<li> Selecione un "Cliente" </li>'; }
		if(clients === ''){	error+='<li> El campo "Cliente" no puede estar vacio </li>'; }
		if(employees === ''){	error+='<li> El campo "Encargado" no puede estar vacio </li>'; }
		if(taxNumbers === ''){	error+='<li> El campo "NIT - Nombre" no puede estar vacio </li>'; }
		if(salesmenVal === '0'){	error+='<li> Selecione un "Vendedor" </li>'; }
		if(salesmen === ''){	error+='<li> El campo "Vendedor" no puede estar vacio </li>'; }
		if(arrayItemsDetails[0] === 0){error+='<li> Debe existir al menos 1 "Item" </li>';}
		if(discount === ''){	error+='<li> El campo "Descuento" no puede estar vacio </li>'; }
		if(exRate === ''){	error+='<li> El campo "Tipo de Cambio" no puede estar vacio </li>'; }
		var itemZero = findIfOneItemHasQuantityZero(arrayItemsDetails);
		if(itemZero > 0){error+='<li> Se encontraron '+ itemZero +' "Items" con "Cantidad" 0, no puede existir ninguno </li>';}
//		if(typeof(result)==='undefined') result = 'undefined';
//		if(result !== 'undefined'){
			if(result === 'error'){error+='<li> El "No. Nota de Remision" no puede repetirse </li>'; }
//		}
		return error;
	}
	
	function ajax_check_code_duplicity(callback, param){
//		 var jqXHR = 
		$.ajax({
		    type:"POST",
//		    async: false,	
		    url:urlModuleController + "ajax_check_code_duplicity",			
		    data:{noteCode: $('#txtNoteCode').val()
				,genericCode: $('#txtGenericCode').val()},
		    beforeSend: showProcessing(),
				success: function(data){
					$("#processing").text("");					
					callback(data, param); 
				}
		});
//		return jqXHR.responseText;
	}
	
	function findIfOneItemHasQuantityZero(arrayItemsDetails){
		var cont = 0;
		for(var i = 0; i < arrayItemsDetails.length; i++){
			if(parseInt(arrayItemsDetails[i]['quantity'],10) === 0){
				cont++;
			}
		}
		return cont;
	}
	
	function changeLabelDocumentState(state){
		switch(state)
		{
			case 'NOTE_PENDANT':
				$('#documentState').addClass('label-warning');
				$('#documentState').text('NOTA PENDIENTE');
				break;
			case 'NOTE_APPROVED':
				$('#documentState').removeClass('label-warning').addClass('label-success');
				$('#documentState').text('NOTA APROBADA');
				break;
			case 'NOTE_CANCELLED':
				$('#documentState').removeClass('label-success').addClass('label-important');
				$('#documentState').text('NOTA CANCELADA');
				break;
				
			case 'NOTE_RESERVED':
				$('#documentState').removeClass('label-warning').addClass('label-info');
				$('#documentState').text('NOTA RESERVADA');
				break;	
				
			case 'SINVOICE_PENDANT':
				$('#documentState').addClass('label-warning');
				$('#documentState').text('FACTURA PENDIENTE');
				break;
			case 'SINVOICE_APPROVED':
				$('#documentState').removeClass('label-warning').addClass('label-success');
				$('#documentState').text('FACTURA APROBADA');
				break;
			case 'SINVOICE_CANCELLED':
				$('#documentState').removeClass('label-success').addClass('label-important');
				$('#documentState').text('FACTURA CANCELADA');
				break;
		}
	}
	
	function initiateModal(){
		$('#modalAddItem').modal({
					show: 'true',
					backdrop:'static'
		});
	}
	
//	function initiateModalEdit(){
//		$('#modalEditItem').modal({
//					show: 'true',
//					backdrop:'static'
//		});
//	}
	
	function initiateModalDistrib(){
		$('#modalDistribItem').modal({
					show: 'true',
					backdrop:'static'
		});
	}
	
	function initiateModalPay(){
		$('#modalAddPay').modal({
					show: 'true',
					backdrop:'static'
		});
	}
	
		function validateOnlyIntegers(event){
		// Allow only backspace and delete
		if (event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 || (event.keyCode > 34 && event.keyCode < 41)/*event.keyCode === 35 || event.keyCode === 36 || event.keyCode === 37 || event.keyCode === 38 || event.keyCode === 39 || event.keyCode === 40*/) {
			// let it happen, don't do anything
		}
		else {
			// Ensure that it is a number and stop the keypress
			if ( (event.keyCode < 96 || event.keyCode > 105) ) { //habilita keypad
				if ( (event.keyCode < 48 || event.keyCode > 57) ) {
					event.preventDefault(); 
				}
			}   
		}
	}
	
	function validateOnlyFloatNumbers(event){
		// Allow backspace,	tab, decimal point
		if (event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 110 || event.keyCode === 190) {
			// let it happen, don't do anything
		}
		else {
			// Ensure that it is a number and stop the keypress
			if ( (event.keyCode < 96 || event.keyCode > 105) ) { //habilita keypad
				if ((event.keyCode < 48 || event.keyCode > 57 ) ) {
					
						event.preventDefault(); 					
					
				}
			}   
		}
	}


	function initiateModalAddItemSO(){
		var error = validateBeforeSaveAll([{0:0}]);//I send [{0:0}] 'cause it doesn't care to validate if arrayItemsDetails is empty or not
		if( error === ''){
			if(arrayItemsWarehousesAlreadySaved.length === 0){  //For fix undefined index
				arrayItemsWarehousesAlreadySaved = [0+'w'+0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
			}
			$('#btnModalAddItem').show();
			$('#btnModalEditItem').hide();
			$('#boxModalValidateItem').html('');//clear error message
			ajax_initiate_modal_add_item_in_order(arrayItemsWarehousesAlreadySaved);
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	}
	
	function initiateModalAddItem(/*result*/){
		var error = validateBeforeSaveAll([{0:0}]/*, result*/);//I send [{0:0}] 'cause it doesn't care to validate if arrayItemsDetails is empty or not
		if( error === ''){
			if(arrayItemsWarehousesAlreadySaved.length === 0){  //For fix undefined index
				arrayItemsWarehousesAlreadySaved = [0+'w'+0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
//				arrayWarehouseItemsAlreadySaved = [0];
			}
			$('#btnModalAddItem').show();
			$('#btnModalEditItem').hide();
			$('#boxModalValidateItem').html('');//clear error message
			ajax_initiate_modal_add_item_in(arrayItemsWarehousesAlreadySaved);
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	}
	
	function initiateModalEditItem(/*result, */objectTableRowSelected){
		var error = validateBeforeSaveAll([{0:0}]/*, result*/);//I send [{0:0}] 'cause it doesn't care to validate if arrayItemsDetails is empty or not
		if( error === ''){
//			var itemIdForEdit = objectTableRowSelected.find('#txtItemId').val();
//			var warehouseIdForEdit = objectTableRowSelected.find('#txtWarehouseId'+itemIdForEdit).val();
			$('#btnModalAddItem').hide();
			$('#btnModalEditItem').show();
			$('#boxModalValidateItem').html('');//clear error message
//			$('#cbxModalWarehouses').empty();
//			$('#cbxModalWarehouses').append('<option value="'+warehouseIdForEdit+'">'+objectTableRowSelected.find('#spaWarehouse'+itemIdForEdit).text()+'</option>');
//			$('#cbxModalItems').empty();
//			$('#cbxModalItems').append('<option value="'+itemIdForEdit+'">'+objectTableRowSelected.find('td:first').text()+'</option>');
//			$('#txtModalPrice').val(objectTableRowSelected.find('#spaSalePrice'+itemIdForEdit+'w'+warehouseIdForEdit).text());
//			$('#txtModalStock').val(objectTableRowSelected.find('#spaStock'+itemIdForEdit).text());
//			$('#txtModalQuantity').val(objectTableRowSelected.find('#spaQuantity'+itemIdForEdit+'w'+warehouseIdForEdit).text());
//			$('#txtModalStock').keypress(function() {
//				return false;
//			});
//			fnBittionSetSelectsStyle();
//			initiateModal();
			ajax_initiate_modal_edit_item_in(arrayItemsWarehousesAlreadySaved, objectTableRowSelected /*,itemIdForEdit, warehouseIdForEdit*/);
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	}
	
	function initiateModalAddPay(/*result*/){
		var error = validateBeforeSaveAll([{0:0}]/*, result*/);//I send [{0:0}] 'cause it doesn't care to validate if arrayItemsDetails is empty or not
		if( error === ''){
//			if(arrayPaysAlreadySaved.length === 0){  //For fix undefined index
//				arrayPaysAlreadySaved = [0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
//			}
			$('#btnModalAddPay').show();
			$('#btnModalEditPay').hide();
			$('#boxModalValidatePay').html('');//clear error message
			ajax_initiate_modal_add_pay(/*arrayPaysAlreadySaved/*,parseFloat(payDebt).toFixed(2)*/);
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	}
	
	function initiateModalEditPay(/*result,*/ objectTableRowSelected){
		var error = validateBeforeSaveAll([{0:0}]/*, result*/);//I send [{0:0}] 'cause it doesn't care to validate if arrayItemsDetails is empty or not
		if( error === ''){
//			var payIdForEdit = objectTableRowSelected.find('#txtPayDate').val();  //
			$('#btnModalAddPay').hide();
			$('#btnModalEditPay').show();
			$('#boxModalValidatePay').html('');//clear error message
//			$('#txtModalDate').val(objectTableRowSelected.find('#spaPayDate'+payIdForEdit).text());
//			$('#txtModalPaidAmount').val(objectTableRowSelected.find('#spaPayAmount'+payIdForEdit).text());
//			$('#txtModalDescription').val(objectTableRowSelected.find('#spaPayDescription'+payIdForEdit).text());
//			$('#txtModalAmountHidden').val(objectTableRowSelected.find('#spaPayAmount'+payIdForEdit).text());
//			$('#txtModalDebtAmount').val(objectTableRowSelected.find('#spaPayAmount'+payIdForEdit).text());
//			initiateModalPay();
			ajax_initiate_modal_edit_pay(objectTableRowSelected/*arrayPaysAlreadySaved/*,parseFloat(payDebt).toFixed(2)*/);
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}	
	}
	
	function initiateModalDistribItem(objectTableRowSelected){
		var error = validateBeforeSaveAll([{0:0}]);//I send [{0:0}] 'cause it doesn't care to validate if arrayItemsDetails is empty or not
		if( error === ''){
//			$('#btnModalAddItem').hide();
//			$('#btnModalEditItem').hide();
			$('#btnModalDistribItem').show();
			$('#boxModalValidateItemDistrib').html('');//clear error message
			ajax_initiate_modal_distrib_item_in(arrayItemsWarehousesAlreadySaved, objectTableRowSelected /*,itemIdForEdit, warehouseIdForEdit*/);
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	}
	
	function createEventClickEditItemButton(itemId,warehouseId){
			$('#btnEditItem'+itemId+'w'+warehouseId).bind("click",function(){ //must be binded 'cause loaded live with javascript'
					var objectTableRowSelected = $(this).closest('tr');
					initiateModalEditItem(objectTableRowSelected);
//					ajax_check_code_duplicity(initiateModalEditItem, objectTableRowSelected);//passing callback as a parameter into another function
					return false; //avoid page refresh
			});
	}
	
	function createEventClickDistribItemButton(itemId,warehouseId){
			$('#btnDistribItem'+itemId+'w'+warehouseId).bind("click",function(){ //must be binded 'cause loaded live with javascript'
					var objectTableRowSelected = $(this).closest('tr');
					initiateModalDistribItem(objectTableRowSelected);
					return false; //avoid page refresh
			});
	}
	
	function createEventClickDeleteItemButton(itemId,warehouseId){
		$('#btnDeleteItem'+itemId+'w'+warehouseId).bind("click",function(e){ //must be binded 'cause loaded live with javascript'
					var objectTableRowSelected = $(this).closest('tr');
					deleteItem(objectTableRowSelected);
//					ajax_check_code_duplicity(deleteItem, objectTableRowSelected);//passing callback as a parameter into another function
					//return false; //avoid page refresh
					e.preventDefault();
		});
	}
	
	function deleteItem(/*result,*/ objectTableRowSelected){
		var arrayItemsDetails = getItemsDetails();
		var error = validateBeforeSaveAll([{0:0}]/*, result*/);//Send [{0:0}] 'cause I won't use arrayItemsDetails classic validation, I will use it differently for this case (as done below)
		if(arrayItemsDetails.length === 1){error+='<li> Debe existir al menos 1 "Item" </li>';}
		if( error === ''){
			showBittionAlertModal({content:'¿Está seguro de eliminar este item?'});
			$('#bittionBtnYes').click(function(){
				if(urlAction === 'save_order'){
					ajax_save_movement('DELETE', 'NOTE_PENDANT', objectTableRowSelected, []);
				}
				if(urlAction === 'save_invoice'){
					ajax_save_movement('DELETE', 'SINVOICE_PENDANT', objectTableRowSelected, []);
				}
				return false; //avoid page refresh
			});
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	}
	
	function deletePay(/*result, */objectTableRowSelected){
		//var arrayPaysDetails = getPaysDetails();
		var error = validateBeforeSaveAll([{0:0}]/*, result*/);//Send [{0:0}] 'cause I won't use arrayItemsDetails classic validation, I will use it differently for this case (as done below)
		if( error === ''){
			showBittionAlertModal({content:'¿Está seguro de eliminar este pago?'});
			$('#bittionBtnYes').click(function(){
				if(urlAction === 'save_order'){
					ajax_save_movement('DELETE_PAY', 'NOTE_PENDANT', objectTableRowSelected, []);
				}
				if(urlAction === 'save_invoice'){
					ajax_save_movement('DELETE_PAY', 'SINVOICE_PENDANT', objectTableRowSelected, []);
				}
				return false;
			});
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	}
	
	function createEventClickEditPayButton(dateId){
			$('#btnEditPay'+dateId).bind("click",function(){ //must be binded 'cause loaded live with javascript'
					var objectTableRowSelected = $(this).closest('tr');
//					startEventsWhenExistsDebts();
					initiateModalEditPay(objectTableRowSelected);
					return false; //avoid page refresh
			});
	}
	
	function createEventClickDeletePayButton(dateId){
		$('#btnDeletePay'+dateId).bind("click",function(){ //must be binded 'cause loaded live with javascript'
					var objectTableRowSelected = $(this).closest('tr');
					deletePay(objectTableRowSelected);
					return false; //avoid page refresh
		});
	}
	
	// (GC Ztep 3) function to fill Items list when saved in modal triggered by addItem() //type="hidden"
	function createRowItemTable(itemId, itemCodeName, salePrice, quantity, backorder, warehouse, warehouseId, stock, stockReal, subtotal){
		var row = '<tr id="itemRow'+itemId+'w'+warehouseId+'" >';
		row +='<td><span id="spaItemName'+itemId+'">'+itemCodeName+'</span><input  value="'+itemId+'" id="txtItemId" ></td>';
		row +='<td><span id="spaSalePrice'+itemId+'w'+warehouseId+'">'+salePrice+'</span></td>';
		row +='<td><span id="spaAvaQuantity'+itemId+'w'+warehouseId+'">'+(quantity-backorder)+'</span></td>';
		if(backorder > 0){
			row +='<td><span id="spaBOQuantity'+itemId+'w'+warehouseId+'" style="color:red">'+backorder+'</span></td>';
		}else{
			row +='<td><span id="spaBOQuantity'+itemId+'w'+warehouseId+'">'+backorder+'</span></td>';
		}	
		row +='<td><span id="spaQuantity'+itemId+'w'+warehouseId+'">'+quantity+'</span></td>';
		row +='<td><span id="spaSubtotal'+itemId+'w'+warehouseId+'">'+subtotal+'</span></td>';
		row +='<td><span id="spaWarehouse'+itemId+'w'+warehouseId+'">'+warehouse+'</span><input  value="'+warehouseId+'" id="txtWarehouseId'+itemId+'" ></td>';
		if(stock > 0){	
			row +='<td><span id="spaVirtualStock'+itemId+'w'+warehouseId+'">'+stock+'</span></td>';
		}else{
			row +='<td><span id="spaVirtualStock'+itemId+'w'+warehouseId+'" style="color:red">'+stock+'</span></td>';
		}	
		row +='<td><span id="spaStock'+itemId+'w'+warehouseId+'">'+stockReal+'</span></td>';
		row +='<td class="columnItemsButtons">';
		row +='<a class="btn btn-primary" href="#" id="btnEditItem'+itemId+'w'+warehouseId+'" title="Editar"><i class="icon-pencil icon-white"></i></a> ';
//		if(urlAction === 'save_invoice'){
			row +='<a class="btn btn-info" href="#" id="btnDistribItem'+itemId+'w'+warehouseId+'" title="Distribuir"><i class="icon-resize-full icon-white"></i></a> ';
//		}	
		row +='<a class="btn btn-danger" href="#" id="btnDeleteItem'+itemId+'w'+warehouseId+'" title="Eliminar"><i class="icon-trash icon-white"></i></a>';
		row +='</td>';
		row +='</tr>';
		$('#tablaItems tbody').prepend(row);
	}
	
	function createRowTotalTable(trId, label, h4Id, amount){
		var row = '<tr id="'+trId+'">';
		row +='<td></td>';
		row +='<td></td>';
			row +='<td colspan="3"><h4>'+label+':</h4></td>';
			row +='<td><h4 id="'+h4Id+'" >'+amount+' Bs.</td>';		
		row +='<td></td>';
		row +='<td></td>';
		row +='<td></td>';
		row +='<td></td>';
		row +='</tr>';
		$('#tablaItems tfoot').append(row);
	}
	
	function createRowPayTable(dateId, payDate, payAmount, payDescription){
		var row = '<tr id="payRow'+dateId+'" >';
		row +='<td><span id="spaPayDate'+dateId+'">'+payDate+'</span><input type="hidden" value="'+dateId+'" id="txtPayDate" ></td>';
		row +='<td><span id="spaPayAmount'+dateId+'">'+payAmount+'</span></td>';
		row +='<td><span id="spaPayDescription'+dateId+'">'+payDescription+'</span></td>';
		row +='<td class="columnPaysButtons">';
		row +='<a class="btn btn-primary" href="#" id="btnEditPay'+dateId+'" title="Editar"><i class="icon-pencil icon-white"></i></a> ';
		row +='<a class="btn btn-danger" href="#" id="btnDeletePay'+dateId+'" title="Eliminar"><i class="icon-trash icon-white"></i></a>';
		row +='</td>';
		row +='</tr>';
		$('#tablaPays > tbody:last').append(row);
	}
	
	
	
//	function updateMultipleStocks(arrayItemsStocks, controlName){
//		var auxItemsStocks = [];
//		for(var i=0; i<arrayItemsStocks.length; i++){
//			auxItemsStocks = arrayItemsStocks[i].split('=>');//  item5=>9stock
//			$('#'+controlName+auxItemsStocks[0]).text(auxItemsStocks[1]);  //update only if quantities are APPROVED
//		}
//	}
	
	// Triggered when Guardar Modal button is pressed
	function addItem(){	
		var warehouse = $('#cbxModalWarehouses option:selected').text();
		var itemCodeName = $('#cbxModalItems option:selected').text();
		var salePrice = $('#txtModalPrice').val();
		var quantity = $('#txtModalQuantity').val();
		var error = validateItem(warehouse, itemCodeName, salePrice, quantity); 
		if(error === ''){
			if(urlAction === 'save_order'){
				ajax_save_movement('ADD', 'NOTE_PENDANT', '', []);
			}
			if(urlAction === 'save_invoice'){
				ajax_save_movement('ADD', 'SINVOICE_PENDANT', '', []);
			}
		}else{
			$('#boxModalValidateItem').html('<ul>'+error+'</ul>');
		}
	}
	
	function editItem(){
		var warehouse = $('#cbxModalWarehouses option:selected').text();
		var itemCodeName = $('#cbxModalItems option:selected').text();	
		var salePrice = $('#txtModalPrice').val();
		var quantity = $('#txtModalQuantity').val();	
//		var cifPrice = $('#txtCifPrice').val();
//		var exCifPrice = $('#txtCifExPrice').val();	
		var backorder = $('#txtModalBOQuantity').val();
		var lastBackorder = $('#txtModalLastBOQuantity').val();
		var virtualStock = $('#txtModalStock').val();
		var lastQuantity = $('#txtModalLastQuantity').val();	
		var error = validateItem(warehouse, itemCodeName, salePrice, quantity, backorder, lastBackorder, virtualStock, lastQuantity); 
		if(error === ''){
			if(urlAction === 'save_order'){
				ajax_save_movement('EDIT', 'NOTE_PENDANT', '', []);
			}
			if(urlAction === 'save_invoice'){
				ajax_save_movement('EDIT', 'SINVOICE_PENDANT', '', []);
			}	
		}else{
			$('#boxModalValidateItem').html('<ul>'+error+'</ul>');
		}
	}
	
	function distribItem(){
		var warehouse = $('#cbxModalWarehousesDistrib option:selected').text();
		var itemCodeName = $('#cbxModalItemsDistrib option:selected').text();	
		var quantity = $('#txtModalQuantityDistrib').val();
		var quantityToDistrib = $('#txtModalQuantityToDistrib').val();	
		var error = validateItemDistrib(warehouse, itemCodeName, quantity, quantityToDistrib); 
		if(error === ''){
			if(urlAction === 'save_order'){
				ajax_save_movement('DISTRIB', 'NOTE_PENDANT', '', []);
			}
			if(urlAction === 'save_invoice'){
				ajax_save_movement('DISTRIB', 'SINVOICE_PENDANT', '', []);
			}
		}else{
			$('#boxModalValidateItemDistrib').html('<ul>'+error+'</ul>');
		}
	}
	
	function addPay(){
		var payDate = $('#txtModalDate').val();
		var payAmount = $('#txtModalPaidAmount').val();
		var payDebt = $('#txtModalDebtAmount').val();
		var error = validateAddPay(payDate, parseFloat(payAmount).toFixed(2), parseFloat(payDebt).toFixed(2));  
		if(error === ''){
			if(urlAction === 'save_order'){
				ajax_save_movement('ADD_PAY', 'NOTE_PENDANT', '', []);
			}
			if(urlAction === 'save_invoice'){
				ajax_save_movement('ADD_PAY', 'SINVOICE_PENDANT', '', []);
			}
		}else{
			$('#boxModalValidatePay').html('<ul>'+error+'</ul>');
		}
	}
	
	function editPay(){
		var payDate = $('#txtModalDate').val();
		var payAmount = $('#txtModalPaidAmount').val();
		var payHiddenAmount = $('#txtModalAmountHidden').val();
		var payDebt = $('#txtModalDebtAmount').val();
		var error = validateEditPay(payDate, parseFloat(payAmount).toFixed(2), parseFloat(payHiddenAmount).toFixed(2), parseFloat(payDebt).toFixed(2));  
		if(error === ''){
			if(urlAction === 'save_order'){
				ajax_save_movement('EDIT_PAY', 'NOTE_PENDANT', '', []);
			}
			if(urlAction === 'save_invoice'){
				ajax_save_movement('EDIT_PAY', 'SINVOICE_PENDANT', '', []);
			}
		}else{
			$('#boxModalValidatePay').html('<ul>'+error+'</ul>');
		}
	}
	//esto suma todos los subtotales y retorna el total	
	function getTotal(){
		var arrayAux = [];
		var total = 0;
//		var discount = $('#txtDiscount').val();
		arrayAux = getItemsDetails();
		if(arrayAux[0] !== 0){
			for(var i=0; i< arrayAux.length; i++){
				 var salePrice = (arrayAux[i]['sale_price']);
				 var quantity = (arrayAux[i]['quantity']);
				 total = total + (salePrice*quantity);
			}
		}
		
//		if(discount !== 0){
//			total = total-(total*(discount/100));
//		}
		
		return parseFloat(total).toFixed(2); 	
	}
	
	function getTotalDebt(){
		var arrayAux = [];
		var total = 0;
		var discount = $('#txtDiscount').val();
		arrayAux = getItemsDetails();
		if(arrayAux[0] !== 0){
			for(var i=0; i< arrayAux.length; i++){
				 var salePrice = (arrayAux[i]['sale_price']);
				 var quantity = (arrayAux[i]['quantity']);
				 total = total + (salePrice*quantity);
			}
		}
		
		if(discount !== 0){
			total = total-(total*(discount/100));
		}
		
		return parseFloat(total).toFixed(2); 	
	}
	//esto sume todos los pagos y devuelve el total
	function getTotalPay(){
		var arrayAux = [];
		var total = 0;
		arrayAux = getPaysDetails();
		if(arrayAux[0] !== 0){
			for(var i=0; i< arrayAux.length; i++){
				 var amount = (arrayAux[i]['amount']);
//				 var quantity = (arrayAux[i]['quantity']);
				 total = total + Number(amount);
			}
		}
		return parseFloat(total).toFixed(2); 	
	}
	
	//get all items for save a purchase
	function getItemsDetails(){		
		var arrayItemsDetails = [];
		var itemId = '';
		var itemSalePrice = '';
		var itemQuantity = '';
		var itemWarehouseId = '';
		var itemBackorder = '';
//		var itemCifPrice = '';
//		var itemExCifPrice = '';
		var exRate = $('#txtExRate').val();
	
		var itemExSalePrice = '';	//??????????????????????
		
		$('#tablaItems tbody tr').each(function(){		
			itemId = $(this).find('#txtItemId').val();
			itemWarehouseId = $(this).find('#txtWarehouseId'+itemId).val();
			itemSalePrice = $(this).find('#spaSalePrice'+itemId+'w'+itemWarehouseId).text();
			itemQuantity = $(this).find('#spaQuantity'+itemId+'w'+itemWarehouseId).text();
			itemBackorder = $(this).find('#spaBOQuantity'+itemId+'w'+itemWarehouseId).text();
			
//			itemCifPrice = $(this).find('#txtCifPrice').val();
//			itemExCifPrice = $(this).find('#txtCifExPrice').val();
			itemExSalePrice = itemSalePrice / exRate;//?????????????????????????
			arrayItemsDetails.push({'inv_item_id':itemId, 'sale_price':itemSalePrice, 'quantity':itemQuantity, 'inv_warehouse_id':itemWarehouseId, 'ex_sale_price':parseFloat(itemExSalePrice).toFixed(2), 'backorder':itemBackorder});
			
		});
		
		if(arrayItemsDetails.length === 0){  //For fix undefined index
			arrayItemsDetails = [0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
		}
		
		return arrayItemsDetails; 		
	}
	
	function getPaysDetails(){		
		var arrayPaysDetails = [];
		var dateId = '';
		var payDate = '';
		var payAmount = '';
		var payDescription = '';
		
		$('#tablaPays tbody tr').each(function(){		
			dateId = $(this).find('#txtPayDate').val();
			payDate = $(this).find('#spaPayDate'+dateId).text();
			payAmount = $(this).find('#spaPayAmount'+dateId).text();
			payDescription = $(this).find('#spaPayDescription'+dateId).text();
			
			arrayPaysDetails.push({'date':dateId, 'amount':payAmount,'description':payDescription});
		});
		
		if(arrayPaysDetails.length === 0){  //For fix undefined index
			arrayPaysDetails = [0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
		}
		
		return arrayPaysDetails; 		
	}
	
	//show message of procesing for ajax
	function showProcessing(){
        $('#processing').text("Procesando...");
    }
	
	function showGrowlMessage(type, text, sticky){
		if(typeof(sticky)==='undefined') sticky = false;
		
		var title;
		var image;
		switch(type){
			case 'ok':
				title = 'EXITO!';
				image= urlImg+'check.png';
				break;
			case 'error':
				title = 'OCURRIO UN PROBLEMA!';
				image= urlImg+'error.png';
				break;
			case 'warning':
				title = 'PRECAUCIÓN!';
				image= urlImg+'warning.png';
				break;
		}
		$.gritter.add({
			title:	title,
			text: text,
			sticky: sticky,
			image: image
		});	
	}
	
	function saveAll(/*result*/){
		var arrayItemsDetails = [];
		arrayItemsDetails = getItemsDetails();
//		var arrayCostsDetails = [];
//		arrayCostsDetails = getCostsDetails();
//		var arrayPaysDetails = [];
//		arrayPaysDetails = getPaysDetails();
		var error = validateBeforeSaveAll(arrayItemsDetails/*, result*/);
		if( error === ''){
			if(urlAction === 'save_order'){
				ajax_save_movement('DEFAULT', 'NOTE_PENDANT', '', []);
			}
			if(urlAction === 'save_invoice'){
				ajax_save_movement('DEFAULT', 'SINVOICE_PENDANT', '', []);
			}
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	}
	
	// (AEA Ztep 2) action when button Aprobar Entrada Almacen is pressed
//	function changeStateApproved(result){
//		showBittionAlertModal({content:'Al APROBAR este documento ya no se podrá hacer más modificaciones. ¿Está seguro?'});
//		$('#bittionBtnYes').click(function(){
//			var arrayForValidate = [];
//			arrayForValidate = getItemsDetails();
//			var error = validateBeforeSaveAll(arrayForValidate);
//			if( error === ''){
//				if(urlAction === 'save_order'){
//					ajax_save_movement('DEFAULT', 'NOTE_APPROVED', '', arrayForValidate);
//				}
//				if(urlAction === 'save_invoice'){
//					ajax_save_movement('DEFAULT', 'SINVOICE_APPROVED', '', arrayForValidate);
//				}
//			}else{
//				$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
//			}
//			hideBittionAlertModal();
//		});
//	}
	
	function changeStateApproved(result){
		var arrayForValidate = [];
		arrayForValidate = getItemsDetails();
		var error = validateBeforeSaveAll(arrayForValidate, result);
		if( error === ''){
//			if(urlAction === 'save_order'){
//				showBittionAlertModal({content:'Al APROBAR este documento ya no se podrá hacer más modificaciones. ¿Está seguro?'});
//				$('#bittionBtnYes').click(function(){
//					ajax_save_movement('DEFAULT', 'NOTE_APPROVED', ''/*, arrayForValidate*/);
//					hideBittionAlertModal();
//				});	
//			}
//			if(urlAction === 'save_invoice'){
//				startEventsWhenExistsDebts();
//				if(result === 'approve'){
//					if(payDebt == 0){
								showBittionAlertModal({content:'Al APROBAR este documento ya no se podrá hacer más modificaciones. ¿Está seguro?'});
								$('#bittionBtnYes').click(function(){
									ajax_save_movement('DEFAULT', 'SINVOICE_APPROVED', ''/*, arrayForValidate*/);
								hideBittionAlertModal();
								});		
//					}else{
//						showBittionAlertModal({content:'No puede aprobar esta factura de venta. <br><br>Primero debe cancelar todos los pagos pendientes.', btnYes:'Aceptar', btnNo:''});
//						$('#bittionBtnYes').click(function(){
//							hideBittionAlertModal();
//						});
//					}				
//				}else{
//					showBittionAlertModal({content:'No puede aprobar esta factura de venta. <br><br>Primero deben aprobar el/los movimiento(s) relacionados a esta factura de venta.', btnYes:'Aceptar', btnNo:''});
//					$('#bittionBtnYes').click(function(){
//						hideBittionAlertModal();
//					});
//				}	
//			}
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}	
	}
	
	function reserveNote(result){
		var arrayForValidate = [];
		arrayForValidate = getItemsDetails();
		var error = validateBeforeSaveAll(arrayForValidate, result);
		if( error === ''){
			if(urlAction === 'save_order'){
				showBittionAlertModal({content:'Reservar. ¿Está seguro?'});
				$('#bittionBtnYes').click(function(){
					ajax_save_movement('DEFAULT', 'NOTE_RESERVED', ''/*, arrayForValidate*/);
					hideBittionAlertModal();
				});	
			}
//			if(urlAction === 'save_invoice'){
//				startEventsWhenExistsDebts();
//				if(result === 'approve'){
//					if(payDebt == 0){
//								showBittionAlertModal({content:'Al APROBAR este documento ya no se podrá hacer más modificaciones. ¿Está seguro?'});
//								$('#bittionBtnYes').click(function(){
//									ajax_save_movement('DEFAULT', 'SINVOICE_APPROVED', ''/*, arrayForValidate*/);
//								hideBittionAlertModal();
//								});		
//					}else{
//						showBittionAlertModal({content:'No puede aprobar esta factura de venta. <br><br>Primero debe cancelar todos los pagos pendientes.', btnYes:'Aceptar', btnNo:''});
//						$('#bittionBtnYes').click(function(){
//							hideBittionAlertModal();
//						});
//					}				
//				}else{
//					showBittionAlertModal({content:'No puede aprobar esta factura de venta. <br><br>Primero deben aprobar el/los movimiento(s) relacionados a esta factura de venta.', btnYes:'Aceptar', btnNo:''});
//					$('#bittionBtnYes').click(function(){
//						hideBittionAlertModal();
//					});
//				}	
//			}
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}	
	}
	// (CEA Ztep 2) action when button Cancelar Entrada Almacen is pressed
//	function changeStateCancelled(){
//		showBittionAlertModal({content:'Al CANCELAR este documento ya no será válido y no habrá marcha atrás. ¿Está seguro?'});
//		$('#bittionBtnYes').click(function(){
////			var arrayItemsDetails = [];
////			arrayItemsDetails = getItemsDetails();
////			var arrayPaysDetails = [];
////			arrayPaysDetails = getPaysDetails();
//			var arrayForValidate = [];
//			arrayForValidate = getItemsDetails();
//			if(urlAction === 'save_order'){
//				ajax_save_movement('DEFAULT', 'NOTE_CANCELLED', '', arrayForValidate);
//			}
//			if(urlAction === 'save_invoice'){
//				ajax_save_movement('DEFAULT', 'SINVOICE_CANCELLED', '', arrayForValidate);
//			}
//			hideBittionAlertModal();
//		});
//	}
	
	function changeStateCancelled(result){
		if(urlAction === 'save_order'){
//			if(result === 'proceed'){
				showBittionAlertModal({content:'Al CANCELAR este documento ya no será válido y no habrá marcha atrás. ¿Está seguro?'});
				$('#bittionBtnYes').click(function(){
					ajax_save_movement('DEFAULT', 'NOTE_CANCELLED', ''/*, arrayForValidate*/);
					hideBittionAlertModal();
				});
//			}else{
//				showBittionAlertModal({content:'No puede cancelar esta orden de compra. <br><br>Primero debe eliminar/cancelar la factura y movimiento(s) relacionados a esta orden de compra.', btnYes:'Aceptar', btnNo:''});
//				$('#bittionBtnYes').click(function(){
//					hideBittionAlertModal();
//				});
//			}

		}
		if(urlAction === 'save_invoice'){
			if(result === 'cancell'){
				showBittionAlertModal({content:'Al CANCELAR este documento ya no será válido y no habrá marcha atrás. ¿Está seguro?'});
				$('#bittionBtnYes').click(function(){
					ajax_save_movement('DEFAULT', 'SINVOICE_CANCELLED', ''/*, arrayForValidate*/);
					hideBittionAlertModal();
				});
			}else{
				showBittionAlertModal({content:'No puede cancelar esta factura de venta. <br><br>Primero debe cancelar el/los movimiento(s) relacionados a esta factura de venta.', btnYes:'Aceptar', btnNo:''});
				$('#bittionBtnYes').click(function(){
					hideBittionAlertModal();
				});
			}
		}
	}
	
	function changeStateLogicDeleted(){
		showBittionAlertModal({content:'¿Está seguro de eliminar este documento en estado Pendiente?'});
		$('#bittionBtnYes').click(function(){
			var purchaseId = $('#txtPurchaseIdHidden').val();
			var genCode = $('#txtGenericCode').val();
//			var purchaseId2=0;
			var type;
//			var type2=0;
			var index;
			switch(urlAction){
				case 'save_order':
					index = 'index_order';
					type = 'NOTE_LOGIC_DELETED';
					break;	
				case 'save_invoice':
					index = 'index_invoice';
					type = 'SINVOICE_LOGIC_DELETED';
					break;	
			}
			ajax_logic_delete(purchaseId, type, index, genCode);
			hideBittionAlertModal();
		});
	}
	
	function changeStateReserved(){
		showBittionAlertModal({content:'¿Está seguro de editar este documento en estado Reservado?'});
		$('#bittionBtnYes').click(function(){
			var saleId = $('#txtPurchaseIdHidden').val();
			var genCode = $('#txtGenericCode').val();
			var reserve;
			var action;
			switch(urlAction){
				case 'save_order':
					reserve = false;
					action = 'save_order';
					break;	
				case 'save_invoice':
					reserve = true;
					action = 'save_invoice';
					break;	
			}
			ajax_change_reserved(saleId, reserve, genCode, action/*, index, genCode*/);
			hideBittionAlertModal();
		});
	}
	//************************************************************************//
	//////////////////////////////////END-FUNCTIONS//////////////////////
	//************************************************************************//
	
	
	
	
	//************************************************************************//
	//////////////////////////////////BEGIN-CONTROLS EVENTS/////////////////////
	//************************************************************************//
//	$('#txtModalPrice').keydown(function(event) {
//			validateOnlyFloatNumbers(event);			
//	});
	$('#txtModalQuantity').keydown(function(event) {
			validateOnlyIntegers(event);			
	});
	$('#txtDiscount').keydown(function(event) {
			validateOnlyIntegers(event);			
	});
//	$('#txtModalPaidAmount').keydown(function(event) {
//			validateOnlyFloatNumbers(event);			
//	});
	//Calendar script
	$("#txtDate").datepicker({
	  showButtonPanel: true
	});
	
	$('#txtDate').focusout(function() {
			ajax_update_ex_rate();			
	});
	
	$('#txtModalQuantityToDistrib').keydown(function(event) {
			validateOnlyIntegers(event);			
	});
	
	function ajax_update_ex_rate(){
		$.ajax({
		    type:"POST",
		    url:urlModuleController + "ajax_update_ex_rate",			
		    data:{date: $("#txtDate").val()},
		    beforeSend: showProcessing(),
				success:function(data){
					$("#processing").text("");
					$("#boxExRate").html(data);
				}
		});
    }
	
//	$("#txtModalDate").datepicker({
//	  showButtonPanel: true
//	});
	
//	$("#txtModalDueDate").datepicker({
//	  showButtonPanel: true
//	});
	
	$('#btnAddItemSO').click(function(){
		initiateModalAddItemSO();
		return false; //avoid page refresh
	});
	
	//Call modal
	$('#btnAddItem').click(function(){
//		itemsListWhenExistsItems();			//NEEDS TO BE RUN BEFORE MODAL TO UPDATE ITEMS LIST BY WAREHOUSE
//		warehouseListWhenExistsItems();	//NEEDS TO BE RUN BEFORE MODAL TO UPDATE ITEMS LIST BY WAREHOUSE
		initiateModalAddItem();
//		ajax_check_code_duplicity(initiateModalAddItem);//passing callback as a parameter into another function
		return false; //avoid page refresh
	});
	
	//function when button Guardar on the modal is pressed
	$('#btnModalAddItem').click(function(){
		addItem();
		return false; //avoid page refresh
	});
	
	//edit an existing item quantity
	$('#btnModalEditItem').click(function(){
		editItem();
		return false; //avoid page refresh
	});
	
	//edit an existing item quantity
	$('#btnModalDistribItem').click(function(){
		distribItem();
		return false; //avoid page refresh
	});
	
	//saves all order
	$('#btnSaveAll').click(function(){
		saveAll();
//		ajax_check_code_duplicity(saveAll);//passing callback as a parameter into another function
		return false; //avoid page refresh
	});
	
	//function triggered when PAYS plus icon is clicked
	$('#btnAddPay').click(function(){
//		startEventsWhenExistsDebts();
		initiateModalAddPay();
//		ajax_check_code_duplicity(initiateModalAddPay);//passing callback as a parameter into another function
		return false; //avoid page refresh
	});
	
	$('#btnModalAddPay').click(function(){
		addPay();
		return false; //avoid page refresh
	});
	
	//edit an existing item quantity
	$('#btnModalEditPay').click(function(){
		editPay();
		return false; //avoid page refresh
	});
	////////////////
	
	// action when button Aprobar Entrada is pressed
	$('#btnApproveState').click(function(){
//		changeStateApproved();
//		ajax_check_document_state(changeStateApproved);
		ajax_check_code_duplicity(changeStateApproved);
		return false;
	});
	// (CEA Ztep 1) action when button Cancelar Entrada Almacen is pressed
	$('#btnCancellState').click(function(){
		//alert('Se cancela entrada');
//		changeStateCancelled();
		ajax_check_document_state1(changeStateCancelled);
		return false;
	});
	
	$('#btnLogicDeleteState').click(function(){
		changeStateLogicDeleted();
		return false;
	});
	
	$('#btnEditReservedNote').click(function(){
		changeStateReserved();
		return false;
	});
	
	$('#btnGoMovements').click(function(){
		window.location = '../../inv_movements/index_sale_out/note_code:'+ $('#txtNoteCode').val() +'/search:yes';
		return false;
	});
	
	
	$('#btnReserveNote').click(function(){
		ajax_check_code_duplicity(reserveNote);
		return false;
	});
//	fnBittionSetSelectsStyle();
	
//	$('#cbxSuppliers').data('pre', $(this).val());
//	$('#cbxSuppliers').change(function(){
//	var supplier = $(this).data('pre');
//		deleteList(supplier);
//	$(this).data('pre', $(this).val());
//		return false; //avoid page refresh
//	});
  
	//accion al seleccionar un cliente
	$('#cbxCustomers').change(function(){
        ajax_list_controllers_inside();		
    });
	
	$('#txtDate').keydown(function(e){e.preventDefault();});
	$('#txtModalDate').keypress(function(){return false;});
	$('#txtCode').keydown(function(e){e.preventDefault();});
	$('#txtOriginCode').keydown(function(e){e.preventDefault();});
	
	
	$("#chkInv").change(function() {
		if(this.checked) {
			$('#tab3li').show();
			$('#tab1li').removeClass('active');
			$('#tab1').removeClass('active');
			$('#tab2li').removeClass('active');
			$('#tab2').removeClass('active');
			$('#tab3li').addClass('active');
			$('#tab3').addClass('active');
		}else{
			$('#tab3li').hide();
			$('#tab2li').removeClass('active');
			$('#tab3li').removeClass('active');
			$('#tab1li').addClass('active');
			$('#tab2').removeClass('active');
			$('#tab3').removeClass('active');
			$('#tab1').addClass('active');
		}
	});
	
	function ajax_list_controllers_inside(){
        $.ajax({
            type:"POST",
            url:urlModuleController + "ajax_list_controllers_inside",			
            data:{customer: $("#cbxCustomers").val()},
            beforeSend: showProcessing(),
			success:function(data){
				$("#processing").text("");
		        $("#boxControllers").html(data);
				fnBittionSetSelectsStyle();
//				$('#cbxEmployees').select2();
//				$('#cbxTaxNumbers').select2();
			}
        });
    }
	
	function ajax_check_document_state(callback){
		$.ajax({
		    type:"POST",
		    url:urlModuleController + "ajax_check_document_state",			
		    data:{action: urlAction,
				purchaseId: $('#txtPurchaseIdHidden').val()
				,genericCode: $('#txtGenericCode').val()},
		    beforeSend: showProcessing(),
				success: function(data){
					$("#processing").text("");					
					callback(data); 
				}
		});
	}
	
	function ajax_check_document_state1(callback){
		$.ajax({
		    type:"POST",
		    url:urlModuleController + "ajax_check_document_state1",			
		    data:{action: urlAction,
				purchaseId: $('#txtPurchaseIdHidden').val()
				,genericCode: $('#txtGenericCode').val()},
		    beforeSend: showProcessing(),
				success: function(data){
					$("#processing").text("");					
					callback(data); 
				}
		});
	}

//	$('#txtDate').keypress(function(e){e.preventDefault();});
//	$('#txtModalDate').keypress(function(){return false;});
//	$('#txtModalDueDate').keypress(function(){return false;});
//	$('#txtCode').keydown(function(e){e.preventDefault();});
//	$('#txtOriginCode').keydown(function(e){e.preventDefault();});
	//************************************************************************//
	//////////////////////////////////END-CONTROLS EVENTS//////////////////////
	//************************************************************************//
	
	
	
	
	//************************************************************************//
	//////////////////////////////////BEGIN-AJAX FUNCTIONS//////////////////////
	////************************************************************************//
	
	
	//*****************************************************************************************************************************//
	function setOnData(ACTION, OPERATION, STATE, objectTableRowSelected, arrayForValidate){
		var DATA = [];
		//constants
		var purchaseId=$('#txtPurchaseIdHidden').val();
		var movementDocCode = $('#txtCode').val();
		var movementCode = $('#txtGenericCode').val();
		var noteCode=$('#txtNoteCode').val();
		var date=$('#txtDate').val();
		var employee=$('#cbxEmployees').val();
		var taxNumber=$('#cbxTaxNumbers').val();
		var salesman=$('#cbxSalesman').val();
		var description=$('#txtDescription').val();
		var exRate=$('#txtExRate').val();
		var discount=$('#txtDiscount').val();
		var invoiced=$('#chkInv').is(':checked');
		
		var invoiceNumber=$('#tabInvoiceNumber').val();
		var invoiceDescription=$('#tabDescription').val();
		//variables
		var warehouseId = 0;
		var itemId = 0;
		var salePrice = 0.00;
		var lastWarehouse = 0;
		var lastQuantity = 0;
//		var lastWarehouseName = '';
		var quantity = 0;
		var backorder = 0;
		var backorderOrigin = 0;
		var lastBackorder = 0;
//		var lastBackorderOrigin = 0;
		var subtotal = 0.00;
		
		var quantityToDistrib = 0;
		var warehouseOriginId = 0;
		
		var dateId = '';
		var payDate = '';
		var payAmount = 0;
		var payDescription = '';
		//only used for ADD
		var warehouse = '';
		var itemCodeName = '';
		var stock = 0;//virtual stock (inv stock - sal stock)
		var realStock = 0;//real stock (inv stock)
		var stockOrigin = 0;
		var stockRealDestiny = 0;
		var stockVirtual = 0;
		var stockVirtualOrigin = 0;
		
		var arrayItemsDetails = [0];

		if(ACTION === 'save_invoice' && STATE === 'SINVOICE_APPROVED'){
			arrayItemsDetails = getItemsDetails();
		}
		//SaleDetails(Item) setup variables
		if(OPERATION === 'ADD' || OPERATION === 'EDIT' || OPERATION === 'ADD_PAY' || OPERATION === 'EDIT_PAY'){
			warehouseId = $('#cbxModalWarehouses').val();		
			itemId = $('#cbxModalItems').val();
			salePrice = $('#txtModalPrice').val();
			quantity = $('#txtModalQuantity').val();

			if(OPERATION === 'ADD_PAY' || OPERATION === 'EDIT_PAY'){
				payDate = $('#txtModalDate').val();
				var myDate = payDate.split('/');
				dateId = myDate[2]+"-"+myDate[1]+"-"+myDate[0];
				payAmount = $('#txtModalPaidAmount').val();
				payDescription = $('#txtModalDescription').val();
			}
			if(OPERATION === 'ADD'){				
				warehouse = $('#cbxModalWarehouses option:selected').text();
				itemCodeName = $('#cbxModalItems option:selected').text();
				stock = $('#txtModalStock').val();
				realStock = $('#txtModalRealStock').val();
				
				subtotal = Number(quantity) * Number(salePrice);
//				backorder = $('#txtModalBOQuantity').val();
//				if (backorder === 0){
//					var stockOp = 0;
//					if(stock > 0){
//						stockOp = stock;
//					}				
//					var backorderOp = Number(stockOp) - Number(quantity);
//					if(backorderOp >= 0){
//						backorder = 0;
//					}else{
//						backorder = Math.abs(backorderOp);
//					}
							      //virtual stock
					backorder = Number(stock) - Number(quantity);
					if(backorder < 0){
						backorder = Math.abs(backorder);
					}else{
						backorder = 0;
					}
					
//				}	
			}
			if(OPERATION === 'EDIT'){
				lastWarehouse = $('#txtModalLastWarehouse').val();
				warehouse = $('#cbxModalWarehouses option:selected').text();
				lastQuantity = $('#txtModalLastQuantity').val();
				realStock = $('#txtModalRealStock').val();
				stock = $('#txtModalStock').val();
//				stockVirtual = $('#txtModalStockVirtual').val();//por adicionar stockVirtual
				backorder = $('#txtModalBOQuantity').val();
				lastBackorder = $('#txtModalLastBOQuantity').val();
				
				if((warehouseId !== lastWarehouse)){//CAMBIO DE WAREHOUSE
					backorder = Number(stock/*Virtual*/) - Number(quantity);
					if(backorder < 0){
						backorder = Math.abs(backorder);
					}else{
						backorder = 0;
					}
					
				}else if((quantity !== lastQuantity) && (backorder !== lastBackorder)){//CAMBIO DE cantidad y backorder
					//creo q no necesita nada				
				}else if(quantity !== lastQuantity){//CAMBIO DE cantidad						
					var backorder = ((Number(lastQuantity) - Number(backorder)) - Number(quantity)) + Number(stock);
//					backorder = Number(rest) + Number(stock/*Virtual*/);
					if(backorder < 0){
						backorder = Math.abs(backorder);
					}else{
						backorder = 0;
					}
				}else if(backorder !== lastBackorder){//CAMBIO DE backorder
					//creo q no necesita nada
				}
//				backorderOrigin = Number(lastBackorder);
//				if(backorder === lastBackorder) {
//					if((quantity !== lastQuantity)/* || (warehouse !== lastWarehouse)*/){//CAMBIO DE CANTIDAD
//						var rest = (Number(lastQuantity) - Number(backorder)) - Number(quantity);
//	//					backorder = /*Math.abs(*/Number(rest) + Number(stock)/*)*/;
////alert('2');
//						backorder = Number(rest) + Number(stockVirtual);
//						if(backorder < 0){
//							backorder = Math.abs(backorder);
//						}else{
//							backorder = 0;
//						}
//	//					stock = Number(rest) + Number(stock);
//					}
//				}
				
			}
		}
		
		if(OPERATION === 'DISTRIB'){
			warehouseId = $('#cbxModalWarehousesDistrib').val();				//warehouse destino
			warehouse = $('#cbxModalWarehousesDistrib option:selected').text();
			itemId = $('#cbxModalItemsDistrib').val();
			itemCodeName = $('#cbxModalItemsDistrib option:selected').text();
			salePrice = $('#txtModalPriceDistrib').val();
			quantity = $('#txtModalQuantityDistrib').val();						//actual quantity
			quantityToDistrib = $('#txtModalQuantityToDistrib').val();			//quantity to pass
			warehouseOriginId = $('#txtModalWarehousesOrigDistrib').val();		//warehouse origen
			stock = $('#txtModalStockDestDistrib').val();
			stockOrigin = $('#txtModalStockOrigDistrib').val();
//			stockVirtual = $('#txtModalDestinyStockVirtual').val();//por adicionar stockVirtual	
			stockVirtualOrigin = $('#txtModalVirtualStockOrigDistrib').val();
			/*stockNew*/realStock = $('#txtModalRealStockOrigDistrib').val();
			stockRealDestiny = $('#txtModalRealStockDestDistrib').val();
			backorder = $('#txtModalLastBOQuantityDestDistrib').val();
			backorderOrigin = $('#txtModalLastBOQuantityOrigDistrib').val();
			lastBackorder = $('#txtModalLastBOQuantityOrigDistrib').val();
			//////////////////////////////////////////EDIT DE ESTE ALMACEN ORIGEN///////////////////////////////////////////////////
					         //ultima cantidad		//backorder				//nueva cantidad
//			alert(quantity);				
//			alert(backorderOrigin);
//			alert(quantity);
//			alert(quantityToDistrib);
//			var rest = (Number(quantity) - Number(backorderOrigin)) - (Number(quantity)-Number(quantityToDistrib));
////			alert(stockVirtualOrigin);
//					backorderOrigin = Number(rest) + Number(stockVirtualOrigin);
//					if(backorderOrigin < 0){
//						backorderOrigin = Math.abs(backorderOrigin);
//					}else{
//						backorderOrigin = 0;
//					}
			var backorderOrigin = ((Number(quantity) - Number(backorderOrigin)) - (Number(quantity) - Number(quantityToDistrib))) + Number(stockVirtualOrigin);
			if(backorderOrigin < 0){
				backorderOrigin = Math.abs(backorderOrigin);
			}else{
				backorderOrigin = 0;
			}		
			//////////////////////////////////////////EDIT DE ESTE ALMACEN ORIGEN///////////////////////////////////////////////////
			
			//////////////////////////////////////////ADD O EDIT DE EL OTRO ALMACEN DESTINO///////////////////////////////////////////////////
			var otherQuantity = $('#spaQuantity'+itemId+'w'+warehouseId).text();
			if (otherQuantity !== ''){//EDIT OTHER
//				alert(otherQuantity);
//				alert(backorder);
//				alert(otherQuantity);
//				alert(quantityToDistrib);
//				var rest2 = (Number(otherQuantity) - Number(backorder)) - (Number(otherQuantity)+Number(quantityToDistrib));
////				alert(rest2);
//				backorder = Number(rest2) + Number(stock);
//				if(backorder < 0){
//					backorder = Math.abs(backorder);
//				}else{
//					backorder = 0;
//				}	
				var backorder = ((Number(otherQuantity) - Number(backorder)) - (Number(otherQuantity)+Number(quantityToDistrib))) + Number(stock);
				if(backorder < 0){
					backorder = Math.abs(backorder);
				}else{
					backorder = 0;
				}
			}else{//ADD OTHER
//				var stockop = 0;
//				if(stock > 0){
//					stockop = stock;
//				}		
//				var backorderop = Number(stockop) - Number(quantityToDistrib);
//				if(backorderop >= 0){
//					backorder = 0;
//				}else{
//					backorder = Math.abs(backorderop);
//				}				//virtual stock
//				var backorderOp = Number(stock) - Number(quantityToDistrib);
//				if(backorderOp >= 0){
//					backorder = 0;
//				}else{
//					backorder = Math.abs(backorderOp);
//				}
				      //virtual stock
				backorder = Number(stock) - Number(quantityToDistrib);
				if(backorder < 0){
					backorder = Math.abs(backorder);
				}else{
					backorder = 0;
				}
			}
			//////////////////////////////////////////ADD O EDIT DE EL OTRO ALMACEN DESTINO///////////////////////////////////////////////////
					
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
		}																				//remaining quantity = quantity - quantityToDistrib (warehouseOriginId)
																						//other quantity = quantityToDistrib --- if its new (warehouseId)
		if(OPERATION === 'DELETE'){															//other quantity = quantityToDistrib + other quantity --- if its edit (warehouseId)
			itemId = objectTableRowSelected.find('#txtItemId').val();
			warehouseId = objectTableRowSelected.find('#txtWarehouseId'+itemId).val();
		}
		
		if(OPERATION === 'DELETE_PAY'){
			payDate = objectTableRowSelected.find('#txtPayDate').val();
		}
		//setting data
		DATA ={	'purchaseId':purchaseId
				,'movementDocCode':movementDocCode
				,'movementCode':movementCode
				,'noteCode':noteCode
				,'date':date
				,'employee':employee
				,'taxNumber':taxNumber
				,'salesman':salesman
				,'description':description	
				,'exRate':exRate
				,'discount':discount
				,'invoiced':invoiced
				,'invoiceNumber':invoiceNumber
				,'invoiceDescription':invoiceDescription

				,'warehouseId':warehouseId
				,'warehouse':warehouse
				,'itemId':itemId
				,'salePrice':salePrice
				,'lastWarehouse':lastWarehouse
				,'lastQuantity':lastQuantity
				,'quantity':quantity	
				,'backorder':backorder	
				,'lastBackorder':lastBackorder
				,'backorderOrigin':backorderOrigin	
//				,'cifPrice':cifPrice
//				,'exCifPrice':exCifPrice
				,'subtotal':subtotal
			//	,'total':total
				
				,'quantityToDistrib':quantityToDistrib
				,'warehouseOriginId':warehouseOriginId
				
				,'dateId':dateId
				,'payDate':payDate
				,'payAmount':payAmount
				,'payDescription':payDescription
		
				,arrayItemsDetails:arrayItemsDetails
		
				,'ACTION':ACTION
				,'OPERATION':OPERATION
				,'STATE':STATE

				,'itemCodeName':itemCodeName
				,'stock':stock
				,'realStock':realStock
				,'stockOrigin':stockOrigin
				,'stockRealDestiny':stockRealDestiny
//				,'stockNew':stockNew
//				,arrayForValidate:arrayForValidate
			  };
		  
		return DATA;
	}
	
	function highlightTemporally(id){
		//$('#itemRow'+dataSent['itemId']).delay(8000).removeAttr('style');
			$(id).fadeIn(4000).css("background-color","#FFFF66");
			setTimeout(function() {
				$(id).removeAttr('style');
				//$('#itemRow'+itemId).animate({ background: '#fed900'}, "slow");
				 //$('#itemRow'+itemId).fadeOut(400);
				 //$('#itemRow'+itemId).fadeIn(4000).css("background-color","red");
				 //$('#itemRow'+itemId).animate({ backgroundColor: "#f6f6f6" }, 'slow');
			}, 4000);
	}
	
	function fixPrintButtonUrlWhenNewDocument(id) {
		var a_href = $('#btnPrint').attr("href");
		var new_href = a_href.replace(a_href.substr(a_href.lastIndexOf('/') + 1), id + ".pdf");
		$('#btnPrint').attr("href", new_href);
	}
	
	function setOnPendant(DATA, ACTION, OPERATION, STATE, objectTableRowSelected, warehouseId, warehouse, itemId, itemCodeName, salePrice, stock, realStock, stockOrigin, stockRealDestiny, lastWarehouse, lastQuantity, quantity, backorder, lastBackorder, backorderOrigin, subtotal, discount, warehouseOriginId, quantityToDistrib, dateId, payDate, payAmount, payDescription){
		if($('#txtPurchaseIdHidden').val() === ''){
			$('#txtCode').val(DATA[2]);
			$('#txtGenericCode').val(DATA[3]);
			if(ACTION === 'save_invoice'){
				$('#btnApproveState').show();
			}
			$(/*'#btnApproveState*/'#btnReserveNote, #btnPrint, #btnLogicDeleteState, #btnAddPay').show();
			$('#txtPurchaseIdHidden').val(DATA[1]);
			changeLabelDocumentState(STATE); //#UNICORN
		}
		/////////////************************************////////////////////////
		//Item's table setup
		if(OPERATION === 'ADD'){
			if((stock - quantity) < 0){stock = 0;}else{stock = stock - quantity;}
			createRowItemTable(itemId, itemCodeName, /*parseFloat(*/salePrice/*).toFixed(2)*/, /*parseInt(*/quantity/*,10)*/,backorder , warehouse, warehouseId, stock/*(stock - quantity)*/, realStock, parseFloat(subtotal).toFixed(2));
			createEventClickEditItemButton(itemId, warehouseId);
//			if(urlAction === 'save_invoice'){
				createEventClickDistribItemButton(itemId, warehouseId);
//			}
			createEventClickDeleteItemButton(itemId, warehouseId);
//			arrayItemsAlreadySaved.push(itemId);  //push into array of the added item
//			arrayWarehouseItemsAlreadySaved.push(warehouseId);  //push into array of the added warehouses	
			arrayItemsWarehousesAlreadySaved.push(itemId+'w'+warehouseId);  //push into array of the added items+warehouses
			///////////////////
			itemsCounter = itemsCounter + 1;
			//////////////////
			$('#countItems').text(itemsCounter);
			//$('#countItems').text(arrayItemsAlreadySaved.length);
			var total = getTotal();
			$('#total').text(/*parseFloat(*/total/*).toFixed(2)*/+' Bs.');
			
			
			if(discount > 0){
//				var total = getTotal();
				var discAmnt = (total*discount)/100;
				if( $('#discAmnt').length || $('#totalDisc').length ) {
					$('#discAmnt').text(parseFloat(discAmnt).toFixed(2)+' Bs.');
					$('#totalDisc').text(parseFloat(total - discAmnt).toFixed(2)+' Bs.');					
				}else{
					$('#totalLabel').html('<h6 id="totalLabel">Monto sin </br> descuento:</h6>');
					createRowTotalTable('discountTr', 'Descuento', 'DiscAmnt', parseFloat(discAmnt).toFixed(2));
					createRowTotalTable('totalTr', 'Total', 'TotalDisc', parseFloat(total - discAmnt).toFixed(2));
				}	
			}else{
				if( $('#discAmnt').length || $('#totalDisc').length ) {
					$('#totalLabel').html('<h4 id="totalLabel">Total:</h4>');
					$('#discountTr').remove();
					$('#totalTr').remove();
				}
			}
			$('#modalAddItem').modal('hide');
			highlightTemporally('#itemRow'+itemId+'w'+warehouseId);
		}	
		if(OPERATION === 'ADD_PAY'){
			createRowPayTable(dateId, payDate, parseFloat(payAmount).toFixed(2), payDescription);
			createEventClickEditPayButton(dateId);
			createEventClickDeletePayButton(dateId);
			arrayPaysAlreadySaved.push(dateId);  //push into array of the added date
			var totalPay = getTotalPay();
			$('#total2').text(/*parseFloat(*/totalPay/*).toFixed(2)*/+' Bs.');
			$('#modalAddPay').modal('hide');
			highlightTemporally('#payRow'+dateId);
		}
//		row +='<td><span id="spaWarehouse'+itemId+'w'+warehouseId+'">'+warehouse+'</span><input  value="'+warehouseId+'" id="txtWarehouseId'+itemId+'w'+warehouseId+'" ></td>';
		if(OPERATION === 'EDIT'){
			if(lastWarehouse !== warehouseId){
				arrayItemsWarehousesAlreadySaved = jQuery.grep(arrayItemsWarehousesAlreadySaved, function(value) {
					return value !== itemId+'w'+lastWarehouse;
				});
				arrayItemsWarehousesAlreadySaved.push(itemId+'w'+warehouseId);  //push into array of the added items+warehouses
				$('#itemRow'+itemId+'w'+lastWarehouse).attr('id', 'itemRow'+itemId+'w'+warehouseId);
				$('#spaSalePrice'+itemId+'w'+lastWarehouse).attr('id', 'spaSalePrice'+itemId+'w'+warehouseId);
				$('#spaAvaQuantity'+itemId+'w'+lastWarehouse).attr('id', 'spaAvaQuantity'+itemId+'w'+warehouseId);
				$('#spaBOQuantity'+itemId+'w'+lastWarehouse).attr('id', 'spaBOQuantity'+itemId+'w'+warehouseId);
				$('#spaQuantity'+itemId+'w'+lastWarehouse).attr('id', 'spaQuantity'+itemId+'w'+warehouseId);
				$('#spaWarehouse'+itemId+'w'+lastWarehouse).attr('id', 'spaWarehouse'+itemId+'w'+warehouseId);
				$('#spaWarehouse'+itemId+'w'+warehouseId).text(warehouse);
				$('#txtWarehouseId'+itemId).val("");
//				$('input[id="txtWarehouseId'+itemId+'"][value="'+lastWarehouse+'"]').val(warehouseId); //by using val you don't affect the DOM element's value
				$('input[id="txtWarehouseId'+itemId+'"][value="'+lastWarehouse+'"]').attr('value', warehouseId); //by using setAttribute or jQuery's attr you will also affect the DOM element's value
//				$('span:contains("'+lastWarehouseName+'")').text(); //recupera el text de todos los spans q contains()
				$('#spaVirtualStock'+itemId+'w'+lastWarehouse).attr('id', 'spaVirtualStock'+itemId+'w'+warehouseId);
				$('#spaStock'+itemId+'w'+lastWarehouse).attr('id', 'spaStock'+itemId+'w'+warehouseId);
				$('#spaSubtotal'+itemId+'w'+lastWarehouse).attr('id', 'spaSubtotal'+itemId+'w'+warehouseId);
				$('#btnEditItem'+itemId+'w'+lastWarehouse).attr('id', 'btnEditItem'+itemId+'w'+warehouseId);
				$('#btnDeleteItem'+itemId+'w'+lastWarehouse).attr('id', 'btnDeleteItem'+itemId+'w'+warehouseId);
			}
			$('#spaQuantity'+itemId+'w'+warehouseId).text(parseInt(quantity,10));
			var virtualStock = 0;
			if(lastWarehouse !== warehouseId){
				if((Number(stock) - Number(quantity)) < 0){virtualStock = 0;}else{virtualStock = Number(stock) - Number(quantity);}
//				virtualStock = Number(stock) - Number(quantity);
														//lastBackorder
			}else if((quantity !== lastQuantity) && (backorder !== lastBackorder)){//CAMBIO DE cantidad y backorder	
													//lastBackorder
				virtualStock = ((Number(lastQuantity) - Number(lastBackorder)) - Number(quantity)) + Number(backorder) + Number(stock);
				if(virtualStock < 0){virtualStock = 0;}
			}else if(quantity !== lastQuantity){//CAMBIO DE cantidad		
													//lastBackorder
				virtualStock = ((Number(lastQuantity) - Number(lastBackorder)) - Number(quantity)) + Number(stock);
				if(virtualStock < 0){virtualStock = 0;}
//				var diff = 0;
//				if( lastQuantity < quantity ){
//					diff = Number(quantity) - Number(lastQuantity);
//					virtualStock = Number(stock) - Number(diff);
//
//				}else if( lastQuantity > quantity){
//					diff = Number(lastQuantity) - Number(quantity);
//					virtualStock = Number(stock) + Number(diff);
//				}else{
//					diff = 0;
//					virtualStock = Number(stock);
//				}	
//				alert(backorder);
							//lastBackorder
			}else if(backorder !== lastBackorder){//CAMBIO DE backorder
														//lastBackorder
				virtualStock = ((Number(lastQuantity) - Number(lastBackorder)) - Number(quantity)) + Number(backorder) + Number(stock);
				if(virtualStock < 0){virtualStock = 0;}
			}
			$('#spaBOQuantity'+itemId+'w'+warehouseId).text(backorder);
			if(backorder > 0){
				$('#spaBOQuantity'+itemId+'w'+warehouseId).attr('style', 'color:red');
			}else{
				$('#spaBOQuantity'+itemId+'w'+warehouseId).attr('style', 'color:black');
			}
			$('#spaAvaQuantity'+itemId+'w'+warehouseId).text(Number(quantity) - Number(backorder));
			$('#spaStock'+itemId+'w'+warehouseId).text(realStock);	
			$('#spaVirtualStock'+itemId+'w'+warehouseId).text(virtualStock);
			if(virtualStock <= 0){
//				$('#spaVirtualStock'+itemId+'w'+warehouseId).text(0);
				$('#spaVirtualStock'+itemId+'w'+warehouseId).attr('style', 'color:red');
			}else{
//				$('#spaVirtualStock'+itemId+'w'+warehouseId).text(virtualStock);
				$('#spaVirtualStock'+itemId+'w'+warehouseId).attr('style', 'color:black');
			}
			$('#spaSalePrice'+itemId+'w'+warehouseId).text(parseFloat(salePrice).toFixed(2));	
			$('#spaSubtotal'+itemId+'w'+warehouseId).text(parseFloat(Number(quantity) * Number(salePrice)).toFixed(2));
			var total = getTotal();			
			$('#total').text(/*parseFloat(*/total/*).toFixed(2)*/+' Bs.');

			if(discount > 0){
//				var total = getTotal();
				var discAmnt = (total*discount)/100;
				if( $('#discAmnt').length || $('#totalDisc').length ) {
					$('#discAmnt').text(parseFloat(discAmnt).toFixed(2)+' Bs.');
					$('#totalDisc').text(parseFloat(total - discAmnt).toFixed(2)+' Bs.');					
				}else{
					$('#totalLabel').html('<h6 id="totalLabel">Monto sin </br> descuento:</h6>');
					createRowTotalTable('discountTr', 'Descuento', 'DiscAmnt', parseFloat(discAmnt).toFixed(2));
					createRowTotalTable('totalTr', 'Total', 'TotalDisc', parseFloat(total - discAmnt).toFixed(2));
				}	
			}else{
				if( $('#discAmnt').length || $('#totalDisc').length ) {
					$('#totalLabel').html('<h4 id="totalLabel">Total:</h4>');
					$('#discountTr').remove();
					$('#totalTr').remove();
				}
			}
			
			$('#modalAddItem').modal('hide');
			highlightTemporally('#itemRow'+itemId+'w'+warehouseId);
		}	
		if(OPERATION === 'EDIT_PAY'){	
			$('#spaPayDate'+dateId).text(payDate);
			$('#spaPayAmount'+dateId).text(parseFloat(payAmount).toFixed(2));
			$('#spaPayDescription'+dateId).text(payDescription);
//			$('#total2').text(parseFloat(getTotalPay()).toFixed(2)+' Bs.');	
			var totalPay = getTotalPay();
			$('#total2').text(/*parseFloat(*/totalPay/*).toFixed(2)*/+' Bs.');
			$('#modalAddPay').modal('hide');
			highlightTemporally('#payRow'+dateId);
		}
		if(OPERATION === 'DELETE'){	
			arrayItemsWarehousesAlreadySaved = jQuery.grep(arrayItemsWarehousesAlreadySaved, function(value) {
				return value !== itemId+'w'+warehouseId;
			});
//			var itemIdForDelete = objectTableRowSelected.find('#txtItemId').val();
			var subtotal = $('#spaSubtotal'+itemId/*ForDelete*/+'w'+warehouseId).text();		
			hideBittionAlertModal();
			
			objectTableRowSelected.fadeOut("slow", function() {
				$(this).remove();
			});
			///////////////////
			itemsCounter = itemsCounter - 1;
			//////////////////
			$('#countItems').text(itemsCounter);
			//$('#countItems').text(arrayItemsAlreadySaved.length-1);	//because arrayItemsAlreadySaved updates after all is done
			var total = getTotal() - subtotal;
			$('#total').text(parseFloat(total).toFixed(2)+' Bs.');
			
			if(discount > 0){
//				var total = getTotal();
				var discAmnt = (total*discount)/100;
				if( $('#discAmnt').length || $('#totalDisc').length ) {
					$('#discAmnt').text(parseFloat(discAmnt).toFixed(2)+' Bs.');
					$('#totalDisc').text(parseFloat(total - discAmnt).toFixed(2)+' Bs.');					
				}else{
					$('#totalLabel').html('<h6 id="totalLabel">Monto sin </br> descuento:</h6>');
					createRowTotalTable('discountTr', 'Descuento', 'DiscAmnt', parseFloat(discAmnt).toFixed(2));
					createRowTotalTable('totalTr', 'Total', 'TotalDisc', parseFloat(total - discAmnt).toFixed(2));
				}	
			}else{
				if( $('#discAmnt').length || $('#totalDisc').length ) {
					$('#totalLabel').html('<h4 id="totalLabel">Total:</h4>');
					$('#discountTr').remove();
					$('#totalTr').remove();
				}
			}
		}
		if(OPERATION === 'DELETE_PAY'){						
			arrayPaysAlreadySaved = jQuery.grep(arrayPaysAlreadySaved, function(value){
				return value !== payDate;
			});
			subtotal = $('#spaPayAmount'+payDate).text();			
			hideBittionAlertModal();
			objectTableRowSelected.fadeOut("slow", function() {
				$(this).remove();
			});
			$('#total2').text(parseFloat(getTotalPay()-subtotal).toFixed(2)+' Bs.');
		}
		if(OPERATION === 'DEFAULT'){
			if(discount > 0){
				var total = getTotal();
				var discAmnt = (total*discount)/100;
				if( $('#discAmnt').length || $('#totalDisc').length ) {
					$('#discAmnt').text(parseFloat(discAmnt).toFixed(2)+' Bs.');
					$('#totalDisc').text(parseFloat(total - discAmnt).toFixed(2)+' Bs.');					
				}else{
					$('#totalLabel').html('<h6 id="totalLabel">Monto sin </br> descuento:</h6>');
					createRowTotalTable('discountTr', 'Descuento', 'DiscAmnt', parseFloat(discAmnt).toFixed(2));
					createRowTotalTable('totalTr', 'Total', 'TotalDisc', parseFloat(total - discAmnt).toFixed(2));
				}	
			}else{
				if( $('#discAmnt').length || $('#totalDisc').length ) {
					$('#totalLabel').html('<h4 id="totalLabel">Total:</h4>');
					$('#discountTr').remove();
					$('#totalTr').remove();
				}
			}
			
			if(STATE === 'NOTE_RESERVED'){
				$('#btnSaveAll, #btnLogicDeleteState ,#btnReserveNote').hide();
				$('#btnEditReservedNote').show();
				
				$('.columnItemsButtons').hide();
				$('#txtNoteCode, #txtDate, #txtDescription, #txtExRate, #txtDiscount').attr('disabled','disabled');
				$('#cbxCustomers').select2('disable', true); //change to function on BittionMain ??????
				$('#cbxEmployees').select2('disable', true); //change to function on BittionMain ??????
				$('#cbxSalesman').select2('disable', true); //change to function on BittionMain ??????
				$('#cbxTaxNumbers').select2('disable', true); //change to function on BittionMain ??????
				$('#chkInv').attr("disabled", true);
				if ($('#btnAddItemSO').length > 0){//existe
					$('#btnAddItemSO').hide();
				}
				changeLabelDocumentState('NOTE_RESERVED');
			}
		}
		
				
		if(OPERATION === 'DISTRIB'){
			var tQuantity= Number(quantity) - Number(quantityToDistrib);
			$('#spaQuantity'+itemId+'w'+warehouseOriginId).text(tQuantity);
			var virtualStock = 0;
//				var diff = 0;
//				if( quantity < tQuantity ){
//					diff = Number(tQuantity) - Number(quantity);
//					stockReserved = Number(stock) - Number(diff);
//
//				}else if( quantity > tQuantity){
//					diff = Number(quantity) - Number(tQuantity);
//					alert(stockOrigin);
//					alert(diff);
//					virtualStock = Number(stockOrigin) + Number(diff);
//				}else{
//					diff = 0;
//					stockReserved = Number(stock);
//				}	
//			alert(stockReserved);
			virtualStock = ((Number(quantity) - Number(lastBackorder)) - Number(tQuantity)) + Number(stockOrigin);
			if(virtualStock < 0){virtualStock = 0;}

			$('#spaBOQuantity'+itemId+'w'+warehouseOriginId).text(backorderOrigin);
			if(backorderOrigin > 0){
				$('#spaBOQuantity'+itemId+'w'+warehouseOriginId).attr('style', 'color:red');
			}else{
				$('#spaBOQuantity'+itemId+'w'+warehouseOriginId).attr('style', 'color:black');
			}
			$('#spaAvaQuantity'+itemId+'w'+warehouseOriginId).text(Number(tQuantity) - Number(backorderOrigin));
			
			$('#spaSubtotal'+itemId+'w'+warehouseOriginId).text(parseFloat(Number(tQuantity) * Number(salePrice)).toFixed(2));
			
			var otherQuantity = $('#spaQuantity'+itemId+'w'+warehouseId).text();
			if (otherQuantity !== ''){//EDIT OTHER
				var otherLastBackorder = $('#spaBOQuantity'+itemId+'w'+warehouseId).text();
				var otherTQuantity = Number(otherQuantity) + Number(quantityToDistrib);
				var otherVirtualStock = 0;
				otherVirtualStock = ((Number(otherQuantity) - Number(otherLastBackorder)) - Number(otherTQuantity)) + Number(stock);
				if(otherVirtualStock < 0){otherVirtualStock = 0;}
				$('#spaQuantity'+itemId+'w'+warehouseId).text(otherTQuantity);
				$('#spaSubtotal'+itemId+'w'+warehouseId).text(parseFloat(Number(otherTQuantity) * Number(salePrice)).toFixed(2));
//				$('#spaVirtualStock'+itemId+'w'+warehouseId).text(Number(stock)-Number(quantityToDistrib));
				$('#spaVirtualStock'+itemId+'w'+warehouseId).text(otherVirtualStock);
				$('#spaBOQuantity'+itemId+'w'+warehouseId).text(backorder);
				if(backorder > 0){
					$('#spaBOQuantity'+itemId+'w'+warehouseId).attr('style', 'color:red');
				}else{
					$('#spaBOQuantity'+itemId+'w'+warehouseId).attr('style', 'color:black');
				}
			}else{//ADD OTHER
				var otherSubtotal = Number(quantityToDistrib) * Number(salePrice);
//				createRowItemTable(itemId, itemCodeName, salePrice, quantity, backorder, warehouse, warehouseId, (stock - quantity), stockReal, parseFloat(subtotal).toFixed(2));
				//createRowItemTable(itemId, itemCodeName, salePrice, quantity, backorder , warehouse, warehouseId, (stock - quantity), stockReal, parseFloat(subtotal).toFixed(2));
				if((stock - quantity) < 0){stock = 0;}else{stock = stock - quantity;}
				createRowItemTable(itemId, itemCodeName, salePrice, quantityToDistrib, backorder, warehouse, warehouseId, stock,/*(stock - quantityToDistrib),*/ stockRealDestiny, parseFloat(otherSubtotal).toFixed(2));
				createEventClickEditItemButton(itemId, warehouseId);
//				if(urlAction === 'save_invoice'){
					createEventClickDistribItemButton(itemId, warehouseId);
//				}
				createEventClickDeleteItemButton(itemId, warehouseId);
				arrayItemsWarehousesAlreadySaved.push(itemId+'w'+warehouseId);  //push into array of the added items+warehouses
				///////////////////
				itemsCounter = itemsCounter + 1;
				//////////////////
				$('#countItems').text(itemsCounter);
			}
//			$('#spaVirtualStock'+itemId+'w'+warehouseOriginId).text(Number(stockOrigin)+Number(quantityToDistrib));
			$('#spaVirtualStock'+itemId+'w'+warehouseOriginId).text(virtualStock);
			if(virtualStock <= 0){
//				$('#spaVirtualStock'+itemId+'w'+warehouseId).text(0);
				$('#spaVirtualStock'+itemId+'w'+warehouseOriginId).attr('style', 'color:red');
			}else{
//				$('#spaVirtualStock'+itemId+'w'+warehouseId).text(stockReserved);
				$('#spaVirtualStock'+itemId+'w'+warehouseOriginId).attr('style', 'color:black');
			}
			var total = getTotal();
			$('#total').text(/*parseFloat(*/total/*).toFixed(2)*/+' Bs.');
			$('#modalDistribItem').modal('hide');
			highlightTemporally('#itemRow'+itemId+'w'+warehouseOriginId);
			highlightTemporally('#itemRow'+itemId+'w'+warehouseId);
//			highlightTemporally('#payRow'+dateId);
		}
		showGrowlMessage('ok', 'Cambios guardados.');
	}
	
	function setOnApproved(DATA, STATE, ACTION){
		$('#txtCode').val(DATA[2]);
		$('#txtGenericCode').val(DATA[3]);
		$('#btnApproveState, #btnLogicDeleteState, #btnSaveAll, .columnItemsButtons').hide();
		$('#btnCancellState').show();
		$('#txtCode, #txtNoteCode, #txtDate, #txtDescription, #txtExRate, #txtDiscount').attr('disabled','disabled');
		$('#cbxCustomers, #cbxEmployees, #cbxTaxNumbers, #cbxSalesman').select2('disable', true); //change to function on BittionMain ??????
		if ($('#btnAddItem').length > 0){//existe
			$('#btnAddItem').hide();
		}
		changeLabelDocumentState(STATE); //#UNICORN
		showGrowlMessage('ok', 'Aprobado.');
	}
	
	function setOnCancelled(STATE){
		$('#btnCancellState').hide();
		changeLabelDocumentState(STATE); //#UNICORN
		showGrowlMessage('ok', 'Cancelado.');
	}
	
	function setOnError(){
		showGrowlMessage('error', 'Vuelva a intentarlo.');
	}
	
	function setOnBlock(){
//		alert($('#modalAddItem').length);
		$('#modalAddItem').modal('hide');
		showBittionAlertModal({content:'no se puede seguir editando bla bla', btnYes:'Aceptar', btnNo:''});
		$('#bittionBtnYes').click(function(){
			if(urlAction === 'save_order'){
				window.location = urlModuleController + 'index_order';
			}	
			if(urlAction === 'save_invoice'){
				window.location = urlModuleController + 'index_invoice';
			}
		});
//		showGrowlMessage('error', 'asdasdasdasd.');
	}
	
	function ajax_save_movement(OPERATION, STATE, objectTableRowSelected/*, arrayForValidate*/){//SAVE_IN/ADD/PENDANT
		var ACTION = urlAction;
		var dataSent = setOnData(ACTION, OPERATION, STATE, objectTableRowSelected/*, arrayForValidate*/);
		//Ajax Interaction	
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_save_movement",//saveSale			
            data:dataSent,
            beforeSend: showProcessing(),
            success: function(data){
				$('#boxMessage').html('');//this for order goes here
				$('#processing').text('');//this must go at the begining not at the end, otherwise, it won't work when validation is send
				var dataReceived = data.split('|');
				//////////////////////////////////////////
//				if(dataReceived[0] === 'NOTE_APPROVED' || dataReceived[0] === 'NOTE_CANCELLED'){
//						var arrayItemsStocks = dataReceived[3].split(',');
//						updateMultipleStocks(arrayItemsStocks, 'spaStock');//What is this for???????????
//				}
				switch(dataReceived[0]){
					case 'NOTE_PENDANT':
						setOnPendant(dataReceived, ACTION, OPERATION, STATE, objectTableRowSelected, dataSent['warehouseId'], dataSent['warehouse'], dataSent['itemId'], dataSent['itemCodeName'], dataSent['salePrice'], dataSent['stock'], dataSent['realStock'], dataSent['stockOrigin'], dataSent['stockRealDestiny'], dataSent['lastWarehouse'], dataSent['lastQuantity'], dataSent['quantity'], dataSent['backorder'], dataSent['lastBackorder'], dataSent['backorderOrigin'], dataSent['subtotal'], dataSent['discount'], dataSent['warehouseOriginId'], dataSent['quantityToDistrib'], dataSent['dateId'], dataSent['payDate'], dataSent['payAmount'], dataSent['payDescription']);
						break;
					case 'NOTE_APPROVED':
						setOnApproved(dataReceived, STATE, ACTION);
						break;
					case 'NOTE_CANCELLED':
						setOnCancelled(STATE);
						break;
					case 'SINVOICE_PENDANT':
						setOnPendant(dataReceived, ACTION, OPERATION, STATE, objectTableRowSelected, dataSent['warehouseId'], dataSent['warehouse'], dataSent['itemId'], dataSent['itemCodeName'], dataSent['salePrice'], dataSent['stock'], dataSent['realStock'], dataSent['stockOrigin'], dataSent['stockRealDestiny'], dataSent['lastWarehouse'], dataSent['lastQuantity'], dataSent['quantity'], dataSent['backorder'], dataSent['lastBackorder'], dataSent['backorderOrigin'], dataSent['subtotal'], dataSent['discount'], dataSent['warehouseOriginId'], dataSent['quantityToDistrib'], dataSent['dateId'], dataSent['payDate'], dataSent['payAmount'], dataSent['payDescription']);
						break;
					case 'SINVOICE_APPROVED':
						setOnApproved(dataReceived, STATE, ACTION);
						break;
					case 'SINVOICE_CANCELLED':
						setOnCancelled(STATE);
						break;
					case 'VALIDATION':
						setOnValidation(dataReceived, ACTION);
						break;
					case 'BLOCK':
						setOnBlock();
						break;		
					case 'ERROR':
						setOnError();
						break;
				}
			},
			error:function(data){
				$('#boxMessage').html(''); 
				$('#processing').text(''); 
				setOnError();
			}
        });
	}
	
	//*************************************************************************************************************************//
	
	function ajax_logic_delete(purchaseId,/* purchaseId2, */type, /*type2,*/ index, genCode){
		$.ajax({
				type:"POST",
				url:urlModuleController + "ajax_logic_delete",			
				data:{purchaseId: purchaseId
				//	,purchaseId2: purchaseId2
					,type: type
				//	,type2: type2
					,genCode: genCode
				},
				success: function(data){
					if(data === 'success'){
						showBittionAlertModal({content:'Se eliminó el documento en estado Pendiente', btnYes:'Aceptar', btnNo:''});
						$('#bittionBtnYes').click(function(){
							window.location = urlModuleController + index;
						});

					}else if(data === 'BLOCK'){
						setOnBlock();
					}else{	
						showGrowlMessage('error', 'Vuelva a intentarlo.');
					}
				},
				error:function(data){
					showGrowlMessage('error', 'Vuelva a intentarlo.');
				}
			});
		}
		
	function ajax_change_reserved(saleId, reserve, genCode, action){
		$.ajax({
				type:"POST",
				url:urlModuleController + "ajax_change_reserved",			
				data:{saleId: saleId
					,reserve: reserve
					,genCode:genCode
					,action:action
				},
				success: function(data){
					var dataReceived = data.split('|');
					if(dataReceived[0] === 'success'){
						showBittionAlertModal({content:'Se cambio el documento en estado Reservado', btnYes:'Aceptar', btnNo:''});
						$('#bittionBtnYes').click(function(){
//							window.location = urlModuleController + 'save_order/' + 'id:' +dataReceived[1];
							window.location = urlModuleController + urlAction + '/id:' +dataReceived[1];
//							location.reload();// NO DEJA VER EL MENSAJE DE EXITO
						});
//					$('#btnSetToPendant').hide();
//					$('#cbxWarehouses').select2('enable', true); 
//					$('#btnApproveState, #btnPrint, #btnLogicDeleteState, #btnAddItem, .columnItemsButtons').show();
//					$('#btnAddItem').show();
//					$('.columnItemsButtons').show();
//					$('#txtCode, #txtNoteCode, #txtDate, #txtDescription, #txtExRate, #txtDiscount').removeAttr('disabled');
//					changeLabelDocumentState('ORDER_PENDANT'); //#UNICORN
					}else if(dataReceived[0] === 'BLOCK'){
						setOnBlock();
					}else{
						showGrowlMessage('error', 'Vuelva a intentarlo.');
					}
				},
				error:function(data){
					showGrowlMessage('error', 'Vuelva a intentarlo.');
				}
			});
		}	
		
	//Get prices and stock for the fist item when modal inititates
	function ajax_initiate_modal_add_item_in_order(itemsWarehousesAlreadySaved){
		 $.ajax({
			type:"POST",
			url:urlModuleController + "ajax_initiate_modal_add_item_in_order",			
			data:{itemsWarehousesAlreadySaved: itemsWarehousesAlreadySaved},				
			beforeSend: showProcessing(),
			success: function(data){
				$('#processing').text('');
				$('#boxModalInitiateIWPS').html(data);
				$('#txtModalQuantity').val('');  
				$('#boxModalBOQuantity').attr('style', 'display:none');
				initiateModal();
				fnBittionSetSelectsStyle();
				$('#cbxModalItems').bind("change",function(){ //must be binded 'cause dropbox is loaded by a previous ajax'
					//updates price and stock in modal
					ajax_update_warehouse_price_stock_modal_order(itemsWarehousesAlreadySaved);
				});							
				$('#txtModalStock').keypress(function(){return false;});//find out why this is necessary
				////////////////////////////////////////////////////////////////////////////////// till convert this float validation script to function
				$('#txtModalPrice').keypress(function(event){
					if($.browser.mozilla === true){
						if (event.which === 8 || event.keyCode === 37 || event.keyCode === 39 || event.keyCode === 9 || event.keyCode === 16 || event.keyCode === 46){
							return true;
						}
					}
					if ((event.which !== 46 || $(this).val().indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});
				////////////////////////////////////////////////////////////////////////////////// till convert this float validation script to function
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#processing').text('');
			}
        });
	}	
	
	//Get prices and stock for the fist item when modal inititates
	function ajax_initiate_modal_add_item_in(itemsWarehousesAlreadySaved){ 
		 $.ajax({
			type:"POST",
			url:urlModuleController + "ajax_initiate_modal_add_item_in",			
			data:{itemsWarehousesAlreadySaved: itemsWarehousesAlreadySaved/*, date: $('#txtDate').val()*/},				
			beforeSend: showProcessing(),
			success: function(data){
				$('#processing').text('');
				$('#boxModalInitiateIWPS').html(data);
				$('#txtModalQuantity').val('');  
				initiateModal();
				fnBittionSetSelectsStyle();
				$('#cbxModalItems').bind("change",function(){ //must be binded 'cause dropbox is loaded by a previous ajax'
					//updates price and stock in modal
					ajax_update_warehouse_price_stock_modal(itemsWarehousesAlreadySaved);
				});
//				$('#cbxModalWarehouses').bind("change",function(){ //must be binded 'cause dropbox is loaded by a previous ajax'
//					//updates items, price and stock in modal
//					ajax_update_items_price_stock_modal();
//				});								
				$('#txtModalStock').keypress(function(){return false;});//find out why this is necessary
				
//				$('#txtModalPrice').keydown(function(event) {
//					validateOnlyFloatNumbers(event);			
//				});
				////////////////////////////////////////////////////////////////////////////////// till convert this float validation script to function
				$('#txtModalPrice').keypress(function(event){
					if($.browser.mozilla === true){
						if (event.which === 8 || event.keyCode === 37 || event.keyCode === 39 || event.keyCode === 9 || event.keyCode === 16 || event.keyCode === 46){
							return true;
						}
					}
					if ((event.which !== 46 || $(this).val().indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});
				////////////////////////////////////////////////////////////////////////////////// till convert this float validation script to function
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#processing').text('');
			}
        });
	}
	
	//Get available warehouses for the item selected to be edited$('#spaWarehouse'+itemId)
	function ajax_initiate_modal_edit_item_in(itemsWarehousesAlreadySaved, objectTableRowSelected /*,itemIdForEdit, warehouseIdForEdit*/){
		var itemIdForEdit = objectTableRowSelected.find('#txtItemId').val();
		var warehouseIdForEdit = objectTableRowSelected.find('#txtWarehouseId'+itemIdForEdit).val();
//		var warehouseName = objectTableRowSelected.find('#spaWarehouse'+itemIdForEdit+'w'+warehouseIdForEdit).text();
		 $.ajax({
			type:"POST",
			url:urlModuleController + "ajax_initiate_modal_edit_item_in",			
			data:{itemsWarehousesAlreadySaved: itemsWarehousesAlreadySaved, itemIdForEdit: itemIdForEdit, warehouseIdForEdit: warehouseIdForEdit/*, date: $('#txtDate').val()*/},				
			beforeSend: showProcessing(),
			success: function(data){
				$('#processing').text('');
				$('#boxModalInitiateIWPS').html(data);
				
				$('#boxModalBOQuantity').attr('style', 'display:inline');
//				$('#txtModalQuantity').val(objectTableRowSelected.find('#spaQuantity'+itemIdForEdit).text());
				$('#cbxModalItems').empty();
				$('#cbxModalItems').append('<option value="'+itemIdForEdit+'">'+objectTableRowSelected.find('td:first').text()+'</option>');
				$('#txtModalPrice').val(objectTableRowSelected.find('#spaSalePrice'+itemIdForEdit+'w'+warehouseIdForEdit).text());	
				////////////////////////////////////////ver si es necesario q jalen de la bd, no por ahora
				$('#txtModalStock').val(objectTableRowSelected.find('#spaVirtualStock'+itemIdForEdit+'w'+warehouseIdForEdit).text());//VAMOS A BLOKEAR ESTO TEMPORALMENTE //MEJOR Q JALE ESTO DE LA BASE
				$('#txtModalRealStock').val(objectTableRowSelected.find('#spaStock'+itemIdForEdit+'w'+warehouseIdForEdit).text());
				////////////////////////////////////////
				$('#txtModalLastWarehouse').val(warehouseIdForEdit);
				$('#txtModalBOQuantity').val(objectTableRowSelected.find('#spaBOQuantity'+itemIdForEdit+'w'+warehouseIdForEdit).text());
				$('#txtModalLastBOQuantity').val(objectTableRowSelected.find('#spaBOQuantity'+itemIdForEdit+'w'+warehouseIdForEdit).text());
//				$('#txtModalLastWarehouseName').val(warehouseName);
				$('#txtModalQuantity').val(objectTableRowSelected.find('#spaQuantity'+itemIdForEdit+'w'+warehouseIdForEdit).text());
				$('#txtModalLastQuantity').val(objectTableRowSelected.find('#spaQuantity'+itemIdForEdit+'w'+warehouseIdForEdit).text());
				initiateModal();
				fnBittionSetSelectsStyle();
				$('#cbxModalWarehouses').bind("change",function(){ //must be binded 'cause dropbox is loaded by a previous ajax'
					//updates items, price and stock in modal
					ajax_update_stock_modal();
					$('#boxModalBOQuantity').attr('style', 'display:none');	
				});
				
//				$('#cbxModalItems').bind("change",function(){ //must be binded 'cause dropbox is loaded by a previous ajax'
//					//updates price and stock in modal
//					ajax_update_price_stock_modal();
//				});
//				$('#txtModalQuantity').val(objectTableRowSelected.find('#spaQuantity'+itemIdForEdit).text());	
			
//				$('#txtModalPrice').keydown(function(event) {
//					validateOnlyFloatNumbers(event);			
//				});
				////////////////////////////////////////////////////////////////////////////////// till convert this float validation script to function
				$('#txtModalPrice').keypress(function(event){
					if($.browser.mozilla === true){
						if (event.which === 8 || event.keyCode === 37 || event.keyCode === 39 || event.keyCode === 9 || event.keyCode === 16 || event.keyCode === 46){
							return true;
						}
					}
					if ((event.which !== 46 || $(this).val().indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});
				////////////////////////////////////////////////////////////////////////////////// till convert this float validation script to function
				$('#txtModalStock').keypress(function(){return false;});//find out why this is necessary
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#processing').text('');
			}
		});
	}
	
	function ajax_initiate_modal_distrib_item_in(itemsWarehousesAlreadySaved, objectTableRowSelected){
		var itemIdForEdit = objectTableRowSelected.find('#txtItemId').val();
		var warehouseIdForEdit = objectTableRowSelected.find('#txtWarehouseId'+itemIdForEdit).val();
		var movementDocCode = $('#txtCode').val();
		 $.ajax({
			type:"POST",
			url:urlModuleController + "ajax_initiate_modal_distrib_item_in",			
			data:{movementDocCode:movementDocCode, itemsWarehousesAlreadySaved: itemsWarehousesAlreadySaved, itemIdForEdit: itemIdForEdit, warehouseIdForEdit: warehouseIdForEdit},				
			beforeSend: showProcessing(),
			success: function(data){
				$('#processing').text('');
				$('#boxModalInitiateIWS').html(data);
				$('#txtModalQuantityToDistrib').val('');  
//				$('#txtModalQuantityDistrib').val(objectTableRowSelected.find('#spaQuantity'+itemIdForEdit).text());
				$('#cbxModalItemsDistrib').empty();
				$('#cbxModalItemsDistrib').append('<option value="'+itemIdForEdit+'">'+objectTableRowSelected.find('td:first').text()+'</option>');
				$('#txtModalWarehousesOrigDistrib').val(objectTableRowSelected.find('#txtWarehouseId'+itemIdForEdit).val());
				$('#txtModalPriceDistrib').val(objectTableRowSelected.find('#spaSalePrice'+itemIdForEdit+'w'+warehouseIdForEdit).text());
				$('#txtModalQuantityDistrib').val(objectTableRowSelected.find('#spaQuantity'+itemIdForEdit+'w'+warehouseIdForEdit).text());
				$('#txtModalStockOrigDistrib').val(objectTableRowSelected.find('#spaVirtualStock'+itemIdForEdit+'w'+warehouseIdForEdit).text());//MEJOR Q JALE ESTO DE LA BASE
				$('#txtModalRealStockOrigDistrib').val(objectTableRowSelected.find('#spaStock'+itemIdForEdit+'w'+warehouseIdForEdit).text());
				$('#txtModalLastBOQuantityOrigDistrib').val(objectTableRowSelected.find('#spaBOQuantity'+itemIdForEdit+'w'+warehouseIdForEdit).text());
				
				initiateModalDistrib();
				fnBittionSetSelectsStyle();
				$('#cbxModalWarehousesDistrib').bind("change",function(){ //must be binded 'cause dropbox is loaded by a previous ajax'
					//updates items, price and stock in modal
					ajax_update_stock_modal();
				});
				$('#txtModalStockDistrib').keypress(function(){return false;});//find out why this is necessary
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#processing').text('');
			}
		});
	}
	
	function ajax_update_stock_modal(){ 
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_update_stock_modal",			
            data:{item: $('#cbxModalItems').val(),/*itemsWarehousesAlreadySaved: itemsWarehousesAlreadySaved,*/
			warehouse: $('#cbxModalWarehouses').val()},
            beforeSend: showProcessing(),
            success: function(data){
				$('#processing').text("");
				$('#boxModalStocks').html(data);
//				fnBittionSetSelectsStyle();
//				$('#cbxModalItems').bind("change",function(){ //must be binded 'cause dropbox is loaded by a previous ajax'
////					//updates price and stock in modal
//					ajax_update_price_stock_modal();
//				});
				
//				$('#txtModalPrice').keydown(function(event) {
//					validateOnlyFloatNumbers(event);			
//				});
				$('#txtModalPrice').keypress(function(event){
					if($.browser.mozilla === true){
						if (event.which === 8 || event.keyCode === 37 || event.keyCode === 39 || event.keyCode === 9 || event.keyCode === 16 || event.keyCode === 46){
							return true;
						}
					}
					if ((event.which !== 46 || $(this).val().indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});
			},
			error:function(data){
				$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
				$('#processing').text('');
			}
        });
	}
	
	function ajax_update_price_stock_modal(){ 
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_update_price_stock_modal",			
            data:{item: $('#cbxModalItems').val(),/*itemsWarehousesAlreadySaved: itemsWarehousesAlreadySaved,*/
			warehouse: $('#cbxModalWarehouses').val()
			,date: $('#txtDate').val()},
            beforeSend: showProcessing(),
            success: function(data){
				$('#processing').text("");
				$('#boxModalPriceStock').html(data);
//				fnBittionSetSelectsStyle();
//				$('#cbxModalItems').bind("change",function(){ //must be binded 'cause dropbox is loaded by a previous ajax'
////					//updates price and stock in modal
//					ajax_update_price_stock_modal();
//				});
				
//				$('#txtModalPrice').keydown(function(event) {
//					validateOnlyFloatNumbers(event);			
//				});
				$('#txtModalPrice').keypress(function(event){
					if($.browser.mozilla === true){
						if (event.which === 8 || event.keyCode === 37 || event.keyCode === 39 || event.keyCode === 9 || event.keyCode === 16 || event.keyCode === 46){
							return true;
						}
					}
					if ((event.which !== 46 || $(this).val().indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});
			},
			error:function(data){
				$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
				$('#processing').text('');
			}
		 });
	}
	
	function ajax_initiate_modal_add_pay(/*paysAlreadySaved/*,payDebt*/){
		 $.ajax({
            type:"POST",
            url:urlModuleController + "ajax_initiate_modal_add_pay",			
		    data:{
//				paysAlreadySaved: paysAlreadySaved,
//					,payDebt: payDebt
//				,discount: $('#txtDiscount').val()
			date:$('#txtDate').val()
			,docCode:$('#txtCode').val()
		},
            beforeSend: showProcessing(),
            success: function(data){
				$('#processing').text('');
				$('#boxModalInitiatePay').html(data); 
				$('#txtModalDescription').val('');  
				initiateModalPay();
				fnBittionSetTypeDate();
				$("#txtModalDate").datepicker({
					showButtonPanel: true
				});
//				$('#txtModalPaidAmount').keydown(function(event) {
//					validateOnlyFloatNumbers(event);			
//				});
				$('#txtModalPaidAmount').keypress(function(event){
					if($.browser.mozilla === true){
						if (event.which === 8 || event.keyCode === 37 || event.keyCode === 39 || event.keyCode === 9 || event.keyCode === 16 || event.keyCode === 46){
							return true;
						}
					}
					if ((event.which !== 46 || $(this).val().indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});
			},
			error:function(data){
				$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
				$('#processing').text('');
			}
        });
	}
	
	function ajax_initiate_modal_edit_pay(objectTableRowSelected/*paysAlreadySaved/*,payDebt*/){
		var payIdForEdit = objectTableRowSelected.find('#txtPayDate').val();
		 $.ajax({
            type:"POST",
            url:urlModuleController + "ajax_initiate_modal_edit_pay",			
		    data:{
//				paysAlreadySaved: paysAlreadySaved,
//					,payDebt: payDebt
//				,discount: $('#txtDiscount').val()
//			date:$('#txtDate').val(),
			docCode:$('#txtCode').val()
		},
            beforeSend: showProcessing(),
            success: function(data){
				$('#processing').text('');
				$('#boxModalInitiatePay').html(data); 
//				$('#txtModalDescription').val(''); 
				$('#txtModalDate').val(objectTableRowSelected.find('#spaPayDate'+payIdForEdit).text());
				$('#txtModalPaidAmount').val(objectTableRowSelected.find('#spaPayAmount'+payIdForEdit).text());
				$('#txtModalDescription').val(objectTableRowSelected.find('#spaPayDescription'+payIdForEdit).text());
				$('#txtModalAmountHidden').val(objectTableRowSelected.find('#spaPayAmount'+payIdForEdit).text());
				initiateModalPay();
				fnBittionSetTypeDate();
				$("#txtModalDate").datepicker({
					showButtonPanel: true
				});
//				$('#txtModalPaidAmount').keydown(function(event) {
//					validateOnlyFloatNumbers(event);			
//				});
				$('#txtModalPaidAmount').keypress(function(event){
					if($.browser.mozilla === true){
						if (event.which === 8 || event.keyCode === 37 || event.keyCode === 39 || event.keyCode === 9 || event.keyCode === 16 || event.keyCode === 46){
							return true;
						}
					}
					if ((event.which !== 46 || $(this).val().indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});
			},
			error:function(data){
				$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
				$('#processing').text('');
			}
        });
	}
	
	//Update price
	function ajax_update_warehouse_price_stock_modal_order(itemsWarehousesAlreadySaved){
		$.ajax({
			 type:"POST",
			url:urlModuleController + "ajax_update_warehouse_price_stock_modal_order",			
			data:{itemsWarehousesAlreadySaved: itemsWarehousesAlreadySaved, item: $('#cbxModalItems').val() /*,warehouse: $('#cbxModalWarehouses').val()*/ ,date: $('#txtDate').val()},
			beforeSend: showProcessing(),
			success: function(data){
				$('#processing').text("");
				$('#boxModalWarehousePriceStock').html(data);
				fnBittionSetSelectsStyle();
				$('#cbxModalWarehouses').bind("change",function(){ //must be binded 'cause dropbox is loaded by a previous ajax'
					//updates items, price and stock in modal
					ajax_update_price_stock_modal();
				});	
				////////////////////////////////////////////////////////////////////////////////// till convert this float validation script to function
				$('#txtModalPrice').keypress(function(event){
					if($.browser.mozilla === true){
						if (event.which === 8 || event.keyCode === 37 || event.keyCode === 39 || event.keyCode === 9 || event.keyCode === 16 || event.keyCode === 46){
							return true;
						}
					}
					if ((event.which !== 46 || $(this).val().indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});
				////////////////////////////////////////////////////////////////////////////////// till convert this float validation script to function
				$('#txtModalStock').bind("keypress",function(){ //must be binded 'cause input is re-loaded by a previous ajax'
					return false;	//find out why this is necessary
				});
			},
			error:function(data){
				$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
				$('#processing').text('');
			}
        });
	}
	
	//Update price
	function ajax_update_warehouse_price_stock_modal(itemsWarehousesAlreadySaved){
		$.ajax({
			 type:"POST",
			url:urlModuleController + "ajax_update_warehouse_price_stock_modal",			
			data:{itemsWarehousesAlreadySaved: itemsWarehousesAlreadySaved, item: $('#cbxModalItems').val() /*,warehouse: $('#cbxModalWarehouses').val()*/ ,date: $('#txtDate').val()},
			beforeSend: showProcessing(),
			success: function(data){
				$('#processing').text("");
				$('#boxModalWarehousePriceStock').html(data);
				fnBittionSetSelectsStyle();
				$('#cbxModalWarehouses').bind("change",function(){ //must be binded 'cause dropbox is loaded by a previous ajax'
					//updates items, price and stock in modal
					ajax_update_price_stock_modal();
				});	
				////////////////////////////////////////////////////////////////////////////////// till convert this float validation script to function
				$('#txtModalPrice').keypress(function(event){
					if($.browser.mozilla === true){
						if (event.which === 8 || event.keyCode === 37 || event.keyCode === 39 || event.keyCode === 9 || event.keyCode === 16 || event.keyCode === 46){
							return true;
						}
					}
					if ((event.which !== 46 || $(this).val().indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});
				////////////////////////////////////////////////////////////////////////////////// till convert this float validation script to function
				$('#txtModalStock').bind("keypress",function(){ //must be binded 'cause input is re-loaded by a previous ajax'
					return false;	//find out why this is necessary
				});
			},
			error:function(data){
				$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
				$('#processing').text('');
			}
        });
	}
	//Update stock
//	function ajax_update_stock_modal_1(){ 
//		$.ajax({
//            type:"POST",
//            url:urlModuleController + "ajax_update_stock_modal_1",			
//            data:{item: $('#cbxModalItems').val(),
//				warehouse: $('#cbxModalWarehouses').val()},
//            beforeSend: showProcessing(),
//            success: function(data){
//				$('#processing').text("");
//				$('#boxModalStock').html(data);
//				$('#txtModalStock').bind("keypress",function(){ //must be binded 'cause input is re-loaded by a previous ajax'
//					return false;	//find out why this is necessary
//				});
//			},
//			error:function(data){
//				$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
//				$('#processing').text('');
//			}
//        });
//	}
	
	
	//************************************************************************//
	//////////////////////////////////END-AJAX FUNCTIONS////////////////////////btnGenerateMovements
	//************************************************************************//
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$('#btnCancellAll').click(function(){
		//alert('Se cancela entrada');
		changeStateCancelledAll();
		return false;
	});
	
	function changeStateCancelledAll(){
		showBittionAlertModal({content:'¿Está seguro de eliminar este documento y su factura y movimientos?'});
		$('#bittionBtnYes').click(function(){
			var purchaseId = $('#txtPurchaseIdHidden').val();
			var genCode = $('#txtGenericCode').val();
//			var purchaseId2=0;
			var type;
//			var type2=0;
			var index;
			switch(urlAction){
				case 'save_order':
					index = 'index_order';
					type = 'NOTE_CANCELLED';
					break;	
				case 'save_invoice':
					index = 'index_invoice';
					type = 'SINVOICE_LOGIC_DELETED';
					break;	
			}
			ajax_cancell_all(purchaseId, type, index, genCode);
			hideBittionAlertModal();
		});
	}
	
	function ajax_cancell_all(purchaseId,/* purchaseId2, */type, /*type2,*/ index, genCode){
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_cancell_all",			
            data:{purchaseId: purchaseId
			//	,purchaseId2: purchaseId2
				,type: type
			//	,type2: type2
				,genCode: genCode
			},
            success: function(data){
				if(data === 'success'){
					showBittionAlertModal({content:'Se eliminó el documento su factura y movimientos', btnYes:'Aceptar', btnNo:''});
					$('#bittionBtnYes').click(function(){
						window.location = urlModuleController + index;
					});
					
				}else{
					showGrowlMessage('error', 'Vuelva a intentarlo.');
				}
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
			}
        });
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$('#btnGenerateMovements').click(function(){
		generateMovements();
		return false;
	});
	
	function generateMovements(){
		showBittionAlertModal({content:'¿Esta seguro de crear los movimientos correspondientes?'});
		$('#bittionBtnYes').click(function(){
			var arrayItemsDetails = [];
			arrayItemsDetails = getItemsDetails();
			var error = validateBeforeSaveAll(arrayItemsDetails);
			if( error === ''){
				if(urlAction === 'save_invoice'){
					ajax_generate_movements(arrayItemsDetails);
				}
			}else{
				$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
			}
			hideBittionAlertModal();
		});
	}
	
	function ajax_generate_movements(arrayItemsDetails){
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_generate_movements",			
            data:{arrayItemsDetails: arrayItemsDetails 
//				  ,purchaseId:$('#txtPurchaseIdHidden').val()
				  ,date:$('#txtDate').val()
//				  ,customer:$('#cbxCustomers').val()
//				  ,employee:$('#cbxEmployees').val()
//				  ,taxNumber:$('#cbxTaxNumbers').val()
//				  ,salesman:$('#cbxSalesman').val()	
				  ,description:$('#txtDescription').val()
//				  ,exRate:$('#txtExRate').val()
//				  ,note_code:$('#txtNoteCode').val()
				  ,genericCode:$('#txtGenericCode').val()
//				  ,originCode:$('#txtOriginCode').val()
			  },
            beforeSend: showProcessing(),
            success: function(data){			
				var arrayCatch = data.split('|');
				if(arrayCatch[0] === 'creado'){


//		$('#btnApproveState, #btnLogicDeleteState, #btnSaveAll, .columnItemsButtons, #btnApproveStateFull').hide();
//		$('#btnCancellState').show();
//		$('#txtCode, #txtNoteCode, #txtDate, #cbxCustomers, #cbxEmployees, #cbxTaxNumbers, #cbxSalesman, #txtDescription, #txtExRate').attr('disabled','disabled');
//		if ($('#btnAddItem').length > 0){//existe
//			$('#btnAddItem').hide();
//		}
//		changeLabelDocumentState('NOTE_APPROVED'); //#UNICORN
					showBittionAlertModal({content:'Se crearon los movimientos correspondientes', btnYes:'Aceptar', btnNo:''});
						$('#bittionBtnYes').click(function(){
							window.location = '../../inv_movements/index_sale_out/document_code:'+ $('#txtGenericCode').val() +'/search:yes';
						});
							

//					$('#boxMessage').html('');
//					showGrowlMessage('ok', 'Movimientos creados.');
				}
				$('#processing').text('');
			},
			error:function(data){
				//$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#processing').text('');
			}
        });
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$('#btnApproveStateFull').click(function(){
		changeStateApprovedFull();
		return false;
	});
	
	function changeStateApprovedFull(){
		showBittionAlertModal({content:'Al APROBAR este documento ya no se podrá hacer más modificaciones y se crearan MOVs y FACs. ¿Está seguro?'});
		$('#bittionBtnYes').click(function(){
			var arrayItemsDetails = [];
			arrayItemsDetails = getItemsDetails();
			var error = validateBeforeSaveAll(arrayItemsDetails);
			if( error === ''){
				if(urlAction === 'save_order'){
					ajax_change_state_approved_movement_in_full(arrayItemsDetails);
				}
			}else{
				$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
			}
			hideBittionAlertModal();
		});
	}
	
	function ajax_change_state_approved_movement_in_full(arrayItemsDetails){
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_change_state_approved_movement_in_full",			
            data:{arrayItemsDetails: arrayItemsDetails 
				  ,purchaseId:$('#txtPurchaseIdHidden').val()
				  ,date:$('#txtDate').val()
				  ,customer:$('#cbxCustomers').val()
				  ,employee:$('#cbxEmployees').val()
				  ,taxNumber:$('#cbxTaxNumbers').val()
				  ,salesman:$('#cbxSalesman').val()	
				  ,description:$('#txtDescription').val()
				  ,exRate:$('#txtExRate').val()
				   ,discount:$('#txtDiscount').val()
				  ,note_code:$('#txtNoteCode').val()
				  ,genericCode:$('#txtGenericCode').val()
			  },
            beforeSend: showProcessing(),
            success: function(data){			
				var arrayCatch = data.split('|');
				if(arrayCatch[0] === 'aprobado'){


//		$('#txtCode').val(DATA[2]);
//		$('#txtGenericCode').val(DATA[3]);
		$('#btnApproveState, #btnLogicDeleteState, #btnSaveAll, .columnItemsButtons, #btnApproveStateFull').hide();
		$('#btnCancellState').show();
		$('#txtCode, #txtNoteCode, #txtDate, #cbxCustomers, #cbxEmployees, #cbxTaxNumbers, #cbxSalesman, #txtDescription, #txtExRate, #txtDiscount').attr('disabled','disabled');
		if ($('#btnAddItem').length > 0){//existe
			$('#btnAddItem').hide();
		}
		changeLabelDocumentState('NOTE_APPROVED'); //#UNICORN
		


					$('#boxMessage').html('');
					showGrowlMessage('ok', 'Entrada aprobada.');
				}
				$('#processing').text('');
			},
			error:function(data){
				//$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#processing').text('');
			}
        });
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
//END SCRIPT	
});
