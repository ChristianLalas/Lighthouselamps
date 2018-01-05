<?php 
	class Bad_Order extends CI_Controller{
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
				$trackID = $this->Database_model->getBOTransactionID();
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();

				if($trackID == null){
					$data['GRtrackID'] = 1;
				} else{
					$data['GRtrackID'] = $trackID[0]->BOID + 1;
				}
				
				$this->load->view('bad_order', $data);
			}else{
				$this->load->view('login_view');
			}
		
		} 

		function getItems(){
			$result = $this->Database_model->getItems();
			echo($result);
		}

		function insertGivBORtnsData(){
			$passData = json_decode(file_get_contents("php://input"));

			$accID 		= $passData->accoutID;
			$itemData 	= $passData->itemData;
			$trackID  	= $passData->trackID;
			$issuer 	= $passData->issuer;
			$branchID	= $passData->branchID;
			$dateTime 	= $passData->dateTime;
			
			$data = array(
				'aLActivity' => "Bad Order",
				'accID'	 	 => $accID
			);

			$actLogID = $this->Database_model->insertActivityLogs($data);
		
			$data = array(
					'BODateTime' 	=> $dateTime,
					'BOIssuer' 		=> $issuer,
					'BObranch'		=> $branchID,
					'BOActLogID' 	=> $actLogID[0]->actLogID
				);

			$BOID = $this->Database_model->insertBO($data);

			for($i=0; $i<=count($itemData); $i++) {
				if (empty($itemData[$i])===false) {
					$data = array(
						'bDItemCode'	=> $itemData[$i]->itemCode, 
						'bDQty'  		=> $itemData[$i]->qty,  
						'BOres'			=> $itemData[$i]->res,
						'BOID' 			=> $BOID[0]->BOID,
					);

					$this->Database_model->insertBODetails($data);
				}
			}
			
		}
	}
?>