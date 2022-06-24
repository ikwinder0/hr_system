<?php
/*
* System Settings - Database backup View
*/
?>

<div class="row mt-3">
  <div class="col-md-12 card">
    <div class="card-header">
      <h5>
        <?= lang('Main.xin_list_all');?>
        <?= lang('Main.xin_backup_log');?>
      </h5>
      <div class="card-header-right"> <span class="badge">
        <?php $attributes = array('name' => 'del_backup', 'id' => 'del_backup', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 0);?>
        <?php echo form_open('erp/settings/delete_db_backup', $attributes, $hidden);?>
        <button type="submit" class="btn btn-sm btn-primary save">
        <?= lang('Main.xin_delete_old_backup');?>
        </button>
        <?php echo form_close(); ?></span> <span class="badge">
        <?php $attributes = array('name' => 'db_backup', 'id' => 'db_backup', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 0);?>
        <?php echo form_open('erp/settings/create_database_backup', $attributes, $hidden);?>
        <button type="submit" class="btn btn-sm btn-primary save">
        <?= lang('Main.xin_create_backup');?>
        </button>
        <?php echo form_close(); ?> </span> </div>
    </div>
    <div class="card-body">
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th><?= lang('Main.xin_action');?></th>
              <th><?= lang('Main.xin_database_file');?></th>
              <th><?= lang('Main.xin_e_details_date');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
