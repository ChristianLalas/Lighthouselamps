<?php 
    class Purchase extends CI_Controller{
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
                $trackID = $this->Database_model->getPOTransactionID();
                $data['counts'] = count($this->Database_model->getCounts());
                $data['countsReq'] = count($this->Database_model->getRequest());
                $data['endBalReq']  = count($this->Database_model->getEndBalRequest());
                $data['countsRecon'] = count($this->Database_model->getEndBalRequest());
                $data['recon']          = $this->Database_model->getRecon();
                if($trackID == null){
                    $data['GRtrackID'] = 1;
                } else{
                    $data['GRtrackID'] = $trackID[0]->POID + 1;
                }
                
                $this->load->view('purchase', $data);
            }else{
                $this->load->view('login_view');
            }
        
        } 

        function getItems(){
            $result = $this->Database_model->getItems();
            echo($result);
        }

        function insertGivPORtnsData(){
            $passData = json_decode(file_get_contents("php://input"));

            $accID      = $passData->accoutID;
            $itemData   = $passData->itemData;
            $trackID    = $passData->trackID;
            $issuer     = $passData->issuer;
            $supplier   = $passData->supplierID;
            $dateTime   = $passData->dateTime;
            
            $data = array(
                'aLActivity' => "Purchase Order",
                'accID'      => $accID
            );

            $actLogID = $this->Database_model->insertActivityLogs($data);
        
            $data = array(
                    'PODateTime'    => $dateTime,
                    'POIssuer'      => $issuer,
                    'POSupID'       => $supplier,
                    'POActLogID'    => $actLogID[0]->actLogID
                );

            $POID = $this->Database_model->insertPO($data);

            for($i=0; $i<=count($itemData); $i++) {
                if (empty($itemData[$i])===false) {
                    $data = array(
                        'pDItemCode'    => $itemData[$i]->itemCode, 
                        'pDQty'         => $itemData[$i]->qty,  
                        'pQty'          => $itemData[$i]->qty,    
                        'POID'          => $POID[0]->POID,
                    );

                    $this->Database_model->insertPODetails($data);
                }
            }
            
        }
    }
?>