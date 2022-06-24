<?php
namespace App\Models;

use CodeIgniter\Model;
	
class LeadsfollowupModel extends Model {
 
    protected $table = 'ci_leads_followup';

    protected $primaryKey = 'followup_id';
    
	// get all fields of table
    protected $allowedFields = ['followup_id','lead_id','company_id','next_followup','description','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>