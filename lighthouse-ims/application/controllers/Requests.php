<?php 
    class Requests extends CI_Controller{
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
                $data['request'] = $this->Database_model->getRequest();
                $data['requestChc'] = $this->Database_model->getRequestChecker();
                $data['counts'] = count($this->Database_model->getCounts());
                $data['countsReq'] = count($this->Database_model->getRequest());
                $data['stockadj'] = $this->Database_model->getStockAdjR();
                $data['countsRecon'] = count($this->Database_model->getEndBalRequest());
                $data['recon']          = $this->Database_model->getRecon();
            $this->load->view('requests', $data);
            } else {
                $this->load->view('login_view');
            }
        }

        function updateStatus(){
            $passData = json_decode(file_get_contents("php://input"));
            
            $accID = $passData->accountID; 

            $data = array(
                'aLActivity' => "PROCESSED REQUESTS",
                'accID'      => $accID
            );
            
            $this->Database_model->insertActivityLogs($data);

            $data = array(
                "saStat" => $passData->status
            );

            $this->Database_model->updateRequestStatus($passData->id, $data);
        }
    }
?>