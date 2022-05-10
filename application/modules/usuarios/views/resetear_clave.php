<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">Cambio de contrase&ntilde;a usuario</h4>
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
		<form id="formEditarUsuario" action="JavaScript:void(0);" method="POST" class="form">
			<div class="modal-body">
				<div class="row mb-10">
					<div class="col-md-6 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="nombre">
							Nombres
						</label>
						<input  class="form-control form-control-solid" type="text" name="nombre" id="nombre" autofocus value="<?=$usuario->nombres?>" disabled />
						<input type="hidden" name="id_usuario" id="id_usuario" value="<?=$usuario->id_usuario?>" />
					</div>
					<div class="col-md-6 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="apellido">
							Apellidos
						</label>
						<input class="form-control form-control-solid" type="text" name="apellido" id="apellido" value="<?=$usuario->apellidos?>" disabled />
					</div>
				</div>

				<div class="row">
					<div class="row mb-10">
						<div class="col-md-12 fv-row">
							<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="clave">
								<span class="required">Nueva contrase&ntilde;a</span>
							</label>
							<input class="form-control" name="clave" id="clave" type="password" autocomplete="off" />
						</div>
					</div>
					<div class="row mb-10">
						<div class="col-md-12 fv-row">
							<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="clave1">
								<span class="required">Confirmar contrase&ntilde;a</span>
							</label>
							<input  class="form-control" name="clave1" id="clave1" type="password" autocomplete="off"/>
						</div>
					</div>
				</div>
				<hr>
				<p><span class="text-danger">*</span> Campos obligatorios</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-window-close"></i> Cancelar</button>
				<button type="submit" class="btn btn-primary btn-sm" id="btnCambiarClave">
					<i class="fa fa-check"></i>
					<span class="indicator-label">CAMBIAR</span>
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
				clave: {
					required: true
				},
				clave1: {
					required: true,
					equalTo: "#clave"
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
				rest_password_usuario(form);
			}
		});
		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.form-control', form).change(function () {
			form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});

	});

	function rest_password_usuario(form) {
		let botonSubmit = $('#btnCambiarClave');
		$.ajax({
			url: base_url + "usuarios/resetearPasswordUsuario",
			type: "POST",
			data: $(form).serialize(),
			dataType: "json",
			beforeSend: function () {
				botonSubmit.attr('disabled', true);
			},
			success: function (response) {
				switch (response.status) {
					case 'success' :
						toastr.success("La contrase&ntilde;a del usuario fue cambiada correctamente", "CORRECTO");
						$("#secundario").modal('hide');//esconde el modal
						break;
					case 'error' :
						toastr.error("Error al guardar los datos", "ERROR");
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
