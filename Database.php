<?php

class Database
{
    protected $connection;

    /**
     * Construct the Database connection
     * 
     * @param array $config
     */
    public function __construct($config)
    {
        $dsn = "{$config['driver']}:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ];

        try {
            $this->connection = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: {$e->getMessage()}");
        }
    }

    /**
     * Execute a database query
     * 
     * @param string $query
     * @param array $params
     * @return PDOStatement
     * @throws PDOException
     */
    public function query($query, $params = [])
    {
        try {
            $sth = $this->connection->prepare($query);

            /*
            // Bind parameters if provided ':id', $id
            foreach ($params as $key => $value) {
                $sth->bindValue(':' . $key, $value);
            }
            */
            $sth->execute($params);
            return $sth;
        } catch (PDOException $e) {
            throw new Exception("Database query failed to execute: {$e->getMessage()}");
        }
    }
}
