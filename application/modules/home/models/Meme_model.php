<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Meme_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	function getMemeFromUrl() {
		$header = array('Content-Type: application/json');

		//Consumo del servicio Rest
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://api.chucknorris.io/jokes/random');
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($curl);
		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		return json_decode($response);
	}

	function insert($urlIcon, $id, $url, $value) {
		try {
			$this->db->trans_start();

			$this->db->set("icon_url", $urlIcon);
			$this->db->set("id_meme", $id);
			$this->db->set("url", $url);
			$this->db->set("value", $value);
			$this->db->insert('memes');
			$idNuevoMeme = $this->db->insert_id();

//			log_message('error', 'SQL: '.$this->sion->last_query());
			if ($this->db->trans_status() === FALSE) {// Si ocurrio algun problema
				$this->db->trans_rollback();
				return 0;
			} else {
				$this->db->trans_commit();
				return $idNuevoMeme;
			}
		} catch (Exception $ex) {
			log_message('error', 'Message: ' . $ex->getMessage() . '. Trace: ' . $ex->getTraceAsString());
			return 0;
		}
	}

	function delete() {
		$this->db->set('estado', 0);
		$this->db->update('memes');
		return $this->db->affected_rows();
	}


	public function getMemes() {
		$this->db->where("estado", 1);
		$query = $this->db->get("memes");
		return ($query->num_rows() > 0) ? $query->result() : FALSE;
	}

}
