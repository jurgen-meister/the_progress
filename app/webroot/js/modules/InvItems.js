$(document).ready(function() {
//START SCRIPT

	var arrayPricesAlreadySaved = [];
	var cont = 0;

	fnBittionSetSelectsStyle();

	startEventsWhenExistsPrices();

	clearFieldsForFirefox();

	//************************************************************************//
	//////////////////////////////////BEGIN-CONTROLS EVENTS/////////////////////
	//************************************************************************//

	//Validate only numbers
	$('#txtModalPrice, #txtPrice').keydown(function(event) {
		validateOnlyNumbers(event);
	});
	//Call modal
	$('#btnAddPrice').click(function(event) {
		initiateModalAddPrice();
		event.preventDefault(); //avoid page refresh
	});
	//Add a new price
	$('#btnModalAddPrice').click(function(event) {
		addPrice();
		event.preventDefault(); //avoid page refresh
		//location.reload();
	});
	//edit an existing price
	$('#btnModalEditPrice').click(function(event) {
		editPrice();
		event.preventDefault(); //avoid page refresh
	});
	//save item
	$('#saveButton').click(function(event) {
		ajax_save_item();
		event.preventDefault();
	});
	$("#txtModalDate, #txtPriceDate").keypress(function(event) {
		event.preventDefault();
	});

	//************************************************************************//
	//////////////////////////////////END-CONTROLS EVENTS//////////////////////
	//************************************************************************//


	//************************************************************************//
	//////////////////////////////////BEGIN-FUNCTIONS////////////////
	//************************************************************************//
	function clearFieldsForFirefox() {
		var urlController = ['save_item'];
		for (var i = 0; i < urlController.length; i++) {
			if (urlAction === urlController[i]) {
				if (urlActionValue1 === null) {
					$('input').val('');//empty all inputs including hidden thks jquery 
					$('textarea').val('');
				}
			}
		}
	}


	function startEventsWhenExistsPrices() {
		var arrayAux = [];
		arrayAux = getPrices();
		if (arrayAux[0] !== 0) {
			for (var i = 0; i < arrayAux.length; i++) {
				arrayPricesAlreadySaved[i] = arrayAux[i]['inv_price_id'];
				createEventClickEditPriceButton(arrayAux[i]['inv_price_id']);
				createEventClickDeletePriceButton(arrayAux[i]['inv_price_id']);
			}
		}
		/*else{
		 alert('esta vacio');
		 }*/
	}

	//show message of procesing for ajax
	function showProcessing() {
		$('#processing').text("Procesando...");
	}

	function initiateModalAddPrice() {
		if (arrayPricesAlreadySaved.length === 0) {  //For fix undefined index
			arrayPricesAlreadySaved = [0]; //if there isn't any row, the array must have at least one field 0 otherwise it sends null
		}
		$('#btnModalAddPrice').show();
		$('#btnModalEditPrice').hide();
		$('#boxModalValidatePrice').html('');//clear error message
		ajax_initiate_modal_add_price(arrayPricesAlreadySaved);
	}


	function initiateModal() {
		$('#modalAddPrice').modal({
			show: 'true',
			backdrop: 'static'
		});
		$('#modalAddPrice').on('shown', function () {
			fnBittionSetSelectsStyle();
			$('.select2-input').focus();//because is wrapp with select2 stuff, must call this
		});

	}

	function validateOnlyNumbers(event) {
		// Allow backspace,	tab, decimal point
		if (event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 110 || event.keyCode === 190) {
			// let it happen, don't do anything
		}
		else {
			// Ensure that it is a number and stop the keypress
			if ((event.keyCode < 96 || event.keyCode > 105)) { //habilita keypad
				if ((event.keyCode < 48 || event.keyCode > 57)) {

					event.preventDefault();

				}
			}
		}
	}

	function addPrice() {
		cont = cont + 1;
		var contTable = 'tab' + cont;
		var priceTypeId = $('#cbxModalPriceTypes option:selected').val();
		var priceTypeName = $('#cbxModalPriceTypes option:selected').text();
		var priceDate = $('#txtModalDate').val();
		var priceAmount = $('#txtModalPrice').val();
		var priceDescription = $('#txtModalDescription').val();
		var error = validatePrice(priceTypeId, priceAmount, priceDate);
		var exRate = 0;
		if (error === "") {
//			ajax_check_exists_ex_rate();
//			exRate = $("#tokenAle").val();
//			alert(exRate);
//			if(exRate > 0){
			ajax_save_price();
//				createRowPriceTable(contTable,priceTypeId, priceTypeName, priceDate,priceAmount, priceDescription);
//				createEventClickEditPriceButton(contTable);
//				createEventClickDeletePriceButton(contTable);			
//				arrayPricesAlreadySaved.push(contTable);  //push into array of the added item
//				$('#modalAddPrice').modal('hide');
//			}
		}
		else {
			$('#boxModalValidateItem').html('<ul>' + error + '</ul>');
		}
	}



	function editPrice() {

		var priceId = $('#txtPriceId').val();
		var priceTypeId = $('#cbxModalPriceTypes option:selected').val();
		var priceTypeName = $('#cbxModalPriceTypes option:selected').text();
		var priceDate = formatDate(new Date());
		var priceAmount = $('#txtModalPrice').val();
		var priceDescription = $('#txtModalDescription').val();


		var error = validatePrice(priceTypeId, priceAmount, priceDate);
		if (error == '') {

			$('#spaPriceName' + priceTypeId).text(priceTypeName);
			$('#spaPriceDate' + priceTypeId).text(priceDate);
			$('#spaPriceAmount' + priceTypeId).text(priceAmount);
			$('#spaPriceDescription' + priceTypeId).text(priceDescription);
			//$('#spaQuantity'+priceId).text(parseInt(quantity,10));
			//var row = '<tr><td>'+priceTypeId+'---'+priceIdForEdit+'</td></tr>';
			//$('#spaPriceDescription'+priceTypeId).val(objectTableRowSelected.find('#txtModalDescription'+priceTypeId).text());	
			//$('#tablaPrecios > tbody:last').append(row);
			$('#modalAddPrice').modal('hide');

		} else {
			$('#boxModalValidatePrice').html('<ul>' + error + '</ul>');
		}
	}

	function formatDate(d) {


		var month = d.getMonth() + 1;
		var day = d.getDate();
		//var hour = d.getHours();
		//var minute = d.getMinutes();
		//var second = d.getSeconds();

		var output = (('' + day).length < 2 ? '0' : '') + day + '/' +
				(('' + month).length < 2 ? '0' : '') + month + '/' +
				d.getFullYear();


		return output;
	}

	//validates before add price
	function validatePrice(priceType, priceAmount, priceDate) {
		var error = '';

		if (priceType === '') {
			error += '<li>El campo "Tipo de Precio" no puede estar vacio</li>';
		}

		if (priceDate === '') {
			error += '<li>El campo "Fecha" no puede estar vacio</li>';
		}

		if (priceAmount === '') {
			error += '<li>El campo "Monto" no puede estar vacio</li>';
		}


		return error;
	}

	function createRowPriceTable(contTable, priceTypeId, priceTypeName, priceDate, priceAmount, priceDescription) {
		var row = '<tr>';
		row += '<td><span id="spaPriceName' + contTable + '">' + priceTypeName + '</span><input type="hidden" value="' + contTable + '" id="txtPriceId" ><input type="hidden" value="' + contTable + '" id="txtItemId" ></td>';
		row += '<td><span id="spaPriceDate' + contTable + '">' + priceDate + '</span></td>';
		row += '<td><span id="spaPriceAmount' + contTable + '">' + priceAmount + '</span></td>';
		row += '<td><span id="spaPriceDescription' + contTable + '">' + priceDescription + '</span></td>';
		row += '<td class="columnItemsButtons">';
		//row +='<a class="btn btn-info" href="#" id="btnEditPrice'+contTable+'" title="Editar"><i class="icon-pencil icon-white"></i></a>';
		row += '<a class="btn btn-danger" href="#" id="btnDeletePrice' + contTable + '" title="Eliminar"><i class="icon-trash icon-white"></i></a>';
		row += '</td>';
		row += '</tr>'
		$('#tablaPrecios > tbody:last').append(row);
	}

	function createEventClickEditPriceButton(contTable) {
		$('#btnEditPrice' + contTable).bind("click", function(event) { //must be binded 'cause loaded live with javascript'
			var objectTableRowSelected = $(this).closest('tr')
			initiateModalEditPrice(objectTableRowSelected);
			event.preventDefault(); //avoid page refresh
		});
	}

	function initiateModalEditPrice(objectTableRowSelected) {
		var priceIdForEdit = objectTableRowSelected.find('#txtPriceId').val();  //
		$('#btnModalAddPrice').hide();
		$('#btnModalEditPrice').show();
		$('#boxModalValidatePrice').html('');//clear error message

		$('#cbxModalPriceTypes').empty();
		$('#cbxModalPriceTypes').append('<option value="' + priceIdForEdit + '">' + objectTableRowSelected.find('td:first').text() + '</option>');


		$('#txtModalPrice').val(objectTableRowSelected.find('#spaPriceAmount' + priceIdForEdit).text());
		$('#txtModalDescription').val(objectTableRowSelected.find('#spaPriceDescription' + priceIdForEdit).text());

		initiateModal();
	}

	function createEventClickDeletePriceButton(contTable) {
		$('#btnDeletePrice' + contTable).bind("click", function(event) { //must be binded 'cause loaded live with javascript'
			var objectTableRowSelected = $(this).closest('tr')
			deletePrice(objectTableRowSelected);
			event.preventDefault(); //avoid page refresh
		});
	}

	function deletePrice(objectTableRowSelected) {
		if (confirm('Esta seguro de Eliminar el Precio?')) {

			var priceIdForDelete = objectTableRowSelected.find('#txtPriceId').val();  //
			var priceTypeId = objectTableRowSelected.find('#txtPriceTypeId').val();  //
			arrayPricesAlreadySaved = jQuery.grep(arrayPricesAlreadySaved, function(value) {
				return value != priceIdForDelete;
			});

			ajax_delete_price(priceIdForDelete, objectTableRowSelected, priceTypeId);
			//objectTableRowSelected.remove();			

		}
	}

	//get all prices
	function getPrices() {
		var arrayPrices = [];

		var itemId = '';
		var priceId = '';
		var priceTypeId = '';
		var priceTypeName = '';
		var priceDate = '';
		var priceAmount = '';
		var priceDescription = '';


		$('#tablaPrecios tbody tr').each(function() {

			priceId = $(this).find('#txtPriceId').val();

			priceTypeId = $(this).find('#spaPriceType' + priceId).text();
			priceDate = $(this).find('#spaDate' + priceId).text();
			priceDate = $(this).find('#spaDate' + priceId).text();
			priceAmount = $(this).find('#spaPrice' + priceId).text();
			priceDescription = $(this).find('#spaDescription' + priceId).text();


			arrayPrices.push({'inv_price_id': priceId, 'pricetype': priceTypeId, 'date': priceDate, 'price': priceAmount, 'description': priceDescription});

		});

		if (arrayPrices.length == 0) {  //For fix undefined index
			arrayPrices = [0] //if there isn't any row, the array must have at least one field 0 otherwise it sends null
		}

		return arrayPrices;
	}



	//************************************************************************//
	//////////////////////////////////END-FUNCTIONS//////////////////////
	//************************************************************************//


	//************************************************************************//
	//////////////////////////////////BEGIN-AJAX FUNCTIONS//////////////////////
	////************************************************************************//
	function ajax_initiate_modal_add_price(pricesAlreadySaved) {
		$.ajax({
			type: "POST",
			url: urlModuleController + "ajax_initiate_modal_add_price",
			data: {pricesAlreadySaved: pricesAlreadySaved}, //, warehouse: $('#cbxWarehouses').val(), transfer:transfer, warehouse2:warehouse2},
			beforeSend: showProcessing(),
			success: function(data) {
				$('#processing').text('');
				$('#boxModalIntiatePrice').html(data);
				$('#boxModalValidateItem').text('');
				initiateModal();
				//focus and select 2 go inside event show on initiateModal	
				$("html,body").css("overflow", "hidden");//remove scroll
				$('#modalAddPrice').on('hidden', function() {
					$("html,body").css("overflow", "auto");//restablish scroll
				});
			},
			error: function(data) {
				$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
				$('#processing').text('');
			}
		});
	}

	//Save price
	function ajax_save_price() {

		$.ajax({
			type: "POST",
			url: urlModuleController + "ajax_save_price",
			data: {itemId: $('#txtItemIdHidden').val(),
				priceTypeId: $('#cbxModalPriceTypes option:selected').val(),
				priceTypeName: $('#cbxModalPriceTypes option:selected').text(),
				priceDate: $('#txtModalDate').val(),
				priceAmount: $('#txtModalPrice').val(),
				priceDescription: $('#txtModalDescription').val(),
				currencyType: $("#cbxCurrencyType").val()
			},
			beforeSend: showProcessing(),
			success: function(data) {

				if (data === "noExRate") {
					//alert("mierda");
					$("#boxModalValidateItem").text('No hay un "Tipo de Cambio" registrado para la fecha elegida');
				}
				if (data === "success") {
					location.reload();
				}
				$('#processing').text('');
			},
			error: function(data) {
				//ojo aca esta disparando error a causa del reload que se esta haciendo en el evento //Add a new price
				//$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
				$('#processing').text('');
			}
		});
	}

	//Delete price
	function ajax_delete_price(priceIdForDelete, objectTableRowSelected, priceTypeId) {

		$.ajax({
			type: "POST",
			url: urlModuleController + "ajax_delete_price",
			data: {priceId: priceIdForDelete, itemId: $("#txtItemIdHidden").val(), priceTypeId: priceTypeId},
			beforeSend: showProcessing(),
			success: function(data) {
				if (data === "success") {
					$('#boxMessage').html('<div class="alert alert-success">\n\
					<button type="button" class="close" data-dismiss="alert">&times;</button>Precio eliminado<div>');
					objectTableRowSelected.remove();

				}
				if (data === "mustExistOne") {
					//alert("No se puede eliminar el precio porque debe existir al menos uno de su tipo");
					showBittionAlertModal({content: 'No se puede eliminar el PRECIO porque debe existir al menos 1 de su TIPO', btnYes: '', btnNo: 'ok'});
				}
				if(data === 'error'){
					$('#boxMessage').html('<div class="alert alert">\n\
					<button type="button" class="close" data-dismiss="alert">&times;</button>Error!!!, no se pudo eliminar<div>');
					objectTableRowSelected.remove();
				}
				$('#processing').text('');

			},
			error: function(data) {
				$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
				$('#processing').text('');
			}
		});
	}

	//Save Item
	function ajax_save_item() {

		$.ajax({
			type: "POST",
			url: urlModuleController + "ajax_save_item",
			data: {itemId: $('#txtItemIdHidden').val(),
				itemSupplier: $('#supplier option:selected').val(),
				itemCode: $('#code').val(),
				itemBrand: $('#brand option:selected').val(),
				itemCategory: $('#category option:selected').val(),
				itemName: $('#name').val(),
				itemDescription: $('#description').val(),
				itemMin: $('#minquantity').val(),
				itemPic: $('#picture').val()
			},
			beforeSend: showProcessing(),
			success: function(data) {

				window.location.replace(urlModuleController + 'index');

				$('#boxMessage').html('<div class="alert alert-success">\n\
				<button type="button" class="close" data-dismiss="alert">&times;</button>Item guardado con exito<div>');
				$('#processing').text('');

			},
			error: function(data) {
				$('#boxMessage').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Ocurrio un problema, vuelva a intentarlo<div>');
				$('#processing').text('');
			}
		});
	}



	//************************************************************************//
	//////////////////////////////////END-AJAX FUNCTIONS////////////////////////
	//************************************************************************//
});

