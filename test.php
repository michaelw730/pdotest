<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbc = json_decode(file_get_contents("db.conf.json"));

//set options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    //PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

include_once("employees.php");

//connect to db
$dsn = "$dbc->type:host=$dbc->host;dbname=$dbc->db;charset=$dbc->charset";
try {
    $pdo = new PDO($dsn, $dbc->user, $dbc->pass, $options);
} catch (\PDOException $e) {
    die("db connect error");
}

$emp = new Employees($pdo);

$last_name = "peac";
print_r($emp->get_employees($last_name));
print_r($emp->get_departments(null));
$data = $emp->query("SELECT * FROM titles LIMIT 1,200");

function html_table($data = array())
{
    $rows = array();
    foreach ($data as $row) {
        $cells = array();
        foreach ($row as $cell) {
            $cells[] = "<td>{$cell}</td>";
        }
        $rows[] = "<tr>" . implode('', $cells) . "</tr>";
    }
    return "<table class='hci-table'>" . implode('', $rows) . "</table>";
}

//echo html_table($data);


exit();
$res = $emp->get_employees2();
print_r($res);
print json_encode($res);
exit();
while ($row = $prep->fetch())
{
    echo $row['last_name'] . "\n";
}