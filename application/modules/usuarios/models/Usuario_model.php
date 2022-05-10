<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function exists($usuario, $clave) {
		$query = $this->db->get_where('USUARIO', array('usuario' => $usuario, 'clave' => mb_strtoupper($clave, 'utf8')));
//		log_message('error', 'SQL: ' . $this->db->last_query());

		return ($query->num_rows() > 0)? $query->row_array() : FALSE;
	}

	function getDatosById($idUsuario) {
		$this->db->where('id_usuario', $idUsuario);
		$q = $this->db->get('V_USUARIOS');
		return ($q->num_rows() > 0)? $q->row() : FALSE;
	}

	function obtenerDatosPorId($id) {
		$this->db->select("id_usuario, nombres, apellidos, ci, telefono, usuario, estado, rol, id_sucursal, sucursal");
		$this->db->where("id_usuario", $id);
		$q = $this->db->get('V_USUARIOS');
		return ($q->num_rows() > 0)? $q->row_array() : FALSE;
	}

	function insert($nombres, $apellidos, $ci, $idSucursal, $telefono, $rol, $nombreUsuario, $clave) {
		try {
			$this->db->trans_start();

			$this->db->set("nombres", $nombres);
			$this->db->set("apellidos", $apellidos);
			$this->db->set("ci", $ci);
			$this->db->set("telefono", $telefono);
			if (!empty($idSucursal)) {
				$this->db->set("id_sucursal", $idSucursal);
			}
			$this->db->set("rol", $rol);
			$this->db->set("usuario", $nombreUsuario);
			$this->db->set("clave", mb_strtoupper($clave, 'utf8'));
			$this->db->insert('USUARIO');
			$idNuevoUsuario = $this->db->insert_id();

//			log_message('error', 'SQL: '.$this->sion->last_query());
			if ($this->db->trans_status() === FALSE) {// Si ocurrio algun problema
				$this->db->trans_rollback();
				return 0;
			} else {
				$this->db->trans_commit();
				return $idNuevoUsuario;
			}
		} catch (Exception $ex) {
			log_message('error', 'Message: ' . $ex->getMessage() . '. Trace: ' . $ex->getTraceAsString());
			return 0;
		}
	}

	function update($idUsuario, $nombres, $apellidos, $ci, $telefono, $genero) {
		$this->db->set("nombres", mb_strtoupper($nombres, 'utf8'));
		$this->db->set("apellidos", mb_strtoupper($apellidos, 'utf8'));
		$this->db->set("ci", $ci);
		$this->db->set("telefono", $telefono);
		$this->db->set("genero", $genero);
		$this->db->where('id_usuario', $idUsuario);
		$this->db->update('USUARIO');
		return $this->db->affected_rows();
	}

	function changeRol($idUsuario, $rol) {
		try {
			$this->db->set("rol", $rol);
			$this->db->where("id_usuario", $idUsuario);
			$this->db->update('USUARIO');
			return $this->db->affected_rows();
//			log_message('error', 'SQL: '.$this->sion->last_query());
		} catch (Exception $ex) {
			log_message('error', 'Message: ' . $ex->getMessage() . '. Trace: ' . $ex->getTraceAsString());
			return 0;
		}
	}

	function delete($idUsuario) {
		$this->db->set('estado', 'X');
		$this->db->where('id_usuario', $idUsuario);
		$this->db->update('USUARIO');
		return $this->db->affected_rows();
	}

	function updatePassword($clave, $id_usuario, $idUsuarioCambio = null) {
		$this->db->set('clave', mb_strtoupper($clave, 'utf8'));
		if (!is_null($idUsuarioCambio)) {
			$this->db->set('cambio_clave_por', $idUsuarioCambio);
		}
		$this->db->where('id_usuario', $id_usuario);
//		$this->db->set("update_at", "now()", false);
		$this->db->update('USUARIO');
		return $this->db->affected_rows();
	}

	function verificarPasswordActual($password, $idUsuario) {
		$this->db->where("id_usuario", $idUsuario);
		$this->db->where("clave", mb_strtoupper($password, 'utf8'));
		$this->db->from('USUARIO');
//		$this->db->get("usuario");
		return $this->db->count_all_results();
//		log_message('error', 'SQL: ' . $this->db->last_query());
//		return $cant;
	}

	function existeCi($ci, $idUsuario) {
		$this->db->where('UPPER(ci)', mb_strtoupper($ci, 'utf8'));
		$this->db->where('estado', 'AC');
		if ($idUsuario != 0) {
			$this->db->where('id_usuario != ', $idUsuario);
		}
		$this->db->from('USUARIO');
		return $this->db->count_all_results();
	}

	function existeUsuario($usuario, $idUsuario) {
		$this->db->where('UPPER(usuario)', mb_strtoupper($usuario, 'utf8'));
		$this->db->where('estado', 'AC');
		if ($idUsuario != 0) {
			$this->db->where('id_usuario != ', $idUsuario);
		}
		$this->db->from('USUARIO');
		return $this->db->count_all_results();
	}

	function verificarUsoMenu($rol, $idMenu) {
		$this->db->where('rol', $rol);
		$this->db->where('id_menu', $idMenu);
//		$this->db->where('estado', 'AC');
		$this->db->from('MENU');
		return $this->db->count_all_results();
//		log_message('error', 'SQL: ' . $this->db->last_query());
//		return $fgd;
	}

	public function cargarMenu($rol) {
		$this->db->where("rol", $rol);
		$this->db->order_by('orden', 'asc');
		return $this->db->get("MENU");
	}

	public function getActiveMenu($rol) {
		$this->db->select('id_menu');
		$this->db->where("rol", $rol);
		$this->db->where("clase", 'menu-link activate');
		$query = $this->db->get("MENU");
		return ($query->num_rows() > 0) ? $query->row()->id_menu : 0;
	}

}
