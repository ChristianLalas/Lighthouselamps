<?php 

class Database_model extends CI_Model{
	
	function __construct(){
		parent :: __construct();
	}
	
	
	function login($username, $password){
		$this -> db -> select('accID, accUn, accPass');
		$this -> db -> from('accounts');
		$this -> db -> where("accUN like binary", $username); 
		$this -> db -> where("accPass like binary", $password);
		$this -> db -> where(accStat, "ENABLED");
		$this -> db -> limit(1);
		
		$query = $this -> db -> get();
		if($query->num_rows() == 1){
			return $query->result();
		} else {
			return NULL;
		}
	}
	
	

	function getAccounts(){
		$query = $this->db->query('SELECT * FROM ACCOUNTS where accStat = "ENABLED";');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function newAccount($data){
		$this->db->insert('accounts', $data);
	}

	 function editAccStat($data){
		$this->db->where('accID', $data['accID'])->update('accounts', array('accStat' => $data['newStat']));
	}

	function getUnit(){
		$query = $this->db->query('Select * from units');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

function getPending() {
		$query = $this->db->query('SELECT * FROM purchase WHERE pDStatus = "pending"');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getInventory(){
		$query = $this->db->query('SELECT *, TRUNCATE((itemQty / bCValue), 0) as "baseQty", mod(itemQty, bCValue) as "convQty" FROM (inventory join category on inventory.categoryID = category.categoryID) join itemtype on inventory.itemTypeID = itemtype.itemTypeID join suppliers on inventory.supID = suppliers.supID WHERE itemStat = "ENABLED" order by itemName ASC;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}


	public function save($title,$data1)
	{
		$this->db->set($data1);
		$this->db->insert('images');
	}


	function getPurchase() {
		$query = $this->db->query('	SELECT DISTINCT purchase.POID, purchase.PODateTime from purchase join po_details on purchase.POID = po_details.POID join inventory on po_details.pDItemCode = inventory.itemCode ORDER BY PODateTime DESC');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}
	function getPurchaseS($POID) {
		$query = $this->db->query('SELECT * FROM ((po_details LEFT JOIN purchase ON  po_details.POID = purchase.POID) LEFT JOIN inventory ON po_details.pDItemCode = inventory.itemCode)LEFT JOIN suppliers ON inventory.supID = suppliers.supID JOIN accounts ON purchase.POIssuer = accounts.accID where purchase.POID = '.$POID.' ORDER BY PODateTime DESC');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}


	function getPurchaseD($POID) {
		$query = $this->db->query('SELECT * FROM ending_balance;');
		
		if($query->num_rows() > 0){
			$query = $this->db->query('SELECT * from (po_details join purchase on purchase.POID = po_details.pOID) join inventory on inventory.itemCode = po_details.pDItemCode JOIN accounts ON purchase.POIssuer = accounts.accID JOIN suppliers ON purchase.POSupID = suppliers.SupID where po_details.POID = '.$POID.' and pDQty > 0 and poStatus= "pending" and PODateTime BETWEEN (SELECT date_add(MAX(STR_TO_DATE(eDDateTime,"%Y-%m-%d %H:%i:%s")), interval 1 Second) FROM ending_balance) AND now();');
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		} else {
			$query = $this->db->query('SELECT * from (po_details join purchase on purchase.POID = po_details.pOID) join inventory on inventory.itemCode = po_details.pDItemCode JOIN accounts ON purchase.POIssuer = accounts.accID JOIN suppliers ON purchase.POSupID = suppliers.SupID where po_details.POID = '.$POID.' and pDQty > 0  ');
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
	}

	function getPO() {
		$query = $this->db->query('SELECT DISTINCT purchase.POID, purchase.PODateTime, supCompany, purchase.pDStatus FROM purchase join po_details on purchase.POID = po_details.POID, suppliers WHERE purchase.POsupID = suppliers.SupID and pDQty > 0 ORDER BY purchase.POID ASC');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}


	function getInventoryIL(){
		$query = $this->db->query('SELECT *, TRUNCATE((itemQty / bCValue), 0) as "baseQty", mod(itemQty, bCValue) as "convQty" FROM (inventory join category on inventory.categoryID = category.categoryID) join itemtype on inventory.itemTypeID = itemtype.itemTypeID join suppliers on inventory.supID = suppliers.supID join images on inventory.itemCode = images.imageIC order by itemName ASC;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getRecon(){
		$query = $this->db->query('SELECT *, TRUNCATE((itemQty / bCValue), 0) as "baseQty", mod(itemQty, bCValue) as "convQty" FROM (inventory join category on inventory.categoryID = category.categoryID) join itemtype on inventory.itemTypeID = itemtype.itemTypeID join suppliers on inventory.supID = suppliers.supID WHERE itemStat = "ENABLED" and recon = "1"order by itemName ASC;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getImage(){
		$query = $this->db->query('SELECT * from images');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getInventoryILEnabled(){
		$query = $this->db->query('select * from ((inventory join itemtype on inventory.itemTypeID = itemtype.itemTypeID) join units on baseUnit = unitID) join convunits on inventory.convUnitID = convunits.convUnitID where itemStat = "ENABLED" order by itemName ASC;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getInventoryILDisabled(){
		$query = $this->db->query('select * from (inventory join itemtype on inventory.itemTypeID = itemtype.itemTypeID) join category on inventory.categoryID = category.categoryID where itemStat = "DISABLED" order by itemName ASC;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getCounts(){
		$query = $this->db->query('select * from (inventory join itemtype on inventory.itemTypeID = itemtype.itemTypeID)  join category on inventory.categoryID = category.categoryID WHERE itemRLvl >= (itemQty / bCValue) AND itemStat = "ENABLED" order by itemName ASC;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function editItemStatus($data){
		$this->db->where('pditemCode', $data['itemCode'])->update('po_details', array('poStatus' => $data['newStat'] ,'pDQty' => 0));
	}
	
    function editItemStat($data){
		$this->db->where('itemCode', $data['itemCode'])->update('inventory', array('itemStat' => $data['newStat']));
	}
	
	function insertActLogs($data){
		$this->db->insert('actlogs', $data);
	}
	
	function updInventory($data){
		$this->db->update('inventory', $data, array('prodID' => $prodid));
	}

	function newItem($data){
		$this->db->insert('inventory', $data);
		
	}
	
	function newItem1($data1){
		$this->db->insert('inventory_history', $data1);
		
	}
	
	function newDelivery($data){
		$this->db->insert('deliveries', $data);
	}
	
	function getDelivery(){
		$query = $this->db->query('Select * from deliveries ORDER BY delDateTime ASC;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function newSupplier($data){
		$this->db->insert('suppliers', $data);
	}

	 function editSupStat($data){
		$this->db->where('supID', $data['supID'])->update('suppliers', array('supStat' => $data['newStat']));
	}
	
	function getConsumedStocks(){
		$query = $this->db->query('Select * from consumedstocks ORDER BY csDate DESC;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}
	
	function getItems(){
		$query = $this->db->query('SELECT * from (inventory join itemtype on inventory.itemTypeID = itemtype.itemTypeID) join category on inventory.categoryID = category.categoryID join suppliers on inventory.supID = suppliers.supID where itemStat = "ENABLED" order by itemName ASC;');
		if($query->num_rows() > 0){
			return json_encode($query->result());
		} else {
			return NULL;
		}
	}

	function addSupplier($data){
		$this->db->insert('suppliers',$data);
	}
	
	/*edit suppliers*/
	function searchSupplier($supId){
		$query = $this->db->query("SELECT * FROM suppliers WHERE supID='".$supId."'");
		if($query->num_rows() >= 0){
			return json_encode($query->result());
		} else {
			return null;
		}
	}

	function updateSupplier($supId, $data){
		$this->db->where('supId', $supId);
		$this->db->update('suppliers', $data); 
	}

	/*activity logs*/
	function getActivityLogs(){
		$query = $this->db->query("SELECT * FROM actlogs join accounts on  actlogs.accID = accounts.accID order by aLDateTime DESC;");
		if($query->num_rows() >= 0){
			return $query->result();
		} else {
			return null;
		}
	}

	function getActivitySummary($id, $activity){
		$data = array();
		if ($activity == "Deliveries") {
			$query = $this->db->query("SELECT * FROM ((((delivery_details join deliveries on deliveries.delID = delivery_details.delID)) join inventory on dDItemCode = itemCode) join units on dDUnit = unitID) join accounts on delIssuer = accID where delActLogID = '".$id."';");

			if($query->num_rows() > 0){
				foreach($query->result() as $rs){
					$data[] = '{"itemName":"'.$rs->itemName.'", "qty":"'.$rs->dDQty.'","unitName":"'.$rs->unitName.'","checker":"'	.$rs->accLN.", ". $rs->accFN.'","trackID":"'.$rs->delRecieptNo.'","dateNTime":"'.$rs->delDateTime.'","company":"'.$rs->supCompany.'"} ';
				};
				return json_encode($data);
			} else {
				return null;
			}
		} elseif ($activity == "Bad Order") {
			$query = $this->db->query("SELECT * FROM ((((badorder join bo_details on badorder.BOID = bo_details.BOID) join suppliers on BOSupID = supID) join inventory on bDItemCode = itemCode) join units on bDUnit = unitID) join accounts on BOIssuer = accID where BOActLogID = '".$id."';");

			if($query->num_rows() > 0){
				foreach($query->result() as $rs){
					$data[] = '{"itemName":"'.$rs->itemName.'", "qty":"'.$rs->bDQty.'","unitName":"'.$rs->unitName.'","checker":"'	.$rs->accLN.'","desc":"'.$rs->bDDesc.", ". $rs->accFN.'","trackID":"'.$rs->BOID.'","dateNTime":"'.$rs->BODateTime.'","company":"'.$rs->supCompany.'"} ';
				};
				return json_encode($data);
			} else {
				return null;
			}
		} elseif ($activity == "Spoilage") {
			$query = $this->db->query("SELECT * from ((( spoilage_details join spoilage on spoilage_details.spID = spoilage.spID) join inventory on sDItemCode = itemCode) join units on sDUnit = unitID) join accounts on spIssuer = accID where spActLogID = '".$id."';");

			if($query->num_rows() > 0){
				foreach($query->result() as $rs){
					$data[] = '{"itemName":"'.$rs->itemName.'", "qty":"'.$rs->sDQty.'","unitName":"'.$rs->unitName.'","checker":"'	.$rs->accLN.", ". $rs->accFN.'","trackID":"'.$rs->spID.'","dateNTime":"'.$rs->spDateTime.'","desc":"'.$rs->sDDesc.'"} ';
				};
				return json_encode($data);
			} else {
				return null;
			}
		} elseif ($activity == "Returns") {
			$query = $this->db->query("SELECT * from (((returns_details join returns on returns.retID = returns_details.retID) join inventory on rDItemCode = itemCode) join units on rDUnit = unitID) join accounts on retIssuer = accID where retActLogID = '".$id."';");

			if($query->num_rows() > 0){
				foreach($query->result() as $rs){
					$data[] = '{"itemName":"'.$rs->itemName.'", "qty":"'.$rs->rDQty.'","unitName":"'.$rs->unitName.'","checker":"'	.$rs->accLN.", ". $rs->accFN.'","trackID":"'.$rs->retID.'","dateNTime":"'.$rs->retDateTime.'","desc":"'.$rs->rDDesc.'"} ';
				};
				return json_encode($data);
			} else {
				return null;
			}
		} elseif ($activity == "Issuance") {
			$query = $this->db->query("SELECT * FROM (((issuance join issuance_details on issuance.isID = issuance_details.isID) join inventory on isDItemCode = itemCode) join units on isDUnit = unitID) join accounts  on isIssuer = accID where isActLogID = '".$id."';");

			if($query->num_rows() > 0){
				foreach($query->result() as $rs){
					$data[] = '{"itemName":"'.$rs->itemName.'", "qty":"'.$rs->isDQty.'","unitName":"'.$rs->unitName.'","checker":"'	.$rs->accLN.", ". $rs->accFN.'","trackID":"'.$rs->isID.'","dateNTime":"'.$rs->isDateTime.'","desc":"'.$rs->isDesc.'"} ';
				};
				return json_encode($data);
			} else {
				return null;
			}	
		} elseif ($activity == "Stock Adjustments") {
			$query = $this->db->query("SELECT * FROM (stock_adjustments join inventory on saItemCode = itemCode) where saActLogID = '".$id."';");
			if($query->num_rows() > 0){
				foreach($query->result() as $rs){
					$data[] = '{"itemName":"'.$rs->itemName.'", "qty":"'.$rs->saQty.'","desc":"'.$rs->saDesc.'"} ';
				};
				return json_encode($data);
			} else {
				return null;
			}
		} else {
			return null;
		}
	}

	/*acounts*/
	function getAccoutsData(){
		$query = $this->db->query('SELECT  * FROM accounts;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return null;
		}
	}

	/*add new user*/
	function addUser($newUserData){
		$this->db->insert('accounts',$newUserData);
	}

	/*admin varification*/
	function PasswordVeri($adminUsername, $adminPass){
		$query = $this->db->query("SELECT * FROM accounts where accUN = '".$adminUsername."' and accPass = '".$adminPass."' and accType = 'MANAGER' and accStat = 'ENABLED'");
		if($query->num_rows() > 0){
			return "TRUE";
		} else {
			return "FALSE";
		}
	}

	function getUserPassword($id){
		$data = array();
		$query = $this->db->query("SELECT accPass FROM accounts where accID = '".$id."'");
		if($query->num_rows() >= 0){	
			foreach($query->result() as $rs){
				$data[] = '{"password":"'.$rs->accPass.'"}';
			};
			return json_encode($data);
		} else {
			return null;
		}
	}

	function getUserInfo($id){
		$data = array();
		$query = $this->db->query("SELECT * FROM accounts where accID = '".$id."'");
		if($query->num_rows() >= 0){	
			foreach($query->result() as $rs){
				$data[] = '{"id":"'.$rs->accID.'", "fname":"'.$rs->accFN.'", "lname":"'.$rs->accLN.'", "type":"'.$rs->accType.'", "username":"'.$rs->accUN.'", "password":"'.$rs->accPass.'", "contactNo":"'.$rs->accContctNo.'", "address":"'.$rs->accAd.'", "status":"'.$rs->accStat.'"}';
			};
			return json_encode($data);
		} else {
			return null;
		}
	}

	function changePass($id, $newPassword){
		$this->db->query("UPDATE accounts SET password = '".$newPassword."' WHERE accID='".$id."';");
	}

	function editUser($Id){
		$query = $this->db->query("SELECT  * FROM accounts where accID = ".$Id.";");
		if($query->num_rows() >= 0){
			return $query->result();
		} else {
			return null;
		}
	}

	function updateUser($accID, $data){
		$this->db->where('accID', $accID);
		$this->db->update('accounts', $data); 
	}

	/*change User Status either de/activate*/
	function changeUserStatus($id, $data){
		$this->db->where('accID', $id);
		$this->db->update('accounts', $data); 
	}

	function insertActivityLogs($data){
		$this->db->insert('actlogs',$data);

		$query = $this->db->query("SELECT actLogID FROM actlogs order by actLogID desc limit 1;");

		if($query->num_rows() >= 0){
			return $query->result();
		} else {
			return null;
		}
	}
	function getItemCode(){
		$query = $this->db->query("SELECT itemCode FROM inventory order by itemCode desc limit 1; ");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return null;
		}
	}


	function getSITransactionID(){
		$query = $this->db->query("SELECT isID FROM issuance order by isID desc limit 1;");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return null;
		}
	}

	
	function getBOTransactionID(){
		$query = $this->db->query("SELECT BOID FROM badorder order by BOID desc limit 1; ");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return null;
		}
	}
	function getPOTransactionID(){
		$query = $this->db->query("SELECT POID FROM purchase order by POID desc limit 1; ");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return null;
		}
	}
	function getROTransactionID(){
		$query = $this->db->query("SELECT ROID FROM returns order by ROID desc limit 1; ");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return null;
		}
	}

	function getReceivingReturnsID(){
		$query = $this->db->query("SELECT retID FROM returns order by retID desc limit 1; ");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return null;
		}
	}

	function insertPurchase($data){
		$this->db->insert('purchase', $data);

		$query = $this->db->query("SELECT purID FROM purchase order by purID desc limit 1;");

		if($query->num_rows() >= 0){
			return $query->result();
		} else {
			return null;
		}
	}
	
	function insertDeliveries($data){
		$this->db->insert('deliveries', $data);

		$query = $this->db->query("SELECT delID FROM deliveries order by delID desc limit 1;");

		if($query->num_rows() >= 0){
			return $query->result();
		} else {
			return null;
		}
	}
	function insertSDeliveries($data){
		$this->db->insert('sdeliveries', $data);

		$query = $this->db->query("SELECT SDelID FROM sdeliveries order by SDelID desc limit 1;");

		if($query->num_rows() >= 0){
			return $query->result();
		} else {
			return null;
		}
	}


	function insertDeliveryDetails($data){
		$this->db->insert('delivery_details', $data);

		$query = $this->db->query("SELECT delID FROM delivery_details order by delID desc limit 1;");

		if($query->num_rows() >= 0){
			return $query->result();
		} else {
			return null;
		}
	}

	function insertIssuance($data){
		$this->db->insert('issuance', $data);

		$query = $this->db->query("SELECT isID FROM issuance order by isID desc limit 1;");

		if($query->num_rows() >= 0){
			return $query->result();
		} else {
			return null;
		}
	}

	function insertIssuanceDetails($data){
		$this->db->insert('issuance_details', $data);
	}

	function insertReturns($data){
		$this->db->insert('returns', $data);

		$query = $this->db->query("SELECT ROID FROM returns order by ROID desc limit 1;");

		if($query->num_rows() >= 0){
			return $query->result();
		} else {
			return null;
		}
	}

	function insertRODetails($data){
		$this->db->insert('ro_details', $data);
	}
	
	function insertBO($data){
		$this->db->insert('badorder', $data);

		$query = $this->db->query("SELECT BOID FROM badorder order by BOID desc limit 1;");

		if($query->num_rows() >= 0){
			return $query->result();
		} else {
			return null;
		}
	}

	function insertBODetails($data){
		$this->db->insert('bo_details', $data);
	}
	function insertPO($data){
		$this->db->insert('purchase', $data);

		$query = $this->db->query("SELECT POID FROM purchase order by POID desc limit 1;");

		if($query->num_rows() >= 0){
			return $query->result();
		} else {
			return null;
		}
	}
	function insertPODetails($data){
		$this->db->insert('po_details', $data);
	}

	function insertSpoilage($data){
		$this->db->insert('spoilage', $data);
		$query = $this->db->query("SELECT spID FROM spoilage order by spID desc limit 1;");

		if($query->num_rows() >= 0){
			return $query->result();
		} else {
			return null;
		}
	}
	function insertSpoilageDetails($data){
		$this->db->insert('spoilage_details', $data);
	}

	function insertStockAdjustments($data){
		$this->db->insert('stock_adjustments', $data);
	}

	function correctionReport(){
		$query = $this->db->query('SELECT * FROM inventory inner join correction on corItem = prodName order by corDate desc;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getRequest(){
		$query = $this->db->query("SELECT * FROM (stock_adjustments join (accounts join actlogs on accounts.accID = actlogs.accID) on saActLogID = actLogID) join inventory on saItemCode = itemCode WHERE saStat = 'PENDING' order by saDateTime desc;");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getEndBalRequest(){
		$query = $this->db->query('SELECT * FROM ending_details JOIN inventory ON ending_details.eDItemCode = inventory.itemCode  ;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getEndingBalReq(){
		$query = $this->db->query("SELECT * FROM (ending_details JOIN inventory ON ending_details.eDItemCode = inventory.itemCode) JOIN accounts ON ending_details.eDAcc = accounts.accID ORDER BY eDDateTime DESC;");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getRequestChecker(){
		$query = $this->db->query("SELECT * FROM (stock_adjustments join (accounts join actlogs on accounts.accID = actlogs.accID) on saActLogID = actLogID) join inventory on saItemCode = itemCode order by saDateTime desc limit 10;");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}


	function getLowStock(){
		$query = $this->db->query("SELECT *, TRUNCATE((itemQty / bCValue), 0) as 'baseQty', mod(itemQty, bCValue) as 'convQty'FROM inventory  join itemtype on inventory.itemTypeID = itemtype.itemTypeID where itemRLvl >= (itemQty / bCValue) ;");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function updateRequestStatus($saID, $data){
		$this->db->where('saID', $saID);
		$this->db->update('stock_adjustments', $data); 
	}

	function searchItem($itemCode){
		$query = $this->db->query("SELECT * FROM inventory where itemCode = ".$itemCode.";");
		if($query->num_rows() > 0){
			return json_encode($query->result());
		} else {
			return NULL;
		}
	}

	function updateItem($itemCode, $data){
		$this->db->where('itemCode', $itemCode);
		$this->db->update('inventory', $data); 
	}

	function updateItem1($itemCode, $data1){
		$this->db->where('itemCode', $itemCode);
		$this->db->insert('inventory_history', $data1); 
	}


	function updateItemEnd($itemCode, $data){
		$this->db->where('itemCode', $itemCode);
		$this->db->update('inventory', $data); 
	}

	function insertEndBalDetails($data){
		$this->db->insert('ending_details', $data);
	}

	function insertEndBalRecons($data){
		$this->db->insert('ending_balance', $data);

		$this->db->empty_table('ending_details');

	}

	function start_reconciliation(){
		$this->db->update('inventory', ['recon' => '1']);
	}
	function cancel_reconciliation(){
		$this->db->update('inventory', ['recon' => '0']);
	}
	function getUnits(){
		$query = $this->db->query("SELECT * FROM units");
		if($query->num_rows() > 0){
			return json_encode($query->result());
		} else {
			return NULL;
		}
	}

	function getMaster(){
		$query = $this->db->query('Select * from (inventory left join inventoryb on inventoryb.priceb)  ');
		if($query->num_rows() >= 0){
			return $query->result();
		} else {
			return null;
		}
	}


	function getSupplier(){
		$query = $this->db->query('Select * from suppliers where supStat = "ENABLED";');
		if($query->num_rows() >= 0){
			return $query->result();
		} else {
			return null;
		}
	}

	function getSuppliers(){
		$query = $this->db->query("SELECT * from suppliers");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getCategory(){
		$query = $this->db->query("SELECT * FROM category");
		if($query->num_rows() > 0){
			return json_encode($query->result());
		} else {
			return NULL;
		}
	}
	function getCategorylist(){
		$query = $this->db->query("SELECT * FROM category");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}
	function getItemTypelist(){
		$query = $this->db->query("SELECT * FROM itemtype");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

function getPriceL($itemCode){
		$query = $this->db->query('SELECT dt, price FROM inventory_history where itemCode = '.$itemCode.'');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}



	function getItemType(){
		$query = $this->db->query("SELECT * FROM itemtype");
		if($query->num_rows() > 0){
			return json_encode($query->result());
		} else {
			return NULL;
		}
	}

	function EBGetItemType(){
		$query = $this->db->query("SELECT * FROM itemtype");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getDeliveriesR() {
		$query = $this->db->query('	SELECT DISTINCT deliveries.delRecieptNo, deliveries.delDateTime from deliveries join delivery_details on deliveries.delID = delivery_details.delID join inventory on delivery_details.dDItemCode = inventory.itemCode ORDER BY delDateTime DESC');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}
	function getDeliveriesRR($delRecieptNo) {
		$query = $this->db->query('SELECT * FROM (((delivery_details LEFT JOIN deliveries ON  delivery_details.delID = deliveries.delID) LEFT JOIN inventory ON delivery_details.dDItemCode = inventory.itemCode) JOIN suppliers ON inventory.supID = suppliers.supID) JOIN accounts ON deliveries.delIssuer = accounts.accID where deliveries.delRecieptNo = "'.$delRecieptNo.'" ORDER BY delDateTime DESC');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}



	function getIssuedsR() {
		$query = $this->db->query('SELECT * FROM (((issuance_details LEFT JOIN issuance ON  issuance_details.isID = issuance.isID)LEFT JOIN inventory ON issuance_details.isDItemCode = inventory.itemCode) JOIN suppliers ON inventory.supID = suppliers.supID JOIN accounts ON issuance.isIssuer = accounts.accID)  ORDER BY isDateTime DESC');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}





	function getRecReturnsR() {
		$query = $this->db->query('SELECT * FROM (((ro_details LEFT JOIN returns ON  ro_details.ROID = returns.ROID) LEFT JOIN inventory ON ro_details.rDItemCode = inventory.itemCode) JOIN suppliers ON returns.ROSupID = suppliers.supID) JOIN accounts ON returns.ROIssuer = accounts.accID  ORDER BY RODateTime DESC');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getBOReturnsR() {
		$query = $this->db->query('SELECT * FROM (((bo_details LEFT JOIN badorder ON  bo_details.BOID = badorder.BOID) LEFT JOIN inventory ON bo_details.bDItemCode = inventory.itemCode) JOIN suppliers ON inventory.supID = suppliers.supID) JOIN accounts ON badorder.BOIssuer = accounts.accID  ORDER BY BODateTime DESC');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getStockAdjR() {
		$query = $this->db->query('SELECT * FROM stock_adjustments LEFT JOIN inventory ON stock_adjustments.saItemCode = inventory.itemCode ORDER BY saDateTime DESC');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getEndingbalR() {
		$query = $this->db->query('SELECT * FROM (ending_balance JOIN inventory ON ending_balance.eDItemCode = inventory.itemCode) ORDER BY eDDateTime DESC');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}


	function checkEndBalRecords(){
		$query = $this->db->query('select if(max(date(EDDateTime)) = current_date(), "TRUE", "FALSE") as "STATEMENT" from (ending_balance join inventory on EDItemCode = itemCode) join itemtype on inventory.itemTypeID = itemtype.itemTypeID ;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function checkEndReqRecords(){
		$query = $this->db->query('select if(max(date(EDDateTime)) = current_date(), "TRUE", "FALSE") as "STATEMENT" from (ending_details join inventory on EDItemCode = itemCode) join itemtype on inventory.itemTypeID = itemtype.itemTypeID ;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function checkPORecords(){
		$query = $this->db->query('select if(max(date(EDDateTime)) = current_date(), "TRUE", "FALSE") as "STATEMENT" from (ending_balance join inventory on EDItemCode = itemCode) join itemtype on inventory.itemTypeID = itemtype.itemTypeID ;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}
	function checkEndBalRecordsByItemType($itemType){
		$query = $this->db->query('select if(max(date(EDDateTime)) = current_date(), "TRUE", "FALSE") as "STATEMENT" from (ending_balance join inventory on EDItemCode = itemCode) join itemtype on inventory.itemTypeID = itemtype.itemTypeID where inventory.itemTypeID ='.$itemType.';');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getCurrentDeliveryItem($itemCode){
		$query = $this->db->query('SELECT * FROM ending_balance;');
		
		if($query->num_rows() > 0){
			$query = $this->db->query('SELECT * from (delivery_details join deliveries on deliveries.delID = delivery_details.delID) where dDItemCode = '.$itemCode.'  and delDateTime BETWEEN (SELECT date_add(MAX(STR_TO_DATE(eDDateTime,"%Y-%m-%d %H:%i:%s")), interval 1 Second) FROM ending_balance) AND now();');
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		} else {
			$query = $this->db->query('SELECT * from (delivery_details join deliveries on deliveries.delID = delivery_details.delID) where dDItemCode = '.$itemCode);
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
	}


	function getCurrentIssuanceItem($itemCode){
		$query = $this->db->query('SELECT * FROM ending_balance;');
		if($query->num_rows() > 0){
			$query = $this->db->query('SELECT * FROM (issuance join issuance_details on issuance.isID = issuance_details.isID) where isDItemCode = '.$itemCode.' and isDateTime BETWEEN (SELECT date_add(MAX(STR_TO_DATE(eDDateTime,"%Y-%m-%d %H:%i:%s")), interval 1 Second) FROM ending_balance) AND now();');
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		} else {
			$query = $this->db->query('SELECT * FROM(issuance join issuance_details on issuance.isID = issuance_details.isID)  where isDItemCode = '.$itemCode);
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
	}

	function getCurrentBOItem($itemCode){
		$query = $this->db->query('SELECT * FROM ending_balance;');
		if($query->num_rows() > 0){
			$query = $this->db->query('SELECT * FROM (badorder join bo_details on badorder.BOID = bo_details.BOID) where bDItemCode = '.$itemCode.' and BODateTime BETWEEN (SELECT date_add(MAX(STR_TO_DATE(eDDateTime,"%Y-%m-%d %H:%i:%s")), interval 1 Second) FROM ending_balance) AND now();');
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		} else {
			$query = $this->db->query('SELECT * FROM (badorder join bo_details on badorder.BOID = bo_details.BOID) where bDItemCode = '.$itemCode);
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
	}

	function getCurrentROItem($itemCode){
		$query = $this->db->query('SELECT * FROM ending_balance;');
		if($query->num_rows() > 0){
			$query = $this->db->query('SELECT * FROM (returns join ro_details on returns.ROID = ro_details.ROID) join suppliers on suppliers.supID = returns.ROsupID where rDItemCode = '.$itemCode.' and RODateTime BETWEEN (SELECT date_add(MAX(STR_TO_DATE(eDDateTime,"%Y-%m-%d %H:%i:%s")), interval 1 Second) FROM ending_balance) AND now();');
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		} else {
			$query = $this->db->query('SELECT * FROM (returns join ro_details on returns.ROID = ro_details.RDID) join suppliers on suppliers.supID = returns.ROsupID where rDItemCode = '.$itemCode);
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
	}
	
	function getCurrentReturnsItem($itemCode){
		$query = $this->db->query('SELECT * FROM ending_balance;');
		
		if($query->num_rows() > 0){
			$query = $this->db->query('SELECT * FROM (returns_details join returns on returns.retID = returns_details.retID) join units on rDUnit = unitID where rDItemCode = '.$itemCode.' and retDateTime BETWEEN (SELECT date_add(MAX(STR_TO_DATE(eDDateTime,"%Y-%m-%d %H:%i:%s")), interval 1 Second) FROM ending_balance) AND now();');
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		} else {
			$query = $this->db->query('SELECT * FROM (returns_details join returns on returns.retID = returns_details.retID) join units on rDUnit = unitID where rDItemCode = '.$itemCode);
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
	}

	function getCurrentSAItem($itemCode){
		$query = $this->db->query('SELECT * FROM ending_balance;');
		if($query->num_rows() > 0){
			$query = $this->db->query('SELECT * from stock_adjustments where saItemCode = '.$itemCode.' and saStat = "APPROVED" and saDateTime BETWEEN (SELECT date_add(MAX(STR_TO_DATE(eDDateTime,"%Y-%m-%d %H:%i:%s")), interval 1 Second) FROM ending_balance) AND now();');
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		} else {
			$query = $this->db->query('SELECT * from  stock_adjustments where saItemCode = '.$itemCode.' and saStat = "APPROVED"');
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
	}

	function getCurrentEndBalItem($itemCode){
		$query = $this->db->query('SELECT * FROM ending_balance where eDItemCode = '.$itemCode.';');
		
	}

	function getCurrentBal($itemCode){
		$query = $this->db->query('SELECT *, TRUNCATE((itemQty / bCValue), 0) as "baseQty",  mod(itemQty, bCValue) as "convQty" FROM inventory join category on inventory.categoryID = category.categoryID where itemCode = '.$itemCode.';');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getStartingBal($itemCode){
		$query = $this->db->query('SELECT *, TRUNCATE((eDPhysCnt / bCValue), 0) as "baseQty", mod(eDPhysCnt, bCValue) as "convQty" FROM (ending_balance join inventory on eDItemCode = itemCode)join category on inventory.categoryID = category.categoryID where eDItemCode = '.$itemCode.' order by eDDateTime desc limit 1;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getItemsByType($itemType){
		$query = $this->db->query('SELECT *, TRUNCATE((itemQty / bCValue), 0) as "baseQty", mod(itemQty, bCValue) as "convQty" FROM ((inventory join units on baseUnit = unitID) join convunits on inventory.convUnitID = convunits.convUnitID) join itemtype on inventory.itemTypeID = itemtype.itemTypeID WHERE itemStat = "ENABLED" and inventory.itemTypeID = "'.$itemType.'" order by itemName ASC;');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getLedgerDate($itemCode){
		$query = $this->db->query('SELECT STR_TO_DATE(eDDateTime,"%Y-%m-%d %H:%i:%s") as "dates" FROM ending_balance where eDItemCode = '.$itemCode.' order by eDDateTime desc;');
		if($query->num_rows() > 0){
			return json_encode($query->result());
		} else {
			return NULL;
		}
	}

	function getNextLedgerDate($itemCode, $fromDate){
		$query = $this->db->query("SELECT STR_TO_DATE(eDDateTime,'%Y-%m-%d %H:%i:%s') as 'date' FROM ending_balance where eDItemCode = ".$itemCode." and STR_TO_DATE(eDDateTime,'%Y-%m-%d %H:%i:%s') = (SELECT min(STR_TO_DATE(eDDateTime,'%Y-%m-%d %H:%i:%s')) FROM ending_balance where STR_TO_DATE(eDDateTime, '%Y-%m-%d %H:%i:%s') > STR_TO_DATE('".$fromDate."','%Y-%m-%d'))");
		if($query->num_rows() > 0){
			return json_encode($query->result());
		} else {
			return NULL;
		}
	}

	function getPreviousLedgerDate($itemCode, $fromDate){
		$query = $this->db->query("SELECT STR_TO_DATE(eDDateTime,'%Y-%m-%d %H:%i:%s') as 'date' FROM ending_balance where eDItemCode = ".$itemCode." and STR_TO_DATE(eDDateTime,'%Y-%m-%d %H:%i:%s') = (SELECT min(STR_TO_DATE(eDDateTime,'%Y-%m-%d %H:%i:%s')) FROM ending_balance where STR_TO_DATE(eDDateTime,'%Y-%m-%d %H:%i:%s') < STR_TO_DATE('".$fromDate."','%Y-%m-%d'));");
		if($query->num_rows() > 0){
			return json_encode($query->result());
		} else {
			return NULL;
		}
	}

	function getHistoryDeliveryItem($itemCode, $toDate, $fromDate){
		$query = $this->db->query('SELECT * from (delivery_details join deliveries on deliveries.delID = delivery_details.delID) join units on dDUnit = unitID where dDItemCode = '.$itemCode.'  and delDateTime BETWEEN STR_TO_DATE("'.$fromDate.'","%Y-%m-%d %H:%i:%s") AND STR_TO_DATE("'.$toDate.'","%Y-%m-%d %H:%i:%s");');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getHistoryIssuanceItem($itemCode, $toDate, $fromDate){
		$query = $this->db->query('SELECT * FROM (issuance join issuance_details on issuance.isID = issuance_details.isID) join units on isDUnit = unitID where isDItemCode = '.$itemCode.' and isDateTime BETWEEN STR_TO_DATE("'.$fromDate.'","%Y-%m-%d %H:%i:%s") AND STR_TO_DATE("'.$toDate.'","%Y-%m-%d %H:%i:%s");');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getHistoryBOItem($itemCode, $toDate, $fromDate){
		$query = $this->db->query('SELECT * FROM (badorder join bo_details on badorder.BOID = bo_details.BOID) join units on bDUnit = unitID where bDItemCode = '.$itemCode.' and BODateTime BETWEEN STR_TO_DATE("'.$fromDate.'","%Y-%m-%d %H:%i:%s") AND STR_TO_DATE("'.$toDate.'","%Y-%m-%d %H:%i:%s");');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getHistoryROItem($itemCode, $toDate, $fromDate){
		$query = $this->db->query('SELECT * FROM (returns join ro_details on returns.BOID = ro_details.BOID) where rDItemCode = '.$itemCode.' and RODateTime BETWEEN STR_TO_DATE("'.$fromDate.'","%Y-%m-%d %H:%i:%s") AND STR_TO_DATE("'.$toDate.'","%Y-%m-%d %H:%i:%s");');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}
	function getHistorySpoilageItem($itemCode, $toDate, $fromDate){
		$query = $this->db->query('SELECT * FROM (spoilage_details join spoilage on spoilage_details.spID = spoilage.spID) join units on sDUnit = unitID where sDItemCode = '.$itemCode.' and spDateTime BETWEEN STR_TO_DATE("'.$fromDate.'","%Y-%m-%d %H:%i:%s") AND STR_TO_DATE("'.$toDate.'","%Y-%m-%d %H:%i:%s");');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}
	
	function getHistoryReturnsItem($itemCode, $toDate, $fromDate){
		$query = $this->db->query('SELECT * FROM (returns_details join returns on returns.retID = returns_details.retID) join units on rDUnit = unitID where rDItemCode = '.$itemCode.' and retDateTime BETWEEN STR_TO_DATE("'.$fromDate.'","%Y-%m-%d %H:%i:%s") AND STR_TO_DATE("'.$toDate.'","%Y-%m-%d %H:%i:%s");');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getHistorySAItem($itemCode, $toDate, $fromDate){
		$query = $this->db->query('SELECT * from stock_adjustments  where saItemCode = '.$itemCode.' and saStat = "APPROVED" and saDateTime BETWEEN STR_TO_DATE("'.$fromDate.'","%Y-%m-%d %H:%i:%s") AND STR_TO_DATE("'.$toDate.'","%Y-%m-%d %H:%i:%s");');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getEndingBal($itemCode, $toDate){
		$query = $this->db->query("SELECT unitName, TRUNCATE((eDPhysCnt / bCValue), 0) as 'baseQty', convUnitName,mod(eDPhysCnt, bCValue) as 'convQty' FROM ((ending_balance join inventory on eDItemCode = itemCode)join units on baseUnit = unitID) join convunits on inventory.convUnitID = convunits.convUnitID where eDItemCode = ".$itemCode." and STR_TO_DATE(eDDateTime,'%Y-%m-%d %H:%i:%s') = STR_TO_DATE('".$toDate."','%Y-%m-%d %H:%i:%s') order by eDDateTime desc limit 1;");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}

	function getHistoryStartingBal($itemCode, $fromDate){
		$query = $this->db->query("SELECT unitName, TRUNCATE((eDPhysCnt / bCValue), 0) as 'baseQty', convUnitName, mod(eDPhysCnt, bCValue) as 'convQty' FROM ((ending_balance join inventory on eDItemCode = itemCode)join units on baseUnit = unitID) join convunits on inventory.convUnitID = convunits.convUnitID where eDItemCode = ".$itemCode." and  STR_TO_DATE(eDDateTime,'%Y-%m-%d %H:%i:%s') =  STR_TO_DATE('".$fromDate."','%Y-%m-%d %H:%i:%s') order by eDDateTime desc limit 1;");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return NULL;
		}
	}
	
	function checkNewItem($newItemName){
		$query = $this->db->query("Select * from inventory where itemName ='".$newItemName."';");
		if($query->num_rows() > 0){
			return "TRUE";
		} else {
			return "FALSE";
		}
	}

	function checkUsername($newUsername){
		$query = $this->db->query("select * from accounts WHERE accUN = '".$newUsername."';");
		if($query->num_rows() > 0){
			return "TRUE";
		} else {
			return "FALSE";
		}
	}

	function checkNewUsername($accID, $newUsername){
		$query = $this->db->query('SELECT if(accUN = "'.$newUsername.'","TRUE","FALSE") as "status" FROM accounts where accID = '.$accID.';');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return null;
		}
	}

	function checkNewSupplierName($newSuppplierName){
		$query = $this->db->query('SELECT * FROM suppliers WHERE supCompany = "'.$newSuppplierName.'";');
		if($query->num_rows() > 0){
			return "TRUE";
		} else {
			return "FALSE";
		}
	}


	function checkEditSupplierName($supID, $newSuppplierName){
		$query = $this->db->query('SELECT if(supCompany = "'.$newSuppplierName.'","TRUE","FALSE") as "status" FROM suppliers where supID = '.$supID.';');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return null;
		}
	}

	function checkEditItemName($itemCode, $newItemName){
		$query = $this->db->query('SELECT if(itemName = "'.$newItemName.'","TRUE","FALSE") as "status" FROM inventory where itemCode = '.$itemCode.';');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return null;
		}
	}

	function insertUnits($unitName){
		$data = array('practiceName' => $unitName );
		$this->db->insert('practice', $data);

		$data = array('convUnitName' => $unitName );
		$this->db->insert('convunits', $data);
	}
	function insertItemtype($itemTypeName){
		$data = array('itemTypeName' => $itemTypeName );
		$this->db->insert('itemtype', $data);

	}
	function insertCategory($categoryName){
		$data = array('categoryName' => $categoryName );
		$this->db->insert('category', $data);

	}
	function insertDescription($descriptionName){
		$data = array('descName' => $descriptionName );
		$this->db->insert('description', $data);

	}


	function checkNewUnitName($unitName){
		$query = $this->db->query("SELECT * FROM units where unitName = '".$unitName."';");
		if($query->num_rows() > 0){
			return "TRUE";
		} else {
			return "FALSE";
		}
	}
	function checkNewItemtypeName($itemTypeName){
		$query = $this->db->query("SELECT * FROM itemtype where itemTypeName = '".$itemTypeName."';");
		if($query->num_rows() > 0){
			return "TRUE";
		} else {
			return "FALSE";
		}
	}
	function checkNewCategoryName($categoryName){
		$query = $this->db->query("SELECT * FROM category where categoryName = '".$categoryName."';");
		if($query->num_rows() > 0){
			return "TRUE";
		} else {
			return "FALSE";
		}
	}
	function checkNewDescriptionName($descriptionName){
		$query = $this->db->query("SELECT * FROM description where descName = '".$descriptionName."';");
		if($query->num_rows() > 0){
			return "TRUE";
		} else {
			return "FALSE";
		}
	}

	function checkEditUnitName($unitID, $unitName){
		$query = $this->db->query('SELECT if(unitID = "'.$unitName.'","TRUE","FALSE") as "status" FROM units where unitName = '.$unitID.';');
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return null;
		}
	}
}
?>