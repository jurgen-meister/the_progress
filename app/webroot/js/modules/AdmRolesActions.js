$(document).ready(function(){
//START SCRIPT

	///reset selects for firefox bug
	$('#cbxRoles option:nth-child(1)').attr("selected", "selected");
	$('#cbxModules option:nth-child(1)').attr("selected", "selected");
	
	//Initialize dropdown lists to position 0 for firefox refresh bug
    $('#cbxModules option:nth-child(1)').attr("selected", "selected");
    $('#cbxRoles option:nth-child(1)').attr("selected", "selected");
	/////////Ajax
	$('#cbxRoles, #cbxModules').change(function(){
        ajax_list_actions();		
    });
	ajax_list_actions();
	
	
	function ajax_list_actions(){
        $.ajax({
            type:"POST",
            url: urlModuleController + "ajax_list_actions",			
            data:{module: $("#cbxModules").val(), role: $("#cbxRoles").val()},
            beforeSend: showProcessing,
            success:function(data){
				$("#boxChkTree").html(data);
				bindOnAjaxTable();
				$("#processing").text("");
			},
			error:function(data){
				$.gritter.add({
					title:	'ERROR!',
					text:	'Al listar las acciones',
					sticky: false,
					image:urlImg+'error.png'
				});	
				$("#processing").text("");
			}
        });
    }
	
		
	$('#saveButton').click(function(){
		ajax_save();
		return false; //evita haga submit form
    });
	
	
	
	function ajax_save(){
		var role = $("#cbxRoles").val();
		var module = $("#cbxModules").val();
		var menu = [];
		menu = captureCheckbox();
		$.ajax({
            type:"POST",
			async:false,//will freeze the browser until it's done, avoid repeated inserts after happy button clicker, con: processsing message won't work
            url:urlModuleController +"ajax_save",
            data:{role: role, module: module, menu: menu },
            beforeSend:showProcessing,
            success:function(data){
				if(data === 'success' || data ==='successEmpty'){
					$.gritter.add({
					   title: 'EXITO!',
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
				$("#processing").text("");
			}
        });
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
	
	
	function showProcessing(){
        $("#processing").text("Procesando...");
    }
	
	function bindOnAjaxTable(){
		$("#chkMain").on('click',function() {
//			var checked_num = $('#tblActions input[name="chkTree[]"]:checked').length;
//			alert(checked_num);
			if(this.checked){
				$('#tblActions input[name="chkTree[]"]').prop('checked', true);
			}else{
				$('#tblActions input[name="chkTree[]"]').prop('checked', false);
			}
		});
		
		$('#tblActions tbody .chkController').on('click',function() {
			if(this.checked){
				$(this).closest('tr').find('.chkAction').prop('checked', true);
			}else{
				$(this).closest('tr').find('.chkAction').prop('checked', false);
			}
		});
		
		$('#tblActions tbody .chkAction').on('click',function() {
			var currentTr = $(this).closest('tr');
//			alert(currentTr.find('.chkTransaction:checked').length);
			if(currentTr.find('.chkAction:checked').length === 0){
				currentTr.find('.chkController').prop('checked', false);
			}
			if(currentTr.find('.chkAction:checked').length === 1){
				currentTr.find('.chkController').prop('checked', true);
			}

		});
	}
	

	
});

