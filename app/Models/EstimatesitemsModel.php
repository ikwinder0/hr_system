<?php
namespace App\Models;

use CodeIgniter\Model;
	
class EstimatesitemsModel extends Model {
 
    protected $table = 'ci_estimates_items';

    protected $primaryKey = 'estimate_item_id';
    
	// get all fields of table
    protected $allowedFields = ['estimate_item_id','estimate_id','project_id','item_name','item_qty','item_unit_price','item_sub_total','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>