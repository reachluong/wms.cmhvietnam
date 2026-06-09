<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the companies.
     * Fetch all wood warehouse branches to display con the React frontend grid
     * 
     * @return Illiminate\Http\JsonResponce
     */
    public function index()
    {
        $companies = Company::all();

        return response()->json([
            'success' => true,
            'data' => $companies
        ], 200);
    }


    /**
     * Store a newly created company in storage.
     * Validate and save a new warehouse branch from the configuration from.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // 1. Execute strict data validation to protect system integrity

        $validated = $request->validate([
            'company_code' => 'required|string|unique:companies,company_code',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'manager_name' => 'nullable|string',
        ],[
            // Overridding the default message
            'company_code.unique' => 'This branch code already exists in the system !'
        ]);
        try {
            $company = Company::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Company branch created successfully!',
                'data' => $company
            ], 201);
        } catch (\Exception $e) {

        // Log the error for debugging
            Log::error('Add Branch Failure: ' . $e->getMessage());
        // Return Error
            return response()->json([
                'success' => false,
                'message' => 'Internal server error occurred!'
            ], 500);
        }
        

        
    } 

    /**
     * Display the specified company.
     * Retrieve detailed information of a scpecific branch by its ID.
     * 
     * @param string $id
     * @return \\Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'Company branch not found!'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $company
        ], 200);
    }

    /**
     * Update the specified company in storage.
     * Validate and update the warehouse branch details on edit.
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'Company branch not found for update!'
            ], 404);
        }

        $validated = $request->validated([
            'company_code' => 'required|string|unique:companies,company_code,' .$id,
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'manager_name' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        $company->update($validated);
        return response()->json([
            'success' => true,
            'message' => 'Company branch updated successfully!',
            'data' => $company
        ], 200);
    }

    /**
     * Remove the specified company from storage.
     * Delete a warehouse branch from the system.
     * 
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $company = Company::find($id);

        if(!$company) {
            return response()->json([
                'success' => false,
                'message' => 'Company branch not found for deletion'
            ], 404);
        }

        $company->delete();
        return response()->json([
            'success' => true,
            'message' => 'Company branch deleted successfully!'
        ], 200);
    }
}
