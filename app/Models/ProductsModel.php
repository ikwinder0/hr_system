<?php
namespace App\Models;

use CodeIgniter\Model;
	
class ProductsModel extends Model {
 
    protected $table = 'ci_stock_products';

    protected $primaryKey = 'product_id';
    
	// get all fields of table
    protected $allowedFields = ['product_id','company_id','product_name','product_qty','reorder_stock','barcode','barcode_type','warehouse_id','category_id','product_sku','product_serial_number','purchase_price','retail_price','expiration_date','product_image','product_description','product_rating','added_by','created_at','status'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>