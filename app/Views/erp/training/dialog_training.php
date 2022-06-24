<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\TrainingModel;
use App\Models\TrainersModel;
use App\Models\ConstantsModel;
use App\Models\TrackgoalsModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();	
$SystemModel = new SystemModel();			
$TrainingModel = new TrainingModel();
$TrainersModel = new TrainersModel();
$ConstantsModel = new ConstantsModel();
$TrackgoalsModel = new TrackgoalsModel();
$Moduleattributes = new Moduleattributes();
$Moduleattributesval = new Moduleattributesval();
$Moduleattributesvalsel = new Moduleattributesvalsel();
$get_animate = '';
$xin_system = erp_company_settings();
if($request->getGet('data') === 'training' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $TrainingModel->where('training_id', $ifield_id)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'company'){
	$trainer = $TrainersModel->where('company_id', $usession['sup_user_id'])->orderBy('trainer_id','ASC')->findAll();
	$track_goals = $TrackgoalsModel->where('company_id',$usession['sup_user_id'])->orderBy('tracking_id', 'ASC')->findAll();
	$training_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','training_type')->orderBy('constants_id', 'ASC')->findAll();
	$count_module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',4)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',4)->orderBy('custom_field_id', 'ASC')->findAll();
} else {
	$trainer = $TrainersModel->where('company_id', $user_info['company_id'])->orderBy('trainer_id','ASC')->findAll();
	$track_goals = $TrackgoalsModel->where('company_id',$user_info['company_id'])->orderBy('tracking_id', 'ASC')->findAll();
	$training_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','training_type')->orderBy('constants_id', 'ASC')->findAll();
	$count_module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',4)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',4)->orderBy('custom_field_id', 'ASC')->findAll();
}
$xin_com_system = erp_company_settings();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Dashboard.left_edit_training');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_training', 'id' => 'edit_training', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/training/update_training', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="training_type">
          <?= lang('Dashboard.left_training_skill');?> <span class="text-danger">*</span>
        </label>
        <select class="form-control" name="training_type" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_training_skill');?>">
          <option value=""></option>
          <?php foreach($training_types as $itraining_type) {?>
          <option value="<?php echo $itraining_type['constants_id']?>" <?php if($result['training_type_id']==$itraining_type['constants_id']):?> selected="selected" <?php endif;?>><?php echo $itraining_type['category_name']?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="trainer">
          <?= lang('Dashboard.left_trainer');?> <span class="text-danger">*</span>
        </label>
        <select class="form-control" name="trainer" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_trainer');?>">
          <option value=""></option>
          <?php foreach($trainer as $staff) {?>
          <option value="<?= $staff['trainer_id']?>" <?php if($result['trainer_id']==$staff['trainer_id']):?> selected="selected" <?php endif;?>>
          <?= $staff['first_name'].' '.$staff['last_name'] ?>
          </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="training_cost">
          <?= lang('Main.xin_training_cost');?>
        </label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text">
            <?= $xin_system['default_currency'];?>
            </span></div>
          <input class="form-control" placeholder="<?= lang('Main.xin_training_cost');?>" name="training_cost" type="text" value="<?php echo $result['training_cost'];?>">
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <?php if($user_info['user_type'] == 'company'){?>
    <?php $istaff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
    <?php $assigned_ids = explode(',',$result['employee_id']); ?>
    <input type="hidden" value="0" name="employee_id[]" />
    <div class="col-md-6">
      <div class="form-group">
        <label for="employee" class="control-label">
          <?= lang('Dashboard.dashboard_employees');?>
        </label>
        <select multiple class="form-control" name="employee_id[]" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employees');?>">
          <option value=""></option>
          <?php foreach($istaff_info as $istaff) {?>
          <option value="<?= $istaff['user_id']?>" <?php if(in_array($istaff['user_id'],$assigned_ids)):?> selected <?php endif; ?>>
          <?= $istaff['first_name'].' '.$istaff['last_name'] ?>
          </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <?php } ?>
    <div class="col-md-3">
      <div class="form-group">
        <label for="start_date">
          <?= lang('Projects.xin_start_date');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <input class="form-control d_date" placeholder="<?= lang('Projects.xin_start_date');?>" name="start_date" type="text" value="<?php echo $result['start_date'];?>">
          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="end_date">
          <?= lang('Projects.xin_end_date');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <input class="form-control d_date" placeholder="<?= lang('Projects.xin_end_date');?>" name="end_date" type="text" value="<?php echo $result['finish_date'];?>">
          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
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
        <textarea class="form-control meditor" placeholder="<?= lang('Main.xin_description');?>" name="description" rows="4" id="description2"><?php echo $result['description'];?></textarea>
      </div>
    </div>
  </div>
  <?php if($count_module_attributes > 0):?>
    <div class="row">
      <?php foreach($module_attributes as $mattribute):?>
      <?php $attribute_info = $Moduleattributesval->where('user_id',$ifield_id)->where('module_attributes_id', $mattribute['custom_field_id'])->first();?>
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
          <input class="form-control d_date" 
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
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_update');?>
  </button>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
$(document).ready(function(){
						
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
	Ladda.bind('button[type=submit]');	 
	//$('#description2').trumbowyg();
	$('.d_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: '<?= js_set_date_format();?>',
		lang: '<?= $xin_com_system['datepicker_locale'];?>'
	});
	$(".meditor").kendoEditor({
		resizable: {
			content: true,
			toolbar: true
		}
	});
	
	/* Edit data */
	$("#edit_training").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'edit_record');
		fd.append("form", action);
		e.preventDefault();
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
						Ladda.stopAll();
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?= site_url("erp/training/training_list") ?>",
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
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_token"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			} 	        
	   });
	});
});	
</script>
<?php }
?>
