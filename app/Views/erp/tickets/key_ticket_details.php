<?php
use CodeIgniter\I18n\Time;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\TicketsModel;
use App\Models\DepartmentModel;
use App\Models\TicketreplyModel;
use App\Models\TicketnotesModel;
use App\Models\TicketfilesModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$TicketsModel = new TicketsModel();
$DepartmentModel = new DepartmentModel();
$TicketfilesModel = new TicketfilesModel();
$TicketreplyModel = new TicketreplyModel();
$TicketnotesModel = new TicketnotesModel();
$Moduleattributes = new Moduleattributes();
$Moduleattributesval = new Moduleattributesval();
$Moduleattributesvalsel = new Moduleattributesvalsel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$segment_id = $request->uri->getSegment(3);
$ticket_id = udecode($segment_id);

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$count_module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',3)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',3)->orderBy('custom_field_id', 'ASC')->findAll();
} else {
	$count_module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',3)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',3)->orderBy('custom_field_id', 'ASC')->findAll();
}
// ticket replies
$ticket_reply = $TicketreplyModel->where('ticket_id', $ticket_id)->orderBy('ticket_reply_id', 'ASC')->findAll();
// ticket notes
$ticket_notes = $TicketnotesModel->where('ticket_id', $ticket_id)->orderBy('ticket_note_id', 'ASC')->findAll();

$ticket_info = $TicketsModel->where('ticket_id', $ticket_id)->first();
$department_info = $DepartmentModel->where('department_id', $ticket_info['department_id'])->first();
if($department_info){
	$department_name = $department_info['department_name'];
} else {
	$department_name = '--';
}
// created by
$created_by = $UsersModel->where('user_id', $ticket_info['created_by'])->first();
// assigned to
$assigned_to = $UsersModel->where('user_id', $ticket_info['employee_id'])->first();
//
$created_at = set_date_format($ticket_info['created_at']);
//
if($ticket_info['ticket_status']==1): $priority = lang('Projects.xin_low'); elseif($ticket_info['ticket_status']==2): $priority = lang('Main.xin_medium'); elseif($ticket_info['ticket_status']==3): $priority = lang('Projects.xin_high'); elseif($ticket_info['ticket_status']==4): $priority = lang('Main.xin_critical');  endif;
if($user_info['user_type'] == 'staff'){
	$_ticket_reply = $TicketreplyModel->where('company_id', $user_info['company_id'])->where('ticket_id', $ticket_id)->first();
} else {
	$_ticket_reply = $TicketreplyModel->where('company_id', $usession['sup_user_id'])->where('ticket_id', $ticket_id)->first();
}

// ticket files
$ticket_files = $TicketfilesModel->where('ticket_id', $ticket_id)->orderBy('ticket_file_id', 'ASC')->findAll();
?>

