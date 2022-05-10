"use strict";
var KTSigninGeneral = function() {
    var e, t, i;
    return {
        init: function() {
            e = document.querySelector("#kt_sign_in_form"),
                t = document.querySelector("#kt_sign_in_submit"),
                i = FormValidation.formValidation(e, {
                    fields: {
                        email: {
                            validators: {
                                notEmpty: {
                                    message: "El campo usuario es requerido"
                                },
                                // emailAddress: {
                                //     message: "The value is not a valid email address"
                                // }
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: "El campo contrase&ntilde;a es requerido"
                                },
                                callback: {
                                    message: "Por favor introduzca una contrase&ntilde;a v&aacute;lida",
                                    callback: function(e) {
                                        if (e.value.length > 0) return _validatePassword()
                                    }
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: ""
                        })
                    }
                });
            t.addEventListener("click", (function(n) {
                n.preventDefault();
                let mensajeError = null,
                    botonSubmit = $('#kt_sign_in_submit');
                i.validate().then((
                    function(i) {
                        if ("Valid" === i) {
                            t.setAttribute("data-kt-indicator", "on");
                            t.disabled = !0;
                            setTimeout((function() {
                                t.removeAttribute("data-kt-indicator");
                                t.disabled = !1;

                                $.ajax({
                                    url: base_url + "home/validarDatosUsuario",
                                    type:"POST",
                                    data: $('#kt_sign_in_form').serialize(),
                                    dataType: "json",
                                    beforeSend: function(){
                                        botonSubmit.attr('disabled',true);
                                    },
                                    success: function(response){
                                        switch(response.status){
                                            case 'correcto' :
                                                let url = base_url + "home/index";
                                                location.href = url;
                                                toastr.success("Acceso correcto!!!", "CORRECTO");
                                                break;
                                            case 'error' :
                                                mensajeError = "Error, el usuario/contrase&ntilde;a no coinciden";
                                                // toastr.error("Error el usuario/contrase&ntilde;a no coinciden", "ERROR");
                                                botonSubmit.attr('disabled',false);
                                                break;
                                            case 'inactivo' :
                                                mensajeError = "El usuario est&aacute; inactivo, cont&aacute;ctese con el administrador";
                                                // toastr.error("El usuario est&aacute; inactivo, cont&aacute;ctese con el administrador", "ERROR");
                                                botonSubmit.attr('disabled',false);
                                                break;
                                            default :
                                                mensajeError = "Error desconocido al ejecutar la petici&oacute;n";
                                                // toastr.error("Error desconocido al ejecutar la petici&oacute;n", "ERROR");
                                                botonSubmit.attr('disabled',false);
                                        }
                                        if (mensajeError !== null) {
                                            swal.fire({
                                                html: mensajeError,
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "Aceptar",
                                                customClass: {
                                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                                }
                                            }).then(function() {
                                                KTUtil.scrollTop();
                                            });
                                        }
                                    },
                                    error:function(error){
                                        toastr.error("Ocurri&oacute; un error al realizar la petici&oacute;n "+error, "ERROR");
                                        botonSubmit.attr('disabled',false);
                                    }
                                });
                                // Swal.fire({
                                //     text: "Ingreso satisfactorio!",
                                //     icon: "success",
                                //     buttonsStyling: !1,
                                //     confirmButtonText: "Ok, got it!",
                                //     customClass: {
                                //         confirmButton: "btn btn-primary"
                                //     }
                                // }).then((function(t) {
                                //     t.isConfirmed && (e.querySelector('[name="email"]').value = "", e.querySelector('[name="password"]').value = "")
                                // }))
                            }), 2e3)
                        } else {
                            Swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                        // "Valid" == i ?  :
                    }))
            }))
        }
    }
}();
KTUtil.onDOMContentLoaded((function() {
    KTSigninGeneral.init()
}));