<div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">Cambiar contrase&ntilde;a</h4>
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
		<form id="formEditarClave" action="JavaScript:void(0);" role="form">
			<div class="modal-body">
				<div class="row mb-10">
					<div class="col-md-12 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="old_clave">
							<span class="required">Contrase&ntilde;a actual</span>
							<!--                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a card holder's name"></i>-->
						</label>
						<input class="form-control" name="old_clave" id="old_clave" type="password" autocomplete="off" autofocus/>
					</div>
				</div>
				<div class="row mb-10">
					<div class="col-md-12 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="clave">
							<span class="required">Nueva contrase&ntilde;a</span>
							<!--                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a card holder's name"></i>-->
						</label>
						<input class="form-control" name="clave" id="clave" type="password" autocomplete="off" />
					</div>
				</div>
				<div class="row mb-10">
					<div class="col-md-12 fv-row">
						<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2" for="clave1">
							<span class="required">Confirmar contrase&ntilde;a</span>
							<!--                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a card holder's name"></i>-->
						</label>
						<input  class="form-control" name="clave1" id="clave1" type="password" autocomplete="off"/>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-window-close"></i> Cancelar</button>
				<button type="submit" class="btn btn-primary btn-sm" id="btnCambiarClave">
					<i class="fa fa-check"></i>
					<span class="indicator-label">Actualizar</span>
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
<script src="<?= base_url() ?>assets/plugins/custom/validation/additional-methods.min.js" type="text/javascript"></script>

<script type="text/javascript">

	jQuery(document).ready(function () {
		var form = $('#formEditarClave');

		form.validate({
			ignore: ".ignore, .select2-focusser, .select2-input, input[type=hidden]",
			doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
			//errorElement: 'div', //default input error message container
			errorClass: 'text-danger', // default input error message class
			focusInvalid: true, // focus the last invalid input
			rules: {
				old_clave: {
					required: true
				},
				clave: {
					required: true
				},
				clave1: {
					required: true,
					equalTo: "#clave"
				}
			},
			messages: {
				old_clave: {
					required: "Introduzca su contrase&ntilde;a actual!"
				},
				clave: {
					required: "Debe introducir una nueva contrase&ntilde;a!"
				},
				clave1: {
					required: "Repita la nueva contrase&ntilde;a por favor"
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
				actualizar_clave(form);
			}
		});

	});

	function actualizar_clave(form) {
		let botonSubmit = $('#btnCambiarClave');
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>usuarios/actualizar_clave",
			data: $(form).serialize(),
			dataType: "json",
			beforeSend: function () {
				botonSubmit.attr('disabled', true);
			},
			success: function (response) {
				switch (response.status) {
					case 'success' :
						toastr.success("Su contrase&ntilde;a fue actualizada correctamente", "CORRECTO");
						$("#primario").modal('hide');//esconde el modal
						break;
					case 'error' :
						toastr.error("Error al guardar los datos", "ERROR");
						break;
					case 'wrong' :
						toastr.error("La contrase&ntilde;a actual es incorrecta", "ERROR");
						break;
					case 'denied':
						toastr.error("Usted no tiene permiso para usar el recurso, cont&aacute;ctese con el administrador", "ERROR");
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
