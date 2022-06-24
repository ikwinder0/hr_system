<?php
use App\Models\SystemModel;
use App\Models\SuperroleModel;
use App\Models\UsersModel;
use App\Models\MembershipModel;
use App\Models\CompanymembershipModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$SuperroleModel = new SuperroleModel();
$MembershipModel = new MembershipModel();
$CompanymembershipModel = new CompanymembershipModel();
$session = \Config\Services::session();
$router = service('router');
$usession = $session->get('sup_username');
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>
<script type="text/javascript">
//$(document).ready(function(){
	jQuery("#treeview_r1").kendoTreeView({
	checkboxes: {
	checkChildren: true,
	template: "<label class='custom-control custom-checkbox' ><input type='checkbox' class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text #</span></label>"
	},
	check: onCheck,
	dataSource: [
	// Attendance
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_attendance');?>", value: "attendance",},
	//Projects
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_projects');?>", add_info: "", value: "hr_projects",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_projects');?>", value: "project1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "project1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "project2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "project3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "project4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_update_status');?>", value: "project5",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_discussion');?>", value: "project6",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_bugs');?>", value: "project7",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_tasks');?>", value: "project8",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_attach_files');?>", value: "project9",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_note');?>", value: "project10",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_project_timelogs');?>", value: "project11",}
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_projects_calendar');?>", value: "projects_calendar",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_projects_kanban_board');?>", value: "projects_sboard",},
	]},
	//Tasks
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_tasks');?>", add_info: "", value: "hr_tasks",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_tasks');?>", value: "task1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "task1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "task2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "task3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "task4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_update_status');?>", value: "task5",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_discussion');?>", value: "task6",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_attach_files');?>", value: "task7",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_note');?>", value: "task8",}
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_tasks_calendar');?>", value: "tasks_calendar",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_tasks_sboard');?>", value: "tasks_sboard",},
	]},
	//Payroll
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_payroll');?>",  add_info: "", value: "hr_payroll",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Payroll.xin_setup_payroll');?>", value: "pay1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_payroll_list');?>", value: "pay1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_generate_payslip');?>", value: "pay2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "pay3",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_payslip_history');?>", value: "pay_history",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_advance_salary');?>", value: "hradvance_salary",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "advance_salary1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_request_advance_salary');?>", value: "advance_salary2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "advance_salary3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "advance_salary4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_loan');?>", value: "hrloan",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "loan1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_request_advance_salary');?>", value: "loan2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "loan3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "loan4",},
	]},
	]},
	//Helpdesk
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.dashboard_helpdesk');?>", value: "hr_helpdesk",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "helpdesk1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_create_ticket');?>", value: "helpdesk2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "helpdesk3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_view_ticket');?>", value: "helpdesk4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "helpdesk5",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_update_status');?>", value: "helpdesk6",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_attach_files');?>", value: "helpdesk7",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_note');?>", value: "helpdesk8",}
	]},
	//Training Sessions
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_training');?>", add_info: "", value: "hr_training",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_training');?>", value: "training1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "training2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "training3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "training4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "training6",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_note');?>", value: "training5",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_update_status');?>", value: "training7",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_trainers');?>", value: "trainer1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "trainer1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "trainer2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "trainer3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "trainer4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_training_skills');?>", value: "training_skill1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "training_skill1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "training_skill2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "training_skill3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "training_skill4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_training_calendar');?>", value: "training_calendar",},
	]},
	//Assets
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_assets');?>",  add_info: "", value: "hr_assets",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_assets');?>", value: "asset1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "asset1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "asset2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "asset3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "asset4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_category');?>", value: "asset_cat1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "asset_cat1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "asset_cat2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "asset_cat3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "asset_cat4",}
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Asset.xin_brands');?>", value: "asset_brand1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "asset_brand1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "asset_brand2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "asset_brand3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "asset_brand4",}
	]},
	]},
	//Awards
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_awards');?>",  add_info: "", value: "hr_awards",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_awards');?>", value: "award1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "award1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "award2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "award3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "award4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Employees.xin_award_type');?>", value: "award_type1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "award_type1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "award_type2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "award_type3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "award_type4",}
	]},
	]},
	//Travel
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_travels');?>",  add_info: "", value: "hr_travel",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_travels');?>", value: "travel1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "travel1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "travel2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "travel3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "travel4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_update_status');?>", value: "travel5",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Employees.xin_arragement_type');?>", value: "travel_type1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "travel_type1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "travel_type2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "travel_type3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "travel_type4",}
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Employees.xin_travel_calendar');?>", value: "travel_calendar",},
	]},
	
	//Manage Leave
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Leave.left_leave_request');?>", add_info: "", value: "hr_leave",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_manage_leaves');?>", value: "leave1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "leave2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "leave3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "leave4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "leave6",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_update_status');?>", value: "leave7",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Leave.xin_leave_calendar');?>", value: "leave_calendar",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Leave.xin_leave_type');?>", value: "leave_type1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "leave_type1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "leave_type2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "leave_type3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "leave_type4",},
	]},
	]},
	// Overtime Request
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_overtime_request');?>", value: "overtime_req1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "overtime_req1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "overtime_req2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "overtime_req3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "overtime_req4",},
	]},
	//Complaints
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_complaints');?>", value: "hr_complaints",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "complaint1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "complaint2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "complaint3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "complaint4",},
	]},
	//Resignations
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_resignations');?>", value: "hr_resignations",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "resignation1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "resignation2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "resignation3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "resignation4",},
	]},
	//Disciplinary Cases 
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_warnings');?>", add_info: "", value: "hr_disciplinary",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_warnings');?>", value: "disciplinary1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "disciplinary1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "disciplinary2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "disciplinary3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "disciplinary5",}
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Employees.xin_case_type');?>", value: "case_type1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "case_type1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "case_type2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "case_type3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "case_type4",},
	]},
	]},
	//Transfers 
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_transfers');?>", value: "hr_transfers",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "transfers1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "transfers2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "transfers3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "transfers4",},
	]},
	//Settings 
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.left_settings');?>", value: "hr_settings",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.left_settings');?>", value: "settings1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.left_constants');?>", value: "settings2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.left_email_templates');?>", value: "settings3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_multi_language');?>", value: "settings4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.header_db_log');?>", value: "settings5",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_currency_converter');?>", value: "settings6",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_sms_templates');?>", value: "settings7",},
	]},
	//Inventory Control
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_inventory_control');?>", add_info: "", value: "hr_inventory_control",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_warehouses');?>", value: "warehouse1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "warehouse1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "warehouse2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "warehouse3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "warehouse4",}
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_products');?>", value: "product1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "product1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "product2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "product3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "product4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_out_of_stock');?>", value: "out_of_stock",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_expired_products');?>", value: "expired_product",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_product_category');?>", value: "product_category1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "product_category1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "product_category2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "product_category3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "product_category4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_suppliers');?>", value: "supplier1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "supplier1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "supplier2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "supplier3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "supplier4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_purchases');?>", value: "purchases1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "purchases1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_new_purchase');?>", value: "purchases2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_edit_purchase');?>", value: "purchases3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "purchases4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_update_status');?>", value: "purchases5",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_sales_order');?>", value: "sales_order1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "sales_order1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_add_new_order');?>", value: "sales_order2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_edit_order');?>", value: "sales_order3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "sales_order4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_quote_orders');?>", value: "quote_order1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "quote_order1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_add_quote_order');?>", value: "quote_order2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_edit_quote');?>", value: "quote_order3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "quote_order4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_paid_orders');?>", value: "paid_orders",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_unpaid_orders');?>", value: "unpaid_orders",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_packed_orders');?>", value: "packed_orders",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_delivered_orders');?>", value: "delivered_orders",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_cancelled_orders');?>", value: "cancelled_orders",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_custom_fields');?>", value: "custom_fields",},
	//end1st
	]
	});
	
	jQuery("#treeview_r2").kendoTreeView({
	checkboxes: {
	checkChildren: true,
	template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text #</span></label>"
	},
	check: onCheck,
	dataSource: [
		//Employees
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.dashboard_employees');?>",  add_info: "", value: "hr_staff",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.dashboard_employees');?>", value: "staff2",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "staff2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "staff3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_view');?>", value: "staff4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "staff5",},
	]},
	
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_office_shifts');?>", value: "shift1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "shift1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "shift2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "shift3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "shift4",}
	]},

	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_employees_exit');?>", value: "staffexit1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "staffexit1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "staffexit2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "staffexit3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "staffexit4",},
