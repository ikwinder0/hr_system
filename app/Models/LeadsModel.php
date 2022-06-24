<?php
namespace App\Models;

use CodeIgniter\Model;
	
class LeadsModel extends Model {
 
    protected $table = 'ci_leads';

    protected $primaryKey = 'lead_id';
    
	// get all fields of leads table
    protected $allowedFields = ['lead_id','company_id','first_name','last_name','email','profile_photo','contact_number','gender','address_1','address_2','city','state','zipcode','country','status','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>