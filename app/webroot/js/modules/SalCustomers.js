$(document).ready(function() {
//START SCRIPT
	
	$("#saveCustomer").click(function(event){
//		alert("saveCustomer");
		event.preventDefault();
		var id = $("#txtIdCustomer").val();
		var name = $("#txtNameCustomer").val();
		var employeeId = $("#txtIdEmployee").val();
		var employeeName = $("#txtNameEmployee").val();
		var nitId = $("#txtidTaxNumber").val();
		var nitName = $("#txtNameTaxNumber").val();	
		var nit = $("#txtNitTaxNumber").val();		
		var address = $("#txtAddressCustomer").val();
		var phone = $("#txtPhoneCustomer").val();
		var email = $("#txtEmailCustomer").val();
		var description = $("#txtDescriptionCustomer").val();
		
		var error = validateBeforeSaveCustomer(name, employeeName);
		if(error === ""){
			ajax_save_customer(id, name, employeeId, employeeName, nitId, nitName, nit, address, phone, email, description);
			$('#boxMessage').html('');
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
		
	});
	
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
	
	function ajax_save_customer(id, name, employeeId, employeeName, nitId, nitName, nit, address, phone, email, description){
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_save_customer",			
            data:{id: id, name: name, employeeId:employeeId, employeeName:employeeName, nitId:nitId, nitName:nitName, nit:nit, address:address, phone:phone, email:email, description:description},
            beforeSend: function(){
				$('#boxProcessing').text(" Procesando...");
			},
            success: function(data){
				var arrayData = data.split('|');
				if(arrayData[0] === "success"){
					showGrowlMessage('ok', 'Cambios guardados.');
					if(arrayData[1] === "add"){
						$("#txtIdCustomer").val(arrayData[2]);
						addRowEmployee(arrayData[3], 'Encargado(a)', '', '');
						addRowTaxNumber(arrayData[4], 'N/a', 'N/a');
					}
					if(arrayData[1] === "edit"){
						$("#txtIdCustomer").val(arrayData[2]);
					}	
					
				}else{
					showGrowlMessage('error', 'Vuelva a intentarlo.');
				}
				$('#boxProcessing').text('');
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessing').text('');
			}
        });
	}
	
	//Employee
	function ajax_save_employee(id, name, phone, email, idCustomer){
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_save_employee",			
            data:{id: id, name: name, phone:phone, email:email, idCustomer:idCustomer},
            beforeSend: function(){
				$('#boxProcessingEmployee').text(" Procesando...");
			},
            success: function(data){
				var arrayData = data.split('|');
				if(arrayData[0] === "success"){
					showGrowlMessage('ok', 'Cambios guardados.');
					if(arrayData[2] === "add"){
						addRowEmployee(arrayData[1], name, phone, email);
					}
					if(arrayData[2] === "edit"){
						editEmployee(arrayData[1], name, phone, email);
					}
				}else{
					showGrowlMessage('error', 'Vuelva a intentarlo.');
				}
				$('#boxProcessingEmployee').text('');
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessingEmployee').text('');
			}
        });
	}
	
	function ajax_save_tax_number(id, nit, name, idCustomer){
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_save_tax_number",			
            data:{id: id, nit:nit, name: name, idCustomer:idCustomer},
            beforeSend: function(){
				$('#boxProcessingTaxNumber').text(" Procesando...");
			},
            success: function(data){
				var arrayData = data.split('|');
				if(arrayData[0] === "success"){
					showGrowlMessage('ok', 'Cambios guardados.');
					if(arrayData[2] === "add"){
						addRowTaxNumber(arrayData[1], nit, name);
					}
					if(arrayData[2] === "edit"){
						editTaxNumber(arrayData[1], nit, name);
					}
				}else{
					showGrowlMessage('error', 'Vuelva a intentarlo.');
				}
				$('#boxProcessingTaxNumber').text('');
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessingTaxNumber').text('');
			}
        });
	}
	
	function addRowEmployee(id, name, phone, email) {
		var pruebaRow = createRowEmployee(id, name, phone, email);
		$('#tblEmployees tbody').append(pruebaRow);
		bindButtonEventsRowEmployee();
		$('#SalEmployeeVsaveForm input[type=hidden], #SalEmployeeVsaveForm input[type=text]').val(""); //clear all after add
	}
	
	function createRowEmployee(id, name, phone, email) {
		var rowCount = $('#tblEmployees tbody tr').length + 1;
		var row = '<tr id="rowEmployee' + id + '">';
		row += '<td style="text-align:center;"><span class="spaNumber">' + rowCount + '</span><input type="hidden" value="' + id + '" class="spaIdEmployee"></td>';
		row += '<td><span class="spaNameEmployee">' + name + '</span></td>';
		row += '<td><span class="spaPhoneEmployee">' + phone + '</span></td>';
		row += '<td><span class="spaEmailEmployee">' + email + '</span></td>';
		row += '<td>';
		row += '<a href="#" class="btn btn-primary btnRowEditEmployee" title="Editar"><i class="icon-pencil icon-white"></i></a>';
		row += ' <a href="#" class="btn btn-danger btnRowDeleteEmployee" title="Eliminar"><i class="icon-trash icon-white"></i></a>';
		row += '</td>';
		row += '</tr>';
		return row;
	}
	
	function addEmployee(idCustomer) {
		var id = $("#txtIdEmployee").val();
		var name = $("#txtNameEmployee").val();
		var phone = $("#txtPhoneEmployee").val();
		var email = $("#txtEmailEmployee").val();
//		var idCustomer = 
		var error = validateBeforeAddEmployee(name);

		if (error === "") {
			ajax_save_employee(id, name, phone, email, idCustomer);
			$('#boxMessageEmployee').html('');
		} else {
			$('#boxMessageEmployee').html('<div class="alert-error"><ul>' + error + '</ul></div>');
		}
	}
	
	$("#btnAddEmployee").click(function(event) {
		event.preventDefault();
		var idCustomer = $("#txtIdCustomer").val();
		if(idCustomer !== ""){
			addEmployee(idCustomer);
		}else{
			alert('Debe "Guardar Cambios" del Cliente antes de adicionar un Empleado');
		}
	});
	
	$("#btnEditEmployee").click(function(event) {
		event.preventDefault();
		var id = $("#txtIdEmployee").val();
		var name = $("#txtNameEmployee").val();
		var phone = $("#txtPhoneEmployee").val();
		var email = $("#txtEmailEmployee").val();
		var idCustomer = $("#txtIdCustomer").val();
//		if(idCustomer !== ""){
//			editEmployee(id, name, phone, email);
		var error = validateBeforeAddEmployee(name);

		if (error === "") {
			ajax_save_employee(id, name, phone, email, idCustomer);
			$('#boxMessageEmployee').html('');
		} else {
			$('#boxMessageEmployee').html('<div class="alert-error"><ul>' + error + '</ul></div>');
		}
//		}else{
//			alert('Debe "Guardar Cambios" del Cliente antes de editar un Empleado');
//		}
		
	});
	
	function bindButtonEventsRowEmployee() {
		$('#tblEmployees tbody tr:last .btnRowEditEmployee').bind("click", function(event) {
			editRowEmployee($(this), event);
		});

		$('#tblEmployees tbody tr:last .btnRowDeleteEmployee').bind("click", function(event) {
			deleteRowEmployee($(this), event);
		});
	}

	////////////EVENTS
			

	function reorderRowNumbers(table){
		var counter = 1;
		$('#'+table+' tbody tr').each(function() {
			$(this).find('.spaNumber').text(counter);
			counter++;
		});
	}
	

	
	function validateBeforeAddEmployee(name) {
		var error = '';
		if (name === '') {
			error += '<li> El campo "Nombre" del Empleado no puede estar vacio </li>';
		}
		return error;
	}
	
	function validateBeforeSaveCustomer(name, employeeName) {
		var error = '';
		if (name === '') {
			error += '<li> El campo "Nombre" del Cliente no puede estar vacio </li>';
		}
		if (employeeName === '') {
			error += '<li> El campo "Responsable" del Cliente no puede estar vacio </li>';
		}
		return error;
	}
	
	
	$(".btnRowEditEmployee").click(function(event) {
		editRowEmployee($(this), event);
	});

	$(".btnRowDeleteEmployee").click(function(event) {
		deleteRowEmployee($(this), event);
		
	});
	

	
	$("#btnCancelEmployee").click(function(event) {
		$("#btnAddEmployee").show();
		$("#btnEditEmployee, #btnCancelEmployee").hide();
		$('#SalEmployeeVsaveForm input[type=hidden], #SalEmployeeVsaveForm input[type=text]').val("");
		$('#SalEmployeeVsaveForm input[type=text]').removeAttr('style');
		event.preventDefault();
	});
	
	function editEmployee(id, name, phone, email){
		$("#rowEmployee"+id).find('.spaNameEmployee').text(name);
		$("#rowEmployee"+id).find('.spaPhoneEmployee').text(phone);
		$("#rowEmployee"+id).find('.spaEmailEmployee').text(email);
		$('#SalEmployeeVsaveForm input[type=hidden], #SalEmployeeVsaveForm input[type=text]').val("");
		$('#SalEmployeeVsaveForm input[type=text]').removeAttr('style');
		$("#btnAddEmployee").show();
		$("#btnEditEmployee, #btnCancelEmployee").hide();
//		highlightTemporally(id);
	}
	//not working :( ??
