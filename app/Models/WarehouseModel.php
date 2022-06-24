<?php
namespace App\Models;

use CodeIgniter\Model;
	
class WarehouseModel extends Model {
 
    protected $table = 'ci_stock_warehouses';

    protected $primaryKey = 'warehouse_id';
    
	// get all fields of table
    protected $allowedFields = ['warehouse_id','company_id','warehouse_name','contact_number','pickup_location','address_1','address_2','city','state','zipcode','country','added_by','status','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>