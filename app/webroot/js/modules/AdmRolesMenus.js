$(document).ready(function() {
//START SCRIPT
	
	/////////////MAIN/////////////
	if($("#roles").val() !== '' && $("#parentMenus").val() !== ''){
		ajax_list_menus();
	}
	/////////////////////////////
	
	$('#roles option:nth-child(1)').attr("selected", "selected");
	$('#modules option:nth-child(1)').attr("selected", "selected");

	//Initialize dropdown lists to position 0 for firefox refresh bug
	$('#parentMenus option:nth-child(1)').attr("selected", "selected");
	$('#roles option:nth-child(1)').attr("selected", "selected");
	$('#modules_inside option:nth-child(1)').attr("selected", "selected");
	$('#roles_inside option:nth-child(1)').attr("selected", "selected");
	/////////Ajax
	$('#roles').change(function() {
		ajax_list_menus();
	});
	$('#parentMenus').change(function() {
		ajax_list_menus();
	});

	$('#roles_inside').change(function() {
		ajax_list_menus_inside();
	});
	$('#modules_inside').change(function() {
		ajax_list_menus_inside();
	});

	function ajax_list_menus() {
		$.ajax({
			type: "POST",
			url: urlModuleController + "ajax_list_menus",
			data: {
				role: $("#roles").val(),
				parentMenus: $("#parentMenus").val(),
				parentMenuName: $("#parentMenus option:selected").text()
			},
			beforeSend: showProcessing,
			success: showMenus
		});
	}



	$('#saveButton').click(function(event) {
		ajax_save();
		event.preventDefault();
	});



	function ajax_save() {
		var roleGeneric = $("#roles").val();
		var parentMenusGeneric = $("#parentMenus").val();
		var menuGeneric = [];
		menuGeneric = captureCheckbox();
		var type = 'outside';
		if (urlAction === 'add_inside') {
			roleGeneric = $("#roles_inside").val();
			moduleGeneric = $("#modules_inside").val();
			menuGeneric = captureCheckboxInside();
			type = 'inside';
		}
		$.ajax({
			type: "POST",
			async: false, //will freeze the browser until it's done, avoid repeated inserts after happy button clicker, con: processsing message won't work
			url: urlModuleController + "ajax_save",
			data: {role: roleGeneric, parentMenus: parentMenusGeneric, menu: menuGeneric, type: type},
			beforeSend: showProcessing,
			success: function(data) {
				if (data === 'success' || data === 'successEmpty') {
					$.gritter.add({
						title: 'EXITO!',
						text: 'Cambios guardados.',
						sticky: false,
						image: urlImg+'check.png'
					});
				} else {
					$.gritter.add({
						title: 'NO SE GUARDO!',
						text: 'Ocurrio un error.',
						sticky: false,
						image: urlImg+'error.png'
					});
				}
				;
				$("#processing").text("");
			},
			error: function(data) {
				$.gritter.add({
					title: 'ERROR!',
					text: 'Ocurrio un problema.',
					sticky: false,
					image: urlImg+'error.png'
				});
				$("#processing").text("");
			}
		});
	}

	function captureCheckbox() {
		var allVals = [];
		$('form #boxChkTree :checked').each(function() {
			allVals.push($(this).val());
		});
		return allVals;
	}

	function showProcessing() {
		$("#processing").text("Cargando...");
	}

	function showMenus(data) {
		$("#boxChkTree").html(data);
		bindOnAjaxTable();
		$("#processing").text("");
	}

	function bindOnAjaxTable() {
		$("#chkMain").on('click', function() {
			if (this.checked) {
				$('#tblMenus input[name="chkTree[]"] ').prop('checked', true);
			} else {
				$('#tblMenus input[name="chkTree[]"] ').prop('checked', false);
			}
		});
		
		$('#tblMenus tbody input[name="chkTree[]"] ').on('click',function() {
			var menusChecked = $('#tblMenus tbody input[name="chkTree[]"]:checked ').length;
			
			if(menusChecked === 0){
				$('#tblMenus #chkMain').prop('checked', false);
			}else{
				$('#tblMenus #chkMain').prop('checked', true);
			}
		});
	}

});

