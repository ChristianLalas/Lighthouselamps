<?php 
	class Inventory extends CI_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('Database_model');
				$this->load->library('session');
				$this->load->helper('date');
			$this->load->helper('url');		
			date_default_timezone_set('Asia/Manila');	
		}
		
		function index(){
			if($this->session->userdata('logged_in')){
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['inventory'] = $this->Database_model->getInventory();
				//$data['itemType']   = $this->Database_model->EBGetItemType();
				$data['header'] = "(All)";
				$data['counts'] = count($this->Database_model->getCounts());
               	//$data['countsReq'] = count($this->Database_model->getRequest());
               	$data['endBalReq']  = count($this->Database_model->getEndBalRequest());
               	$data['recon']          = $this->Database_model->getRecon();
				$this->load->view('inventory_list', $data);
			} else {
				redirect('Login/logInInvalid');
			}
		}
		
		function inventoryMerch(){
			
				if($this->session->userdata('logged_in'))
				{
					$session_data = $this->session->userdata('logged_in');
					$data['accountUN'] = $session_data['accID'];
					$data['accounts'] = $this->Database_model->getAccounts();
					$data['inventory'] = $this->Database_model->getInventoryProd();
					$data['header'] = "(Products)";
					$data['counts'] = count($this->Database_model->getCounts());
               		$data['countsReq'] = count($this->Database_model->getRequest());
					$this->load->view('inventory_list', $data);
		}
				else
				{
					$this->load->view('login_view', $data);
		}
		}
		
		function inventoryRawM(){
			if($this->session->userdata('logged_in')){
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['inventory'] = $this->Database_model->getInventoryRawMat();
				$data['header'] = "(Raw Materials)";
				$data['counts'] = count($this->Database_model->getCounts());
               	$data['countsReq'] = count($this->Database_model->getRequest());
				$this->load->view('inventory_list', $data);
			}else{
					$this->load->view('login_view', $data);
			}
		}

		function inventoryLowS(){
			if($this->session->userdata('logged_in')){
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['inventory'] = $this->Database_model->getLowStock();
				$data['counts'] = count($this->Database_model->getCounts());
               	$data['countsReq'] = count($this->Database_model->getRequest());
				$this->load->view('lowstocks', $data);
			} else {
				$this->load->view('login_view');
			}
		} 
		
		function getSummaryLedger(){
			$itemCode = $this->input->post('itemCode');
			$data['inventory'] = $this->Database_model->getInventory($itemCode);
			$this->load->view('item_list', $data);
		}
			
		function setCurrerntLedger(){
			if($this->session->userdata('logged_in')){

				$session_data		= $this->session->userdata('logged_in');
				$data['accountUN'] 	= $session_data['accID'];
				$data['counts'] 	= count($this->Database_model->getCounts());
				//$data['countsReq'] 	= count($this->Database_model->getRequest());
				$data['itemCode'] 	= $this->uri->segment(3);
				$itemCode 			= $this->uri->segment(3);
				$data['inventory'] 	= $this->Database_model->getInventory();
				$data['accounts'] 	= $this->Database_model->getAccounts();
				$data['delData'] 	= $this->Database_model->getCurrentDeliveryItem($itemCode);
				$data['IssueData'] 	= $this->Database_model->getCurrentIssuanceItem($itemCode);
				//$data['BOData'] 	= $this->Database_model->getCurrentBOItem($itemCode);
				//$data['SpoilData'] 	= $this->Database_model->getCurrentSpoilageItem($itemCode);
				//$data['RRData'] 	= $this->Database_model->getCurrentReturnsItem($itemCode);
				//$data['corrData'] 	= $this->Database_model->getCurrentSAItem($itemCode);
				
				$data['footerLable'] = "CURRENT";
				
//				$data['EndingBal'] 	 = $this->Database_model->getCurrentBal($itemCode);;
			//	$data['StartingBal'] = $this->Database_model->getStartingBal($itemCode);;
				

				$this->load->view('ledger', $data);
			} else {
				$this->load->view('login_view');
			}
		}

		function getLedgerDate(){
			$passData = json_decode(file_get_contents("php://input"));

			$result = $this->Database_model->getLedgerDate($passData->itemCode);
			echo($result);
		}

		function getNextLedgerDate(){
			$passData = json_decode(file_get_contents("php://input"));

			$result = $this->Database_model->getNextLedgerDate($passData->itemCode, $passData->date);
			echo($result);
		}

		function nextPreviousLedgerDate(){
			$passData = json_decode(file_get_contents("php://input"));

			$result = $this->Database_model->getPreviousLedgerDate($passData->itemCode, $passData->date);
			echo($result);
		}

		function getItemLedgerHistory(){
			if($this->session->userdata('logged_in')){

				$session_data		= $this->session->userdata('logged_in');
				$data['accountUN'] 	= $session_data['accID'];
				$data['counts']		= count($this->Database_model->getCounts());
				$data['countsReq'] 	= count($this->Database_model->getRequest());
				
				$itemCode 	= $this->input->post('itemCode');
				$toDate 	= $this->input->post('toDate');
				$fromDate 	= $this->input->post('fromDate');

				$data['itemCode'] 	= $itemCode;

				$data['accounts'] 	= $this->Database_model->getAccounts();
				$data['inventory'] 	= $this->Database_model->getInventory();
				$data['delData'] 	= $this->Database_model->getHistoryDeliveryItem($itemCode, $toDate, $fromDate);
				$data['IssueData'] 	= $this->Database_model->getHistoryIssuanceItem($itemCode, $toDate, $fromDate);
				$data['BOData'] 	= $this->Database_model->getHistoryBOItem($itemCode, $toDate, $fromDate);
				$data['SpoilData'] 	= $this->Database_model->getHistorySpoilageItem($itemCode, $toDate, $fromDate);
				$data['RRData'] 	= $this->Database_model->getHistoryReturnsItem($itemCode, $toDate, $fromDate);
				$data['corrData'] 	= $this->Database_model->getHistorySAItem($itemCode, $toDate, $fromDate);

				$data['footerLable'] = "ENDING";
				
				$data['EndingBal']	 = $this->Database_model->getEndingBal($itemCode, $toDate);
			
				$data['StartingBal'] = $this->Database_model->getHistoryStartingBal($itemCode, $fromDate);
		
				$this->load->view('ledger', $data);
			} else {
				$this->load->view('login_view');
			}
		}

	}
?>