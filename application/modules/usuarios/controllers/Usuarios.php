<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Rogert Castillo
 * Date: 03/01/2022
 * Time: 12:41
 */

class Usuarios extends MY_Controller
{
	public function __construct() {
		$this->add_model('Usuario', 'usuarios');
//		$this->add_model('Sucursal', 'sucursales');
		$this->add_library('datatables');
		parent::__construct();
	}
	function listar() {
		if ($this->verificarUsuario()) {
			$idMenu = $this->input->get('id');
			$puedeUsarMenu = $this->Usuario->verificarUsoMenu($this->getUsuario()->rol, $idMenu);
			if ($puedeUsarMenu > 0) {
				$link = new Linkstate();
				$link->id = $idMenu;
				$this->setLink($link);
				$this->load_view('usuarios', 'listar');
			} else {
				$this->redirect_to_action('home', 'errorForbiden');
			}
		} else {
			$this->redirect_to_action('home', 'login');
		}
	}

	function json_dataTable() {
		if ($this->verificarUsuario()) {
			$this->datatables->select("nombres, apellidos, ci, id_sucursal, sucursal, rol, telefono, usuario, id_usuario");
//			if ($this->getUsuario()->rol == 'ADMINISTRADOR' && !is_null($this->getUsuario()->id_sucursal)) {
//				$this->datatables->where('id_sucursal', $this->getUsuario()->id_sucursal);
//			}
			if ($this->getUsuario()->rol != 'ADMINISTRADOR') {
				$this->datatables->where("id_sucursal IN(SELECT suc.id_sucursal FROM SUCURSAL suc WHERE (suc.padre = " . $this->getUsuario()->id_sucursal . ' OR suc.id_sucursal = ' . $this->getUsuario()->id_sucursal . '))');
//				$this->datatables->where('id_sucursal', $this->getUsuario()->id_sucursal);
			}
			$this->datatables->order_by('id_usuario', 'desc');
			$this->datatables->from('V_USUARIOS');
			echo $this->datatables->generate();
		} else {
			echo 'denied';
		}
	}

	function nuevo() {
		if ($this->verificarUsuario()) {
//			$idMenu = $this->input->get('id');
//			$puedeUsarMenu = $this->Usuario->verificarUsoMenu($this->getUsuario()->rol, $idMenu);
//			if ($puedeUsarMenu > 0) {
//
//			} else {
//				$this->redirect_to_action('home', 'errorForbiden');
//			}
//			if ($this->getUsuario()->rol == 'ADMINISTRADOR' && !is_null($this->getUsuario()->id_sucursal)) {
//				$data['sucursales'] = $this->Sucursal->getDatosById($this->getUsuario()->id_sucursal);
//			} else {
//				$data['sucursales'] = $this->Sucursal->listar();
//			}
//			$this->load->view('usuarios/nuevo', $data);
			$this->load->view('usuarios/nuevo');
		} else {
			$this->redirect_to_action('home', 'login');
		}
	}

	/**
	 * Guarda un nuevo Usuario
	 */
	public function insertar() {
		$res = null;
		if ($this->verificarUsuario()) {
			$nombres = trim(mb_strtoupper($this->input->post('nombre'), 'utf-8'));
			$apellidos = trim(mb_strtoupper($this->input->post('apellido'), 'utf-8'));
			$ci = ($this->input->post('ci') == '') ? null : trim(mb_strtoupper($this->input->post('ci'), 'utf-8'));
			$idSucursal = trim($this->input->post('id_sucursal'));
			$telefono = ($this->input->post('telefono') == '') ? null : $this->input->post('telefono');
			$rol = ($this->input->post('rol') == '') ? null : $this->input->post('rol');
			$nombreUsuario = ($this->input->post('usuario') == '') ? null : trim(mb_strtolower($this->input->post('usuario'), 'utf-8'));
			$clave = openssl_digest(trim($this->input->post('clave')), 'sha512');
			$existe = $this->Usuario->existeCi($ci, 0);
			if ($existe == 0) {
				$res = $this->Usuario->insert($nombres, $apellidos, $ci, $idSucursal, $telefono, $rol, $nombreUsuario, $clave);
				$status = ($res > 0) ? 'success' : 'error';
			} else {
				$status = 'existe';
			}
		} else {
			$status = 'denied';
		}
		echo json_encode(array('status' => $status, 'id_usuario' => $res));
	}

	/**
	 * Modificar datos de un Usuario
	 */
	public function editar() {
		if ($this->verificarUsuario()) {
			$idUsuario = $this->session->userdata('usuario')->id;
			$data['usuario'] = $this->Usuario->getDatosById($idUsuario);
//			$data['sucursales'] = $this->Area->listar();
			$this->load->view("usuarios/editar", $data);
		} else {
			$this->redirect_to_action('home', 'login');
		}
	}

