<?php

class AdminDAO
{
    private $_bd;
    private $_array = array();

    public function __construct($cnx)
    {
        $this->_bd = $cnx;
    }

    public function getAdmin($login, $password)
    {
        $query = "SELECT * FROM admin WHERE login_admin = :login AND password_admin = :password";
        try {
            $this->_bd->beginTransaction();
            $resultset = $this->_bd->prepare($query);
            $resultset->bindValue(':login', $login);
            $resultset->bindValue(':password', $password);
            $resultset->execute();

            // Récupérer toute la ligne sous forme de tableau associatif
            $admin = $resultset->fetch(PDO::FETCH_ASSOC);

            $this->_bd->commit();
            return $admin;  // retourne un tableau ou false si pas trouvé

        } catch (PDOException $e) {
            $this->_bd->rollback();
            print "Echec de la requête " . $e->getMessage();
            return false;
        }
    }


}
