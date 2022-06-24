<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\MeetingModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$MeetingModel = new MeetingModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$get_data = $MeetingModel->where('company_id',$user_info['company_id'])->orderBy('meeting_id', 'ASC')->findAll();
} else {
	$get_data = $MeetingModel->where('company_id',$usession['sup_user_id'])->orderBy('meeting_id', 'ASC')->findAll();
}
?>
<?php
$events_date = date('Y-m');
?>
<script type="text/javascript">
$(document).ready(function() {
	 $(function () {
        $("#scheduler").kendoScheduler({
            date: new Date("2013/6/10"),
            startTime: new Date("2021/3/12 08:00 PM"),
            endTime: new Date("2021/3/16 08:00 PM"),
            dateHeaderTemplate: kendo.template("<strong>#=kendo.toString(date, 'D')# - #=kendo.toString(kendo.date.nextDay(date), 'D')#</strong>"),
            eventHeight: 50,
            majorTick: 360,
            views: [ "timeline", "timelineWeek" ],
            timezone: "Etc/UTC",
            dataSource: {
                batch: true,
                transport: {
                    read: {
                        url: "http://localhost/timehrm/erp/conference/conference_values",
                        dataType: "jsonp"
                    },
                    update: {
                        url: "https://demos.telerik.com/kendo-ui/service/meetings/update",
                        dataType: "jsonp"
                    },
                    create: {
                        url: "https://demos.telerik.com/kendo-ui/service/meetings/create",
                        dataType: "jsonp"
                    },
                    destroy: {
                        url: "https://demos.telerik.com/kendo-ui/service/meetings/destroy",
                        dataType: "jsonp"
                    },
                    parameterMap: function (options, operation) {
                        if (operation !== "read" && options.models) {
                            return { models: kendo.stringify(options.models) };
                        }
                    }
                },
                schema: {
                    model: {
                        id: "meetingID",
                        fields: {
                            meetingID: { from: "MeetingID", type: "number" },
                            title: { from: "Title", defaultValue: "No title", validation: { required: true } },
                            start: { type: "date", from: "Start" },
                            end: { type: "date", from: "End" },
                            startTimezone: { from: "StartTimezone" },
                            endTimezone: { from: "EndTimezone" },
                            description: { from: "Description" },
                            recurrenceId: { from: "RecurrenceID" },
                            recurrenceRule: { from: "RecurrenceRule" },
                            recurrenceException: { from: "RecurrenceException" },
                            roomId: { from: "RoomID", nullable: true },
                            attendees: { from: "Attendees", nullable: true },
                            isAllDay: { type: "boolean", from: "IsAllDay" }
                        }
                    }
                }
            },
            group: {
                resources: ["Rooms"],
                orientation: "vertical"
            },
            resources: [{
                field: "roomId",
                name: "Rooms",
                dataSource: [
                    { text: "Meeting Room 101", value: 1, color: "#6eb3fa" },
                    { text: "Meeting Room 201", value: 2, color: "#f58a8a" }
                ],
                title: "Room"
            }]
        });
    });
});
</script>