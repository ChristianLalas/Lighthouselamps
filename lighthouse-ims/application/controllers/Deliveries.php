<?php 
	
	    class Deliveries extends CI_Controller{
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
					$data['purchase'] = $this->Database_model->getPO();
					$data['deliveries'] = $this->Database_model->getDeliveriesR();
					$data['endBalReq']  = count($this->Database_model->getEndBalRequest());
					$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
					$data['recon']          = $this->Database_model->getRecon();

					$this->load->view('deliveries', $data);
					}
				else
				{
					$this->load->view('login_view');
		}
		}

		function getItems(){
			$result = $this->Database_model->getItems();
			echo($result);
		}

		function insertDelData(){
			$passData = json_decode(file_get_contents("php://input"));
			
			$accID 		= $passData->accountID;
			$itemData 	= $passData->itemData;
			$trackID  	= $passData->trackID;
			$receiver 	= $passData->receiver;
			$dateTime 	= $passData->dateTime;
			
			$data = array(
				'aLActivity' => "Deliveries",
				'accID'	 	 => $accID
			);

			$actLogID = $this->Database_model->insertActivityLogs($data);

			$data = array(
					"delRecieptNo"	=> $trackID,
					"delIssuer"		=> $receiver,
					"delDateTime"	=> $dateTime, 
					"delActLogID"	=> $actLogID[0]->actLogID
				);

			$delID = $this->Database_model->insertDeliveries($data);

			for ($i=0; $i <= count($itemData); $i++) {
				if(empty($itemData[$i]) == false){ 
					$data = array(
						"dDItemCode"	=> $itemData[$i]->itemCode,
						"dDQty"			=> $itemData[$i]->qty,
						"delID"			=> $delID[0]->delID
					);

					$this->Database_model->insertDeliveryDetails($data);
				}	
			}
		}

		function insertDelDataVP(){
			$passData = json_decode(file_get_contents("php://input"));
			
			$accID 		= $passData->accountID;
			$itemData 	= $passData->itemData;
			$trackID  	= $passData->trackID;
			$receiver 	= $passData->receiver;
			$dateTime 	= $passData->dateTime;
			
			$data = array(
				'aLActivity' => "Deliveries",
				'accID'	 	 => $accID
			);

			$actLogID = $this->Database_model->insertActivityLogs($data);

			$data = array(
					"delRecieptNo"	=> $trackID,
					"delIssuer"		=> $receiver,
					"delDateTime"	=> $dateTime, 
					"delActLogID"	=> $actLogID[0]->actLogID
				);

			$delID = $this->Database_model->insertDeliveries($data);

			for ($i=0; $i <= count($itemData); $i++) {
				if(empty($itemData[$i]) == false){ 
					$data = array(
						"dDItemCode"	=> $itemData[$i]->itemCode,
						"dDQty"			=> $itemData[$i]->rQty,
						"delID"			=> $delID[0]->delID
					);

					$this->Database_model->insertDeliveryDetails($data);
				}	
			}
		}
	} 

?>