<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TodoModel extends Model {
 
    protected $table = 'ci_todo_items';

    protected $primaryKey = 'todo_item_id';
    
	// get all fields of table
    protected $allowedFields = ['todo_item_id','company_id','user_id','description','is_done','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>