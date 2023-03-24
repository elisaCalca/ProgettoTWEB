<?php
/* Funzioni per le operazioni CRUD sulla tabella PRODUCTS */

require_once("ConnectionService.php");
require_once("UsersService.php");
header('Content-Type: application/json');

function create_recentlyseen($newSeen)
{
    try {
        $db = create_connection();

        $seenUserId = get_user_byEmail($newSeen["email"]);
        $productId = $newSeen["productid"];
        $date = date("Y-m-d H:i:s");
        $db->query("INSERT INTO Recently_Seen(UserID, ProductId, DateVisualization)
            VALUES ($seenUserId, $productId, $date)");
        return $db->lastInsertId();
    } catch (PDOException $e) {
        return null;
    }
}

function get_top3recentlyseen_byUserId($id)
{
    try {
        $db = create_connection();

        $id = $db->quote($id);
        $rows = $db->query("SELECT TOP(3) FROM Recently_Seen WHERE UserID = $id
            ORDER BY DateVisualization DESC");
        $seenarray = array();
        while ($elem = $rows->fetch()) {
            array_push($seenarray, $elem);
        }
        return $seenarray;
    } catch (PDOException $e) {
        return null;
    }
}
?>