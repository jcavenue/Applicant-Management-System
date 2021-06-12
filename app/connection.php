<?php

namespace app;

class Connection {

    private static $conn;

    public function connect() {

        // read parameters in the ini configuration file
        $params = parse_ini_file('Resources/database.ini');
        if ($params === false) {
            throw new \Exception("Error reading database configuration file");
        }
        // connect to the postgresql database
        $conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", 
                $params['host'], 
                $params['port'], 
                $params['database'], 
                $params['user'], 
                $params['password']);

		try {
			$pdo = new \PDO($conStr);
			$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo "Error Found" . $e->getMessage();
		}

        return $pdo;
    }

    public static function get() {
        if (null === static::$conn) {
            static::$conn = new static();
        }

        return static::$conn;
    }
}
?>