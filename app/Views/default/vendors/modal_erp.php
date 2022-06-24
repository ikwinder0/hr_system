<style type="text/css">
#ui-datepicker-div {
	z-index:1100 !important;
}
.modal-backdrop {
	z-index: 1091 !important;
}
.modal {
	z-index: 1100 !important;
}
.popover {
	z-index: 1100 !important;
}
</style>
<div class="modal fade show delete-modal" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <?= lang('Main.xin_delete_confirm');?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" > <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger"> <strong>
          <?= lang('Main.xin_d_not_restored');?>
          </strong> </div>
      </div>
      <?php $attributes = array('name' => 'delete_record', 'id' => 'delete_record', 'autocomplete' => 'off', 'role'=>'form');?>
      <?php $hidden = array('_method' => 'DELETE', '_token' => '000');?>
      <?= form_open('', $attributes, $hidden);?>
      <div class="modal-footer">
        <?php
		$del_token = array(
			'type'  => 'hidden',
			'id'  => 'token_type',
			'name'  => 'token_type',
			'value' => 0,
		);
		?>
        <?= form_input($del_token);?>
          <button type="button" class="btn btn-light" data-dismiss="modal"><?= lang('Main.xin_close');?></button>
          <button type="submit" class="btn btn-primary"><?= lang('Main.xin_confirm_del');?></button>
        <?= form_close(); ?>
      </div>
    </div>
  </div>
</div>
<div class="modal view-modal-data fade" id="notification-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="ajax_view_modal"></div>
    </div>
</div>
<div class="modal fade show edit-modal-data" role="dialog" aria-labelledby="edit-modal-data" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="ajax_modal"></div>
  </div>
</div>
<div class="modal fade show payroll-modal-data" role="dialog" aria-labelledby="edit-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_payroll_modal"></div>
  </div>
</div>
<?php /*?><div class="modal fade show viewv-modal-data" role="dialog" aria-labelledby="view-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_view_modal"></div>
  </div>
</div><?php */?>
