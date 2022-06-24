<?php
namespace App\Models;

use CodeIgniter\Model;
	
class OfficialdocumentsModel extends Model {
 
    protected $table = 'ci_official_documents';

    protected $primaryKey = 'document_id';
    
	// get all fields of table
    protected $allowedFields = ['document_id','company_id','license_name','document_type','license_no','expiry_date','document_file','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>