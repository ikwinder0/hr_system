<?php
use App\Models\UsersModel;
use App\Models\RolesModel;
use App\Models\MembershipModel;
use App\Models\CompanymembershipModel;
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$MembershipModel = new MembershipModel();
$CompanymembershipModel = new CompanymembershipModel();
$request = \Config\Services::request();
$session = \Config\Services::session();
$router = service('router');
$usession = $session->get('sup_username');

if($request->getGet('data') === 'role' && $request->getGet('field_id')){
$role_id = udecode($field_id);
$result = $RolesModel->where('role_id', $role_id)->first();
$role_resources_ids = explode(',',$result['role_resources']);
?>
<?php
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$cmembership = $CompanymembershipModel->where('company_id', $user_info['company_id'])->first();
} else {
	$cmembership = $CompanymembershipModel->where('company_id', $usession['sup_user_id'])->first();
}
$mem_info = $MembershipModel->where('membership_id', $cmembership['membership_id'])->first();
//$modules_permission = unserialize($mem_info['modules_permission']);
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Users.xin_role_staff_edit');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_role', 'id' => 'edit_role', 'autocomplete' => 'off','class' => '"m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/roles/update_role', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="role_name">
          <?= lang('Users.xin_role_name');?>
          <span class="text-danger">*</span> </label>
        <input class="form-control" placeholder="<?= lang('Users.xin_role_name');?>" name="role_name" type="text" value="<?= $result['role_name'];?>">
      </div>
    </div>
    <input type="checkbox" name="role_resources[]" value="0" checked style="display:none;"/>
    <div class="col-md-6">
      <div class="form-group">
        <label for="role_access">
          <?= lang('Users.xin_role_access');?>
          <span class="text-danger">*</span> </label>
        <select class="form-control custom-select" id="role_access_modal" name="role_access" data-plugin="select_hrm" data-placeholder="<?= lang('Users.xin_role_access');?>">
          <option value="">&nbsp;</option>
          <option value="2" <?php if($result['role_access']==2):?> selected="selected" <?php endif;?>>
          <?= lang('Users.xin_role_cmenu');?>
          </option>
          <option value="1" <?php if($result['role_access']==1):?> selected="selected" <?php endif;?>>
          <?= lang('Users.xin_role_all_menu');?>
          </option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="resources"> <?= lang('Staff Apps');?></label>
              <div id="all_resources">
                <div class="demo-section k-content">
                  <div>
                    <div id="treeview_m1"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    	<div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
            <label for="resources"> <?= lang('Company Apps');?></label>
              <div id="all_resources">
                <div class="demo-section k-content">
                  <div>
                    <div id="treeview_m2"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>

