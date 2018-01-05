<?php 
	
	    class Set_Deliveries extends CI_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('Database_model');
			$this->load->helper('url');			
			$this->load->helper('date');
			date_default_timezone_set('Asia/Manila');			
		}
		
		function index(){
				if($this->session->userdata('logged_in'))
				{
					$session_data = $this->session->userdata('logged_in');
                    $data['accountUN'] = $session_data['accID'];
                    $data['accounts'] = $this->Database_model->getAccounts();
					$data['accounts'] = $this->Database_model->getAccounts();
					$data['inventory'] = $this->Database_model->getInventory();
					$data['supplier'] = $this->Database_model->getSupplier();
					$data['delivery'] = $this->Database_model->getDelivery();
					$data['users'] = $this->Database_model->getAccounts();
					$data['counts'] = count($this->Database_model->getCounts());
					$data['countsReq'] = count($this->Database_model->getRequest());
					$data['purchase'] = $this->Database_model->getPurchase();
					$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
					$data['recon']          = $this->Database_model->getRecon();
					$this->load->view('set_deliveries', $data);
					}
				else
				{
					$this->load->view('login_view');
		}
		}

		function insertSDelData(){
			$passData = json_decode(file_get_contents("php://input"));
			

			$itemCode  		= $passData->itemCode;
			$SdDQty 		= $passData->SdDQty;
			

			$data = array(
					"SdDItemCode"     => $itemCode,
                    "SdDQty"          => $SdDQty
				);

			$SDelID = $this->Database_model->insertSDeliveries($data);
		}
	} 

?>