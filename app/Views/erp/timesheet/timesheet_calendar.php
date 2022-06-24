<div class="ui-bordered px-4 pt-4 mb-4">
  <?php $attributes = array('name' => 'xin-form', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => 1);?>
        <?php echo form_open('admin/timesheet/timecalendar/', $attributes, $hidden);?>
  <div class="form-row">
    <div class="col-md mb-4">
      <label class="form-label"><?= lang('xin_e_details_date');?></label>
      <input class="form-control hr_month_year" value="<?php //if(!isset($month_year)): echo date('Y-m'); else: echo $month_year; endif;?>" name="month_year" type="text">
    </div>
    <?php //if($user_info[0]->user_role_id==1){?>
    
    <div class="col-md mb-3" id="employee_ajax">
      <label class="form-label"><?= lang('xin_employee');?></label>
      <select name="employee_id" id="employee_id" class="form-control employee-data" data-plugin="select_hrm" data-placeholder="<?= lang('xin_choose_an_employee');?>" required>
        <?php //if(isset($employee_id)): ?>
        <?php //$result = $this->Department_model->ajax_company_employee_info($company_id); ?>
        <option value="0">All</option>
        <?php //foreach($result as $employee) {?>
        <option value="<?php echo $employee->user_id;?>" <?php if($employee->user_id==$employee_id): ?> selected="selected" <?php endif;?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
        <?php //} ?>
        <?php //endif;?>
      </select>
    </div>
    <?php //} ?>
    <div class="col-md col-xl-2 mb-4">
      <label class="form-label d-none d-md-block">&nbsp;</label>
      <button type="submit" class="btn btn-secondary btn-block"><?= lang('xin_get');?></button>
    </div>
  </div>
  <?php echo form_close(); ?> </div>
<?php //if(isset($company_id) || $user_info[0]->user_role_id!=1){?>
<div class="row <?php echo $get_animate;?>">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $r[0]->first_name.' '.$r[0]->last_name;?> - <?php echo date('F Y',strtotime($month_year));?></strong></span> </div>
      <div class="card-body">
        <div class="table-responsive" data-pattern="priority-columns">
          <table class="table table-striped m-md-b-0">
            <tbody>
              <tr>
                <th scope="row"><?= lang('left_company');?></th>
                <td class="text-right"><?php echo $comp_name;?></td>
              </tr>
              <tr>
                <th scope="row" style="border-top:0px;"><?= lang('left_department');?></th>
                <td class="text-right"><?php echo $department_name;?></td>
              </tr>
              <tr>
                <th scope="row" style="border-top:0px;"><?= lang('left_designation');?></th>
                <td class="text-right"><?php echo $designation_name;?></td>
              </tr>
              <tr>
                <th scope="row"><?= lang('dashboard_employee_id');?></th>
                <td class="text-right"><?php echo $r[0]->employee_id;?></td>
              </tr>
              <tr>
                <th scope="row"><?= lang('xin_attendance_total_present');?></th>
                <td class="text-right"><?php echo $pcount;?></td>
              </tr>
              <tr>
                <th scope="row"><?= lang('xin_attendance_total_absent');?></th>
                <td class="text-right"><?php echo $acount;?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <div id='calendar_hr'></div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.popoverTitleCalendar{
  width: 100%;
  height: 100%;
  padding: 15px 15px;
  font-family: Roboto;
  font-size: 13px;
  border-radius: 5px 5px 0 0;
}
.popoverInfoCalendar i{
  font-size: 14px;
    margin-right: 10px;
    line-height: inherit;
    color: #d3d4da;
}
.popoverInfoCalendar p{
  margin-bottom: 1px;
}
.popoverDescCalendar{
  margin-top: 12px;
  padding-top: 12px;
  border-top: 1px solid #E3E3E3;
  overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}
