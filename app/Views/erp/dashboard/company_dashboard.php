<?php
use CodeIgniter\I18n\Time;

use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\ConstantsModel;
use App\Models\LeaveModel;
use App\Models\TicketsModel;
use App\Models\ProjectsModel;
use App\Models\MembershipModel;
use App\Models\TransactionsModel;
use App\Models\CompanymembershipModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$LeaveModel = new LeaveModel();
$TicketsModel = new TicketsModel();
$ProjectsModel = new ProjectsModel();
$MembershipModel = new MembershipModel();
$TransactionsModel = new TransactionsModel();
$ConstantsModel = new ConstantsModel();
$CompanymembershipModel = new CompanymembershipModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$xin_system = erp_company_settings();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$company_id = user_company_info();
$total_staff = $UsersModel->where('company_id', $company_id)->where('user_type','staff')->countAllResults();
$total_projects = $ProjectsModel->where('company_id',$company_id)->countAllResults();
$total_tickets = $TicketsModel->where('company_id',$company_id)->countAllResults();
$open = $TicketsModel->where('company_id',$company_id)->where('ticket_status', 1)->countAllResults();
$closed = $TicketsModel->where('company_id',$company_id)->where('ticket_status', 2)->countAllResults();
	
?>

<div class="row">
  <div class="col-xl-12 col-md-12">
    
    <div class="row">
      <div class="col-xl-12 col-md-12">
        <div class="row">
          <div class="col-sm-12">
             <div class="card flat-card">
				  <div class="row-table">
					<div class="col-sm-6 card-body br">
					  <div class="row">
						<div class="col-sm-12 text-md-center">
						  <h5>
							<?= $total_tickets;?>
						  </h5>
						  <span>
						  Total Candidate Applied
						  </span> </div>
					  </div>
					</div>
					<div class="col-sm-6 d-none d-md-table-cell d-lg-table-cell d-xl-table-cell card-body br">
					  <div class="row">
						<div class="col-sm-12 text-md-center">
						  <h5>
							<?= $open;?>
						  </h5>
						  <span>
						  Total Candidate Screened
						  </span> </div>
					  </div>
					</div>
					<div class="col-sm-6 card-body">
					  <div class="row">
						
						<div class="col-sm-12 text-md-center">
						  <h5>
							<?= $closed;?>
						  </h5>
						  <span>
						  Short listed
						  </span> </div>
					  </div>
					</div>
					<div class="col-sm-6 card-body br">
					  <div class="row">
						
						<div class="col-sm-12 text-md-center">
						  <h5>
							<?= $total_tickets;?>
						  </h5>
						  <span>
						  Selected
						  </span> </div>
					  </div>
					</div>
					<div class="col-sm-6 d-none d-md-table-cell d-lg-table-cell d-xl-table-cell card-body br">
					  <div class="row">
						
						<div class="col-sm-12 text-md-center">
						  <h5>
							<?= $open;?>
						  </h5>
						  <span>
						  Visa Approved
						  </span> </div>
					  </div>
					</div>
					<div class="col-sm-6 card-body">
					  <div class="row">
						
						<div class="col-sm-12 text-md-center">
						  <h5>
							<?= $closed;?>
						  </h5>
						  <span>
						  Ticket Issued
						  </span> </div>
					  </div>
					</div>
					<div class="col-sm-6 card-body">
					  <div class="row">
						
						<div class="col-sm-12 text-md-center">
						  <h5>
							<?= $closed;?>
						  </h5>
						  <span>
						  Travelled
						  </span> </div>
					  </div>
					</div>
				  </div>
				</div>
          </div>
       
        </div>
        
        <div class="row">
          <div class="col-xl-12 col-md-12">
             <div class="card">
			  <div class="card-header">
				<h5>
				  Dashboard
				</h5>
			  </div>
			  <div class="card-body">
				<div id="erp-payroll-chart"></div>
			  </div>
			</div>
          </div>
        </div>
       
      </div>
    </div>
  </div>
</div>
