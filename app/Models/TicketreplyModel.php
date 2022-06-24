<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TicketreplyModel extends Model {
 
    protected $table = 'ci_support_ticket_reply';

    protected $primaryKey = 'ticket_reply_id';
    
	// get all fields of table
    protected $allowedFields = ['ticket_reply_id','company_id','ticket_id','sent_by','assign_to','reply_text','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>