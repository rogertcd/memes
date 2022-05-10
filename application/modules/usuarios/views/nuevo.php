<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">Adicionar nuevo usuario al sistema</h4>
			<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
				<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
				<span class="svg-icon svg-icon-2x">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                            <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                            <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                        </g>
                    </svg>
                </span>
				<!--end::Svg Icon-->
			</div>
		</div>
		<form id="formNuevoUsuario" action="JavaScript:void(0);" method="POST" role="form">
			<div class="modal-body">
				<div class="row mb-10">
					<div class="col-md-6 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="nombre">
							<span class="required">Nombres</span>
							<!--                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a card holder's name"></i>-->
						</label>
						<input  class="form-control" type="text" name="nombre" id="nombre" autofocus />
					</div>
					<div class="col-md-6 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="apellido">
							<span class="required">Apellidos</span>
						</label>
						<input class="form-control" type="text" name="apellido" id="apellido" />
					</div>
				</div>
				<div class="row mb-10">
					<div class="col-md-6 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="id_sucursal">
							<span class="required">Sucursal</span>
						</label>
						<select class="form-select" data-control="select2" data-dropdown-parent="#primario" name="id_sucursal" id="id_sucursal">
							<option value="">-- Seleccione --</option>
						</select>
					</div>
					<div class="col-md-6 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="rol">
							<span class="required">Rol</span>
						</label>
						<select class="form-select" data-control="select2" data-dropdown-parent="#primario" name="rol" id="rol">
							<option value="">-- Seleccione --</option>
							<?php
							if ($this->session->userdata('usuario')->rol == 'ADMINISTRADOR') {
								?>
								<option value="ADMINISTRADOR">Administrador</option>
							<?php
							}
							?>
							<option value="SUPERVISOR">Supervisor</option>
							<option value="VENTAS">Ventas</option>
						</select>
					</div>
				</div>
				<div class="row mb-10">
					<div class="col-md-6 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="ci">
							C.I.
						</label>
						<input class="form-control" type="text" name="ci" id="ci" placeholder="C&eacute;dula de identidad" />
					</div>
					<div class="col-md-6 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="telefono">
							Tel&eacute;fono
						</label>
						<input class="form-control" type="text" name="telefono" id="telefono" />
					</div>
				</div>
				<div class="row mb-10">
					<div class="col-md-4 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="usuario">
							<span class="required">Usuario</span>
						</label>
						<input class="form-control" type="text" name="usuario" id="usuario" autocomplete="off" placeholder="Usuario para ingreso al sistema"/>
					</div>
					<div class="col-md-4 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="clave">
							<span class="required">Clave</span>
						</label>
						<input value="1234" class="form-control" type="password" name="clave" id="clave" autocomplete="off" />
					</div>
					<div class="col-md-4 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="clave1">
							<span class="required">Confirmar clave</span>
						</label>
						<input value="1234" class="form-control" type="password" name="clave1" id="clave1"/>
					</div>
				</div>
				<hr>
				<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
					<span class="required">Campos obligatorios</span>
				</label>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-window-close"></i> CANCELAR</button>
				<button type="submit" class="btn btn-primary" id="btnGuardarUsuario"><i class="fa fa-check"></i>
					<span class="indicator-label">GUARDAR</span>
					<span class="indicator-progress">Procesando...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
				</button>
			</div>
		</form>
	</div>
	<!-- /.modal-content -->
</div>

<script src="<?= base_url() ?>assets/plugins/custom/validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/plugins/custom/validation/additional-methods.min.js?v=1.1.1" type="text/javascript"></script>

