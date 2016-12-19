<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    public $table = "users";

    protected $primaryKey = 'username';

    /**
     * To allow mass update you have to declare witch columns tou allow to update
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password'];

    /**
     * Lumen add custom column updated_at and when you insert or update new
     * row in database it pass and column updated_at. To not get sql error about
     * Column not fount updated_at add this var
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token'
    ];

    /**
     * @return array
     */
    public function getColumnList(){

        return Schema::getColumnListing($this->table);
    }
}