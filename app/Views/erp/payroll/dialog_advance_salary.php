<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\AdvancesalaryModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();		
$AdvancesalaryModel = new AdvancesalaryModel();	
$SystemModel = new SystemModel();
$ConstantsModel = new ConstantsModel();
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	//$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','award_type')->findAll();
} else {
	//$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','award_type')->findAll();
}
$xin_system = erp_company_settings();
/* Assets view
*/
$get_animate = '';
if($request->getGet('data') === 'advance_salary' && $request->getGet('field_id')){
$advance_salary_id = udecode($field_id);
$result = $AdvancesalaryModel->where('advance_salary_id', $advance_salary_id)->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Main.xin_edit_advance_salary');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_advance_salary', 'id' => 'edit_advance_salary', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/payroll/edit_advance_salary', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
	  <?php if($user_info['user_type'] == 'company'){?>
      <?php $staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
      <div class="col-md-6">
        <div class="form-group">
          <label for="first_name">
            <?= lang('Dashboard.dashboard_employee');?> <span class="text-danger">*</span>
          </label>
          <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employee');?>">
            <?php foreach($staff_info as $staff) {?>
            <option value="<?= $staff['user_id']?>" <?php if($result['employee_id']==$staff['user_id']):?> selected="selected"<?php endif;?>>
            <?= $staff['first_name'].' '.$staff['last_name'] ?>
            </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <?php $colmd = 'col-md-6'?>
      <?php } else {?>
      <?php $colmd = 'col-md-6'?>
      <?php } ?>
      <div class="col-md-6">
        <div class="form-group">
          <label for="month_year">
            <?= lang('Employees.xin_award_month_year');?> <span class="text-danger">*</span>
          </label>
          <div class="input-group">
            <input class="form-control d_month_year" placeholder="<?= lang('Employees.xin_award_month_year');?>" name="month_year" type="text" value="<?= $result['month_year'];?>">
            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="cash">
            <?= lang('Invoices.xin_amount');?> <span class="text-danger">*</span>
          </label>
          <div class="input-group">
            <div class="input-group-append"><span class="input-group-text">
              <?= $xin_system['default_currency'];?>
              </span></div>
            <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="advance_amount" type="text" value="<?= $result['advance_amount'];?>">
          </div>
        </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label for="one_time_deduct">
          <?= lang('Main.xin_one_time_deduct');?> <span class="text-danger">*</span>
        </label>
        <select class="form-control mone_time_deduct" name="one_time_deduct" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_one_time_deduct');?>">
          <option value="0" <?php if($result['one_time_deduct']==0):?> selected="selected"<?php endif;?>>
          <?= lang('Main.xin_no');?>
          </option>
          <option value="1" <?php if($result['one_time_deduct']==1):?> selected="selected"<?php endif;?>>
          <?= lang('Main.xin_yes');?>
          </option>
        </select>
      </div>
    </div>
   <div class="col-md-6">
    <div class="form-group">
      <label for="emi_amount">
        <?= lang('Main.xin_emi_full_text');?> <span class="text-danger">*</span>
      </label>
      <div class="input-group">
        <div class="input-group-append"><span class="input-group-text">
          <?= $xin_system['default_currency'];?>
          </span></div>
        <input class="form-control" placeholder="<?= lang('Main.xin_emi_full_text');?>" name="emi_amount" id="mmonthly_installment" type="text" value="<?= $result['monthly_installment'];?>">
      </div>
    </div>
  </div>
  <?php if($result['status']=='0'):?>
  <div class="col-md-6">
      <div class="form-group">
        <label for="notice_date">
          <?= lang('Main.dashboard_xin_status');?> <span class="text-danger">*</span>
        </label>
        <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_xin_status');?>">
          <option value="">
          <?= lang('dashboard_xin_status');?>
          </option>
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
  <?php endif;?>
  <div class="col-md-12">
    <div class="form-group">
      <label for="award_information">
        <?= lang('Main.xin_reason');?> <span class="text-danger">*</span>
      </label>
      <textarea class="form-control" placeholder="<?= lang('Main.xin_reason');?>" name="reason" cols="30" rows="3" id="reason"><?= $result['reason'];?></textarea>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <div class="alert alert-success" role="alert">
        <?= lang('Invoices.xin_paid');?>:&nbsp;<?= number_to_currency($result['total_paid'], $xin_system['default_currency'],null,2);?>
    </div>
    </div>
      </div>
     <?php $remaining_amount = $result['advance_amount'] - $result['total_paid'];?> 
      <div class="col-md-6">
        <div class="form-group">
          <div class="alert alert-warning" role="alert">
            <?= lang('Main.xin_remaining');?>:&nbsp;<?= number_to_currency($remaining_amount, $xin_system['default_currency'],null,2);?>
        </div>
        </div>
      </div>
    </div>
    
    <?php if($result['status']=='1'):?>
    <div class="alert alert-success" role="alert">
        <?= lang('Main.xin_advance_salary_request_accepted');?>
    </div>
    <?php endif;?>
    <?php if($result['status']=='2'):?>
    <div class="alert alert-danger" role="alert">
        <?= lang('Main.xin_advance_salary_request_rejected');?>
    </div>
    <?php endif;?>
</div>
<!--</div>-->
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <?php if($result['status']=='0'):?>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_update');?>
  </button>
  <?php endif;?>
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
		$(".mone_time_deduct").change(function(){
			if($(this).val()==1){
				$('#mmonthly_installment').attr('disabled',true);
			} else {
				$('#mmonthly_installment').attr('disabled',false);
			}
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
		$("#edit_advance_salary").submit(function(e){
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
							url : "<?php echo site_url("erp/payroll/advance_salary_list") ?>",
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
					$('.view-modal-data').modal('toggle');
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
