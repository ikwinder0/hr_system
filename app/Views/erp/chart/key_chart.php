<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\StaffdetailsModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$DepartmentModel = new DepartmentModel();
$DesignationModel = new DesignationModel();
$StaffdetailsModel = new StaffdetailsModel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$company_id = $user_info['company_id'];
} else {
	$company_id = $usession['sup_user_id'];
}
$user_chart = $UsersModel->where('user_id', $company_id)->first();
$main_department = $DepartmentModel->where('company_id', $company_id)->where('department_head!=', 0)->findAll();
$get_animate = '';
?>
<?php /*?><?php foreach($main_department as $idepartment){?>
	<?php $idep_head = $UsersModel->where('user_id', $idepartment['department_head'])->first(); ?>
    <?= $idep_head['first_name'].' '.$idep_head['last_name'].$idepartment['department_id'];?> - <?= $idepartment['department_name'];?><br>
    <?php $subdesign = $DesignationModel->where('department_id', $idepartment['department_id'])->first(); ?>
    <?php $idesignation = $StaffdetailsModel->where('designation_id', $subdesign['designation_id'])->findAll(); ?>
    <?php foreach($idesignation as $sdesign){?>
			
			<?php $iuser_count = $UsersModel->where('user_id', $sdesign['user_id'])->countAllResults(); ?>
			<?php if($iuser_count > 0){?>
            <?php $iuser = $UsersModel->where('user_id', $sdesign['user_id'])->first(); ?>
            <?= $iuser['first_name'].' '.$iuser['last_name'].$idepartment['department_id'].'__'.$sdesign['designation_id'];?>', 'title': '<?= $sdesign['designation_name'];?><br>
            <?php } ?>
			<?php }?>
<?php } ?><?php */?>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h5 class="card-title"><?= lang('Dashboard.xin_org_chart_title');?></h5>
                <div id="chart-container"></div>
            </div>
        </div>
    </div>
    
    
</div>