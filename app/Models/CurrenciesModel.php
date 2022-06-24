<?php
namespace App\Models;

use CodeIgniter\Model;
	
class CurrenciesModel extends Model {
 
    protected $table = 'ci_currencies';

    protected $primaryKey = 'currency_id';
    
	// get all fields of table
    protected $allowedFields = ['currency_id','country_name','currency_name','currency_code'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>