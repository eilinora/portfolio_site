<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MY_Base_Page_Controller extends MX_Controller {

  function __construct() {
    parent::__construct();
    //
    $this->_loadLibraries();
    $this->_loadModel ();
  }

  public function index() {
    //global functions
  }

  protected function _loadLibraries() {
    $this->load->library('site_navigation_generator');
  }

  protected function _loadModel () {
    //load common db_queries model
    //
    //NOTE: individual models for each module should be loaded in sub classes
  }

  protected function _setCSSPageID ($data, $id) {
    $data['class_id'] = $id;
    return $data;
  }

  protected function _hideSideBar ($data) {
    $data ['showSideBar'] = true;
    return $data;
  }

  protected function _loadPage ($view, $data) {
    //load site release version which is used to clear css/js cache
    $this->load->file('config/site_version.php', $data);

    //load headers and nav
    $this->load->view('includes/header.inc', $data);
    //$this->load->view('includes/nav.inc', $data);
    
    //load page content and wrapper
    $data['page_content'] = $view;
    $this->load->view ('page_wrapper', $data);

    //load footer
    $this->load->view('includes/footer.inc', $data);
  }
  
}

/* End of file MY_Base_Page_Controller.php */
/* Location: ./application/controllers/MY_Base_Page_Controller.php */