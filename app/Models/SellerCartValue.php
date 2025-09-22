<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerCartValue extends Model
{
      // The table associated with the model
      protected $table = 'seller_cart_values';

      // The attributes that are mass assignable
      protected $fillable = [
          'user_id',
          'seller_admin_id',
          'address_id',
          'subtotal',
          'shipping_charge',
          'total',
          'products'
      ];

      // Casting the 'products' attribute to an array (since it's stored as JSON)
      protected $casts = [
          'products' => 'array', // Converts the JSON field 'products' to an array
      ];

      // Defining relationships

      /**
       * Get the user associated with the cart value.
       */
      public function user()
      {
          return $this->belongsTo(User::class);
      }

      /**
       * Get the seller admin associated with the cart value.
       */
      public function sellerAdmin()
      {
          return $this->belongsTo(SellerAdmin::class);
      }

      /**
       * Get the address associated with the cart value.
       */
      public function address()
      {
          return $this->belongsTo(Address::class);
      }

      /**
       * Get the products in the cart (though stored as JSON, you can define how to retrieve it).
       */
      public function getProductsAttribute($value)
      {
          return json_decode($value, true); // Assuming the products are stored in JSON format
      }

      /**
       * Set the products attribute (encode array to JSON before saving).
       */
      public function setProductsAttribute($value)
      {
          $this->attributes['products'] = json_encode($value);
      }
}
