<?php

// app/Models/GasStation.php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

final class GasStation extends Model
{

    public $table = "gasstations";

    /**
     * @return array
     */
    public function getColumnList(){

        return Schema::getColumnListing($this->table);
    }
}