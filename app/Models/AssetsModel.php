<?php
namespace App\Models;

use CodeIgniter\Model;
	
class AssetsModel extends Model {
 
    protected $table = 'ci_assets';

    protected $primaryKey = 'assets_id';
    
	// get all fields of assets table
    protected $allowedFields = ['assets_id','assets_category_id','brand_id','company_id','employee_id','company_asset_code','name','purchase_date','invoice_number','manufacturer','serial_number','warranty_end_date','asset_note','asset_image','is_working','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>