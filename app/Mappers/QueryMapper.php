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
     * The columns to select
     * @var String $_columns
     */
    protected $_columns;

    /**
     * The where clause
     * @var String $_whereStatement
     */
    protected $_whereStatement;

    /**
     * @var String $_LIMIT
     */
    protected $_LIMIT;

    /**
     * @var String $_OFFSET
     */
    protected $_OFFSET;

    public function __construct(array $parameters, $tableName)
    {
        $this->_columns = '*';
        $this->_whereStatement = "";
        $this->_OFFSET = "";
        $this->_LIMIT = "";
        $this->_parameters = $parameters;
        $this->_tableName = $tableName;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        $this->prepareColumns($this->_parameters);

        $sql = "SELECT " . $this->_columns . " FROM " . $this->_tableName;

        $this->prepareLimitOffset($this->_parameters);

        $this->prepareWhere($this->_parameters);

        $sql .= $this->_whereStatement;

        $sql .= $this->_LIMIT;
        $sql .= $this->_OFFSET;

        return DB::select($sql);
    }

    /**
     * Prepare columns for select statement
     * @param array $parameters
     */
    protected function prepareColumns(&$parameters){

        if(!isset($parameters['fields'])){
            return;
        }

        $fields = $parameters['fields'];

        if(strcasecmp($fields, '*') == 0){
            return;
        }

        unset($parameters['fields']);

        $this->_columns = $fields;
    }

    protected function prepareWhere(&$parameters){

        if(empty($parameters)){
            return;
        }

        $arrayKeys = array_keys($parameters);

        $where = " WHERE " . $arrayKeys[0] . " = " . $parameters[$arrayKeys[0]];
        unset($parameters[$arrayKeys[0]]);

        foreach ($parameters as $key => $value){
            $where .= ' AND ' . $key . ' = ' . $value;
            unset($parameters[$key]);
        }

        $this->_whereStatement = $where;
    }

    protected function prepareLimitOffset(&$parameters){

        if(empty($parameters)){
            return;
        }

        if(isset($parameters['limit'])){
            $this->_LIMIT = ' LIMIT ' . $parameters['limit'];
            unset($parameters['limit']);
        }

        if(isset($parameters['offset'])){
            $this->_OFFSET = ' OFFSET ' . $parameters['offset'];
            unset($parameters['offset']);
        }
    }
}