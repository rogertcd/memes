<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Rogert Castillo
 * Date: 04/01/2022
 * Time: 10:48
 */

class Home extends MY_Controller {

	function __construct() {
		$this->add_model('Meme', 'home');
		parent::__construct();
	}
	public function index()
	{
		$memesID = array();
		//
		$this->Meme->delete();
		for ($i = 1; $i <= 15; $i++) {
			while (true) {
				$newMeme = $this->Meme->getMemeFromUrl();
				if (array_search(strtoupper($newMeme->{'id'}), $memesID) === false) {
					$this->Meme->insert($newMeme->{'icon_url'}, $newMeme->{'id'}, $newMeme->{'url'}, $newMeme->{'value'});
//					$memesID[] = strtoupper($newMeme->{'id'});
					array_push($memesID, strtoupper($newMeme->{'id'}));
//					array_push($memes, $newMeme);
					break;
				}
			}
		}

		$data['memes'] = $this->Meme->getMemes();
		$this->load->view('home/index', $data);
	}

}
