<?php

namespace app\Mappers;

use Illuminate\Support\Facades\Schema;
use DB;

class QueryMapper
{
    /**
     * Database table name
     * @var String $_tableName
     */
    protected $_tableName;

    /**
     * Request Parameters
     * @var $_parameters
     */
    protected $_parameters;

    /**
     * The sql query
     * @var String $sql;
     */
    protected $_sql;

    /**
     * The columns to select
     * @var string $_columns
     */
    protected $_columns;

    public function __construct(array $parameters, $tableName)
    {
        $this->_columns = '*';
        $this->_parameters = $parameters;
        $this->_tableName = $tableName;
    }

    public function get()
    {
        $this->prepareColumns($this->_parameters);

        $sql = "SELECT " . $this->_columns . " FROM " . $this->_tableName;

        return DB::select($sql);
    }

    protected function unsetDefaultParameters(array $parameters)
    {
        $defaultParameters = explode(",", $_ENV['parameters']);

        foreach ($defaultParameters as $key => $field){
            unset($parameters[$key]);
        }

        return $parameters;
    }

    /**
     * Prepare columns for select statement
     * @param array $parameters
     */
    protected function prepareColumns($parameters){

        if(!isset($parameters['fields'])){
            return;
        }

        $fields = $parameters['fields'];

        if(strcasecmp($fields, '*') == 0){
            return;
        }

        $this->_columns = $fields;
    }
}