<?php /*?>	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_view');?>", value: "staffexit5",}<?php */?>
	]},
	
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Employees.xin_exit_type');?>", value: "exit_type1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "exit_type1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "exit_type2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "exit_type3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "exit_type4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_employee_profile');?>", value: "hr_profile",items: [
	<?php /*?>{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_view').' '.lang('Employees.xin_contract');?>", value: "hr_contract",},<?php */?>
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit').' '.lang('Main.xin_employee_basic_title');?>", value: "hr_basic_info",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit').' '.lang('Main.xin_personal_info');?>", value: "hr_personal_info",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit').' '.lang('Main.xin_e_details_profile_picture');?>", value: "hr_picture",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit').' '.lang('Main.xin_account_info');?>", value: "account_info",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_view').' '.lang('Employees.xin_documents');?>", value: "hr_documents",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.header_change_password');?>", value: "change_password",},
	]},
	<?php /*?>{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_view').' '.lang('Dashboard.dashboard_request_calendar');?>", value: "request_calendar",},<?php */?>
	]},
	//Recruitment
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Recruitment.xin_recruitment_ats');?>",  add_info: "", value: "hr_ats",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Recruitment.xin_new_opening');?>", value: "ats2",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Recruitment.xin_jobs_list');?>", value: "ats2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "ats3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "ats4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "ats5",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Recruitment.xin_candidates');?>", value: "candidate",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Recruitment.xin_interviews');?>", value: "interview",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_promotions');?>", value: "promotion",},

	]},
	//CoreHR
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.dashboard_core_hr');?>",  add_info: "", value: "core_hr",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_announcements');?>", value: "news1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "news1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "news2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "news3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "news4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_department');?>", value: "department1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "department1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "department2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "department3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "department4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_designation');?>", value: "designation1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "designation1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "designation2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "designation3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "designation4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.header_policies');?>", value: "policy1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "policy1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "policy2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "policy3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "policy4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_view_policies');?>", value: "policy5",}
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_org_chart_title');?>", value: "org_chart",},
	]},
	//Attendance
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_attendance');?>",  add_info: "", value: "timesheet",  items: [
	
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_update_attendance');?>", value: "upattendance1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "upattendance1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "upattendance2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "upattendance3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "upattendance4",},
	]},
	
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_month_timesheet_title');?>", value: "monthly_time",},
	]},
	//Finance
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_hr_finance');?>",  add_info: "", value: "hr_finance",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Finance.xin_accounts');?>", value: "accounts1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "accounts1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "accounts2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "accounts3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "accounts4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_acc_deposit');?>", value: "deposit1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "deposit1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "deposit2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "deposit3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "deposit4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_acc_expense');?>", value: "expense1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "expense1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "expense2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "expense3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "expense4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_acc_transactions');?>", value: "transaction1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Finance.xin_dep_categories');?>", value: "dep_cat1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "dep_cat1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "dep_cat2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "dep_cat3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "dep_cat4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Finance.xin_exp_categories');?>", value: "exp_cat1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "exp_cat1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "exp_cat2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "exp_cat3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "exp_cat4",},
	]},
	]},
	
	//Performance (PMS)
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text:"<?= lang('Dashboard.left_talent_management');?>",add_info: "", value:"hr_talent", items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_performance_indicator');?>", value: "indicator1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "indicator1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "indicator2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "indicator3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "indicator4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_performance_appraisal');?>", value: "appraisal1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "appraisal1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "appraisal2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "appraisal3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "appraisal4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Performance.xin_competencies');?>", value: "competency1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "competency1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "competency2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "competency3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "competency4",},
	]},
	
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_hr_goal_tracking');?>", value: "tracking1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "tracking1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "tracking2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "tracking3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "tracking4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Performance.xin_update_rating');?>", value: "tracking5",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_hr_goal_tracking_type');?>", value: "track_type1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "track_type1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "track_type2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "track_type3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "track_type4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Performance.xin_goals_calendar');?>", value: "track_calendar",},
	]},
	
	//Clients
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_manage_clients');?>", value: "hr_clients",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "client1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "client2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "client3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "client4",},
	]},
	
	//Leads
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_leads');?>", value: "hr_leads",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "leads1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "leads2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "leads3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "leads4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_change_to_client');?>", value: "leads5",},
	]},
	
	//Invoices
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_invoices_title');?>", add_info: "", value: "hr_invoices",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Invoices.xin_billing_invoices');?>", value: "invoice1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "invoice2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Invoices.xin_create_new_invoices');?>", value: "invoice3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Invoices.xin_edit_invoice');?>", value: "invoice4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "invoice5",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_acc_invoice_payments');?>", value: "invoice_payments",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_acc_calendar');?>", value: "invoice_calendar",},
	
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_invoice_tax_type');?>", value: "tax_type1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "tax_type1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "tax_type2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "tax_type3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "tax_type4",},
	]},
	]},
	//Estimates
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_estimates');?>", value: "estimate1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "estimate2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_create_new_estimate');?>", value: "estimate3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit_estimate');?>", value: "estimate4",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "estimate5",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_convert_estimate_to_invoice');?>", value: "estimate6",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_cancel_estimate');?>", value: "estimate7",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_quote_calendar');?>", value: "estimates_calendar",},
	]
	},
	//Events
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_hr_events');?>",  add_info: "", value: "hr_events",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_hr_events');?>", value: "hr_event1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "hr_event1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "hr_event2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "hr_event3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "hr_event4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Conference.xin_events_calendar');?>", value: "events_calendar",},
	]},
	//Conference Booking
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_hr_meetings');?>",  add_info: "", value: "hr_conference",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_hr_meetings');?>", value: "conference1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "conference1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "conference2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "conference3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "conference4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Conference.xin_conference_calendar');?>", value: "conference_calendar",},
	]},
	//Holidays
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_holidays');?>",  add_info: "", value: "hr_holidays",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_holidays');?>", value: "holiday1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "holiday1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "holiday2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "holiday3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "holiday4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Employees.xin_holidays_calendar');?>", value: "holidays_calendar",},
	]},
	//Visitor Book
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_visitor_book');?>", value: "hr_visitors",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "visitor1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "visitor2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "visitor3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "visitor4",},
	]},
	//Documents Manager
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_upload_files');?>",  add_info: "", value: "hr_files",  items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Employees.xin_general_documents');?>", value: "file1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "file1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "file2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "file3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "file4",},
	]},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Employees.xin_official_documents');?>", value: "officialfile1",items: [
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "officialfile1",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "officialfile2",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "officialfile3",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "officialfile4",},
	]},
	]},
	
<?php /*?>		
	//Company Settings
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_company_settings');?>", value: "company_settings",},<?php */?>
	//Todo List
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_todo_ist');?>", value: "todo_ist",},
	//System Calendar
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_system_calendar');?>", value: "system_calendar",},
	//System Reports
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_system_reports');?>", value: "system_reports",},
//
]
});
//});
// show checked node IDs on datasource change
function onCheck() {
var checkedNodes = [],
		treeView = jQuery("#treeview2").data("kendoTreeView"),
		message;
		jQuery("#result").html(message);
}
</script>