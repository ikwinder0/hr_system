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
$account_id = udecode($segment_id);

$company_id = user_company_info();
$xin_system = erp_company_settings();
$user_info = $UsersModel->where('user_id', $company_id)->first();
$account_data = $AccountsModel->where('company_id',$company_id)->where('account_id', $account_id)->first();
$transaction_data = $TransactionsModel->where('company_id',$company_id)->where('account_id', $account_id)->findAll();
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
                                                    <td><a href="#!"><img class="img-fluid" width="171" height="30" src="<?= base_url();?>/public/uploads/logo/other/<?= $ci_erp_settings['other_logo'];?>"></a>
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
                            <div class="col-md-7 invoice-client-info">
                                <h6><?= lang('Main.xin_account_info');?> :</h6>
                                <h6 class="m-0"><?= $account_data['account_name'];?></h6>
                                <p class="m-0 m-t-10"><?= $account_data['account_number'];?></p>
                                <p class="m-0"><?= $account_data['branch_code'];?>, <?= $account_data['bank_branch'];?></p>
                            </div>
                            <div class="col-md-5">
                                <h6 class="m-b-20"><?= lang('Main.xin_e_details_date');?></h6>
                                <h6 class="text-uppercase text-primary"><?= set_date_format(date('Y-m-d'));?>
                                </h6>
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
                                                <th>&nbsp;</th>
                                                <th><?= lang('Invoices.xin_amount');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $credit = 0; $debit = 0; $balance2 =0; $amount = 0;
										foreach($transaction_data as $transation) {
											
											
											if($transation['dr_cr']=="cr"){
												$title = '<span class="text-success">'.lang('Finance.xin_credit').'</span>';
												$credit += $transation['amount'];
												$balance2 = $balance2 + $account_data['account_balance'];
												
												$amount = '<h6 class="text-success">+ '.number_to_currency($transation['amount'], $xin_system['default_currency'],null,2).'</h6>';
												$type = $ConstantsModel->where('constants_id', $transation['entity_category_id'])->where('type','income_type')->first();
												if($type){
													$itype_name = $type['category_name'];
												} else {
													$itype_name = '--';
												}
											} else {
												$title = '<span class="text-danger">'.lang('Finance.xin_debit').'</span>';
												$debit += $transation['amount'];
												$balance2 = $balance2 - $account_data['account_balance'];
												$amount = '<h6 class="text-danger">- '.number_to_currency($transation['amount'], $xin_system['default_currency'],null,2).'</h6>';
												$type = $ConstantsModel->where('constants_id', $transation['entity_category_id'])->where('type','expense_type')->first();
												if($type){
													$itype_name = $type['category_name'];
												} else {
													$itype_name = '--';
												}
											}
											$payment_method = $ConstantsModel->where('constants_id', $transation['payment_method_id'])->where('type','payment_method')->first();
											if($payment_method){
												$ipayment_method = $payment_method['category_name'];
											} else {
												$ipayment_method = '';
											}
										?>
                                            <tr>
                                                <td>
                                                    <a href="<?= site_url('erp/transaction-details/').uencode($transation['transaction_id']);?>" class="text-secondary" style="text-decoration:none;"><h6><?= $itype_name;?></h6>
                                                    <p class="m-0"><?= $transation['description'];?></p></a>
                                                </td>
                                                <td><?= $ipayment_method;?></td>
                                                <td><?= $title;?></td>
                                                <td><?= $amount;?></td>
                                            </tr>
                                         <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-responsive invoice-table invoice-total">
                                    <tbody>
                                        <tr>
                                            <th><?= lang('Finance.xin_credit');?> : </th>
                                            <td><?= number_to_currency($credit, $xin_system['default_currency'],null,2)?></td>
                                        </tr>
                                        <tr>
                                            <th><?= lang('Finance.xin_debit');?> : </th>
                                            <td><?= number_to_currency($debit, $xin_system['default_currency'],null,2)?></td>
                                        </tr>
                                        <?php /*?><tr class="text-info">
                                            <td>
                                                <hr />
                                                <h5 class="text-primary m-r-10"><?= lang('Finance.xin_balance');?> : </h5>
                                            </td>
                                            <td>
                                                <hr />
                                                <h5 class="text-primary"><?= number_to_currency($balance2, $xin_system['default_currency'],null,2);?></h5>
                                            </td>
                                        </tr><?php */?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
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