</div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_update');?>
  </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		Ladda.bind('button[type=submit]');
		/* Edit data */
		$("#edit_role").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');			
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=edit_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?= site_url("erp/roles/staff_roles_list") ?>",
							type : 'GET'
						},
						"language": {
							"lengthMenu": dt_lengthMenu,
							"zeroRecords": dt_zeroRecords,
							"info": dt_info,
							"infoEmpty": dt_infoEmpty,
							"infoFiltered": dt_infoFiltered,
							"search": dt_search,
							"paginate": {
								"first": dt_first,
								"previous": dt_previous,
								"next": dt_next,
								"last": dt_last
							},
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.edit-modal-data').modal('toggle');
					Ladda.stopAll();
				}
			}
		});
	});
});	
</script> 
<script>
$(document).ready(function(){
	$("#role_access_modal").change(function(){
		var sel_val = $(this).val();
		if(sel_val=='1') {
			$('.role-checkbox-modal').prop('checked', true);
		} else {
			$('.role-checkbox-modal').prop("checked", false);
		}
	});
});
</script> 
<script type="text/javascript">
//$(document).ready(function(){
	jQuery("#treeview_m1").kendoTreeView({
	checkboxes: {
	checkChildren: true,
	template: "<label class='custom-control custom-checkbox' ><input type='checkbox' #= item.check# class='#= item.class #'  name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text #</span></label>"
	},
	check: onCheck,
	dataSource: [
	// Attendance
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_attendance');?>", value: "attendance", check: "<?php if(isset($role_id)) { if(in_array('attendance',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	//Projects
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_projects');?>", add_info: "",  check: "<?php if(isset($role_id)) { if(in_array('hr_projects',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "hr_projects",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_projects');?>", value: "project1", check: "<?php if(isset($role_id)) { if(in_array('project1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "project1", check: "<?php if(isset($role_id)) { if(in_array('project1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "project2", check: "<?php if(isset($role_id)) { if(in_array('project2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "project3", check: "<?php if(isset($role_id)) { if(in_array('project3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "project4", check: "<?php if(isset($role_id)) { if(in_array('project4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_update_status');?>", value: "project5", check: "<?php if(isset($role_id)) { if(in_array('project5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Projects.xin_discussion');?>", value: "project6", check: "<?php if(isset($role_id)) { if(in_array('project6',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Projects.xin_bugs');?>", value: "project7", check: "<?php if(isset($role_id)) { if(in_array('project7',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Projects.xin_tasks');?>", value: "project8", check: "<?php if(isset($role_id)) { if(in_array('project8',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Projects.xin_attach_files');?>", value: "project9", check: "<?php if(isset($role_id)) { if(in_array('project9',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Projects.xin_note');?>", value: "project10", check: "<?php if(isset($role_id)) { if(in_array('project10',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_project_timelogs');?>", value: "project11", check: "<?php if(isset($role_id)) { if(in_array('project11',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Projects.xin_projects_calendar');?>", value: "projects_calendar", check: "<?php if(isset($role_id)) { if(in_array('projects_calendar',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Projects.xin_projects_kanban_board');?>", value: "projects_sboard", check: "<?php if(isset($role_id)) { if(in_array('projects_sboard',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	//Tasks
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_tasks');?>", add_info: "",  check: "<?php if(isset($role_id)) { if(in_array('hr_tasks',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "hr_tasks",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_tasks');?>", value: "task1", check: "<?php if(isset($role_id)) { if(in_array('task1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "task1", check: "<?php if(isset($role_id)) { if(in_array('task1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "task2", check: "<?php if(isset($role_id)) { if(in_array('task2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "task3", check: "<?php if(isset($role_id)) { if(in_array('task3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "task4", check: "<?php if(isset($role_id)) { if(in_array('task4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_update_status');?>", value: "task5",check: "<?php if(isset($role_id)) { if(in_array('task5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Projects.xin_discussion');?>", value: "task6",check: "<?php if(isset($role_id)) { if(in_array('task6',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Projects.xin_attach_files');?>", value: "task7",check: "<?php if(isset($role_id)) { if(in_array('task7',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Projects.xin_note');?>", value: "task8",check: "<?php if(isset($role_id)) { if(in_array('task8',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_tasks_calendar');?>", value: "tasks_calendar", check: "<?php if(isset($role_id)) { if(in_array('tasks_calendar',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_tasks_sboard');?>", value: "tasks_sboard", check: "<?php if(isset($role_id)) { if(in_array('tasks_sboard',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	//Payroll
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_payroll');?>",  add_info: "",  check: "<?php if(isset($role_id)) { if(in_array('hr_payroll',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "hr_payroll",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Payroll.xin_setup_payroll');?>", value: "pay1", check: "<?php if(isset($role_id)) { if(in_array('pay1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_payroll_list');?>", value: "pay1", check: "<?php if(isset($role_id)) { if(in_array('pay1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_generate_payslip');?>", value: "pay2", check: "<?php if(isset($role_id)) { if(in_array('pay2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "pay3", check: "<?php if(isset($role_id)) { if(in_array('pay3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_payslip_history');?>", value: "pay_history", check: "<?php if(isset($role_id)) { if(in_array('pay_history',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_advance_salary');?>", value: "hradvance_salary", check: "<?php if(isset($role_id)) { if(in_array('hradvance_salary',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "advance_salary1", check: "<?php if(isset($role_id)) { if(in_array('advance_salary1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_request_advance_salary');?>", value: "advance_salary2", check: "<?php if(isset($role_id)) { if(in_array('advance_salary2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "advance_salary3", check: "<?php if(isset($role_id)) { if(in_array('advance_salary3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "advance_salary4", check: "<?php if(isset($role_id)) { if(in_array('advance_salary4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_loan');?>", value: "hrloan", check: "<?php if(isset($role_id)) { if(in_array('hrloan',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "loan1", check: "<?php if(isset($role_id)) { if(in_array('loan1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_request_advance_salary');?>", value: "loan2", check: "<?php if(isset($role_id)) { if(in_array('loan2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "loan3", check: "<?php if(isset($role_id)) { if(in_array('loan3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "loan4", check: "<?php if(isset($role_id)) { if(in_array('loan4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	]},
	//Helpdesk
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.dashboard_helpdesk');?>", value: "hr_helpdesk", check: "<?php if(isset($role_id)) { if(in_array('hr_helpdesk',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "helpdesk1", check: "<?php if(isset($role_id)) { if(in_array('helpdesk1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_create_ticket');?>", value: "helpdesk2", check: "<?php if(isset($role_id)) { if(in_array('helpdesk2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "helpdesk3", check: "<?php if(isset($role_id)) { if(in_array('helpdesk3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_view_ticket');?>", value: "helpdesk4", check: "<?php if(isset($role_id)) { if(in_array('helpdesk4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "helpdesk5", check: "<?php if(isset($role_id)) { if(in_array('helpdesk5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_update_status');?>", value: "helpdesk6",check: "<?php if(isset($role_id)) { if(in_array('helpdesk6',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Projects.xin_attach_files');?>", value: "helpdesk7",check: "<?php if(isset($role_id)) { if(in_array('helpdesk7',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Projects.xin_note');?>", value: "helpdesk8",check: "<?php if(isset($role_id)) { if(in_array('helpdesk8',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}
	]},
	//Training Sessions
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_training');?>", add_info: "",  check: "<?php if(isset($role_id)) { if(in_array('hr_training',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "hr_training",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_training');?>", value: "training1", check: "<?php if(isset($role_id)) { if(in_array('training1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "training2", check: "<?php if(isset($role_id)) { if(in_array('training2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "training3", check: "<?php if(isset($role_id)) { if(in_array('training3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "training4", check: "<?php if(isset($role_id)) { if(in_array('training4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "training6", check: "<?php if(isset($role_id)) { if(in_array('training6',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Projects.xin_note');?>", value: "training5",check: "<?php if(isset($role_id)) { if(in_array('training5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox custom-control-input input-light-primary", text: "<?= lang('Main.xin_update_status');?>", value: "training7",check: "<?php if(isset($role_id)) { if(in_array('training7',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_trainers');?>", value: "trainer1", check: "<?php if(isset($role_id)) { if(in_array('trainer1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "trainer1", check: "<?php if(isset($role_id)) { if(in_array('trainer1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "trainer2", check: "<?php if(isset($role_id)) { if(in_array('trainer2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "trainer3", check: "<?php if(isset($role_id)) { if(in_array('trainer3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "trainer4", check: "<?php if(isset($role_id)) { if(in_array('trainer4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_training_skills');?>", value: "training_skill1", check: "<?php if(isset($role_id)) { if(in_array('training_skill1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "training_skill1", check: "<?php if(isset($role_id)) { if(in_array('training_skill1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "training_skill2", check: "<?php if(isset($role_id)) { if(in_array('training_skill2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "training_skill3", check: "<?php if(isset($role_id)) { if(in_array('training_skill3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "training_skill4", check: "<?php if(isset($role_id)) { if(in_array('training_skill4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_training_calendar');?>", value: "training_calendar", check: "<?php if(isset($role_id)) { if(in_array('training_calendar',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	//Assets
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_assets');?>",  add_info: "", value: "hr_assets", check: "<?php if(isset($role_id)) { if(in_array('hr_assets',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_assets');?>", value: "asset1", check: "<?php if(isset($role_id)) { if(in_array('asset1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "asset1", check: "<?php if(isset($role_id)) { if(in_array('asset1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "asset2", check: "<?php if(isset($role_id)) { if(in_array('asset2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "asset3", check: "<?php if(isset($role_id)) { if(in_array('asset3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "asset4", check: "<?php if(isset($role_id)) { if(in_array('asset4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_category');?>", value: "asset_cat1", check: "<?php if(isset($role_id)) { if(in_array('asset_cat1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "asset_cat1", check: "<?php if(isset($role_id)) { if(in_array('asset_cat1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "asset_cat2", check: "<?php if(isset($role_id)) { if(in_array('asset_cat2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "asset_cat3", check: "<?php if(isset($role_id)) { if(in_array('asset_cat3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "asset_cat4", check: "<?php if(isset($role_id)) { if(in_array('asset_cat4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Asset.xin_brands');?>", value: "asset_brand1", check: "<?php if(isset($role_id)) { if(in_array('asset_brand1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "asset_brand1", check: "<?php if(isset($role_id)) { if(in_array('asset_brand1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "asset_brand2", check: "<?php if(isset($role_id)) { if(in_array('asset_brand2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "asset_brand3", check: "<?php if(isset($role_id)) { if(in_array('asset_brand3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "asset_brand4", check: "<?php if(isset($role_id)) { if(in_array('asset_brand4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}
	]},
	]},
	//Awards
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_awards');?>",  add_info: "", value: "hr_awards", check: "<?php if(isset($role_id)) { if(in_array('hr_awards',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_awards');?>", value: "award1", check: "<?php if(isset($role_id)) { if(in_array('award1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "award1", check: "<?php if(isset($role_id)) { if(in_array('award1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "award2", check: "<?php if(isset($role_id)) { if(in_array('award2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "award3", check: "<?php if(isset($role_id)) { if(in_array('award3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "award4", check: "<?php if(isset($role_id)) { if(in_array('award4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Employees.xin_award_type');?>", value: "award_type1", check: "<?php if(isset($role_id)) { if(in_array('award_type1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "award_type1", check: "<?php if(isset($role_id)) { if(in_array('award_type1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "award_type2", check: "<?php if(isset($role_id)) { if(in_array('award_type2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "award_type3", check: "<?php if(isset($role_id)) { if(in_array('award_type3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "award_type4", check: "<?php if(isset($role_id)) { if(in_array('award_type4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}
	]},
	]},
	//Travel
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_travels');?>",  add_info: "",  check: "<?php if(isset($role_id)) { if(in_array('hr_travel',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "hr_travel",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_travels');?>", value: "travel1", check: "<?php if(isset($role_id)) { if(in_array('travel1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "travel1", check: "<?php if(isset($role_id)) { if(in_array('travel1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "travel2", check: "<?php if(isset($role_id)) { if(in_array('travel2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "travel3", check: "<?php if(isset($role_id)) { if(in_array('travel3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "travel4", check: "<?php if(isset($role_id)) { if(in_array('travel4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_update_status');?>", value: "travel5", check: "<?php if(isset($role_id)) { if(in_array('travel5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Employees.xin_arragement_type');?>", value: "travel_type1", check: "<?php if(isset($role_id)) { if(in_array('travel_type1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "travel_type1", check: "<?php if(isset($role_id)) { if(in_array('travel_type1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "travel_type2", check: "<?php if(isset($role_id)) { if(in_array('travel_type2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "travel_type3", check: "<?php if(isset($role_id)) { if(in_array('travel_type3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "travel_type4", check: "<?php if(isset($role_id)) { if(in_array('travel_type4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Employees.xin_travel_calendar');?>",  check: "<?php if(isset($role_id)) { if(in_array('travel_calendar',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "travel_calendar",},
	]},
	//Manage Leave
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Leave.left_leave_request');?>", add_info: "",  check: "<?php if(isset($role_id)) { if(in_array('hr_leave',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "hr_leave",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_manage_leaves');?>", value: "leave1", check: "<?php if(isset($role_id)) { if(in_array('leave1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "leave2", check: "<?php if(isset($role_id)) { if(in_array('leave2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "leave3", check: "<?php if(isset($role_id)) { if(in_array('leave3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "leave4", check: "<?php if(isset($role_id)) { if(in_array('leave4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "leave6", check: "<?php if(isset($role_id)) { if(in_array('leave6',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_update_status');?>", value: "leave7", check: "<?php if(isset($role_id)) { if(in_array('leave7',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Leave.xin_leave_calendar');?>", value: "leave_calendar", check: "<?php if(isset($role_id)) { if(in_array('leave_calendar',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Leave.xin_leave_type');?>", value: "leave_type1", check: "<?php if(isset($role_id)) { if(in_array('leave_type1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "leave_type1", check: "<?php if(isset($role_id)) { if(in_array('leave_type1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "leave_type2", check: "<?php if(isset($role_id)) { if(in_array('leave_type2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "leave_type3", check: "<?php if(isset($role_id)) { if(in_array('leave_type3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "leave_type4", check: "<?php if(isset($role_id)) { if(in_array('leave_type4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	]},
	// Overtime Request
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_overtime_request');?>", value: "overtime_req1", check: "<?php if(isset($role_id)) { if(in_array('overtime_req1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "overtime_req1", check: "<?php if(isset($role_id)) { if(in_array('overtime_req1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "overtime_req2", check: "<?php if(isset($role_id)) { if(in_array('overtime_req2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "overtime_req3", check: "<?php if(isset($role_id)) { if(in_array('overtime_req3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "overtime_req4", check: "<?php if(isset($role_id)) { if(in_array('overtime_req4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	//Complaints
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_complaints');?>", value: "hr_complaints", check: "<?php if(isset($role_id)) { if(in_array('hr_complaints',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "complaint1", check: "<?php if(isset($role_id)) { if(in_array('complaint1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "complaint2", check: "<?php if(isset($role_id)) { if(in_array('complaint2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "complaint3", check: "<?php if(isset($role_id)) { if(in_array('complaint3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "complaint4", check: "<?php if(isset($role_id)) { if(in_array('complaint4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	//Resignations
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_resignations');?>", value: "hr_resignations", check: "<?php if(isset($role_id)) { if(in_array('hr_resignations',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "resignation1", check: "<?php if(isset($role_id)) { if(in_array('resignation1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "resignation2", check: "<?php if(isset($role_id)) { if(in_array('resignation2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "resignation3", check: "<?php if(isset($role_id)) { if(in_array('resignation3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "resignation4", check: "<?php if(isset($role_id)) { if(in_array('resignation4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	//Disciplinary Cases 
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_warnings');?>", add_info: "",  check: "<?php if(isset($role_id)) { if(in_array('hr_disciplinary',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "hr_disciplinary",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_warnings');?>", value: "disciplinary1", check: "<?php if(isset($role_id)) { if(in_array('disciplinary1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "disciplinary1", check: "<?php if(isset($role_id)) { if(in_array('disciplinary1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "disciplinary2", check: "<?php if(isset($role_id)) { if(in_array('disciplinary2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "disciplinary3", check: "<?php if(isset($role_id)) { if(in_array('disciplinary3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "disciplinary5", check: "<?php if(isset($role_id)) { if(in_array('disciplinary5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Employees.xin_case_type');?>", value: "case_type1", check: "<?php if(isset($role_id)) { if(in_array('case_type1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "case_type1", check: "<?php if(isset($role_id)) { if(in_array('case_type1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "case_type2", check: "<?php if(isset($role_id)) { if(in_array('case_type2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "case_type3", check: "<?php if(isset($role_id)) { if(in_array('case_type3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "case_type4", check: "<?php if(isset($role_id)) { if(in_array('case_type4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	]},
	//Transfers 
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_transfers');?>", value: "hr_transfers", check: "<?php if(isset($role_id)) { if(in_array('hr_transfers',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "transfers1", check: "<?php if(isset($role_id)) { if(in_array('transfers1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "transfers2", check: "<?php if(isset($role_id)) { if(in_array('transfers2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "transfers3", check: "<?php if(isset($role_id)) { if(in_array('transfers3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "transfers4", check: "<?php if(isset($role_id)) { if(in_array('transfers4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	//Settings 
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.left_settings');?>", value: "hr_settings", check: "<?php if(isset($role_id)) { if(in_array('hr_settings',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.left_settings');?>", value: "settings1", check: "<?php if(isset($role_id)) { if(in_array('settings1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.left_constants');?>", value: "settings2", check: "<?php if(isset($role_id)) { if(in_array('settings2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.left_email_templates');?>", value: "settings3", check: "<?php if(isset($role_id)) { if(in_array('settings3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_multi_language');?>", value: "settings4", check: "<?php if(isset($role_id)) { if(in_array('settings4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.header_db_log');?>", value: "settings5", check: "<?php if(isset($role_id)) { if(in_array('settings5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_currency_converter');?>", value: "settings6", check: "<?php if(isset($role_id)) { if(in_array('settings6',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_sms_templates');?>", value: "settings7", check: "<?php if(isset($role_id)) { if(in_array('settings7',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	//Inventory Control
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_inventory_control');?>", add_info: "", value: "hr_inventory_control",  check: "<?php if(isset($role_id)) { if(in_array('hr_inventory_control',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_warehouses');?>", value: "warehouse1", check: "<?php if(isset($role_id)) { if(in_array('warehouse1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "warehouse1", check: "<?php if(isset($role_id)) { if(in_array('warehouse1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "warehouse2", check: "<?php if(isset($role_id)) { if(in_array('warehouse2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "warehouse3", check: "<?php if(isset($role_id)) { if(in_array('warehouse3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "warehouse4", check: "<?php if(isset($role_id)) { if(in_array('warehouse4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_products');?>", value: "product1", check: "<?php if(isset($role_id)) { if(in_array('product1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "product1", check: "<?php if(isset($role_id)) { if(in_array('product1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "product2", check: "<?php if(isset($role_id)) { if(in_array('product2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "product3", check: "<?php if(isset($role_id)) { if(in_array('product3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "product4", check: "<?php if(isset($role_id)) { if(in_array('product4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_out_of_stock');?>", value: "out_of_stock", check: "<?php if(isset($role_id)) { if(in_array('out_of_stock',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_expired_products');?>", value: "expired_product", check: "<?php if(isset($role_id)) { if(in_array('expired_product',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_product_category');?>", value: "product_category1", check: "<?php if(isset($role_id)) { if(in_array('product_category1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "product_category1", check: "<?php if(isset($role_id)) { if(in_array('product_category1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "product_category2", check: "<?php if(isset($role_id)) { if(in_array('product_category2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "product_category3", check: "<?php if(isset($role_id)) { if(in_array('product_category3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "product_category4", check: "<?php if(isset($role_id)) { if(in_array('product_category4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_suppliers');?>", value: "supplier1", check: "<?php if(isset($role_id)) { if(in_array('supplier1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "supplier1", check: "<?php if(isset($role_id)) { if(in_array('supplier1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "supplier2", check: "<?php if(isset($role_id)) { if(in_array('supplier2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "supplier3", check: "<?php if(isset($role_id)) { if(in_array('supplier3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "supplier4", check: "<?php if(isset($role_id)) { if(in_array('supplier4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_purchases');?>", value: "purchases1", check: "<?php if(isset($role_id)) { if(in_array('purchases1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "purchases1", check: "<?php if(isset($role_id)) { if(in_array('purchases1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_new_purchase');?>", value: "purchases2", check: "<?php if(isset($role_id)) { if(in_array('purchases2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_edit_purchase');?>", value: "purchases3", check: "<?php if(isset($role_id)) { if(in_array('purchases3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "purchases4", check: "<?php if(isset($role_id)) { if(in_array('purchases4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_update_status');?>", value: "purchases5", check: "<?php if(isset($role_id)) { if(in_array('purchases5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_sales_order');?>", value: "sales_order1", check: "<?php if(isset($role_id)) { if(in_array('sales_order1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "sales_order1", check: "<?php if(isset($role_id)) { if(in_array('sales_order1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_add_new_order');?>", value: "sales_order2", check: "<?php if(isset($role_id)) { if(in_array('sales_order2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_edit_order');?>", value: "sales_order3", check: "<?php if(isset($role_id)) { if(in_array('sales_order3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "sales_order4", check: "<?php if(isset($role_id)) { if(in_array('sales_order4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_quote_orders');?>", value: "quote_order1", check: "<?php if(isset($role_id)) { if(in_array('quote_order1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "quote_order1", check: "<?php if(isset($role_id)) { if(in_array('quote_order1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_add_quote_order');?>", value: "quote_order2", check: "<?php if(isset($role_id)) { if(in_array('quote_order2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_edit_quote');?>", value: "quote_order3", check: "<?php if(isset($role_id)) { if(in_array('quote_order3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "quote_order4", check: "<?php if(isset($role_id)) { if(in_array('quote_order4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_paid_orders');?>", value: "paid_orders", check: "<?php if(isset($role_id)) { if(in_array('paid_orders',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_unpaid_orders');?>", value: "unpaid_orders", check: "<?php if(isset($role_id)) { if(in_array('unpaid_orders',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_packed_orders');?>", value: "packed_orders", check: "<?php if(isset($role_id)) { if(in_array('packed_orders',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_delivered_orders');?>", value: "delivered_orders", check: "<?php if(isset($role_id)) { if(in_array('delivered_orders',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Inventory.xin_cancelled_orders');?>", value: "cancelled_orders", check: "<?php if(isset($role_id)) { if(in_array('cancelled_orders',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_custom_fields');?>", value: "custom_fields", check: "<?php if(isset($role_id)) { if(in_array('custom_fields',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]
	});
	
	jQuery("#treeview_m2").kendoTreeView({
	checkboxes: {
	checkChildren: true,
	template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text #</span></label>"
	},
	check: onCheck,
	dataSource: [
		//Employees
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.dashboard_employees');?>",  add_info: "", value: "hr_staff", check: "<?php if(isset($role_id)) { if(in_array('hr_staff',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.dashboard_employees');?>", value: "staff2", check: "<?php if(isset($role_id)) { if(in_array('staff2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "staff2", check: "<?php if(isset($role_id)) { if(in_array('staff2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "staff3", check: "<?php if(isset($role_id)) { if(in_array('staff3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_view');?>", value: "staff4", check: "<?php if(isset($role_id)) { if(in_array('staff4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "staff5", check: "<?php if(isset($role_id)) { if(in_array('staff5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	
	]},
	
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_office_shifts');?>", value: "shift1", check: "<?php if(isset($role_id)) { if(in_array('shift1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "shift1", check: "<?php if(isset($role_id)) { if(in_array('shift1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "shift2", check: "<?php if(isset($role_id)) { if(in_array('shift2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "shift3", check: "<?php if(isset($role_id)) { if(in_array('shift3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "shift4", check: "<?php if(isset($role_id)) { if(in_array('shift4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}
	]},

	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_employees_exit');?>", value: "staffexit1", check: "<?php if(isset($role_id)) { if(in_array('staffexit1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "staffexit1",check: "<?php if(isset($role_id)) { if(in_array('staffexit1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "staffexit2",check: "<?php if(isset($role_id)) { if(in_array('staffexit2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "staffexit3",check: "<?php if(isset($role_id)) { if(in_array('staffexit3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "staffexit4",check: "<?php if(isset($role_id)) { if(in_array('staffexit4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	<?php /*?>{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_view');?>", value: "staffexit5", check: "<?php if(isset($role_id)) { if(in_array('staffexit5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}<?php */?>
	]},
	
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Employees.xin_exit_type');?>", value: "exit_type1", check: "<?php if(isset($role_id)) { if(in_array('exit_type1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "exit_type1", check: "<?php if(isset($role_id)) { if(in_array('exit_type1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "exit_type2", check: "<?php if(isset($role_id)) { if(in_array('exit_type2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "exit_type3", check: "<?php if(isset($role_id)) { if(in_array('exit_type3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "exit_type4", check: "<?php if(isset($role_id)) { if(in_array('exit_type4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_employee_profile');?>", value: "hr_profile", check: "<?php if(isset($role_id)) { if(in_array('hr_profile',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	<?php /*?>{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_view').' '.lang('Employees.xin_contract');?>", value: "hr_contract", check: "<?php if(isset($role_id)) { if(in_array('hr_contract',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},<?php */?>
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit').' '.lang('Main.xin_employee_basic_title');?>", value: "hr_basic_info", check: "<?php if(isset($role_id)) { if(in_array('hr_basic_info',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit').' '.lang('Main.xin_personal_info');?>", value: "hr_personal_info", check: "<?php if(isset($role_id)) { if(in_array('hr_personal_info',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit').' '.lang('Main.xin_e_details_profile_picture');?>", value: "hr_picture", check: "<?php if(isset($role_id)) { if(in_array('hr_picture',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit').' '.lang('Main.xin_account_info');?>", value: "account_info", check: "<?php if(isset($role_id)) { if(in_array('account_info',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_view').' '.lang('Employees.xin_documents');?>", value: "hr_documents", check: "<?php if(isset($role_id)) { if(in_array('hr_documents',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.header_change_password');?>", value: "change_password",check: "<?php if(isset($role_id)) { if(in_array('change_password',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	<?php /*?>{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_view').' '.lang('Dashboard.dashboard_request_calendar');?>", value: "request_calendar", check: "<?php if(isset($role_id)) { if(in_array('request_calendar',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},<?php */?>
	]},
	//Recruitment
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Recruitment.xin_recruitment_ats');?>",  add_info: "", value: "hr_ats", check: "<?php if(isset($role_id)) { if(in_array('hr_ats',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Recruitment.xin_new_opening');?>", value: "ats2", check: "<?php if(isset($role_id)) { if(in_array('ats2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Recruitment.xin_jobs_list');?>", value: "ats2", check: "<?php if(isset($role_id)) { if(in_array('ats2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "ats3", check: "<?php if(isset($role_id)) { if(in_array('ats3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "ats4", check: "<?php if(isset($role_id)) { if(in_array('ats4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "ats5", check: "<?php if(isset($role_id)) { if(in_array('ats5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Recruitment.xin_candidates');?>", value: "candidate", check: "<?php if(isset($role_id)) { if(in_array('candidate',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Recruitment.xin_interviews');?>", value: "interview", check: "<?php if(isset($role_id)) { if(in_array('interview',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_promotions');?>", value: "promotion", check: "<?php if(isset($role_id)) { if(in_array('promotion',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},

	]},
	//CoreHR
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.dashboard_core_hr');?>",  add_info: "", value: "core_hr", check: "<?php if(isset($role_id)) { if(in_array('core_hr',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_announcements');?>", value: "news1",check: "<?php if(isset($role_id)) { if(in_array('news1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "news1", check: "<?php if(isset($role_id)) { if(in_array('news1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "news2", check: "<?php if(isset($role_id)) { if(in_array('news2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "news3", check: "<?php if(isset($role_id)) { if(in_array('news3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "news4", check: "<?php if(isset($role_id)) { if(in_array('news4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_department');?>", value: "department1", check: "<?php if(isset($role_id)) { if(in_array('department1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "department1", check: "<?php if(isset($role_id)) { if(in_array('department1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "department2", check: "<?php if(isset($role_id)) { if(in_array('department2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "department3", check: "<?php if(isset($role_id)) { if(in_array('department3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "department4", check: "<?php if(isset($role_id)) { if(in_array('department4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_designation');?>", value: "designation1", check: "<?php if(isset($role_id)) { if(in_array('designation1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "designation1", check: "<?php if(isset($role_id)) { if(in_array('designation1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "designation2", check: "<?php if(isset($role_id)) { if(in_array('designation2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "designation3", check: "<?php if(isset($role_id)) { if(in_array('designation3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "designation4", check: "<?php if(isset($role_id)) { if(in_array('designation4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.header_policies');?>", value: "policy1", check: "<?php if(isset($role_id)) { if(in_array('policy1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "policy1", check: "<?php if(isset($role_id)) { if(in_array('policy1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "policy2", check: "<?php if(isset($role_id)) { if(in_array('policy2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "policy3", check: "<?php if(isset($role_id)) { if(in_array('policy3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "policy4", check: "<?php if(isset($role_id)) { if(in_array('policy4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_view_policies');?>", value: "policy5", check: "<?php if(isset($role_id)) { if(in_array('policy5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_org_chart_title');?>", value: "org_chart",check: "<?php if(isset($role_id)) { if(in_array('org_chart',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	//Attendance
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_attendance');?>",  add_info: "", value: "timesheet", check: "<?php if(isset($role_id)) { if(in_array('timesheet',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_update_attendance');?>", value: "upattendance1", check: "<?php if(isset($role_id)) { if(in_array('upattendance1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "upattendance1", check: "<?php if(isset($role_id)) { if(in_array('upattendance1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "upattendance2", check: "<?php if(isset($role_id)) { if(in_array('upattendance2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "upattendance3", check: "<?php if(isset($role_id)) { if(in_array('upattendance3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "upattendance4", check: "<?php if(isset($role_id)) { if(in_array('upattendance4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_month_timesheet_title');?>", value: "monthly_time", check: "<?php if(isset($role_id)) { if(in_array('monthly_time',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	//Finance
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_hr_finance');?>",  add_info: "", value: "hr_finance", check: "<?php if(isset($role_id)) { if(in_array('hr_finance',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Finance.xin_accounts');?>", value: "accounts1", check: "<?php if(isset($role_id)) { if(in_array('accounts1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "accounts1", check: "<?php if(isset($role_id)) { if(in_array('accounts1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "accounts2", check: "<?php if(isset($role_id)) { if(in_array('accounts2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "accounts3", check: "<?php if(isset($role_id)) { if(in_array('accounts3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "accounts4", check: "<?php if(isset($role_id)) { if(in_array('accounts4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_acc_deposit');?>", value: "deposit1", check: "<?php if(isset($role_id)) { if(in_array('deposit1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "deposit1", check: "<?php if(isset($role_id)) { if(in_array('deposit1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "deposit2", check: "<?php if(isset($role_id)) { if(in_array('deposit2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "deposit3", check: "<?php if(isset($role_id)) { if(in_array('deposit3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "deposit4", check: "<?php if(isset($role_id)) { if(in_array('deposit4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_acc_expense');?>", value: "expense1", check: "<?php if(isset($role_id)) { if(in_array('expense1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "expense1", check: "<?php if(isset($role_id)) { if(in_array('expense1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "expense2", check: "<?php if(isset($role_id)) { if(in_array('expense2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "expense3", check: "<?php if(isset($role_id)) { if(in_array('expense3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "expense4", check: "<?php if(isset($role_id)) { if(in_array('expense4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_acc_transactions');?>", value: "transaction1", check: "<?php if(isset($role_id)) { if(in_array('transaction1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", },
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Finance.xin_dep_categories');?>", value: "dep_cat1", check: "<?php if(isset($role_id)) { if(in_array('dep_cat1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "dep_cat1", check: "<?php if(isset($role_id)) { if(in_array('dep_cat1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "dep_cat2", check: "<?php if(isset($role_id)) { if(in_array('dep_cat2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "dep_cat3", check: "<?php if(isset($role_id)) { if(in_array('dep_cat3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "dep_cat4", check: "<?php if(isset($role_id)) { if(in_array('dep_cat4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Finance.xin_exp_categories');?>", value: "exp_cat1", check: "<?php if(isset($role_id)) { if(in_array('exp_cat1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "exp_cat1", check: "<?php if(isset($role_id)) { if(in_array('exp_cat1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "exp_cat2", check: "<?php if(isset($role_id)) { if(in_array('exp_cat2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "exp_cat3", check: "<?php if(isset($role_id)) { if(in_array('exp_cat3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "exp_cat4", check: "<?php if(isset($role_id)) { if(in_array('exp_cat4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	]},
	
	//Performance (PMS)
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text:"<?= lang('Dashboard.left_talent_management');?>",add_info: "",  check: "<?php if(isset($role_id)) { if(in_array('hr_talent',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value:"hr_talent", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_performance_indicator');?>",  check: "<?php if(isset($role_id)) { if(in_array('indicator1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "indicator1",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "indicator1", check: "<?php if(isset($role_id)) { if(in_array('indicator1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "indicator2", check: "<?php if(isset($role_id)) { if(in_array('indicator2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "indicator3", check: "<?php if(isset($role_id)) { if(in_array('indicator3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "indicator4", check: "<?php if(isset($role_id)) { if(in_array('indicator4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_performance_appraisal');?>",  check: "<?php if(isset($role_id)) { if(in_array('appraisal1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "appraisal1",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "appraisal1", check: "<?php if(isset($role_id)) { if(in_array('appraisal1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "appraisal2", check: "<?php if(isset($role_id)) { if(in_array('appraisal2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "appraisal3", check: "<?php if(isset($role_id)) { if(in_array('appraisal3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "appraisal4", check: "<?php if(isset($role_id)) { if(in_array('appraisal4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Performance.xin_competencies');?>", value: "competency1", check: "<?php if(isset($role_id)) { if(in_array('competency1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "competency1", check: "<?php if(isset($role_id)) { if(in_array('competency1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "competency2", check: "<?php if(isset($role_id)) { if(in_array('competency2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "competency3", check: "<?php if(isset($role_id)) { if(in_array('competency3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "competency4", check: "<?php if(isset($role_id)) { if(in_array('competency4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_hr_goal_tracking');?>", value: "tracking1", check: "<?php if(isset($role_id)) { if(in_array('tracking1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "tracking1", check: "<?php if(isset($role_id)) { if(in_array('tracking1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "tracking2", check: "<?php if(isset($role_id)) { if(in_array('tracking2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "tracking3", check: "<?php if(isset($role_id)) { if(in_array('tracking3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "tracking4", check: "<?php if(isset($role_id)) { if(in_array('tracking4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Performance.xin_update_rating');?>", value: "tracking5",check: "<?php if(isset($role_id)) { if(in_array('tracking5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_hr_goal_tracking_type');?>",  check: "<?php if(isset($role_id)) { if(in_array('track_type1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "track_type1",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "track_type1", check: "<?php if(isset($role_id)) { if(in_array('track_type1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "track_type2", check: "<?php if(isset($role_id)) { if(in_array('track_type2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "track_type3", check: "<?php if(isset($role_id)) { if(in_array('track_type3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "track_type4", check: "<?php if(isset($role_id)) { if(in_array('track_type4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Performance.xin_goals_calendar');?>",  check: "<?php if(isset($role_id)) { if(in_array('track_calendar',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "track_calendar",},
	]},
	
	//Clients
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Projects.xin_manage_clients');?>", value: "hr_clients", check: "<?php if(isset($role_id)) { if(in_array('hr_clients',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "client1", check: "<?php if(isset($role_id)) { if(in_array('client1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "client2", check: "<?php if(isset($role_id)) { if(in_array('client2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "client3", check: "<?php if(isset($role_id)) { if(in_array('client3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "client4", check: "<?php if(isset($role_id)) { if(in_array('client4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	//Leads
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_leads');?>", value: "hr_leads",  check: "<?php if(isset($role_id)) { if(in_array('hr_leads',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "leads1",  check: "<?php if(isset($role_id)) { if(in_array('leads1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "leads2",  check: "<?php if(isset($role_id)) { if(in_array('leads2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "leads3",  check: "<?php if(isset($role_id)) { if(in_array('leads3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "leads4",  check: "<?php if(isset($role_id)) { if(in_array('leads4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_change_to_client');?>", value: "leads5",  check: "<?php if(isset($role_id)) { if(in_array('leads5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	//Invoices
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_invoices_title');?>", add_info: "",  check: "<?php if(isset($role_id)) { if(in_array('hr_invoices',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "hr_invoices",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Invoices.xin_billing_invoices');?>", value: "invoice1", check: "<?php if(isset($role_id)) { if(in_array('invoice1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "invoice2", check: "<?php if(isset($role_id)) { if(in_array('invoice2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Invoices.xin_create_new_invoices');?>", value: "invoice3", check: "<?php if(isset($role_id)) { if(in_array('invoice3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Invoices.xin_edit_invoice');?>", value: "invoice4", check: "<?php if(isset($role_id)) { if(in_array('invoice4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "invoice5", check: "<?php if(isset($role_id)) { if(in_array('invoice5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_acc_invoice_payments');?>", value: "invoice_payments", check: "<?php if(isset($role_id)) { if(in_array('invoice_payments',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_acc_calendar');?>", value: "invoice_calendar", check: "<?php if(isset($role_id)) { if(in_array('invoice_calendar',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_invoice_tax_type');?>", value: "tax_type1", check: "<?php if(isset($role_id)) { if(in_array('tax_type1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "tax_type1", check: "<?php if(isset($role_id)) { if(in_array('tax_type1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "tax_type2", check: "<?php if(isset($role_id)) { if(in_array('tax_type2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "tax_type3", check: "<?php if(isset($role_id)) { if(in_array('tax_type3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "tax_type4", check: "<?php if(isset($role_id)) { if(in_array('tax_type4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	]},
	//Estimates
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_estimates');?>", value: "estimate1", check: "<?php if(isset($role_id)) { if(in_array('estimate1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "estimate2", check: "<?php if(isset($role_id)) { if(in_array('estimate2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_create_new_estimate');?>", value: "estimate3", check: "<?php if(isset($role_id)) { if(in_array('estimate3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit_estimate');?>", value: "estimate4", check: "<?php if(isset($role_id)) { if(in_array('estimate4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "estimate5", check: "<?php if(isset($role_id)) { if(in_array('estimate5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_convert_estimate_to_invoice');?>", value: "estimate6", check: "<?php if(isset($role_id)) { if(in_array('estimate6',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_cancel_estimate');?>", value: "estimate7", check: "<?php if(isset($role_id)) { if(in_array('estimate7',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_quote_calendar');?>", value: "estimates_calendar", check: "<?php if(isset($role_id)) { if(in_array('estimates_calendar',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]
	},
	//Events
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_hr_events');?>",  add_info: "",  check: "<?php if(isset($role_id)) { if(in_array('hr_events',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "hr_events",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_hr_events');?>", value: "hr_event1", check: "<?php if(isset($role_id)) { if(in_array('hr_event1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "hr_event1", check: "<?php if(isset($role_id)) { if(in_array('hr_event1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "hr_event2", check: "<?php if(isset($role_id)) { if(in_array('hr_event2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "hr_event3", check: "<?php if(isset($role_id)) { if(in_array('hr_event3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "hr_event4", check: "<?php if(isset($role_id)) { if(in_array('hr_event4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Conference.xin_events_calendar');?>",  check: "<?php if(isset($role_id)) { if(in_array('events_calendar',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "events_calendar",},
	]},
	//Conference Booking
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_hr_meetings');?>",  add_info: "",  check: "<?php if(isset($role_id)) { if(in_array('hr_conference',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "hr_conference",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_hr_meetings');?>", value: "conference1", check: "<?php if(isset($role_id)) { if(in_array('conference1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "conference1", check: "<?php if(isset($role_id)) { if(in_array('conference1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "conference2", check: "<?php if(isset($role_id)) { if(in_array('conference2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "conference3", check: "<?php if(isset($role_id)) { if(in_array('conference3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "conference4", check: "<?php if(isset($role_id)) { if(in_array('conference4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Conference.xin_conference_calendar');?>",  check: "<?php if(isset($role_id)) { if(in_array('conference_calendar',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "conference_calendar",},
	]},
	//Holidays
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_holidays');?>",  add_info: "",  check: "<?php if(isset($role_id)) { if(in_array('hr_holidays',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "hr_holidays",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.left_holidays');?>", value: "holiday1", check: "<?php if(isset($role_id)) { if(in_array('holiday1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "holiday1", check: "<?php if(isset($role_id)) { if(in_array('holiday1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "holiday2", check: "<?php if(isset($role_id)) { if(in_array('holiday2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "holiday3", check: "<?php if(isset($role_id)) { if(in_array('holiday3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "holiday4", check: "<?php if(isset($role_id)) { if(in_array('holiday4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Employees.xin_holidays_calendar');?>",  check: "<?php if(isset($role_id)) { if(in_array('holidays_calendar',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "holidays_calendar",},
	]},
	//Visitor Book
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_visitor_book');?>", value: "hr_visitors", check: "<?php if(isset($role_id)) { if(in_array('hr_visitors',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "visitor1", check: "<?php if(isset($role_id)) { if(in_array('visitor1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "visitor2", check: "<?php if(isset($role_id)) { if(in_array('visitor2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "visitor3", check: "<?php if(isset($role_id)) { if(in_array('visitor3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "visitor4", check: "<?php if(isset($role_id)) { if(in_array('visitor4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	//Documents Manager
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_upload_files');?>",  add_info: "",  check: "<?php if(isset($role_id)) { if(in_array('hr_files',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "hr_files",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Employees.xin_general_documents');?>", value: "file1", check: "<?php if(isset($role_id)) { if(in_array('file1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "file1", check: "<?php if(isset($role_id)) { if(in_array('file1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "file2", check: "<?php if(isset($role_id)) { if(in_array('file2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "file3", check: "<?php if(isset($role_id)) { if(in_array('file3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "file4", check: "<?php if(isset($role_id)) { if(in_array('file4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Employees.xin_official_documents');?>", value: "officialfile1", check: "<?php if(isset($role_id)) { if(in_array('officialfile1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_role_enable');?>", value: "officialfile1", check: "<?php if(isset($role_id)) { if(in_array('officialfile1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_add');?>", value: "officialfile2", check: "<?php if(isset($role_id)) { if(in_array('officialfile2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_edit');?>", value: "officialfile3", check: "<?php if(isset($role_id)) { if(in_array('officialfile3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_delete');?>", value: "officialfile4", check: "<?php if(isset($role_id)) { if(in_array('officialfile4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	]},
	
	
	<?php /*?>//Company Settings
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_company_settings');?>", value: "company_settings", check: "<?php if(isset($role_id)) { if(in_array('company_settings',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},<?php */?>
	//Todo List
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Main.xin_todo_ist');?>", value: "todo_ist", check: "<?php if(isset($role_id)) { if(in_array('todo_ist',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	//System Calendar
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_system_calendar');?>", value: "system_calendar", check: "<?php if(isset($role_id)) { if(in_array('system_calendar',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	//System Reports
	{ id: "", class: "role-checkbox-modal custom-control-input input-light-primary", text: "<?= lang('Dashboard.xin_system_reports');?>", value: "system_reports", check: "<?php if(isset($role_id)) { if(in_array('system_reports',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	//
	]
	});
//});
// show checked node IDs on datasource change
function onCheck() {
var checkedNodes = [],
treeView = jQuery("#treeview").data("kendoTreeView"),
message;
//checkedNodeIds(treeView.dataSource.view(), checkedNodes);
jQuery("#result").html(message);
}
</script>
<?php }
?>
