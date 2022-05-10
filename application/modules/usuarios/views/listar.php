<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
	<!--begin::Container-->
	<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
		<!--begin::Page title-->
		<div data-kt-place="true" data-kt-place-mode="prepend" data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center me-3">
			<!--begin::Title-->
			<h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Usuarios</h1>
			<!--end::Title-->
			<!--begin::Separator-->
			<span class="h-20px border-gray-200 border-start mx-4"></span>
			<!--end::Separator-->
			<!--begin::Breadcrumb-->
			<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
				<!--begin::Item-->
				<li class="breadcrumb-item text-muted">
					<a href="<?= base_url() ?>" class="text-muted text-hover-primary">Inicio</a>
				</li>
				<!--end::Item-->
				<!--begin::Item-->
				<li class="breadcrumb-item">
					<span class="bullet bg-gray-200 w-5px h-2px"></span>
				</li>
				<!--end::Item-->
				<!--begin::Item-->
				<li class="breadcrumb-item text-muted">Administraci&oacute;n</li>
				<!--end::Item-->
				<!--begin::Item-->
				<li class="breadcrumb-item">
					<span class="bullet bg-gray-200 w-5px h-2px"></span>
				</li>
				<!--end::Item-->
				<!--begin::Item-->
				<li class="breadcrumb-item text-muted">Usuarios</li>
				<!--end::Item-->
			</ul>
			<!--end::Breadcrumb-->
		</div>
		<!--end::Page title-->
		<!--begin::Actions-->
		<div class="d-flex align-items-center py-1">
			<!--begin::Wrapper-->
			<!--end::Wrapper-->
			<!--begin::Button-->
			<a href="javaScript: openModal('<?= base_url() ?>usuarios/nuevo','#primario',null,true);" class="btn btn-sm btn-primary"  id="kt_toolbar_crear_nuevo"><i class="la la-user-plus"></i> Nuevo</a>
			<!--end::Button-->
		</div>
		<!--end::Actions-->
	</div>
	<!--end::Container-->
</div>
<!--end::Toolbar-->
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
	<!--begin::Container-->
	<div id="kt_content_container" class="container">
		<!--begin::Card-->
		<div class="card">
			<!--begin::Card Body-->
			<div class="card-body fs-6 p-10 p-lg-15">
				<!--begin::Section-->
				<div class="py-10">
					<!--begin::Heading-->
					<h1 class="anchor fw-bolder mb-5" id="dom-positioning">
						<a href="#dom-positioning"></a>Gestionar usuarios</h1>
					<!--end::Heading-->
					<!--begin::Block-->
					<!--                    <div class="py-5">When customising DataTables for your own usage, you might find that the default position of the feature elements (filter input etc) is not quite to your liking. For more info please check-->
					<!--                        <a href="https://datatables.net/examples/basic_init/dom.html" target="_blank" class="fw-bolder me-1">DOM positioning</a>documentation.</div>-->
					<!--end::Block-->
					<!--begin::Block-->
					<div class="my-5">
						<table id="kt_datatable" class="table table-striped gy-5 gs-7 border rounded">
							<thead>
							<tr class="fw-bolder fs-6 text-gray-800 px-7">
								<th>NOMBRES</th>
								<th>APELLIDOS</th>
								<th>C.I.</th>
								<th>SUCURSAL</th>
								<th>ROL</th>
								<th>USUARIO</th>
								<th>TEL&Eacute;FONO</th>
								<th>OPCIONES</th>
							</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
					<!--end::Block-->

				</div>
				<!--end::Section-->
			</div>
			<!--end::Card Body-->
		</div>
		<!--end::Card-->
	</div>
	<!--end::Container-->
</div>
<!--end::Post-->

