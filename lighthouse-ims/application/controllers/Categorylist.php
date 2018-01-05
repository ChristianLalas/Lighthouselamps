<?php 
	class Categorylist extends CI_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('Database_model');
			$this->load->helper('url');			
		}
		
		function index(){
			if($this->session->userdata('logged_in')){
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['supplier'] = $this->Database_model->getSupplier();
				$data['inventory'] = $this->Database_model->getInventory();
				$data['category'] = $this->Database_model->getCategorylist();
				$data['itemtype'] = $this->Database_model->getItemTypelist();
				$data['header'] = "(All)";
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['endBalReq']  = count($this->Database_model->getEndBalRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();

				$trackID = $this->Database_model->getItemCode();
               	if($trackID == null){
					$data['ItemCodeTrack'] = 1;
				} else{
					$data['ItemCodeTrack'] = $trackID[0]->itemCode + 1;
				}
				$this->load->view('item_category', $data);
			} else {
				$this->load->view('login_view');
			}
		}
	}
?>
