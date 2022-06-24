<?php
namespace App\Models;

use CodeIgniter\Model;
	
class DocumentsModel extends Model {
 
    protected $table = 'ci_system_documents';

    protected $primaryKey = 'document_id';
    
	// get all fields of table
    protected $allowedFields = ['document_id','company_id','department_id','document_name','document_type','document_file','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>