<div class="row">
  <div class="col-lg-4">
    <div class="card hdd-right-inner">
      <div class="card-header">
        <h5>
          <?= lang('Dashboard.left_ticket_details');?>
        </h5>
      </div>
      <?php if(in_array('helpdesk6',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <?php $attributes = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
      <?php $hidden = array('token' => $segment_id);?>
      <?= form_open('erp/tickets/update_ticket_status', $attributes, $hidden);?>
      <?php } ?>
      <div class="card-body">
        <div class="alert alert-success d-block text-center text-uppercase"><i class="feather icon-check-circle mr-2"></i>
          <?= lang('Dashboard.left_ticket_no');?>
          <?= $ticket_info['ticket_code'];?>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <div class="media align-items-center">
              <label class="mb-0 wid-100">
                <?= lang('Main.xin_subject');?>
              </label>
              <div class="media-body">
                <p class="mb-0">
                  <?= $ticket_info['subject'];?>
                </p>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <div class="media align-items-center">
              <label class="mb-0 wid-100">
                <?= lang('Dashboard.dashboard_employee');?>
              </label>
              <div class="media-body">
                <p class="mb-0"><img src="<?= staff_profile_photo($ticket_info['employee_id']);?>" alt="" class="wid-20 rounded mr-1 img-fluid">
                  <?= $created_by['first_name'].' '.$created_by['last_name'];?>
                </p>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <div class="media align-items-center">
              <label class="mb-0 wid-100">
                <?= lang('Projects.xin_p_priority');?>
              </label>
              <div class="media-body">
                <p class="mb-0">
                  <?= $priority;?>
                </p>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <div class="media align-items-center">
              <label class="mb-0 wid-100">
                <?= lang('Dashboard.left_department');?>
              </label>
              <div class="media-body">
                <p class="mb-0">
                  <?= $department_name;?>
                </p>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <div class="media align-items-center">
              <label class="mb-0 wid-100">
                <?= lang('Employees.xin_assigned_to');?>
              </label>
              <div class="media-body">
                <p class="mb-0"><img src="<?= staff_profile_photo($ticket_info['created_by']);?>" alt="" class="wid-20 rounded mr-1 img-fluid">
                  <?= $assigned_to['first_name'].' '.$assigned_to['last_name'];?>
                </p>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <div class="media align-items-center">
              <label class="mb-0 wid-100">
                <?= lang('Main.xin_created_at');?>
              </label>
              <div class="media-body">
                <p class="mb-0"><i class="feather icon-calendar mr-1"></i>
                  <?= $created_at;?>
                </p>
              </div>
            </div>
          </li>
        </ul>
        <div class="row mt-2 mb-2">
          <div class="col-md-12"> <span class=" txt-primary"> <i class="fas fa-chart-line"></i> <strong>
            <?= lang('Main.dashboard_xin_status');?> <span class="text-danger">*</span>
            </strong> </span> </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <select class="col-sm-12" name="status" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_xin_status');?>">
                <option></option>
                <option value="1" <?php if($ticket_info['ticket_status']=='1'):?> selected <?php endif; ?>>
                <?= lang('Main.xin_open');?>
                </option>
                <option value="2" <?php if($ticket_info['ticket_status']=='2'):?> selected <?php endif; ?>>
                <?= lang('Main.xin_closed');?>
                </option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="status">
                <?= lang('Recruitment.xin_remarks');?> <span class="text-danger">*</span>
              </label>
              <textarea class="form-control" name="remarks" rows="3" cols="15" placeholder="<?= lang('Recruitment.xin_remarks');?>"><?php echo $ticket_info['ticket_remarks'];?></textarea>
            </div>
          </div>
        </div>
        <?php if($count_module_attributes > 0):?>
        <div class="row">
          <?php foreach($module_attributes as $mattribute):?>
          <?php $attribute_info = $Moduleattributesval->where('user_id',$ticket_id)->where('module_attributes_id', $mattribute['custom_field_id'])->first();?>
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
          <div class="col-md-12">
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
          <div class="col-md-12">
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
          <div class="col-md-12">
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
          <div class="col-md-12">
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
      <?php if(in_array('helpdesk6',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary">
        <?= lang('Main.xin_update_status');?>
        </button>
      </div>
      <?= form_close(); ?>
      <?php } ?>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="bg-light card mb-2">
      <div class="card-body">
        <ul class="nav nav-pills mb-0">
          <li class="nav-item m-r-5"> <a href="#pills-home" data-toggle="tab" aria-expanded="false" class="">
            <button type="button" class="btn btn-outline-secondary text-uppercase"><i class="mr-2 feather icon-message-square"></i>
            <?= lang('Projects.xin_post_a_reply');?>
            </button>
            </a> </li>
          <?php if(in_array('helpdesk8',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item m-r-5"> <a href="#pills-profile" data-toggle="tab" aria-expanded="true" class="">
            <button type="button" class="btn btn-outline-secondary text-uppercase"><i class="mr-2 feather icon-edit"></i>
            <?= lang('Projects.xin_post_a_note');?>
            </button>
            </a> </li>
         <?php } ?>
		 <?php if(in_array('helpdesk7',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
         <li class="nav-item m-r-5"> <a href="#pills-files" data-toggle="tab" aria-expanded="true" class="">
            <button type="button" class="btn btn-outline-secondary text-uppercase"><i class="mr-2 feather icon-edit"></i>
            <?= lang('Projects.xin_attach_files');?>
            </button>
            </a> </li>
         <?php } ?>
        </ul>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h5><i class="feather icon-lock mr-1"></i>
          <?= lang('Dashboard.left_ticket_no');?>
          <?= $ticket_info['ticket_code'];?>
        </h5>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
          <?php $tr = 0; foreach($ticket_reply as $_reply){?>
          <?php //if($_reply['sent_by'] == $usession['sup_user_id']){ ?>
          <?php $sent_by = $UsersModel->where('user_id', $_reply['sent_by'])->first(); ?>
          <?php
		  	if ($tr%2==0){
				$bgtr = '';
			} else {
				$bgtr = '';
			}
		  ?>
          <div class="card-body hd-detail hdd-admin border-bottom <?= $bgtr;?>" id="reply_option_id_<?= $_reply['ticket_reply_id'];?>">
            <div class="row">
              <div class="col-auto text-center"> <img class="media-object wid-60 img-radius mb-2" src="<?= staff_profile_photo($_reply['sent_by']);?>" alt="">
              </div>
              <div class="col">
                <div class="comment-top">
                  <h6>
                    <?= $sent_by['first_name'].' '.$sent_by['last_name'];?>
                    <small class="text-muted f-w-400"><?= time_ago($_reply['created_at']);?></small></h6>
                </div>
                <div class="comment-content">
                  <?= html_entity_decode($_reply['reply_text']);?>
                </div>
              </div>
              <div class="col-auto pl-0 col-right">
                <div class="card-body text-center">
                  <ul class="list-unstyled mb-0 edit-del">
                    <li class="d-inline-block f-20"><a href="#!" class="delete_reply" data-field="<?= $_reply['ticket_reply_id'];?>" data-title="reply"><i class="feather icon-trash-2 text-danger"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <?php //} ?>
          <?php $tr++; } ?>
          <?php //if($_ticket_reply['sent_by']){ ?>
          <div class="card-body hd-detail hdd-admin border-bottom">
            <?php $attributes = array('name' => 'ticket_reply', 'id' => 'ticket_reply', 'autocomplete' => 'off');?>
            <?php $hidden = array('token' => $segment_id,'token2' => uencode($_ticket_reply['sent_by']),'token3' => uencode($usession['sup_user_id']));?>
            <?= form_open('erp/tickets/add_ticket_reply', $attributes, $hidden);?>
            <div class="row mt-4">
              <div class="col-sm-12">
                <div class="form-group">
                  <textarea class="form-control editor" name="description"><?= lang('Projects.xin_post_a_reply');?>...</textarea>
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary">
              <?= lang('Main.xin_reply');?>
              </button>
            </div>
            <?= form_close(); ?>
          </div>
          <?php //} ?>
        </div>
       <?php if(in_array('helpdesk8',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div class="card-body task-comment">
            <ul class="media-list p-0">
                <?php $tn=0; foreach($ticket_notes as $_note){ ?>
                <?php $time = Time::parse($_note['created_at']); ?>
                <?php $note_user = $UsersModel->where('user_id', $_note['employee_id'])->first();?>
                <li class="media" id="note_option_id_<?= $_note['ticket_note_id'];?>">
                    <div class="media-left mr-3">
                        <a href="#!">
                            <img class="img-fluid media-object img-radius comment-img" src="<?= staff_profile_photo($_note['employee_id']);?>" alt="">
                        </a>
                    </div>
                    <div class="media-body">
                        <h6 class="media-heading txt-primary"><?= $note_user['first_name'].' '.$note_user['last_name'];?> <span class="f-12 text-muted ml-1"><?= time_ago($_note['created_at']);?></span></h6>
                        <p><?= $_note['ticket_note'];?></p>
                        <div class="m-t-10">
                            <span><a href="#!" data-field="<?= $_note['ticket_note_id'];?>" data-title="note" class="delete_note m-r-10 text-secondary"><i class="fas fa-trash-alt text-danger mr-2"></i> <?= lang('Main.xin_delete');?></a></span><span></span>
                        </div>                                    
                    </div>
                </li>
                <hr class="note_option_id_<?= $_note['ticket_note_id'];?>">
                <?php } ?>
            </ul>
            <?php $attributes = array('name' => 'add_note', 'id' => 'add_note', 'autocomplete' => 'off');?>
            <?php $hidden = array('token' => $segment_id);?>
            <?= form_open('erp/tickets/add_note', $attributes, $hidden);?>
              <div class="input-group mb-3">
                <input type="text" name="description" class="form-control" placeholder="<?= lang('Projects.xin_create_note_list');?>">
                <div class="input-group-append">
                    <button class="btn waves-effect waves-light btn-primary btn-icon" type="submit"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <?= form_close(); ?>
            </div>
          </div>
        <?php } ?>
        <?php if(in_array('helpdesk7',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="tab-pane fade" id="pills-files" role="tabpanel" aria-labelledby="pills-files-tab">
          <div class="card-body">
            <div class="list-group list-group-flush list-pills border-bottom">
              <?php foreach($ticket_files as $_files){ ?>
              <?php $file_user = $UsersModel->where('user_id', $_files['employee_id'])->first();?>
              <div class="list-group-item list-group-item-action d-block py-3 file_option_id_<?= $_files['ticket_file_id'];?>">
                <div class="row" id="file_option_id_<?= $_files['ticket_file_id'];?>">
                  <div class="col-auto pr-0"> <img src="<?= staff_profile_photo($_files['employee_id']);?>" class="img-radius wid-40" alt=""> </div>
                  <div class="col"> <a href="#!">
                    <h6 class="mb-0">
                      <?= $_files['file_title'];?> <span class="f-12 text-muted ml-1"><?= time_ago($_files['created_at']);?></span>
                    </h6>
                    </a> <small class="mb-0 text-muted"> <?php echo lang('Main.xin_by');?>: <a href="#!" class="text-muted font-weight-bold text-h-primary">
                    <?= $file_user['first_name'].' '.$file_user['last_name'];?>
                    </a> </small>
                    <div class="row justify-content-between">
                      <div class="col-auto mt-2"> <a href="<?php echo site_url('download')?>?type=tickets&filename=<?php echo uencode($_files['attachment_file']);?>" class="text-secondary"><i class="fas fa-download m-r-5"></i> <?php echo lang('Main.xin_download');?></a> </div>
                      <div class="col-auto mt-2">
                        <ul class="list-inline mb-0">
                          <li class="list-inline-item"><a href="#!" data-field="<?= $_files['ticket_file_id'];?>" class="delete_file text-body text-h-primary"><i class="fas fa-trash-alt text-danger mr-2"></i><span><?php echo lang('Main.xin_delete');?></span></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
            <?php $attributes = array('name' => 'add_attachment', 'id' => 'add_attachment', 'autocomplete' => 'off');?>
            <?php $hidden = array('token' => $segment_id);?>
            <?= form_open('erp/tickets/add_attachment', $attributes, $hidden);?>
            <div class="bg-white">
              <div class="row mt-4">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="task_name"><?php echo lang('Dashboard.xin_title');?></label>
                    <input class="form-control" placeholder="<?php echo lang('Dashboard.xin_title');?>" name="file_name" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <fieldset class="form-group">
                      <label for="logo"><?php echo lang('Main.xin_attachment');?></label>
                      <input type="file" class="form-control-file" id="attachment_file" name="attachment_file">
                      <small>
                      <?= lang('Main.xin_company_file_type');?>
                      </small>
                    </fieldset>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Projects.xin_add_file');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      <?php } ?>  
      </div>
    </div>
  </div>
</div>
