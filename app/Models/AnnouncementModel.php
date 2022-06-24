<?php
namespace App\Models;

use CodeIgniter\Model;
	
class AnnouncementModel extends Model {
 
    protected $table = 'ci_announcements';

    protected $primaryKey = 'announcement_id';
    
	// get all fields of table
    protected $allowedFields = ['announcement_id','company_id','department_id','title','start_date','end_date','published_by','summary','description','is_active','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>