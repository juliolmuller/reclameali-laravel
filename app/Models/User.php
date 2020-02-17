<?php

namespace App\Models;

use App\Models\Traits\DefaultRelations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Wildside\Userstamps\Userstamps;
use Znck\Eloquent\Traits\BelongsToThrough;

/**
 * User Model
 *
 * @mixin \Eloquent
 *
 * Database table:
 * @table users
 *
 * Database columns:
 * @property integer id                              required | unique
 * @property string first_name                       required | length: 1 to 30
 * @property string last_name                        required | length: 1 to 150
 * @property string cpf                              required | length: 11
 * @property string email                            required | length: 1 to 255
 * @property string phone                            nullable | length: 0 to 16
 * @property \Illuminate\Support\Carbo date_of_birth required
 * @property string street                           nullable | length: 0 to 255
 * @property integer number                          nullable | unsigned
 * @property string complement                       nullable | length: 0 to 20
 * @property string zip_code                         nullable | length: 8
 * @property integer city_id                         nullable | \App\Models\City::id
 * @property integer role_id                         required | \App\Models\Role::id
 * @property string password                         required | length: 60
 * @property string remember_token                   required | length: 100
 * @property \Illuminate\Support\Carbon created_at   nullable
 * @property integer created_by                      nullable | \App\Models\User::id
 * @property \Illuminate\Support\Carbon updated_at   nullable
 * @property integer updated_by                      nullable | \App\Models\User::id
 * @property \Illuminate\Support\Carbon deleted_at   nullable
 * @property integer deleted_by                      nullable | \App\Models\User::id
 *
 * Database relations:
 * @property \App\Models\Role role                   BelongsTo (many-to-one)
 * @property \App\Models\City city                   BelongsTo (many-to-one)
 * @property \App\Models\State state                 BelongsToThrough (many-to-one)
 * @property \App\Models\User creator                BelongsTo (many-to-one)
 * @property \App\Models\User editor                 BelongsTo (many-to-one)
 * @property \App\Models\User destroyer              BelongsTo (many-to-one)
 * @property \App\Models\Ticket[] tickets            HasMany (one-to-many)
 */
class User extends Authenticatable
{
    use BelongsToThrough,
        DefaultRelations,
        Notifiable,
        SoftDeletes,
        Userstamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'cpf', 'date_of_birth', 'email', 'phone', 'password', 'role_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Number of users per page (on pagination)
     *
     * @var int
     */
    protected $perPage = 30;

    /**
     * Relations to be eager loaded on 'withDefault' and 'loadDefault' calls
     *
     * @var array
     */
    protected const RELATIONS = ['role', 'city', 'state', 'creator', 'editor', 'destroyer'];

    /**
     * Get the role associated with $this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Get the city associated with $this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the state associated with $this user
     *
     * @return \Znck\Eloquent\Relations\BelongsToThrough
     */
    public function state()
    {
        return $this->belongsToThrough(State::class, City::class);
    }

    /**
     * Get the tickets associated with $this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'created_by')->orderByDesc('created_at');
    }

    /**
     * Returns an array of hyperlinks for the navigation bar
     *
     * @return array
     */
    public function getNavigationLinks()
    {
        $links = [[
            'route' => 'home',
            'label' => 'Home',
        ]];

        switch ($this->role_id) {
            case 1:
                return array_merge($links, [
                    ['route' => 'page.tickets',     'label' => 'Atendimentos'],
                    ['route' => 'page.manage_data', 'label' => 'Meus Dados'],
                ]);

            case 2:
                return array_merge($links, [
                    ['route' => 'page.tickets',     'label' => 'Atendimentos'],
                    ['route' => 'page.categories',  'label' => 'Categorias'],
                    ['route' => 'page.products',    'label' => 'Produtos'],
                    ['route' => 'page.manage_data', 'label' => 'Meus Dados'],
                ]);

            case 3:
                return array_merge($links, [
                    ['route' => 'page.tickets',         'label' => 'Atendimentos'],
                    ['route' => 'page.ticket_options', 'label' => 'Gerenciar Opções'],
                    ['route' => 'page.users',           'label' => 'Usuários'],
                ]);

            case 4:
                return array_merge($links, [
                    ['route' => 'page.users',       'label' => 'Usuários'],
                    ['route' => 'page.roles',       'label' => 'Perfis de Acesso'],
                    ['route' => 'page.permissions', 'label' => 'Permissões'],
                ]);

            default:
                return $links;
        }
    }
}
