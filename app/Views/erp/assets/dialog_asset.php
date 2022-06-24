<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\AssetsModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();		
$AssetsModel = new AssetsModel();	
$ConstantsModel = new ConstantsModel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','assets_category')->findAll();
	$brand_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','assets_brand')->findAll();
} else {
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','assets_category')->findAll();
	$brand_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','assets_brand')->findAll();
}

/* Assets view
*/
$get_animate = '';
if($request->getGet('data') === 'asset' && $request->getGet('field_id')){
$assets_id = udecode($field_id);
$result = $AssetsModel->where('assets_id', $assets_id)->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Asset.xin_edit_asset');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'update_asset', 'id' => 'update_asset', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open_multipart('erp/assets/update_asset', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="asset_name" class="control-label">
              <?= lang('Asset.xin_asset_name');?>
              <span class="text-danger">*</span> </label>
            <input class="form-control" placeholder="<?= lang('Asset.xin_asset_name');?>" name="asset_name" type="text" value="<?= $result['name'];?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="first_name">
              <?= lang('Dashboard.xin_category');?>
              <span class="text-danger">*</span> </label>
            <select class="form-control" name="category_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.xin_category');?>">
              <option value=""></option>
              <?php foreach($category_info as $as_category) {?>
              <option value="<?= $as_category['constants_id']?>" <?php if($as_category['constants_id']==$result['assets_category_id']):?> selected="selected"<?php endif;?>>
              <?= $as_category['category_name']?>
              </option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <?php if($user_info['user_type'] == 'company'){?>
      <?php $staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="first_name">
              <?= lang('Dashboard.dashboard_employee');?>
            </label>
            <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_choose_an_employee');?>">
              <?php foreach($staff_info as $staff) {?>
              <option value="<?= $staff['user_id']?>" <?php if($staff['user_id']==$result['employee_id']):?> selected="selected"<?php endif;?>>
              <?= $staff['first_name'].' '.$staff['last_name'] ?>
              </option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <?php } ?>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="manufacturer">
              <?= lang('Asset.xin_manufacturer');?>
            </label>
            <input class="form-control" placeholder="<?= lang('Asset.xin_manufacturer');?>" name="manufacturer" type="text" value="<?= $result['manufacturer'];?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="xin_serial_number" class="control-label">
              <?= lang('Asset.xin_serial_number');?>
            </label>
            <input class="form-control" placeholder="<?= lang('Asset.xin_serial_number');?>" name="serial_number" type="text" value="<?= $result['serial_number'];?>">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-9">
          <div class="form-group">
            <label for="logo">
              <?= lang('Asset.xin_asset_image');?>
              <span class="text-danger">*</span> </label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="asset_image">
              <label class="custom-file-label">
                <?= lang('Main.xin_choose_file');?>
              </label>
              <small>
              <?= lang('Main.xin_company_file_type');?>
              </small> </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="logo">&nbsp; </label>
            <?php if($result['asset_image']!='' || $result['asset_image']!='no-file'){?>
            <?php
                  $imageProperties = [
                    'src'    => base_url().'/public/uploads/asset_image/'.$result['asset_image'],
                    'alt'    => $result['name'],
                    'class'  => 'd-block ui-w-50 rounded-circle',
                    'width'  => '50',
                    'height' => '50',
                    'title'  => $result['name']
                ];
                 ?>
            <span class="avatar box-48 mr-0-5">
            <?= img($imageProperties);?>
            </span>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="first_name">
              <?= lang('Asset.xin_brand');?>
              <span class="text-danger">*</span> </label>
            <select class="form-control" name="brand_id" data-plugin="select_hrm" data-placeholder="<?= lang('Asset.xin_brand');?>">
              <option value=""></option>
              <?php foreach($brand_info as $assets_brand) {?>
              <option value="<?= $assets_brand['constants_id']?>" <?php if($assets_brand['constants_id']==$result['brand_id']):?> selected="selected"<?php endif;?>>
              <?= $assets_brand['category_name']?>
              </option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="company_asset_code">
              <?= lang('Asset.xin_company_asset_code');?>
            </label>
            <input class="form-control" placeholder="<?= lang('Asset.xin_company_asset_code');?>" name="company_asset_code" type="text" value="<?= $result['company_asset_code'];?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="is_working" class="control-label">
              <?= lang('Asset.xin_is_working');?>
            </label>
            <select class="form-control" name="is_working" data-plugin="select_hrm" data-placeholder="<?= lang('Asset.xin_is_working');?>">
              <option value="1" <?php if($result['is_working']==1):?> selected="selected"<?php endif;?>>
              <?= lang('Main.xin_yes');?>
              </option>
              <option value="0" <?php if($result['is_working']==0):?> selected="selected"<?php endif;?>>
              <?= lang('Main.xin_no');?>
              </option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="purchase_date">
              <?= lang('Asset.xin_purchase_date');?>
            </label>
            <div class="input-group">
              <input class="form-control m_date" placeholder="<?= lang('Asset.xin_purchase_date');?>" name="purchase_date" type="text" value="<?= $result['purchase_date'];?>">
              <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="role">
              <?= lang('Main.xin_invoice_number');?>
            </label>
            <div class="input-group">
              <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-file-invoice"></i></span></div>
              <input class="form-control" placeholder="<?= lang('Main.xin_invoice_number');?>" name="invoice_number" type="text" value="<?= $result['invoice_number'];?>">
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="warranty_end_date" class="control-label">
              <?= lang('Asset.xin_warranty_end_date');?>
            </label>
            <div class="input-group">
              <input class="form-control m_date" placeholder="<?= lang('Asset.xin_warranty_end_date');?>" name="warranty_end_date" type="text" value="<?= $result['warranty_end_date'];?>">
              <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="award_information">
          <?= lang('Asset.xin_asset_note');?>
        </label>
        <textarea class="form-control" placeholder="<?= lang('Asset.xin_asset_note');?>" name="asset_note" cols="30" rows="2" id="asset_note"><?= $result['asset_note'];?>
</textarea>
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
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
						
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
	 Ladda.bind('button[type=submit]');
	 
	$('.m_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD',
		cancelText: 'Cancelll', okText: 'Okk',clearText: 'Clearr',nowText: 'Noww'
	});

	/* Edit data */
	$("#update_asset").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 2);
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
					var xin_table2 = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?= site_url("erp/assets/assets_list"); ?>",
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
					xin_table2.api().ajax.reload(function(){ 
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
<?php } if($request->getGet('type') === 'view_asset' && $request->getGet('field_id')){ ?>
<?php
$assets_id = udecode($field_id);
$result = $AssetsModel->where('assets_id', $assets_id)->first(); ?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Asset.xin_view_asset');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<form class="m-b-1">
<div class="modal-body">
  <table class="footable-details table table-striped table-hover toggle-circle">
    <tbody>
      <tr>
        <th><?= lang('Asset.xin_asset_name');?></th>
        <td style="display: table-cell;"><?= $result['name'];?></td>
      </tr>
      <tr>
        <th><?= lang('Dashboard.xin_category');?></th>
        <td style="display: table-cell;"><?php foreach($category_info as $assets_category) {?>
          <?php if($result['assets_category_id']==$assets_category['assets_category_id']):?>
          <?= $assets_category['category_name'];?>
          <?php endif;?>
          <?php } ?></td>
      </tr>
      <tr>
        <th><?= lang('Asset.xin_company_asset_code');?></th>
        <td style="display: table-cell;"><?= $result['company_asset_code'];?></td>
      </tr>
      <tr>
        <th><?= lang('Dashboard.dashboard_employee');?></th>
        <?php $staff_info = $UsersModel->where('user_id', $result['employee_id'])->first();?>
        <td style="display: table-cell;"><?= $staff_info['first_name'].' '.$staff_info['last_name'];?></td>
      </tr>
      <tr>
        <th><?= lang('Asset.xin_is_working');?></th>
        <td style="display: table-cell;"><?php
			if($result['is_working']==1){
				echo $working = lang('Main.xin_yes');
			} else {
				echo $working = lang('Main.xin_no');
			}
		  ?></td>
      </tr>
      <tr>
        <th><?= lang('Asset.xin_purchase_date');?></th>
        <td style="display: table-cell;"><?= set_date_format($result['purchase_date']);?></td>
      </tr>
      <tr>
        <th><?= lang('Main.xin_invoice_number');?></th>
        <td style="display: table-cell;"><?= $result['invoice_number'];?></td>
      </tr>
      <tr>
        <th><?= lang('Asset.xin_manufacturer');?></th>
        <td style="display: table-cell;"><?= $result['manufacturer'];?></td>
      </tr>
      <tr>
        <th><?= lang('Asset.xin_serial_number');?></th>
        <td style="display: table-cell;"><?= $result['serial_number'];?></td>
      </tr>
      <tr>
        <th><?= lang('Asset.xin_warranty_end_date');?></th>
        <td style="display: table-cell;"><?= set_date_format($result['warranty_end_date']);?></td>
      </tr>
      <tr> </tr>
      <tr>
        <th><?= lang('Asset.xin_asset_note');?></th>
        <td style="display: table-cell;"><?= html_entity_decode($result['asset_note']);?></td>
      </tr>
      <tr>
        <th><?= lang('Asset.xin_asset_image');?></th>
        <td style="display: table-cell;"><?php if($result['asset_image']!='' && $result['asset_image']!='no file') {?>
          <?php
			  $imageProperties = [
				'src'    => base_url().'/public/uploads/asset_image/'.$result['asset_image'],
				'alt'    => $result['name'],
				'class'  => 'd-block ui-w-50',
				'width'  => '50',
				'height' => '50',
				'title'  => $result['name']
			];
		 ?>
          <?= img($imageProperties);?>
          &nbsp; <a href="<?= site_url()?>download?type=asset_image&filename=<?= uencode($result['asset_image']);?>">
          <?= lang('Main.xin_download');?>
          </a>
          <?php } ?></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
</div>
<?= form_close(); ?>
<?php }
?>
