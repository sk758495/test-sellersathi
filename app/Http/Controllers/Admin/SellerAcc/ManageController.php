<?php

namespace App\Http\Controllers\Admin\SellerAcc;

use App\Http\Controllers\Controller;
use App\Models\SellerAdmin;
use Illuminate\Http\Request;

class ManageController extends Controller
{
    // Display a listing of seller admins
    public function index()
    {
        // Fetch all seller admin accounts from the database
        $sellerAdmins = SellerAdmin::all();

        // Return the view with seller admins data
        return view('admin.seller_admins.index', compact('sellerAdmins'));
    }

    public function destroy($id)
    {
        $sellerAdmin = SellerAdmin::findOrFail($id);
        $sellerAdmin->delete();
    
        return redirect()->route('admin-seller-index')->with('success', 'Seller Admin deleted successfully.');
    }

}
