<?php
/* Funzioni per le operazioni CRUD sulla tabella SHOPPING_BAGS */

require_once("ConnectionService.php");
require_once("UsersService.php");
header('Content-Type: application/json');

function add_shoppingbag_byProductId($productId, $userId, $qty)
{
    $db = create_connection();

    $productId = $db->quote($productId);
    $row = has_already($productId, $userId);
    $oldqty = $row["Qty"];
    $userId = $db->quote($userId);
    if($oldqty == null){
        $qty = $db->quote($qty);
        $db->query("INSERT INTO Shopping_Bags(UserID, ProductId, Qty)
            VALUES($userId, $productId, $qty)");
        return $db->lastInsertId();
    } else {
        $qty = $qty + $oldqty;
        $qty = $db->quote($qty);
        $db->query("UPDATE Shopping_Bags SET Qty = $qty
            WHERE UserID = $userId AND ProductId = $productId");
        return $db->lastInsertId();
    }
}

function has_already($productId, $userId)
{
    $db = create_connection();

    $productId = $db->quote($productId);
    $userId = $db->quote($userId);
    $row = $db->query("SELECT * FROM Shopping_Bags WHERE UserID = $userId
        AND ProductId = $productId");
    return $row->fetch();
}

function getall_shoppingbag_byUserEmail($userEmail)
{
    $db = create_connection();

    $userEmail = $db->quote($userEmail);
    return $db->query("SELECT Prod.ID, Prod.Name, Img.ImageData, Shop.Qty
        FROM Shopping_Bags AS Shop 
        JOIN Users AS Usrs ON Shop.UserID = Usrs.ID
        JOIN Products AS Prod ON Prod.ID = Shop.ProductId
        JOIN Images AS Img ON Prod.ImageID = Img.ID
        WHERE Usrs.Email = $userEmail");
}

function get_countproductInShoppingBag_byUserId($id)
{
    $db = create_connection();

    $id = $db->quote($id);
    $row = $db->query("SELECT COUNT(*) AS countbag FROM Shopping_Bags WHERE
        UserID = $id");
    $row = $row->fetch();
    if($row["countbag"] != null)
        return $row["countbag"];
    else
        return 0;

}

function delete_shoppingbag_byProductId($productId, $UserId)
{
    $db = create_connection();

    $productId = $db->quote($productId);
    $userId = $db->quote($UserId);
    $db->query("DELETE FROM Shopping_Bags WHERE ProductId = $productId AND
        UserID = $userId");
    return true;
}

function delete_shoppingbag_forUser($UserId)
{
    $db = create_connection();

    $userId = $db->quote($UserId);
    $db->query("DELETE FROM Shopping_Bags WHERE UserID = $userId");
    return true;

}

?>