//	function highlightTemporally(id) {
//		$("#tblEmployees #rowEmployee1").fadeIn(4000).css("background-color", "#FFFF66");
//		setTimeout(function() {
//			$("#rowEmployee1").removeAttr('style');
//		}, 4000);
//	}
	
	///////////PAGE FUNCTIONS
	function editRowEmployee(object, event) {
		event.preventDefault();
		var objectTableRowSelected = object.closest('tr');
		var id = objectTableRowSelected.find('.spaIdEmployee').val();
		var name = objectTableRowSelected.find('.spaNameEmployee').text();
		var phone = objectTableRowSelected.find('.spaPhoneEmployee').text();
		var email = objectTableRowSelected.find('.spaEmailEmployee').text();
		$("#txtIdEmployee").val(id);
		$("#txtNameEmployee").val(name);
		$("#txtPhoneEmployee").val(phone);
		$("#txtEmailEmployee").val(email);
		$("#btnAddEmployee").hide();
		$("#btnEditEmployee, #btnCancelEmployee").show();
		$('#SalEmployeeVsaveForm input[type=text]').css("background-color","#FFFF66");
		//alert(valor);
	}

	function deleteRowEmployee(object, event) {
		showBittionAlertModal({content: '¿Está seguro de eliminar este empleado?'});
		$('#bittionBtnYes').click(function(event) {
			var objectTableRowSelected = object.closest('tr');
			var id = objectTableRowSelected.find('.spaIdEmployee').val();
			hideBittionAlertModal();
			ajax_delete_employee(id, objectTableRowSelected);
			event.preventDefault();
		});
		
		event.preventDefault();
	}

	
	function ajax_delete_employee(id, objectTableRowSelected){
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_delete_employee",			
            data:{id: id},
            beforeSend: function(){
				$('#boxProcessingEmployee').text(" Procesando...");
			},
            success: function(data){
//				var arrayData = data.split('|');
				if(data === "success"){
					showGrowlMessage('ok', 'Cambios guardados.');
					objectTableRowSelected.fadeOut("slow", function() {
						$(this).remove();
						reorderRowNumbers('tblEmployees');//must go inside due the fadeout efect
					});
				}else if(data === "children"){
					alert("El Empleado tiene Ventas registradas, no se puede eliminar!");
				}else{
					showGrowlMessage('error', 'Vuelva a intentarlo.');
				}
				$('#boxProcessingEmployee').text('');
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessingEmployee').text('');
			}
        });
	}

	///////////AJAX FUNCTIONS
	
	//Tax Numbers functions
	
	//Employee
	
	
	function addRowTaxNumber(id, nit, name) {
		var pruebaRow = createRowTaxNumber(id, nit, name);
		$('#tblTaxNumbers tbody').append(pruebaRow);
		bindButtonEventsRowTaxNumber();
		$('#SalTaxNumberVsaveForm input[type=hidden], #SalTaxNumberVsaveForm input[type=text]').val(""); //clear all after add
	}
	
	function createRowTaxNumber(id, nit, name) {
		var rowCount = $('#tblTaxNumbers tbody tr').length + 1;
		var row = '<tr id="rowTaxNumber' + id + '">';
		row += '<td style="text-align:center;"><span class="spaNumber">' + rowCount + '</span><input type="hidden" value="' + id + '" class="spaIdTaxNumber"></td>';
		row += '<td><span class="spaNitTaxNumber">' + nit + '</span></td>';
		row += '<td><span class="spaNameTaxNumber">' + name + '</span></td>';
		row += '<td>';
		row += '<a href="#" class="btn btn-primary btnRowEditTaxNumber" title="Editar"><i class="icon-pencil icon-white"></i></a>';
		row += ' <a href="#" class="btn btn-danger btnRowDeleteTaxNumber" title="Eliminar"><i class="icon-trash icon-white"></i></a>';
		row += '</td>';
		row += '</tr>';
		return row;
	}
	
	function addTaxNumber(idCustomer) {
		var id = $("#txtIdTaxNumber").val();
		var nit = $("#txtNitTaxNumber").val();
		var name = $("#txtNameTaxNumber").val();
		var error = validateBeforeAddTaxNumber(nit, name);
		if (error === "") {
			ajax_save_tax_number(id, nit, name,idCustomer);
			$('#boxMessageTaxNumber').html('');
		} else {
			$('#boxMessageTaxNumber').html('<div class="alert-error"><ul>' + error + '</ul></div>');
		}
	}
	
	$("#btnAddTaxNumber").click(function(event) {
		event.preventDefault();
		var idCustomer = $("#txtIdCustomer").val();
		if(idCustomer !== ""){
			addTaxNumber(idCustomer);
		}else{
			alert('Debe "Guardar Cambios" del Cliente antes de adicionar un Nit');
		}
	});
	
	$("#btnEditTaxNumber").click(function(event) {
		event.preventDefault();
		var id = $("#txtIdTaxNumber").val();
		var nit = $("#txtNitTaxNumber").val();
		var name = $("#txtNameTaxNumber").val();
		var idCustomer = $("#txtIdCustomer").val();
//		if(idCustomer !== ""){
//			editEmployee(id, name, phone, email);
		var error = validateBeforeAddTaxNumber(nit, name);
		if (error === "") {
			ajax_save_tax_number(id, nit, name, idCustomer);
			$('#boxMessageTaxNumber').html('');
		} else {
			$('#boxMessageTaxNumber').html('<div class="alert-error"><ul>' + error + '</ul></div>');
		}
//		}else{
//			alert('Debe "Guardar Cambios" del Cliente antes de editar un Empleado');
//		}
		
	});
	
	function bindButtonEventsRowTaxNumber() {
		$('#tblTaxNumbers tbody tr:last .btnRowEditTaxNumber').bind("click", function(event) {
			editRowTaxNumber($(this), event);
		});

		$('#tblTaxNumbers tbody tr:last .btnRowDeleteTaxNumber').bind("click", function(event) {
			deleteRowTaxNumber($(this), event);
		});
	}

	////////////EVENTS
			
	function validateBeforeAddTaxNumber(nit, name) {
		var error = '';
		if (nit === '') {
			error += '<li> El campo "Nit" no puede estar vacio </li>';
		}
		if (name === '') {
			error += '<li> El campo "Nombre" no puede estar vacio </li>';
		}
		return error;
	}
	
	$(".btnRowEditTaxNumber").click(function(event) {
		editRowTaxNumber($(this), event);
	});

	$(".btnRowDeleteTaxNumber").click(function(event) {
		deleteRowTaxNumber($(this), event);
		
	});
	

	
	$("#btnCancelTaxNumber").click(function(event) {
		$("#btnAddTaxNumber").show();
		$("#btnEditTaxNumber, #btnCancelTaxNumber").hide();
		$('#SalTaxNumberVsaveForm input[type=hidden], #SalTaxNumberVsaveForm input[type=text]').val("");
		$('#SalTaxNumberVsaveForm input[type=text]').removeAttr('style');
		event.preventDefault();
	});
	
	function editTaxNumber(id, nit, name){
		$("#rowTaxNumber"+id).find('.spaNitTaxNumber').text(nit);
		$("#rowTaxNumber"+id).find('.spaNameTaxNumber').text(name);
		$('#SalTaxNumberVsaveForm input[type=hidden], #SalTaxNumberVsaveForm input[type=text]').val("");
		$('#SalTaxNumberVsaveForm input[type=text]').removeAttr('style');
		$("#btnAddTaxNumber").show();
		$("#btnEditTaxNumber, #btnCancelTaxNumber").hide();
	}

	
	///////////PAGE FUNCTIONS
	function editRowTaxNumber(object, event) {
		event.preventDefault();
		var objectTableRowSelected = object.closest('tr');
		var id = objectTableRowSelected.find('.spaIdTaxNumber').val();
		var nit = objectTableRowSelected.find('.spaNitTaxNumber').text();
		var name = objectTableRowSelected.find('.spaNameTaxNumber').text();
		
		$("#txtIdTaxNumber").val(id);
		$("#txtNitTaxNumber").val(nit);
		$("#txtNameTaxNumber").val(name);
		$("#btnAddTaxNumber").hide();
		$("#btnEditTaxNumber, #btnCancelTaxNumber").show();
		$('#SalTaxNumberVsaveForm input[type=text]').css("background-color","#FFFF66");
		//alert(valor);
	}

	function deleteRowTaxNumber(object, event) {
		showBittionAlertModal({content: '¿Está seguro de eliminar este nit?'});
		$('#bittionBtnYes').click(function(event) {
			var objectTableRowSelected = object.closest('tr');
			var id = objectTableRowSelected.find('.spaIdTaxNumber').val();
			hideBittionAlertModal();
			ajax_delete_tax_number(id, objectTableRowSelected);
			event.preventDefault();
		});
		
		event.preventDefault();
	}

	
	function ajax_delete_tax_number(id, objectTableRowSelected){
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_delete_tax_number",			
            data:{id: id},
            beforeSend: function(){
				$('#boxProcessingTaxNumber').text(" Procesando...");
			},
            success: function(data){
//				var arrayData = data.split('|');
				if(data === "success"){
					showGrowlMessage('ok', 'Cambios guardados.');
					objectTableRowSelected.fadeOut("slow", function() {
						$(this).remove();
						reorderRowNumbers('tblTaxNumbers');//must go inside due the fadeout efect
					});
				}else if(data === "children"){
					alert("El Nit ya fue usado en Ventas, no se puede eliminar!");
				}else{
					showGrowlMessage('error', 'Vuelva a intentarlo.');
				}
				$('#boxProcessingTaxNumber').text('');
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessingTaxNumber').text('');
			}
        });
	}
	
//END SCRIPT	
});

