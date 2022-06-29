<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Websites extends Model 
{
    protected $table = "websites";
    
    protected $fillable = [
        'name', 'description', 'status'
    ];
}
