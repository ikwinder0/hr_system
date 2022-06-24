<?php /// remove this file.
use App\Models\UsersModel;
use App\Models\SuperroleModel;
//Process String
if( !function_exists('super_database_backup') ){

	function super_database_backup(){
				
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SuperroleModel = new \App\Models\SuperroleModel();
		
		$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$role_user = $SuperroleModel->where('role_id', $user['user_role_id'])->first();
		$role_resources_ids = explode(',',$role_user['role_resources']);
		return $role_resources_ids;
	}
}