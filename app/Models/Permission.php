<?php

namespace App\Models;

use App\Models\Traits\DefaultRelations;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

/**
 * Product Model
 *
 * @mixin \Eloquent
 *
 * Database table:
 * @table permissions
 *
 * Database columns:
 * @property integer id                            required | unique
 * @property string name                           nullable | length: 0 to 50 | unique
 * @property string controller                     required | length: 1 to 255 | unique(controller, method)
 * @property string method                         required | length: 1 to 100 | unique(controller, method)
 * @property \Illuminate\Support\Carbon created_at nullable
 * @property integer created_by                    nullable | \App\Models\User::id
 * @property \Illuminate\Support\Carbon updated_at nullable
 * @property integer updated_by                    nullable | \App\Models\User::id
 *
 * Database relations:
 * @property \App\Models\User creator              BelongsTo (many-to-one)
 * @property \App\Models\User editor               BelongsTo (many-to-one)
 * @property \App\Models\Role[] roles              BelongsToMany (many-to-many)
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
