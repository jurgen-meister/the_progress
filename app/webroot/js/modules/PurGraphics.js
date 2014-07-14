$(document).ready(function(){
//START SCRIPT

//ON START
	//EXECUTE onload
	//ajax_get_graphics_data();
	startDataTable();
	
/////////////
$('#cbxReportGroupTypes').change(function(){
		getGroupItemsAndFilters();
	});
	
	function getGroupItemsAndFilters(){
		ajax_get_group_items_and_filters();
	}
	
	$('#btnGenerateGraphicsPurchases').click(function(){
		var items = getSelectedCheckboxes();
		if(items.length > 0){
			ajax_get_graphics_data(items);	
			$('#boxMessage').html('');
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+'<li> Debe elegir al menos un "Item" </li>'+'</ul></div>');
		}
		
	});
	
	function getSelectedCheckboxes(){
	   var selected = new Array();
	   $(".data-table tbody input:checkbox:checked").each(function() {
			selected.push($(this).val());
	   });
	   return selected;
   }
	
	function startDataTable(){
	   $('.data-table').dataTable({
			"bJQueryUI": true,
			//"sPaginationType": "full_numbers",
			"sDom": '<"">t<"F"f>i',
			"sScrollY": "240px",
			//"bScrollCollapse": true,
			"bPaginate": false,
			"aaSorting":[], //on start sorting setting to empty
			"oLanguage": {
				"sSearch": "Filtrar:",
				 "sZeroRecords":  "No se encontro nada.",
				 //"sInfo":         "Ids from _START_ to _END_ of _TOTAL_ total" //when pagination exists
				 "sInfo": "Encontrados _TOTAL_ Productos",
				 "sInfoEmpty": "Encontrados 0 Productos",
				 "sInfoFiltered": "(filtrado de _MAX_ Productos)"
			},
			"aoColumnDefs": [
			  { 'bSortable': false, 'aTargets': [ 0 ] }// do not sort first column
			]
		});
		$('input[type=checkbox]').uniform();
		$("#title-table-checkbox").click(function() {
			var checkedStatus = this.checked;
			var checkbox = $(this).parents('.widget-box').find('tr td:first-child input:checkbox');		
			checkbox.each(function() {
				this.checked = checkedStatus;
				if (checkedStatus === this.checked) {
					$(this).closest('.checker > span').removeClass('checked');
				}
				if (this.checked) {
					$(this).closest('.checker > span').addClass('checked');
				}
			});
		});	
   }
   
	function ajax_get_group_items_and_filters(){ //Report
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_get_group_items_and_filters",			
            data:{type: $('#cbxReportGroupTypes').val()},
			beforeSend: function(){
				$('#boxProcessing').text('Procesando...');
			},
            success: function(data){
				$('#boxGroupItemsAndFilters').html(data);
				fnBittionSetSelectsStyle();
				startDataTable();
				$('#boxGroupItemsAndFilters #cbxReportGroupFilters').bind("change",function(){ 
					var selected = new Array();
					$("#boxGroupItemsAndFilters #cbxReportGroupFilters option:selected").each(function () {
						selected.push($(this).val());
					});
					ajax_get_group_items(selected);
				});
				$('#boxProcessing').text('');
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessing').text('');
			}
        });
	}
	
	function ajax_get_group_items(selected){ //Report
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_get_group_items",			
            data:{type: $('#cbxReportGroupTypes').val(), selected: selected},
			beforeSend: function(){
				$('#boxProcessing').text('Procesando...');
			},
            success: function(data){
				$('#boxGroupItems').html(data);
				startDataTable();
				$('#boxProcessing').text('');
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessing').text('');
			}
        });
	}

///////////////////////////////////////

	function createBarData(sentData){
		var splitData = sentData.split("|");
		var data = [];
		var finalData = [];
			for (var i=0; i < 12; i++){
				data[i]=[i+1,parseInt(splitData[i])];
			}
		finalData.push({
			data:data,
			bars: {
				show: true, 
				barWidth: 0.5, 
				order: 1
			}
		});
		return finalData;
	}

	function createBarOptions(){
		var options =
				{
					legend: true,
					/////////////////////
					 xaxis:{
							   ticks: [
										[1, "Ene"], [2, "Feb"], [3, "Mar"], [4, "Abr"], [5, "May"], [6, "Jun"],
										[7, "Jul"], [8, "Ago"], [9, "Sep"], [10, "Oct"], [11, "Nov"], [12, "Dic"]
							   ]
						}    
				/////////////////////
				};
		return options;
	}
	/////////////////////////////////////////////////////////

	function ajax_get_graphics_data(items){ 
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_get_graphics_data",			
            data:{year: $('#cbxYear').val(), priceType:$('#cbxPriceType').val() ,currency:$('#cbxCurrency').val() ,item:items},
			beforeSend: function(){
				$('#boxProcessing').text("Procesando...");
			},
            success: function(data){
				//var arrayData = data.split(",");
				var barOptions = createBarOptions();
				
				//Display graph    
				$.plot($(".bars"), createBarData(data), barOptions);
				
				//hide message
				$('#boxProcessing').text("");
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessing').text("");
			}
        });
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
	
	//EXECUTE onload
	//ajax_get_graphics_data();
	//$('#cbxItem').select2();
	//$('select').select2();
	
	//events
	/*
	$('#cbxItem, #cbxYear, #cbxCurrency, #cbxPriceType').change(function(){
		ajax_get_graphics_data();
	});
	*/

	
	
//END SCRIPT	
});
		