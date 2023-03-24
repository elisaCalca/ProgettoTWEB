<?php
if (!isset($_SESSION)) { session_start(); }

require_once("../Services/RolesService.php");
require_once("../Services/ImagesService.php");
require_once("../Services/ProductsService.php");
require_once("../Services/RecentlySeenService.php");
require_once("../Services/ShoppingBagsService.php");
require_once("../Services/UsersService.php");
require_once("../Utils/ValidationUtils.php");
header('Content-Type: application/json');

if (isset($_POST["submit"]) || isset($_GET["submit"]))
{
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        if ($_POST["submit"] == "login")
            echo login_api($_POST["usr"], $_POST["pwd"]);
        else if($_POST["submit"] == "register")
            echo register_api($_POST["name"], $_POST["surname"], $_POST["email"], $_POST["password"], $_POST["role"]);
        else if($_POST["submit"] == "createeditproduct")
            echo create_update_product_api($_POST["id"], $_POST["name"], $_POST["descr"], $_POST["price"], $_POST["img"]);
        else if($_POST["submit"] == "getall_products_byuser")
            echo getall_products_byUserEmail_api($_SESSION["username"]);
        else if($_POST["submit"] == "delete_productmycompany")
            echo delete_productmycompany_api($_POST["prodId"], $_SESSION["username"]);
        else if($_POST["submit"] == "getall_shoppingbag")
            echo getall_shoppingbag_api($_SESSION["username"]);
        else if($_POST["submit"] == "get_randomproduct")
            echo get_randomproduct_api();
        else if($_POST["submit"] == "add_productshoppingbag")
            echo add_productshoppingbag_api($_POST["productId"], $_SESSION["username"], $_POST["qty"]);
        else if($_POST["submit"] == "submit_order_delete_bag")
            echo submit_order_delete_bag_api($_SESSION["username"]);
        else if($_POST["submit"] == "get_userInfo")
            echo get_userInfo_api($_SESSION["username"]);
        else if($_POST["submit"] == "get_product_byName")
            echo get_product_byName_api($_POST["prodName"]);
        else if($_POST["submit"] == "get_login_infos")
            echo get_login_infos_api($_SESSION["username"]);
        else if($_POST["submit"] == "update_userInfo")
            echo update_userInfo_api($_SESSION["username"], $_POST["name"], $_POST["surname"], 
            $_POST["newemail"], $_POST["oldpwd"], $_POST["newpwd"], $_POST["roleName"]);
        else if($_POST["submit"] == "delete_product_shoppingbag")
            echo delete_productshopbag_api($_POST["prodId"], $_SESSION["username"]);
    }
    else if($_SERVER['REQUEST_METHOD'] == "GET")
    {
        if($_GET["submit"] == "get_product")
            echo get_product_byId_api($_GET["product_id"]);
        
    }
    else
    {
        echo json_encode(array("status" => false, "code" => 405, "message" => "Method Not Allowed"));
    }
}
else
{
    echo json_encode(array("status" => false, "code" => 400,"submit_key"=>$_GET["submit"],
     "request method"=> $_SERVER['REQUEST_METHOD'], "message" => "Bad Request"));
}

