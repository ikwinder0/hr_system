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
$roles = $SuperroleModel->orderBy('role_id', 'ASC')->findAll();
if($result['is_active'] == 1){
	$status = '<span class="text-success"><em class="icon ni ni-check-circle"></em> '.lang('Main.xin_employees_active').'</span>';
} else {
	$status = '<span class="text-danger"><em class="icon ni ni-cross-circle"></em> '.lang('Main.xin_employees_inactive').'</span>';
}
?>

<div class="media align-items-center py-3 mb-3">
  <?php if($result['profile_photo']!='' || $result['profile_photo']!='no-file'){?>
  <?php
      $imageProperties = [
        'src'    => base_url().'/public/uploads/users/thumb/'.$result['profile_photo'],
        'alt'    => $result['company_name'],
        'class'  => 'd-block ui-w-100 rounded-circle',
        'width'  => '50',
        'height' => '50',
        'title'  => $result['company_name']
    ];
     ?>
  <?= img($imageProperties);?>
  <?php } ?>
  <div class="media-body ml-4">
    <h4 class="font-weight-bold mb-2">
      <?= $result['first_name'];?>
      <?= $result['last_name'];?>
      <span class="text-muted font-weight-normal">@
      <?= $result['username'];?>
      </span></h4>
    <div class="text-muted mb-0">
      <?= $status;?>
    </div>
    <div class="text-muted mb-0">You can view and update info for this record <span class="text-primary"><i class="fas fa-info-circle"></i></span> Create At:
      <?= $result['created_at'];?>
    </div>
  </div>
</div>
<div class="row">
<div class="col-md-12">
  <div class="nav-tabs-top">
    <ul class="nav nav-tabs">
      <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#user-edit-account"><i class="fas fa-user-cog"></i> Basic</a> </li>
      <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#user-profile-logo"><i class="fas fa-images"></i> Profile Logo</a> </li>
    </ul>
    <div class="card tab-content">
      <div class="tab-pane fade active show" id="user-edit-account">
        <?php $attributes = array('name' => 'edit_user', 'id' => 'edit_user', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
        <?php $hidden = array('_method' => 'EDIT', 'token' => $segment_id);?>
        <?= form_open('erp/crm/update_customer', $attributes, $hidden);?>
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
                <label for="role">
                  <?= lang('Main.xin_employee_role');?>
                  <span class="text-danger">*</span></label>
                <select class="form-control" name="role" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_employee_role');?>">
                  <option value=""></option>
                  <?php foreach($roles as $role) {?>
                  <?php /*?><?php if($iuser[0]->user_role_id==1):?>
                            <option value="<?php echo $role->role_id?>"><?php echo $role->role_name?></option>
                          <?php else:?><?php */?>
                  <?php //if($role->role_id!=1):?>
                  <option value="<?= $role['role_id']?>" <?php if($role['role_id']==$result['user_role_id']):?> selected="selected"<?php endif;?>>
                  <?= $role['role_name']?>
                  </option>
                  <?php //endif;?>
                  <?php /*?><?php endif;?><?php */?>
                  <?php } ?>
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
                  <span class="text-danger">*</span></label>
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
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_city');?>" name="city" type="text" value="<?= $result['city'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="state">
                  <?= lang('Main.xin_state');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_state');?>" name="state" type="text" value="<?= $result['state'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="zipcode">
                  <?= lang('Main.xin_zipcode');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_zipcode');?>" name="zipcode" type="text" value="<?= $result['zipcode'];?>">
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary"> <i data-feather="check"></i>
            <?= lang('Main.xin_save');?>
            </button>
          </div>
        </div>
        <?= form_close(); ?>
      </div>
      <div class="tab-pane fade" id="user-profile-logo">
        <?php $attributes = array('name' => 'profile_photo', 'id' => 'ci_logo', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 0, 'token' => $segment_id);?>
        <?= form_open_multipart('erp/crm/update_profile_photo', $attributes, $hidden);?>
        <div class="card-body pb-2">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="logo">
                  <?= lang('Company.xin_company_logo');?>
                  <span class="text-danger">*</span> </label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="file">
                  <label class="custom-file-label">Choose file...</label>
                  <small>
                  <?= lang('Main.xin_company_file_type');?>
                  </small> </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary"> <i data-feather="check"></i>
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