<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\DepartmentModel;
use App\Models\StaffdetailsModel;
use App\Models\TicketsModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$TicketsModel = new TicketsModel();
$DepartmentModel = new DepartmentModel();
$StaffdetailsModel = new StaffdetailsModel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$staff_details = $StaffdetailsModel->where('user_id', $user_info['user_id'])->first();
if($user_info['user_type'] == 'staff'){
   $main_department = $DepartmentModel->where('company_id', $user_info['company_id'])->where('department_id', $staff_details['department_id'])->findAll();
   $get_tickets = $TicketsModel->where('company_id',$user_info['company_id'])->where('employee_id', $usession['sup_user_id'])->orderBy('ticket_id', 'ASC')->paginate(9);
   $pager = $TicketsModel->pager;
} else {
	$main_department = $DepartmentModel->where('company_id', $usession['sup_user_id'])->findAll();
	$get_tickets = $TicketsModel->where('company_id',$usession['sup_user_id'])->orderBy('ticket_id', 'ASC')->paginate(9);
	$pager = $TicketsModel->pager;
}
?>

<div class="row help-desk">
  <div class="col-xl-8 col-lg-12">
  <?php if(in_array('helpdesk1',staff_role_resource()) && in_array('helpdesk2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <div class="card">
      <div class="card-body">
        <nav class="navbar justify-content-between p-0 align-items-center">
          <h5>
            <?= lang('Dashboard.left_tickets_list');?>
          </h5>
          <div class="btn-group btn-group-toggle" data-toggle="buttons"> <a href="<?= site_url().'erp/create-ticket';?>" class="btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
            <?= lang('Dashboard.left_create_ticket');?>
            </a> </div>
        </nav>
      </div>
    </div>
    <?php } ?>
    <?php foreach($get_tickets as $r){ ?>
    <?php
		// created by
		$created_by = $UsersModel->where('user_id', $r['created_by'])->first();
		if($created_by){
			$icreated_by = $created_by['first_name'].' '.$created_by['last_name'];
			$cprofile_pic = staff_profile_photo($r['created_by']);
		} else {
			$icreated_by = '--';
			$cprofile_pic = '--';
		}		
		// assigned employee
		$iuser = $UsersModel->where('user_id', $r['employee_id'])->first();
		if($iuser){
			$employee_name = $iuser['first_name'].' '.$iuser['last_name'];
			$eprofile_pic = staff_profile_photo($r['employee_id']);
		} else {
			$employee_name = '--';
			$eprofile_pic = '--';
		}
		// created at
		$created_at = set_date_format($r['created_at']);
		// priority
		if($r['ticket_priority']==1):
			$priority = '<span class="text-warning">'.lang('Projects.xin_low').'</span>';
		elseif($r['ticket_priority']==2):
			$priority = '<span class="text-success">'.lang('Main.xin_medium').'</span>';
		elseif($r['ticket_priority']==3):
			$priority = '<span class="text-danger">'.lang('Projects.xin_high').'</span>';
		elseif($r['ticket_priority']==4):
			$priority = '<span class="text-danger">'.lang('Main.xin_critical').'</span>';
		endif;
		// status
		if($r['ticket_status']==1):
			$status = '<span class="text-warning">'.lang('Main.xin_open').'</span>';
		elseif($r['ticket_status']==2):
			$status = '<span class="text-success">'.lang('Main.xin_closed').'</span>';
		else:
			$status = '<span class="text-warning">'.lang('Main.xin_open').'</span>';
		endif;
		?>
    <div class="ticket-block">
      <div class="row">
        <div class="col-auto"> <img class="media-object wid-60 img-radius" src="<?= $cprofile_pic;?>" alt=""> </div>
        <div class="col">
          <div class="card hd-body">
            <div class="row align-items-center">
              <div class="col border-right pr-0">
                <div class="card-body inner-center">
                  <div class="ticket-customer font-weight-bold">
                    <?= $icreated_by;?>
                  </div>
                  <div class="ticket-type-icon private mt-1 mb-1"><i class="feather icon-lock mr-1 f-14"></i>
                    <?= $r['subject'];?>
                  </div>
                  <ul class="list-inline mt-2 mb-0">
                    <li class="list-inline-item">#
                      <?= $r['ticket_code'];?>
                    </li>
                    <li class="list-inline-item"><img src="<?= $eprofile_pic;?>" alt="" class="wid-20 rounded mr-1 img-fluid">
                      <?= lang('Employees.xin_assigned_to');?>
                      <?= $employee_name;?>
                    </li>
                    <li class="list-inline-item"><i class="feather icon-calendar mr-1 f-14"></i>
                      <?= $created_at;?>
                    </li>
                    <li class="list-inline-item">
                      <?= $priority;?>
                    </li>
                    <li class="list-inline-item">
                      <?= $status;?>
                    </li>
                  </ul>
                  <div class="mt-2"> 
                  <?php if(in_array('helpdesk3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?><a href="#" class="mr-3 text-muted" data-toggle="modal" data-target=".view-modal-data" data-field_id="<?= uencode($r['ticket_id']);?>"><i class="feather icon-edit mr-1"></i>
                    <?= lang('Main.xin_edit');?>
                    </a> 
                    <?php } ?>
                    <?php if($iuser!=null && $created_by!=null){ ?>
                    <?php if(in_array('helpdesk4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                    <a href="<?= site_url('erp/ticket-view').'/'.uencode($r['ticket_id']);?>" class="mr-3 text-muted"><i class="feather icon-eye mr-1"></i>
                    <?= lang('Dashboard.left_view_ticket');?>
                    </a> 
                    <?php } ?>
                    <?php } ?>
                    <?php if(in_array('helpdesk5',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                    <a href="#" class="text-danger delete" data-toggle="modal" data-target=".delete-modal" data-record-id="<?= uencode($r['ticket_id']);?>"><i class="feather icon-trash-2 mr-1"></i>
                    <?= lang('Main.xin_delete');?>
                    </a>
                    <?php } ?></div>
                </div>
              </div>
              <?php if(in_array('helpdesk4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
              <div class="col-auto pl-0 right-icon">
                <div class="card-body">
                  <ul class="list-unstyled mb-0">
                    <li><a href="<?= site_url('erp/ticket-view').'/'.uencode($r['ticket_id']);?>" data-toggle="tooltip" data-placement="top" title="<?= lang('Dashboard.left_view_ticket');?>"><i class="feather icon-circle text-muted"></i></a></li>
                  </ul>
                </div>
              </div>
              <?php } ?> 
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
  <div class="col-xl-4 col-md-12">
    <div class="row">
      <div class="col-xl-12 col-md-12">
        <div class="card">
          <div class="card-body">
            <h6>
              <?= lang('Dashboard.left_ticket_priority');?>
            </h6>
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
                <div id="ticket-priority-chart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-12 col-md-12">
        <div class="card">
          <div class="card-body">
            <h6>
              <?= lang('Dashboard.left_ticket_status');?>
            </h6>
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
                <div id="ticket-status-chart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>
<div class="p-2">
<?= $pager->links() ?>
</div>