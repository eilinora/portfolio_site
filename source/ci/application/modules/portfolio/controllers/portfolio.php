<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH."/controllers/MY_Base_Page_Controller.php";

class Portfolio extends MY_Base_Page_Controller {

  public function index() {
    parent::index();

    //load any helper functions used by controller and view
    $this->_loadHelpers ();

    //
    //TODO: HANDLE ERROR IF ISBN IS empty or invalid
    //
    //grabbing product data form db
    $data = array();
    //$data = $this->product_page_model->getPageInfo($data, $id);

    //set the class id for the page (used in css for styling)
    $data = $this->_setCSSPageID($data, 'porfolio');

    //load view of page as string to be displayed out
    $view = $this->load->view('portfolio_view', $data, true);

    //send string to _load page which will add any global wrapper views to module 
    $this->_loadPage($view, $data);
  }
  /**
   * grab the last segment which should contain the ISBN
   * @return [type] [description]
   */
  protected function _getBookIDFromURI () {
    $segment_len = $this->uri->total_segments();
    return $this->uri->segment($segment_len);
  }

  protected function _loadHelpers () {

  }

  protected function _loadModel () {
    //load model specific to this view
    //$this->load->model('portfolio_model');
  }

}

/* End of file home */
/* Location: ./application/controllers/home.php */