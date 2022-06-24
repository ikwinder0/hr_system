<?php
namespace App\Models;

use CodeIgniter\Model;
	
class MainModel extends Model {
 
    public function __construct()
    {
        parent::__construct();
       // $db = \Config\Database::connect();
    }
	
	// Function to update record in table
	public function update_company_membership($data2, $id){
		
		$db      = \Config\Database::connect();
		$builder = $db->table('ci_company_membership');
		$builder->where('company_id', $id);
		$builder->update($data2);	
		return true;
	}
	// Function to update record in table
	public function update_company_settings($data2, $id){
		
		$db      = \Config\Database::connect();
		$builder = $db->table('ci_erp_company_settings');
		$builder->where('company_id', $id);
		$builder->update($data2);	
		return true;
	}
	// Function to update record in table
	public function update_employee_record($data2, $id){
		
		$db      = \Config\Database::connect();
		$builder = $db->table('ci_erp_users_details');
		$builder->where('user_id', $id);
		$builder->update($data2);
		return true;
	}
	// Function to update record in table
	public function update_advance_salary_record($data2, $id,$salary_type){
		
		$db      = \Config\Database::connect();
		$builder = $db->table('ci_advance_salary');
		$builder->where('employee_id', $id);
		$builder->where('salary_type', $salary_type);
		$builder->update($data2);
		return true;
	}
	// Function to delete record in table
	public function delete_company_membership($id){
		
		$db      = \Config\Database::connect();
		$builder = $db->table('ci_company_membership');
		$builder->where('company_id', $id);
		$builder->delete();	
	}
	// Function to delete record in table
	public function delete_indicator_options($id){
		
		$db      = \Config\Database::connect();
		$builder = $db->table('ci_performance_indicator_options');
		$builder->where('indicator_id', $id);
		$builder->delete();	
	}
	// Function to delete record in table
	public function delete_appraisal_options($id){
		
		$db      = \Config\Database::connect();
		$builder = $db->table('ci_performance_appraisal_options');
		$builder->where('appraisal_id', $id);
		$builder->delete();	
	}
	// check if check-in available
	public function attendance_first_in_check($employee_id,$attendance_date){
		
		$db      = \Config\Database::connect();
		$builder = $db->table('ci_timesheet');
		$builder->where('employee_id', $employee_id);
		$builder->where('attendance_date', $attendance_date);
		$builder->orderBy('time_attendance_id', 'DESC');
		$builder->limit(1);
		return $builder->countAllResults();
	}
	// check if check-out available
	public function attendance_first_out_check($employee_id,$attendance_date){
		
		$db      = \Config\Database::connect();
		$builder = $db->table('ci_timesheet');
		$builder->where('employee_id', $employee_id);
		$builder->where('attendance_date', $attendance_date);
		$builder->orderBy('time_attendance_id', 'DESC');
		$builder->limit(1);
		return $builder->countAllResults();
	}
	// check if check-out available
	public function attendance_first_out($employee_id,$attendance_date){
		
		$db      = \Config\Database::connect();
		$builder = $db->table('ci_timesheet');
		$builder->where('employee_id', $employee_id);
		$builder->where('attendance_date', $attendance_date);
		$builder->orderBy('time_attendance_id', 'DESC');
		$builder->limit(1);
		$query = $builder->get();
		return $query->getResult();
	}
	public function get_client_tasks($client_id){	

		$db      = \Config\Database::connect();
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$builder = $db->table('ci_projects');
		$builder->select('*');
		$builder->where('ci_projects.client_id', $client_id);
		$builder->join('ci_tasks', 'ci_tasks.project_id = ci_projects.project_id');
		$query = $builder->get();
		return $query->getResult();
	}
	// get my mails
	public function my_mailbox(){	

		$db      = \Config\Database::connect();
		// get session
		$session = \Config\Services::session();
		$UsersModel = new \App\Models\UsersModel();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$builder = $db->table('ci_mailbox');
		$where = "mail_to='".$usession['sup_user_id']."' OR sent_by='".$usession['sup_user_id']."'";
		$builder->where('company_id', $user_info['company_id']);
		$builder->where($where);
		$query = $builder->get();
		return $query->getResult();
	}
	// get my stars mails
	public function my_stars_mailbox(){	

		$db      = \Config\Database::connect();
		// get session
		$session = \Config\Services::session();
		$UsersModel = new \App\Models\UsersModel();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$builder = $db->table('ci_mailbox_read');
		$builder->where('company_id', $user_info['company_id']);
		$builder->where('is_starred', 1);
		$builder->orderBy('mail_id', 'ASC');
		$builder->groupBy("mail_id");
		$query = $builder->get();
		return $query->getResult();
	}
	// get my important mails
	public function my_important_mailbox(){	

		$db      = \Config\Database::connect();
		// get session
		$session = \Config\Services::session();
		$UsersModel = new \App\Models\UsersModel();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$builder = $db->table('ci_mailbox_read');
		$builder->where('company_id', $user_info['company_id']);
		$builder->where('is_important', 1);
		$builder->orderBy('mail_id', 'ASC');
		$builder->groupBy("mail_id");
		$query = $builder->get();
		return $query->getResult();
	}
	// Function to update record in table
	public function update_stars_mail($sup_user_id,$id,$data2){
		
		$db      = \Config\Database::connect();
		$builder = $db->table('ci_mailbox_read');
		$builder->where('mail_to', $sup_user_id);
		$builder->where('mail_id', $id);
		$builder->update($data2);	
		return true;
	}
	// Function to update record in table
	public function update_important_mail($sup_user_id,$id,$data2){
		
		$db      = \Config\Database::connect();
		$builder = $db->table('ci_mailbox_read');
		$builder->where('mail_to', $sup_user_id);
		$builder->where('mail_id', $id);
		$builder->update($data2);	
		return true;
	}
	// update mail record
	public function update_mail_record($mail_to,$mail_id) {
	
		$sql = 'UPDATE ci_mailbox_read set is_read = ? WHERE mail_to = ? and mail_id = ?';
		$binds = array(1,$mail_to,$mail_id);
		$query = $this->db->query($sql, $binds);		
		return $query;
	}
	
