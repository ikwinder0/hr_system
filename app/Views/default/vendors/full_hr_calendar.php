<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\EventsModel;
use App\Models\ConstantsModel;
use App\Models\HolidaysModel;
use App\Models\TrackgoalsModel;
use App\Models\InvoicesModel;
use App\Models\LeaveModel;
use App\Models\MeetingModel;
use App\Models\ProjectsModel;
use App\Models\TasksModel;
use App\Models\TrainingModel;
use App\Models\TravelModel;

//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$EventsModel = new EventsModel();
$ConstantsModel = new ConstantsModel();
$HolidaysModel = new HolidaysModel();
$TrackgoalsModel = new TrackgoalsModel();
$InvoicesModel = new InvoicesModel();
$MeetingModel = new MeetingModel();
$ProjectsModel = new ProjectsModel();
$TasksModel = new TasksModel();
$TrainingModel = new TrainingModel();
$TravelModel = new TravelModel();
$LeaveModel = new LeaveModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$xin_system = $SystemModel->where('setting_id', 1)->first();
$xin_com_system = erp_company_settings();
if($user_info['user_type'] == 'staff'){
	
} else {
	
}
if($user_info['user_type'] == 'staff'){
	// EventsModel
	$events_data = $EventsModel->where('company_id',$user_info['company_id'])->orderBy('event_id', 'ASC')->findAll();
	// TrackgoalsModel
	$track_goals_data = $TrackgoalsModel->where('company_id',$user_info['company_id'])->orderBy('tracking_id', 'ASC')->findAll();
	// HolidaysModel
	$holidays_data = $HolidaysModel->where('company_id',$user_info['company_id'])->orderBy('holiday_id', 'ASC')->findAll();
	// InvoicesModel
	$invoice_data = $InvoicesModel->where('company_id',$user_info['company_id'])->orderBy('invoice_id', 'ASC')->findAll();
	// LeaveModel
	$leave_data = $LeaveModel->where('employee_id',$usession['sup_user_id'])->orderBy('leave_id', 'ASC')->findAll();
	// MeetingModel
	$meeting_data = $MeetingModel->where('company_id',$user_info['company_id'])->orderBy('meeting_id', 'ASC')->findAll();
	// ProjectsModel
	$project_data = $ProjectsModel->where('company_id',$user_info['company_id'])->orderBy('project_id', 'ASC')->findAll();
	// TasksModel
	$task_data = $TasksModel->where('company_id',$user_info['company_id'])->orderBy('task_id', 'ASC')->findAll();
	// TrainingModel
	$training_data = $TrainingModel->where('company_id',$user_info['company_id'])->orderBy('training_id', 'ASC')->findAll();
	// TravelModel
	$travel_data = $TravelModel->where('company_id',$user_info['company_id'])->orderBy('travel_id', 'ASC')->findAll();
} else {
	// EventsModel
	$events_data = $EventsModel->where('company_id',$usession['sup_user_id'])->orderBy('event_id', 'ASC')->findAll();
	// TrackgoalsModel
	$track_goals_data = $TrackgoalsModel->where('company_id',$usession['sup_user_id'])->orderBy('tracking_id', 'ASC')->findAll();
	// HolidaysModel
	$holidays_data = $HolidaysModel->where('company_id',$usession['sup_user_id'])->orderBy('holiday_id', 'ASC')->findAll();
	// InvoicesModel
	$invoice_data = $InvoicesModel->where('company_id',$usession['sup_user_id'])->orderBy('invoice_id', 'ASC')->findAll();
	// LeaveModel
	$leave_data = $LeaveModel->where('company_id',$usession['sup_user_id'])->orderBy('leave_id', 'ASC')->findAll();
	// MeetingModel
	$meeting_data = $MeetingModel->where('company_id',$usession['sup_user_id'])->orderBy('meeting_id', 'ASC')->findAll();
	// ProjectsModel
	$project_data = $ProjectsModel->where('company_id',$usession['sup_user_id'])->orderBy('project_id', 'ASC')->findAll();
	// TasksModel
	$task_data = $TasksModel->where('company_id',$usession['sup_user_id'])->orderBy('task_id', 'ASC')->findAll();
	// TrainingModel
	$training_data = $TrainingModel->where('company_id',$usession['sup_user_id'])->orderBy('training_id', 'ASC')->findAll();
	// TravelModel
	$travel_data = $TravelModel->where('company_id',$usession['sup_user_id'])->orderBy('travel_id', 'ASC')->findAll();
}
?>
<?php
$events_date = date('Y-m');
?>
<script type="text/javascript">
$(document).ready(function(){
	
	/* initialize the calendar
	-----------------------------------------------------------------*/
	$('#calendar_hr').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay,listWeek'
		},
		locale: '<?= $xin_com_system['calendar_locale'];?>',
		/*views: {
			listDay: { buttonText: 'list day' },
			listWeek: { buttonText: 'list week' }
		  },*/
		//defaultView: 'agendaWeek',
		themeSystem: 'bootstrap4',
		/*bootstrapFontAwesome: {
		  close: ' ion ion-md-close',
		  prev: ' ion ion-ios-arrow-back scaleX--1-rtl',
		  next: ' ion ion-ios-arrow-forward scaleX--1-rtl',
		  prevYear: ' ion ion-ios-arrow-dropleft-circle scaleX--1-rtl',
		  nextYear: ' ion ion-ios-arrow-dropright-circle scaleX--1-rtl'
		},*/
		  
		eventRender: function(event, element) {
		element.attr('title',event.title).tooltip();
		element.attr('href', event.urllink);
        element.click(function() {
			$.ajax({
				url : main_url+"events/read_event_record/",
				type: "GET",
				data: 'jd=1&is_ajax=1&mode=modal&data=view_event&event_id='+event.event_id,
				success: function (response) {
					if(response) {
						$('#modals-slide').modal('show')
						$("#ajax_modal_view").html(response);
					}
				}
			});
        });
		
		},
		dayClick: function(date, jsEvent, view) {
        date_last_clicked = $(this);
			var event_date = date.format();
			$('#exact_date').val(event_date);
			var eventInfo = $("#module-opt");
            var mousex = jsEvent.pageX + 20; //Get X coodrinates
            var mousey = jsEvent.pageY + 20; //Get Y coordinates
            var tipWidth = eventInfo.width(); //Find width of tooltip
            var tipHeight = eventInfo.height(); //Find height of tooltip

            //Distance of element from the right edge of viewport
            var tipVisX = $(window).width() - (mousex + tipWidth);
            //Distance of element from the bottom of viewport
            var tipVisY = $(window).height() - (mousey + tipHeight);

            if (tipVisX < 20) { //If tooltip exceeds the X coordinate of viewport
                mousex = jsEvent.pageX - tipWidth - 20;
            } if (tipVisY < 20) { //If tooltip exceeds the Y coordinate of viewport
                mousey = jsEvent.pageY - tipHeight - 20;
            }
            //Absolute position the tooltip according to mouse position
            eventInfo.css({ top: mousey, left: mousex });
            eventInfo.show(); //Show tool tip
		},
		defaultDate: '<?php echo $events_date;?>',
		eventLimit: true, // allow "more" link when too many events
		navLinks: true, // can click day/week names to navigate views
		selectable: true,
		events: [
			<?php if(in_array('task1',staff_role_resource()) || $user_info['user_type'] == 'company') {?> 
			<?php foreach($events_data as $events):?>
			{
				event_id: '<?php echo $events['event_id']?>',
				unq: '0',
				title: '<?php echo $events['event_title']?>',
				start: '<?php echo $events['event_date']?>T<?php echo $events['event_time']?>',
				color: '#1de9b6 !important'
			},
			<?php endforeach;?>
			<?php } ?>
			<?php if(in_array('tracking1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
			<?php foreach($track_goals_data as $track_goal):?>
			{
				event_id: '<?php echo $track_goal['tracking_id']?>',
				unq: '0',
				title: '<?php echo $track_goal['subject']?>',
				start: '<?php echo $track_goal['start_date']?>',
				end: '<?php echo $track_goal['end_date']?>',
				urllink: '<?php echo site_url().'erp/goal-details/'.uencode($track_goal['tracking_id']);?>',
				color: '#e13faf !important'
			},
			<?php endforeach;?>
			<?php } ?>
			<?php if(in_array('holiday1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
			<?php foreach($holidays_data as $holiday):?>
			{
				event_id: '<?php echo $holiday['holiday_id']?>',
				unq: '0',
				title: '<?php echo $holiday['event_name']?>',
				start: '<?php echo $holiday['start_date']?>',
				end: '<?php echo $holiday['end_date']?>',
				color: '#dd8030 !important'
			},
			<?php endforeach;?>
			<?php } ?>
			<?php if(in_array('invoice2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
			<?php foreach($invoice_data as $invoice):?>
			{
				event_id: '<?php echo $invoice['invoice_number']?>',
				unq: '0',
				title: '<?php echo $invoice['invoice_number']?>',
				start: '<?php echo $invoice['invoice_date']?>',
				end: '<?php echo $invoice['invoice_date']?>',
				urllink: '<?php echo site_url().'erp/invoice-detail/'.uencode($invoice['invoice_id']);?>',
				color: '#98b815 !important'
			},
			<?php endforeach;?>
			<?php } ?>
			<?php if(in_array('leave2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
			<?php foreach($leave_data as $leave):?>
			<?php
				$ltype = $ConstantsModel->where('constants_id', $leave['leave_type_id'])->where('type','leave_type')->first();
				if($ltype){
					$category_name = $ltype['category_name'];
				} else {
					$category_name = '';
				}
			?>
			{
				event_id: '<?php echo $leave['leave_id']?>',
				unq: '0',
				title: '<?php echo $category_name?>',
				start: '<?php echo $leave['from_date']?>',
				end: '<?php echo $leave['to_date']?>',
				urllink: '<?php echo site_url().'erp/view-leave-info/'.uencode($leave['leave_id']);?>',
				color: '#f4c22b'
			},
			<?php endforeach;?>
			<?php } ?>
			<?php if(in_array('conference1',staff_role_resource()) || $user_info['user_type']== 'company') {?>
			<?php foreach($meeting_data as $meeting):?>
			{
				event_id: '<?php echo $meeting['meeting_id']?>',
				unq: '0',
				title: '<?php echo $meeting['meeting_title']?>',
				start: '<?php echo $meeting['meeting_date']?>T<?php echo $meeting['meeting_time']?>',
				color: '#f44236 !important'
			},
			<?php endforeach;?>
			<?php } ?>
			<?php if(in_array('project1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
			<?php foreach($project_data as $project):?>
			{
				event_id: '<?php echo $project['project_id']?>',
				unq: '0',
				title: '<?php echo $project['title']?>',
				start: '<?php echo $project['start_date']?>',
				end: '<?php echo $project['end_date']?>',
				urllink: '<?php echo site_url().'erp/project-detail/'.uencode($project['project_id']);?>',
				color: '#3ebfea !important'
			},
			<?php endforeach;?>
			<?php } ?>
			<?php if(in_array('task1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
			<?php foreach($task_data as $task):?>
			{
				event_id: '<?php echo $task['task_id']?>',
				unq: '0',
				title: '<?php echo $task['task_name']?>',
				start: '<?php echo $task['start_date']?>',
				end: '<?php echo $task['end_date']?>',
				urllink: '<?php echo site_url().'erp/task-detail/'.uencode($task['task_id']);?>',
				color: '#7267EF !important'
			},
			<?php endforeach;?>
			<?php } ?>
			<?php if(in_array('training1',staff_role_resource()) || $user_info['user_type'] == 'company') {?> 
			<?php foreach($training_data as $training):?>
			<?php
				$ptype = $ConstantsModel->where('constants_id',$training['training_type_id'])->first();
				if($ptype){
					$pcategory_name = $ptype['category_name'];
				} else {
					$pcategory_name = '';
				}
			?>
			{
				event_id: '<?php echo $training['training_id']?>',
				unq: '0',
				title: '<?php echo $pcategory_name?>',
				start: '<?php echo $training['start_date']?>',
				end: '<?php echo $training['finish_date']?>',
				urllink: '<?php echo site_url().'erp/training-details/'.uencode($training['training_id']);?>',
				color: '#36a934 !important'
			},
			<?php endforeach;?>
			<?php } ?>
			<?php if(in_array('travel1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
			<?php foreach($travel_data as $travel):?>
			{
				event_id: '<?php echo $travel['travel_id']?>',
				unq: '0',
				title: '<?php echo $travel['visit_purpose']?>',
				start: '<?php echo $travel['start_date']?>',
				end: '<?php echo $travel['end_date']?>',
				urllink: '<?php echo site_url().'erp/view-travel-info/'.uencode($travel['travel_id']);?>',
				color: '#a389d4 !important'
			},
			<?php endforeach;?>
			<?php } ?>
		]
	});	
	/* initialize the external events
	-----------------------------------------------------------------*/

	$('#external-events .fc-event').each(function() {

		// Different colors for events
        $(this).css({'backgroundColor': $(this).data('color'), 'borderColor': $(this).data('color')});

		// store data so the calendar knows to render an event upon drop
		$(this).data('event', {
			title: $.trim($(this).text()), // use the element's text as the event title
			color: $(this).data('color'),
			stick: true // maintain when user navigates (see docs on the renderEvent method)
		});

	});


});
</script>