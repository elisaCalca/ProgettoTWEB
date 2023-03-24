<?php
/* Funzioni per le operazioni CRUD sulla tabella PRODUCTS */

require_once("ConnectionService.php");
require_once("UsersService.php");
require_once("ImagesService.php");
header('Content-Type: application/json');

function create_product($id, $name, $descr, $price, $imgb64, $selleremail)
{
    $db = create_connection();

    $name = $db->quote($name);
    $description = $db->quote($descr);
    $price = $db->quote($price);
    $sellerId = get_user_byEmail($selleremail);
    $sellerId = $db->quote($sellerId["ID"]);
    $rowimg = create_image($imgb64);
    $imageId = $db->quote($rowimg["ID"]);
    $db->query("INSERT INTO Products(Name, Description, Price,
        UserIDSeller, ImageID) VALUES($name, $description,
        $price, $sellerId, $imageId)");
    return $db->lastInsertId();
}

function get_product_byID($id)
{
    $db = create_connection();

    $id = $db->quote($id);
    $row = $db->query("SELECT Prod.ID, Prod.Name, Prod.Description, Prod.Price, Img.ImageData
        FROM Products AS Prod JOIN Images AS Img ON Prod.ImageID = Img.ID WHERE Prod.ID = $id");
    return $row->fetch();
}

function get_product_byName($name)
{
    $db = create_connection();

    $name = '%' . $name . '%';
    $name = $db->quote($name);
    $row = $db->query("SELECT Prod.ID, Prod.Name, Prod.Description, Prod.Price, Img.ImageData
        FROM Products AS Prod JOIN Images AS Img ON Prod.ImageID = Img.ID 
        WHERE Prod.Name LIKE $name LIMIT 1");
    return $row->fetch();
}

function get_randomproduct()
{
    $db = create_connection();

    $row = $db->query("SELECT Prod.ID AS ID, Prod.Name AS Name, Prod.Description AS Description, 
            Prod.Price AS Price, Img.ImageData AS ImageData
        FROM Products AS Prod 
        JOIN Images AS Img ON Prod.ImageID = Img.ID
        ORDER BY RAND() LIMIT 1");
    return $row->fetch();
}

function getall_products_byUserEmail($userEmail)
{
    $db = create_connection();

    $userEmail = $db->quote($userEmail);
    return $db->query("SELECT Prod.ID AS ID, Prod.Name AS Name, Prod.Description AS Description, 
            Prod.Price AS Price, Img.ImageData AS ImageData
        FROM Products AS Prod 
        JOIN Images AS Img ON Prod.ImageID = Img.ID 
        JOIN Users AS Usrs ON Prod.UserIDSeller = Usrs.ID
        WHERE Usrs.Email = $userEmail");
}

function update_product($id, $name, $descr, $price, $imgb64, $selleremail)
{
    $db = create_connection();

    $id = $db->quote($id);
    $name = $db->quote($name);
    $description = $db->quote($descr);
    $price = $db->quote($price);
    $rowUsr = get_user_byEmail($selleremail);
    $sellerId = $db->quote($rowUsr["ID"]);
    //controllo se è necessario fare update dell'immagine
    if($imgb64 != null && strlen($imgb64)>0){
        $rowimg = create_image($imgb64);
        $imageId = $db->quote($rowimg["ID"]);
        $db->query("UPDATE Products SET Name = $name, Description = $description, Price = $price,
            UserIDSeller = $sellerId, ImageID = $imageId WHERE ID = $id");
    } else {
        $db->query("UPDATE Products SET Name = $name, Description = $description, Price = $price,
            UserIDSeller = $sellerId WHERE ID = $id");
    }
    return true;
}

function delete_product_byId($id, $userID)
{
    $db = create_connection();

    $id = $db->quote($id);
    $userID = $db->quote($userID);
    $db->query("DELETE FROM Products WHERE ID = $id AND UserIDSeller = $userID");
    return true;
}

?>