<?php
class Employees {
    private $pdo;
    
    function __construct($dbc) {

        //set db settings
        $type = $dbc['type'];
        $host = $dbc['host'];
        $db   = $dbc['db'];
        $user = $dbc['user'];
        $pass = $dbc['pass'];
        $charset = $dbc['charset'];

        //create dsn
        $dsn = "$type:host=$host;dbname=$db;charset=$charset";

        //set options
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            //PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        //connect to db
        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            $this->error($e);
        }

    }

    private function error($e) {
        echo "Error";
        //throw new \PDOException($e->getMessage(), (int)$e->getCode());
        echo $e->getMessage().$e->getCode();
        exit();
    }

    public function query($sql, $params = null) {
        return $this->run_sql($sql, $params = null);
    }

    public function insert($sql, $params = null) {
        return $this->query($sql, $params = null);
    }

    public function get_employees($last_name = null) {
        $params = array();

        //create sql
        $sql = "SELECT * 
                FROM employees \n";

        if ($last_name != null) {
            $params = array(':last_name' => $last_name);
            $sql .= "WHERE (last_name = :last_name)\n";
        }

        $sql .= "LIMIT 1, 10000";

        return $this->run_sql($sql, $params);
    }

    public function get_departments() {
        $params = array();

        //create sql
        $sql = "SELECT * 
                FROM departments \n";

        $sql .= "LIMIT 1, 10000";

        return $this->run_sql($sql, $params);
    }

    private function run_sql($sql, $params) {
        //run sql
        try {
            $prep = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $prep->execute($params);
        } catch (\PDOException $e) {
            $this->error($e);
        }

        return $prep->fetchAll();
    }

}