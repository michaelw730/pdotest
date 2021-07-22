<?php
class Employees {
    private $pdo;
    
    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    private function error($e) {
        echo "Error";
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