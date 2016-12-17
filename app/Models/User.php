<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class User extends Model
{

    public $table = "users";

    /**
     * @return array
     */
    public function getColumnList(){

        return Schema::getColumnListing($this->table);
    }
}