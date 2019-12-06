function submitEvento(){
	var programas = $('#table_program_data').val();
	var items = $('#table_items_data').val();
	var invitados = $('#table_invitados_data').val();
	var count_invitados = $('#count_invitados').val();
	$('#btn_guardar').val(1);
	toastr.options = {
	      "closeButton": false,
	      "debug": false,
	      "newestOnTop": false,
	      "progressBar": false,
	      "positionClass": "toast-top-right",
	      "preventDuplicates": false,
	      "onclick": null,
	      "showDuration": "300",
	      "hideDuration": "1000",
	      "timeOut": "5000",
	      "extendedTimeOut": "1000",
	      "showEasing": "swing",
	      "hideEasing": "linear",
	      "showMethod": "fadeIn",
	      "hideMethod": "fadeOut"
    	}
	if(programas.length == 2){
	    toastr.error('<div style="font-size:16px">Debe agregar al menos una programación para este evento.</div>');
	    $('#TabEventos a[href="#programacion"]').tab('show');

	}else if (invitados.length == 0 && count_invitados == 0) {
	    toastr.error('<div style="font-size:16px">Debe agregar al menos un invitado para este evento.</div>');
	    $('#TabEventos a[href="#invitados"]').tab('show');   
	}else{
    	$('form#eventos').submit();
	    $('#TabEventos a[href="#datos"]').tab('show');

	}


}


//selecciona un empleado del staff del evento para editarlo
function selecionarEmpleadoInvitado(id){
	var url =$('.invitado_empleado_url').attr('id');
	url = url+'?empleadoInvitado='+id;

	$.post(url, function( data ) {
		data.forEach( function(valor, indice, array) {
			console.log(valor)
			$('#invitado_empleado').val(valor.empleado_codigo).trigger('change');
			$('#estado_invitado_empleado').val(valor.activo).trigger('change');
			$('#id_invitado').val(id);


		});
	});
}

//agrega o edita un empleado del staff de un evento
function saveEmpleadoInvitado(){
	var invitado_empleado = $('#invitado_empleado').val();
	var estado_invitado_empleado = $('#estado_invitado_empleado').val();
	var id_invitado = $('#id_invitado').val();
	var evento_codigo = $('#evento_codigo').val();
	var url =$('.save_invitado_empleado').attr('id');
	url = url+'?invitado_codigo='+id_invitado+'&codigo_empleado='+invitado_empleado+'&activo='+estado_invitado_empleado+'&evento_codigo='+evento_codigo;
	$.post(url, function( data ) {
		$.pjax.reload({
                container:"#invitados_evento",
                replace: false,
                push:false,
                timeout:5000
            });
	    toastr.success('<div style="font-size:16px">Se ha actualizado el invitado exitosamente.</div>');

	}).fail(function() {
	    toastr.error('<div style="font-size:16px">Ocurrió un error al actualizar.</div>');
  	});
	$('#invitado_empleado').val('').trigger('change');
	$('#estado_invitado_empleado').val('').trigger('change');
	$('#id_invitado').val(0);

}

function cargaDatatableInvitados(){
	var table = $('#table_invitados').DataTable();
    table.destroy();   
    $('#table_invitados').DataTable( {
            'responsive': true,
            "searching": false,
            "lengthChange": false,
            "ordering": false,
            "lengthMenu": [ 10 ],
            "info":     false,
            "paging":true,
            "language": {
		        "zeroRecords": "No se encontraron resultados.",
		    },
            data:  [],
            columns: [
            			{title: "Número de Documento"},
                        { title: "Nombre" },
                        { title: "Apelllido Materno" },
                        { title: "Apellido Paterno" },
                        { title: "Estado" },
                    ]
    });
}

