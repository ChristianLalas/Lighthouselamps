<?php 
	class Stock_Issuance extends CI_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('Database_model');
			$this->load->helper('url');			
			$this->load->helper('date');
			date_default_timezone_set('Asia/Manila');			
		}
		
		function index(){
			if($this->session->userdata('logged_in')){
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['inventory'] = $this->Database_model->getInventory();
				$data['users'] = $this->Database_model->getAccounts();
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['endBalReq']  = count($this->Database_model->getEndBalRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();
				$trackID = $this->Database_model->getSITransactionID();
				if($trackID == null){
					$data['SItrackID'] = 1;
				} else {
					$data['SItrackID'] = $trackID[0]->isID + 1;
				}
				
				$this->load->view('stock_issuance', $data);
			}else{
				$this->load->view('login_view');
			}
		}

		function getItems(){
			$result = $this->Database_model->getItems();
			echo($result);
		}

		function insertIssuData(){
			$passData = json_decode(file_get_contents("php://input"));

			$accID 		= $passData->accoutID;
			$itemData 	= $passData->itemData;
			$trackID  	= $passData->trackID;
			$issuer 	= $passData->issuer;
			$dateTime 	= $passData->dateTime;

			$data = array(
				'aLActivity' => "Issuance",
				'accID'	 	 => $accID 
			);

			$actLogID = $this->Database_model->insertActivityLogs($data);

			$data = array(
					'isDateTime' 	=> $dateTime, 
					'isIssuer' 		=> $issuer,
					'isActLogID' 	=> $actLogID[0]->actLogID
				);

			$isID = $this->Database_model->insertIssuance($data);
			
			for ($i=0; $i <= count($itemData); $i++) {
				if(empty($itemData[$i]) == false){ 
					$data = array(
						'isDItemCode'	=> $itemData[$i]->itemCode, 
						'isDQty'  		=> $itemData[$i]->qty,
						'isDesc' 		=> $itemData[$i]->desc,				
						'isID' 			=> $isID[0]->isID					
					);

					$this->Database_model->insertIssuanceDetails ($data);
				}
			}
		}
	}
?>