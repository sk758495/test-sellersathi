<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerAdminBankDetail extends Model
{
    // Define the table (if necessary)
    protected $table = 'seller_admin_bank_details';

    // Allow mass assignment for these fields
    protected $fillable = [
        'seller_admin_id',
        'account_name',
        'account_number',
        'ifsc_code',
        'bank_name',
        'branch_name',
        'upi_id',  // UPI ID field
        'phone',
       ];

       public function sellerAdmin()
       {
           return $this->belongsTo(SellerAdmin::class);  // Adjust if necessary
       }
}
