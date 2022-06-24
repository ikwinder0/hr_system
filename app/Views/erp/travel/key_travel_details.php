<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\TravelModel;
use App\Models\ConstantsModel;
use App\Models\TrackgoalsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();		
$TravelModel = new TravelModel();	
$SystemModel = new SystemModel();
$ConstantsModel = new ConstantsModel();
$TrackgoalsModel = new TrackgoalsModel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','travel_type')->findAll();
	$staff_info = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','staff')->findAll();
	$track_goals = $TrackgoalsModel->where('company_id',$user_info['company_id'])->orderBy('tracking_id', 'ASC')->findAll();
} else {
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','travel_type')->findAll();
	$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
	$track_goals = $TrackgoalsModel->where('company_id',$usession['sup_user_id'])->orderBy('tracking_id', 'ASC')->findAll();
}
$xin_system = erp_company_settings();

$segment_id = $request->uri->getSegment(3);
$travel_id = udecode($segment_id);
$result = $TravelModel->where('travel_id', $travel_id)->first();
?>
<?php
	if($result['status']=='0'):
		$status = '<div class="alert alert-warning d-block text-center text-uppercase">'.lang('Dashboard.left_travel').': '.lang('Main.xin_pending').'</div>';
	elseif($result['status']=='1'):
		$status = '<div class="alert alert-success d-block text-center text-uppercase">'.lang('Dashboard.left_travel').': '.lang('Main.xin_accepted').'</div>';
	else:
		$status = '<div class="alert alert-danger d-block text-center text-uppercase">'.lang('Dashboard.left_travel').': '.lang('Main.xin_rejected').'</div>';
	endif;	
?>

