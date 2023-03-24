<?php
/* Funzioni per le operazioni CRUD sulla tabella IMAGES */

require_once("ConnectionService.php");
header('Content-Type: application/json');

function create_image($base64Img)
{
    $db = create_connection();

    $base64Img = $db->quote($base64Img);
    $date = $db->quote(date("Y-m-d H:i:s"));
    $db->query("INSERT INTO Images(ImageData, DateInsertion) VALUES($base64Img, $date)");
    $row = $db->query("SELECT * FROM Images ORDER BY DateInsertion DESC LIMIT 1");
    return $row->fetch();
}

function get_image_byID($id)
{
    try {
        $db = create_connection();

        $id = $db->quote($id);
        $row = $db->query("SELECT * FROM Images WHERE ID = $id");
        return $row->fetch();
    } catch (PDOException $e) {
        return null;
    }
}

function update_image_byId($toUpdate)
{
    try {
        $db = create_connection();

        $id = $db->quote($toUpdate["id"]);
        $base64Img = $db->quote($toUpdate["imagedata"]);
        $db->query("UPDATE Images SET ImageData = $base64Img WHERE ID = $id");
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function delete_image_byId($id)
{
    try {
        $db = create_connection();

        $id = $db->quote($id);
        $db->query("DELETE FROM Images WHERE ID = $id");
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

?>