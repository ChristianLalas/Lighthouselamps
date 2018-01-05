<?php 
	class Item_List extends CI_Controller{
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
				$data['inventory'] = $this->Database_model->getInventoryIL();
				$data['image'] = $this->Database_model->getImage();
				$data['inventory1'] = $this->Database_model->getInventory();
				$data['header'] = "(All)";
				$data['counts'] = count($this->Database_model->getCounts());
				$trackID = $this->Database_model->getItemCode();
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['endBalReq']  = count($this->Database_model->getEndBalRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
			    $data['recon']          = $this->Database_model->getRecon();

				if($trackID == null){
					$data['ItemCodeTrack'] = 1;
				} else{
					$data['ItemCodeTrack'] = $trackID[0]->itemCode + 1;
				}
				$this->load->view('inventory_list', $data);
			} else {
				$this->load->view('login_view');
			}
		}


		function itemEnabled(){
			if($this->session->userdata('logged_in')){
					$session_data = $this->session->userdata('logged_in');
					$data['accountUN'] = $session_data['accID'];
					$data['accounts'] = $this->Database_model->getAccounts();
					$data['inventory'] = $this->Database_model->getInventoryILEnabled();
					$data['header'] = "(AVAILABLE)";
					$data['counts'] = count($this->Database_model->getCounts());
					$data['countsReq'] = count($this->Database_model->getRequest());
					$data['recon']          = $this->Database_model->getRecon();

					$this->load->view('inventory_list', $data);
			} else {
					$this->load->view('login_view');
			}
		}

		function itemDisabled(){
			if($this->session->userdata('logged_in')){
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['inventory'] = $this->Database_model->getInventoryILDisabled();
				$data['header'] = "(UNAVAILABLE)";
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['recon']          = $this->Database_model->getRecon();

				$this->load->view('inventory_list', $data);
			} else {
				$this->load->view('login_view');
			}
		}

		function itemEnable(){
			$data['recon']          = $this->Database_model->getRecon();
			if($this->session->userdata('logged_in')){
				$data['itemCode'] = $this->uri->segment(4);
				$data['newStat'] = "ENABLED";
				$this->Database_model->editItemStat($data);
				
				redirect('Item_List');
			} else {
				$this->load->view('login_view');
			}
		}

		function itemDisable(){
			if($this->session->userdata('logged_in')){
				$data['itemCode'] = $this->uri->segment(4);
				$data['newStat'] = "DISABLED";
				$this->Database_model->editItemStat($data);
				
				redirect('Item_List');
			} else {
				$this->load->view('login_view');
			}
		}

		function getUnits(){
			$result = $this->Database_model->getUnits();
			echo($result);
		}
		function getCategory(){
			$result = $this->Database_model->getCategory();
			echo($result);
		}
		function getSuppliers(){
			$result = $this->Database_model->getSuppliers();
			echo($result);
		}


		function getItemType(){
			$result = $this->Database_model->getItemType();
			echo($result);
		}

		function searchItem(){
			$passData = json_decode(file_get_contents("php://input"));

			$result = $this->Database_model->searchItem($passData->code);
			echo($result);
		}

		function updateItem(){
			$passData = json_decode(file_get_contents("php://input"));

			$data = array(
				"itemName" 	=> $passData->name,
				"itemRLvl" 	=> $passData->reorderLvl,
				"itemTypeID"=> $passData->type,
				"supID" 	=> $passData->supplier,
				"categoryID"=> $passData->category,
				"bCValue"	=> $passData->bCValue,
				"description" 	=> $passData->description,
				"price" 	=> $passData->price

				);

			$this->Database_model->updateItem($passData->id, $data);
			$data1 = array(
				"itemCode"	=> $passData->id,
				"itemName" 	=> $passData->name,
				"itemRLvl" 	=> $passData->reorderLvl,
				"itemTypeID"=> $passData->type,
				"supID" 	=> $passData->supplier,
				"categoryID"=> $passData->category,
				"bCValue"	=> $passData->bCValue,
				"description" 	=> $passData->description,
				"price" 	=> $passData->price

				);

			$this->Database_model->updateItem1($passData->id, $data1);
		}


		function updateItem1(){
			$passData = json_decode(file_get_contents("php://input"));

			$data = array(
				"itemCode" 	=> $passData->code,
				"itemName" 	=> $passData->name,
				"itemRLvl" 	=> $passData->reorderLvl,
				"itemTypeID"=> $passData->type,
				"supID" 	=> $passData->supplier,
				"categoryID"=> $passData->category,
				"bCValue"	=> $passData->bCValue,
				"description" 	=> $passData->description,
				"price" 	=> $passData->price,
				"date"			=> $passData->date

				);

			$this->Database_model->updateItem1($data);
		}

		function insertItem(){
			$passData = json_decode(file_get_contents("php://input"));

			$data = array(

				"itemName" 	=> $passData->name,
				"itemRLvl" 	=> $passData->reorderLvl,
				"itemTypeID"=> $passData->type,
				"itemQty"	=> 0,
				"categoryID"=> $passData->category,
				"description" => $passData->description,
				"supID"		=> $passData->supplier,
				"price"		=> $passData->price,
				"bCValue"	=> 1,
				"itemStat"	=> "ENABLED"
				);

			$this->Database_model->newItem($data);

			$data1 = array(
				"itemCode"	=> $passData->code,
				"itemName" 	=> $passData->name,
				"itemRLvl" 	=> $passData->reorderLvl,
				"itemTypeID"=> $passData->type,
				"itemQty"	=> 0,
				"categoryID"=> $passData->category,
				"description" => $passData->description,
				"supID"		=> $passData->supplier,
				"price"		=> $passData->price,
				"bCValue"	=> 1,
				"itemStat"	=> "ENABLED"
				);

			$this->Database_model->newItem1($data1);
		}
		
		function checkNewItem(){
			$passData = json_decode(file_get_contents("php://input"));

			$result = $this->Database_model->checkNewItem($passData->newItemName);

			echo($result);
		}

		function checkEditItemName(){
			$passData = json_decode(file_get_contents("php://input"));

			$itemCode = $passData->itemCode;
			$itemName = $passData->itemName;
			
			$resultOne = $this->Database_model->checkEditItemName($itemCode, $itemName);
			$resultTwo = $this->Database_model->checkNewItem($itemName);
			
			if ($resultOne[0]->status == "FALSE" && $resultTwo == "TRUE") {
				echo("TRUE");
			} else if(($resultOne[0]->status == "FALSE" && $resultTwo == "FALSE") || $resultOne[0]->status == "TRUE"){
				echo("FALSE");
			}
		}

		function insertUnit(){
			$passData = json_decode(file_get_contents("php://input"));

			$this->Database_model->insertUnits($passData->unitName);
		}
		function insertItemtype(){
			$passData = json_decode(file_get_contents("php://input"));

			$this->Database_model->insertItemtype($passData->itemTypeName);
		}
		function insertCategory(){
			$passData = json_decode(file_get_contents("php://input"));

			$this->Database_model->insertCategory($passData->categoryName);
		}
		function insertDescription(){
			$passData = json_decode(file_get_contents("php://input"));

			$this->Database_model->insertDescription($passData->descriptionName);
		}

		function checkNewUnitName(){
			$passData = json_decode(file_get_contents("php://input"));

			$result	= $this->Database_model->checkNewUnitName($passData->unitName);
			echo($result);
		}
		function checkNewTypeName(){
			$passData = json_decode(file_get_contents("php://input"));

			$result	= $this->Database_model->checkNewItemtypeName($passData->itemTypeName);
			echo($result);
		}
		function checkNewCategoryName(){
			$passData = json_decode(file_get_contents("php://input"));

			$result	= $this->Database_model->checkNewCategoryName($passData->categoryName);
			echo($result);
		}
		function checkNewDescriptionName(){
			$passData = json_decode(file_get_contents("php://input"));

			$result	= $this->Database_model->checkNewDescriptionName($passData->descriptionName);
			echo($result);
		}

		function checkEditUnitName(){
			$passData = json_decode(file_get_contents("php://input"));
			
			$unitID 	= $passData->unitID;
			$unitName 	= $passData->unitName;
			
			$result	= $this->Database_model->checkEditUnitName($unitID, $unitName);
			echo($result[0]->status);
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
				$data['BOData'] 	= $this->Database_model->getCurrentBOItem($itemCode);
				$data['ROData'] 	= $this->Database_model->getCurrentBOItem($itemCode);
				//$data['SpoilData'] 	= $this->Database_model->getCurrentSpoilageItem($itemCode);
				//$data['RRData'] 	= $this->Database_model->getCurrentReturnsItem($itemCode);
				//$data['corrData'] 	= $this->Database_model->getCurrentSAItem($itemCode);
				$data['endData'] 	= $this->Database_model->getCurrentEndBaltem($itemCode);
				
				$data['footerLable'] = "CURRENT";
				
				$data['EndingBal'] 	 = $this->Database_model->getCurrentBal($itemCode);;
				$data['StartingBal'] = $this->Database_model->getStartingBal($itemCode);;
				

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
				$data['ROData'] 	= $this->Database_model->getHistoryROItem($itemCode, $toDate, $fromDate);
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