<?php
namespace App\Models;

use CodeIgniter\Model;
	
class SuppliersModel extends Model {
 
    protected $table = 'ci_stock_suppliers';

    protected $primaryKey = 'supplier_id';
    
	// get all fields of table
    protected $allowedFields = ['supplier_id','company_id','supplier_name','registration_no','email','contact_number','website_url','address_1','address_2','city','state','zipcode','country','added_by','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>