.popover-title {
    background: transparent;
    font-weight: 600;
    padding: 0 !important;
    border: none;
}
.popover-content {
    padding: 15px 15px;
    font-family: Roboto;
    font-size: 13px;
}
.fc-center h2{
   text-transform: uppercase;
  font-size: 18px;
  font-family: Roboto;
  font-weight: 500;
  color: #505363;
  line-height: 32px;
}
.fc-toolbar.fc-header-toolbar {
    margin-bottom: 22px;
    padding-top: 22px;
}
.fc-agenda-view .fc-day-grid .fc-row .fc-content-skeleton {
    padding-bottom: 1em;
    padding-top: 1em;
}
.fc-day{
  transition: all 0.2s linear;
}
.fc-day:hover{
  background:#EEF7FF;
  cursor: pointer;
  transition: all 0.2s linear;
}
.fc-highlight {
    background: #EEF7FF;
    opacity: 0.7;
}
.fc-time-grid-event.fc-short .fc-time:before {
    content: attr(data-start);
    display: none;
}
.fc-time-grid-event.fc-short .fc-time span {
    display: inline-block;
}
.fc-time-grid-event.fc-short .fc-avatar-image {
    display: none;
    transition: all 0.3s linear;
}
.fc-time-grid .fc-bgevent, .fc-time-grid .fc-event {
    border: 1px solid #fff !important;
}
.fc-time-grid-event.fc-short .fc-content {
    padding: 4px 20px 10px 22px !important;
}
.fc-time-grid-event .fc-avatar-image{
    top: 9px;
}
.fc-event-vert {
  min-height: 22px;
}
.fc .fc-axis {
    vertical-align: middle;
    padding: 0 4px;
    white-space: nowrap;
    font-size: 10px;
    color: #505362;
    text-transform: uppercase;
    text-align: center !important;
    background-color: #fafafa;
}
.fc-unthemed .fc-event .fc-content, .fc-unthemed .fc-event-dot .fc-content {
    padding: 10px 20px 10px 22px;
    font-family: 'Roboto', sans-serif;
    margin-left: -1px;
    height: 100%;
}
.fc-event{
    border: none !important;
}
.fc-day-grid-event .fc-time {
    font-weight: 700;
      text-transform: uppercase;
}
.fc-unthemed .fc-day-grid td:not(.fc-axis).fc-event-container {
    padding: 0.2rem 0.5rem;
}
.fc-unthemed .fc-content, .fc-unthemed .fc-divider, .fc-unthemed .fc-list-heading td, .fc-unthemed .fc-list-view, .fc-unthemed .fc-popover, .fc-unthemed .fc-row, .fc-unthemed tbody, .fc-unthemed td, .fc-unthemed th, .fc-unthemed thead {
    border-color: #DADFEA;
}
.fc-ltr .fc-h-event .fc-end-resizer, .fc-ltr .fc-h-event .fc-end-resizer:before, .fc-ltr .fc-h-event .fc-end-resizer:after, .fc-rtl .fc-h-event .fc-start-resizer, .fc-rtl .fc-h-event .fc-start-resizer:before, .fc-rtl .fc-h-event .fc-start-resizer:after {
    left: auto;
    cursor: e-resize;
    background: none;
}
.colorAppointment :before {
    background-color: #9F4AFF;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
}
.colorCheck-in :before {
    background-color: #ff4747;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
}
.colorCheckout :before {
    background-color: #FFC400;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
}
.colorInventory :before {
    background-color: #FE56F2;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
}
.colorValuation :before {
    background-color: #0DE882;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
}
.colorViewing :before {
    background-color: #26CBFF;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
}
select.filter{
  width: 500px !important;
}

.popover  {
	background: #fff !important;
	color: #2E2F34;
  border: none;
  margin-bottom: 10px;
}

/*popover header*/
.popover-title{
    background: #F7F7FC;
    font-weight: 600;
    padding: 15px 15px 11px ;
    border: none;
}

/*popover arrows*/
.popover.top .arrow:after {
  border-top-color: #fff;
}

.popover.right .arrow:after {
  border-right-color: #fff;
}

.popover.bottom .arrow:after {
  border-bottom-color: #fff;
}

.popover.left .arrow:after {
  border-left-color: #fff;
}

.popover.bottom .arrow:after {
  border-bottom-color: #fff;
}
.material-icons {
  font-family: 'Material Icons';
  font-weight: normal;
  font-style: normal;
  font-size: 24px;  /* Preferred icon size */
  display: inline-block;
  line-height: 1;
  text-transform: none;
  letter-spacing: normal;
  word-wrap: normal;
  white-space: nowrap;
  direction: ltr;

  /* Support for all WebKit browsers. */
  -webkit-font-smoothing: antialiased;
  /* Support for Safari and Chrome. */
  text-rendering: optimizeLegibility;

  /* Support for Firefox. */
  -moz-osx-font-smoothing: grayscale;

  /* Support for IE. */
  font-feature-settings: 'liga';
}
.fc-icon-print::before{
  font-family: 'Material Icons';
  content: "\e8ad";
  font-size: 24px;
}
.fc-printButton-button{
  padding: 0 3px !important;
}

@media print {
.print-visible  { display: inherit !important; }
.hidden-print   { display: none !important; }
}
</style>
<?php //} ?>
<style type="text/css">
.calendar-options { padding: .3rem 0.4rem !important;}
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>