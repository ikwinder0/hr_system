<?php
namespace App\Models;

use CodeIgniter\Model;
	
class InvoiceitemsModel extends Model {
 
    protected $table = 'ci_invoices_items';

    protected $primaryKey = 'invoice_item_id';
    
	// get all fields of table
    protected $allowedFields = ['invoice_item_id','invoice_id','project_id','item_name','item_qty','item_unit_price','item_sub_total','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>