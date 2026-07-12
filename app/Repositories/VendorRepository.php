<?php

namespace App\Repositories;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorRepository
{
    public function vendor_list(Request $request)
    {
        $query = Vendor::query();

        // Filter by user if is_admin and user filter is set
        if (isset($request->is_admin) && $request->is_admin == 1 && $request->user) {
            $query->where('created_by', $request->user);
        }
        
        // Filter by status if provided
        if (isset($request->status) && $request->status != '') {
            $query->where('status', $request->status);
        }

        return $query->get();
    }

    public function findVendorById($id)
    {
        return Vendor::findOrFail($id);
    }

    public function updateVendor(Vendor $vendor, array $data)
    {
        return $vendor->update($data);
    }

    public function deleteVendor($id)
    {
        $vendor = $this->findVendorById($id);
        return $vendor->delete();
    }
}