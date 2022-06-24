<?php
namespace App\Models;

use CodeIgniter\Model;
	
class MailreplyModel extends Model {
 
    protected $table = 'ci_mailbox_reply';

    protected $primaryKey = 'reply_id';
    
	// get all fields of table
    protected $allowedFields = ['reply_id','company_id','mail_id','mail_to','sent_by','description','is_read','is_main','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>