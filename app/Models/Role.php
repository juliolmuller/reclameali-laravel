<?php

namespace App\Models;

use App\Models\Traits\DefaultRelations;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

/**
 * Role Model
 *   Table:
 *     access_roles
 *   Attributes:
 *     id:          required | integer | unique
 *     name:        required | string(1-10) | unique
 *     description: nullable | string(0-255)
 *     created_at:  nullable | timestamp
 *     created_by:  nullable | \App\Models\User::id (integer)
 *     updated_at:  nullable | timestamp
 *     updated_by:  nullable | \App\Models\User::id (integer)
 *   Relationships:
 *     permissions: \App\Models\Permission[] (BelongsToMany)
 *     creator:     \App\Models\User (BelongsTo)
 *     editor:      \App\Models\User (BelongsTo)
 *     users:       \App\Models\User[] (HasMany)
 *
 * @mixin \Eloquent
 */
class Role extends Model
{
    use DefaultRelations,
        Userstamps;

    /**
     * Table associated with the model
     *
     * @var string
     */
    protected $table = 'access_roles';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Serializable attributes
     *
     * @var array
     */
    protected $visible = ['id', 'name'];

    /**
     * Number of roles per page (on pagination)
     *
     * @var int
     */
    protected $perPage = 30;

    /**
     * Relations to be eager loaded on 'withDefault' and 'loadDefault' calls
     *
     * @var array
     */
    protected const RELATIONS = ['creator', 'editor'];

    /**
     * Get the users associated with $this role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class)->orderBy('email');
    }

    /**
     * Get the permissions associated with $this role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role')
            ->orderBy('controller')
            ->orderBy('method');
    }
}
