<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    

    /**
     * The table associated with the model
     * Explicitly define the table name in the MySQL Database
     * 
     * @var string
     */
    protected $table =  'companies';

    /**
     * The attributes that are mass assignable.
     * Define which fields are allowed to be filled via mass assignment.
     *
     * @var array <int, string>
     */
    protected $fillable = [
        'company_code',  // Unique code for warehouse/branch
        'name',          // Fullname of the branch
        'phone',         // Contact telephone for the branch
        'address',       // Address for the branch
        'manager_name',  // Manager name for the branch
        'logo_path',     // Storage path for the company logo image
        'is_active',     // Operational status flag      
    ];
    
    /**
     * The attributes that should be cast.
     * Automatically convert database values to specific PHP types when retrieved.
     * * @var array <string, string>
     */
    protected $casts = [
        'is_active' => 'boolean', // Convert tinyint(1) from MySQL
    ];
}
