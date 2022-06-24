<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TicketfilesModel extends Model {
 
    protected $table = 'ci_support_ticket_files';

    protected $primaryKey = 'ticket_file_id';
    
	// get all fields of table
    protected $allowedFields = ['ticket_file_id','company_id','ticket_id','employee_id','file_title','attachment_file','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>