function uploadFile(){
	var formData = new FormData();
	var documento = $("#eventos-file").prop("files")[0]; 
	formData.append("file", documento);
	var url = $('.file_url').attr('id');
	$.ajax({
		url: url,
		type: "post",
		enctype: 'multipart/form-data',
		data: formData,
		contentType: false,
        cache: false,
        processData: false,
	})
	.done(function(res){
		array_datatable = []
		res.forEach( function(valor, indice, array) {
	        var data_datatable = [];
	    	data_datatable = [
	                            valor[0]['numero_documento'],
	                            valor[0]['nombre'],
	                            valor[0]['apellido_materno'],
	                            valor[0]['apellido_paterno'],
	                            (valor[0]['estado_codigo'] == 1)?'Activo':'Inactivo'
	                         ]
        	array_datatable.push(data_datatable);

    	});
		$('#table_invitados_data').val(JSON.stringify(res));
		var table = $('#table_invitados').DataTable();
	    table.destroy();   
	    $('#table_invitados').DataTable( {
	            'responsive': true,
	            "searching": false,
	            "lengthChange": false,
	            "ordering": false,
	            "lengthMenu": [ 10 ],
	            "info":     false,
	            "paging":true,
	            "language": {
			        "zeroRecords": "No se encontraron resultados.",
			    },
	            data:  array_datatable,
	            columns: [
	            			{title: "Número de Documento"},
	                        { title: "Nombre" },
	                        { title: "Apelllido Materno" },
	                        { title: "Apellido Paterno" },
	                        { title: "Estado" },
	                    ]
	    });
		$("#invitados_preview_table").show();
	});


}


//selecciona un empleado del staff del evento para editarlo
function selecionarEmpleadoStaff(id){
	var url =$('.staff_empleado_url').attr('id');
	url = url+'?empleadoStaff='+id;

	$.post(url, function( data ) {
		data.forEach( function(valor, indice, array) {
			$('#staff_empleado').val(valor.empleado_codigo).trigger('change');
			$('#staff_tarea').val(valor.tarea_codigo).trigger('change');
			$('#estado_staff_empleado').val(valor.activo).trigger('change');
			$('#id_staff').val(id);


		});
	});
}

//agrega o edita un empleado del staff de un evento
function saveEmpleadoStaff(){
	var empleado_staff = $('#staff_empleado').val();
	var tarea_staff = $('#staff_tarea').val();
	var estado_staff = $('#estado_staff_empleado').val();
	var staff_codigo = $('#id_staff').val();
	var evento_codigo = $('#evento_codigo').val();
	var url =$('.save_staff_empleado').attr('id');
	url = url+'?staff_codigo='+staff_codigo+'&staff_empleado='+empleado_staff+'&tarea_codigo='+tarea_staff+'&activo='+estado_staff+'&evento_codigo='+evento_codigo;
	$.post(url, function( data ) {
		$.pjax.reload({
                container:"#staff_evento",
                replace: false,
                push:false,
                timeout:5000
            });
		toastr.success('<div style="font-size:16px">Se ha actualizado el staff exitosamente.</div>');

	}).fail(function() {
	    toastr.error('<div style="font-size:16px">Ocurrió un error al actualizar.</div>');
  	});
	$('#staff_empleado').val('').trigger('change');
	$('#staff_tarea').val('').trigger('change');
	$('#estado_staff_empleado').val('').trigger('change');
	$('#id_staff').val(0);

}
	
