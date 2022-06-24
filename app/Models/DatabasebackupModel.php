<?php
namespace App\Models;

use CodeIgniter\Model;
	
class DatabasebackupModel extends Model {
 
    protected $table = 'ci_database_backup';

    protected $primaryKey = 'backup_id';
    
	// get all fields of table
    protected $allowedFields = ['backup_id','backup_file','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>