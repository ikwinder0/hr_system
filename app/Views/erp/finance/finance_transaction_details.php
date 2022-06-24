<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MainModel;
use App\Models\AccountsModel;
use App\Models\ConstantsModel;
use App\Models\TransactionsModel;

$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$MainModel = new MainModel();
$AccountsModel = new AccountsModel();
$ConstantsModel = new ConstantsModel();
$TransactionsModel = new TransactionsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$segment_id = $request->uri->getSegment(3);
$transaction_id = udecode($segment_id);

$company_id = user_company_info();
$xin_system = erp_company_settings();
$user_info = $UsersModel->where('user_id', $company_id)->first();
$transaction_data = $TransactionsModel->where('company_id',$company_id)->where('transaction_id', $transaction_id)->first();
$account_data = $AccountsModel->where('company_id',$company_id)->where('account_id', $transaction_data['account_id'])->first();
if($account_data){
	$account_name = $account_data['account_name'];
	$account_number = $account_data['account_number'];
	$branch_code = $account_data['branch_code'];
	$bank_branch = $account_data['bank_branch'];
} else {
	$account_name = '--';
	$account_number = '--';
	$branch_code = '--';
	$bank_branch = '--';
}
if($transaction_data['transaction_type']=='expense'){
	$type = $ConstantsModel->where('constants_id', $transaction_data['entity_category_id'])->where('type','expense_type')->first();
} else {
	$type = $ConstantsModel->where('constants_id', $transaction_data['entity_category_id'])->where('type','income_type')->first();
}
$payment_method = $ConstantsModel->where('constants_id', $transaction_data['payment_method_id'])->where('type','payment_method')->first();
if($payment_method){
	$ipayment_method = $payment_method['category_name'];
} else {
	$ipayment_method = '';
}
$f_entity = $UsersModel->where('user_id', $transaction_data['entity_id'])->where('user_type','staff')->first();
if($f_entity){
	$payer_name = $f_entity['first_name'].' '.$f_entity['last_name'];
} else {
	$payer_name = '';
}
$ci_erp_settings = $SystemModel->where('setting_id', 1)->first();
?>
<div class="row">
    <!-- [ basic-alert ] start -->
    <div class="col-md-12">
        <!-- [ Invoice ] start -->
        <div class="container">
            <div>
                <div class="card" id="printTable">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-12 invoice-contact">
                                <div class="invoice-box row">
                                    <div class="col-md-12">
                                        <table class="table table-responsive invoice-table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td><a href="#!"><img class="img-fluid" width="171" height="30" src="<?= base_url();?>/public/uploads/logo/other/<?= $ci_erp_settings['other_logo'];?>" alt=""></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                        </div>
                        <div class="row invoive-info d-print-inline-flex">
                            <div class="col-md-6 invoice-client-info">
                                <h6><?= lang('Finance.xin_deposit_information');?> :</h6>
                                <h6 class="m-0"><?= $account_name;?></h6>
                                <p class="m-0 m-t-10"><?= $account_number;?></p>
                                <p class="m-0"><?= $branch_code;?>, <?= $bank_branch;?></p>
                            </div>
                            <div class="col-md-6">
                                    <table class="table table-responsive invoice-table invoice-order table-borderless">
                                        <tbody>
                                            <tr>
                                                <th><?= lang('Finance.xin_received_from');?> :</th>
                                                <td><strong><?= $payer_name;?></strong></td>
                                            </tr>
                                            <tr>
                                            <th><?= lang('Main.xin_e_details_date');?> :</th>
                                                <td><?= set_date_format($transaction_data['transaction_date']);?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table invoice-detail-table">
                                        <thead>
                                            <tr class="thead-default">
                                                <th><?= lang('Main.xin_description');?></th>
                                                <th><?= lang('Finance.xin_type');?></th>
                                                <th><?= lang('Finance.xin_acc_ref_no');?></th>
                                                <th><?= lang('Invoices.xin_amount');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h6><?= $type['category_name'];?></h6>
                                                    <p class="m-0"><?= $transaction_data['description'];?></p>
                                                </td>
                                                <td><?= $ipayment_method;?></td>
                                                <td><?= $transaction_data['reference'];?></td>
                                                <td><?= number_to_currency($transaction_data['amount'], $xin_system['default_currency'],null,2)?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-responsive invoice-table invoice-total">
                                    <tbody>
                                        <tr>
                                            <th><?= lang('Main.xin_total');?> : </th>
                                            <td> <?= number_to_currency($transaction_data['amount'], $xin_system['default_currency'],null,2)?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h6><?= lang('Invoices.xin_terms_condition');?> :</h6>
                                <p><?= $xin_system['invoice_terms_condition'];?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-center d-print-none">
                    <div class="col-sm-12 invoice-btn-group text-center">
                        <button type="button" class="btn btn-print-invoice waves-effect waves-light btn-primary m-b-10"><?= lang('Main.xin_print');?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Invoice ] end -->
    </div>
    <!-- [ basic-alert ] end -->
</div>
