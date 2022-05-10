<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Rogert Castillo
 * Date: 06/04/2021
 * Time: 16:56
 */

class MY_Model extends CI_Model
{
	private $libraries = array();
	private $models = array();

	protected $model_string = '%_model';

	private function _load_libraries()
	{
		foreach ($this->libraries as $library) {
			$this->load->library($library);
		}
	}

	protected function add_library($library)
	{
		if (is_null($this->libraries)) {
			$this->libraries = array();
		}
		array_push($this->libraries, $library);
	}

	function __construct()
	{
		setlocale(LC_ALL, "es_ES.UTF-8");
		date_default_timezone_set('America/La_Paz');
		// the TRUE paramater tells CI that you'd like to return the database object.
		$this->_load_libraries();
		$this->_load_models();

		parent::__construct();
	}

	public function utf8ize($d)
	{
		if (mb_detect_encoding($d, 'UTF-8', true) === false) {
			if (is_array($d)) {
				foreach ($d as $k => $v) {
					$d[$k] = $this->utf8ize($v);
				}
			} else if (is_string($d)) {
				return utf8_encode($d);
			}
		}
		return $d;
	}

	public function obtenerFechaHoraServidor() {
		$xconsulta = "SELECT NOW() AS FECHA_SERVER";
		$query = $this->db->query($xconsulta)->row();
		return $query->FECHA_SERVER;
	}

	public function obtenerFechaServidor() {
		$xconsulta = "SELECT CURDATE() AS FECHA_SERVER";
		$query = $this->db->query($xconsulta)->row();
		return $query->FECHA_SERVER;
	}

	public function obtenerUltimoDiaMes($mes) {
		$mesFormatoDosDigitos = ($mes < 10) ? '0' . $mes : $mes;
		$primerDia = $this->obtenerAnioActual() . '-' . $mesFormatoDosDigitos . '-01';
		$consulta = "SELECT LAST_DAY('$primerDia') AS ultimo_dia";
		$query = $this->db->query($consulta)->row();
		return $query->ultimo_dia;
	}

	public function obtenerAnioActual() {
		$consulta = "SELECT YEAR(CURDATE()) AS anio_actual";
		$query = $this->db->query($consulta)->row();
		return $query->anio_actual;
	}

	public function obtenerMesActual() {
		$consulta = "SELECT MONTH(CURDATE()) AS mes_actual";
		$query = $this->db->query($consulta)->row();
		return $query->mes_actual;
	}

	public function escape_seguro(&$data) {
		if (count($data) <= 0)
			return $this->db->escape($data);

		foreach ($data as $node)
			$node = $this->db->escape($node);

		return $data;
	}

	protected function is_empty_or_white_spaces($value)
	{
		return is_null($value) || ctype_space($value) || $value = "";
	}

	private function _load_models()
	{
		foreach ($this->models as $model) {
			$pos = strpos($model, '/');
			if ($pos === false) {
				$this->load->model($this->_model_name($model), $model);
			} else {
				$model_name = substr($model, $pos + 1);
				$module_name = substr($model, 0, $pos + 1);
				$complete_name = $module_name . $this->_model_name($model_name);

				$this->load->model($complete_name, $model_name);
			}
		}
	}

	protected function _model_name($model)
	{
		return str_replace('%', $model, $this->model_string);
	}

	protected function add_model($model, $module = null)
	{
		if (is_null($this->models)) {
			$this->models = array();
		}
		$complete_name = $this->is_empty_or_white_spaces($module) ? $model : $module . "/" . $model;
		array_push($this->models, $complete_name);
	}

}
