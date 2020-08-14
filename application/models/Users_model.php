<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends MY_Model
{
	public $tableName = "users";
	public $pkey = "fin_user_id";

	public function  __construct()
	{
		parent::__construct();
	}

	public function getDataById($fin_user_id)
	{
		//$ssql = "select * from " . $this->tableName ." where fin_user_id = ?";
		$ssql = "select a.*,b.fst_department_name,c.fst_group_name,c.fin_level,d.fst_branch_name,d.fbl_is_hq from " . $this->tableName . " a 
			left join departments b on a.fin_department_id = b.fin_department_id 
			left join usersgroup c on a.fin_group_id = c.fin_group_id 
			left join msbranches d on a.fin_branch_id = d.fin_branch_id 
			where a.fin_user_id = ?";


		$qr = $this->db->query($ssql, [$fin_user_id]);
		$rwUser = $qr->row();
		if ($rwUser) {
			if (file_exists(FCPATH . 'assets/app/users/avatar/avatar_' . $rwUser->fin_user_id . '.jpg')) {
				$avatarURL = site_url() . 'assets/app/users/avatar/avatar_' . $rwUser->fin_user_id . '.jpg';
			} else {

				$avatarURL = site_url() . 'assets/app/users/avatar/default.jpg';
			}
			$rwUser->avatarURL = $avatarURL;
		}

		//Groups
		/*$ssql = "select * from user_group where fin_user_id = ? ";
		$qr = $this->db->query($ssql,[$fin_user_id]);
		$rsGroup = $qr->result();*/

		$data = [
			"user" => $rwUser
			//"list_group" => $rsGroup
		];

		return $data;
	}

	public function getRules($mode = "ADD", $id = 0){

		$rules = [];

		$rules[] = [
			'field' => 'fst_username',
			'label' => 'Username',
			'rules' => array(
				'required',
				'is_unique[users.fst_username.fin_user_id.' . $id . ']'
			),
			'errors' => array(
				'required' => '%s tidak boleh kosong',
				'is_unique' => '%s harus unik',
			),
		];

		$rules[] = [
			'field' => 'fst_fullname',
			'label' => 'Full Name',
			'rules' => 'required|min_length[3]',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
				'min_length' => 'Panjang %s paling sedikit 3 character'
			)
		];

		$rules[] = [
			'field' => 'fst_email',
			'label' => 'Email',
			'rules' => 'required',
			'errors' => array(
				'required' => '%s tidak boleh kosong'
			)
		];

		$rules[] = [
			'field' => 'fdt_birthdate',
			'label' => 'Birth Date',
			'rules' => 'required',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
			)
		];

		$rules[] = [
			'field' => 'fst_birthplace',
			'label' => 'Birth Place',
			'rules' => 'required',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
			)
		];

		$rules[] = [
			'field' => 'fin_department_id',
			'label' => 'Deparment',
			'rules' => 'required',
			'errors' =>array(
				'required' => '%s tidak boleh kosong'
			)
		];

		return $rules;
	}

	public function getRulesCp(){
		$activeUser = $this->aauth->user();
		$password = $activeUser->fst_password;
		$CurrentPassword = $this->input->post("current_password");

		$rules = [];

		if (md5($CurrentPassword) != $password) {

			$rules[] =
				[
					'field' => 'current_password',
					'label' => 'Current Password',
					'rules' => 'matches[' . $password . ']',
					'errors' => array(
						'matches' => 'Wrong password'
					)
				];
		} else { }

		$rules[] = [
			'field' => 'new_password1',
			'label' => 'New Password',
			'rules' => 'required|min_length[3]|matches[new_password2]',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
				'min_length' => 'Panjang %s paling sedikit 3 character',
				'matches' => 'not matches with Repeat password'
			)
		];

		$rules[] = [
			'field' => 'new_password2',
			'label' => 'Repeat Password',
			'rules' => 'required|min_length[3]',
			'errors' => array(
				'required' => '%s tidak boleh kosong',
				'min_length' => 'Panjang %s paling sedikit 3 character'
			)
		];


		return $rules;
	}

	public function getAllList()
	{
		$ssql = "select fin_user_id,fst_username from " . $this->tableName . " where fst_active = 'A' order by fst_username";
		$qr = $this->db->query($ssql, []);
		$rs = $qr->result();
		return $rs;
	}

	public function getUserList_R()
	{
		$ssql = "select fin_user_id,fst_username from " . $this->tableName . " where fst_active != 'D' order by fin_user_id";
		$qr = $this->db->query($ssql, []);
		$rs = $qr->result();
		return $rs;
	}

	public function get_Users()
	{
		$query = $this->db->get('users');
		return $query->result_array();
	}

	public function getSelect2Driver(){
		$activeBranchId = $this->aauth->get_active_branch_id();
		$driverDepartmentId = getDbConfig("driver_department_id");
		$ssql ="select fin_user_id as id, fst_fullname as text from users where fin_branch_id = ? and fin_department_id = ? and fst_active ='A' ";
		$qr = $this->db->query($ssql,[$activeBranchId,$driverDepartmentId]);
		$rs = $qr->result();
		return $rs;
	}

	public function getPrintUser($branchName,$departmentName,$userId_awal,$userId_akhir){
        if ($branchName == 'null'){
            $branchName ="";
        }
        if ($departmentName == 'null'){
            $departmentName ="";
        }
        $ssql = "SELECT a.*,b.fst_department_name,c.fst_group_name,c.fin_level,d.fst_branch_name,d.fbl_is_hq FROM users a 
				LEFT JOIN departments b on a.fin_department_id = b.fin_department_id 
				LEFT JOIN  usersgroup c on a.fin_group_id = c.fin_group_id 
				LEFT JOIN  msbranches d on a.fin_branch_id = d.fin_branch_id 
                WHERE a.fin_branch_id like ?  AND a.fin_department_id like ?
                AND a.fin_user_id >= '$userId_awal' AND a.fin_user_id <= '$userId_akhir' ORDER BY a.fst_fullname ";
        $query = $this->db->query($ssql,['%'.$branchName.'%','%'.$departmentName.'%']);
        //echo $this->db->last_query();
        //die();
        $rs = $query->result();

        return $rs;
	}

	public function getToUserList(){
		$ssql = "select fin_user_id, fst_username from users where fst_active != 'D' order by fst_username";
		$qr = $this->db->query($ssql, []);
		$rs = $qr->result();
		return $rs;
	}
	
	public function getSalesList(){
		$salesDeptId = getDbConfig("sales_department_id");
		$activeBranchId = $this->aauth->get_active_branch_id();
		
		$ssql = "select fin_user_id, fst_username from users where  fin_branch_id =? and fin_department_id = $salesDeptId order by fst_username";
		$qr = $this->db->query($ssql,[$activeBranchId]);
		return $qr->result();
	}

	public function getDriverList(){
		$activeBranchId = $this->aauth->get_active_branch_id();
		$driverDepartmentId = getDbConfig("driver_department_id");
		$ssql ="select fin_user_id, fst_fullname from users where fin_branch_id = ? and fin_department_id = ? and fst_active ='A' ";
		$qr = $this->db->query($ssql,[$activeBranchId,$driverDepartmentId]);
		$rs = $qr->result();
		return $rs;
	}

	public function getApprovedBy($userId = null){
		if ($userId == null){
			$user = $this->aauth->user();
		}else{
			$ssql = "SELECT a.*,b.fin_level FROM users a inner join usersgroup b on a.fin_group_id = b.fin_group_id where a.fin_user_id = ?";
			$qr=$this->db->query($ssql,[$userId]);			
			$user = $qr->row();
			if($user == null){
				return [];
			}
		}
		
        $deptActive = $user->fin_department_id;
        $levelActive = intval($user->fin_level);
        $levelActive = strval($levelActive);

		//yg berhak melakukan approval semua user yg sama departmentnya di atas user request  atau user dengan level top management(direksi)
        $ssql = "SELECT a.*,b.fst_group_name,b.fin_level 
			FROM users a LEFT JOIN usersgroup b ON a.fin_group_id = b.fin_group_id 
			WHERE (a.fin_department_id = $deptActive AND b.fin_level < $levelActive) 
			OR (b.fin_level <= 1)
			AND a.fst_active ='A' 
			ORDER BY a.fst_username";

        $qr = $this->db->query($ssql,[$levelActive]);
		$rs = $qr->result();
		return $rs;
	}

}
