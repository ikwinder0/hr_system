<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\PolicyModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$PolicyModel = new PolicyModel();
$get_animate = '';
if($request->getGet('data') === 'policy' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $PolicyModel->where('policy_id', $ifield_id)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Dashboard.header_edit_policy');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_policy', 'id' => 'edit_policy', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open_multipart('erp/policies/update_policy', $attributes, $hidden);?>
<div class="modal-body">
  <div class="form-group">
    <label for="title">
      <?= lang('Dashboard.xin_title');?> <span class="text-danger">*</span>
    </label>
    <input type="text" class="form-control" name="title" placeholder="<?= lang('Dashboard.xin_title');?>" value="<?php echo $result['title'];?>">
  </div>
  <div class="form-group">
    <label for="message">
      <?= lang('Main.xin_description');?> <span class="text-danger">*</span>
    </label>
    <textarea class="form-control" placeholder="<?= lang('Main.xin_description');?>" name="description" rows="4"><?php echo $result['description'];?></textarea>
  </div>
  <div class="row m-b-1 <?php echo $get_animate;?>">
    <div class="col-md-6">
      <label for="logo">
        <?= lang('Main.xin_attachment');?>
       </label>
      <div class="custom-file">
        <input type="file" class="custom-file-input" name="attachment">
        <label class="custom-file-label">
          <?= lang('Main.xin_choose_file');?>
        </label>
        <small>
        <?= lang('Main.xin_company_file_type');?>
        </small> </div>
    </div>
    <div class="col-md-4">
      <label for="photo">&nbsp;</label>
      <fieldset class="form-group">
        <?php if($result['attachment']!='' || $result['attachment']!='no-file'){?>
        <?php
			  $imageProperties = [
				'src'    => base_url().'/public/uploads/policy/'.$result['attachment'],
				'alt'    => $result['title'],
				'class'  => 'd-block ui-w-50',
				'width'  => '50',
				'height' => '50',
				'title'  => $result['title']
			];
			 ?>
        <span class="box-96 mr-0-5">
        <?= img($imageProperties);?>
        </span>
        <?php } ?>
      </fieldset>
      
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
							
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		 Ladda.bind('button[type=submit]');
		/* Edit data */
		$("#edit_policy").submit(function(e){
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
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("erp/policies/policies_list") ?>",
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
