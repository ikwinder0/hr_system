<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ShiftModel;
use App\Models\SystemModel;
use App\Models\CountryModel;
use App\Models\ConstantsModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\StaffdetailsModel;
//$encrypter = \Config\Services::encrypter();
$ShiftModel = new ShiftModel();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$CountryModel = new CountryModel();
$ConstantsModel = new ConstantsModel();
$DepartmentModel = new DepartmentModel();
$DesignationModel = new DesignationModel();
$StaffdetailsModel = new StaffdetailsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

///
$segment_id = $request->uri->getSegment(3);
$user_id = udecode($segment_id);
$result = $UsersModel->where('user_id', $user_id)->first();
$employee_detail = $StaffdetailsModel->where('user_id', $result['user_id'])->first();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$departments = $DepartmentModel->where('company_id',$user_info['company_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$user_info['company_id'])->where('department_id',$employee_detail['department_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$user_info['company_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
} else {
	$departments = $DepartmentModel->where('company_id',$usession['sup_user_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$usession['sup_user_id'])->where('department_id',$employee_detail['department_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$usession['sup_user_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
}

$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
$religion = $ConstantsModel->where('type','religion')->orderBy('constants_id', 'ASC')->findAll();
$roles = $RolesModel->orderBy('role_id', 'ASC')->findAll();
$selected_shift = $ShiftModel->where('office_shift_id', $employee_detail['office_shift_id'])->first();
?>

<div class="mb-3 sw-container tab-content">
  <div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
    <ul class="nav nav-tabs step-anchor">
      <li class="nav-item clickable"> <a href="<?= site_url('erp/employee-details/').$segment_id;?>" class="mb-3 nav-link"> <span class="sw-done-icon ion lnr lnr-users"></span> <span class="sw-icon lnr lnr-users"></span>
        <?= lang('xin_general');?>
        <div class="text-muted small">
          <?= lang('xin_e_details_basic');?>
        </div>
        </a> </li>
      <?php //if(in_array('351',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> <a href="<?= site_url('erp/employee-salary/').$segment_id;?>" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-highlight"></span> <span class="sw-icon lnr lnr-highlight"></span>
        <?= lang('xin_employee_set_salary');?>
        <div class="text-muted small">
          <?= lang('xin_set_up').' '. lang('xin_employee_set_salary');?>
        </div>
        </a> </li>
      <?php //} ?>
      <li class="nav-item clickable"> <a href="<?= site_url('erp/employee-leave/').$segment_id;?>" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-calendar-full"></span> <span class="sw-icon lnr lnr-calendar-full"></span>
        <?= lang('left_leaves');?>
        <div class="text-muted small">
          <?= lang('xin_view_leave_all');?>
        </div>
        </a> </li>
      <li class="nav-item active"> <a href="<?= site_url('erp/employee-corehr/').$segment_id;?>" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-earth"></span> <span class="sw-icon lnr lnr-earth"></span>
        <?= lang('xin_hr');?>
        <div class="text-muted small">
          <?= lang('xin_view_core_hr_modules');?>
        </div>
        </a> </li>
      <li class="nav-item clickable"> <a href="<?= site_url('erp/employee-projects-tasks/').$segment_id;?>" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-layers"></span> <span class="sw-icon lnr lnr-layers"></span>
        <?= lang('xin_hr_m_project_task');?>
        <div class="text-muted small">
          <?= lang('xin_view_all_projects');?>
        </div>
        </a> </li>
      <li class="nav-item clickable"> <a href="<?= site_url('erp/employee-payslip/').$segment_id;?>" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-keyboard"></span> <span class="sw-icon lnr lnr-keyboard"></span>
        <?= lang('left_payslips');?>
        <div class="text-muted small">
          <?= lang('xin_view_payslips_all');?>
        </div>
        </a> </li>
    </ul>
    <hr class="border-light mb-3 m-0">
    <div class="card overflow-hidden">
      <div class="row no-gutters row-bordered row-border-light">
        <div class="col-md-3 pt-0">
          <div class="list-group list-group-flush account-settings-links"> <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-awards"> <i class="lnr lnr-strikethrough text-lightest"></i> &nbsp;
            <?= lang('left_awards');?>
            </a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-travels"> <i class="lnr lnr-car text-lightest"></i> &nbsp;
            <?= lang('left_travels');?>
            </a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-training"> <i class="lnr lnr-graduation-hat text-lightest"></i> &nbsp;
            <?= lang('left_training');?>
            </a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-tickets"> <i class="lnr lnr-location text-lightest"></i> &nbsp;
            <?= lang('left_tickets');?>
            </a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-transfers"> <i class="lnr lnr-store text-lightest"></i> &nbsp;
            <?= lang('left_transfers');?>
            </a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-promotions"> <i class="lnr lnr-tag text-lightest"></i> &nbsp;
            <?= lang('left_promotions');?>
            </a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-complaints"> <i class="lnr lnr-file-add text-lightest"></i> &nbsp;
            <?= lang('left_complaints');?>
            </a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-warnings"> <i class="lnr lnr-paw text-lightest"></i> &nbsp;
            <?= lang('left_warnings');?>
            </a> </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content">
            <div class="tab-pane fade show active" id="account-awards">
              <div class="card">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
                  <?= lang('xin_list_all');?>
                  </strong>
                  <?= lang('left_awards');?>
                  </span> </div>
                <?php //$award = $this->Awards_model->get_employee_awards($user_id); ?>
                <div class="card-body">
                  <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered xin_ci_table" id="xin_hr_table">
                      <thead>
                        <tr>
                          <th style="width:100px;"><?= lang('xin_view');?></th>
                          <th width="300"><i class="fa fa-trophy"></i>
                            <?= lang('xin_award_name');?></th>
                          <th><i class="fa fa-gift"></i>
                            <?= lang('xin_gift');?></th>
                          <th><i class="fa fa-calendar"></i>
                            <?= lang('xin_award_month_year');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php //foreach($award->result() as $r) {} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="account-travels">
              <div class="card">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
                  <?= lang('xin_list_all');?>
                  </strong>
                  <?= lang('xin_travel');?>
                  </span> </div>
                <?php //$travel = $this->Travel_model->get_employee_travel($user_id); ?>
                <div class="card-body">
                  <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered xin_ci_table">
                      <thead>
                        <tr>
                          <th><?= lang('xin_view');?></th>
                          <th><?= lang('xin_summary');?></th>
                          <th><?= lang('xin_visit_place');?></th>
                          <th><i class="fa fa-calendar"></i>
                            <?= lang('xin_start_date');?></th>
                          <th><i class="fa fa-calendar"></i>
                            <?= lang('xin_end_date');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php //foreach($travel->result() as $r) {} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="account-training">
              <div class="card">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
                  <?= lang('xin_list_all');?>
                  </strong>
                  <?= lang('left_training');?>
                  </span> </div>
                <?php //$training = $this->Training_model->get_employee_training($user_id); ?>
                <div class="card-body">
                  <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered xin_ci_table">
                      <thead>
                        <tr>
                          <th><?= lang('xin_view');?></th>
                          <th><?= lang('left_training_type');?></th>
                          <th><?= lang('xin_trainer');?></th>
                          <th><i class="fa fa-calendar"></i>
                            <?= lang('xin_training_duration');?></th>
                          <th><i class="fa fa-dollar"></i>
                            <?= lang('xin_cost');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php //foreach($training->result() as $r) {} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="account-tickets">
              <div class="card">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
                  <?= lang('xin_list_all');?>
                  </strong>
                  <?= lang('left_tickets');?>
                  </span> </div>
                <?php //$ticket = $this->Tickets_model->get_employees_tickets($user_id);?>
                <div class="card-body">
                  <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered xin_ci_table">
                      <thead>
                        <tr class="xin-bg-dark">
                          <th><?= lang('xin_view');?></th>
                          <th><?= lang('xin_ticket_code');?></th>
                          <th><?= lang('xin_subject');?></th>
                          <th><?= lang('xin_p_priority');?></th>
                          <th><i class="fa fa-calendar"></i>
                            <?= lang('xin_e_details_date');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php //foreach($ticket->result() as $r) {} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="account-transfers">
              <div class="card">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
                  <?= lang('xin_list_all');?>
                  </strong>
                  <?= lang('left_transfers');?>
                  </span> </div>
                <?php //$transfer = $this->Transfers_model->get_employee_transfers($user_id); ?>
                <div class="card-body">
                  <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered xin_ci_table">
                      <thead>
                        <tr>
                          <th><?= lang('xin_view');?></th>
                          <th><?= lang('xin_summary');?></th>
                          <th><?= lang('left_company');?></th>
                          <th><i class="fa fa-calendar"></i>
                            <?= lang('xin_transfer_date');?></th>
                          <th><?= lang('dashboard_xin_status');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php //foreach($transfer->result() as $r) {} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="account-promotions">
              <div class="card">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
                  <?= lang('xin_list_all');?>
                  </strong>
                  <?= lang('left_promotions');?>
                  </span> </div>
                <?php //$promotion = $this->Promotion_model->get_employee_promotions($user_id); ?>
                <div class="card-body">
                  <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered xin_ci_table">
                      <thead>
                        <tr>
                          <th><?= lang('xin_view');?></th>
                          <th><?= lang('xin_promotion_title');?></th>
                          <th><i class="fa fa-calendar"></i>
                            <?= lang('xin_e_details_date');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php //foreach($promotion->result() as $r) {} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="account-complaints">
              <div class="card">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
                  <?= lang('xin_list_all');?>
                  </strong>
                  <?= lang('left_complaints');?>
                  </span> </div>
                <?php //$complaint = $this->Complaints_model->get_employee_complaints($user_id); ?>
                <div class="card-body">
                  <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered xin_ci_table">
                      <thead>
                        <tr>
                          <th><?= lang('xin_view');?></th>
                          <th width="200"><i class="fa fa-user"></i>
                            <?= lang('xin_complaint_from');?></th>
                          <th><i class="fa fa-users"></i>
                            <?= lang('xin_complaint_against');?></th>
                          <th><?= lang('xin_complaint_title');?></th>
                          <th><i class="fa fa-calendar"></i>
                            <?= lang('xin_complaint_date');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php //foreach($complaint->result() as $r) {} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="account-warnings">
              <div class="card">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
                  <?= lang('xin_list_all');?>
                  </strong>
                  <?= lang('left_warnings');?>
                  </span> </div>
                <?php //$warning = $this->Warning_model->get_employee_warning($user_id); ?>
                <div class="card-body">
                  <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered xin_ci_table">
                      <thead>
                        <tr>
                          <th><?= lang('xin_view');?></th>
                          <th><?= lang('xin_subject');?></th>
                          <th><i class="fa fa-calendar"></i>
                            <?= lang('xin_warning_date');?></th>
                          <th><i class="fa fa-user"></i>
                            <?= lang('xin_warning_by');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php //foreach($warning->result() as $r) {} ?>
                      </tbody>
                    </table>
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
