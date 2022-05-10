<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">Editar mis datos personales</h4>
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
		<form id="formEditarUsuario" action="JavaScript:void(0);" method="POST" role="form">
			<div class="modal-body">
				<div class="row mb-10">
					<div class="col-md-6 fv-row">
						<!--						<div class="form-group">-->
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="nombre">
							<span class="required">Nombres</span>
							<!--                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a card holder's name"></i>-->
						</label>
						<input  class="form-control" type="text" name="nombre" id="nombre" autofocus value="<?=$usuario->nombres?>" />
						<input type="hidden" name="id_usuario" id="id_usuario" value="<?=$usuario->id_usuario?>" />
						<!--						</div>-->
					</div>
					<div class="col-md-6 fv-row">
						<!--						<div class="form-group">-->
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="apellido">
							<span class="required">Apellidos</span>
						</label>
						<input class="form-control" type="text" name="apellido" id="apellido" value="<?=$usuario->apellidos?>" />
					</div>
				</div>
				<div class="row mb-10">
					<div class="col-md-4 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="ci">C.I.</label>
						<input class="form-control" type="text" name="ci" id="ci" value="<?=$usuario->ci?>" />
					</div>
					<div class="col-md-4 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="telefono">Tel&eacute;fono</label>
						<input class="form-control" type="text" name="telefono" id="telefono" value="<?=$usuario->telefono?>" />
					</div>
					<div class="col-md-4 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="celular">G&eacute;nero</label>
						<select class="form-select" data-control="select2" data-dropdown-parent="#primario" name="genero" id="genero">
							<option value="F" <?php if ($usuario->genero == 'F') echo 'selected' ?>>Femenino</option>
							<option value="M" <?php if ($usuario->genero == 'M') echo 'selected' ?>>Masculino</option>
						</select>
					</div>
				</div>
				<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
					<span class="required">Campos obligatorios</span>
				</label>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-window-close"></i> CERRAR</button>
				<button type="submit" class="btn btn-primary" id="btnActualizarUsuario"><i class="fa fa-check"></i>
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

		var form = $('#formEditarUsuario');
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
				genero: {
					required: true
				},
				ci: {
					required: false,
					cidni: true,
					minlength: 5,
					maxlength: 8,
					remote: {
						url: "<?= base_url() ?>usuarios/verificarCi",
						type: "POST",
						data: {id_usuario: "<?=$usuario->id_usuario?>"}
					}
				}
			},
			messages: {
				ci: {
					remote: "Este documento de identidad ya existe, es posible que el usuario que intenta adicionar ya est&eacute registrado!"
				},
				area: {
					required: "Seleccione el Area asignada"
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
				actualizar_usuario(form);
			}
		});
		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.form-control', form).change(function () {
			form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});

	});

	function actualizar_usuario(form) {
		let botonSubmit = $('#btnActualizarUsuario');
		$.ajax({
			url: base_url + "usuarios/actualizar",
			type: "POST",
			data: $(form).serialize(),
			dataType: "json",
			beforeSend: function () {
				botonSubmit.attr('disabled', true);
			},
			success: function (response) {
				switch (response.status) {
					case 'success' :
						toastr.success("Sus datos fueron actualizados correctamente", "CORRECTO");
						$("#primario").modal('hide');//esconde el modal
						break;
					case 'error' :
						toastr.error("Error al guardar los datos", "ERROR");
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
