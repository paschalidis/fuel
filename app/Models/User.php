<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class User extends Model
{

    public $table = "users";

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
     * @return array
     */
    public function getColumnList(){

        return Schema::getColumnListing($this->table);
    }
}