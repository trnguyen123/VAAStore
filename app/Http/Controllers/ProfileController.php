<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function showProfilePage()
    {
        return view('pages.show_profile');
    }

    public function showProfile(Request $request)
    {
        $customer_id = $request->input('customer_id');

        if (!$customer_id) {
            return response()->json(['success' => false, 'message' => 'Customer ID is missing'], 400);
        }

        $customer = Customer::where('customer_id', $customer_id)->first();

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        return response()->json([
            'success' => true,
            'customer' => [
                'customer_id' => $customer->customer_id,
                'full_name' => $customer->full_name,
                'email' => $customer->email,
                'phone_number' => $customer->phone_number,
                'address' => $customer->address,
                'gender' => $customer->gender,
                'date_of_birth' => $customer->date_of_birth,
            ],
        ]);
    }
    public function showEditProfilePage()
    {
        return view('pages.edit_profile');
    }

    public function editProfilePage(Request $request)
    {
        $customer_id = $request->input('customer_id');

        if (!$customer_id) {
            return response()->json(['success' => false, 'message' => 'Customer ID is missing'], 400);
        }

        $customer = Customer::where('customer_id', $customer_id)->first();

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        return response()->json([
            'success' => true,
            'customer' => [
                'customer_id' => $customer->customer_id,
                'full_name' => $customer->full_name,
                'email' => $customer->email,
                'phone_number' => $customer->phone_number,
                'address' => $customer->address,
                'gender' => $customer->gender,
                'date_of_birth' => $customer->date_of_birth,
            ],
        ]);
    }

public function updateProfile(Request $request)
    {
        $customer_id = $request->input('customer_id');
        
        if (!$customer_id) {
            return response()->json(['success' => false, 'message' => 'Customer ID is missing'], 400);
        }

        $customer = Customer::where('customer_id', $customer_id)->first();

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        // Cập nhật các trường thông tin
        $customer->full_name = $request->input('full_name');
        $customer->email = $request->input('email');
        $customer->phone_number = $request->input('phone_number');
        $customer->address = $request->input('address');
        $customer->gender = $request->input('gender');
        $customer->date_of_birth = $request->input('date_of_birth');
        
        $customer->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'customer' => $customer
        ]);
    }

}
