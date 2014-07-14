$(document).ready(function(){
//START SCRIPT

//	var globalPeriod = $('#globalPeriod').text(); // this value is obtained from the main template AND from MainBittion.js

	var arrayItemsAlreadySaved = []; 
	var itemsCounter = 0;
	var arraySupplierItemsAlreadySaved = []; 
	startEventsWhenExistsItems();
	
	var arrayCostsAlreadySaved = []; 
	startEventsWhenExistsCosts();
	
	var arrayPaysAlreadySaved = []; 
	startEventsWhenExistsPays();

	var payDebt = 0;
	startEventsWhenExistsDebts();
	
	
	function startEventsWhenExistsDebts(){		
		payDebt =0;
		var discount = $('#txtDiscount').val();
		var	payPaid = getTotalPay();
		var payTotal = getTotal();
		var payTotalPlusDisc = Number(payTotal) - ((Number(payTotal) * Number(discount))/100);
		var payDebtDirt = Number(payTotalPlusDisc) - Number(payPaid);
		payDebt = parseFloat(payDebtDirt).toFixed(2);
		return payDebt;
	}
	
	//gets a list of the item ids in the document details
	function itemsListWhenExistsItems(){
		var arrayAux = [];
		arrayItemsAlreadySaved = [];
		arrayAux = getItemsDetails();
		if(arrayAux[0] !== 0){
			for(var i=0; i< arrayAux.length; i++){
				 arrayItemsAlreadySaved[i] = arrayAux[i]['inv_item_id'];
			}
		}
		if(arrayItemsAlreadySaved.length === 0){  //For fix undefined index
			arrayItemsAlreadySaved = [0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
		}
		
		return arrayItemsAlreadySaved; //NOT SURE TO PUT THIS LINE	
	}
	
	//gets a list of the supplier ids in the document details
	function suppliersListWhenExistsItems(){
		var arrayAux = [];
		arraySupplierItemsAlreadySaved = [];
		arrayAux = getItemsDetails();
		if(arrayAux[0] !== 0){
			for(var i=0; i< arrayAux.length; i++){
				 arraySupplierItemsAlreadySaved[i] = arrayAux[i]['inv_supplier_id'];
			}
		}
		if(arraySupplierItemsAlreadySaved.length === 0){  //For fix undefined index
			arraySupplierItemsAlreadySaved = [0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
		}
		
		return arraySupplierItemsAlreadySaved; //NOT SURE TO PUT THIS LINE	
	}

	function startEventsWhenExistsItems(){
		var arrayAux = [];
		arrayAux = getItemsDetails();
		if(arrayAux[0] !== 0){
			for(var i=0; i< arrayAux.length; i++){
				arrayItemsAlreadySaved[i] = arrayAux[i]['inv_item_id'];
				arraySupplierItemsAlreadySaved[i] = arrayAux[i]['inv_supplier_id'];
				createEventClickEditItemButton(arrayAux[i]['inv_item_id'],arrayAux[i]['inv_supplier_id']);
				createEventClickDeleteItemButton(arrayAux[i]['inv_item_id'],arrayAux[i]['inv_supplier_id']);	
				itemsCounter = itemsCounter + 1;  //like this cause iteration something++ apparently not supported by javascript, gave me NaN error				 
			}
		}
	}
		
	//When exist costs, it starts its events and fills arrayCostsAlreadySaved
	function startEventsWhenExistsCosts(){		/*STANDBY*/
		var arrayAux = [];
		arrayAux = getCostsDetails();
		if(arrayAux[0] !== 0){
			for(var i=0; i< arrayAux.length; i++){
				 arrayCostsAlreadySaved[i] = arrayAux[i]['inv_price_type_id'];
				 createEventClickEditCostButton(arrayAux[i]['inv_price_type_id']);
				 createEventClickDeleteCostButton(arrayAux[i]['inv_price_type_id']);			 
			}
		}
		/*else{
			alert('esta vacio');
		}*/
	}
	
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
		/*else{
			alert('esta vacio');
		}*/
	}
	
	//validates before add item quantity
	function validateItem(supplier, item, quantity, /*exFobPrice*/exSubtotal){
		var error = '';
		if(supplier === ''){error+='<li>El campo "Proveedor" no puede estar vacio</li>';}
		if(item === ''){error+='<li>El campo "Item" no puede estar vacio</li>';}
		if(quantity === ''){
			error+='<li>El campo "Cantidad" no puede estar vacio</li>'; 
		}else{
			if(parseInt(quantity, 10) == 0){
				error+='<li>El campo "Cantidad" no puede ser cero</li>'; 
			}
		}
//		if(exFobPrice === ''){
//			error+='<li>El campo "Precio Unitario" no puede estar vacio</li>'; 
//		}else{
////o si puede ser cero el precio?			
//			if(parseFloat(price).toFixed(2) == 0){
//				error+='<li>El campo "P/U" no puede ser cero</li>'; 
//			}
//		}		
		if(exSubtotal === ''){
			error+='<li>El campo "Subtotal" no puede estar vacio</li>'; 
		}
		return error;
	}
	
	function validateCost(costCodeName, costExAmount){
		var error = '';		
		if(costExAmount === ''){
			error+='<li>El campo "Monto" no puede estar vacio</li>'; 
		}else{
//o si puede ser cero el precio?			
			if(parseFloat(costExAmount).toFixed(2) == 0){
				error+='<li>El campo "Monto" no puede ser cero</li>'; 
			}
		}
		if(costCodeName === ''){error+='<li>El campo "Costo" no puede estar vacio</li>';}
		return error;
	}
	
	function validateEditPay(payDate, payAmount, payHiddenAmount){
		var error = '';
		if(payDate === ''){
			error+='<li>El campo "Fecha" no puede estar vacio</li>'; 
		}		
		if(payAmount === ''){
			error+='<li>El campo "Monto a Pagar" no puede estar vacio</li>'; 
		}else{
			var payDebt2 = Number(payDebt) + Number(payHiddenAmount);
			if(parseFloat(payAmount).toFixed(2) == 0){
				error+='<li>El campo "Monto a Pagar" no puede ser cero</li>'; 
			}else if (payAmount > payDebt2){
				error+='<li>El campo "Monto a Pagar" no puede ser mayor a la deuda</li>'; 
			}
		}
		return error;
	}
	
	function validateAddPay(payDate, payAmount){
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
			if(payAmount > payDebt){
				error+='<li>El campo "Monto a Pagar" no puede ser mayor a la deuda</li>'; 
			}
			if(parseFloat(payAmount).toFixed(2) == 0){//si pongo === no valida el 0
				error+='<li>El campo "Monto a Pagar" no puede ser cero</li>'; 
			}
		}
		return error;
	}
	
	function validateBeforeSaveAll(arrayItemsDetails, result){
		var error = '';
		var date = $('#txtDate').val();
		var dateYear = date.split('/');
		var discount = $('#txtDiscount').val();
		var exRate = $('#txtExRate').val();
		
		if(date === ''){	error+='<li> El campo "Fecha" no puede estar vacio </li>'; }
		if(dateYear[2] !== globalPeriod){	error+='<li> El año '+dateYear[2]+' de la fecha del documento no es valida, ya que se encuentra en la gestión '+ globalPeriod +'.</li>'; }
		if(discount === ''){	error+='<li> El campo "Descuento" no puede estar vacio </li>'; }
		if(exRate === ''){	error+='<li> El campo "Tipo de Cambio" no puede estar vacio </li>'; }
		if(arrayItemsDetails[0] === 0){error+='<li> Debe existir al menos 1 "Item" </li>';}
		var itemZero = findIfOneItemHasQuantityZero(arrayItemsDetails);
		if(itemZero > 0){error+='<li> Se encontraron '+ itemZero +' "Items" con "Cantidad" 0, no puede existir ninguno </li>';}
		if(result === 'error'){	error+='<li> El "No. Factura Proforma" no puede repetirse </li>'; }
//		alert(result);
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
			case 'ORDER_PENDANT':
				$('#documentState').addClass('label-warning');
				$('#documentState').text('ORDEN PENDIENTE');
				break;
			case 'ORDER_APPROVED':
				$('#documentState').removeClass('label-warning').addClass('label-success');
				$('#documentState').text('ORDEN APROBADA');
				break;
			case 'ORDER_CANCELLED':
				$('#documentState').removeClass('label-success').addClass('label-important');
				$('#documentState').text('ORDEN CANCELADA');
				break;
				case 'INVOICE_PENDANT':
				$('#documentState').addClass('label-warning');
				$('#documentState').text('FACTURA PENDIENTE');
				break;
			case 'INVOICE_APPROVED':
				$('#documentState').removeClass('label-warning').addClass('label-success');
				$('#documentState').text('FACTURA APROBADA');
				break;
			case 'INVOICE_CANCELLED':
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
	
	function initiateModalCost(){
		$('#modalAddCost').modal({
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

	function initiateModalAddItem(result){
		var error = validateBeforeSaveAll([{0:0}], result);//I send [{0:0}] 'cause it doesn't care to validate if arrayItemsDetails is empty or not
		if( error === ''){
			if(arrayItemsAlreadySaved.length === 0){  //For fix undefined index
				arrayItemsAlreadySaved = [0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
				arraySupplierItemsAlreadySaved = [0];
			}
			$('#btnModalAddItem').show();
			$('#btnModalEditItem').hide();
			$('#boxModalValidateItem').html('');//clear error message
			ajax_initiate_modal_add_item_in(arrayItemsAlreadySaved, arraySupplierItemsAlreadySaved);
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}	
	}
	
	function initiateModalAddCost(result){
		var error = validateBeforeSaveAll([{0:0}], result);//I send [{0:0}] 'cause it doesn't care to validate if arrayItemsDetails is empty or not
		if( error === ''){	
			if(arrayCostsAlreadySaved.length === 0){  //For fix undefined index
				arrayCostsAlreadySaved = [0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
			}
			$('#btnModalAddCost').show();
			$('#btnModalEditCost').hide();
			$('#boxModalValidateCost').html('');//clear error message
			ajax_initiate_modal_add_cost(arrayCostsAlreadySaved);
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}	
	}
	
	function initiateModalAddPay(result){
		var error = validateBeforeSaveAll([{0:0}], result);//I send [{0:0}] 'cause it doesn't care to validate if arrayItemsDetails is empty or not
		if( error === ''){	
			if(arrayPaysAlreadySaved.length === 0){  //For fix undefined index
				arrayPaysAlreadySaved = [0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
			}
			$('#btnModalAddPay').show();
			$('#btnModalEditPay').hide();
			$('#boxModalValidatePay').html('');//clear error message
			ajax_initiate_modal_add_pay(arrayPaysAlreadySaved, parseFloat(payDebt).toFixed(2));
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}	
	}
	
	function initiateModalEditItem(result, objectTableRowSelected){
		var error = validateBeforeSaveAll([{0:0}], result);//I send [{0:0}] 'cause it doesn't care to validate if arrayItemsDetails is empty or not
		if( error === ''){
			var itemIdForEdit = objectTableRowSelected.find('#txtItemId').val();  
			var supplierIdForEdit = objectTableRowSelected.find('#txtSupplierId'+itemIdForEdit).val();
			$('#btnModalAddItem').hide();
			$('#btnModalEditItem').show();
			$('#boxModalValidatePay').html('');//clear error message
			$('#cbxModalSuppliers').empty();
			$('#cbxModalSuppliers').append('<option value="'+supplierIdForEdit+'">'+objectTableRowSelected.find('#spaSupplier'+itemIdForEdit).text()+'</option>');
			$('#cbxModalItems').empty();
			$('#cbxModalItems').append('<option value="'+itemIdForEdit+'">'+objectTableRowSelected.find('td:first').text()+'</option>');
			$('#txtModalQuantity').val(objectTableRowSelected.find('#spaQuantity'+itemIdForEdit+'s'+supplierIdForEdit).text());
			$('#txtModalExSubtotal').val(objectTableRowSelected.find('#spaExSubtotal'+itemIdForEdit+'s'+supplierIdForEdit).text());
			$('#txtModalPrice').val(objectTableRowSelected.find('#spaExFobPrice'+itemIdForEdit+'s'+supplierIdForEdit).text());
			initiateModal();
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}	
	}
	
	function initiateModalEditCost(result, objectTableRowSelected){
		var error = validateBeforeSaveAll([{0:0}], result);//I send [{0:0}] 'cause it doesn't care to validate if arrayItemsDetails is empty or not
		if( error === ''){
			var costIdForEdit = objectTableRowSelected.find('#txtCostId').val();  //
			$('#btnModalAddCost').hide();
			$('#btnModalEditCost').show();
			$('#boxModalValidateCost').html('');//clear error message
			$('#txtModalCostExAmount').val(objectTableRowSelected.find('#spaCostExAmount'+costIdForEdit).text());
			$('#cbxModalCosts').empty();
			$('#cbxModalCosts').append('<option value="'+costIdForEdit+'">'+objectTableRowSelected.find('td:first').text()+'</option>');
			initiateModalCost();
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	}
	
	function initiateModalEditPay(result, objectTableRowSelected){
		var error = validateBeforeSaveAll([{0:0}], result);//I send [{0:0}] 'cause it doesn't care to validate if arrayItemsDetails is empty or not
		if( error === ''){
			var payIdForEdit = objectTableRowSelected.find('#txtPayDate').val();  //
			$('#btnModalAddPay').hide();
			$('#btnModalEditPay').show();
			$('#boxModalValidatePay').html('');//clear error message
			$('#txtModalDate').val(objectTableRowSelected.find('#spaPayDate'+payIdForEdit).text());
			$('#txtModalPaidAmount').val(objectTableRowSelected.find('#spaPayAmount'+payIdForEdit).text());
			$('#txtModalDescription').val(objectTableRowSelected.find('#spaPayDescription'+payIdForEdit).text());
			$('#txtModalAmountHidden').val(objectTableRowSelected.find('#spaPayAmount'+payIdForEdit).text());
			initiateModalPay();
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}	
	}
	
	function createEventClickEditItemButton(itemId, supplierId){
			$('#btnEditItem'+itemId+'s'+supplierId).bind("click",function(){ //must be binded 'cause loaded live with javascript'
					var objectTableRowSelected = $(this).closest('tr');
//					initiateModalEditItem(objectTableRowSelected);
					ajax_check_code_duplicity(initiateModalEditItem, objectTableRowSelected);//passing callback as a parameter into another function
					return false; //avoid page refresh
			});
	}
	
	function createEventClickDeleteItemButton(itemId, supplierId){
		$('#btnDeleteItem'+itemId+'s'+supplierId).bind("click",function(e){ //must be binded 'cause loaded live with javascript'
					var objectTableRowSelected = $(this).closest('tr');
//					deleteItem(objectTableRowSelected);
					ajax_check_code_duplicity(deleteItem, objectTableRowSelected);//passing callback as a parameter into another function
					//return false; //avoid page refresh
					e.preventDefault();
		});
	}
	
	function deleteItem(result, objectTableRowSelected){
		var arrayItemsDetails = getItemsDetails();
		var error = validateBeforeSaveAll([{0:0}], result);//Send [{0:0}] 'cause I won't use arrayItemsDetails classic validation, I will use it differently for this case (as done below)
		if(arrayItemsDetails.length === 1){error+='<li> Debe existir al menos 1 "Item" </li>';}
		if( error === ''){
			showBittionAlertModal({content:'¿Está seguro de eliminar este item?'});
			$('#bittionBtnYes').click(function(){
				if(urlAction === 'save_order'){
					ajax_save_movement('DELETE', 'ORDER_PENDANT', objectTableRowSelected/*, []*/);
				}
				if(urlAction === 'save_invoice'){
					ajax_save_movement('DELETE', 'PINVOICE_PENDANT', objectTableRowSelected/*, []*/);
				}
				return false; //avoid page refresh
			});
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	}
	
	function deletePay(result, objectTableRowSelected){
		//var arrayPaysDetails = getPaysDetails();
		var error = validateBeforeSaveAll([{0:0}], result);//Send [{0:0}] 'cause I won't use arrayItemsDetails classic validation, I will use it differently for this case (as done below)
		if( error === ''){
			showBittionAlertModal({content:'¿Está seguro de eliminar este pago?'});
			$('#bittionBtnYes').click(function(){
				ajax_save_movement('DELETE_PAY', 'PINVOICE_PENDANT', objectTableRowSelected/*, []*/);
				return false;
			});
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	}
	
	function deleteCost(result, objectTableRowSelected){
		//var arrayCostsDetails = getCostsDetails();
		var error = validateBeforeSaveAll([{0:0}], result);//Send [{0:0}] 'cause I won't use arrayItemsDetails classic validation, I will use it differently for this case (as done below)
		if( error === ''){
			showBittionAlertModal({content:'¿Está seguro de eliminar este costo?'});
			$('#bittionBtnYes').click(function(){
				ajax_save_movement('DELETE_COST', 'PINVOICE_PENDANT', objectTableRowSelected/*, []*/);
				return false;
			});
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	}
	
//	function deleteList(supplier){
//		if ( $('#txtItemId').length ){
//		
//			if(confirm('Esta por cambiar de proveedor, esto borrara la lista de items esta seguro?')){	
//				$('#tablaItems tbody tr').each(function(){
//					var objectTableRowSelected = $('#txtItemId').closest('tr')
//					var itemIdForDelete = objectTableRowSelected.find('#txtItemId').val();  //
//					arrayItemsAlreadySaved = jQuery.grep(arrayItemsAlreadySaved, function(value){
//						return value != itemIdForDelete;
//					});
//					objectTableRowSelected.remove();
//				})				
//			}else{
//		//		alert(supplier);
//				$('#cbxSuppliers').val(supplier);
//			}
//		}
//	}
	
	function createEventClickEditCostButton(costId){
			$('#btnEditCost'+costId).bind("click",function(){ //must be binded 'cause loaded live with javascript'
					var objectTableRowSelected = $(this).closest('tr');
//					initiateModalEditCost(objectTableRowSelected);
					ajax_check_code_duplicity(initiateModalEditCost, objectTableRowSelected);//passing callback as a parameter into another function
					return false; //avoid page refresh
			});
	}
	
	function createEventClickDeleteCostButton(costId){
		$('#btnDeleteCost'+costId).bind("click",function(){ //must be binded 'cause loaded live with javascript'
					var objectTableRowSelected = $(this).closest('tr');
//					deleteCost(objectTableRowSelected);
					ajax_check_code_duplicity(deleteCost, objectTableRowSelected);//passing callback as a parameter into another function
					return false; //avoid page refresh
		});
	}
	
	function createEventClickEditPayButton(dateId){
			$('#btnEditPay'+dateId).bind("click",function(){ //must be binded 'cause loaded live with javascript'
					var objectTableRowSelected = $(this).closest('tr');
					startEventsWhenExistsDebts();
//					initiateModalEditPay(objectTableRowSelected);
					ajax_check_code_duplicity(initiateModalEditPay, objectTableRowSelected);//passing callback as a parameter into another function
					return false; //avoid page refresh
			});
	}
	
	function createEventClickDeletePayButton(dateId){
		$('#btnDeletePay'+dateId).bind("click",function(){ //must be binded 'cause loaded live with javascript'
					var objectTableRowSelected = $(this).closest('tr');
//					deletePay(objectTableRowSelected);
					ajax_check_code_duplicity(deletePay, objectTableRowSelected);//passing callback as a parameter into another function
					return false; //avoid page refresh
		});
	}
	
	
	// (GC Ztep 3) function to fill Items list when saved in modal triggered by addItem()
	function createRowItemTable(itemId, itemCodeName, exFobPrice, quantity, supplier, supplierId, exSubtotal){
		var row = '<tr id="itemRow'+itemId+'s'+supplierId+'" >';
		row +='<td><span id="spaItemName'+itemId+'">'+itemCodeName+'</span><input type="hidden" value="'+itemId+'" id="txtItemId" ></td>';
		row +='<td><span id="spaSupplier'+itemId+'">'+supplier+'</span><input type="hidden" value="'+supplierId+'" id="txtSupplierId'+itemId+'" ></td>';
		row +='<td><span id="spaQuantity'+itemId+'s'+supplierId+'">'+quantity+'</span></td>';
		row +='<td><span id="spaExFobPrice'+itemId+'s'+supplierId+'">'+ parseFloat(exFobPrice).toFixed(2)+'</span></td>';
		row +='<td><span id="spaExSubtotal'+itemId+'s'+supplierId+'">'+parseFloat(exSubtotal).toFixed(2)+'</span></td>';
		row +='<td class="columnItemsButtons">';
		row +='<a class="btn btn-primary" href="#" id="btnEditItem'+itemId+'s'+supplierId+'" title="Editar"><i class="icon-pencil icon-white"></i></a> ';
		row +='<a class="btn btn-danger" href="#" id="btnDeleteItem'+itemId+'s'+supplierId+'" title="Eliminar"><i class="icon-trash icon-white"></i></a>';
		row +='</td>';
		row +='</tr>';
		$('#tablaItems tbody').prepend(row);
	}
	
	function createRowCostTable(costId, costCodeName, costExAmount){
		var row = '<tr id="costRow'+costId+'" >';
		row +='<td><span id="spaCostName'+costId+'">'+costCodeName+'</span><input type="hidden" value="'+costId+'" id="txtCostId" ></td>';
		row +='<td><span id="spaCostExAmount'+costId+'">'+costExAmount+'</span></td>';
		row +='<td class="columnCostsButtons">';
		row +='<a class="btn btn-primary" href="#" id="btnEditCost'+costId+'" title="Editar"><i class="icon-pencil icon-white"></i></a> ';
		row +='<a class="btn btn-danger" href="#" id="btnDeleteCost'+costId+'" title="Eliminar"><i class="icon-trash icon-white"></i></a>';
		row +='</td>';
		row +='</tr>';
		$('#tablaCosts > tbody:last').append(row);
	}
	//genera el codigo HTML para la creacion de una fila de la tabla de Pagos
	function createRowPayTable(dateId, payDate, payAmount, payDescription){
		var row = '<tr id="payRow'+dateId+'" >';
		row +='<td><span id="spaPayDate'+dateId+'">'+payDate+'</span><input type="hidden" value="'+dateId+'" id="txtPayDate" ></td>';
		row +='<td><span id="spaPayDescription'+dateId+'">'+payDescription+'</span></td>';
		row +='<td><span id="spaPayAmount'+dateId+'">'+payAmount+'</span></td>';
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
	
	
	function addItem(){
		var supplier = $('#cbxModalSuppliers option:selected').text();
		var itemCodeName = $('#cbxModalItems option:selected').text();
		var quantity = $('#txtModalQuantity').val();		
		var exSubtotal = $('#txtModalExSubtotal').val();
		
		var error = validateItem(supplier, itemCodeName, quantity, exSubtotal);
		if(error === ''){
			if(urlAction === 'save_order'){
				ajax_save_movement('ADD', 'ORDER_PENDANT', ''/*, []*/);
			}
			if(urlAction === 'save_invoice'){
				ajax_save_movement('ADD', 'PINVOICE_PENDANT', ''/*, []*/);
			}
		}else{
			$('#boxModalValidateItem').html('<ul>'+error+'</ul>');
		}
	}
	
	function editItem(){
		var supplier = $('#cbxModalSuppliers option:selected').text();
		var quantity = $('#txtModalQuantity').val();
		var itemCodeName = $('#cbxModalItems option:selected').text();
//		var exFobPrice = $('#txtModalPrice').val();
		var exSubtotal = $('#txtModalExSubtotal').val();
		
		var error = validateItem(supplier, itemCodeName, quantity, exSubtotal/*parseFloat(exFobPrice).toFixed(2)*/); 
		if(error === ''){
			
			if(urlAction === 'save_order'){
				ajax_save_movement('EDIT', 'ORDER_PENDANT', ''/*, []*/);
			}
			if(urlAction === 'save_invoice'){
				ajax_save_movement('EDIT', 'PINVOICE_PENDANT', ''/*, []*/);
			}
		}else{
			$('#boxModalValidateItem').html('<ul>'+error+'</ul>');
		}
	}
		
	function addPay(){
		var payDate = $('#txtModalDate').val();
		var payAmount = $('#txtModalPaidAmount').val();
		var error = validateAddPay(payDate, payAmount);  
		if(error === ''){
			if(urlAction  === 'save_invoice'){
				ajax_save_movement('ADD_PAY', 'PINVOICE_PENDANT', ''/*, []*/);
			}
		}else{
			$('#boxModalValidatePay').html('<ul>'+error+'</ul>');
		}
	}
	
	function editPay(){
		var payDate = $('#txtModalDate').val();
		var payAmount = $('#txtModalPaidAmount').val();
		var payHiddenAmount = $('#txtModalAmountHidden').val();
		var error = validateEditPay(payDate, payAmount, payHiddenAmount);  
		if(error === ''){
			if(urlAction === 'save_invoice'){
				ajax_save_movement('EDIT_PAY', 'PINVOICE_PENDANT', ''/*, []*/);
			}
		}else{
			$('#boxModalValidatePay').html('<ul>'+error+'</ul>');
		}
	}	
		
	function addCost(){
		var costCodeName = $('#cbxModalCosts option:selected').text();
		var costExAmount = $('#txtModalCostExAmount').val();
		var error = validateCost(costCodeName, costExAmount); 
		if(error === ''){
			if(urlAction === 'save_invoice'){
				ajax_save_movement('ADD_COST', 'PINVOICE_PENDANT', ''/*, []*/);
			}
		}else{
			$('#boxModalValidateCost').html('<ul>'+error+'</ul>');
		}
	}
	
	function editCost(){
		var costId = $('#cbxModalCosts').val();
		var costCodeName = $('#cbxModalCosts option:selected').text();
		var costExAmount = $('#txtModalCostExAmount').val();
		var error = validateCost(costCodeName, costExAmount); 
		if(error === ''){
			if(urlAction === 'save_invoice'){
				ajax_save_movement('EDIT_COST', 'PINVOICE_PENDANT', ''/*, []*/);
			}
		}else{
			$('#boxModalValidateCost').html('<ul>'+error+'</ul>');
		}
	}	
	//esto suma todos los subtotales y retorna el total	
	function getTotal(){
		var arrayAux = [];
		var total = 0;
		arrayAux = getItemsDetails();
		if(arrayAux[0] !== 0){
			for(var i=0; i< arrayAux.length; i++){
//				 var exFobPrice = (arrayAux[i]['ex_fob_price']);
//				 var quantity = (arrayAux[i]['quantity']);
//				 total = total + (exFobPrice*quantity);
				 var exSubtotal = (arrayAux[i]['ex_subtotal']);
				  total = total + Number(exSubtotal);
			}
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
				 total = total + Number(amount);
			}
		}
		return parseFloat(total).toFixed(2); 
	}
	//esto suma todos los costos y devuelve el total
	function getTotalCost(){
		var arrayAux = [];
		var total = 0;
		arrayAux = getCostsDetails();
		if(arrayAux[0] !== 0){
			for(var i=0; i< arrayAux.length; i++){
				 var exAmount = (arrayAux[i]['ex_amount']);
				 total = total + Number(exAmount);
			}
		}
		return parseFloat(total).toFixed(2); 
	}
	
	//get all items for save a purchase
	function getItemsDetails(){		
		var arrayItemsDetails = [];
		var itemId = '';
		var itemExFobPrice = '';
		var itemQuantity = '';
		var itemSupplierId = '';
		var itemExSubtotal = '';
		
		var exRate = $('#txtExRate').val();
		var itemFobPrice = '';
		
		
		
		$('#tablaItems tbody tr').each(function(){		
			itemId = $(this).find('#txtItemId').val();
			itemSupplierId = $(this).find('#txtSupplierId'+itemId).val();
			itemExFobPrice = $(this).find('#spaExFobPrice'+itemId+'s'+itemSupplierId).text();
			itemQuantity = $(this).find('#spaQuantity'+itemId+'s'+itemSupplierId).text();
			itemExSubtotal = $(this).find('#spaExSubtotal'+itemId+'s'+itemSupplierId).text();
			
			itemFobPrice = itemExFobPrice * exRate;//(parseFloat(itemExPrice).toFixed(2))
			arrayItemsDetails.push({'inv_item_id':itemId, 'ex_fob_price':itemExFobPrice, 'quantity':itemQuantity, 'inv_supplier_id':itemSupplierId, 'fob_price':/*parseFloat(*/itemFobPrice/*).toFixed(2)*/, 'ex_subtotal':itemExSubtotal});
			
		});
		
		if(arrayItemsDetails.length === 0){  //For fix undefined index
			arrayItemsDetails = [0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
		}
		
		return arrayItemsDetails; 		
	}
	
	//get all costs for save a invoice
	function getCostsDetails(){		
		var arrayCostsDetails = [];
		var costId = '';
		var costExAmount = '';
		
		$('#tablaCosts tbody tr').each(function(){		
			costId = $(this).find('#txtCostId').val();
			costExAmount = $(this).find('#spaCostExAmount'+costId).text();
			
			arrayCostsDetails.push({'inv_price_type_id':costId, 'ex_amount':costExAmount});
		});
		
		if(arrayCostsDetails.length === 0){  //For fix undefined index
			arrayCostsDetails = [0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
		}
		
		return arrayCostsDetails; 		
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
	
	function saveAll(result){
		var arrayItemsDetails = [];
		arrayItemsDetails = getItemsDetails();
//		var arrayCostsDetails = [];
//		arrayCostsDetails = getCostsDetails();
//		var arrayPaysDetails = [];
//		arrayPaysDetails = getPaysDetails();
		var error = validateBeforeSaveAll(arrayItemsDetails, result);
		if( error === ''){
			if(urlAction === 'save_order'){
				ajax_save_movement('DEFAULT', 'ORDER_PENDANT', ''/*, []*/);
			}
			if(urlAction === 'save_invoice'){
				ajax_save_movement('DEFAULT', 'PINVOICE_PENDANT', ''/*, []*/);
			}
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	}
	
	// (AEA Ztep 2) action when button Aprobar Entrada Almacen is pressed
	function changeStateApproved(result){
		var arrayForValidate = [];
		arrayForValidate = getItemsDetails();
		var error = validateBeforeSaveAll(arrayForValidate, result);
		if( error === ''){
			if(urlAction === 'save_order'){
				showBittionAlertModal({content:'Al APROBAR este documento ya no se podrá hacer más modificaciones. ¿Está seguro?'});
				$('#bittionBtnYes').click(function(){
					ajax_save_movement('DEFAULT', 'ORDER_APPROVED', ''/*, arrayForValidate*/);
					hideBittionAlertModal();
				});	
			}
			if(urlAction === 'save_invoice'){
				startEventsWhenExistsDebts();
				if(result === 'approve'){
					if(payDebt == 0){
								showBittionAlertModal({content:'Al APROBAR este documento ya no se podrá hacer más modificaciones. ¿Está seguro?'});
								$('#bittionBtnYes').click(function(){
									ajax_save_movement('DEFAULT', 'PINVOICE_APPROVED', ''/*, arrayForValidate*/);
								hideBittionAlertModal();
								});		
					}else{
						showBittionAlertModal({content:'No puede aprobar esta orden de compra. <br><br>Primero debe cancelar todos los pagos pendientes.', btnYes:'Aceptar', btnNo:''});
						$('#bittionBtnYes').click(function(){
							hideBittionAlertModal();
						});
					}				
				}else{
					showBittionAlertModal({content:'No puede aprobar esta orden de compra. <br><br>Primero deben aprobar el/los movimiento(s) relacionados a esta factura de compra.', btnYes:'Aceptar', btnNo:''});
					$('#bittionBtnYes').click(function(){
						hideBittionAlertModal();
					});
				}	
			}
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}	
	}
	// (CEA Ztep 2) action when button Cancelar Entrada Almacen is pressed
	function changeStateCancelled(result){
		if(urlAction === 'save_order'){
			if(result === 'proceed'){
				showBittionAlertModal({content:'Al CANCELAR este documento ya no será válido y no habrá marcha atrás. ¿Está seguro?'});
				$('#bittionBtnYes').click(function(){
					ajax_save_movement('DEFAULT', 'ORDER_CANCELLED', ''/*, arrayForValidate*/);
					hideBittionAlertModal();
				});
			}else{
				showBittionAlertModal({content:'No puede cancelar esta orden de compra. <br><br>Primero debe eliminar/cancelar la factura y movimiento(s) relacionados a esta orden de compra.', btnYes:'Aceptar', btnNo:''});
				$('#bittionBtnYes').click(function(){
					hideBittionAlertModal();
				});
			}

		}
		if(urlAction === 'save_invoice'){
			if(result === 'proceed'){
				showBittionAlertModal({content:'Al CANCELAR este documento ya no será válido y no habrá marcha atrás. ¿Está seguro?'});
				$('#bittionBtnYes').click(function(){
					ajax_save_movement('DEFAULT', 'PINVOICE_CANCELLED', ''/*, arrayForValidate*/);
					hideBittionAlertModal();
				});
			}else{
				showBittionAlertModal({content:'No puede cancelar esta factura de compra. <br><br>Primero debe cancelar el/los movimiento(s) relacionados a esta factura de compra.', btnYes:'Aceptar', btnNo:''});
				$('#bittionBtnYes').click(function(){
					hideBittionAlertModal();
				});
			}
		}
	}
	
	
	
	function changeStateLogicDeleted(result){
		var purchaseId = $('#txtPurchaseIdHidden').val();
		var genCode = $('#txtGenericCode').val();
		var type;
		var index;
		switch(urlAction){
			case 'save_order':
					showBittionAlertModal({content:'¿Está seguro de eliminar este documento en estado Pendiente?'});
					$('#bittionBtnYes').click(function(){

						index = 'index_order';
						type = 'ORDER_LOGIC_DELETED';

						ajax_logic_delete(purchaseId, type, index, genCode);
						hideBittionAlertModal();
					});	
				break;	
			case 'save_invoice':
				if(result === 'proceed'){
					showBittionAlertModal({content:'¿Está seguro de eliminar esta factura en estado Pendiente? (al eliminar este documento tambien se trataran de eliminar los movimientos asociados)'});
					$('#bittionBtnYes').click(function(){

						index = 'index_invoice';
						type = 'PINVOICE_LOGIC_DELETED';

						ajax_logic_delete(purchaseId, type, index, genCode);
						hideBittionAlertModal();
					});		
				}else{
					showBittionAlertModal({content:'No puede eliminar esta factura de compra. <br><br>Primero debe cancelar el/los movimiento(s) relacionados a esta factura de compra.', btnYes:'Aceptar', btnNo:''});
					$('#bittionBtnYes').click(function(){
						hideBittionAlertModal();
					});
				}	
				break;	
		}	
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
	
	function setToPendant(){
		showBittionAlertModal({content:'¿Está seguro de cambiar este documento a estado pendiente?'});
		$('#bittionBtnYes').click(function(){
			var arrayItemsDetails = [];
			arrayItemsDetails = getItemsDetails();
			
			var error = validateBeforeSaveAll(arrayItemsDetails);
			if( error === ''){
				
				ajax_set_to_pendant(arrayItemsDetails);
				
			}else{
				$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
			}
			hideBittionAlertModal();
		});
	}
	
	function ajax_set_to_pendant(arrayItemsDetails){
		$.ajax({
			type:"POST",
			url:urlModuleController + "ajax_set_to_pendant",			
			data:{arrayItemsDetails: arrayItemsDetails 
				  ,purchaseId:$('#txtPurchaseIdHidden').val()
				  ,purchaseCode:$('#txtGenericCode').val()
				  ,noteCode:$('#txtNoteCode').val()
		                  ,date:$('#txtDate').val()
				  ,warehouseId:$('#cbxWarehouses').val()
				  ,description:$('#txtDescription').val()
				  ,discount:$('#txtDiscount').val()
				  ,exRate:$('#txtExRate').val()
			  },
			beforeSend: showProcessing(),
			success: function(data){
				$('#boxMessage').html('');//this for order goes here
				$('#processing').text('');//this must go at the begining not at the end, otherwise, it won't work when validation is send
//				var dataReceived = data.split('|');
				if(data === 'success'){
					location.reload();// NO DEJA VER EL MENSAJE DE EXITO
//					$('#btnSetToPendant').hide();
//					$('#cbxWarehouses').select2('enable', true); 
//					$('#btnApproveState, #btnPrint, #btnLogicDeleteState, #btnAddItem, .columnItemsButtons').show();
////					$('#btnAddItem').show();
////					$('.columnItemsButtons').show();
//					$('#txtCode, #txtNoteCode, #txtDate, #txtDescription, #txtExRate, #txtDiscount').removeAttr('disabled');
//					changeLabelDocumentState('ORDER_PENDANT'); //#UNICORN
				}
			},
			error:function(data){
				$('#boxMessage').html(''); 
				$('#processing').text(''); 
				setOnError();
			}
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
	$('#txtDiscount').keydown(function(event) {
			validateOnlyIntegers(event);			
	});
//	$('#txtModalCostExAmount').keydown(function(event) {
//			validateOnlyFloatNumbers(event);			
//	});
//	$('#txtModalPaidAmount').keydown(function(event) {
//			validateOnlyFloatNumbers(event);			
//	});
	
	$('#txtDate').focusout(function() {
			ajax_update_ex_rate();			
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
				},
				error: function(data) {
					$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
					$('#processing').text('');
				}
		});
	}

	//Call modal
	$('#btnAddItem').click(function(){
		itemsListWhenExistsItems();			//NEEDS TO BE RUN BEFORE MODAL TO UPDATE ITEMS LIST BY SUPPLIER
		suppliersListWhenExistsItems();	//NEEDS TO BE RUN BEFORE MODAL TO UPDATE ITEMS LIST BY SUPPLIER
//		initiateModalAddItem();
		ajax_check_code_duplicity(initiateModalAddItem);//passing callback as a parameter into another function
		return false; //avoid page refresh
	});
	
	// (GC Ztep 1) action when button Guardar on the modal is pressed
	$('#btnModalAddItem').click(function(){
		addItem();
		return false; //avoid page refresh
	});
	
	//edit an existing item quantity
	$('#btnModalEditItem').click(function(){
		editItem();
		return false; //avoid page refresh
	});
	
	//saves all order
	$('#btnSaveAll').click(function(){
//		saveAll();
		ajax_check_code_duplicity(saveAll);//passing callback as a parameter into another function
		return false; //avoid page refresh
	});
	
	//function triggered when PAYS plus icon is clicked
	$('#btnAddPay').click(function(){
		startEventsWhenExistsDebts();
//		initiateModalAddPay();
		ajax_check_code_duplicity(initiateModalAddPay);//passing callback as a parameter into another function
		return false; //avoid page refresh
	});
	
	$('#btnModalAddPay').click(function(){
		addPay();
		return false; //avoid page refresh
	});
	
	$('#btnAddCost').click(function(){
//		initiateModalAddCost();
		ajax_check_code_duplicity(initiateModalAddCost);//passing callback as a parameter into another function
		return false; //avoid page refresh
	});
	$('#btnModalAddCost').click(function(){
		addCost();
		return false; //avoid page refresh
	});
	
	//edit an existing item quantity
	$('#btnModalEditCost').click(function(){
		editCost();
		return false; //avoid page refresh
	});
	
	//edit an existing item quantity
	$('#btnModalEditPay').click(function(){
		editPay();
		return false; //avoid page refresh
	});
	////////////////
	
	// (AEA Ztep 1) action when button Aprobar Entrada Almacen is pressed
	$('#btnApproveState').click(function(){
		ajax_check_document_state(changeStateApproved);
		return false;
	});
	// (CEA Ztep 1) action when button Cancelar Entrada Almacen is pressed
	$('#btnCancellState').click(function(){
		//alert('Se cancela entrada');
		ajax_check_document_state(changeStateCancelled);
		return false;
	});
	
	$('#btnLogicDeleteState').click(function(){
		ajax_check_document_state(changeStateLogicDeleted);
		return false;
	});
	
	$('#btnSetToPendant').click(function(){
		setToPendant();
		return false;
	});
	
	$('#btnGoInvoice').click(function(){
		ajax_go_invoice();
		return false;
	});
	
	$('#btnGoMovements').click(function(){
		window.location.replace = '../../inv_movements/index_purchase_in/note_code:'+ $('#txtNoteCode').val() +'/search:yes';
		return false;
	});
	
	$('#btnEnableMovements').click(function(){
		ajax_enable_movements();
		return false;
	});
	
	$('#btnGenerateMovements').click(function(){
		generateMovements();
//		ajax_generate_movements();
		return false;
	});
	
	function generateMovements(){
		showBittionAlertModal({content:'¿Está seguro de querer generar el/los movimeinto(s) correspondientes a esta factura?'});
		$('#bittionBtnYes').click(function(){
			var arrayItemsDetails = [];
			arrayItemsDetails = getItemsDetails();
			
			var error = validateBeforeSaveAll(arrayItemsDetails);
			if( error === ''){
				
				ajax_generate_movements(arrayItemsDetails);
				
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
				  //,purchaseId:$('#txtPurchaseIdHidden').val()
				  ,purchaseCode:$('#txtGenericCode').val()
				  //,noteCode:$('#txtNoteCode').val()
		                  ,date:$('#txtDate').val()
				  ,warehouseId:$('#cbxWarehouses').val()
				  ,description:$('#txtDescription').val()
				  //,discount:$('#txtDiscount').val()
				  //,exRate:$('#txtExRate').val()
			  },
			beforeSend: showProcessing(),
			success: function(data){
				$('#boxMessage').html('');//this for order goes here
				$('#processing').text('');//this must go at the begining not at the end, otherwise, it won't work when validation is send
//				var dataReceived = data.split('|');
				if(data === 'success'){
					$('#btnGenerateMovements').hide();
					$('#btnGoMovements').show();
					location.reload();//no es una buena forma pq no aparece el mensaje de exito
				}
			},
			error:function(data){
				$('#boxMessage').html(''); 
				$('#processing').text(''); 
				setOnError();
			}
		});
	}
	
	
	function ajax_enable_movements(){
		$.ajax({
		    type:"POST",
		    url:urlModuleController + "ajax_enable_movements",			
		    data:{genericCode:$('#txtGenericCode').val()},
		    beforeSend: showProcessing(),
				success:function(data){
					$('#processing').text('');//this must go at the begining not at the end, otherwise, it won't work when validation is send
					if(data === 'success'){
						showBittionAlertModal({content:'Se creo el movimiento', btnYes:'Aceptar', btnNo:''});
						$('#bittionBtnYes').click(function(){
							$('#btnEnableMovements').hide();
							$('#btnGoMovements').show();
							hideBittionAlertModal();
						});
					}
				},
				error: function(data) {
					$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
					$('#processing').text('');
				}
		});
	}
	
	function ajax_go_invoice(){
		$.ajax({
		    type:"POST",
		    url:urlModuleController + "ajax_go_invoice",			
		    data:{genericCode:$('#txtGenericCode').val(),
				purchaseId:$('#txtPurchaseIdHidden').val()},
		    beforeSend: showProcessing(),
				success:function(data){
					$('#processing').text('');//this must go at the begining not at the end, otherwise, it won't work when validation is send
					window.location = urlModuleController + 'save_invoice/id:'+data;
				},
				error: function(data) {
					$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
					$('#processing').text('');
				}
		});
	}
	
//	function ajax_generate_movements(){
//		$.ajax({
//		    type:"POST",
//		    url:urlModuleController + "ajax_generate_movements",			
//		    data:{genericCode:$('#txtGenericCode').val()},
//		    beforeSend: showProcessing(),
//				success:function(data){
//					$('#processing').text('');//this must go at the begining not at the end, otherwise, it won't work when validation is send
//					if(data === 'success'){
//						showBittionAlertModal({content:'Se creo el movimiento', btnYes:'Aceptar', btnNo:''});
//						$('#bittionBtnYes').click(function(){
//							$('#btnEnableMovements').hide();
//							$('#btnGoMovements').show();
//							hideBittionAlertModal();
//						});
//					}
//				},
//				error: function(data) {
//					$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
//					$('#processing').text('');
//				}
//		});
//	}
	
//	$('#cbxSuppliers').data('pre', $(this).val());
//	$('#cbxSuppliers').change(function(){
//	var supplier = $(this).data('pre');
//		deleteList(supplier);
//	$(this).data('pre', $(this).val());
//		return false; //avoid page refresh
//	});
  

	$('#txtDate').keydown(function(e){e.preventDefault();});
	$('#txtModalDate').keypress(function(){return false;});
//	$('#txtModalDueDate').keypress(function(){return false;});
	$('#txtCode').keydown(function(e){e.preventDefault();});
	$('#txtOriginCode').keydown(function(e){e.preventDefault();});
	//************************************************************************//
	//////////////////////////////////END-CONTROLS EVENTS//////////////////////
	//************************************************************************//
	
	
	
	
	//************************************************************************//
	//////////////////////////////////BEGIN-AJAX FUNCTIONS//////////////////////
	////************************************************************************//
	
	//*****************************************************************************************************************************//
	function setOnData(ACTION, OPERATION, STATE, objectTableRowSelected/*, arrayForValidate*/){
		var DATA = [];
		//constants
		var purchaseId=$('#txtPurchaseIdHidden').val();
		var movementDocCode = $('#txtCode').val();
		var movementCode = $('#txtGenericCode').val();
		var noteCode=$('#txtNoteCode').val();
		var date=$('#txtDate').val();
		var warehouseId = $('#cbxWarehouses').val();
		var description=$('#txtDescription').val();
		var discount=$('#txtDiscount').val();
		var exRate=$('#txtExRate').val();
		//variables
		var supplierId = 0;
		var itemId = 0;
		var exFobPrice = 0.00;
		var exSubtotal = 0.00;
		var quantity = 0;
//		var subtotal = 0.00;
		
		var dateId = '';
		var payDate = '';
		var payAmount = 0;
		var payDescription = '';
		
		var costId = 0;
		var costExAmount = 0;
		var costCodeName = '';
		//only used for ADD
		var supplier = '';
		var itemCodeName = '';
//		var stock = 0;
		var arrayItemsDetails = [0];
		var total=0;
		var totalCost=0;
		
		if(ACTION === 'save_invoice' && STATE === 'PINVOICE_APPROVED'){
			arrayItemsDetails = getItemsDetails();
			total = getTotal();
			totalCost = getTotalCost();
		}
		//PurchaseDetails(Item) setup variables
		if(OPERATION === 'ADD' || OPERATION === 'EDIT' || OPERATION === 'ADD_PAY' || OPERATION === 'EDIT_PAY' || OPERATION === 'ADD_COST' || OPERATION === 'EDIT_COST'){	
			supplierId = $('#cbxModalSuppliers').val();
			itemId = $('#cbxModalItems').val();
//			exFobPrice = $('#txtModalPrice').val();
			exSubtotal = $('#txtModalExSubtotal').val();
			quantity = $('#txtModalQuantity').val();
			exFobPrice = exSubtotal / quantity;

			if(OPERATION === 'ADD_PAY' || OPERATION === 'EDIT_PAY' || OPERATION === 'ADD_COST' || OPERATION === 'EDIT_COST'){
				payDate = $('#txtModalDate').val();
				var myDate = payDate.split('/');
				dateId = myDate[2]+"-"+myDate[1]+"-"+myDate[0];
				payAmount = $('#txtModalPaidAmount').val();
				payDescription = $('#txtModalDescription').val();
				
				costId = $('#cbxModalCosts').val();
				costExAmount = $('#txtModalCostExAmount').val();
				costCodeName = $('#cbxModalCosts option:selected').text();
			}
			if(OPERATION === 'ADD'){
				supplier = $('#cbxModalSuppliers option:selected').text();
				itemCodeName = $('#cbxModalItems option:selected').text();
//				subtotal = Number(quantity) * Number(exFobPrice);
			}
		}
			
		if(OPERATION === 'DELETE'){
			itemId = objectTableRowSelected.find('#txtItemId').val();
			supplierId = objectTableRowSelected.find('#txtSupplierId'+itemId).val();
		}
		
		if(OPERATION === 'DELETE_PAY'){
			payDate = objectTableRowSelected.find('#txtPayDate').val();
		}
		
		if(OPERATION === 'DELETE_COST'){
			costId = objectTableRowSelected.find('#txtCostId').val();
		}
		//setting data
		DATA ={	'purchaseId':purchaseId
				,'movementDocCode':movementDocCode
				,'movementCode':movementCode
				,'noteCode':noteCode
				,'date':date
				,'warehouseId':warehouseId
				,'description':description	
				,'discount':discount
				,'exRate':exRate
				
				,'supplierId':supplierId
				,'supplier':supplier
				,'itemId':itemId
				,'exFobPrice':exFobPrice
				,'quantity':quantity	
				,'exSubtotal':exSubtotal
//				,'subtotal':subtotal
				
				,'dateId':dateId
				,'payDate':payDate
				,'payAmount':payAmount
				,'payDescription':payDescription
				
				,'costId':costId
				,'costExAmount':costExAmount
		
				,'total':total
				,'totalCost':totalCost
				,arrayItemsDetails:arrayItemsDetails
		
				,'ACTION':ACTION
				,'OPERATION':OPERATION
				,'STATE':STATE

				,itemCodeName:itemCodeName
				,costCodeName:costCodeName
//				,stock:stock
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
	
	function setOnPendant(DATA, ACTION, OPERATION, STATE, objectTableRowSelected, supplierId, supplier, itemId, itemCodeName, exFobPrice, quantity, exSubtotal, dateId, payDate, payAmount, payDescription, costId, costExAmount, costCodeName){
		if($('#txtPurchaseIdHidden').val() === ''){
			$('#txtCode').val(DATA[2]);
			$('#txtGenericCode').val(DATA[3]);
			
			$('#btnApproveState, #btnPrint, #btnLogicDeleteState').show();
			$('#txtPurchaseIdHidden').val(DATA[1]);
			changeLabelDocumentState(STATE); //#UNICORN
		}
		/////////////************************************////////////////////////
		//Item's table setup
		if(OPERATION === 'ADD'){
			createRowItemTable(itemId, itemCodeName, exFobPrice, quantity,/*parseFloat(exFobPrice).toFixed(2), parseInt(quantity,10),*/ supplier, supplierId,  exSubtotal/*, parseFloat(subtotal).toFixed(2)*/);
			createEventClickEditItemButton(itemId, supplierId);
			createEventClickDeleteItemButton(itemId, supplierId);
			arrayItemsAlreadySaved.push(itemId);  //push into array of the added item	
			arraySupplierItemsAlreadySaved.push(supplierId);  //push into array of the added warehouses	
			///////////////////
		   itemsCounter = itemsCounter + 1;
			//////////////////
			$('#countItems').text(itemsCounter);
			//$('#countItems').text(arrayItemsAlreadySaved.length);
			$('#total').text(/*parseFloat(*/getTotal()/*).toFixed(2)*/+' $us.');
			$('#modalAddItem').modal('hide');
			highlightTemporally('#itemRow'+itemId+'s'+supplierId);
		}	
		if(OPERATION === 'ADD_PAY'){
			createRowPayTable(dateId, payDate, parseFloat(payAmount).toFixed(2), payDescription);
			createEventClickEditPayButton(dateId);
			createEventClickDeletePayButton(dateId);
			arrayPaysAlreadySaved.push(dateId);  //push into array of the added date
			$('#total2').text(parseFloat(getTotalPay()).toFixed(2)+' Bs.');
			$('#modalAddPay').modal('hide');
			highlightTemporally('#payRow'+dateId);
		}		
		if(OPERATION === 'ADD_COST'){
			createRowCostTable(costId, costCodeName, parseFloat(costExAmount).toFixed(2));
			createEventClickEditCostButton(costId);
			createEventClickDeleteCostButton(costId);
			arrayCostsAlreadySaved.push(costId);  //push into array of the added date
			$('#total3').text(parseFloat(getTotalCost()).toFixed(2)+' $us.');
			$('#modalAddCost').modal('hide');
			highlightTemporally('#costRow'+costId);
		}
		if(OPERATION === 'EDIT'){
			$('#spaQuantity'+itemId+'s'+supplierId).text(parseInt(quantity,10));
			$('#spaExFobPrice'+itemId+'s'+supplierId).text(parseFloat(exFobPrice).toFixed(2));	
			$('#spaExSubtotal'+itemId+'s'+supplierId).text(parseFloat(exSubtotal).toFixed(2));
			$('#total').text(/*parseFloat(*/getTotal()/*).toFixed(2)*/+' $us.');
			$('#modalAddItem').modal('hide');
			highlightTemporally('#itemRow'+itemId+'s'+supplierId);
		}	
		if(OPERATION === 'EDIT_PAY'){	
			$('#spaPayDate'+dateId).text(payDate);
			$('#spaPayAmount'+dateId).text(parseFloat(payAmount).toFixed(2));
			$('#spaPayDescription'+dateId).text(payDescription);
			$('#total2').text(parseFloat(getTotalPay()).toFixed(2)+' Bs.');	
			$('#modalAddPay').modal('hide');
			highlightTemporally('#payRow'+dateId);
		}
		if(OPERATION === 'EDIT_COST'){	
			$('#spaCostExAmount'+costId).text(parseFloat(costExAmount).toFixed(2));
			$('#total3').text(parseFloat(getTotalCost()).toFixed(2)+' $us.');	
			$('#modalAddCost').modal('hide');
			highlightTemporally('#costRow'+costId);
		}
		if(OPERATION === 'DELETE'){					
			var itemIdForDelete = objectTableRowSelected.find('#txtItemId').val();
			var subtotal = $('#spaExSubtotal'+itemIdForDelete+'s'+supplierId).text();		
			hideBittionAlertModal();
			
			objectTableRowSelected.fadeOut("slow", function() {
				$(this).remove();
			});
			itemsListWhenExistsItems();
			suppliersListWhenExistsItems();
			/////////////////////////
			itemsCounter = itemsCounter - 1;
			////////////////////////
			$('#countItems').text(itemsCounter);
			//$('#countItems').text(arrayItemsAlreadySaved.length-1);	//because arrayItemsAlreadySaved updates after all is done
			$('#total').text(/*parseFloat(*/getTotal()-subtotal/*).toFixed(2)*/+' $us.');
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
		if(OPERATION === 'DELETE_COST'){						
			arrayCostsAlreadySaved = jQuery.grep(arrayCostsAlreadySaved, function(value){
				return value !== costId;
			});
			subtotal = $('#spaCostExAmount'+costId).text();			
			hideBittionAlertModal();
			objectTableRowSelected.fadeOut("slow", function() {
				$(this).remove();
			});
			$('#total3').text(parseFloat(getTotalCost()-subtotal).toFixed(2)+' $us.');
		}
		showGrowlMessage('ok', 'Cambios guardados.');
	}
	
	function setOnApproved(DATA, STATE, ACTION){
		$('#txtCode').val(DATA[2]);
		$('#txtGenericCode').val(DATA[3]);
		$('#btnApproveState, #btnLogicDeleteState, #btnSaveAll, .columnItemsButtons, .columnPaysButtons').hide();
		$('#btnCancellState, #btnGoInvoice, #btnGoMovements').show();
		$('#txtCode, #txtNoteCode, #txtDate, #txtDescription, #txtExRate, #txtDiscount').attr('disabled','disabled');
		$('#cbxWarehouses').select2('disable', true); //change to function on BittionMain ??????
		if ($('#btnAddItem').length > 0){//existe
			$('#btnAddItem').hide();
		}
		if ($('#btnAddPay').length > 0){//existe
			$('#btnAddPay').hide();
		}
		changeLabelDocumentState(STATE); //#UNICORN
		showGrowlMessage('ok', 'Aprobado.');
	}
	
	function setOnCancelled(STATE){
		$('#btnCancellState').hide();
		$('#btnSetToPendant').show();
		changeLabelDocumentState(STATE); //#UNICORN
		showGrowlMessage('ok', 'Cancelado.');
	}
	
	function setOnError(){
		showGrowlMessage('error', 'Vuelva a intentarlo.');
	}
	
	function ajax_save_movement(OPERATION, STATE, objectTableRowSelected/*, arrayForValidate*/){//SAVE_IN/ADD/PENDANT
		var ACTION = urlAction;
		var dataSent = setOnData(ACTION, OPERATION, STATE, objectTableRowSelected/*, arrayForValidate*/);
		//Ajax Interaction	
		$.ajax({
            type:"POST",
            url: urlModuleController + "ajax_save_movement",//saveSale			
            data: dataSent,
            beforeSend: showProcessing(),
            success: function(data){
				$('#boxMessage').html('');//this for order goes here
				$('#processing').text('');//this must go at the begining not at the end, otherwise, it won't work when validation is send
				var dataReceived = data.split('|');
				//////////////////////////////////////////
//				if(dataReceived[0] === 'ORDER_APPROVED' || dataReceived[0] === 'ORDER_CANCELLED'){
//						var arrayItemsStocks = dataReceived[3].split(',');
//						updateMultipleStocks(arrayItemsStocks, 'spaStock');//What is this for???????????
//				}
				switch(dataReceived[0]){
					case 'ORDER_PENDANT':
						setOnPendant(dataReceived, ACTION, OPERATION, STATE, objectTableRowSelected, dataSent['supplierId'], dataSent['supplier'], dataSent['itemId'], dataSent['itemCodeName'], dataSent['exFobPrice'], dataSent['quantity'], dataSent['exSubtotal']);
						break;
					case 'ORDER_APPROVED':
						setOnApproved(dataReceived, STATE, ACTION);
						break;
					case 'ORDER_CANCELLED':
						setOnCancelled(STATE);
						break;
					case 'PINVOICE_PENDANT':
						setOnPendant(dataReceived, ACTION, OPERATION, STATE, objectTableRowSelected, dataSent['supplierId'], dataSent['supplier'], dataSent['itemId'], dataSent['itemCodeName'], dataSent['exFobPrice'], dataSent['quantity'], dataSent['exSubtotal'], dataSent['dateId'], dataSent['payDate'], dataSent['payAmount'], dataSent['payDescription'], dataSent['costId'], dataSent['costExAmount'], dataSent['costCodeName']);
						break;
					case 'PINVOICE_APPROVED':
						setOnApproved(dataReceived, STATE, ACTION);
						break;
					case 'PINVOICE_CANCELLED':
						setOnCancelled(STATE);
						break;
					case 'VALIDATION':
						setOnValidation(dataReceived, ACTION);
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
	
	//*************************************************************************************
	
	function ajax_logic_delete(purchaseId, type, index, genCode){
		$.ajax({
			type:"POST",
			url:urlModuleController + "ajax_logic_delete",			
			data:{purchaseId: purchaseId
				,type: type
				,genCode: genCode
			},
			success: function(data){//ACA CREO Q FATLA PROCESS
				if(data === 'success'){
					showBittionAlertModal({content:'Se eliminó el documento en estado Pendiente', btnYes:'Aceptar', btnNo:''});
					$('#bittionBtnYes').click(function(){
//						window.location = urlModuleController + index;
						window.location = document.referrer;//NO JALA CUANDO VIENE DE UN DOCUMENTO NUEVO QUE NO TENIA ID EN EL URL
					});

				}else if(data === 'exception'){
					showBittionAlertModal({content:'No se puede eliminar el documento debido a que los movimientos relacionados estan aprobados', btnYes:'Aceptar', btnNo:''});
					$('#bittionBtnYes').click(function(){
						hideBittionAlertModal();
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
	
	//Get items and prices for the fist item when inititates modal
	function ajax_initiate_modal_add_item_in(itemsAlreadySaved, supplierItemsAlreadySaved){
		 $.ajax({
            type:"POST",
            url:urlModuleController + "ajax_initiate_modal_add_item_in",			
		  data:{	itemsAlreadySaved: itemsAlreadySaved, 
				supplierItemsAlreadySaved: supplierItemsAlreadySaved,
				date: $('#txtDate').val()
			},
            beforeSend: showProcessing(),
            success: function(data){
				$('#processing').text('');
				$('#txtModalQuantity').val('');  
				$('#txtModalExSubtotal').val('');  
				$('#boxModalInitiateSupplierItemPrice').html(data);
				initiateModal();
				
				$('#cbxModalSuppliers').bind("change",function(){ //must be binded 'cause dropbox is loaded by a previous ajax'
					//to update the list of items by selected supplier
					ajax_update_items_modal(itemsAlreadySaved, supplierItemsAlreadySaved);
				});
				fnBittionSetSelectsStyle();
//				$('#cbxModalItems').bind("change",function(){ //must be binded 'cause dropbox is loaded by a previous ajax'
//					//to update the price by selected item
//					ajax_update_price_modal();
//				});
//				$('#cbxModalItems').select2();

				$('#txtModalQuantity').keydown(function(event) {
					validateOnlyIntegers(event);			
				});
//				$('#txtModalPrice').keydown(function(event) {
//					validateOnlyFloatNumbers(event);			
//				});
				////////////////////////////////////////////////////////////////////////////////// till convert this float validation script to function
				$('#txtModalExSubtotal').keypress(function(event){
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
	
	function ajax_update_items_modal(itemsAlreadySaved, supplierItemsAlreadySaved){ 
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_update_items_modal",			
            data:{itemsAlreadySaved: itemsAlreadySaved,
				supplierItemsAlreadySaved: supplierItemsAlreadySaved,
				supplier: $('#cbxModalSuppliers').val(),
			date: $('#txtDate').val()},
            beforeSend: showProcessing(),
            success: function(data){
				$('#processing').text("");
				$('#boxModalItemPrice').html(data);
			
//				$('#cbxModalItems').bind("change",function(){ //must be binded 'cause dropbox is loaded by a previous ajax'
//					//to update the price by selected item
//					ajax_update_price_modal();
//				});
//				$('#cbxModalItems').select2();	
				fnBittionSetSelectsStyle();
				$('#txtModalQuantity').keydown(function(event) {
					validateOnlyIntegers(event);			
				});
//				$('#txtModalPrice').keydown(function(event) {
//					validateOnlyFloatNumbers(event);			
//				});				
				$('#txtModalExSubtotal').keypress(function(event){
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
	function ajax_update_price_modal(){
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_update_price_modal",			
            data:{item: $('#cbxModalItems').val(),
			date: $('#txtDate').val()},
            beforeSend: showProcessing(),
            success: function(data){
				$('#processing').text("");
				$('#boxModalPrice').html(data);
//				$('#txtModalPrice').keydown(function(event) {
//					validateOnlyFloatNumbers(event);			
//				});
			},
			error:function(data){
				$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
				$('#processing').text('');
			}
        });
	}
	
	function ajax_initiate_modal_add_cost(costsAlreadySaved){
		 $.ajax({
            type:"POST",
            url:urlModuleController + "ajax_initiate_modal_add_cost",			
			  data:{costsAlreadySaved: costsAlreadySaved/*, supplier: $('#cbxSuppliers').val()*//*, transfer:transfer, warehouse2:warehouse2*/},
            beforeSend: showProcessing(),
            success: function(data){
				$('#processing').text('');
				$('#boxModalInitiateCost').html(data);
				$('#txtModalCostExAmount').val('');  
				initiateModalCost();
/*				$('#cbxModalCosts').bind("change",function(){ //must be binded 'cause dropbox is loaded by a previous ajax'
					ajax_update_amount();
				});
*///				$('#txtModalPrice').keypress(function(){return false;});
//				$('#cbxModalCosts').select2();	
				fnBittionSetSelectsStyle();
			},
			error:function(data){
				$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
				$('#processing').text('');
			}
        });
	}
	
	function ajax_initiate_modal_add_pay(paysAlreadySaved,payDebt){
		 $.ajax({
            type:"POST",
            url:urlModuleController + "ajax_initiate_modal_add_pay",			
		    data:{paysAlreadySaved: paysAlreadySaved,
					payDebt: payDebt},
            beforeSend: showProcessing(),
            success: function(data){
				$('#processing').text('');
				$('#boxModalInitiatePay').html(data); 
				$('#txtModalDescription').val('');  
				initiateModalPay();
//				fnBittionSetTypeDate();		Replace datepicker with this function
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
	
//	function ajax_check_document_state(){
//		$.ajax({
//            type:"POST",
//            url:urlModuleController + "ajax_check_document_state",			
//            data:{
//				purchaseId: $('#txtPurchaseIdHidden').val(),
//				genericCode: $('#txtGenericCode').val()
//			},
//            success: function(data){
//				if(data === 'proceed'){
//					
//					ajax_save_movement('DEFAULT', 'ORDER_CANCELLED', '');
//					
//				}else{
//					$('#boxMessage').html('<div class="alert alert-error">\n\
//					<button type="button" class="close" data-dismiss="alert">&times;</button>\n\
//					<p>No se pudo realizar la operación debido a que debe Cancelar la Factura y/o el/los Movimientos relacionados</p><div>');
//				}
//				hideBittionAlertModal();
//			}
//        });
//	}
	
	//************************************************************************//
	//////////////////////////////////END-AJAX FUNCTIONS////////////////////////
	//************************************************************************//
	
//END SCRIPT	
});
