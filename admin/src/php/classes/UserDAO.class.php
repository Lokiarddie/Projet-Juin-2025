<?php

class UserDAO
{
    private $_bd;
    private $_array = array();

    public function __construct($cnx)
    {
        $this->_bd = $cnx;
    }

    public function getUser($login, $password)
    {
        $query = "SELECT * FROM clients WHERE login = :login AND password = :password";
        try {
            $this->_bd->beginTransaction();
            $resultset = $this->_bd->prepare($query);
            $resultset->bindValue(':login', $login);
            $resultset->bindValue(':password', $password);
            $resultset->execute();

            $user = $resultset->fetch(PDO::FETCH_ASSOC); // ← récupère un tableau associatif
            $this->_bd->commit();
            return $user;

        } catch (PDOException $e) {
            $this->_bd->rollBack();
            print "Échec de la requête : " . $e->getMessage();
            return null;
        }
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM clients WHERE id = :id";
        $stmt = $this->_bd->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteUserById(int $id): bool {
        $sql = "DELETE FROM clients WHERE id = :id";
        $stmt = $this->_bd->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function existsLogin(string $login): bool {
        $stmt = $this->_bd->prepare("SELECT COUNT(*) FROM clients WHERE login = :login");
        $stmt->execute(['login' => $login]);
        return $stmt->fetchColumn() > 0;
    }

    public function existsEmail(string $email): bool {
        $stmt = $this->_bd->prepare("SELECT COUNT(*) FROM clients WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    public function createUser(array $data): bool {
        $sql = "INSERT INTO clients (nom, prenom, email, adresse, login, password, date_inscription) 
            VALUES (:nom, :prenom, :email, :adresse, :login, :password, :date_inscription)";
        $stmt = $this->_bd->prepare($sql);
        return $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'adresse' => $data['adresse'],
            'login' => $data['login'],
            'password' => $data['password'],
            'date_inscription' => $data['date_inscription'],
        ]);
    }




}
