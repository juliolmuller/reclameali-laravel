<?php

namespace App\Models;

use App\Models\Traits\DefaultRelations;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

/**
 * Role Model
 *
 * @mixin \Eloquent
 *
 * Database table:
 * @table access_roles
 *
 * Database columns:
 * @property integer id                            required | unique
 * @property string name                           required | length: 1 to 10 | unique
 * @property string description                    nullable | length: 0 to 255
 * @property \Illuminate\Support\Carbon created_at nullable
 * @property integer created_by                    nullable | \App\Models\User::id
 * @property \Illuminate\Support\Carbon updated_at nullable
 * @property integer updated_by                    nullable | \App\Models\User::id
 *
 * Database relations:
 * @property \App\Models\User creator              BelongsTo (many-to-one)
 * @property \App\Models\User editor               BelongsTo (many-to-one)
 * @property \App\Models\Permission[] permissions  BelongsToMany (many-to-many)
 * @property \App\Models\User[] users              HasMany (one-to-many)
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