var items_obj = [];
function agregarItems(){
	if($('#id_item').val() != ""){
		//editar item
		items_obj.forEach( function(valor, indice, array) {
			if(valor.id == $('#id_item').val()){
				    
					valor.item_nombre = $( "#item_codigo option:selected" ).text();;
					valor.item_codigo = $('#item_codigo').val();
					valor.item_cantidad= $('#eventos-cantidad').val();;
					valor.item_stock = $('#eventos-cantidad').val();
	                valor.item_estado = ($('#eventos-estado_item').is(":checked") == true)?'1':'0';


			}
	    });
	}else{
		//agregar item
		//se capturan los datos
		var item_codigo = $('#item_codigo').val();
		var nombre_item = $( "#item_codigo option:selected" ).text();
		var cantidad = $('#eventos-cantidad').val();	
		var estado = ($('#eventos-estado_item').is(":checked") == true)?'1':'0';
		var ind = items_obj.length;
	    var btn = '<a class="btn-editar-item" id="btn-'+ind+'"><span class="glyphicon glyphicon-pencil" title="Editar"></span></a>'

		var item =  {
						id:ind,
						item_evento_codigo:0,
						item_nombre:nombre_item,
						item_codigo:item_codigo,
						item_cantidad:cantidad,
						item_stock:cantidad,
		                item_estado:estado,
						btn:btn
			        }

	    items_obj.push(item);
	}
	//se arma el array para imprimir el datatable
    var array_datatable = []
    items_obj.forEach( function(valor, indice, array) {
        var data_datatable = [];
    	data_datatable = [
                            valor.item_nombre,
                            valor.item_cantidad,
                            valor.item_stock,
                            (valor.item_estado == 1)?'Activo':'Inactivo',
                            valor.btn
                         ]
        array_datatable.push(data_datatable);

    });
    var table = $('#table_items').DataTable();
    table.destroy();   
    $('#table_items').DataTable( {
            'responsive': true,
            "searching": false,
            "lengthChange": false,
            "ordering": false,
            "lengthMenu": [ 4 ],
            "info":     false,
            "paging":false,
            "language": {
		        "zeroRecords": "No se encontraron resultados.",
		    },
            data:  array_datatable,
            columns: [
                        { title: "Nombre" },
                        { title: "Cantidad" },
                        { title: "Stock" },
                        { title: "Estado" },
                        { title: "" },
                    ]
    });

	$('#item_codigo').val("").trigger('change');
	$("#eventos-estado_item").attr("checked", false);
	$("#id_item").val("");
	$('#eventos-cantidad').val("");
    $('#table_items_data').val(JSON.stringify(items_obj));

}

$(document).on('click', '.btn-editar-item', function(id){
	var id = this.id;
	id = id.split('-');
	id = id[1];
	items_obj.forEach( function(valor, indice, array) {
		if(valor.id == id){
			var estado = (valor.item_estado == '1')?true:false;
			$('#item_codigo').val(valor.item_codigo).trigger('change');
			$("#eventos-estado_item").attr("checked", estado);
			$("#id_item").val(id);
			$('#eventos-cantidad').val(valor.item_cantidad);

			/*var $el = $('#eventos-estado_item'), opts = $el.attr('data-krajee-bootstrapSwitch');
			console.log(opts);
    		$el.bootstrapSwitch(opts);*/

		}
   

    });

})


function cargarDatatable(){

	$.post($('.item_url').attr('id'), function( data ) {
        data = [data.data];
        var array_datatable = []
        var array_obj = []
        var ind = 0;
        data[0].forEach( function(valor, indice, array) {
            var btn = '<a class="btn-editar-item" id="btn-'+ind+'"><span class="glyphicon glyphicon-pencil" title="Editar"></span></a>'
        	//valores de un item
        	data_datatable = [];
        	var item = {};
        	item ={
            				id:ind,
            				item_evento_codigo:valor.item_evento_codigo,
            				item_nombre:valor.nombre,
            				item_codigo:valor.item_codigo,
            				item_cantidad:valor.cantidad,
            				item_stock:valor.stock,
            				item_estado:valor.estado,
            				btn:btn
        			  }

		    data_datatable = [
	                            valor.nombre,
	                            valor.cantidad,
	                            valor.stock,
	                            (valor.estado == 1)?'Activo':'Inactivo',
	                            btn
	                         ]
         	items_obj.push(item);

         	//array que se imprime en el datatable
            array_datatable.push(data_datatable);
            ind++;
        });

        var table = $('#table_items').DataTable();
        table.destroy();   
        $('#table_items').DataTable( {
	            'responsive': true,
	            "searching": false,
	            "lengthChange": false,
	            "ordering": false,
	            "lengthMenu": [ 4 ],
	            "info":false,
	            "paging":false,
	            "language": {
		            "zeroRecords": "No se encontraron resultados.",
		        },
	            data:  array_datatable,
	            columns: [
	                        { title: "Nombre" },
	                        { title: "Cantidad" },
	                        { title: "Stock" },
	                        { title: "Estado" },
	                        { title: "" },

	                    ]
	    });
	$('#table_items_data').val(JSON.stringify(items_obj));

    })
}
