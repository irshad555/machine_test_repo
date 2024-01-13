<?php

namespace App\Models\Traits;

use App\Models\User;

trait HasUpdatedBy {
    
    /**
     * updatedBy
     *
     * @return void
     */
    public function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
