<?php
/* Funzioni per le operazioni CRUD sulla tabella USERS */

require_once("ConnectionService.php");
header('Content-Type: application/json');

function create_user($name, $surname, $email, $password, $role)
{
    $db = create_connection();
    $name = $db->quote($name);
    $surname = $db->quote($surname);
    $email = $db->quote($email);
    $row = get_roleId_byName($role);
    $roleId = $db->quote($row["ID"]);
    $md5pwd = md5($password);
    $password = $db->quote($md5pwd);

    $db->query("INSERT INTO Users(Name, Surname, Email, RoleID, Password)
    VALUES($name, $surname, $email, $roleId, $password)");
    return $db->lastInsertId();
    
}

function get_user_byEmail($email)
{
    $db = create_connection();

    $email = $db->quote($email);
    $row = $db->query("SELECT * FROM Users WHERE Email = $email");
    return $row->fetch();
}

function get_logininfo_byEmail($username)
{
    $db = create_connection();

    $username = $db->quote($username);
    $row = $db->query("SELECT Usr.RoleID AS RoleID FROM Users AS Usr
        JOIN Roles AS Rl ON Usr.RoleID = Rl.ID
        WHERE Usr.Email = $username");
    return $row->fetch();
}

function get_login($username, $password)
{
    $db = create_connection();
    $username = $db->quote($username);
    $password = $db->quote(md5($password));
    $row = $db->query("SELECT * FROM Users WHERE Email = $username AND Password = $password");
    return $row->fetch();
}

function update_user_byId($emailOld, $name, $surname, $email, $oldpassword, $newPassword, $newRoleName)
{
    $db = create_connection();

    $user = get_user_byEmail($emailOld);
    $userId = $user["ID"];

    $loginrow = get_login($emailOld, $oldpassword); //check if the old password is correct
    if($loginrow == null) {
        return false;
    } else {
        $id = $db->quote($userId);
        $name = $db->quote($name);
        $surname = $db->quote($surname);
        $email = $db->quote($email);
        $role = get_roleId_byName($newRoleName);
        $roleId = $db->quote($role["ID"]);
        
        if($newPassword != null && strlen($newPassword)>0){
            $newPassword = $db->quote(md5($newPassword));
            $db->query("UPDATE Users SET Name = $name, Surname = $surname,
            Email = $email, RoleID = $roleId, Password = $newPassword
            WHERE ID = $id");
        return true;
        } else {
            $db->query("UPDATE Users SET Name = $name, Surname = $surname,
            Email = $email, RoleID = $roleId WHERE ID = $id");
        return true;
        }
    }
}

function user_exist_byEmail($email)
{
    $db = create_connection();

    $email = $db->quote($email);

    $row = $db->query("SELECT COUNT(*) AS exist FROM Users WHERE Email = $email");
    $row = $row->fetch();
    if ($row["exist"] > 0)
        return true;
    else
        return false;
}
?>