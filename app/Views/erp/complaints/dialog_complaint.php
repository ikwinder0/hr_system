<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ComplaintsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();		
$ComplaintsModel = new ComplaintsModel();	
$SystemModel = new SystemModel();
$xin_system = $SystemModel->where('setting_id', 1)->first();
/* Assets view
*/
$get_animate = '';
$xin_com_system = erp_company_settings();
if($request->getGet('data') === 'complaint' && $request->getGet('field_id')){
$complaint_id = udecode($field_id);
$result = $ComplaintsModel->where('complaint_id', $complaint_id)->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_edit_complaint');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_complaint', 'id' => 'edit_complaint', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/complaints/update_complaint', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="title">
          <?= lang('Employees.xin_complaint_title');?> <span class="text-danger">*</span>
        </label>
        <input class="form-control" placeholder="<?= lang('Employees.xin_complaint_title');?>" name="title" type="text" value="<?php echo $result['title'];?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="status">
          <?= lang('Main.dashboard_xin_status');?> <span class="text-danger">*</span>
        </label>
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
    <div class="col-md-8">
      <div class="form-group">
        <label for="complaint_date">
          <?= lang('Employees.xin_complaint_date');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <input class="form-control d_date" placeholder="<?= lang('Employees.xin_complaint_date');?>" name="complaint_date" type="text" value="<?php echo $result['complaint_date'];?>">
          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="description">
          <?= lang('Main.xin_description');?> <span class="text-danger">*</span>
        </label>
        <textarea class="form-control textarea" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="30" rows="3"><?php echo $result['description'];?></textarea>
      </div>
    </div>
  </div>
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
		Ladda.bind('button[type=submit]');
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		$('.d_date').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: '<?= js_set_date_format();?>',
			lang: '<?= $xin_com_system['datepicker_locale'];?>'
		});
		/* Edit data */
		$("#edit_complaint").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&type=edit_record&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
						Ladda.stopAll();
					} else {
						// On page load: datatable
						var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("erp/complaints/complaints_list") ?>",
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
				}
			});
		});
	});	
  </script>
<?php }
?>
