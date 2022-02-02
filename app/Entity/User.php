<?php

namespace App\Entity;

use App\Pdo\Database;
use PDO;

class User
{
    /**
     * Indentificador Único do usuario
     * @var interger
     * */
    public $id;

    /**
     * Nome do usuario
     * @var string
     * */
    public $name;

    /**
     * Email do usuario
     * @var string
     * */
    public $email;
    /**
     * Senha do usuario
     * @var string
     * */
    public $password;

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     */


    public function save(){
        $db = new Database('users');
        $db->insert([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);
    }

    public static function findAll()
    {
        return (new Database('users'))->select()->fetchAll(PDO:: FETCH_CLASS);
    }

    public function findById($id)
    {
        return (new Database('users'))->select("id= {$id}")
            ->fetchObject(self::class);
    }

    public function update()
    {
        return (new Database('users'))->update("id={$this->id}", [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ]);
    }

    public function delete($id)
    {
        return (new Database('users'))->delete("id= {$id}");
    }

    public function login(){
        return (new Database('users'))->select("email = '{$this->email}' AND password = '{$this->password}'")
                ->fetchObject(self::class);
    }
}