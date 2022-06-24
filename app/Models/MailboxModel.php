<?php
namespace App\Models;

use CodeIgniter\Model;
	
class MailboxModel extends Model {
 
    protected $table = 'ci_mailbox';

    protected $primaryKey = 'mail_box_id';
    
	// get all fields of table
    protected $allowedFields = ['mail_box_id','company_id','mail_to','sent_by','subject','description','is_read','is_replied','is_starred','is_important','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>