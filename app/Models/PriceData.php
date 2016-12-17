<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class PriceData extends Model
{
    public $table = "pricedata";

    /**
     * @return array
     */
    public function getColumnList(){

        return Schema::getColumnListing($this->table);
    }
}