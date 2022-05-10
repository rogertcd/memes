<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Rogert Castillo
 * Date: 06/04/2021
 * Time: 16:45
 */

class Template extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function mostrar($data = null)
    {
        $this->load->view('Template/layout', $data);
    }


}
