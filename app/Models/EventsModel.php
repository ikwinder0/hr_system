<?php
namespace App\Models;

use CodeIgniter\Model;
	
class EventsModel extends Model {
 
    protected $table = 'ci_events';

    protected $primaryKey = 'event_id';
    
	// get all fields of table
    protected $allowedFields = ['event_id','company_id','employee_id','event_title','event_date','event_time','event_note','event_color','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>