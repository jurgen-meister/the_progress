$(document).ready(function(){
//START SCRIPT

	///reset selects for firefox bug
	$('#cbxRoles option:nth-child(1)').attr("selected", "selected");
	$('#cbxModules option:nth-child(1)').attr("selected", "selected");

	if($('select').val() !== ''){
		ajax_list_transactions();
	}
	
	
    //Initialize AJAX
	$('#saveButton').click(function(event){
		$("#message").hide();
		ajax_save();
		event.preventDefault();
    });
	


    function ajax_list_transactions(){
        $.ajax({
            type:"POST",
            url:urlModuleController + "ajax_list_transactions",			
            data:{role: $("#cbxRoles").val(), module: $("#cbxModules").val()},
            beforeSend: showProcessing,
            success:function(data){
				$("#boxChkTree").html(data);
//				$('input[type=checkbox]').uniform(); //doesn't work with select all checkboxes function
				bindOnAjaxTable();
				$("#processing").text("");
			},
			error:function(data){
				$.gritter.add({
					title:	'ERROR!',
					text:	'Al listar las transacciones',
					sticky: false,
					image:urlImg+'error.png'
				});	
				$("#processing").text("");
			}
        });
    }
	
	function ajax_save(){
		var role = $("#cbxRoles").val();
		var module = $("#cbxModules").val();
		var checkboxes = [];
		checkboxes = captureCheckbox();
		$.ajax({
            type:"POST",
			async:false,//will freeze the browser until it's done, avoid repeated inserts after happy button clicker, con: processsing message won't work
            url:urlModuleController + "ajax_save",
            data:{role: role, module: module, transaction: checkboxes},
            beforeSend:function(){
				$("#processing").text("Procesando...");
			},
            success:function(data){
				if(data === 'success' || data ==='successEmpty'){
					$.gritter.add({
					   title:	'EXITO!',
					   text: 'Cambios guardados.',
					   sticky: false,
					   image:urlImg+'check.png'
				   });	
				}else{
					$.gritter.add({
						title:	'NO SE GUARDO!',
						text:	'Ocurrio un error.',
						sticky: false,
						image:urlImg+'error.png'
					});		
				};
				$("#processing").text("");
			},
			error:function(data){
				$.gritter.add({
					title:	'ERROR!',
					text:	'Ocurrio un problema.',
					sticky: false,
					image:urlImg+'error.png'
				});		
			}
        });
	}
	
	
    function showProcessing(){
        $("#processing").text("Procesando...");
    }

	
	function captureCheckbox(){
	 var allVals =[];
     $('form #boxChkTree :checked').each(function(){
		 if($(this).val() !== "empty"){
			allVals.push($(this).val());
		 }
       });	   
	   return allVals;
	}
	
	/////
	$('#cbxRoles, #cbxModules').change(function(){
        ajax_list_transactions();
		$("#message").hide();
    });
	
	function bindOnAjaxTable(){
		$("#chkMain").on('click',function() {
//			var checked_num = $('#tblTransactions input[name="chkTree[]"]:checked').length;
//			alert(checked_num);
			if(this.checked){
				$('#tblTransactions input[name="chkTree[]"]').prop('checked', true);
			}else{
				$('#tblTransactions input[name="chkTree[]"]').prop('checked', false);
			}
		});
		
		$('#tblTransactions tbody .chkController').on('click',function() {
			if(this.checked){
				$(this).closest('tr').find('.chkTransaction').prop('checked', true);
			}else{
				$(this).closest('tr').find('.chkTransaction').prop('checked', false);
			}
		});
		
		$('#tblTransactions tbody .chkTransaction').on('click',function() {
			var currentTr = $(this).closest('tr');
//			alert(currentTr.find('.chkTransaction:checked').length);
			if(currentTr.find('.chkTransaction:checked').length === 0){
				currentTr.find('.chkController').prop('checked', false);
			}
			if(currentTr.find('.chkTransaction:checked').length === 1){
				currentTr.find('.chkController').prop('checked', true);
			}

		});
	}
			
		

	
});

