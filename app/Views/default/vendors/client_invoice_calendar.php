<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\ConstantsModel;
use App\Models\InvoicesModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$ConstantsModel = new ConstantsModel();
$InvoicesModel = new InvoicesModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'customer'){
	$completed_invoices = $InvoicesModel->where('company_id',$user_info['company_id'])->where('client_id',$usession['sup_user_id'])->where('status', 1)->orderBy('invoice_id', 'ASC')->findAll();
	$pending_invoices = $InvoicesModel->where('company_id',$user_info['company_id'])->where('client_id',$usession['sup_user_id'])->where('status', 0)->orderBy('invoice_id', 'ASC')->findAll();
}
$xin_com_system = erp_company_settings();
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
			<?php foreach($completed_invoices as $cinvoice):?>
			{
				event_id: '<?php echo $cinvoice['invoice_number']?>',
				unq: '0',
				title: '<?php echo $cinvoice['invoice_number']?>',
				start: '<?php echo $cinvoice['invoice_date']?>',
				end: '<?php echo $cinvoice['invoice_date']?>',
				urllink: '<?php echo site_url().'erp/invoice-detail/'.uencode($cinvoice['invoice_id']);?>',
				color: '#1de9b6 !important'
			},
			<?php endforeach;?>
			<?php foreach($pending_invoices as $pinvoice):?>
			{
				event_id: '<?php echo $pinvoice['invoice_number']?>',
				unq: '0',
				title: '<?php echo $pinvoice['invoice_number']?>',
				start: '<?php echo $pinvoice['invoice_date']?>',
				end: '<?php echo $pinvoice['invoice_date']?>',
				urllink: '<?php echo site_url().'erp/invoice-detail/'.uencode($pinvoice['invoice_id']);?>',
				color: '#FFD950 !important'
			},
			<?php endforeach;?>
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