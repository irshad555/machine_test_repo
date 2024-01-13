<?php

namespace App\Models\Traits;

use App\Models\User;

trait HasCreatedBy {
    
    /**
     * createdBy
     *
     * @return void
     */
    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

}
