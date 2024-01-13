<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasCreatedBy;
use App\Models\Traits\HasUpdatedBy;

class Employee extends Model
{
    use HasCreatedBy,
        HasUpdatedBy,
        HasFactory;

        public function company() {
            return $this->belongsTo(Company::class);
        }
}
