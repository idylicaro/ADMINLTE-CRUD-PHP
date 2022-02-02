<?php

    namespace App\Pdo;
    use PDO;
    use PDOException;


    class Database{
        const HOST = 'localhost';
        const NAME = 'php_challenge';
        const USER = 'root';
        const PASS = '123456';

        private $table;

        private $connection;

        /**
         * @param string $stable
         */
        public function __construct($table=null){
            $this->table = $table;
            $this->setConnection();

        }

        private function setConnection(){
            try {
                $dbenv = getenv('DATABASE_URL');
                if ($dbenv){
                    $parsed = parse_url($dbenv);
                    $dbname = ltrim($parsed['path']. '/');
                    $conn = new PDO("{$parsed['scheme']}:host={$parsed};$dbname={$dbname};charset=utf8mb4", $parsed['user'], $parsed['pass']);
                }
                else{
                    $this->connection = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::NAME, self::USER, self::PASS);
                }
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die($e);
                die('Erro ao se conectar com o banco de dados');
            }
        }

        /**
         * @param  string $query
         * @param  array  $params
         * @return PDOStatement
         */
        public function execute($query,$params = []){
            try{
                $statement = $this->connection->prepare($query);
                $statement->execute($params);
                return $statement;
            }catch(PDOException $e){
                die('ERROR: '.$e->getMessage());
            }
        }

        /**
         * @param  array $values [ field => value ]
         * @return integer ID inserido
         */
        public function insert($values)
        {
            $fields = array_keys($values);
            $binds = array_pad([], count($fields), '?');

            $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';

            $this->execute($query, array_values($values));

            return $this->connection->lastInsertId();
        }

        /**
         * @param  string $where
         * @param  string $order
         * @param  string $limit
         * @param  string $fields
         * @return PDOStatement
         */
        public function select($where = null, $order = null, $limit = null, $fields = '*'){
            $where = strlen($where) ? 'WHERE '.$where : '';
            $order = strlen($order) ? 'ORDER BY '.$order : '';
            $limit = strlen($limit) ? 'LIMIT '.$limit : '';

            $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

            return $this->execute($query);
        }

        /**
         * @param  string $where
         * @param  array $values [ field => value ]
         * @return boolean
         */
        public function update($where,$values){
            $fields = array_keys($values);

            $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

            $this->execute($query,array_values($values));

            return true;
        }

        /**
         * @param  string $where
         * @return boolean
         */
        public function delete($where){
            $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

            $this->execute($query);

            return true;
        }
    }
