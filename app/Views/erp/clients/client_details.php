<?php
use App\Models\UsersModel;
use App\Models\CountryModel;
use App\Models\SuperroleModel;

$CountryModel = new CountryModel();
$SuperroleModel = new SuperroleModel();
$UsersModel = new UsersModel();
$request = \Config\Services::request();

$roles = $SuperroleModel->orderBy('role_id', 'ASC')->findAll();
$segment_id = $request->uri->getSegment(3);
$user_id = udecode($segment_id);
$result = $UsersModel->where('user_id', $user_id)->first();
/////
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();

if($result['is_active'] == 1){
	$status = '<span class="badge badge-light-success"><em class="icon ni ni-check-circle"></em> '.lang('Main.xin_employees_active').'</span>';
	$status_label = '<i class="fas fa-certificate text-success bg-icon"></i><i class="fas fa-check front-icon text-white"></i>';
} elseif($result['is_active'] == 2){
	$status = '<span class="badge badge-light-danger"><em class="icon ni ni-cross-circle"></em> '.lang('Main.xin_employees_inactive').'</span>';
	$status_label = '<i class="fas fa-certificate text-danger bg-icon"></i><i class="fas fa-times-circle front-icon text-white"></i>';
}
?>
<?php if($result['profile_photo']!='' || $result['profile_photo']!='no-file'){?>
<?php
      $imageProperties = [
        'src'    => base_url().'/public/uploads/clients/thumb/'.$result['profile_photo'],
        'alt'    => $result['company_name'],
        'class'  => 'd-block img-radius img-fluid wid-80',
        'width'  => '50',
        'height' => '50',
        'title'  => $result['company_name']
    ];
     ?>
<?php } ?>