<div class="row">
<?php if(in_array('travel5',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
  <div class="col-lg-4">
    <div class="card hdd-right-inner">
      <div class="card-header">
        <h5>
          <?= lang('Employees.xin_travel_details');?>
        </h5>
        
        <div class="card-header-right"> <a href="<?= site_url('erp/business-travel');?>">
          <button type="button" class="btn btn-shadow btn-secondary btn-sm"><i class="mr-2 feather icon-edit"></i>
          <?= lang('Main.xin_add_new');?>
          <?= lang('Dashboard.left_travel');?>
          </button>
          </a> </div>
      </div>
      <?php if(in_array('travel5',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <?php $attributes = array('name' => 'update_travel_status', 'id' => 'update_travel_status', 'autocomplete' => 'off');?>
      <?php $hidden = array('token' => $segment_id);?>
      <?php echo form_open('erp/travel/update_travel_status', $attributes, $hidden);?>
      <?php } ?>
      <div class="card-body">
        <div class="row mt-2 mb-2">
          <div class="col-md-12"> <span class=" txt-primary"> <i class="fas fa-chart-line"></i> <strong>
            <?= lang('Main.dashboard_xin_status');?> <span class="text-danger">*</span>
            </strong> </span> </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <select name="status" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_xin_status');?>">
                <option value="0" <?php if($result['status']=='0'):?> selected <?php endif; ?>>
                <?= lang('Main.xin_pending');?>
                </option>
                <option value="1" <?php if($result['status']=='1'):?> selected <?php endif; ?>>
                <?= lang('Main.xin_accepted');?>
                </option>
                <option value="2" <?php if($result['status']=='2'):?> selected <?php endif; ?>>
                <?= lang('Main.xin_rejected');?>
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-right">
        <button type="submit" class="btn btn-success">
        <?= lang('Main.xin_update_status');?>
        </button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
  <?php $colmdval = 'col-lg-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-lg-12';?>
  <?php } ?>
  <div class="<?= $colmdval?>">
    <div class="bg-light card mb-2">
      <div class="card-body">
        <ul class="nav nav-pills mb-0">
          <li class="nav-item m-r-5"> <a href="#pills-overview" data-toggle="tab" aria-expanded="false" class="">
            <button type="button" class="btn btn-shadow btn-secondary text-uppercase">
            <?= lang('Main.xin_overview');?>
            </button>
            </a> </li>
          <?php if(in_array('travel3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>  
          <li class="nav-item m-r-5"> <a href="#pills-edit" data-toggle="tab" aria-expanded="false" class="">
            <button type="button" class="btn btn-shadow btn-secondary text-uppercase">
            <?= lang('Main.xin_edit');?>
            </button>
            </a> </li>
         <?php } ?>   
        </ul>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h5><i class="feather icon-lock mr-1"></i>
          <?= lang('Employees.xin_travel_info');?>
        </h5>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table m-b-0 f-14 b-solid requid-table">
                <tbody class="text-muted">
                  <tr>
                    <td><?php echo lang('Projects.xin_start_date');?></td>
                    <td><i class="far fa-calendar-alt"></i>&nbsp;
                      <?= $result['start_date'];?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Projects.xin_end_date');?></td>
                    <td class="text-danger"><i class="far fa-calendar-alt"></i>&nbsp;
                      <?= $result['end_date'];?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Employees.xin_visit_purpose');?></td>
                    <td><?= $result['visit_purpose'];?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Employees.xin_visit_place');?></td>
                    <td><?= $result['visit_place'];?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Employees.xin_travel_mode');?></td>
                    <td><?php if(1==$result['travel_mode']): $tmode = lang('Employees.xin_by_bus');?>
                      <?php endif;?>
                      <?php if(2==$result['travel_mode']): $tmode = lang('Employees.xin_by_train');?>
                      <?php endif;?>
                      <?php if(3==$result['travel_mode']): $tmode = lang('Employees.xin_by_plane');?>
                      <?php endif;?>
                      <?php if(4==$result['travel_mode']): $tmode = lang('Employees.xin_by_taxi');?>
                      <?php endif;?>
                      <?php if(5==$result['travel_mode']): $tmode = lang('Employees.xin_by_rental_car');?>
                      <?php endif;?>
                      <?php echo $tmode;?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Employees.xin_arragement_type');?></td>
                    <td><?php foreach($category_info as $travel_arr_type) {?>
                      <?php if($result['arrangement_type']==$travel_arr_type['constants_id']):?>
                      <?php echo $travel_arr_type['category_name'];?>
                      <?php endif;?>
                      <?php } ?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Main.dashboard_xin_status');?></td>
                    <td><?php if(0==$result['status']): $tstatus = lang('Main.xin_pending');?>
                      <?php endif;?>
                      <?php if(1==$result['status']): $tstatus = lang('Main.xin_accepted');?>
                      <?php endif;?>
                      <?php if(2==$result['status']): $tstatus = lang('Main.xin_rejected');?>
                      <?php endif;?>
                      <?php echo $tstatus;?></td>
                  </tr>
                  <tr>
                    <td><?= lang('Dashboard.dashboard_employee');?></td>
                    <td style="display: table-cell;"><?php $travel_user = $UsersModel->where('user_id', $result['employee_id'])->where('user_type','staff')->first();?>
                      <?php if($travel_user){ ?>
					  	<?= $travel_user['first_name'].' '.$travel_user['last_name'] ?>
                      <?php } else {?>
                      <?= lang('Users.xin_user_data_removed');?>
                      <?php } ?>
                      </td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Employees.xin_expected_travel_budget');?></td>
                    <td class="text-success"><i class="fas fa-money-check-alt"></i>&nbsp;
                      <?= number_to_currency($result['expected_budget'], $xin_system['default_currency'],null,2);?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Employees.xin_actual_travel_budget');?></td>
                    <td class="text-warning"><i class="fas fa-money-check-alt"></i>&nbsp;
                      <?= number_to_currency($result['actual_budget'], $xin_system['default_currency'],null,2);?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <?php $associated_goals = explode(',',$result['associated_goals']); ?>
            <div class="m-b-20 m-t-20">
              <h6><?php echo lang('Main.xin_associated_goals');?></h6>
              <hr>
              <div class="table-responsive">
              <table class="table table-borderless">
                <tbody class="text-muted">
                <?php $gi =1;foreach($track_goals as $track_goal) {?>
				<?php $tracking_type = $ConstantsModel->where('constants_id',$track_goal['tracking_type_id'])->first(); ?>
                <?php if(in_array($tracking_type['constants_id'],$associated_goals)):?>
                <tr>
                  <td><a target="_blank" href="<?= site_url('erp/goal-details/').uencode($track_goal['tracking_id']);?>"><?= $tracking_type['category_name'] ?></a></td>
                </tr>
                <?php endif;?>
                <?php $gi++; } ?>
                </tbody>
              </table>
            </div>
            </div>
            <div class="m-b-30 m-t-15">
              <h6><?php echo lang('Main.xin_description');?></h6>
              <hr>
              <?= html_entity_decode($result['description']);?>
            </div>
          </div>
        </div>
        <?php if(in_array('travel3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="tab-pane fade" id="pills-edit" role="tabpanel" aria-labelledby="pills-edit-tab">
          <?php $attributes = array('name' => 'update_travel', 'id' => 'update_travel', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?php echo form_open('erp/travel/update_travel', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="start_date">
                    <?= lang('Projects.xin_start_date');?> <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?= lang('Projects.xin_start_date');?>" name="start_date" type="text" value="<?php echo $result['start_date'];?>">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="end_date">
                    <?= lang('Projects.xin_end_date');?> <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?= lang('Projects.xin_end_date');?>" name="end_date" type="text" value="<?php echo $result['end_date'];?>">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="travel_mode">
                    <?= lang('Employees.xin_travel_mode');?> <span class="text-danger">*</span>
                  </label>
                  <select class="select2" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_travel_mode');?>" name="travel_mode">
                    <option value="1" <?php if(1==$result['travel_mode']):?> selected="selected"<?php endif;?>>
                    <?= lang('Employees.xin_by_bus');?>
                    </option>
                    <option value="2" <?php if(2==$result['travel_mode']):?> selected="selected"<?php endif;?>>
                    <?= lang('Employees.xin_by_train');?>
                    </option>
                    <option value="3" <?php if(3==$result['travel_mode']):?> selected="selected"<?php endif;?>>
                    <?= lang('Employees.xin_by_plane');?>
                    </option>
                    <option value="4" <?php if(4==$result['travel_mode']):?> selected="selected"<?php endif;?>>
                    <?= lang('Employees.xin_by_taxi');?>
                    </option>
                    <option value="5" <?php if(5==$result['travel_mode']):?> selected="selected"<?php endif;?>>
                    <?= lang('Employees.xin_by_rental_car');?>
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="visit_purpose">
                    <?= lang('Employees.xin_visit_purpose');?> <span class="text-danger">*</span>
                  </label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_visit_purpose');?>" name="visit_purpose" type="text" value="<?php echo $result['visit_purpose'];?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="visit_place">
                    <?= lang('Employees.xin_visit_place');?> <span class="text-danger">*</span>
                  </label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_visit_place');?>" name="visit_place" type="text" value="<?php echo $result['visit_place'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="arrangement_type">
                    <?= lang('Employees.xin_arragement_type');?> <span class="text-danger">*</span>
                  </label>
                  <select class="select2" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_arragement_type');?>" name="arrangement_type">
                    <?php foreach($category_info as $assets_category) {?>
                    <option value="<?= $assets_category['constants_id']?>" <?php if($assets_category['constants_id']==$result['arrangement_type']):?> selected="selected"<?php endif;?>>
                    <?= $assets_category['category_name']?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="expected_budget">
                    <?= lang('Employees.xin_expected_travel_budget');?> <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">
                      <?= $xin_system['default_currency'];?>
                      </span></div>
                    <input class="form-control" placeholder="<?= lang('Employees.xin_expected_travel_budget');?>" name="expected_budget" type="text" value="<?php echo $result['expected_budget'];?>">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="actual_budget">
                    <?= lang('Employees.xin_actual_travel_budget');?> <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">
                      <?= $xin_system['default_currency'];?>
                      </span></div>
                    <input class="form-control" placeholder="<?= lang('Employees.xin_actual_travel_budget');?>" name="actual_budget" type="text" value="<?php echo $result['actual_budget'];?>">
                  </div>
                </div>
              </div>
              <input type="hidden" value="0" name="associated_goals[]" />
              <?php $associated_goals = explode(',',$result['associated_goals']); ?>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="employee"><?php echo lang('Main.xin_associated_goals');?></label>
                  <select multiple name="associated_goals[]" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo lang('Main.xin_associated_goals');?>">
                    <option value=""></option>
                    <?php foreach($track_goals as $track_goal) {?>
                    <?php $tracking_type = $ConstantsModel->where('constants_id',$track_goal['tracking_type_id'])->first(); ?>
                    <option value="<?= $tracking_type['constants_id']?>" <?php if(in_array($tracking_type['constants_id'],$associated_goals)):?> selected="selected"<?php endif;?>>
                    <?= $tracking_type['category_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="description">
                    <?= lang('Main.xin_description');?>
                  </label>
                  <textarea class="form-control editor" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="30" rows="3"><?php echo $result['description'];?></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Employees.xin_update_travel_info');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
