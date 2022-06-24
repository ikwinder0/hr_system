<?php
namespace App\Models;

use CodeIgniter\Model;
	
class CountryModel extends Model {
 
    protected $table = 'ci_countries';

    protected $primaryKey = 'country_id';
    
	// get all fields of table
    protected $allowedFields = ['country_id','country_code','country_name'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>