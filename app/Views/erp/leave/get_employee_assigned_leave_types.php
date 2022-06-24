<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\LeaveModel;
use App\Models\ConstantsModel;
use App\Models\StaffdetailsModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$LeaveModel = new LeaveModel();
$ConstantsModel = new ConstantsModel();
$StaffdetailsModel = new StaffdetailsModel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$leave_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
} else {
	$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
}

$result = $UsersModel->where('user_id', $field_id)->first();
$employee_detail = $StaffdetailsModel->where('user_id', $result['user_id'])->first();
$leave_categories = explode(',',$employee_detail['leave_categories']);
$emp_cat = array('all');
?>
<div class="form-group" id="get_leave_types">
  <label for="leave_type" class="control-label">
    <?= lang('Leave.xin_leave_type');?> <span class="text-danger">*</span>
  </label>
  <select class="form-control" name="leave_type" data-plugin="select_hrm" data-placeholder="<?= lang('Leave.xin_leave_type');?>">
    <option value=""></option>
    <?php if(in_array('all',$leave_categories)):?>
    <?php foreach($leave_types as $ileave_type):?>
        <option value="<?= $ileave_type['constants_id'];?>">
        <?= $ileave_type['category_name'];?>
        </option>
        <?php endforeach;?>
    <?php else:?>
		<?php foreach($leave_categories as $ileave_type):?>
			<?php if($ileave_type!=0 && $ileave_type!='all'):?>
            <?php $leave_types = $ConstantsModel->where('constants_id',$ileave_type)->where('type','leave_type')->first(); ?>
            <option value="<?= $leave_types['constants_id'];?>">
            <?= $leave_types['category_name'];?>
            </option>
            <?php endif;?>
        <?php endforeach;?>
    <?php endif;?>
  </select>
</div>
<?php
//}
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	jQuery('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>