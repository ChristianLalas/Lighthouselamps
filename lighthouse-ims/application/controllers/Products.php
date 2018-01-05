<?php

class Products extends CI_Controller
{

	function __construct(){
		parent::__construct();

		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

		if(!($this->session->userdata('user')))
		{
			redirect('login');
		}
	}

	public function index(){
		$suppliers = $this->Products_Model->get_supplier();
		$products = $this->Products_Model->read();
		$newly_added_products = $this->Products_Model->newly_added_products();
		$reorder = $this->Products_Model->reorder();
		$suppliers = $this->Suppliers_Model->read();
		$this->load->view('index', ['content' => 'products', 'js' => 'js/products', 'suppliers' => $suppliers, 'products' => $products, 'newly_added_products' => $newly_added_products, 'reorder' => $reorder, 'suppliers' => $suppliers]);
	}

	public function create(){
		$name = '';
		if(file_exists($_FILES['image']['tmp_name']) ||  is_uploaded_file($_FILES['image']['tmp_name'])){
			$ext = explode(".", $_FILES["image"]["name"]);
			$name = $_POST['pname'].'.'.end($ext);

			move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $name);
		}
		$data = [
					'image' => $name,
					'prodName' => filter_var(strip_tags($this->input->post('pname')), FILTER_SANITIZE_SPECIAL_CHARS),
					'prodBrand' => filter_var(strip_tags($this->input->post('brand')), FILTER_SANITIZE_SPECIAL_CHARS),
					'prodDesc' => filter_var(strip_tags($this->input->post('desc')), FILTER_SANITIZE_SPECIAL_CHARS),
					'prodPrice' => strip_tags($this->input->post('price')),
					'prodQty' => strip_tags($this->input->post('qty')),
					'prodOrderLvl' => strip_tags($this->input->post('relvl')),
					'date_added' => date('Y-m-d H:i:s'),
					'suppID' => $this->input->post('suppID')
				];
		$user = $this->session->userdata('user')->firstName.' '.$this->session->userdata('user')->lastName;
		$this->Products_Model->create($data, $user);
		$this->session->set_flashdata('product_saved', true);
		redirect('products');
	}

	public function read(){
		echo json_encode(['data' => $this->Products_Model->read()]);
	}

	public function delete(){
		$itemNum = $this->input->post('itemNum');
		$this->Products_Model->delete_product($itemNum);

		redirect('products');
	}

	public function update(){
		$itemNum = $this->input->post('itemNum');
		$price = filter_var(strip_tags($this->input->post('price')), FILTER_SANITIZE_SPECIAL_CHARS);

		$name = '';
		if(file_exists($_FILES['image']['tmp_name']) ||  is_uploaded_file($_FILES['image']['tmp_name'])){
			$ext = explode(".", $_FILES["image"]["name"]);
			$name = $_POST['pname'].'.'.end($ext);

			move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $name);
		}

		$this->Products_Model->update_product($itemNum, $price, $name);

		redirect('products', 'refresh');
	}

	public function save_sale(){
		$customer = $this->input->post('customer');
		$itemNum = $this->input->post('itemNum');
		$qty = $this->input->post('qty');
		$initial_qty = $this->input->post('initial_qty');
		$ph_id = $this->input->post('ph_id');
		$adjusted_price = $this->input->post('price_override');
		$ledger = [];
		$product = [];

		$prod_qty = [];

		if($itemNum)
		{
			foreach ($itemNum as $key => $value) {
				$calc_qty = floatval($initial_qty[$key]);
				if(count($prod_qty) > 0)
				{
					$exist = false;
					foreach ($prod_qty as $key1 => &$value1) {
						if($value1['itemNum'] === $value)
						{
							$calc_qty = floatval($value1['qty']);
							$value1['qty'] = floatval($value1['qty']) - floatval($qty[$key]);

							$exist = true;
						}
					}
					if(!$exist)
					{
						array_push($prod_qty, ['itemNum' => $value, 'qty' => floatval($calc_qty) - floatval($qty[$key])]);
					}
				}
				else
				{
					array_push($prod_qty, ['itemNum' => $value, 'qty' => floatval($calc_qty) - floatval($qty[$key])]);
				}
				array_push($ledger, [
									'itemNum' => $value,
									'activity' => 'sales',
									'activity_date' => date('Y-m-d H:i:s'),
									'initial_inventory' => $calc_qty,
									'inventory_in' => '',
									'inventory_out' => $qty[$key],
									'balance' => floatval($calc_qty) - floatval($qty[$key]),
									'ph_id' => $ph_id[$key],
									'adjusted_price' => $adjusted_price[$key],
									'adjusted_qty' => '',
									'business_partner' => $customer
								]);

				array_push($product, [
										'itemNum' => $value,
										'prodQty' => floatval($calc_qty) - floatval($qty[$key])
									]);
			}
			$this->Products_Model->save_sale($ledger, $product);
			$this->session->set_flashdata('sale', true);
		}
		else
		{
			$this->session->set_flashdata('error', true);
		}
		redirect('customer_sale');
	}

	public function disabled_products(){
		$newly_added_products = $this->Products_Model->newly_added_products();
		$reorder = $this->Products_Model->reorder();
		$this->load->view('index', ['content' => 'disabled_products', 'js' => 'js/disabled_products', 'newly_added_products' => $newly_added_products, 'reorder' => $reorder]);
	}

	public function get_disabled_products(){
		echo json_encode(['data' => $this->Products_Model->get_disabled_products()]);
	}

	public function enable_product(){
		$itemNum = $this->input->post('itemNum');
		$this->Products_Model->enable_product($itemNum);
	}

	public function product_ledger($itemNum){
		$product_ledger = $this->Products_Model->product_ledger($itemNum);
		$price_history = $this->Products_Model->price_history($itemNum);
		$newly_added_products = $this->Products_Model->newly_added_products();
		$reorder = $this->Products_Model->reorder();

		$this->load->view('index', ['content' => 'product_ledger', 'js' => 'js/product_ledger', 'ledger' => $product_ledger, 'price_history' => $price_history, 'newly_added_products' => $newly_added_products, 'reorder' => $reorder]);
	}

	public function get_all_products(){
		echo json_encode($this->Products_Model->get_all_products());
	}
}