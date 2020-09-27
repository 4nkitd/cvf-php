<?php

/* 
    * @author     : 4nkitd@github
    * @authorName : Ankit
*/

class Database extends cvf
{
    private $conn;

    function __construct()
    {
        $host = $this->env('database.host');
        $name = $this->env('database.name');
        $user = $this->env('database.user');
        $pass = $this->env('database.pass');
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$name", $user, $pass);
            
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        }
        catch(PDOException $e) 
        {
            throw new Exception($e->getMessage(), 1);
            
        }
    }

    public function insert(string $table, array $keys, array $values, bool $batch = false)
    {   
        $sql = 'INSERT INTO '. $table .' ( ';
        $sqlValues = ' VALUES ( ';
        $totalLeys = count($keys);
        $keyCount = 1;
        foreach ($keys as $key) {
            $sql .= $key;
            $sqlValues .= ':'.$key;
            
            if($keyCount == $totalLeys) {
                $sql .= ' ) ';
                $sqlValues .= ' ) ';
            } else {
                $sql .= ', ';
                $sqlValues .= ', ';
            } 
            
            ++$keyCount;
        }

        $sql .= $sqlValues .';';

        $dbvalues = array();
        if($batch == false){
            
            if(count($keys) == count($values)){
                for ($i=0; $i < $totalLeys; $i++) { 
                    
                    $dbvalues[$keys[$i]] = $values[$i];
                }
            } else {
                throw new Exception("Keys ANd Values Don't Match");
                
            }
            
        } else {


        }

        $statement = $this->conn->prepare($sql);

        $statement->execute($dbvalues);
    }

    public function select(string $table, array $keys = array('*'), array $where = array(),$extra = '', string $join = '')
    {

        $sql = 'SELECT   ';
        $totalKeys = count($keys);
        $keyCount = 1;
        foreach ($keys as $key) {
            $sql .= $key;
            
            if($keyCount == $totalKeys) {
                $sql .= '  ';
            } else {
                $sql .= ', ';
            } 
            
            ++$keyCount;
        }

        $sql .= ' FROM '.$table;

        if(!empty($join)){
            $sql .= ' '.$join;
        }

        $totalWhere = count($where);

        if($totalWhere >= 1){
            $sql .= ' WHERE ';
            $whereCount = 1;
            foreach ($where as $key) {
                $sql .= $key;
                
                if($whereCount == $totalWhere) {
                    $sql .= '  ';
                } else {
                    $sql .= ' AND ';
                } 
                
                ++$whereCount;
            }
        }
        

        $sql .= $extra.' ;';

        $statement = $this->conn->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function delete(string $table,array $where = array(),$extra = '')
    {
        $sql = 'DELETE FROM '.$table;

        $totalWhere = count($where);

        if($totalWhere >= 1){
            $sql .= ' WHERE ';
            $whereCount = 1;
            foreach ($where as $key) {
                $sql .= $key;
                
                if($whereCount == $totalWhere) {
                    $sql .= '  ';
                } else {
                    $sql .= ' AND ';
                } 
                
                ++$whereCount;
            }
        }
        

        $sql .= $extra.' ;';


        $statement = $this->conn->prepare($sql);

        return $statement->execute();
    }

    public function update(string $table, array $keys , array $where = array(),$extra = '')
    {

        $sql = 'UPDATE '.$table.' SET ';
        $totalKeys = count($keys);
        $keyCount = 1;
        foreach ($keys as $key) {
            $sql .= $key;
            
            if($keyCount == $totalKeys) {
                $sql .= '  ';
            } else {
                $sql .= ', ';
            } 
            
            ++$keyCount;
        }


        $totalWhere = count($where);

        if($totalWhere >= 1){
            $sql .= ' WHERE ';
            $whereCount = 1;
            foreach ($where as $key) {
                $sql .= $key;
                
                if($whereCount == $totalWhere) {
                    $sql .= '  ';
                } else {
                    $sql .= ' AND ';
                } 
                
                ++$whereCount;
            }
        }
        

         $sql .= $extra.' ;';

        $statement = $this->conn->prepare($sql);

        return $statement->execute();
        
    }

}