<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//FOR VIEW GRID FUNCTIONS, USE ONE FUNCTION WITH DIFFERENT SQL
class GridModel extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
	/*--------------------------
	USERS
	---------------------------*/
	function get_users_grid($sort, $order, $page, $rows, $search){
		///////////////$this->db->where('email', $email); 
		$data = array();
		$total_rowct = 0;
		$rowct = 0;
		$total_pages = 0;
		$limit_start = 0;
		$where = false;
		$like = false;
		if($search){
			$like = array($search[0]=>$search[2]);
		}
		//Get total amount of rows
		if($where){
			$this->db->where($where); 
		}
		if($like){
			$this->db->like($like); 
		}
		$query = $this->db->get('users');
		$total_rowct = $query->num_rows();
		//Calculate Pages
		$total_pages = ceil($total_rowct/$rows);
		//Current Page
		if ($page > $total_pages){
			$page = $total_pages;
		}
		//Get Limit Start
		$limit_start = $rows * $page - $rows;
		if($limit_start < 0){ 
			$limit_start = 0;
		}
		//Query
		if($where){
			$this->db->where($where); 
		}
		if($like){
			$this->db->like($like); 
		}
		$this->db->order_by($sort.' '.$order); 
		$this->db->limit($rows, $limit_start);
		$query2 = $this->db->get('users');
		$rowct = $query2->num_rows();
		//Rows
		$data['rows'] = array();
		foreach($query2->result() as $result){
			$data['rows'][] = $result;
		}
		//
		$data['total_pages'] = $total_pages;
		$data['total_rowct'] = $total_rowct;
		$data['rowct'] = $rowct;
		return $data;
	}
	/*--------------------------
	TRUSTEES
	---------------------------*/
	function get_trustees_grid($sort, $order, $page, $rows, $search){
		///////////////$this->db->where('email', $email); 
		$data = array();
		$total_rowct = 0;
		$rowct = 0;
		$total_pages = 0;
		$limit_start = 0;
		$where = false;
		$like = false;
		if($search){
			$like = array($search[0]=>$search[2]);
		}
		//Get total amount of rows
		if($where){
			$this->db->where($where); 
		}
		if($like){
			$this->db->like($like); 
		}
		$query = $this->db->get('trustees');
		$total_rowct = $query->num_rows();
		//Calculate Pages
		$total_pages = ceil($total_rowct/$rows);
		//Current Page
		if ($page > $total_pages){
			$page = $total_pages;
		}
		//Get Limit Start
		$limit_start = $rows * $page - $rows;
		if($limit_start < 0){ 
			$limit_start = 0;
		}
		//Query
		if($where){
			$this->db->where($where); 
		}
		if($like){
			$this->db->like($like); 
		}
		$this->db->order_by($sort.' '.$order); 
		$this->db->limit($rows, $limit_start);
		$query2 = $this->db->get('trustees');
		$rowct = $query2->num_rows();
		//Rows
		$data['rows'] = array();
		foreach($query2->result() as $result){
			$data['rows'][] = $result;
		}
		//
		$data['total_pages'] = $total_pages;
		$data['total_rowct'] = $total_rowct;
		$data['rowct'] = $rowct;
		return $data;
	}
	/*--------------------------
	FUND TYPES
	---------------------------*/
	function get_fund_types_grid($sort, $order, $page, $rows, $search){
		///////////////$this->db->where('email', $email); 
		$data = array();
		$total_rowct = 0;
		$rowct = 0;
		$total_pages = 0;
		$limit_start = 0;
		$where = false;
		$like = false;
		if($search){
			$like = array($search[0]=>$search[2]);
		}
		//Get total amount of rows
		if($where){
			$this->db->where($where); 
		}
		if($like){
			$this->db->like($like); 
		}
		$query = $this->db->get('fund_types');
		$total_rowct = $query->num_rows();
		//Calculate Pages
		$total_pages = ceil($total_rowct/$rows);
		//Current Page
		if ($page > $total_pages){
			$page = $total_pages;
		}
		//Get Limit Start
		$limit_start = $rows * $page - $rows;
		if($limit_start < 0){ 
			$limit_start = 0;
		}
		//Query
		if($where){
			$this->db->where($where); 
		}
		if($like){
			$this->db->like($like); 
		}
		$this->db->order_by($sort.' '.$order); 
		$this->db->limit($rows, $limit_start);
		$query2 = $this->db->get('fund_types');
		$rowct = $query2->num_rows();
		//Rows
		$data['rows'] = array();
		foreach($query2->result() as $result){
			$data['rows'][] = $result;
		}
		//
		$data['total_pages'] = $total_pages;
		$data['total_rowct'] = $total_rowct;
		$data['rowct'] = $rowct;
		return $data;
	}
	/*--------------------------
	CUSTOMERS
	---------------------------*/
	function get_customers_grid($sort, $order, $page, $rows, $search){
		///////////////$this->db->where('email', $email); 
		$data = array();
		$total_rowct = 0;
		$rowct = 0;
		$total_pages = 0;
		$limit_start = 0;
		$where = false;
		$like = false;
		if($search){
			$like = array($search[0]=>$search[2]);
		}
		//Get total amount of rows
		if($where){
			$this->db->where($where); 
		}
		if($like){
			$this->db->like($like); 
		}
		$this->db->select('id');
		$query = $this->db->get('customers');
		//$total_rowct = $this->db->count_all_results();
		$total_rowct = $query->num_rows();
		//Calculate Pages
		$total_pages = ceil($total_rowct/$rows);
		//Current Page
		if ($page > $total_pages){
			$page = $total_pages;
		}
		//Get Limit Start
		$limit_start = $rows * $page - $rows;
		if($limit_start < 0){ 
			$limit_start = 0;
		}
		//Query
		$this->db->select('id, key, title, fname, mname, lname, new_client, address, city, state, zipcode');
		if($where){
			$this->db->where($where); 
		}
		if($like){
			$this->db->like($like); 
		}
		$this->db->order_by($sort.' '.$order); 
		$this->db->limit($rows, $limit_start);
		$query2 = $this->db->get('customers');
		$rowct = $query2->num_rows();
		//Rows
		$data['rows'] = array();
		foreach($query2->result() as $result){
			$data['rows'][] = $result;
		}
		//
		$data['total_pages'] = $total_pages;
		$data['total_rowct'] = $total_rowct;
		$data['rowct'] = $rowct;
		return $data;
	}
	/*--------------------------
	CUSTOMER ACCOUNTS
	---------------------------*/
	function get_customer_accounts_grid($cid,$sort, $order, $page, $rows, $search){
		///////////////$this->db->where('email', $email); 
		$data = array();
		$total_rowct = 0;
		$rowct = 0;
		$total_pages = 0;
		$limit_start = 0;
		$where = false;
		$like = false;
		if($search){
			$like = array($search[0]=>$search[2]);
		}
		//Get total amount of rows
		$this->db->where("customer",$cid); 
		if($where){
			$this->db->where($where); 
		}
		if($like){
			$this->db->like($like); 
		}
		$query = $this->db->get('accounts');
		$total_rowct = $query->num_rows();
		//Calculate Pages
		$total_pages = ceil($total_rowct/$rows);
		//Current Page
		if ($page > $total_pages){
			$page = $total_pages;
		}
		//Get Limit Start
		$limit_start = $rows * $page - $rows;
		if($limit_start < 0){ 
			$limit_start = 0;
		}
		//Query
		$this->db->where("customer",$cid); 
		if($where){
			$this->db->where($where); 
		}
		if($like){
			$this->db->like($like); 
		}
		$this->db->order_by($sort.' '.$order); 
		$this->db->limit($rows, $limit_start);
		$query2 = $this->db->get('accounts');
		$rowct = $query2->num_rows();
		//Rows
		$data['rows'] = array();
		foreach($query2->result() as $result){
			$data['rows'][] = $result;
		}
		//
		$data['total_pages'] = $total_pages;
		$data['total_rowct'] = $total_rowct;
		$data['rowct'] = $rowct;
		return $data;
	}
	/*--------------------------
	PAYMENTS
	---------------------------*/
	function get_payments_grid($sort, $order, $page, $rows, $search,$options){
		$data = array();
		$total_rowct = 0;
		$rowct = 0;
		$total_pages = 0;
		$limit_start = 0;
		$where = false;
		$like = false;
		$cy = $this->SystemModel->get_cache('current_year');
		if($search && is_array($search)){
			$like = array($search[0]=>$search[2]);
		}
		//Get total amount of rows
		if($where){
			$this->db->where($where); 
		}
		foreach($options as $ok => $ov){
			if(!empty($ov)){
				$this->db->where($ok, $ov); 
			}
		}
		if($like){
			$this->db->like($like); 
		}
		$query = $this->db->get('payments');
		$this->db->like('date',$cy); 
		$total_rowct = $query->num_rows();
		//Calculate Pages
		$total_pages = ceil($total_rowct/$rows);
		//Current Page
		if ($page > $total_pages){
			$page = $total_pages;
		}
		//Get Limit Start
		$limit_start = $rows * $page - $rows;
		if($limit_start < 0){ 
			$limit_start = 0;
		}
		//Query
		if($where){
			$this->db->where($where); 
		}
		foreach($options as $ok => $ov){
			if(!empty($ov)){
				$this->db->where($ok, $ov); 
			}
		}
		if($like){
			$this->db->like($like); 
		}
		$this->db->order_by($sort.' '.$order); 
		$this->db->limit($rows, $limit_start);
		$query2 = $this->db->get('payments');
		$rowct = $query2->num_rows();
		//Rows
		$data['rows'] = array();
		foreach($query2->result() as $result){
			$data['rows'][] = $result;
		}
		//
		$data['total_pages'] = $total_pages;
		$data['total_rowct'] = $total_rowct;
		$data['rowct'] = $rowct;
		return $data;
	}
}
/*
END MODEL
*/