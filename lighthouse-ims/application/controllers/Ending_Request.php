<?php 
    class Ending_Request extends CI_Controller{
        function __construct(){
            parent::__construct();
            $this->load->model('Database_model');
            $this->load->helper('url');         
        }
        
        function index(){
            if($this->session->userdata('logged_in')){
                $session_data           = $this->session->userdata('logged_in');
                $data['accountUN']      = $session_data['accID'];
                $data['accounts']       = $this->Database_model->getAccounts();
                $data['itemType']       = $this->Database_model->EBGetItemType();
                $data['counts']         = count($this->Database_model->getCounts());
                $data['countsReq']      = count($this->Database_model->getRequest());
                $data['endReq']         = count($this->Database_model->getEndBalRequest());
                $data['countsRecon']    = count($this->Database_model->getEndBalRequest());
                $data['recon']          = $this->Database_model->getRecon();
                $result                 = $this->Database_model->checkEndBalRecords();
                if($result[0]->STATEMENT === "TRUE"){
                    $data['items1']  = "TRUE";
                } else if($result[0]->STATEMENT === "FALSE"){
                    $data['items1']  = $this->Database_model->getEndBalRequest();
                }


                $result1             = $this->Database_model->checkEndReqRecords();
                if($result1[0]->STATEMENT === "TRUE"){
                    $data['items']  = "TRUE";
                } else if($result1[0]->STATEMENT === "FALSE"){
                    $data['items']  = $this->Database_model->getRecon();
                }

                $this->load->view('ending_request', $data);
            } else {
                $this->load->view('login_view');
            }
        }

        
        
        function getEndBalItems(){
            $result = $this->Database_model->checkEndBalRecords();
            if($result[0]->STATUS == "TRUE"){
                echo(null);
            } else if($result[0]->STATUS == "FALSE"){
                echo($this->Database_model->getItems());
            }
        }

        function start_reconciliation(){
          $this->Database_model->start_reconciliation();
       }
       function cancel_reconciliation(){
          $this->Database_model->cancel_reconciliation();
          redirect('Ending_Request');
       }

        function itemType(){
            if($this->session->userdata('logged_in')){
                $session_data = $this->session->userdata('logged_in');
                $data['accountUN']  = $session_data['accID'];
                $data['accounts']   = $this->Database_model->getAccounts();
                $data['counts'] = count($this->Database_model->getCounts());
                $data['countsReq'] = count($this->Database_model->getRequest());
                $data['itemType']   = $this->Database_model->EBGetItemType();
                $itemType           = $this->uri->segment(3);
                $result             = $this->Database_model->checkEndBalRecordsByItemType($itemType);
                if($result[0]->STATEMENT == "TRUE"){
                    $data['items']  = "TRUE";
                } else {
                    $data['items']  = $this->Database_model->getItemsByType($itemType);
                }
                
                $this->load->view('ending_balance', $data);
            } else {
                $this->load->view('login_view');
            }
        }

        function insertEndBalData(){
            $passData = json_decode(file_get_contents("php://input"));

            $accID      = $passData->accountID;
            $itemData   = $passData->itemData;

            $data = array(
                'aLActivity' => "Did Physical Count",
                'accID'      => $accID
            );

            $actLogID = $this->Database_model->insertActivityLogs($data);

            for ($i=0; $i <= count($itemData); $i++) {
                if(empty($itemData[$i]) == false){ 
                    $data = array(
                        'eDItemCode'   => $itemData[$i]->itemCode,
                        'eDLogiCnt'    => $itemData[$i]->logCnt, 
                        'eDPhysCnt'    => $itemData[$i]->physCnt,
                        'eDDesc'       => $itemData[$i]->desc,                        
                        'eDActLogID'   => $actLogID[0]->actLogID
                    );

                    $this->Database_model->insertEndBalDetails($data);

                }   
            }


            $this->Database_model->cancel_reconciliation();;
        }
    }
?>