<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\AwardsModel;
use App\Models\ConstantsModel;
use App\Models\TrackgoalsModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();		
$AwardsModel = new AwardsModel();	
$SystemModel = new SystemModel();
$ConstantsModel = new ConstantsModel();
$TrackgoalsModel = new TrackgoalsModel();
$Moduleattributes = new Moduleattributes();
$Moduleattributesval = new Moduleattributesval();
$Moduleattributesvalsel = new Moduleattributesvalsel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$icategory_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','award_type')->findAll();
	$track_goals = $TrackgoalsModel->where('company_id',$user_info['company_id'])->orderBy('tracking_id', 'ASC')->findAll();
	$count_module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',1)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',1)->orderBy('custom_field_id', 'ASC')->findAll();
} else {
	$icategory_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','award_type')->findAll();
	$track_goals = $TrackgoalsModel->where('company_id',$usession['sup_user_id'])->orderBy('tracking_id', 'ASC')->findAll();
	$count_module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',1)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',1)->orderBy('custom_field_id', 'ASC')->findAll();
}
$xin_system = erp_company_settings();

$segment_id = $request->uri->getSegment(3);
$award_id = udecode($segment_id);
$result = $AwardsModel->where('award_id', $award_id)->first();	
?>
<div class="row">
  <div class="col-lg-4">
    <div class="card hdd-right-inner">
      <div class="card-header">
        <h5>
          <?= lang('Employees.xin_view_award');?>
        </h5>
      </div>
      <?php $iuser = $UsersModel->where('user_id', $result['employee_id'])->first(); ?>
      <div class="card-body task-details">
        <table class="table">
          <tbody>
            <tr>
              <td><i class="fas fa-adjust m-r-5"></i> <?php echo lang('Dashboard.dashboard_employee');?>:</td>
              <td class="text-right"><span class="float-right">
                <?php
				if($iuser){
					echo $user_detail = $iuser['first_name'].' '.$iuser['last_name'];
				} else {
					echo $user_detail = lang('Users.xin_user_data_removed');
				}?>
                </span></td>
            </tr>
            <?php $category_info = $ConstantsModel->where('constants_id', $result['award_type_id'])->where('type','award_type')->first();?>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i> <?php echo lang('Employees.xin_award_type');?>:</td>
              <td class="text-right">
              <?php
			    if($category_info){
					$cname = $category_info['category_name'];
				} else {
					$cname = '--';
				}
				echo $cname;
				?>
              </td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i> <?php echo lang('Main.xin_attachment');?>:</td>
              <td class="text-right">
              <?php if($result['award_photo']!='' && $result['award_photo']!='no file') {?>
              <a href="<?php echo site_url()?>download?type=awards&filename=<?php echo uencode($result['award_photo']);?>">
              <?= lang('Main.xin_download');?>
              </a>
              <?php } ?>
              </td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i> <?php echo lang('Main.xin_created_at');?>:</td>
              <td class="text-right"><?= set_date_format($result['created_at']);?></td>
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
          <?php if(in_array('award3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>  
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
          <?= $cname; ?>
        </h5>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table m-b-0 f-14 b-solid requid-table">
                <tbody class="text-muted">
                  <tr>
                    <td><?= lang('Employees.xin_award_date');?></td>
                    <td><?= set_date_format($result['created_at']);?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Employees.xin_award_month_year');?></td>
                    <td><?= $result['award_month_year'];?></td>
                  </tr>
                  <tr>
                    <td><?= lang('Employees.xin_gift');?></td>
                    <td><?= $result['gift_item'];?></td>
                  </tr>
                  <tr>
                    <td><?= lang('Employees.xin_cash');?></td>
                    <td><?= number_to_currency($result['cash_price'], $xin_system['default_currency'],null,2);?></td>
                  </tr>
                  </td>
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
              <h6><?php echo lang('Employees.xin_award_info');?></h6>
              <hr>
              <?php echo html_entity_decode($result['award_information']);?>
            </div>
            <div class="m-b-30 m-t-15">
              <h6><?php echo lang('Main.xin_description');?></h6>
              <hr>
              <?php echo html_entity_decode($result['description']);?>
            </div>
          </div>
        </div>
        <?php if(in_array('award3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="tab-pane fade" id="pills-edit" role="tabpanel" aria-labelledby="pills-edit-tab">
		<?php $attributes = array('name' => 'edit_award', 'id' => 'edit_award', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
		<?php $hidden = array('_method' => 'EDIT', 'token' => $segment_id);?>
        <?php echo form_open('erp/awards/update_award', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="award_type">
                      <?= lang('Employees.xin_award_type');?> <span class="text-danger">*</span>
                    </label>
                    <select name="award_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_award_type');?>">
                      <option value=""></option>
                      <?php foreach($icategory_info as $as_category) {?>
                      <option value="<?= $as_category['constants_id']?>" <?php if($as_category['constants_id']==$result['award_type_id']):?> selected="selected"<?php endif;?>>
                      <?= $as_category['category_name']?>
                      </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="gift">
                      <?= lang('Employees.xin_gift');?> 
                    </label>
                    <div class="input-group">
                      <div class="input-group-append"><span class="input-group-text"><i class="fas fa-gift"></i></span></div>
                      <input class="form-control" placeholder="<?= lang('Employees.xin_award_gift');?>" name="gift" type="text" value="<?php echo $result['gift_item'];?>">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="award_date">
                      <?= lang('Main.xin_e_details_date');?> <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                      <input class="form-control date" placeholder="<?= lang('Employees.xin_award_date');?>" name="award_date" type="text" value="<?php echo $result['created_at'];?>">
                      <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cash">
                      <?= lang('Employees.xin_cash');?> <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                      <div class="input-group-append"><span class="input-group-text">
                        <?= $xin_system['default_currency'];?>
                        </span></div>
                      <input class="form-control" placeholder="<?= lang('Employees.xin_award_cash');?>" name="cash" type="text" value="<?php echo $result['cash_price'];?>">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="month_year">
                      <?= lang('Employees.xin_award_month_year');?> <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                      <input class="form-control hr_month_year" readonly="readonly" placeholder="<?= lang('Employees.xin_award_month_year');?>" name="month_year" type="text" value="<?php echo $result['award_month_year'];?>">
                      <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="logo">
                      <?= lang('Employees.xin_award_attachment');?>
                      <span class="text-danger">*</span> </label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="award_picture">
                      <label class="custom-file-label">
                        <?= lang('Main.xin_choose_file');?>
                      </label>
                      <small>
                      <?= lang('Main.xin_company_file_type');?>
                      </small> </div>
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
                    <label for="award_information">
                      <?= lang('Employees.xin_award_info');?> <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control" placeholder="<?= lang('Employees.xin_award_info');?>" name="award_information" cols="30" rows="2" id="award_information"><?php echo $result['award_information'];?></textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="description">
                      <?= lang('Main.xin_description');?>
                    </label>
                    <textarea class="form-control editor" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="30" rows="2"><?php echo $result['description'];?></textarea>
                  </div>
                </div>
              </div>
              <?php if($count_module_attributes > 0):?>
                <div class="row">
                  <?php foreach($module_attributes as $mattribute):?>
                  <?php $attribute_info = $Moduleattributesval->where('user_id',$award_id)->where('module_attributes_id', $mattribute['custom_field_id'])->first();?>
                  <?php
						if($attribute_info){
							$attr_val = $attribute_info['attribute_value'];
						} else {
							$attr_val = '';
						}
					?>
                  <?php if($mattribute['attribute_type'] == 'date'){?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <input class="form-control date" 
                      placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text" value="<?= $attr_val;?>">
                    </div>
                  </div>
                  <?php } else if($mattribute['attribute_type'] == 'select'){?>
                  <?php $iselc_val = $Moduleattributesvalsel->where('custom_field_id', $mattribute['custom_field_id'])->first();?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <?php $iselc_val = $Moduleattributesvalsel->where('custom_field_id',$mattribute['custom_field_id'])->findAll();?>
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <select class="form-control" name="<?php echo $mattribute['attribute'];?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute['attribute_label'];?>">
                        <?php foreach($iselc_val as $selc_val) {?>
                        <option value="<?php echo $selc_val['attributes_select_value_id']?>" <?php if($attr_val==$selc_val['attributes_select_value_id']):?> selected="selected"<?php endif;?>><?php echo $selc_val['select_label']?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } else if($mattribute['attribute_type'] == 'textarea'){?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <textarea class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text"><?= $attr_val;?></textarea>
                    </div>
                  </div>
                  <?php } else { ?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <input class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text" value="<?= $attr_val;?>">
                    </div>
                  </div>
                  <?php }	?>
                  <?php endforeach;?>
                </div>
                <?php endif;?>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_update');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
.ui-datepicker-div { top:500px !important; }
</style>