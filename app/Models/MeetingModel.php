<?php
namespace App\Models;

use CodeIgniter\Model;
	
class MeetingModel extends Model {
 
    protected $table = 'ci_meetings';

    protected $primaryKey = 'meeting_id';
    
	// get all fields of table
    protected $allowedFields = ['meeting_id','company_id','employee_id','meeting_title','meeting_date','meeting_time','meeting_room','meeting_note','meeting_color','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>