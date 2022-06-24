<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\AwardsModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();		
$AwardsModel = new AwardsModel();	
$SystemModel = new SystemModel();
$ConstantsModel = new ConstantsModel();
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','award_type')->findAll();
} else {
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','award_type')->findAll();
}
$xin_system = erp_company_settings();
/* Assets view
*/
$get_animate = '';
if($request->getGet('data') === 'award' && $request->getGet('field_id')){
$award_id = udecode($field_id);
$result = $AwardsModel->where('award_id', $award_id)->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_edit_award');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_award', 'id' => 'edit_award', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/awards/update_award', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="award_type">
          <?= lang('Employees.xin_award_type');?> <span class="text-danger">*</span>
        </label>
        <select name="award_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_award_type');?>">
          <option value=""></option>
          <?php foreach($category_info as $as_category) {?>
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
          <input class="form-control d_award_date" placeholder="<?= lang('Employees.xin_award_date');?>" name="award_date" type="text" value="<?php echo $result['created_at'];?>">
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
          <input class="form-control d_month_year" placeholder="<?= lang('Employees.xin_award_month_year');?>" name="month_year" type="text" value="<?php echo $result['award_month_year'];?>">
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
    <div class="col-md-6">
      <div class='form-group'>
        <label for="logo">&nbsp;</label>
        <?php if($result['award_photo']!='' && $result['award_photo']!='no file') {?>
        <img src="<?php echo base_url().'/public/uploads/awards/'.$result['award_photo'];?>" class="d-block" width="70px" id="u_file"> <a href="<?php echo site_url()?>download?type=awards&filename=<?php echo uencode($result['award_photo']);?>">
        <?= lang('Main.xin_download');?>
        </a>
        <?php } else {?>
        <p>&nbsp;</p>
        <?php } ?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="description">
          <?= lang('Main.xin_description');?>
        </label>
        <textarea class="form-control textarea" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="30" rows="2"><?php echo $result['description'];?></textarea>
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
  </div>
</div>
<!--</div>-->
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_update');?>
  </button>
</div>
<?php echo form_close(); ?>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
.ui-datepicker-div { top:500px !important; }
</style>
<script type="text/javascript">
 $(document).ready(function(){	
		Ladda.bind('button[type=submit]');
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		// Award Date
		$('.d_award_date').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		});
		$('.d_month_year').datepicker({
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat:'yy-mm',
			yearRange: '1900:' + (new Date().getFullYear() + 15),
			beforeShow: function(input) {
				$(input).datepicker("widget").addClass('hide-calendar');
			},
			onClose: function(dateText, inst) {
				var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				$(this).datepicker('setDate', new Date(year, month, 1));
				$(this).datepicker('widget').removeClass('hide-calendar');
				$(this).datepicker('widget').hide();
			}
				
		});		
		$("#edit_award").submit(function(e){
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
							url : "<?php echo site_url("erp/awards/awards_list") ?>",
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
<?php } elseif($request->getGet('type') === 'view_award' && $request->getGet('field_id')){
$award_id = udecode($field_id);
$result = $AwardsModel->where('award_id', $award_id)->first();
?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_view_award');?>
  </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="<?= lang('Main.xin_close');?>"> <span aria-hidden="true">×</span> </button>
</div>

<div class="modal-body">
  <table class="footable-details table table-striped table-hover toggle-circle">
    <tbody>
      <tr>
        <?php $user_info = $UsersModel->where('user_id', $result['employee_id'])->first(); ?>
        <th><?= lang('Dashboard.dashboard_employee');?></th>
        <td style="display: table-cell;"><?php echo $user_info['first_name'].' '.$user_info['last_name'];?></td>
      </tr>
      <?php $category_info = $ConstantsModel->where('constants_id', $result['award_type_id'])->where('type','award_type')->first();?>
      <tr>
        <th><?= lang('Employees.xin_award_type');?></th>
        <td style="display: table-cell;"><?= $category_info['category_name'] ?></td>
      </tr>
      <tr>
        <th><?= lang('Employees.xin_award_date');?></th>
        <td style="display: table-cell;"><?= set_date_format($result['created_at']);?></td>
      </tr>
      <tr>
        <th><?= lang('Employees.xin_award_month_year');?></th>
        <td style="display: table-cell;"><?= $result['award_month_year'];?></td>
      </tr>
      <tr>
        <th><?= lang('Employees.xin_gift');?></th>
        <td style="display: table-cell;"><?php echo $result['gift_item'];?></td>
      </tr>
      <tr>
        <th><?= lang('Employees.xin_cash');?></th>
        <td style="display: table-cell;"><?= number_to_currency($result['cash_price'], $xin_system['default_currency'],null,2);?></td>
      </tr>
      <tr>
        <th><?= lang('Main.xin_attachment');?></th>
        <td style="display: table-cell;"><?php if($result['award_photo']!='' && $result['award_photo']!='no file') {?>
          <img src="<?php echo base_url().'/public/uploads/awards/'.$result['award_photo'];?>" width="70px" id="u_file">&nbsp; <a href="<?php echo site_url()?>download?type=awards&filename=<?php echo uencode($result['award_photo']);?>">
          <?= lang('Main.xin_download');?>
          </a>
          <?php } ?></td>
      </tr>
      <tr>
        <th><?= lang('Employees.xin_award_info');?></th>
        <td style="display: table-cell;"><?php echo html_entity_decode($result['award_information']);?></td>
      </tr>
      <tr>
        <th><?= lang('Main.xin_description');?></th>
        <td style="display: table-cell;"><?php echo html_entity_decode($result['description']);?></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
</div>
<?php echo form_close(); ?>
<?php }
?>
