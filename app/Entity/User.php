<?php

namespace App\Entity;

use App\Pdo\Database;

class User
{
    /*
     * Indentificador Único do usuario
     * @var interger
     * */
    public $id;

    /*
     * Nome do usuario
     * @var string
     * */
    public $name;

    /*
     * Email do usuario
     * @var string
     * */
    public $email;
    /*
     * Senha do usuario
     * @var string
     * */
    public $password;

    public function save(){
        $db = new Database('users');
        $db->insert([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);
    }
    public function login(){
        return (new Database('users'))->select("email = '{$this->email}' AND password = '{$this->password}'")
                ->fetchObject(self::class);
    }
}