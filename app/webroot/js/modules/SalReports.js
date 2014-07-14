$(document).ready(function(){
//START SCRIPT

	////////////////////////////////////// START - INITIAL ACTIONS /////////////////////////////////////////
	
	fnBittionSetSelectsStyle();
	startDataTable();
	
	$('#txtReportStartDate, #txtReportFinishDate').keydown(function(e){e.preventDefault();});
	////////////////////////////////////// END - INITIAL ACTIONS /////////////////////////////////////////

	////////////////////////////////////// START - EVENTS /////////////////////////////////////////
	$('#cbxReportGroupTypes').change(function(){
		getGroupItemsAndFilters();
	});
	
//	$('#cbxReportMovementTypes').change(function(){
//        if($(this).val() === '1001'){
//			$('#boxWarehouse2').show();
//			$("#cbxReportWarehouse option[value='0']").remove();	//ESTO TENIA QUE USAR EN VEZ DE CREAR WO0!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//			$("#cbxReportWarehouse").select2();
//		}else{
//			$('#boxWarehouse2').hide();
//			if($("#cbxReportWarehouse option[value='0']").length === 0){
//				$("#cbxReportWarehouse").append('<option value="0">TODOS</option>');
//			}
//		}
//	});
	
	$('#cbxReportShowByTypes').change(function(){
		if($(this).val() === '1000'){//CLIENTES
			$('#boxCustomer').hide();
			$('#boxSalesmanWO0').hide();
			$('#boxCustomerWO0').show();
			$('#boxSalesman').show();
		}else if ($(this).val() === '998'){//VENDEDORES
			$('#boxSalesman').hide();
			$('#boxCustomerWO0').hide();
			$('#boxSalesmanWO0').show();
			$('#boxCustomer').show();
		}else{
			$('#boxCustomerWO0').hide();
			$('#boxSalesmanWO0').hide();
			$('#boxCustomer').show();
			$('#boxSalesman').show();
		}
	});
	
	$('#btnGenerateReport').click(function(){
		var startDate = $('#txtReportStartDate').val();
		var finishDate = $('#txtReportFinishDate').val();
		var showByType= $('#cbxReportShowByTypes').val();
		//var warehouse = getSelectedMultiSelect('#cbxReportWarehouse');//when it was multiple
		var warehouse = $('#cbxReportWarehouse').val();
		var warehouseName = $('#cbxReportWarehouse option:selected').text();
		var currency = $('#cbxReportCurrency').val();
		var groupBy = $('#cbxReportGroupTypes').val();
		var showByTypeName = $('#cbxReportShowByTypes option:selected').text();
		var detail = $('#cbxDetail').val();
		var items = getSelectedCheckboxes();
		var customer = $('#cbxReportCustomer').val();
		var customerName = $('#cbxReportCustomer option:selected').text();
		var salesman = $('#cbxReportSalesman').val();
		var salesmanName = $('#cbxReportSalesman option:selected').text();
		var customerWO0 = 'non-existent';
		var customerNameWO0 = 'non-existent';
		var salesmanWO0 = 'non-existent';
		var salesmanNameWO0 = 'non-existent';
		
		if($('#boxCustomerWO0').css('display') === 'block'){
			customerWO0 = $('#cbxReportCustomerWO0').val();
			customerNameWO0 = $('#cbxReportCustomerWO0 option:selected').text();
		}	
		if($('#boxSalesmanWO0').css('display') === 'block'){
			salesmanWO0 = $('#cbxReportSalesmanWO0').val();
			salesmanNameWO0 = $('#cbxReportSalesmanWO0 option:selected').text();
		}
		var error = validate(startDate, finishDate, showByType, warehouse, customer, customerWO0, salesman, salesmanWO0, currency, groupBy, items);
		if(error === ''){
			var DATA = {
						startDate:startDate,
						finishDate:finishDate,
						showByType:showByType,
						showByTypeName:showByTypeName,
						warehouse:warehouse,
						warehouseName:warehouseName,
						currency:currency,
						groupBy:groupBy,
						customer:customer,
						customerName:customerName,
						customerWO0:customerWO0,
						customerNameWO0:customerNameWO0,
						salesmanWO0:salesmanWO0,
						salesmanNameWO0:salesmanNameWO0,
						salesman:salesman,
						salesmanName:salesmanName,
						detail:detail,
						items:items
					   };
			ajax_generate_report(DATA);
			$('#boxMessage').html('');
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	});
	
	////////////////////////////////////// END - EVENTS /////////////////////////////////////////
	
	
	////////////////////////////////////// START - FUNCTIONS /////////////////////////////////////////
   function getGroupItemsAndFilters(){
		ajax_get_group_items_and_filters();
   }
   
   function validate(startDate, finishDate, showByType, warehouse, customer, salesman, currency, groupBy, items){
	   var  error='';
	   if(startDate === ''){error+='<li> El campo "Fecha Inicio" esta vacio </li>';}
	   if(finishDate === ''){error+='<li> El campo "Fecha Fin" esta vacio </li>';}
	   startDate = startDate.split("/");
	   finishDate = finishDate.split("/");
	   if(error === ''){
		    if(validateSameYearOnly(startDate[2], finishDate[2]) === 1){
				error+='<li> La "Fecha Inicio" y "Fecha Fin" deben ser del mismo año </li>';
			}else{
				if(validateGreaterThanStartDate(startDate, finishDate) === 1){error+='<li> La "Fecha Inicio" es mayor a la "Fecha Fin" </li>';}
			}
	   }
	   if(showByType === ''){error+='<li> El campo "Mostrar por" esta vacio </li>';}
	   if(warehouse === ''){
			   error+='<li> El campo "Almacen" esta vacio </li>';
	   }
	   if(customer !== 'non-existent'){//if exists
			if(customer === ''){error+='<li> El campo "Cliente" esta vacio </li>';}
//			if(customer === warehouse){error+='<li> El "Almacen" no puede ser igual que el "Almacen a Comparar" </li>';}
	   }
	   if(salesman !== 'non-existent'){//if exists
			if(salesman === ''){error+='<li> El campo "Vendedor" esta vacio </li>';}
//			if(salesman === warehouse){error+='<li> El "Almacen" no puede ser igual que el "Almacen a Comparar" </li>';}
	   }
	   if(currency === ''){error+='<li> El campo "Tipo de Cambio" esta vacio </li>';}
	   if(groupBy === ''){error+='<li> El campo "Agrupar por" esta vacio </li>';}
	   if(items.length === 0){error+='<li> Debe elegir al menos un "Item" </li>';}
	   return error;
   }
   
   function getSelectedCheckboxes(){
	   var selected = new Array();
	   $(".data-table tbody input:checkbox:checked").each(function() {
			selected.push($(this).val());
	   });
	   return selected;
   }
   
   function getSelectedMultiSelect(id){
		var selected = new Array();
	    $("form "+id+" option:selected").each(function () {
			selected.push($(this).val());
		});
		return selected;
   }
   
   function validateGreaterThanStartDate(startDate, finishDate){
		//Don't validate year 'cause is obligatory to be from the same year in other function
	   if(startDate[1] > finishDate[1]){//month
			return 1;//error
		}
		if(startDate[1] === finishDate[1]){//month
			if(startDate[0] > finishDate[0]){//day
				return 1;//error
			}
		}
		return 0;//ok
   }
   
   function validateSameYearOnly(startYear, finishYear){
	   if(startYear !== finishYear){
		   return 1; //error
	   }
	   return 0;//ok
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
				 "sInfo": "Encontrados _TOTAL_ Items",
				 "sInfoEmpty": "Encontrados 0 Items",
				 "sInfoFiltered": "(filtrado de _MAX_ Items)"
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
   
    function open_in_new_tab(url)
	{
	  var win=window.open(url, '_blank');
	  win.focus();
	}
   
////////////////////////////////////// END - FUNCTIONS /////////////////////////////////////////
	
//////////////////////////////////// START - AJAX ///////////////////////////////////////////////

	function ajax_generate_report(dataSent){ //Report
		$.ajax({
            type:"POST",
			async:false, // the key to open new windows when success
            url:urlModuleController + "ajax_generate_report",			
            data:dataSent,
			beforeSend: function(){
				$('#boxProcessing').text('Procesando...');
			},
            success: function(data){
				switch(data){
					case '1000'://CLIENTES
						open_in_new_tab(urlModuleController+'vreport_ins_or_outs');
						break;
					case '998'://VENDEDORES
						open_in_new_tab(urlModuleController+'vreport_transfers');
						break;
					default://ITEMS
						open_in_new_tab(urlModuleController+'vreport_ins_and_outs');
						break;	
				}
				$('#boxProcessing').text('');
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessing').text('');
			}
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
	
	//////////////////////////////////// END - AJAX ///////////////////////////////////////////////
	
	$('#btnGenerateReportCustomersDebts').click(function(){
		var customer = $('#cbxCustomer').val();
		var customerName = $('#cbxCustomer option:selected').text();
		var showType = $('#cbxShowType').val();
		var currency = $('#cbxCurrency').val();
		var error = validate1(customer, showType, currency);
		if(error === ''){
			var DATA = {
						customer:customer,
						customerName:customerName,
						showType:showType,
						currency:currency
					   };
			ajax_generate_report_customers_debts(DATA);
			$('#boxMessage').html('');
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
		return false;
	});
	
	function ajax_generate_report_customers_debts(dataSent){ //Report
		$.ajax({
            type:"POST",
			async:false, // the key to open new windows when success
            url:moduleController + "ajax_generate_report_customers_debts",			
            data:dataSent,
			beforeSend: function(){
				$('#boxProcessing').text('Procesando...');
			},
            success: function(data){
				open_in_new_tab(moduleController+'vreport_customers_debts');
				$('#boxProcessing').text('');
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessing').text('');
			}
        });
	}

	function validate1(customer, showType, currency){
		var  error='';
		if(showType === ''){error+='<li> El campo "Mostrar Ventas" esta vacio </li>';}
		if(customer === ''){error+='<li> El campo "Cliente" esta vacio </li>';}
		if(currency === ''){error+='<li> El campo "Tipo de Cambio" esta vacio </li>';}
		return error;
	}	
	
//END SCRIPT	
});