<script type="text/javascript">
	var vista = 'listarUsuarios',
			oTableUsuarios;

	jQuery(document).ready(function () {

		var tabla = $('#kt_datatable');
		oTableUsuarios = tabla.DataTable({
			"dom":
				"<'row'" +
				"<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
				"<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
				">" +
				"<'table-responsive'tr>" +
				"<'row'" +
				"<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
				"<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
				">",
			// 'scrollX': true,
			'scrollY': false,
			'processing': true,
			'serverSide': true,
			"order": [],
			"responsive": true,
			'columnDefs': [
				{ responsivePriority: 1, targets: 0 },
				{ responsivePriority: 2, targets: 1 },
				{ responsivePriority: 3, targets: 2 },
				{ responsivePriority: 4, targets: 7 },
				{ responsivePriority: 5, targets: 4 },
				{ responsivePriority: 6, targets: 5 },
				{ responsivePriority: 7, targets: 3 },
				{ responsivePriority: 8, targets: 6 }
			],
			"ajax":{
				"dataType": 'json',
				"url": base_url + 'usuarios/json_dataTable',
				"type": "POST",
				//"data": data,
				'complete': function () {
					// App.initAjax();
				}
			},
			'columns': [
				{"data": "nombres"},
				{"data": "apellidos"},
				{"data": "ci", "orderable": false},
				{"data": "sucursal", "orderable": true},
				{"data": "rol", "orderable": false},
				{"data": "usuario", "orderable": true},
				// {"data": "estado", "orderable": false},
				{"data": "telefono", "orderable": false, "searchable": false},
				{"data": "id_usuario", "orderable": false, "searchable": false,
					'render': function (data, type, row, meta) {
						let modalResetPassword = "openModal('" + base_url + "usuarios/cambioClave', '#secundario', {'id_usuario':" + data + "}, true)",
								modalEdicion = "openModal('" + base_url + "usuarios/cambioRol', '#secundario', {'id_usuario':" + data + "}, true)",
								renderizado = '<a href="javascript:'+ modalResetPassword + '" class="btn btn-sm btn-clean btn-icon" title="Cambiar password"><i class="la la-key text-warning fs-3"></i></a>' +
										'<a href="javascript:eliminarUsuario('+data+')" class="btn btn-sm btn-clean btn-icon" title="Eliminar"><i class="la la-trash text-danger fs-3"></i></a>' +
										'<a href="javascript:'+ modalEdicion + '" class="btn btn-sm btn-clean btn-icon" title="Cambiar de rol"><i class="la la-exchange-alt text-info fs-3"></i></a>';
						// return '<input type="checkbox" class="checkboxes" name="checkId" id="check_' + data + '"  value="' + data + '"/>';
						return (parseInt(data) !== parseInt('<?=$this->session->userdata('usuario')->id?>')) ? renderizado : null;
						// return renderizado;
					}
				},
			],
			'rowCallback': function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				// console.log('nRow', nRow, 'aData', aData.idusuario, 'iDisplayIndex', iDisplayIndex, 'iDisplayIndexFull', iDisplayIndexFull);
				$(nRow).attr('id', 'tr' + aData.id_usuario);//asigna un id a cada fila
			},
			"drawCallback": function( settings ) {
				$('#kt_datatable tbody tr').each(function() {
					$(this).find('td:eq(7)').attr('nowrap', 'nowrap');
				});
			}
			// "fnInitComplete": function() {
			// 	$('#kt_datatable tbody tr').each(function(){
			// 		$(this).find('td:eq(7)').attr('nowrap', 'nowrap');
			// 	});
			// }
			// "rowCallback": function( nRow, aData, iDisplayIndex ) {
			// 	console.log('nRow', nRow, 'aData', aData, 'iDisplayIndex', iDisplayIndex);
			// 	$('td', nRow).attr('nowrap','nowrap');
			// 	return nRow;
			// }
		});

	});

	function eliminarUsuario(idusuario) {
		Swal.fire({
			title: "Est&aacute; seguro?",
			html: "Est&aacute; seguro de eliminar el usuario seleccionado?",
			icon: "error",
			showCancelButton: true,
			confirmButtonText: "Si, eliminar!",
			cancelButtonText: 'Cancelar',
			customClass: {
				cancelButton: 'btn btn-danger',
				confirmButton: 'btn btn-primary'
			}
		}).then(function(result) {
			if (result.value) {
				$.ajax({
					url: base_url + 'usuarios/eliminar',
					type: 'POST',
					data: {
						id_usuario: idusuario
					},
					dataType: 'json',
					success: function (response) {
						switch (response.status) {
							case 'success':
								toastr.success("El Usuario fue eliminado correctamente", "CORRECTO");
								$('#tr' + idusuario).slideUp();
								break;
							case 'error':
								toastr.error("Ocurri&oacute; un error al eliminar el usuario", "ERROR");
								break;
							case 'denied':
								toastr.error("Usted no tiene permiso para usar el recurso, cont&aacute;ctese con el administrador", "ERROR");
								break;
						}
					},
					error: function (error) {
						toastr.error("Error al ejecutar la petici&oacute;n" + error, "ERROR");
					}
				});
			}
		});

	}

</script>
