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
				$data['inventory'] = $this->Database_model->getInventoryIL();
				$data['image'] = $this->Database_model->getImage();
				$data['inventory1'] = $this->Database_model->getInventory();
				$data['supplier'] = $this->Database_model->getSupplier();
				$data['itemType']   = $this->Database_model->EBGetItemType();
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

				$this->load->view('inventory_list', $data);
			} else {
				redirect('Login/logInInvalid');
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
               	$data['endBalReq']  = count($this->Database_model->getEndBalRequest());
               	$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
               	$data['recon']          = $this->Database_model->getRecon();

				$this->load->view('lowstocks', $data);
			} else {
				$this->load->view('login_view');
			}
		} 



		
		function getSummaryLedger(){
			$data['recon']          = $this->Database_model->getRecon();
			$itemCode = $this->input->post('itemCode');
			$data['inventory'] = $this->Database_model->getInventory($itemCode);
			$this->load->view('item_list', $data);
		}
			
		function setCurrerntLedger(){
			if($this->session->userdata('logged_in')){

				$session_data		= $this->session->userdata('logged_in');
				$data['accountUN'] 	= $session_data['accID'];
				$data['counts'] 	= count($this->Database_model->getCounts());
				$data['countsReq'] 	= count($this->Database_model->getRequest());
				$data['itemCode'] 	= $this->uri->segment(3);
				$itemCode 			= $this->uri->segment(3);
				$data['inventory'] 	= $this->Database_model->getInventory();
				$data['accounts'] 	= $this->Database_model->getAccounts();
				$data['delData'] 	= $this->Database_model->getCurrentDeliveryItem($itemCode);
				$data['IssueData'] 	= $this->Database_model->getCurrentIssuanceItem($itemCode);
				$data['BOData'] 	= $this->Database_model->getCurrentBOItem($itemCode);
				$data['ROData'] 	= $this->Database_model->getCurrentROItem($itemCode);
				$data['corrData'] 	= $this->Database_model->getCurrentSAItem($itemCode);
				$data['endData'] 	= $this->Database_model->getCurrentEndBalItem($itemCode);
				$data['endBalReq']  = count($this->Database_model->getEndBalRequest());
				$data['footerLable'] = "CURRENT";
				$data['EndingBal'] 	 = $this->Database_model->getCurrentBal($itemCode);
				$data['StartingBal'] = $this->Database_model->getStartingBal($itemCode);
				$data['price'] = $this->Database_model->getPriceL($itemCode);
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();


				$this->load->view('ledger', $data);
			} else {
				$this->load->view('login_view');
			}
		}


			function addImage1(){
			if($this->session->userdata('logged_in')){

				$session_data		= $this->session->userdata('logged_in');
				$data['accountUN'] 	= $session_data['accID'];
				$data['counts'] 	= count($this->Database_model->getCounts());
				$data['countsReq'] 	= count($this->Database_model->getRequest());
				$data['itemCode'] 	= $this->uri->segment(3);
				$itemCode 			= $this->uri->segment(3);
				$data['inventory'] 	= $this->Database_model->getInventory();
				$data['image'] = $this->Database_model->getImage();
				$data['accounts'] 	= $this->Database_model->getAccounts();
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();

				$this->load->view('addimage', $data);
			} else {
				$this->load->view('login_view');
			}
		}


		public function save()
	{
		$data['itemCode'] 	= $this->uri->segment(3);
		$itemCode 			= $this->uri->segment(3);
		$url = $this->do_upload();
		$title = $_POST["title"];

		$data1 = [
					'imageIC' => $itemCode,
					'images' => $url
					
				];
		$this->Database_model->save($title, $data1);

		redirect('Item_List');
		

	}


	
function do_upload()
	{

	$data['itemCode'] 	= $this->uri->segment(3);
	$itemCode 			= $this->uri->segment(3);

	$type = explode('.', $_FILES["userImage"]["name"]);
		$type = strtolower($type[count($type)-1]);
		$url ="./images/".uniqid(rand()).'.'.$type;
		if(in_array($type, array("jpg", "jpeg", "gif", "png")))
			if(is_uploaded_file($_FILES["userImage"]["tmp_name"]))
				if(move_uploaded_file($_FILES["userImage"]["tmp_name"],$url ))
					return $url;
		return "";

		
	// upload the file 
}


		function purchaseOrder(){
			if($this->session->userdata('logged_in')){

				$session_data		= $this->session->userdata('logged_in');
				$data['accountUN'] 	= $session_data['accID'];
				$data['counts'] 	= count($this->Database_model->getCounts());
				$data['countsReq'] 	= count($this->Database_model->getRequest());
				$data['POID'] 	= $this->uri->segment(3);
				$POID 			= $this->uri->segment(3);
				$data['inventory'] 	= $this->Database_model->getInventory();
				$data['accounts'] 	= $this->Database_model->getAccounts();
				$data['recon']          = $this->Database_model->getRecon();
				$data['showPO']		= $this->Database_model->getPurchaseD($POID);
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());

				

				$this->load->view('view_po', $data);
			} else {
				$this->load->view('login_view');
			}
		}

		function itemDisable(){
			if($this->session->userdata('logged_in')){
				$data['itemCode'] = $this->uri->segment(3);
				$data['newStat'] = "canceled";
				$this->Database_model->editItemStatus($data);
				
				$accID = $this->uri->segment(3);
				$date = date('Y-m-d');
				$time = date('h:i a');
				$edit = "canceled purchase item.$itemcode.";
				$data['actlog'] =  array(
					'aLActivity' => $edit,
					'accID' => $accID
				);
				
				$this->Database_model->insertActLogs($data['actlog']);
				redirect('Deliveries');
			} else {
				$this->load->view('login_view');
			}
		}


		function setDeliveredQuantity(){
			if($this->session->userdata('logged_in')){

				$session_data		= $this->session->userdata('logged_in');
				$data['accountUN'] 	= $session_data['accID'];
				$data['counts'] 	= count($this->Database_model->getCounts());
				$data['countsReq'] 	= count($this->Database_model->getRequest());
				$data['itemCode'] 	= $this->uri->segment(3);
				$itemCode 			= $this->uri->segment(3);
				$data['inventory'] 	= $this->Database_model->getInventory();
				$data['accounts'] 	= $this->Database_model->getAccounts();
				$data['purchase'] 	= $this->Database_model->getCurrentBOItem($itemCode);
				$data['delData'] 	= $this->Database_model->getCurrentDeliveryItem($itemCode);
				$data['IssueData'] 	= $this->Database_model->getCurrentIssuanceItem($itemCode);

				$data['BOData'] 	= $this->Database_model->getCurrentBOItem($itemCode);
				$data['ROData'] 	= $this->Database_model->getCurrentROItem($itemCode);
				//$data['SpoilData'] 	= $this->Database_model->getCurrentSpoilageItem($itemCode);
				//$data['RRData'] 	= $this->Database_model->getCurrentReturnsItem($itemCode);
				$data['corrData'] 	= $this->Database_model->getCurrentSAItem($itemCode);
				$data['recon']          = $this->Database_model->getRecon();

				$data['footerLable'] = "CURRENT";
				
				$data['EndingBal'] 	 = $this->Database_model->getCurrentBal($itemCode);;
				$data['StartingBal'] = $this->Database_model->getStartingBal($itemCode);;
				

				$this->load->view('set_delivery', $data);
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
				$data['recon']          = $this->Database_model->getRecon();
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