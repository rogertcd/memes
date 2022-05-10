<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Rogert Castillo
 * Date: 06/04/2021
 * Time: 16:51
 */


require_once(CLASSES_DIR . "Usuarioweb.php");
require_once(CLASSES_DIR . "Linkstate.php");

class MY_Controller extends MX_Controller
{
	private $models = array();
	private $libraries = array();

	private $helpers = array('language');
	private $lang_files = array('messages', 'error_messages');
	private $modules = array('Template');
	protected $model_string = '%_model';

	public function __construct()
	{
		parent::__construct();
		setlocale(LC_ALL, "es_ES.UTF-8");
		date_default_timezone_set('America/La_Paz');
		$this->_load_models();
		$this->_load_helpers();
		$this->_load_language();
		$this->_load_modules();
		$this->_load_libraries();
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

	private function _load_helpers()
	{
		foreach ($this->helpers as $helper) {
			$this->load->helper($helper);
		}
	}

	private function _load_language()
	{
		$site_lang = $this->session->userdata('site_lang');
		$site_lang = !is_null($site_lang) && $site_lang != "" ? $site_lang : "spanish";

		$this->_load_language_files($site_lang);
	}

	private function _load_language_files($language)
	{
		foreach ($this->lang_files as $files) {
			$this->lang->load($files, $language);
		}
	}

	private function _load_modules()
	{
		foreach ($this->modules as $module) {
			$this->load->module($module);
		}
	}

	private function _load_libraries()
	{
		foreach ($this->libraries as $library) {
			$this->load->library($library);
		}
	}
	//</editor-fold>

	//<editor-fold desc="Metodos Protegidos">
	protected function redirect_to_action($controller, $action = null, $data = null)
	{
		$uri = $this->is_empty_or_white_spaces($action) ? $controller : $controller . '/' . $action;
		$this->session->set_flashdata('data', $data);

		redirect($uri);
	}

	protected function load_view($controller, $action, $data = null, $return = null)
	{
		$vista = $controller . '/' . $action;
		if ($return) {
			return $this->load->view($vista, $data, true);
		} else {
			// Colocando el template principal
			$aux = array();
			$aux['content_view'] = $vista;
//			$key = $this->config("encryption_key");
//			$data['key'] = $key;
			$aux['data'] = $data;
			$this->template->mostrar($aux);
		}
	}

	protected function JsonResult($data)
	{
		$json = json_encode($data);
		if ($json) {
			echo $json;
		} else {
			echo json_last_error_msg();
		}
	}

	protected function _model_name($model)
	{
		return str_replace('%', $model, $this->model_string);
	}

	protected function switch_language($language = "")
	{
		$language = $this->is_empty_or_white_spaces($language) ? "spanish" : $language;
		$this->session->set_userdata('site_lang', $language);
	}

	protected function verificarUsuario()
	{
		$usuario = $this->getUsuario();
//		log_message('error', print_r($usuario, true));
		return isset($usuario);
	}

	protected function getUsuario()
	{
		try {
			$usuario = $this->session->userdata('usuario');
			if (isset($usuario)) {
				return $this->session->userdata('usuario');
			} else {
				return null;
			}
		} catch (Exception $ex) {
			log_message('error', $ex->getMessage());
			return null;
		}
	}

	protected function setUsuario($usuario)
	{
		$this->session->set_userdata('usuario', $usuario);
	}

	protected function add_model($model, $module = null)
	{
		if (is_null($this->models)) {
			$this->models = array();
		}
		$complete_name = $this->is_empty_or_white_spaces($module) ? $model : $module . "/" . $model;
		array_push($this->models, $complete_name);
	}

	protected function add_library($library)
	{
		if (is_null($this->libraries)) {
			$this->libraries = array();
		}
		array_push($this->libraries, $library);
	}

	protected function add_helper($helper)
	{
		if (is_null($this->helpers)) {
			$this->helpers = array();
		}
		array_push($this->helpers, $helper);
	}

	protected function is_empty_or_white_spaces($value)
	{
		return is_null($value) || ctype_space($value) || $value = "";
	}

	function get_client_ip()
	{
		if (isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if (isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if (isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	function get_server_ip()
	{
		return (isset($_SERVER['SERVER_ADDR'])) ? $_SERVER['SERVER_ADDR']:$_SERVER['HTTP_HOST'];
	}

	public function config($llave)
	{
		return $this->config->item($llave);
	}

	protected function setLink($link)
	{
		$this->session->set_userdata('link', $link);
	}

}
