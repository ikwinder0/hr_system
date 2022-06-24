<?php
use App\Models\KpaModel;
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\ConstantsModel;
use App\Models\KpaoptionsModel;

$KpaModel = new KpaModel();
$UsersModel = new UsersModel();
$SystemModel = new SystemModel();
$LanguageModel = new LanguageModel();
$ConstantsModel = new ConstantsModel();
$KpaoptionsModel = new KpaoptionsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$request = \Config\Services::request();
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();

$segment_id = $request->uri->getSegment(3);
$ifield_id = udecode($segment_id);

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$staff_info = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','staff')->findAll();
	$kpa_data = $KpaModel->where('company_id',$user_info['company_id'])->where('performance_appraisal_id',$ifield_id)->first();
	$competencies = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies')->orderBy('constants_id', 'ASC')->findAll();
	$competencies2 = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies2')->orderBy('constants_id', 'ASC')->findAll();
	// count
	$count_competencies = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies')->countAllResults();
	$count_competencies2 = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies2')->countAllResults();
	$single_user = $UsersModel->where('company_id',$user_info['company_id'])->where('user_id',$kpa_data['employee_id'])->where('user_type','staff')->first();
	if($single_user){
		$user_staff = $single_user['first_name'].' '.$single_user['last_name'];
	} else {
		$user_staff = '--';
	}
} else {
	$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
	$kpa_data = $KpaModel->where('company_id',$usession['sup_user_id'])->where('performance_appraisal_id',$ifield_id)->first();
	$competencies = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies')->orderBy('constants_id', 'ASC')->findAll();
	$competencies2 = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies2')->orderBy('constants_id', 'ASC')->findAll();
	// count
	$count_competencies = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies')->countAllResults();
	$count_competencies2 = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies2')->countAllResults();
	$single_user = $UsersModel->where('company_id',$usession['sup_user_id'])->where('user_id',$kpa_data['employee_id'])->where('user_type','staff')->first();
	if($single_user){
		$user_staff = $single_user['first_name'].' '.$single_user['last_name'];
	} else {
		$user_staff = '--';
	}
}
?>
<?php
$kpa_count_val = $KpaoptionsModel->where('appraisal_id',$ifield_id)->findAll();
$star_value = 0;
foreach($kpa_count_val as $nw_starval){
	$star_value += $nw_starval['appraisal_option_value'];
}
$total_comp = $count_competencies+$count_competencies2;
$total_val = $total_comp * 5;
///
if($total_val < 1){
	$rating_val = 0;
} else {
	$rating_val = $star_value / $total_val * 5;
	$rating_val = number_format((float)$rating_val, 1, '.', '');
}
$added_by = $UsersModel->where('user_id',$kpa_data['added_by'])->first();
if($added_by){
	$iadded_by = $added_by['first_name'].' '.$added_by['last_name'];
} else {
	$iadded_by = '--';
}
?>

