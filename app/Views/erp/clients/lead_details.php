<?php
use App\Models\LeadsModel;
use App\Models\UsersModel;
use App\Models\CountryModel;
use App\Models\SuperroleModel;

$CountryModel = new CountryModel();
$SuperroleModel = new SuperroleModel();
$LeadsModel = new LeadsModel();
$UsersModel = new UsersModel();
$request = \Config\Services::request();

$roles = $SuperroleModel->orderBy('role_id', 'ASC')->findAll();
$segment_id = $request->uri->getSegment(3);
$lead_id = udecode($segment_id);
$result = $LeadsModel->where('lead_id', $lead_id)->first();
/////
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();

if($result['status'] == 1){
	$status = '<span class="badge badge-light-primary"><em class="icon ni ni-check-circle"></em> '.lang('Dashboard.xin_lead').'</span>';
	$status_label = '<i class="fas fa-certificate text-primary bg-icon"></i><i class="fas fa-check front-icon text-white"></i>';
}
?>
<?php if($result['profile_photo']!='' || $result['profile_photo']!='no-file'){?>
<?php
      $imageProperties = [
        'src'    => base_url().'/public/uploads/clients/thumb/'.$result['profile_photo'],
        'class'  => 'd-block img-radius img-fluid wid-80',
        'width'  => '50',
        'height' => '50',
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
					'class'  => 'd-block img-radius img-fluid wid-80',
					'width'  => '50',
					'height' => '50'
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
      <input type="hidden" value="<?= $segment_id;?>" id="xlead_id" />
      <div class="nav flex-column nav-pills list-group list-group-flush list-pills" id="user-set-tab" role="tablist" aria-orientation="vertical"> <a class="nav-link list-group-item list-group-item-action active" id="user-basic-tab" data-toggle="pill" href="#user-edit-account" role="tab" aria-controls="user-edit-account" aria-selected="false"> <span class="f-w-500"><i class="feather icon-user m-r-10 h5 "></i>
        <?= lang('Main.xin_personal_info');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-profile-picture-tab" data-toggle="pill" href="#user-profile-picture" role="tab" aria-controls="user-profile-picture" aria-selected="false"> <span class="f-w-500"><i class="feather icon-image m-r-10 h5 "></i>
        <?= lang('Main.xin_e_details_profile_picture');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-follow_up-tab" data-toggle="pill" href="#user-follow_up" role="tab" aria-controls="user-follow_up" aria-selected="false"> <span class="f-w-500"><i class="feather icon-layers m-r-10 h5 "></i>
        <?= lang('Main.xin_follow_up');?>
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
          <?php $attributes = array('name' => 'update_lead', 'id' => 'update_lead', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
          <?php $hidden = array('_method' => 'EDIT', 'token' => $segment_id);?>
          <?= form_open('erp/clients/update_lead', $attributes, $hidden);?>
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
          <?= form_open_multipart('erp/clients/update_lead_profile_photo', $attributes, $hidden);?>
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
      <div class="tab-pane fade" id="user-follow_up" role="tabpanel" aria-labelledby="user-follow_up-tab">
        <div class="card user-profile-list">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><i data-feather="layers" class="icon-svg-primary wid-20"></i> <?php echo lang('Main.xin_follow_up');?></strong></span> </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="xin_table" width="100%">
                <thead>
                  <tr>
                    <th width="200"><?php echo lang('Main.xin_next_follow_up');?></th>
                    <th><?php echo lang('Main.xin_description');?></th>
                    <th><?php echo lang('Main.xin_created_at');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <div class="card-header">
            <h5><span class="p-l-5">
              <?= lang('Main.xin_new_follow_up');?>
              </span></h5>
          </div>
          
          <?php $attributes = array('name' => 'add_followup', 'id' => 'followup_info', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
          <?php $hidden = array('_method' => 'EDIT', 'token' => $segment_id);?>
          <?= form_open('erp/clients/add_followup', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="company_name">
                    <?= lang('Main.xin_next_follow_up');?>
                    <span class="text-danger">*</span> </label>
                    <div class="input-group">
                        <input class="form-control date" placeholder="<?= lang('Main.xin_next_follow_up');?>" name="next_follow_up" type="text">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                </div>
              </div>
              
              <div class="col-md-8">
                <div class="form-group">
                  <label for="address_1">
                    <?= lang('Main.xin_description');?> <span class="text-danger">*</span>
                    </label>
                  <input class="form-control" placeholder="<?= lang('Main.xin_description');?>" name="description" type="text">
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
    </div>
  </div>
</div>
