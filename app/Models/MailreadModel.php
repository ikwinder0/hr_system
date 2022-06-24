<?php
namespace App\Models;

use CodeIgniter\Model;
	
class MailreadModel extends Model {
 
    protected $table = 'ci_mailbox_read';

    protected $primaryKey = 'read_id';
    
	// get all fields of table
    protected $allowedFields = ['read_id','company_id','mail_id','mail_to','sent_by','is_read','is_starred','is_important','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>