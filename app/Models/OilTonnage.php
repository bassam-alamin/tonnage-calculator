<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OilTonnage extends Model
{
protected $fillable = ['volume', 'density', 'temperature', 'vcf', 'tonnage'];

}
