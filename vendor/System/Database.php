<?php

namespace System;

use PDO;
use PDOException;

class Database
{
    /**
    * Application object
    *
    * @var \System\Application
    */
    private $app;

    /**
    * PDO Connection
    *
    * @var \PDO
    */
    private static $connection;

    /**
    * Table Name
    *
    * @var string
    */
    private $table;

    /**
    * Data Container
    *
    * @var array
    */
    private $data = [];

    /**
    * Bindings Container
    *
    * @var array
    */
    private $bindings = [];

    /**
    * Last Insert id
    *
    * @var int
    */
    private $lastId;

    /**
    * Wheres
    *
    * @var array
    */
    private $wheres = [];

    /**
    * Selects
    *
    * @var array
    */
    private $selects = [];

    /**
    * Joins
    *
    * @var array
    */
    private $joins = [];

    /**
    * Limit
    *
    * @var int
    */
    private $limit;

    /**
    * Offset
    *
    * @var int
    */
    private $offset;

    /**
    * Total Rows
    *
    * @var int
    */
    private $rows = 0;

    /**
    * Order By
    *
    * @var array
    */
    private $orderBy = [];

    /**
    * Constructor
    * @param \System\Application $app
    */
    public function __construct(Application $app)
    {
        $this->app = $app;

        if (! $this->isConnected()) {
            $this->connect();
        }
    }

    /**
    * Determiane If There is Any connectio to Database
    *
    * @return boolean
    */
    private function isConnected()
    {
        // Check if the  "[ static::$connection ]" is instanceof PDO Class Or Not
        return static::$connection instanceof PDO;
    }

