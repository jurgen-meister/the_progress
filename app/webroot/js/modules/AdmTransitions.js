$(document).ready(function() {
//START SCRIPT

	//***********************************************************************************************************************************//
	///////////////////////////////////////////////////START - AJAX CRUD MAIN//////////////////////////////////////////////////////////////
	var crudDataTableAction = 'life_cycles';//WON'T REPEAT
	var crudFieldMainFocus = 'btnAdd'; //WON'T REPEAT
	
	//Transition Config
	var crudModalIdTransition = 'modalSaveTransition';
	var crudFormIdTransition = 'formSaveTransition';
	var crudDataTableIdTransition = 'dataTableTransition';

	var crudModalActionTransition = 'ajax_modal_save_transition';
	var crudFormSaveActionTransition = 'fnAjaxSaveFormTransition';
	var crudFormDeleteActionTransition = 'fnAjaxDeleteRowTransition';

	var crudModalTitleTransition = 'Transición';
	var crudFieldModalFocusTransition = 'AdmTransitionAdmStateId';
	var rulesTransition ={};//sending empty becuase no validation is needed


	//States Config
	var crudModalIdState = 'modalSaveState';
	var crudFormIdState = 'formSaveState';
	var crudDataTableIdState = 'dataTableStates';

	var crudModalActionState = 'ajax_modal_save_state';
	var crudFormSaveActionState = 'fnAjaxSaveFormState';
	var crudFormDeleteActionState = 'fnAjaxDeleteRowState';

	var crudModalTitleState = 'Estado';
	var crudFieldModalFocusState = 'AdmStateName';
	var rulesState ={};//sending empty becuase .validate() is capturing the defaul controller required


	//Transactions Config	
	var crudModalIdTransaction = 'modalSaveTransaction';
	var crudFormIdTransaction = 'formSaveTransaction';
	var crudDataTableIdTransaction = 'dataTableTransactions';

	var crudModalActionTransaction = 'ajax_modal_save_transaction';
	var crudFormSaveActionTransaction = 'fnAjaxSaveFormTransaction';
	var crudFormDeleteActionTransaction = 'fnAjaxDeleteRowTransaction';

	var crudModalTitleTransaction = 'Transacción';
	var crudFieldModalFocusTransaction = 'AdmTransactionName';
	var rulesTransaction ={};//sending empty becuase .validate() is capturing the defaul controller required


	//MAIN
	if (urlAction === crudDataTableAction) {
		$('#' + crudFieldMainFocus).focus();
		if($('#currentDeviceType').text() === 'computer'){
			$('#cbxController').select2();
		}	
		myOwnDataTableStart($('#cbxController').val());
	}



	//EVENTS
	//Select Controller
	$('#cbxController').change(function(event) {
		myOwnDataTableStart($(this).val());
		event.preventDefault();
	});
	

	//Transition
	$('#btnAdd').click(function(event) {
		event.preventDefault();
		if( $('#headtabTransition').hasClass('active') ){
			ajaxGenerateModal(0, crudModalIdTransition, crudFormIdTransition, crudDataTableIdTransition, crudModalActionTransition, crudFormSaveActionTransition, crudFormDeleteActionTransition, crudModalTitleTransition, crudFieldModalFocusTransition, rulesTransition);
		}else if( $('#headtabState').hasClass('active') ){
			ajaxGenerateModal(0, crudModalIdState, crudFormIdState, crudDataTableIdState, crudModalActionState, crudFormSaveActionState, crudFormDeleteActionState, crudModalTitleState, crudFieldModalFocusState, rulesState);
		}else if( $('#headtabTransaction').hasClass('active') ){
			ajaxGenerateModal(0, crudModalIdTransaction, crudFormIdTransaction, crudDataTableIdTransaction, crudModalActionTransaction, crudFormSaveActionTransaction, crudFormDeleteActionTransaction, crudModalTitleTransaction, crudFieldModalFocusTransaction, rulesTransaction);
		}
	});


	///////////////////////////////////////////////////END - AJAX CRUD MAIN//////////////////////////////////////////////////////////////
	//***********************************************************************************************************************************//



	function myOwnDataTableStart(controllerId) {
		$.ajax({
			type: 'POST',
//			async:false,//hang request and prevent for multi submit, however there is no processing message
			url: urlModuleController + crudDataTableAction,
			dataType: 'json', //key
			data: {sSearch: controllerId},
			beforeSend: function() {
				$('#boxLoading').text('Cargando....');
			},
			success: function(data, textStatus, xhr) {
			//someday must transform all this methods var to an object, will be cleaner.
			createTable(data.Transitions.aaData, crudModalIdTransition, crudFormIdTransition, crudDataTableIdTransition, crudModalActionTransition, crudFormSaveActionTransition, crudFormDeleteActionTransition, crudModalTitleTransition, crudFieldModalFocusTransition, rulesTransition);
			createTable(data.States.aaData, crudModalIdState, crudFormIdState, crudDataTableIdState, crudModalActionState, crudFormSaveActionState, crudFormDeleteActionState, crudModalTitleState, crudFieldModalFocusState, rulesState);
			createTable(data.Transactions.aaData, crudModalIdTransaction, crudFormIdTransaction, crudDataTableIdTransaction, crudModalActionTransaction, crudFormSaveActionTransaction, crudFormDeleteActionTransaction, crudModalTitleTransaction, crudFieldModalFocusTransaction, rulesTransaction);
			$('#boxLoading').text('');
			},
			error: function(xhr, textStatus, error) {
				$.gritter.add({title: 'ERROR!', text: 'Al obtener la información.', sticky: false, image: urlImg+'error.png'});
			$('#boxLoading').text('');
			}
		});
	}


	function createTable(data, crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules) {
		$('#' + crudDataTableId + ' tbody tr').remove();
		var aaDataLength = data.length;
		var tBodyContent = '';
		if (aaDataLength > 0) {
			for (var i = 0; i < aaDataLength; i++) {
				tBodyContent += '<tr id="' + data[i][0] + '">';
				for (var j = 1; j < (data[i].length); j++) {
					tBodyContent += '<td>' + data[i][j] + '</td>';
				}
				tBodyContent += '</tr>';
			}
		}
		$('#' + crudDataTableId + ' tbody').append(tBodyContent);
		
		$('#' + crudDataTableId + ' tbody .btnEditRow').on('click', function(event) {
			editRow($(this), crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules);
			event.preventDefault();
		});
		$('#' + crudDataTableId + ' tbody .btnDeleteRow').on('click', function(event) {
			deleteRow($(this), crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules);
			event.preventDefault();
		});
		return true;
	}

	//***********************************************************************************************************************************//
	///////////////////////////////////////////////////START - AJAX CRUD CORE//////////////////////////////////////////////////////////////
	//FUNCTIONS

	//btnEdit rows function
	function editRow(object, crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules) {
		var tr = object.closest('tr');
		var trId = tr.attr('id');
		var trIdSplited = trId.split('-');
		ajaxGenerateModal(trIdSplited[1], crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules);
	}

	//btnDelete rows function
	function deleteRow(object, crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules) {
		var tr = object.closest('tr');
		var trId = tr.attr('id');
		var trIdSplited = trId.split('-');
		showBittionAlertModal({content: '¿Está seguro de eliminar?'});
		$('#bittionBtnYes').click(function(event) {
			ajaxDeleteRow(trIdSplited[1], crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules);
			hideBittionAlertModal();
			event.preventDefault();
		});
	}

	//Modal generator, only need to create a view with a form helper and that's it
	function createModal(crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules){
		var modal = '';
		modal += '<div id="' + crudModalId + '" class="modal hide ">'; //took off "fade" from the class to be faster
		modal += '<div class="modal-header">';
		modal += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>';
//		modal += '<h3> Controlador: ' +$('#cbxController option:selected').text()+' | Formulario: '+ crudModalTitle + '</h3>';
		modal += '<h3>'+$('#cbxController option:selected').text()+' | '+ crudModalTitle + '</h3>';
		modal += '</div>';
		modal += '<div class="modal-body">';
		modal += '</div>';
		modal += '</div>';
		$('body #content').prepend(modal);
	}

	//Through ajax generate dynamically the modal
	function ajaxGenerateModal(id, crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules) {
		if (id === undefined) {
			id = 0;
		}
		if ($('#' + crudModalId).length === 0) {
			createModal(crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules);
		}
		$.ajax({
			type: "POST",
			url: urlModuleController + crudModalAction,
			data: {id: id, controllerId:$("#cbxController").val()},
			success: function(data) {
				$('#' + crudModalId + ' .modal-body').html(data);//load the modal
				$('#' + crudModalId).modal({//show modal
					show: 'true',
					backdrop: 'static'
				});
				bindEventsToModal(crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules);//bind events if needed, ALWAYS after modal show, otherwise won't work
				$("html,body").css("overflow", "hidden");//remove scroll
			},
			error: function(data) {
				alert(data);
			}
		});
	}



	//Binding events if need, because the modal is generated dinamically
	function bindEventsToModal(crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules){
		validateSaveForm(crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules);
		$('#' + crudFieldModalFocus).focus();
			//toUpper every input
//		$('input:not(.select2-input)').on('keyup',function(event){
		$('#AdmTransactionName, #AdmStateName').on('keyup',function(event){

			$(this).val(($(this).val()).toUpperCase());
		});
		
		$('#' + crudModalId).on('hidden', function() {
			$("html,body").css("overflow", "auto");//restablish scroll
		});
	}

	//Main Save function
	function ajaxSaveForm(crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules) {
		var form = $('#' + crudFormId);
		var formData = form.serialize();
		$.ajax({
			type: 'POST',
			async: false, //hang request and prevent for multi submit, however there is no processing message
			url: urlModuleController + crudFormSaveAction,
			data: formData,
			beforeSend: function() {
			},
			success: function(data, textStatus, xhr) {
				if (data === 'success') {
					$('#' + crudModalId).modal('hide');
					myOwnDataTableStart($('#cbxController').val());
					$.gritter.add({title: 'EXITO!', text: 'Cambios guardados.', sticky: false, image: urlImg+'check.png'});
				} else {
					$('#' + crudModalId).modal('hide');
					$.gritter.add({title: 'NO SE GUARDO!', text: data, sticky: false, image: urlImg+'error.png'});
				}
				$('#' + crudFieldMainFocus).focus();
			},
			error: function(xhr, textStatus, error) {
				$('#' + crudModalId).modal('hide');
				$('#' + crudFieldMainFocus).focus();
				$.gritter.add({title: 'ERROR!', text: 'Ocurrio un problema.', sticky: false, image: urlImg+'error.png'});
			}
		});
	}

	function ajaxDeleteRow(id, crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules) {
		$.ajax({
			type: 'POST',
			async: false, //hang request and prevent for multi submit, however there is no processing message
			url: urlModuleController + crudFormDeleteAction,
			data: {id: id},
			beforeSend: function() {
			},
			success: function(data, textStatus, xhr) {
				if (data === 'success') {
					myOwnDataTableStart($('#cbxController').val());
					$.gritter.add({title: 'EXITO!', text: 'Eliminado.', sticky: false, image: urlImg+'check.png'});
				} else {
					$('#' + crudModalId).modal('hide');
					$.gritter.add({title: 'NO SE ELIMINO!', text: data, sticky: false, image: urlImg+'error.png'});
				}
				$('#' + crudFieldMainFocus).focus();
			},
			error: function(xhr, textStatus, error) {
				$('#' + crudModalId).modal('hide');
				$('#' + crudFieldMainFocus).focus();
				$.gritter.add({title: 'ERROR!', text: 'Ocurrio un problema.', sticky: false, image: urlImg+'error.png'});
			}
		});
	}

	//Validate Plugin
	function validateSaveForm(crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules) {
		$("#" + crudFormId).validate({
			onkeyup: false,
			submitHandler: function() {
				ajaxSaveForm(crudModalId, crudFormId, crudDataTableId, crudModalAction, crudFormSaveAction, crudFormDeleteAction, crudModalTitle, crudFieldModalFocus, rules);
			},
			rules:rules,
			errorClass: "help-inline",
			errorElement: "span",
			errorPlacement: function(error, element) {
				if (element.attr("type") === "checkbox" || element.attr("type") === "radio")
					error.insertAfter(element.parent().siblings().last());//this will insert the error message at the end of the checkboxes and radiobuttons
				else
					error.insertAfter(element);
			},
			highlight: function(element, errorClass, validClass) {
				$(element).parents('.control-group').addClass('error');
				$(element).parents('.control-group').removeClass('success');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('.control-group').removeClass('error');
				$(element).parents('.control-group').addClass('success');
			}
		});
	}
	/////////////////////////////////////////////////////END - AJAX CRUD CORE//////////////////////////////////////////////////////////////
	//***********************************************************************************************************************************//


//END SCRIPT
});