<div class="row"> 
  <!-- [ task-detail-left ] start -->
  <div class="col-xl-4 col-lg-12 task-detail-right">
    <div class="card">
      <div class="card-header">
        <h5><?php echo lang('Performance.xin_performance_details');?></h5>
      </div>
      <div class="card-body task-details">
        <table class="table">
          <tbody>
            <tr>
              <td><i class="fas fa-adjust m-r-5"></i> <?php echo lang('Dashboard.xin_title');?>:</td>
              <td class="text-right"><span class="float-right">
                <?= $kpa_data['title'];?>
                </span></td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i> <?php echo lang('Performance.xin_appraisal_date');?>:</td>
              <td class="text-right"><?= $kpa_data['appraisal_year_month'];?></td>
            </tr>
            <tr>
              <td><i class="fas fa-user m-r-5"></i> <?php echo lang('Dashboard.dashboard_employee');?>:</td>
              <td class="text-right"><?= $user_staff;?></td>
            </tr>
            <tr>
              <td><i class="fas fa-user-plus m-r-5"></i> <?php echo lang('Main.xin_added_by');?>:</td>
              <td class="text-right"><?= $iadded_by;?></td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i> <?php echo lang('Main.xin_created_at');?>:</td>
              <td class="text-right"><?= set_date_format($kpa_data['created_at']);?></td>
            </tr>
            <tr>
              <td colspan="2" class="text-center"><?php
				$total_stars = '<span class="overall-stars">';
				for ( $i = 1; $i <= 5; $i++ ) {
					if ( round( $rating_val - .49 ) >= $i ) {
						$total_stars .= "<i class='fa fa-star'></i>"; //fas fa-star for v5
					} elseif ( round( $rating_val + .49 ) >= $i ) {
						$total_stars .= "<i class='fas fa-star-half-alt'></i>"; //fas fa-star-half-alt for v5
					} else {
						$total_stars .= "<i class='far fa-star'></i>"; //far fa-star for v5
					}
				}
				$total_stars .= '</span>';
				echo $total_stars;
				?>
                <p class="title current-rating"><?php echo lang('Performance.xin_overall_rating');?>:
                  <?= $rating_val;?>
                </p></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="bg-light card mb-2">
      <div class="card-body">
        <ul class="nav nav-pills mb-0">
          <li class="nav-item m-r-5"> <a href="#pills-overview" data-toggle="tab" aria-expanded="false" class="">
            <button type="button" class="btn btn-shadow btn-secondary text-uppercase">
            <?= lang('Main.xin_overview');?>
            </button>
            </a> </li>
          <?php if(in_array('appraisal3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
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
          <?= lang('Performance.xin_performance_details');?>
        </h5>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th colspan="3"><?php echo lang('Performance.xin_performance_technical');?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="table-success">
                        <th colspan="2"><?php echo lang('Dashboard.left_performance_xappraisal');?></th>
                        <th><?php echo lang('Performance.xin_set_value');?></th>
                      </tr>
                      <?php foreach($competencies as $itech_comp):?>
                      <?php $kpa_tech_comp = $KpaoptionsModel->where('appraisal_id',$ifield_id)->where('appraisal_option_id',$itech_comp['constants_id'])->first();?>
                      <?php if($kpa_tech_comp){?>
                      <tr class="m-b-2">
                        <td scope="row" colspan="2"><?php echo $itech_comp['category_name'];?></td>
                        <td>
                        <?php
						$itotal_stars = "<span class='overall-stars'>";
						for ( $i = 1; $i <= 5; $i++ ) {
							if ( round( $kpa_tech_comp['appraisal_option_value'] - .49 ) >= $i ) {
								$itotal_stars .= "<i class='fa fa-star'></i>"; //fas fa-star for v5
							} elseif ( round( $kpa_tech_comp['appraisal_option_value'] + .49 ) >= $i ) {
								$itotal_stars .= "<i class='fas fa-star-half-alt'></i>"; //fas fa-star-half-alt for v5
							} else {
								$itotal_stars .= "<i class='far fa-star'></i>"; //far fa-star for v5
							}
						}
						$itotal_stars .= '</span>';
						echo $itotal_stars;
						?>
                        </td>
                      </tr>
                      <?php } ?>
                      <?php endforeach;?>
                    </tbody>
                  </table>
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th colspan="3"><?php echo lang('Performance.xin_performance_org');?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="table-success">
                        <th colspan="2"><?php echo lang('Dashboard.left_performance_xappraisal');?></th>
                        <th><?php echo lang('Performance.xin_set_value');?></th>
                      </tr>
                      <?php foreach($competencies2 as $iorg_comp):?>
                      <?php $kpa_org_comp = $KpaoptionsModel->where('appraisal_id',$ifield_id)->where('appraisal_option_id',$iorg_comp['constants_id'])->first();?>
                      <?php if($kpa_org_comp){?>
                      <tr class="m-b-2">
                        <td scope="row" colspan="2"><?php echo $iorg_comp['category_name'];?></td>
                        <td>
                        <?php
						$ototal_stars = "<span class='overall-stars'>";
						for ( $i = 1; $i <= 5; $i++ ) {
							if ( round( $kpa_org_comp['appraisal_option_value'] - .49 ) >= $i ) {
								$ototal_stars .= "<i class='fa fa-star'></i>"; //fas fa-star for v5
							} elseif ( round( $kpa_org_comp['appraisal_option_value'] + .49 ) >= $i ) {
								$ototal_stars .= "<i class='fas fa-star-half-alt'></i>"; //fas fa-star-half-alt for v5
							} else {
								$ototal_stars .= "<i class='far fa-star'></i>"; //far fa-star for v5
							}
						}
						$ototal_stars .= '</span>';
						echo $ototal_stars;
						?>
                        </td>
                      </tr>
                      <?php } ?>
                      <?php endforeach;?>
                    </tbody>
                  </table>
            </div>
            <div class="m-b-30 m-t-15">
              <h6><?php echo lang('Recruitment.xin_remarks');?></h6>
              <hr>
              <?= $kpa_data['remarks'];?>
            </div>
          </div>
        </div>
        <?php if(in_array('appraisal3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="tab-pane fade" id="pills-edit" role="tabpanel" aria-labelledby="pills-edit-tab">
          <?php $attributes = array('name' => 'update_appraisal', 'id' => 'update_appraisal', 'autocomplete' => 'off');?>
		  <?php $hidden = array('token' => $segment_id);?>
          <?php echo form_open('erp/talent/update_appraisal', $attributes, $hidden);?>
           <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="title">
                    <?= lang('Dashboard.xin_title');?>
                    <span class="text-danger">*</span> </label>
                  <input class="form-control" placeholder="<?php echo lang('Dashboard.xin_title');?>" name="title" type="text" value="<?= $kpa_data['title'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="employee_id">
                    <?= lang('Dashboard.dashboard_employee');?>
                    <span class="text-danger">*</span> </label>
                  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo lang('Dashboard.dashboard_employee');?>" name="employee_id" id="employee_id">
                    <option value=""></option>
                    <?php foreach($staff_info as $staff) {?>
                    <option value="<?= $staff['user_id']?>" <?php if($staff['user_id'] == $kpa_data['employee_id']):?> selected="selected"<?php endif;?>>
                    <?= $staff['first_name'].' '.$staff['last_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="month_year">
                    <?= lang('Payroll.xin_select_month');?>
                    <span class="text-danger">*</span> </label>
                  <div class="input-group">
                    <input class="form-control hr_month_year" placeholder="<?php echo lang('Payroll.xin_select_month');?>" name="month_year" type="text" value="<?= $kpa_data['appraisal_year_month'];?>">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row m-b-1">
              <div class="col-md-12 table-border-style">
                <div class="table-responsive">
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th colspan="3"><?php echo lang('Performance.xin_performance_technical');?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="table-success">
                        <th colspan="2"><?php echo lang('Dashboard.left_performance_xappraisal');?></th>
                        <th><?php echo lang('Performance.xin_set_value');?></th>
                      </tr>
                      <?php foreach($competencies as $itech_comp):?>
                      <?php $kpa_tech_comp = $KpaoptionsModel->where('appraisal_id',$ifield_id)->where('appraisal_option_id',$itech_comp['constants_id'])->first();?>
                      <tr class="m-b-2">
                        <td scope="row" colspan="2"><?php echo $itech_comp['category_name'];?></td>
                        <td><select class="bar-rating" name="technical_competencies_value[<?= $kpa_tech_comp['performance_appraisal_options_id'];?>][<?= $itech_comp['constants_id'];?>]" autocomplete="off">
                            <option value="1" <?php if($kpa_tech_comp['appraisal_option_value'] == 1):?> selected="selected"<?php endif;?>>1</option>
                            <option value="2" <?php if($kpa_tech_comp['appraisal_option_value'] == 2):?> selected="selected"<?php endif;?>>2</option>
                            <option value="3" <?php if($kpa_tech_comp['appraisal_option_value'] == 3):?> selected="selected"<?php endif;?>>3</option>
                            <option value="4" <?php if($kpa_tech_comp['appraisal_option_value'] == 4):?> selected="selected"<?php endif;?>>4</option>
                            <option value="5" <?php if($kpa_tech_comp['appraisal_option_value'] == 5):?> selected="selected"<?php endif;?>>5</option>
                          </select>
                          <div class="br-current-rating"></div></td>
                      </tr>
                      <?php endforeach;?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th colspan="3"><?php echo lang('Performance.xin_performance_org');?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="table-success">
                        <th colspan="2"><?php echo lang('Dashboard.left_performance_xappraisal');?></th>
                        <th><?php echo lang('Performance.xin_set_value');?></th>
                      </tr>
                      <?php foreach($competencies2 as $iorg_comp):?>
                      <?php $kpa_org_comp = $KpaoptionsModel->where('appraisal_id',$ifield_id)->where('appraisal_option_id',$iorg_comp['constants_id'])->first();?>
                      <tr class="m-b-2">
                        <td scope="row" colspan="2"><?php echo $iorg_comp['category_name'];?></td>
                        <td><select name="organizational_competencies_value[<?= $kpa_org_comp['performance_appraisal_options_id'];?>][<?= $iorg_comp['constants_id'];?>]" class="bar-rating" autocomplete="off">
                            <option value="1" <?php if($kpa_org_comp['appraisal_option_value'] == 1):?> selected="selected"<?php endif;?>>1</option>
                            <option value="2" <?php if($kpa_org_comp['appraisal_option_value'] == 2):?> selected="selected"<?php endif;?>>2</option>
                            <option value="3" <?php if($kpa_org_comp['appraisal_option_value'] == 3):?> selected="selected"<?php endif;?>>3</option>
                            <option value="4" <?php if($kpa_org_comp['appraisal_option_value'] == 4):?> selected="selected"<?php endif;?>>4</option>
                            <option value="5" <?php if($kpa_org_comp['appraisal_option_value'] == 5):?> selected="selected"<?php endif;?>>5</option>
                          </select></td>
                      </tr>
                      <?php endforeach;?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="bg-white">
                  <div class="form-group">
                    <label for="remarks"><?php echo lang('Recruitment.xin_remarks');?></label>
                    <textarea class="form-control textarea" placeholder="<?php echo lang('Recruitment.xin_remarks');?>" name="remarks" id="remarks" rows="4"><?= $kpa_data['remarks'];?>
        </textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Performance.xin_update_performance');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php /*?><div class="col-xl-8 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5>
          <?= lang('Performance.xin_update_performance');?>
        </h5>
      </div>
      <?php if(in_array('appraisal3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <?php $attributes = array('name' => 'update_appraisal', 'id' => 'update_appraisal', 'autocomplete' => 'off');?>
      <?php $hidden = array('token' => $segment_id);?>
      <?php echo form_open('erp/talent/update_appraisal', $attributes, $hidden);?>
      <?php } ?>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="title">
                <?= lang('Dashboard.xin_title');?>
                <span class="text-danger">*</span> </label>
              <input class="form-control" placeholder="<?php echo lang('Dashboard.xin_title');?>" name="title" type="text" value="<?= $kpa_data['title'];?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="employee_id">
                <?= lang('Dashboard.dashboard_employee');?>
                <span class="text-danger">*</span> </label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo lang('Dashboard.dashboard_employee');?>" name="employee_id" id="employee_id">
                <option value=""></option>
                <?php foreach($staff_info as $staff) {?>
                <option value="<?= $staff['user_id']?>" <?php if($staff['user_id'] == $kpa_data['employee_id']):?> selected="selected"<?php endif;?>>
                <?= $staff['first_name'].' '.$staff['last_name'] ?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="month_year">
                <?= lang('Payroll.xin_select_month');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control hr_month_year" placeholder="<?php echo lang('Payroll.xin_select_month');?>" name="month_year" type="text" value="<?= $kpa_data['appraisal_year_month'];?>">
                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row m-b-1">
          <div class="col-md-12 table-border-style">
            <div class="table-responsive">
              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th colspan="3"><?php echo lang('Performance.xin_performance_technical');?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="table-success">
                    <th colspan="2"><?php echo lang('Dashboard.left_performance_xappraisal');?></th>
                    <th><?php echo lang('Performance.xin_set_value');?></th>
                  </tr>
                  <?php foreach($competencies as $itech_comp):?>
                  <?php $kpa_tech_comp = $KpaoptionsModel->where('appraisal_id',$ifield_id)->where('appraisal_option_id',$itech_comp['constants_id'])->first();?>
                  <tr class="m-b-2">
                    <td scope="row" colspan="2"><?php echo $itech_comp['category_name'];?></td>
                    <td><select class="bar-rating" name="technical_competencies_value[<?= $kpa_tech_comp['performance_appraisal_options_id'];?>][<?= $itech_comp['constants_id'];?>]" autocomplete="off">
                        <option value="1" <?php if($kpa_tech_comp['appraisal_option_value'] == 1):?> selected="selected"<?php endif;?>>1</option>
                        <option value="2" <?php if($kpa_tech_comp['appraisal_option_value'] == 2):?> selected="selected"<?php endif;?>>2</option>
                        <option value="3" <?php if($kpa_tech_comp['appraisal_option_value'] == 3):?> selected="selected"<?php endif;?>>3</option>
                        <option value="4" <?php if($kpa_tech_comp['appraisal_option_value'] == 4):?> selected="selected"<?php endif;?>>4</option>
                        <option value="5" <?php if($kpa_tech_comp['appraisal_option_value'] == 5):?> selected="selected"<?php endif;?>>5</option>
                      </select>
                      <div class="br-current-rating"></div></td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th colspan="3"><?php echo lang('Performance.xin_performance_org');?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="table-success">
                    <th colspan="2"><?php echo lang('Dashboard.left_performance_xappraisal');?></th>
                    <th><?php echo lang('Performance.xin_set_value');?></th>
                  </tr>
                  <?php foreach($competencies2 as $iorg_comp):?>
                  <?php $kpa_org_comp = $KpaoptionsModel->where('appraisal_id',$ifield_id)->where('appraisal_option_id',$iorg_comp['constants_id'])->first();?>
                  <tr class="m-b-2">
                    <td scope="row" colspan="2"><?php echo $iorg_comp['category_name'];?></td>
                    <td><select name="organizational_competencies_value[<?= $kpa_org_comp['performance_appraisal_options_id'];?>][<?= $iorg_comp['constants_id'];?>]" class="bar-rating" autocomplete="off">
                        <option value="1" <?php if($kpa_org_comp['appraisal_option_value'] == 1):?> selected="selected"<?php endif;?>>1</option>
                        <option value="2" <?php if($kpa_org_comp['appraisal_option_value'] == 2):?> selected="selected"<?php endif;?>>2</option>
                        <option value="3" <?php if($kpa_org_comp['appraisal_option_value'] == 3):?> selected="selected"<?php endif;?>>3</option>
                        <option value="4" <?php if($kpa_org_comp['appraisal_option_value'] == 4):?> selected="selected"<?php endif;?>>4</option>
                        <option value="5" <?php if($kpa_org_comp['appraisal_option_value'] == 5):?> selected="selected"<?php endif;?>>5</option>
                      </select></td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white">
              <div class="form-group">
                <label for="remarks"><?php echo lang('Recruitment.xin_remarks');?></label>
                <textarea class="form-control textarea" placeholder="<?php echo lang('Recruitment.xin_remarks');?>" name="remarks" id="remarks"><?= $kpa_data['remarks'];?>
</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if(in_array('appraisal3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary">
        <?= lang('Performance.xin_update_performance');?>
        </button>
      </div>
      <?= form_close(); ?>
      <?php } ?>
    </div>
  </div><?php */?>
  <style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>
</div>