    /**
    * Connect to Database
    *
    * @return void
    */
    private function connect()
    {
        $connectionData = $this->app->file->call('config.php');
        // extract all the array keys to be an variables
        extract($connectionData);

        try {
            static::$connection = new PDO($driver . ':host=' . $server . ';dbname=' . $db_name, $db_user_name, $db_user_password);

            static::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            static::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            static::$connection->exec('SET NAMES utf8');

        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    /**
    * Get Database Connection Object PDO Object
    *
    * @return \PDO
    */
    public function connection()
    {
        return static::$connection;
    }

    /**
    * Set select clause
    *
    * @param string $select
    * @return $this
    */
    public function select($select)
    {
        $this->selects[] = $select;

        return $this;
    }

    /**
    * Join clause
    *
    * @param string $join
    * @return $this
    */
    public function join($join)
    {
        $this->joins[] = $join;

        return $this;
    }

    /**
    * orderBy clause
    *
    * @param string $column
    * @param string $sort
    * @return $this
    */
    public function orderBy($column, $sort = 'ASC')
    {
        $this->orderBy = [$column, $sort];

        return $this;
    }

    /**
    * Set Limit clause
    *
    * @param int $limit
    * @return $this
    */
    public function limit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
    * Set Offset clause
    *
    * @param int $offset
    * @return $this
    */
    public function offset($offset = 0)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
    * Fetch Table
    * Thus Will return Only One Record
    *
    * @param string $table
    * @return \stdClass|null
    */
    public function first($table = null)
    {
        if ($table) {
            $this->table = $table;
        }


        $result = $this->setFetchStyle()->fetch();

        $this->resetAll();

        return $result;
    }

    /**
    * Fetch All Records From The Table
    *
    * @param string $table
    * @return Array
    */
    public function get($table = null)
    {
        if ($table) {
            $this->table = $table;
        }

        $query = $this->setFetchStyle();

        $this->rows = $query->rowCount();

        $results = $query->fetchAll();

        $this->resetAll();

        return $results;
    }

    /**
    * Get Total Rows From Last FEtch All Stetment
    *
    * @return int
    */
   public function rowsCount()
   {
       return $this->rows;
   }

    /**
    * Set Fetch and Fetch All style
    *
    * @param string $table
    * @return Array
    */
    private function setFetchStyle()
    {
        $sql = $this->fetchStatments();

        return $this->query($sql, $this->bindings);
    }

    /**
    * Delete Clause
    *
    * @param $table
    * @return $this
    */
    public function delete($table = null)
    {
        if ($table) {
            $this->table = $table;
        }

        $sql = 'DELETE FROM ' . $this->table . ' ';

        $sql .= $this->setFields();

        $this->query($sql, $this->bindings);

        $this->resetAll();

        return $this;
    }



    /**
    * Prepare Select Statement
    *
    * @return string
    */
    private function fetchStatments()
    {
        $sql = 'SELECT ';

        if ($this->selects) {
            $sql .= implode(', ', $this->selects);
        } else {
            $sql .= '*';
        }

        $sql .= ' FROM ' . $this->table . ' ';


        if ($this->joins) {
            $sql .= implode(' ', $this->joins);
        }

        if ($this->wheres) {
            $sql .= ' WHERE ' . implode(' ', $this->wheres);
        }

        if ($this->orderBy) {
            $sql .= ' ORDER BY ' . implode(' ', $this->orderBy) ;
        }

        if ($this->limit) {
            $sql .= ' LIMIT ' . $this->limit;
        }

        if ($this->offset) {
            $sql .= ' OFFSET ' . $this->offset ;
        }



        return $sql;
    }


    /**
    * Set The Table Name
    *
    * @param string $table
    * @return $this
    */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
    * Set The Table Name
    *
    * @param string $table
    * @return $this
    */
    public function from($table)
    {
        return $this->table($table);
    }

    /**
    * Set The Data That Will Be Stored in Database Table
    *
    * @param mixed $key
    * @param mixed $value
    * @return $this
    */
    public function data($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
            $this->addToBindings($key);
        } else {
            $this->data[$key] = $value;
        }
        return $this;
    }

    /**
    * Insert Data To Database
    *
    * @param $table
    * @return $this
    */
    public function insert($table = null)
    {
        if ($table) {
            $this->table = $table;
        }

        $sql = 'INSERT INTO ' . $this->table . ' SET ';

        $sql .= $this->setFields();

        $this->query($sql, $this->bindings);

        $this->lastId = static::$connection->lastInsertId();

        $this->resetAll();

        return $this;
    }

    /**
    * Update Data in Database
    *
    * @param $table
    * @return $this
    */
    public function update($table = null)
    {
        if ($table) {
            $this->table = $table;
        }

        $sql = 'UPDATE ' . $this->table . ' SET ';

        $sql .= $this->setFields();

        $this->query($sql, $this->bindings);

        $this->resetAll();

        return $this;
    }

    /**
    * Set Fields For Insert And UPDATE
    *
    * @return string
    */
    private function setFields()
    {
        $sql = '';

        foreach (array_keys($this->data) as $key) {
            $sql .= '`' . $key . '` = ? , ';
        }

        // remove the last "[ Comma ]"
        $sql = rtrim($sql, ', ');

        if ($this->wheres) {
            foreach ($this->wheres as $key => $value) {
                if ($key == 0) {
                    $sql .= ' WHERE ' . $value;
                } else {
                    $sql .= ' AND ' . $value;
                }
            }
        }
        return $sql;
    }

    /**
    * Add New Where Clause
    *
    * @return $this
    */
    public function where(...$bindings)
    {
        $sql = array_shift($bindings);

        $this->addToBindings($bindings);

        $this->wheres[] = $sql;
        return $this;
    }

    /**
    * Excute the Given Sql Statement
    *
    * NOTE "[ ...$bindings ]" === $bindings = func_get_args();
    * @return \PDOStatement
    */
    public function query(...$bindings)
    {
        $sql = array_shift($bindings);

        if (count($bindings) == 1 && is_array($bindings[0])) {
            $bindings = $bindings[0];
        }

        try {
            //   $query = $this->connection()->prepare($sql);
            $query = static::$connection->prepare($sql);

            foreach ($bindings as $key => $value) {
                $query->bindValue($key + 1, __e($value));
            }

            $query->execute();

        } catch (PDOException $e) {
            die($e->getMessage());
        }


        return $query;
    }

    /**
    * Get Last Insert Id
    *
    * @return int
    */
    public function lastId()
    {
        return $this->lastId;
    }

    /**
    * Add Given Value To Bindings
    *
    * @param mixed $value
    * @return void
    */
    private function addToBindings($value)
    {
        // use array_values becuse the PDO::bindValue Work With indexed array not associtive
        if (is_array($value)) {
            $this->bindings = array_merge($this->bindings, array_values($value));
        } else {
            $this->bindings[] = $value;
        }
    }

    /**
    * Reset All Data
    *
    * @return void
    */
   private function resetAll() {
        $this->rows         = 0;
        $this->limit        = null;
        $this->offset       = null;
        $this->table        = null;
        $this->bindings     = [];
        $this->data         = [];
        $this->selects      = [];
        $this->joins        = [];
        $this->wheres       = [];
        $this->orderBy      = [];
   }
}