<script type="text/javascript">

	jQuery(document).ready(function () {

		$("#rol").select2({
			placeholder: 'Seleccione una opcion',
			allowClear: true,
			language: "es",
			dropdownAutoWidth: true
		});

		$('#id_sucursal').select2({
			placeholder: 'Nombre de la sucursal',
			allowClear: true,
			minimumInputLength: 3,
			closeOnSelect: true,
			dropdownAutoWidth: true,
			quietMillis: 100,
			ajax: {
				// quietMillis: 10,
				cache: false,
				dataType: 'json',
				type: 'POST',
				url: '<?= base_url() ?>sucursales/json_select2',
				data: function (params) {
					return {
						term: params.term,
						page: params.page,
						page_limit: 10
					};
				},
				processResults: function (data, page) {
					return {results: data};
				}
			}
		});

		let form = $('#formNuevoUsuario');
		form.validate({
			ignore: ".ignore, .select2-focusser, .select2-input, input[type=hidden]",
			doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
			//errorElement: 'div', //default input error message container
			errorClass: 'text-danger', // default input error message class
			focusInvalid: true, // focus the last invalid input
			rules: {
				nombre: {
					required: true
				},
				apellido: {
					required: true
				},
				telefono: {
					digits: true
				},
				celular: {
					digits: true
				},
				ci: {
					required: false,
					cidni: true,
					minlength: 5,
					maxlength: 8,
					remote: {
						url: "<?= base_url() ?>usuarios/verificarCi",
						type: "POST",
						data: {id_usuario: "0"}
					}
				},
				sucursal: {
					required: true
				},
				usuario: {
					required: true,
					minlength: 3,
					maxlength: 50,
					remote: {
						url: "<?= base_url() ?>usuarios/verificarNombreUsuario",
						type: "POST",
						data: {id_usuario: "0"}
					}
				},
				clave: {
					required: true
				},
				clave1: {
					required: true,
					equalTo: "#clave"
				},
				matricula: {
					required: false
				}
			},
			messages: {
				usuario: {
					required: "Introduzca un nombre de Usuario!",
					remote: "Este nombre de usuario ya existe, introduzca otro por favor!"
				},
				ci: {
					remote: "Este documento de identidad ya existe, es posible que el usuario que intenta adicionar ya est&eacute registrado!"
				},
				clave: {
					required: "Introduzca una Clave para el Usuario!"
				},
				clave1: {
					required: "Introduzca la repetici&oacute;n de su clave"
				},
				sucursal: {
					required: "Seleccione la sucursal asignada"
				}
			},
			errorPlacement: function (error, element) { // render error placement for each input type
				error.insertAfter(element); // for other inputs, just perform default behavior
			},
			invalidHandler: function (event, validator) { //display error alert on form submit
				toastr.error("El formulario contiene errores, por favor corr&iacute;jalos", "ERROR");
			},
			highlight: function (element) { // hightlight error inputs
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
			},
			unhighlight: function (element) { // revert the change done by hightlight
				$(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
			},
			success: function (label) {
				label.addClass('valid') // mark the current input as valid and display OK icon
						.closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
			},
			submitHandler: function (form) {
				insertar_usuario(form);
			}
		});
		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.form-control', form).change(function () {
			form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});

	});

	function insertar_usuario(form) {
		let botonSubmit = $('#btnGuardarUsuario');
		$.ajax({
			url: base_url + "usuarios/insertar",
			type: "POST",
			data: $(form).serialize(),
			dataType: "json",
			beforeSend: function () {
				botonSubmit.attr('disabled', true);
			},
			success: function (response) {
				switch (response.status) {
					case 'success' :
						toastr.success("Los datos del usuario fueron guardados correctamente", "CORRECTO");
						if (vista === 'listarUsuarios') {
							oTableUsuarios.ajax.reload();
							$("#primario").modal('hide');//esconde el modal
						} else {
							// let usuario = $('#nombres').val().toUpperCase() + ' ' + $('#apellidos').val().toUpperCase() + ' - ' + $('#ci').val();
							let usuario = $('#nombres').val().toUpperCase() + ' ' + $('#apellidos').val().toUpperCase();
							//$('#id_usuario').select2('data', {id: response.id_usuario, text: usuario}).trigger("change");
							$('#id_usuario').empty().append($("<option/>").val(response.id_usuario).text(usuario)).trigger("change");
							$("#secundario").modal('hide');//esconde el modal
						}
						break;
					case 'error' :
						toastr.error("Error al guardar los datos del Usuario", "ERROR");
						break;
					case 'existe' :
						toastr.error("El documento introducido ya est&aacute; registrado en la Base de Datos", "ERROR");
						break;
					default :
						toastr.error("Error desconocido al ejecutar la petici&oacute;n", "ERROR");
				}
				botonSubmit.attr('disabled', false);
			},
			error: function (error) {
				toastr.error("Ocurri&oacute; un error al guardar los datos " + error, "ERROR");
				botonSubmit.attr('disabled', false);
			}
		});
	}

</script>
