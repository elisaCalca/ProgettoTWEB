<?php
/* Funzioni per le operazioni CRUD sulla tabella ROLES */

require_once("ConnectionService.php");
header('Content-Type: application/json');

function get_roleId_byName($name)
{
    $db = create_connection();

    $name = $db->quote($name);
    $row = $db->query("SELECT ID FROM Roles WHERE Name = $name");
    return $row->fetch();
}

function get_roleName_byId($id){
    $db = create_connection();

    $id = $db->quote($id);
    $row = $db->query("SELECT Name FROM Roles WHERE ID = $id");
    return $row->fetch();
} 

?>