/* Funzione per effettuare il login di un utente già registrato
    @param $email: l'email dell'utente
    @param $password: la password dell'utente non criptata
    @return status: true se il login è stato effettuato, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione
*/ 
function login_api($email, $password) {
    try {
        //Validazione lato server
        // $email = validateEmail($email);
        $password = validatePassword($password);

        if($email != null && strlen($email)>0 && $password != null && strlen($password>0)){
            
            $row = get_login($email, $password);
            if ($row == null) {
                return json_encode((array("status" => false, "code" => 403,
                "message" => "Errore. Credenziali errate.")));
            } else {
                //set login info in session
                session_regenerate_id(TRUE);
                $_SESSION["username"] = $row["Email"];
                $_SESSION["name"] = $row["Name"];
            }
            return json_encode((array("status" => true, "code" => 200,
            "message" => "OK")));
        } else {
            return json_encode((array("status" => false, "code" => 400,
            "message" => "Errore. Tutti i campi sono obbligatori per il login.")));
        }

    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

/* Funzione per effettuare la registrazione di un nuovo utente
    @param $name: nome dell'utente
    @param $surname: cognome dell'utente
    @param $email: email dell'utente, deve essere univoca e sarà lo username per il login successivo
    @param $password: la password dell'utente, non ancora criptata
    @param $role: il ruolo con cui l'utente vuole registrarsi
    @return status: true se l'utente è stato registrato, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione
*/
function register_api($name, $surname, $email, $password, $role) {
    try {
        //Validazione lato server
        $name = validateText($name);
        $surname = validateText($surname);
        //$email = validateEmail($email);
        $password = validatePassword($password);
        $role = validateText($role);

        $row = get_roleId_byName($role); //per controllare se il ruolo è valido ed esistente nel DB
        if($name != null && strlen($name)>0 
            && $surname != null && strlen($surname)>0 
            && $email != null && strlen($email)>0 
            && $password != null && strlen($password)>0 
            && $row["ID"] != null && strlen($row["ID"])>0)
        {
            $insertedUserId = create_user($name, $surname, $email, $password, $role);

            return json_encode((array("status" => true, "code" => 200,
            "message" => "Profilo creato correttamente!")));
        } else {
            return json_encode((array("status" => false, "code" => 400,
            "message" => "Errore. Tutti i campi devono essere compilati correttamente.")));
        }
        
    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

/* Funzione che in base ai parametri ricevuti crea o aggiorna un prodotto
    @param $id: se è valorizzato identifica il prodotto da aggiornare, altrimenti creare il prodotto
    @param $name: nome del prodotto
    @param $descr: descrizione del prodotto
    @param $price: prezzo del prodotto
    @param $img: immagine del prodotto in base64
    @return status: true se il prodotto è stato creato/aggiornato, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione
*/
function create_update_product_api($id, $name, $descr, $price, $imgb64) {
    try {
        $selleremail = $_SESSION["username"];

        if($name != null && strlen($name)>0
            && $descr != null && strlen($descr)>0
            && $price != null && strlen($price)>0
            && $selleremail != null && strlen($selleremail)>0)
        {
            if($id != null && strlen($id)>0){
                //update
                $ret = update_product($id, $name, $descr, $price, $imgb64, $selleremail);
            }
            else {
                //create
                if($imgb64 != null && strlen($imgb64)>0){
                    $ret = create_product($id, $name, $descr, $price, $imgb64, $selleremail);
                } else {
                    return json_encode((array("status" => false, "code" => 400,
                    "message" => "Errore. Per inserire un nuovo prodotto è necessario caricare un'immagine")));
                }
            }
            return json_encode((array("status" => true, "code" => 200,
                "message" => "Operazione eseguita correttamente!")));
        } else {
            return json_encode((array("status" => false, "code" => 400,
                "message" => "Errore. Tutti i campi devono essere compilati correttamente.")));
        }
    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

/* Funzione che restituisce il record relativo ad un prodotto dato il suo ID
    @param $product_id: id del prodotto da cercare
    @return status: true se il prodotto è stato trovato, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione, valorizzato solo in caso di errore
    @return product_name: nome del prodotto
    @return product_descr: descrizione del prodotto
    @return product_price: prezzo del prodotto
    @return imgb64: immagine del prodotto in base64
 */
function get_product_byId_api($product_id) {
    try {
        if($product_id != null && strlen($product_id)>0){
            $product = get_product_byID($product_id);
            if($product == null) {
                return json_encode(array("status" => false, "code" => 404,
                "product_name" => "Uh-Oh!",
                "message" => "Sembra che tu abbia ricercato un prodotto inesistente!"
            ));
            } else {
                return json_encode((array("status" => true, "code" => 200,
                "product_name" => $product["Name"],
                "product_descr" => $product["Description"],
                "product_price" => $product["Price"],
                "imgb64" => $product["ImageData"])));
            }
        } else {
            return json_encode((array("status" => false, "code" => 400,
            "message" => "Errore. l'ID del prodotto deve essere un valore valido.")));
        }
    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

/* Funzione che restituisce la lista di tutti i prodotti forniti dall'utente dato il suo ID
    @param $userId: email del fornitore dei prodotti
    @return $products: tutti i record relativi a prodotti che sono forniti da $userID, valorizzato solo in caso di successo
    @return status: true se i prodotti sono stati trovati, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione, valorizzato solo in caso di errore
*/
function getall_products_byUserEmail_api($userEmail) {
    try {
        if($userEmail != null && strlen($userEmail)>0){
            $rows = getall_products_byUserEmail($userEmail);
            $products = [];
            foreach($rows as $row){
                $products[] = array("ID" => $row["ID"], "Name" => $row["Name"], "Description" => $row["Description"],
                "Price" => $row["Price"], "ImageData" => $row["ImageData"]);
            }
            return json_encode((array("status" => true, "code" => 200,
            "products" => $products)));
        } else {
            return json_encode((array("status" => false, "code" => 400,
            "message" => "Errore. L'ID dell'utente deve essere un valore valido.")));
        }
    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

/* Funzione che permette di eliminare un prodotto fornito dalla propria compagnia
    @param $prodId: id del prodotto da eliminare
    @param $userEmail: email del fornitore del prodotto da eliminare
    @return status: true se il prodotto è stato eliminato, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione
*/
function delete_productmycompany_api($prodId, $userEmail) {
    try {
        if($prodId != null && strlen($prodId)>0
            && $userEmail != null && strlen($userEmail)>0)
        {
            $row = get_user_byEmail($userEmail);
            $userId = $row["ID"];
            $res = delete_product_byId($prodId, $userId);
            return json_encode((array("status" => true, "code" => 200,
            "message" => "Prodotto eliminato con successo.")));
        } else {
            return json_encode((array("status" => false, "code" => 400,
            "message" => "Errore. Impossibile identificare il prodotto da eliminare.")));
        }
    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

/* Funzione che permette di eliminare un prodotto fornito dalla propria compagnia
    @param $prodId: id del prodotto da eliminare
    @param $userEmail: email del fornitore del prodotto da eliminare
    @return status: true se il prodotto è stato eliminato, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione
*/
function delete_productshopbag_api($prodId, $userEmail) {
    try {
        if($prodId != null && strlen($prodId)>0
            && $userEmail != null && strlen($userEmail)>0)
        {
            $row = get_user_byEmail($userEmail);
            $userId = $row["ID"];
            $res = delete_shoppingbag_byProductId($prodId, $userId);
            return json_encode((array("status" => true, "code" => 200,
            "message" => "Prodotto eliminato con successo.")));
        } else {
            return json_encode((array("status" => false, "code" => 400,
            "message" => "Errore. Impossibile identificare il prodotto da eliminare.")));
        }
    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

/* Funzione che restituisce i prodotti nel carrello dell'utente passato in input
    @param $userEmail: email con cui si è loggati
    @return status: true non si sono verificati errori, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione
    @return shoppings: lista con i dettagli dei prodotti presenti nel carrello
*/
function getall_shoppingbag_api($userEmail) {
    try {
        if($userEmail != null && strlen($userEmail)>0) {
            $rows = getall_shoppingbag_byUserEmail($userEmail);
            $shoppings = [];
            foreach($rows as $row) {
                $shoppings[] = array("ID" => $row["ID"], "Name" => $row["Name"], "Imageb64" => $row["ImageData"], "Qty" => $row["Qty"]);
            }
            return json_encode((array("status" => true, "code" => 200,
            "shoppings" => $shoppings)));
        } else {
            return json_encode((array("status" => false, "code" => 400,
            "message" => "Errore. Impossibile stabilire l'elenco di prodotti da caricare.")));
        }
    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

/* Funzione che restituisce un prodotto qualsiasi messo in vendita sul sito 
    @return status: true non si sono verificati errori, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione
    @return ID: ID del prodotto
    @return Name: nome del prodotto
    @return Description: descrizione del prodotto
    @return Price: prezzo del prodotto
    @return ImageData: immagine del prodotto in base64
*/
function get_randomproduct_api() {
    try {
        $row = get_randomproduct();
        if(empty($row)){
            return json_encode((array("status" => false, "code" => 200,
                "ID" => "none", "Name" => "Ooops!", "Description" => "Sembra che nessun prodotto sia in vendita al momento..",
                "ImageData" => "../Images/shared/error-confused-gif.gif")));
        } else {
                return json_encode((array("status" => true, "code" => 200,
                "ID" => $row["ID"], "Name" => $row["Name"], "Description" => $row["Description"],
                "Price" => $row["Price"], "ImageData" => $row["ImageData"])));
        }
    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

/* Funzione che permette di aggiungere un prodotto al carrello
    @param $prodId: id del prodotto da aggiungere
    @param $userEmail: email del l'utente che vuole aggiungere il prodotto
    @param $qty: quantità di prodotto da aggiungere
    @return status: true se il prodotto è stato aggiunto, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione
*/
function add_productshoppingbag_api($prodId, $userEmail, $qty) {
    try {
        $userId = get_user_byEmail($userEmail);
        $res = add_shoppingbag_byProductId($prodId, $userId["ID"], $qty);

        return json_encode((array("status" => true, "code" => 200,
            "message" => "Prodotto aggiunto correttamente nel carrello.")));
    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

/* Funzione che "spedisce" un ordine ed elimina i prodotti ordinati dal carrello
    @param $userEmail: email del l'utente che vuole ordinare il prodotto
    @return status: true se il prodotto è stato ordinato, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione
*/
function submit_order_delete_bag_api($userEmail){
    try {
        $userId = get_user_byEmail($userEmail);
        $ret = delete_shoppingbag_forUser($userId["ID"]);

        return json_encode((array("status" => true, "code" => 200,
            "message" => "Ordine effettuato correttamente")));
    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

/* Funzione che restituisce le info dell'utente loggato
    @param $userEmail: email del l'utente loggato
    @return status: true se non si sono verificati errori, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione
    @param $Name: nome dell'utente
    @param $Surname: cognome dell'utente
    @param $Email: email dell'utente, deve essere univoca e sarà lo username per il login successivo
    @param $roleName: il ruolo con cui l'utente vuole registrarsi
*/
function get_userInfo_api($userEmail) {
    try {
        $user = get_user_byEmail($userEmail);
        $roleName = get_roleName_byId($user["RoleID"]);
        return json_encode((array("status" => true, "code" => 200,
            "name" => $user["Name"], "surname" => $user["Surname"], "email" => $userEmail,
            "roleName" => $roleName["Name"]
            )));
    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

/* Funzione che permette di aggiornare le info dell'utente
    @param $name: nome dell'utente
    @param $surname: cognome dell'utente
    @param $email: nuova email
    @param $emailOld: email dell'utente loggato in sessione, verrà sostituita
    @param $newRoleName: il ruolo con cui l'utente vuole registrarsi successivamente
    @param $oldpassword: vecchia password dell'utente, utile per l'autenticazione della modifica
    @param $newpassword: se è valorizzata, sostituirà la oldpassowrd
    @return status: true se non si sono verificati errori, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione
*/
function update_userInfo_api($emailOld, $name, $surname, $email, $oldpassword, $newpassword, $newRoleName) {
    try {
        
        $res = update_user_byId($emailOld, $name, $surname, $email, $oldpassword, $newpassword, $newRoleName);
        
        if($res == true){
            return json_encode((array("status" => true, "code" => 200,
                "message" => "I dati sono stati aggiornati con successo!")));
        } else {
            return json_encode((array("status" => false, "code" => 400,
                "message" => "Errore durante l'aggiornamento dei dati. Controlla che l'email 
                inserita non sia già utilizzata ed inserisci la tua password corretta.")));
        }
    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Prova utilizzando un'email differente o riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

/* Funzione che restituisce il record relativo ad un prodotto dato il suo ID
    @param $product_id: id del prodotto da cercare
    @return status: true se il prodotto è stato trovato, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione, valorizzato solo in caso di errore
    @return product_name: nome del prodotto
    @return product_descr: descrizione del prodotto
    @return product_price: prezzo del prodotto
    @return imgb64: immagine del prodotto in base64
 */
function get_product_byName_api($product_name) {
    try {
        $product_name = trim($product_name);
        if($product_name != null && strlen($product_name)>0){
            $product = get_product_byName($product_name);
            if($product == null) {
                return json_encode(array("status" => false, "code" => 404,
                "product_name" => "Uh-Oh!",
                "message" => "Sembra che tu abbia ricercato un prodotto inesistente!"
            ));
            } else {
                return json_encode((array("status" => true, "code" => 200,
                "ID" => $product["ID"]
                // "product_name" => $product["Name"],
                // "product_descr" => $product["Description"],
                // "product_price" => $product["Price"],
                // "imgb64" => $product["ImageData"]
            )));
            }
        } else {
            return json_encode((array("status" => false, "code" => 400,
            "message" => "Errore. l'ID del prodotto deve essere un valore valido.")));
        }
    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

/* Funzione che verifica se un utente è loggato correttamente
    @param $userEmail: email dell'utente in sessione
    @return role: il ruolo associato all'utente loggato
    @return status: true se il prodotto è stato trovato, false altrimenti
    @return code: codice che rappresenta in che modo si è conclusa l'operazione http
    @return message: messaggio con i dettagli su come si è conclusa l'operazione, valorizzato solo in caso di errore
*/
function get_login_infos_api($userEmail) {
    try {
        if($userEmail != null && strlen($userEmail)>0){
            //se entro qui vuol dire che l'utente presente nella session è valido ed è associato ad un ruolo
            $user = get_logininfo_byEmail($userEmail);
            $roleId = get_roleName_byId($user["RoleID"]);
            $roleName = $roleId["Name"];
            return json_encode((array("status" => true, "code" => 200,
            "role" => $roleName)));
        } else {
            //l'utente presente nella sessione non è valido
            return json_encode((array("status" => false, "code" => 403,
            "message" => "Effettua il login per utilizzare Amazing Shopping!")));
        }
    } catch(PDOException $e) {
        return json_encode((array("status" => false, "code" => 500,
        "message" => "Errore durante la comunicazione con il database. Riprova più tardi.")));
    } catch(Throwable $e) {
        return json_encode((array("status" => false, "code" => 500,
            "message" => "Errore del server. Riprova più tardi.")));
    }
}

?>