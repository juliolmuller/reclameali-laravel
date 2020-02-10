<?php

namespace App\Models;

use App\Models\Traits\DefaultRelations;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

/**
 * Product Model
 *   Table:
 *     products
 *   Attributes:
 *     id:          required | integer | unique
 *     name:        nullable | string(0-50) | unique
 *     controller:  required | string(1-255) | unique(controller, method)
 *     method:      required | string(1-100) | unique(controller, method)
 *     created_at:  nullable | timestamp
 *     created_by:  nullable | \App\Models\User::id (integer)
 *     updated_at:  nullable | timestamp
 *     updated_by:  nullable | \App\Models\User::id (integer)
 *   Relationships:
 *     roles:   \App\Models\Role[] (BelongsToMany)
 *     creator: \App\Models\User (BelongsTo)
 *     editor:  \App\Models\User (BelongsTo)
 *
 * @mixin \Eloquent
 */

class Permission extends Model
{
    use DefaultRelations,
        Userstamps;

    /**
     * Get the roles associated with $this permission
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role')
            ->orderBy('name');
    }
}
