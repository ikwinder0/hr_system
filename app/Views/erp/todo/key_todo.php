<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\TodoModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();
$TodoModel = new TodoModel();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
/*
* Todo - View Page
*/
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$todo = $TodoModel->where('company_id',$user_info['company_id'])->where('user_id',$usession['sup_user_id'])->orderBy('todo_item_id', 'ASC')->findAll();
} else {
	$todo = $TodoModel->where('company_id',$usession['sup_user_id'])->where('user_id',$usession['sup_user_id'])->orderBy('todo_item_id', 'ASC')->findAll();
}
		
?>

<div class="row justify-content-md-center"> 
  <!-- [ Todo-list1 ] start -->
  <div class="col-xl-12">
    <div class="card">
      <div class="card-header">
        <h5>
          <?= lang('Dashboard.dashboard_to_do_list');?>
        </h5>
      </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_todo', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 0);?>
        <?= form_open('erp/todo/add_todo', $attributes, $hidden);?>
        <div class="input-group mb-3">
          <input type="text" name="task_insert" class="form-control add_task_todo" placeholder="<?= lang('Dashboard.dashboard_create_todo');?>...">
          <div class="input-group-append">
            <button type="submit" class="btn waves-effect waves-light btn-secondary btn-icon"> <i class="fa fa-plus"></i> <?= lang('Main.xin_add');?></button>
          </div>
        </div>
        <?= form_close(); ?>
        <div class="new-task">
          <?php foreach($todo as $items){ ?>
          <?php
			if($items['is_done']==1){
				$cls_done = 'done-task';
				$chk_checked = 'checked';
			} else {
				$cls_done = '';
				$chk_checked = '';
			}
			?>
          <div class="to-do-list mb-3">
            <div class="d-inline-block">
              <label class="check-task custom-control custom-checkbox d-flex justify-content-center <?= $cls_done;?>">
                <input type="checkbox" class="custom-control-input" <?= $chk_checked;?> id="item_<?= $items['todo_item_id'];?>" data-field-id="<?= $items['todo_item_id'];?>">
                <span class="custom-control-label">
                <?= $items['description'];?>
                </span> </label>
            </div>
            <div class="float-right"><a onclick="delete_todo(<?= $items['todo_item_id'];?>);" href="#!" class="delete_todolist" data-fieldid="<?= $items['todo_item_id'];?>"><i class="far fa-trash-alt text-danger"></i></a></div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <!-- [ Todo-list1 ] end --> 
</div>
