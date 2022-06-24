<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\PolicyModel;

$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$SystemModel = new SystemModel();
$PolicyModel = new PolicyModel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$get_data = $PolicyModel->where('company_id',$user_info['company_id'])->orderBy('policy_id', 'ASC')->findAll();
} else {
	$get_data = $PolicyModel->where('company_id',$usession['sup_user_id'])->orderBy('policy_id', 'ASC')->findAll();
}
$data = array();
?>
<?php if(in_array('policy2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div class="container-fluid flex-grow-1 container-p-y">
  <h3 class="text-center font-weight-bold py-1 mb-2">
    <?= lang('Dashboard.xin_view_policies');?>
    <a class="text-dark" href="<?php echo site_url('erp/policies-list');?>">
    <button type="button" class="btn btn-primary rounded-pill d-block"><span class="ion ion-md-add"></span>&nbsp;
    <?= lang('Main.xin_add_new');?>
    <?= lang('Dashboard.header_policy');?>
    </button>
    </a> </h3>
  <hr class="container-m-nx border-light my-0">
</div>
<?php } ?>
<div class="row">
  <div class="col-md-12">
    <div class="pc-wizard-subtitle-vertical card" id="detailswizard2">
      <div class="row">
        <div class="col-md-4">
          <ul class="nav flex-column card-body border-right px-0 nav-tabs">
            <?php $i=1;foreach($get_data as $r): ?>
            <li class="nav-item"><a href="#policy_<?= $r['policy_id'];?>" class="nav-link <?php if($i==1):?>active<?php else:?><?php endif;?>" data-toggle="tab"><i class="feather icon-check-square"></i><span>
              <h6>
                <?= $r['title'];?>
              </h6>
              </span></a></li>
            <?php $i++;endforeach;?>
          </ul>
        </div>
        <div class="col-md-8">
          <div class="card-body pb-0">
            <div class="tab-content">
              <?php $j=1;foreach($get_data as $r) { ?>
              <div class="tab-pane show <?php if($j==1):?>active<?php else:?><?php endif;?>" id="policy_<?php echo $r['policy_id'];?>">
                <h5 class="mt-3"><?php echo $r['title'];?></h5>
                <div><?php echo html_entity_decode($r['description']);?></div>
                <?php if($r['attachment']!='' || $r['attachment']!='no-file'){?>
				<?php
                      $imageProperties = [
                        'src'    => base_url().'/public/uploads/policy/'.$r['attachment'],
                        'alt'    => $r['title'],
                        'class'  => 'd-block ui-w-50',
                        'width'  => '100',
                        'height' => '100',
                        'title'  => $r['title']
                    ];
                     ?>
                <span class="box-96 mr-0-5">
                <?= img($imageProperties);?>
                </span>
                <?php } ?>
              </div>
              <?php $j++;} ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
