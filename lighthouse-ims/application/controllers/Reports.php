<?php 
	class Reports extends CI_Controller{
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
				$data['header'] = "Deliveries";
				$data['deliveries'] = $this->Database_model->getDeliveriesR();
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['endBalReq']  = count($this->Database_model->getEndBalRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();
				$this->load->view('reports', $data);
			} else {
				$this->load->view('login_view');
			}
		} 

		function delDelivery(){
			if($this->session->userdata('logged_in')){
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['header'] = "delDelivery";
				$data['delRecieptNo'] 	= $this->uri->segment(3);
				$delRecieptNo 			= $this->uri->segment(3);
				$data['deliveries'] = $this->Database_model->getDeliveriesRR($delRecieptNo);
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();
				$this->load->view('reports', $data);
			} else {
				$this->load->view('login_view');
			}
		} 

		function reportsIssuance(){
			if($this->session->userdata('logged_in')) {
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['issueds'] = $this->Database_model->getIssuedsR();
				$data['header'] = "Issuance";
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();
				$this->load->view('reports', $data);
			} else {
				$this->load->view('login_view');
			}
		} 

		function reportsRecReturns(){
			if($this->session->userdata('logged_in')){
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['recret'] = $this->Database_model->getRecReturnsR();
				$data['header'] = "Return To Supplier";
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['recon']          = $this->Database_model->getRecon();
				$this->load->view('reports', $data);
			} else {
				$this->load->view('login_view');
			}
		} 

		function reportsBOReturns(){
			if($this->session->userdata('logged_in')){
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['badorder'] = $this->Database_model->getBOReturnsR();
				$data['header'] = "Return From Branch";
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();
				$this->load->view('reports', $data);
			} else {
				$this->load->view('login_view');
			}
		} 

		function reportsStockAdj(){
			if($this->session->userdata('logged_in')) {
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['header'] = "Stock Adjustments";
				$data['stockadj'] = $this->Database_model->getStockAdjR();
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();
				$this->load->view('reports', $data);
			} else {
				$this->load->view('login_view');
			}
		} 

		function reportsEndingBal(){
			if($this->session->userdata('logged_in')) {
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['endingbal'] = $this->Database_model->getEndingbalR();
				$data['header'] = "Reconciliation";
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();
				$this->load->view('reports', $data);
			} else {
				$this->load->view('login_view');
			}
		}


		function reportsPurchase(){
			if($this->session->userdata('logged_in')) {
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['purchase'] = $this->Database_model->getPurchase();
				$data['header'] = "Purchase";
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();
				$this->load->view('reports', $data);
			} else {
				$this->load->view('login_view');
			}
		}

		function reportsPurchaseDet(){
			if($this->session->userdata('logged_in')) {
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['POID'] 	= $this->uri->segment(3);
				$POID 			= $this->uri->segment(3);
				$data['purchase'] = $this->Database_model->getPurchaseS($POID);
				$data['header'] = "delPurchase";
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['recon']          = $this->Database_model->getRecon();
				$this->load->view('reports', $data);
			} else {
				$this->load->view('login_view');
			}
		}


function reportsMaster(){
			if($this->session->userdata('logged_in')) {
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['master'] = $this->Database_model->getMaster();
				$data['header'] = "Master List";
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();
				$this->load->view('reports', $data);
			} else {
				$this->load->view('login_view');
			}
		}

function reportsPending(){
			if($this->session->userdata('logged_in')) {
				$session_data = $this->session->userdata('logged_in');
				$data['accountUN'] = $session_data['accID'];
				$data['accounts'] = $this->Database_model->getAccounts();
				$data['pending'] = $this->Database_model->getPending();
				$data['header'] = "Pending";
				$data['counts'] = count($this->Database_model->getCounts());
				$data['countsReq'] = count($this->Database_model->getRequest());
				$data['countsRecon'] = count($this->Database_model->getEndBalRequest());
				$data['recon']          = $this->Database_model->getRecon();
				$this->load->view('reports', $data);
			} else {
				$this->load->view('login_view');
			}
		}


		
		}
?>
