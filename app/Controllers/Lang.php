<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Lang extends MY_Controller {
	
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
        $this->Model_portfolio = new \App\Models\Model_portfolio();
        $this->Model_lang = new \App\Models\Model_lang();

    }

    public function index()
    {
    	redirect(base_url());
    	exit;
    }

    public function change()
    {
    	$lang_change_id = $this->request->getPost('lang_change_id',true);
    	if($lang_change_id)
    	{
            $lang = $this->Model_lang->get_direction_by_lang_id($lang_change_id);
    		$_SESSION['sess_lang_id'] = $lang_change_id;
            $_SESSION['sess_layout_direction'] = $lang['layout_direction'];
    	}
    	redirect($this->agent->referrer());
    }
}