<div class="row">
  <div class="col-lg-4">
    <div class="card user-card user-card-1">
      <div class="card-body pb-0">
        <div class="float-right">
          <?= $status;?>
        </div>
        <input type="hidden" id="client_id" value="<?= $segment_id;?>" />
        <div class="media user-about-block align-items-center mt-0 mb-3">
          <div class="position-relative d-inline-block">
            <?php if($result['profile_photo']!='' || $result['profile_photo']!='no-file'){?>
            <?php
				  $imageProperties = [
					'src'    => base_url().'/public/uploads/clients/thumb/'.$result['profile_photo'],
					'alt'    => $result['company_name'],
					'class'  => 'd-block img-radius img-fluid wid-80',
					'width'  => '50',
					'height' => '50',
					'title'  => $result['company_name']
				];
				 ?>
            <?= img($imageProperties);?>
            <?php } ?>
            <div class="certificated-badge">
              <?= $status_label;?>
            </div>
          </div>
          <div class="media-body ml-3">
            <h6 class="mb-1">
              <?= $result['first_name'].' '.$result['last_name'];?>
            </h6>
            <p class="mb-0 text-muted">@
              <?= $result['username'];?>
            </p>
          </div>
        </div>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"> <span class="f-w-500"><i class="feather icon-mail m-r-10"></i>
          <?= lang('Main.xin_email');?>
          </span> <a href="mailto:<?= $result['email'];?>" class="float-right text-body">
          <?= $result['email'];?>
          </a> </li>
        <li class="list-group-item"> <span class="f-w-500"><i class="feather icon-phone-call m-r-10"></i>
          <?= lang('Main.xin_contact_number');?>
          </span> <a href="#" class="float-right text-body">
          <?= $result['contact_number'];?>
          </a> </li>
      </ul>
      <div class="nav flex-column nav-pills list-group list-group-flush list-pills" id="user-set-tab" role="tablist" aria-orientation="vertical"> <a class="nav-link list-group-item list-group-item-action active" id="user-basic-tab" data-toggle="pill" href="#user-edit-account" role="tab" aria-controls="user-edit-account" aria-selected="false"> <span class="f-w-500"><i class="feather icon-user m-r-10 h5 "></i>
        <?= lang('Main.xin_personal_info');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-profile-picture-tab" data-toggle="pill" href="#user-profile-picture" role="tab" aria-controls="user-profile-picture" aria-selected="false"> <span class="f-w-500"><i class="feather icon-image m-r-10 h5 "></i>
        <?= lang('Main.xin_e_details_profile_picture');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-projects-tab" data-toggle="pill" href="#user-projects" role="tab" aria-controls="user-projects" aria-selected="false"> <span class="f-w-500"><i class="feather icon-layers m-r-10 h5 "></i>
        <?= lang('Dashboard.left_projects');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-tasks-tab" data-toggle="pill" href="#user-tasks" role="tab" aria-controls="user-tasks" aria-selected="false"> <span class="f-w-500"><i class="feather icon-edit m-r-10 h5 "></i>
        <?= lang('Dashboard.left_tasks');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-invoices-tab" data-toggle="pill" href="#user-invoices" role="tab" aria-controls="user-invoices" aria-selected="false"> <span class="f-w-500"><i class="feather icon-calendar m-r-10 h5 "></i>
        <?= lang('Dashboard.xin_invoices_title');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-set-password-tab" data-toggle="pill" href="#user-set-password" role="tab" aria-controls="user-set-password" aria-selected="false"> <span class="f-w-500"><i class="feather icon-shield m-r-10 h5 "></i>
        <?= lang('Main.header_change_password');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> </div>
    </div>
  </div>
  <div class="col-xl-8 col-lg-12">
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade active show" id="user-edit-account" role="tabpanel" aria-labelledby="user-edit-account-tab">
        <div class="card">
          <div class="card-header">
            <h5><i data-feather="user" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.xin_personal_info');?>
              </span></h5>
          </div>
          <?php $attributes = array('name' => 'update_client', 'id' => 'update_client', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
          <?php $hidden = array('_method' => 'EDIT', 'token' => $segment_id);?>
          <?= form_open('erp/clients/update_client', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="company_name">
                    <?= lang('Main.xin_employee_first_name');?>
                    <span class="text-danger">*</span> </label>
                  <input class="form-control" placeholder="<?= lang('Main.xin_employee_first_name');?>" name="first_name" type="text" value="<?= $result['first_name'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="last_name" class="control-label">
                    <?= lang('Main.xin_employee_last_name');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Main.xin_employee_last_name');?>" name="last_name" type="text" value="<?= $result['last_name'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="email">
                    <?= lang('Main.xin_email');?>
                    <span class="text-danger">*</span> </label>
                  <input class="form-control" placeholder="<?= lang('Main.xin_email');?>" name="email" type="email" value="<?= $result['email'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="email">
                    <?= lang('Main.dashboard_username');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Main.dashboard_username');?>" name="username" type="text" value="<?= $result['username'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="membership_type">
                    <?= lang('Main.dashboard_xin_status');?>
                    <span class="text-danger">*</span> </label>
                  <select class="form-select form-control" name="status" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_xin_status');?>">
                    <option value="1" <?php if($result['is_active']=='1'):?> selected="selected"<?php endif;?>>
                    <?= lang('Main.xin_employees_active');?>
                    </option>
                    <option value="2" <?php if($result['is_active']=='2'):?> selected="selected"<?php endif;?>>
                    <?= lang('Main.xin_employees_inactive');?>
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="contact_number">
                    <?= lang('Main.xin_contact_number');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" name="contact_number" type="text" value="<?= $result['contact_number'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="gender" class="control-label">
                    <?= lang('Main.xin_employee_gender');?>
                  </label>
                  <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_employee_gender');?>">
                    <option value="1" <?php if('1'==$result['gender']):?> selected="selected"<?php endif;?>>
                    <?= lang('Main.xin_gender_male');?>
                    </option>
                    <option value="2"<?php if('2'==$result['gender']):?> selected="selected"<?php endif;?>>
                    <?= lang('Main.xin_gender_female');?>
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="country">
                    <?= lang('Main.xin_country');?>
                    <span class="text-danger">*</span> </label>
                  <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_country');?>">
                    <option value="">
                    <?= lang('Main.xin_select_one');?>
                    </option>
                    <?php foreach($all_countries as $country) {?>
                    <option value="<?= $country['country_id'];?>" <?php if($country['country_id']==$result['country']):?> selected="selected"<?php endif;?>>
                    <?= $country['country_name'];?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="address_1">
                    <?= lang('Main.xin_address');?>
                    </label>
                  <input class="form-control" placeholder="<?= lang('Main.xin_address');?>" name="address_1" type="text" value="<?= $result['address_1'];?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="address_2"> &nbsp;</label>
                  <input class="form-control" placeholder="<?= lang('Main.xin_address_2');?>" name="address_2" type="text" value="<?= $result['address_2'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="city">
                    <?= lang('Main.xin_city');?>
                    </label>
                  <input class="form-control" placeholder="<?= lang('Main.xin_city');?>" name="city" type="text" value="<?= $result['city'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="state">
                    <?= lang('Main.xin_state');?>
                    </label>
                  <input class="form-control" placeholder="<?= lang('Main.xin_state');?>" name="state" type="text" value="<?= $result['state'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="zipcode">
                    <?= lang('Main.xin_zipcode');?>
                    </label>
                  <input class="form-control" placeholder="<?= lang('Main.xin_zipcode');?>" name="zipcode" type="text" value="<?= $result['zipcode'];?>">
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary">
              <?= lang('Main.xin_save');?>
              </button>
            </div>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <div class="tab-pane fade" id="user-profile-picture" role="tabpanel" aria-labelledby="user-profile-picture-tab">
        <div class="card">
          <div class="card-header">
            <h5><i data-feather="image" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.xin_e_details_profile_picture');?>
              </span></h5>
          </div>
          <?php $attributes = array('name' => 'profile_photo', 'id' => 'profile_photo', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => 0, 'token' => $segment_id);?>
          <?= form_open_multipart('erp/clients/update_profile_photo', $attributes, $hidden);?>
          <div class="card-body pb-2">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="logo">
                    <?= lang('Main.xin_e_details_profile_picture');?>
                    <span class="text-danger">*</span> </label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="file">
                    <label class="custom-file-label">
                      <?= lang('Main.xin_choose_file');?>
                    </label>
                    <small>
                    <?= lang('Main.xin_company_file_type');?>
                    </small> </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary">
              <?= lang('Main.xin_save');?>
              </button>
            </div>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <div class="tab-pane fade" id="user-projects" role="tabpanel" aria-labelledby="user-projects-tab">
        <div class="card user-profile-list">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo lang('Main.xin_list_all');?></strong> <?php echo lang('Dashboard.left_projects');?></span> </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="xin_projects_table" style="width:100%;">
                <thead>
                  <tr>
                    <th><?php echo lang('Dashboard.left_projects');?></th>
                    <th><?php echo lang('Projects.xin_p_priority');?></th>
                    <th><i class="fa fa-user"></i> <?php echo lang('Projects.xin_project_users');?></th>
                    <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_start_date');?></th>
                    <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_end_date');?></th>
                    <th><?php echo lang('Projects.dashboard_xin_progress');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="user-invoices" role="tabpanel" aria-labelledby="user-invoices-tab">
        <div class="card user-profile-list">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
            <?= lang('Main.xin_list_all');?>
            </strong>
            <?= lang('Invoices.xin_billing_invoices');?>
            </span> </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="xin_invoices_table" style="width:100%;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th width="170px"><?= lang('Invoices.xin_bill_for');?></th>
                    <th><?= lang('Invoices.xin_invoice_date');?></th>
                    <th><?= lang('Invoices.xin_amount');?></th>
                    <th><?= lang('Main.dashboard_xin_status');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="user-tasks" role="tabpanel" aria-labelledby="user-tasks-tab">
        <div class="card user-profile-list">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo lang('Main.xin_list_all');?></strong> <?php echo lang('Projects.xin_tasks');?></span> </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="xin_tasks_table" style="width:100%;">
                <thead>
                  <tr>
                    <th><?php echo lang('Dashboard.xin_title');?></th>
                    <th><?php echo lang('Projects.xin_project');?></th>
                    <th><?php echo lang('Projects.xin_project_users');?></th>
                    <th><?php echo lang('Projects.dashboard_xin_progress');?></th>
                    <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_end_date');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="user-set-password" role="tabpanel" aria-labelledby="user-set-password-tab">
        <div class="alert alert-warning" role="alert">
          <h5 class="alert-heading"><i class="feather icon-alert-circle mr-2"></i>
            <?= lang('Main.xin_alert');?>
          </h5>
          <p>
            <?= lang('Main.xin_dont_share_password');?>
          </p>
        </div>
        <div class="card">
          <div class="card-header">
            <h5><i data-feather="shield" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.header_change_password');?>
              </span></h5>
          </div>
          <?php $attributes = array('name' => 'change_password', 'id' => 'change_password', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?= form_open('erp/clients/update_password_opt', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>
                    <?= lang('Main.xin_current_password');?>
                  </label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-eye"></i></span></div>
                    <input type="password" readonly="readonly" class="form-control" name="pass" placeholder="<?= lang('Main.xin_current_password');?>" value="********">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>
                    <?= lang('Main.xin_new_password');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-eye"></i></span></div>
                    <input type="password" class="form-control" name="new_password" placeholder="<?= lang('Main.xin_new_password');?>">
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>
                    <?= lang('Main.xin_repeat_new_password');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-eye"></i></span></div>
                    <input type="password" class="form-control" name="confirm_password" placeholder="<?= lang('Main.xin_repeat_new_password');?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-danger">
            <?= lang('Main.header_change_password');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
