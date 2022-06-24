<?php
use App\Models\SystemModel;
use App\Models\JobsModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\ConstantsModel;
use App\Models\DepartmentModel;
use App\Models\AnnouncementModel;

$SystemModel = new SystemModel();
$JobsModel = new JobsModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();
$ConstantsModel = new ConstantsModel();
$DepartmentModel = new DepartmentModel();
$AnnouncementModel = new AnnouncementModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$request = \Config\Services::request();
$locale = service('request')->getLocale();

$segment_id = $request->uri->getSegment(3);
$ifield_id = udecode($segment_id);

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$result = $AnnouncementModel->where('company_id',$user_info['company_id'])->where('announcement_id', $ifield_id)->first();
} else {
	$result = $AnnouncementModel->where('company_id',$usession['sup_user_id'])->where('announcement_id', $ifield_id)->first();
}
?>

<div class="row">
  <div class="col-xl-4 col-lg-12 task-detail-right">
    <div class="card">
      <div class="card-header">
        <h5><?= lang('Dashboard.left_announcement');?></h5>
      </div>
      <div class="card-body task-details">
        <table class="table">
          <tbody>
            <tr>
              <td><i class="fas fa-adjust m-r-5"></i> <?php echo lang('Dashboard.xin_title');?>:</td>
              <td class="text-right"><span class="float-right">
                <?= $result['title'];?>
                </span></td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i> <?php echo lang('Projects.xin_start_date');?>:</td>
              <td class="text-right"><?= set_date_format($result['start_date']);?></td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i> <?php echo lang('Projects.xin_end_date');?>:</td>
              <td class="text-right"><?= set_date_format($result['end_date']);?></td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i> <?php echo lang('Main.xin_created_at');?>:</td>
              <td class="text-right"><?= set_date_format($result['created_at']);?></td>
            </tr>
            <?php $department_ids = explode(',',$result['department_id']); ?>
            <tr>
              <td><i class="fas fa-thermometer-half m-r-5"></i>
                <?= lang('Dashboard.left_department');?>
                :</td>
              <td>
			  <?php
              foreach($department_ids as $department_id) {
				  if($department_id!=0){
					$department = $DepartmentModel->where('department_id', $department_id)->first();
					echo $department['department_name'].'<br>';
				  }
			  }
			  ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-xl-8 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class=""><i class="fas fa-ticket-alt m-r-5"></i>
          <?= $result['title'];?>
        </h5>
        
      </div>
      <div class="card-body">
        <div class="m-b-20">
          <h6>
            <?= lang('Main.xin_summary');?>
          </h6>
          <hr>
          <p>
            <?= $result['summary'];?>
          </p>
        </div>
        <div class="m-b-20">
          <h6>
            <?= lang('Main.xin_description');?>
          </h6>
          <hr>
          <p>
            <?= html_entity_decode($result['description']);?>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