	public function read_count_make_payment_payslip($staff_id,$salary_month) {
	
		$db      = \Config\Database::connect();		
		$sql = 'SELECT * FROM ci_payslips WHERE staff_id = ? and salary_month = ?';
		$binds = array($staff_id,$salary_month);
		$query = $db->query($sql, $binds);
		
		return $query->getRow();
	}
	// check if holiday available
	public function holiday_date_check($attendance_date) {
	
		$db      = \Config\Database::connect();	
		$builder = $db->table('ci_holidays');
		$where = "('".$attendance_date."' between start_date and end_date)";
		$builder->where('is_publish', 1);
		$builder->where($where);
		$builder->limit(1);
		$query = $builder->get();
		$holidays = $query->getResult();
		$i = 1;
		$ih=0;
		foreach($holidays as $iholiday){
			$ih += $i;
		}
		if($ih > 0): $ih = 1; else: $ih = 0; endif;
		$data = array('holiday_count' => $ih,'holiday_result' => $holidays);
		return $data;
	}
	// check if leave available
	public function leave_date_check($staff_id,$leave_date) {
	
		$db      = \Config\Database::connect();	
		$builder = $db->table('ci_leave_applications');
		$where = "('".$leave_date."' between from_date and to_date)";
		$builder->where('employee_id', $staff_id);
		$builder->where('status', 2);
		$builder->where($where);
		$builder->limit(1);
		$query = $builder->get();
		$leave_info = $query->getResult();
		$i = 1;
		$ih=0;
		foreach($leave_info as $ileave){
			$ih += $i;
		}
		if($ih > 0): $ilcount = 1; else: $ilcount = 0; endif;
		$data = array('total_leave' => $ih,'leave_count' => $ilcount,'leave_result' => $leave_info);
		return $data;
	}
	// Function to update record in table>>> module attribute
	public function update_attributes_value_record($custom_field_id, $data2){
		
		$db      = \Config\Database::connect();
		$builder = $db->table('ci_module_attributes_values');
		$builder->where('module_attributes_id', $custom_field_id);
		$builder->update($data2);
		return true;
	}
}
?>