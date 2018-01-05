<?php 
	class Returns extends CI_Controller{
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
				$data['inventory'] = $this->Database_model->getInventory();
				$data['supplier'] = $this->Database_model->getSupplier();
				$data['users'] = $this->Database_model->getAccounts();
				$trackID = $this->Database_model->getROTransactionID();
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['endBalReq']  = count($this->Database_model->getEndBalRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();
				if($trackID == null){
					$data['GRtrackID'] = 1;
				} else{
					$data['GRtrackID'] = $trackID[0]->ROID + 1;
				}
				
				$this->load->view('returns', $data);
			}else{
				$this->load->view('login_view');
			}
		
		} 

		function getItems(){
			$result = $this->Database_model->getItems();
			echo($result);
		}

		function insertGivROtnsData(){
			$passData = json_decode(file_get_contents("php://input"));

			$accID 		= $passData->accoutID;
			$itemData 	= $passData->itemData;
			$trackID  	= $passData->trackID;
			$issuer 	= $passData->issuer;
			$supID 		= $passData->supplierID;
			$dateTime 	= $passData->dateTime;
			
			$data = array(
				'aLActivity' => "Return Order",
				'accID'	 	 => $accID
			);

			$actLogID = $this->Database_model->insertActivityLogs($data);
		
			$data = array(
					'ROSupID'		=> $supID,
					'ROIssuer' 		=> $issuer,
					'RODateTime' 	=> $dateTime,
					'ROActLogID' 	=> $actLogID[0]->actLogID
				);

			$ROID = $this->Database_model->insertReturns($data);

			for($i=0; $i<=count($itemData); $i++) {
				if (empty($itemData[$i])===false) {
					$data = array(
						'rDItemCode'	=> $itemData[$i]->itemCode, 
						'rDQty'  		=> $itemData[$i]->qty,     
						'ROID' 			=> $ROID[0]->ROID,
					);

					$this->Database_model->insertRODetails($data);
				}
			}
			
		}
	}
?>