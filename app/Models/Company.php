<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasCreatedBy;
use App\Models\Traits\HasUpdatedBy;

class Company extends Model
{
    use HasCreatedBy,
        HasUpdatedBy,
        HasFactory;
    public static function getTableName() {
        return with(new static)->getTable();
    }
}