	/**
	 * Guardar las modificaciones hechas a un Usuario
	 */
	public function actualizar() {
		if ($this->verificarUsuario()) {
			$idUsuario = $this->input->post('id_usuario');
			$nombres = trim(mb_strtoupper($this->input->post('nombre'), 'utf-8'));
			$apellidos = trim(mb_strtoupper($this->input->post('apellido'), 'utf-8'));
			$ci = ($this->input->post('ci') == '') ? null : trim(mb_strtoupper($this->input->post('ci'), 'utf-8'));
//			$idArea = trim($this->input->post('area'));
			$telefono = ($this->input->post('telefono') == '') ? null : $this->input->post('telefono');
			$genero = ($this->input->post('genero') == '') ? null : $this->input->post('genero');

			$existe = $this->Usuario->existeCi($ci, $idUsuario);
			if($existe == 0){
				$res = $this->Usuario->update($idUsuario, $nombres, $apellidos, $ci, $telefono, $genero);
				if($res == 1)
					$status = 'success';
				else
					$status = 'error';
			} else {
				$status = 'existe';
			}
		} else {
			$status = 'denied';
		}
		echo json_encode(array('status' => $status));
	}

	function editar_clave() {
		if ($this->verificarUsuario()) {
			$data['usuario'] = $this->Usuario->obtenerDatosPorId($this->session->userdata('usuario')->id);
			$this->load->view("usuarios/editar_clave", $data);
		} else {
			redirect('/');
		}
	}

	function actualizar_clave() {
		if ($this->verificarUsuario()) {
			$id_usuario = $this->session->userdata('usuario')->id;
			$claveActual = $this->input->post("old_clave");
			$clave = $this->input->post("clave");

			$passwordActualCorrecto = $this->Usuario->verificarPasswordActual(openssl_digest($claveActual, 'sha512'), $id_usuario);
			if ($passwordActualCorrecto > 0) {
				$res = $this->Usuario->updatePassword(openssl_digest($clave, 'sha512'), $id_usuario);
				if ($res == 1) {
					$status = 'success';
				} else {
					$status = 'error';
				}
			} else {
				$status = 'wrong';
			}
		} else {
			$status = 'denied';
		}
		echo json_encode(array('status' => $status));
	}

	public function cambioRol() {
		if ($this->verificarUsuario()) {
			$idUsuario = $this->input->post("id_usuario");
			$data['usuario'] = $this->Usuario->getDatosById($idUsuario);
//			if ($this->getUsuario()->rol == 'ADMINISTRADOR' && !is_null($this->getUsuario()->id_sucursal)) {
//				$data['sucursales'] = $this->Sucursal->getDatosById($this->getUsuario()->id_sucursal);
//			} else {
//				$data['sucursales'] = $this->Sucursal->listar();
//			}
			$this->load->view("usuarios/cambiar_rol", $data);
		} else {
			$this->redirect_to_action('home', 'login');
		}
	}

	public function cambiarRolUsuario() {
		if ($this->verificarUsuario()) {
			$idUsuario = $this->input->post('id_usuario');
			$rol = trim($this->input->post('rol'));

			$res = $this->Usuario->changeRol($idUsuario, $rol);
			if($res == 1)
				$status = 'success';
			else
				$status = 'error';
		} else {
			$status = 'denied';
		}
		echo json_encode(array('status' => $status));
	}

	public function cambioClave() {
		if ($this->verificarUsuario()) {
			$idUsuario = $this->input->post("id_usuario");
			$data['usuario'] = $this->Usuario->getDatosById($idUsuario);
			$this->load->view("usuarios/resetear_clave", $data);
		} else {
			$this->redirect_to_action('home', 'login');
		}
	}

	public function resetearPasswordUsuario() {
		if ($this->verificarUsuario()) {
			$idUsuario = $this->input->post('id_usuario');
			$nuevaContrasena = openssl_digest(trim($this->input->post('clave')), 'sha512');

			$res = $this->Usuario->updatePassword($nuevaContrasena, $idUsuario, $this->session->userdata('usuario')->id);
			if($res == 1)
				$status = 'success';
			else
				$status = 'error';
		} else {
			$status = 'denied';
		}
		echo json_encode(array('status' => $status));
	}

	function verificarNombreUsuario() {
		if ($this->verificarUsuario()) {
			$nombre = $this->input->post("usuario");
			$id_usuario = $this->input->post('id_usuario');
			$existe = $this->Usuario->existeUsuario($nombre, $id_usuario);
			if ($existe > 0) {
				echo "false";
			} else {
				echo "true";
			}
		}
	}

	function eliminar() {
		if ($this->verificarUsuario()) {
			$res = $this->Usuario->delete($this->input->post("id_usuario"));
			if ($res == 1) {
				$status = 'success';
			} else {
				$status = 'error';
			}
		} else {
			$status = 'ajax';
		}
		echo json_encode(array('status' => $status));
	}

	function verificarCi() {
		if ($this->verificarUsuario()) {
			$ci = $this->input->post("ci");
			$idUsuario = $this->input->post('id_usuario');
			$existe = $this->Usuario->existeCi($ci, $idUsuario);
			if ($existe > 0) {
				echo "false";
			} else {
				echo "true";
			}
		}
	}

}
