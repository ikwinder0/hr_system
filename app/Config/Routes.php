<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// ERP|TimeHRM
///$routes->get('erp/{locale}/dashboard', 'Dashboard::language', ['namespace' => 'App\Controllers\Erp']);
$routes->get('erp/', 'Home::index', ['namespace' => 'App\Controllers']);
$routes->match(['get', 'post'], 'erp/auth/login/', 'Auth::login', ['namespace' => 'App\Controllers\Erp']);
$routes->get('erp/desk', 'Dashboard::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/set-language/(:segment)', 'Dashboard::language/$1', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/forgot-password/', 'Auth::forgot_password', ['namespace' => 'App\Controllers\Erp']);
$routes->get('erp/verified-password/', 'Auth::verified_password', ['namespace' => 'App\Controllers\Erp']);
$routes->match(['get', 'post'],'erp/auth/unlock/', 'Auth::unlock', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/my-profile/', 'Profile::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/system-logout/', 'Logout::index', ['namespace' => 'App\Controllers\Erp']);
/////Super User Modules
//4: Languages
$routes->get('erp/all-languages/', 'Languages::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'],'erp/languages/add_language/', 'Languages::add_language', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'],'erp/languages/delete_language/', 'Languages::delete_language', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'],'erp/languages/language_status/', 'Languages::language_status', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
//7: System||Settings|| STD
$routes->get('erp/currency-converter/', 'Settings::currency_converter', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
//STD
$routes->get('erp/system-settings/', 'Settings::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->match(['get', 'post'],'erp/settings/system_info/', 'Settings::system_info', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'],'erp/settings/add_logo/', 'Settings::add_logo', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'],'erp/settings/add_favicon/', 'Settings::add_favicon', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'],'erp/settings/add_singin_logo/', 'Settings::add_singin_logo', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'],'erp/settings/update_payment_gateway/', 'Settings::update_payment_gateway', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'],'erp/settings/email_info/', 'Settings::email_info', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'],'erp/settings/notification_position_info/', 'Settings::notification_position_info', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
//8: System||Constants
$routes->get('erp/system-constants/', 'Settings::constants', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->match(['get', 'post'], 'erp/settings/company_type_info/', 'Settings::company_type_info', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->match(['get', 'post'], 'erp/settings/update_company_type/', 'Settings::update_company_type', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'], 'erp/settings/delete_company_type/', 'Settings::delete_company_type', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'], 'erp/settings/currency_type_info/', 'Settings::currency_type_info', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'], 'erp/settings/update_currency_type/', 'Settings::update_currency_type', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'], 'erp/settings/delete_currency_type/', 'Settings::delete_currency_type', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
//9: System||Database Backup
$routes->get('erp/system-backup/', 'Settings::database_backup', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'], 'erp/settings/create_database_backup/', 'Settings::create_database_backup', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'], 'erp/settings/delete_db_backup/', 'Settings::delete_db_backup', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'], 'erp/settings/delete_dbsingle_backup/', 'Settings::delete_dbsingle_backup', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
//10: System||Email Templates
$routes->get('erp/email-templates/', 'Settings::email_templates', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'], 'erp/settings/update_template/', 'Settings::update_template', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->get('erp/sms-templates/', 'Settings::sms_templates', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);
$routes->match(['get', 'post'], 'erp/settings/update_sms_template/', 'Settings::update_template', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin',]);

/***************************************************************************************************************/
/***************************************************************************************************************/
/***************************************************************************************************************/

/////Company|Staff Modules
//1: Staff Roles
$routes->get('erp/set-roles/', 'Roles::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin','filter' => 'companyauth']);
$routes->match(['get', 'post'], 'erp/roles/add_role/', 'Roles::add_role', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin','filter' => 'companyauth']);
$routes->match(['get', 'post'], 'erp/roles/update_role/', 'Roles::update_role', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin','filter' => 'companyauth']);
$routes->match(['get', 'post'], 'erp/roles/delete_role/', 'Roles::delete_role', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin','filter' => 'companyauth']);
//2: Assets
$routes->get('erp/assets-list/', 'Assets::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin','filter' => 'companyauth']);
$routes->get('erp/asset-view/(:segment)', 'Assets::asset_view', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin','filter' => 'companyauth']);
$routes->match(['get', 'post'], 'erp/assets/assets_list/', 'Assets::assets_list', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin','filter' => 'companyauth']);
$routes->match(['get', 'post'], 'erp/assets/read_asset/', 'Assets::read_asset', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin','filter' => 'companyauth']);
$routes->match(['get', 'post'], 'erp/assets/add_asset/', 'Assets::add_asset', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin','filter' => 'companyauth']);
$routes->match(['get', 'post'], 'erp/assets/update_asset/', 'Assets::update_asset', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin','filter' => 'companyauth']);
$routes->match(['get', 'post'], 'erp/assets/delete_asset/', 'Assets::delete_asset', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin','filter' => 'companyauth']);


// module types
$routes->get('erp/assets-category/', 'Types::asset_category', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin','filter' => 'companyauth']);
$routes->get('erp/assets-brand/', 'Types::asset_brand', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin','filter' => 'companyauth']);
$routes->get('erp/leave-type/', 'Types::leave_type', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/award-type/', 'Types::award_type', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/arrangement-type/', 'Types::arrangement_type', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/exit-type/', 'Types::exit_type', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/income-type/', 'Types::income_type', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/expense-type/', 'Types::expense_type', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/competencies/', 'Types::competencies', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/goal-type/', 'Types::goal_type', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/training-skills/', 'Types::training_type', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/case-type/', 'Types::case_type', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/tax-type/', 'Types::tax_type', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/jobs-categories/', 'Types::jobs_categories', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/customers-group/', 'Types::customers_group', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/products-category/', 'Types::product_category', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);

// core hr dashboard
$routes->get('erp/corehr-dashboard/', 'Department::corehr_dashboard', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// department
$routes->get('erp/departments-list/', 'Department::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// designation
$routes->get('erp/designation-list/', 'Designation::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// announcements
$routes->get('erp/news-list/', 'Announcements::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/announcement-view/(:segment)', 'Announcements::announcement_view', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// policies
$routes->get('erp/policies-list/', 'Policies::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/all-policies/', 'Policies::staff_policies_all', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// staff
$routes->get('erp/create-employee/', 'Employees::create', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/staff-list/', 'Employees::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/staff-grid/', 'Employees::staff_grid', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/staff-dashboard/', 'Employees::staff_dashboard', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/organization-chart/', 'Employees::staff_chart', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/employee-details/(:segment)', 'Employees::staff_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/employee-application/(:segment)', 'Employees::view_application', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/application-status', 'Employees::application_status', ['namespace' => 'App\Controllers\Erp','filter' => 'superauth']);
// awards
$routes->get('erp/awards-list/', 'Awards::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/award-view/(:segment)', 'Awards::award_view', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// travel
$routes->get('erp/business-travel/', 'Travel::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/travel-calendar/', 'Travel::travel_calendar', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/view-travel-info/(:segment)', 'Travel::travel_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// complaints
$routes->get('erp/complaints-list/', 'Complaints::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// resignation
$routes->get('erp/resignation-list/', 'Resignation::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// transfer
$routes->get('erp/transfers-list/', 'Transfers::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// employee exit
$routes->get('erp/employee-exit/', 'Leaving::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// documents || upload files, official and expired documents
$routes->get('erp/upload-files/', 'Documents::upload_files', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/official-documents/', 'Documents::official_documents', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/expired-documents/', 'Documents::expired_documents', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// warning
$routes->get('erp/disciplinary-cases/', 'Warning::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// tickets
$routes->get('erp/support-tickets/', 'Tickets::tickets_page', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/create-ticket/', 'Tickets::create_ticket', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/helpdesk-dashboard/', 'Tickets::helpdesk_dashboard', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/ticket-view/(:segment)', 'Tickets::ticket_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// training
$routes->get('erp/training-sessions/', 'Training::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/training-details/(:segment)', 'Training::training_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/training-calendar/', 'Training::training_calendar', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// trainers
$routes->get('erp/trainers-list/', 'Trainers::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// events
$routes->get('erp/events-list/', 'Events::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/events-calendar/', 'Events::events_calendar', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// meetings
$routes->get('erp/meeting-list/', 'Conference::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/meetings-calendar/', 'Conference::meetings_calendar', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// leave
$routes->get('erp/leave-list/', 'Leave::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/leave-status/', 'Leave::leave_status', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/view-leave-info/(:segment)', 'Leave::view_leave', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/leave-calendar/', 'Leave::leave_calendar', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// holidays
$routes->get('erp/holidays-list/', 'Holidays::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/holidays-calendar/', 'Holidays::holidays_calendar', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// officeshifts
$routes->get('erp/office-shifts/', 'Officeshifts::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// tasks||Staff
$routes->get('erp/tasks-list/', 'Tasks::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/tasks-grid/', 'Tasks::tasks_grid', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/task-detail/(:segment)', 'Tasks::task_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/tasks-summary/', 'Tasks::tasks_summary', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/tasks-calendar/', 'Tasks::tasks_calendar', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/tasks-scrum-board/', 'Tasks::tasks_scrum_board', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// tasks||Clients
$routes->get('erp/my-tasks-list/', 'Tasks::task_client', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/task-details/(:segment)', 'Tasks::client_task_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// clients
$routes->get('erp/clients-list/', 'Clients::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/clients-grid/', 'Clients::clients_grid', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/view-client-info/(:segment)', 'Clients::client_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// leads
$routes->get('erp/leads-list/', 'Clients::leads_index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/view-lead-info/(:segment)', 'Clients::lead_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// performance
$routes->get('erp/performance-indicator-list', 'Talent::performance_indicator', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/kpi-details/(:segment)', 'Talent::indicator_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/performance-appraisal-list', 'Talent::performance_appraisal', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/kpa-details/(:segment)', 'Talent::appraisal_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/track-goals', 'Trackgoals::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/goal-details/(:segment)', 'Trackgoals::goal_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/goals-calendar/', 'Trackgoals::goals_calendar', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// visitors
$routes->get('erp/visitors-list/', 'Visitors::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// todo
$routes->get('erp/todo-list/', 'Todo::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// organization chart
$routes->get('erp/chart/', 'Application::org_chart', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// subscription
$routes->get('erp/my-subscription/', 'Subscription::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/subscription-expired/', 'Subscription::subscription_expired', ['namespace' => 'App\Controllers\Erp']);
$routes->get('erp/upgrade-subscription/(:segment)', 'Subscription::upgrade_subscription', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/subscription-list/', 'Subscription::more_subscriptions', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// payment history
$routes->get('erp/my-payment-history/', 'Paymenthistory::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/payment-details/(:segment)', 'Paymenthistory::billing_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// contact support
$routes->get('erp/contact-support/', 'Contact::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// payroll
$routes->get('erp/payroll-list/', 'Payroll::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/payroll-view/(:segment)', 'Payroll::payroll_view', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/payslip-history/', 'Payroll::payroll_history', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/advance-salary/', 'Payroll::advance_salary', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/loan-request/', 'Payroll::request_loan', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// invoices || Staff
$routes->get('erp/invoices-list/', 'Invoices::project_invoices', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/invoice-dashboard/', 'Invoices::invoice_dashboard', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/invoice-payments-list/', 'Invoices::project_invoice_payment', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/create-new-invoice/', 'Invoices::create_invoice', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/invoice-calendar/', 'Invoices::invoice_calendar', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/invoice-detail/(:segment)', 'Invoices::invoice_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/edit-invoice/(:segment)', 'Invoices::edit_invoice', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/print-invoice/(:segment)', 'Invoices::view_project_invoice', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// estimates || Staff
$routes->get('erp/estimates-list/', 'Estimates::project_estimates', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/create-new-estimate/', 'Estimates::create_estimate', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/estimates-calendar/', 'Estimates::estimates_calendar', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/estimate-detail/(:segment)', 'Estimates::estimate_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/edit-estimate/(:segment)', 'Estimates::edit_estimate', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/print-estimate/(:segment)', 'Estimates::view_project_estimate', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// invoices || Clients
$routes->get('erp/my-invoices-list/', 'Invoices::invoices_client', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/my-invoice-payments-list/', 'Invoices::client_invoice_payment', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/my-invoices-calendar/', 'Invoices::client_invoice_calendar', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// staff attendance
$routes->get('erp/timesheet-dashboard/', 'Timesheet::timesheet_dashboard', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/attendance-list/', 'Timesheet::attendance', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/attendance-info/(:segment)/(:segment)', 'Timesheet::attendance_view', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/manual-attendance/', 'Timesheet::update_attendance', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/monthly-attendance-view/', 'Timesheet::monthly_timesheet', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/monthly-attendance/', 'Timesheet::monthly_timesheet_filter', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/timesheet-calendar/', 'Timesheet::timesheet_calendar', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// overtime request
$routes->get('erp/overtime-request/', 'Timesheet::overtime_request', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// custom fields
$routes->get('erp/custom-fields/', 'Customfields::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// Finance
$routes->get('erp/finance-dashboard/', 'Finance::finance_dashboard', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/payees-list/', 'Finance::payees', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/payers-list/', 'Finance::payers', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/accounts-list/', 'Finance::bank_cash', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/deposit-list/', 'Finance::deposit', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/expense-list/', 'Finance::expense', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/transfer-list/', 'Finance::transfer', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/account-ledger/(:segment)', 'Finance::account_ledger', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/transactions-list/', 'Finance::transactions', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/transaction-details/(:segment)', 'Finance::transaction_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// HR System
$routes->get('erp/system-reports/', 'Application::reports', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/attendance-report/', 'Reports::attendance_report', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/payroll-report/', 'Reports::payroll_report', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/project-report/', 'Reports::project_report', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/task-report/', 'Reports::task_report', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/invoice-report/', 'Reports::invoice_report', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/leave-report/', 'Reports::leave_report', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/training-report/', 'Reports::training_report', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/account-statement/', 'Reports::account_statement', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/purchases-report/', 'Reports::purchases_report', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/sales-order-report/', 'Reports::salesorder_report', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/system-import/', 'Application::import', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/system-calendar/', 'Application::erp_calendar', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/company-settings/', 'Application::company_settings', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/company-constants/', 'Application::company_constants', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// recruitment
$routes->get('erp/jobs-dashboard/', 'Recruitment::recruitment_dashboard', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/jobs-list/', 'Recruitment::jobs', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/view-job/(:segment)', 'Recruitment::job_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/candidates-list/', 'Recruitment::candidates', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/jobs-interviews/', 'Recruitment::interviews', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/interview-status/', 'Recruitment::update_interview_status', ['namespace' => 'App\Controllers\Erp','filter' => 'superauth']);
$routes->get('erp/result-save/', 'Recruitment::result_save', ['namespace' => 'App\Controllers\Erp','filter' => 'superauth']);
$routes->get('erp/feedback-save/', 'Recruitment::feedback_save', ['namespace' => 'App\Controllers\Erp','filter' => 'superauth']);
$routes->get('erp/promotion-list/', 'Recruitment::promotions', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/create-new-job/', 'Recruitment::create_job', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/edit-a-job/(:segment)', 'Recruitment::edit_job', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// projects||Staff
$routes->get('erp/projects-dashboard/', 'Projects::projects_dashboard', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/projects-list/', 'Projects::projects', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/projects-calendar/', 'Projects::projects_calendar', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/projects-scrum-board/', 'Projects::projects_scrum_board', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/project-detail/(:segment)', 'Projects::project_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/projects-grid/', 'Projects::projects_grid', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// projects||Clients
$routes->get('erp/my-projects-list/', 'Projects::projects_client', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/project-details/(:segment)', 'Projects::client_project_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
/***************************************************************************************************************/
/***************************************************************************************************************/
// INVENTORY
$routes->get('erp/suppliers-list/', 'Suppliers::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/warehouse-list/', 'Warehouse::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/product-list/', 'Products::index', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/product-view/(:segment)', 'Products::product_view', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/out-of-stock-products/', 'Products::out_of_stock', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/expired-products/', 'Products::expired_stock', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// purchases
$routes->get('erp/create-purchase/', 'Purchases::create_purchase', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/stock-purchases/', 'Purchases::stock_purchases', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/purchase-detail/(:segment)', 'Purchases::purchase_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/edit-purchase/(:segment)', 'Purchases::edit_purchase', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/print-purchase/(:segment)', 'Purchases::view_purchase_invoice', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// orders
$routes->get('erp/create-order/', 'Orders::create_order', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/stock-orders/', 'Orders::stock_orders', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/paid-orders/', 'Orders::paid_orders', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/unpaid-orders/', 'Orders::unpaid_orders', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/packed-orders/', 'Orders::packed_orders', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/delivered-orders/', 'Orders::delivered_orders', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/cancelled-orders/', 'Orders::cancelled_orders', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/order-detail/(:segment)', 'Orders::order_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/edit-order/(:segment)', 'Orders::edit_order', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/print-order/(:segment)', 'Orders::view_order_invoice', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
// Order quotes
$routes->get('erp/create-quote/', 'Orderquotes::create_quote', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/order-quotes/', 'Orderquotes::stock_quoteorders', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/quote-detail/(:segment)', 'Orderquotes::quote_details', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/edit-quote/(:segment)', 'Orderquotes::edit_quote', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/print-quote/(:segment)', 'Orderquotes::view_quote_order', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
//Companies
// $routes->get('erp/create-agency', 'Agency::create_agency', ['namespace' => 'App\Controllers\Erp','filter' => 'checklogin']);
$routes->get('erp/companies-list/', 'Companies::index', ['namespace' => 'App\Controllers\Erp','filter' => 'superauth']);
$routes->get('erp/company-detail/(:segment)', 'Companies::company_details', ['namespace' => 'App\Controllers\Erp','filter' => 'superauth']);


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
