<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TrackgoalsModel extends Model {
 
    protected $table = 'ci_track_goals';

    protected $primaryKey = 'tracking_id';
    
	// get all fields of table
    protected $allowedFields = ['tracking_id','company_id','tracking_type_id','start_date','end_date','subject','target_achiement','description','goal_work','goal_rating','goal_progress','goal_status','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>