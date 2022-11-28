<?php
namespace MyApp\Database;

use PDO;
use Exception;

class Database
{
    protected $connection;
    public function __construct()
    {
        try {
            $DBNAME = DB_DATABASE_NAME;
            $DBUSERNAME = DB_USERNAME;
            $DBHOST = DB_HOST;
            $DBPASSWORD = DB_PASSWORD;
            $this->connection = new PDO(
                "mysql:host=$DBHOST;dbname=$DBNAME",
                "$DBUSERNAME",
                "$DBPASSWORD"
            );
            if (mysqli_connect_errno()) {
                throw new Exception("Could not connect to server and database");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function select($query = "", $params = [])
    {
        try {
            $statement = $this->connection->prepare("$query");
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $result = $statement->fetchAll();
            return $result;
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function insert($fieldarray, $table)
    {
        $keys = array_keys((array) $fieldarray);
        $columns = "";
        $values = "";
        try {
            foreach ($keys as $item) {
                $columns .= "$item,";
                $values .= "'$fieldarray[$item]',";
            }
            $columns = substr($columns, 0, -1);
            $values = substr($values, 0, -1);
            $query = "INSERT INTO $table($columns) VALUES($values)";
            $statement = $this->connection->prepare("$query");
            $statement->execute();
            return $query;
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function delete($where, $table)
    {
        try {
            $query = "DELETE FROM $table WHERE $where";
            $statement = $this->connection->prepare("$query");
            $statement->execute();
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>
