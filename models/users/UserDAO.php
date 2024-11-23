<?php
include_once "config/dataBase.php";
include_once "models/users/Users.php";

class UserDAO{
    public function getAll(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM USERS");

        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while($user = $result->fetch_object("User")){
            $users[] = $user;
        }

        $con->close();
        return $users;
    }
}
?>