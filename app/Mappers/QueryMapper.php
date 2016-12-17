<?php

namespace app\Mappers;


class QueryMapper
{
    /**
     * Database table name
     * @var $_tableName
     */
    protected $_tableName;

    /**
     * Request Parameters
     * @var $_parameters
     */
    protected $_parameters;
    public function __construct(array $parameters, $tableName)
    {
        $this->_parameters = $this->unsetDefaultParameters($parameters);
        $this->_tableName = $tableName;
    }

    public function get()
    {
        $results = \DB::select("SELECT * FROM users");

        return $results;
    }

    protected function unsetDefaultParameters(array $parameters)
    {
        $defaultParameters = json_decode($_ENV['parameters'], true);

        foreach ($defaultParameters as $key => $field){
            unset($parameters[$key]);
        }

        return $parameters;
    }
}