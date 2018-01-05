	<?php 
	class Stock_Adjustments extends CI_Controller{
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
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['endBalReq']  = count($this->Database_model->getEndBalRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();
				$this->load->view('stock_adjustments', $data);
			} else {
				$this->load->view('login_view');
			}
		}

		function getItems(){
			$result = $this->Database_model->getItems();
			echo($result);
		}

		function insertCorrectionData(){
			$passData = json_decode(file_get_contents("php://input"));

			$itemData = $passData->itemData;

			$data = array(
				'aLActivity' => "Stock Adjustments",
				'accID'	 	 => $passData->accoutID
			);

			$actLogID  = $this->Database_model->insertActivityLogs($data);

			for ($i=0; $i <= count($itemData); $i++) {
				if(empty($itemData[$i]) == false){ 
					$data = array(
						'saItemCode'	=> $itemData[$i]->itemCode, 
						'saQty'  		=> $itemData[$i]->qty, 
						'saSign'  		=> $itemData[$i]->sign, 
						'saDesc' 		=> $itemData[$i]->desc, 
						'saStat' 		=> $passData->stat,
						'saActLogID' 	=> $actLogID[0]->actLogID
						);

					$this->Database_model->insertStockAdjustments($data);
				}
			}
		}
	}
?>