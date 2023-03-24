<?php

$currentPage = basename($_SERVER["PHP_SELF"], ".php");

?>

<!-- JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<!-- For responsive navBar functionality -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


<script src="../js/NavbarScripts.js"></script>
<script src="../js/ValidationScripts.js"></script>
<?php if ($currentPage == "register") : ?>
    <script src="../js/LoginRegisterScripts.js"></script>
<?php elseif ($currentPage == "home") : ?>
    <script src="../js/RecentlySeenRecommendedScripts.js"></script>
<?php elseif ($currentPage == "single_product") : ?>
    <script src="../js/SingleProductScripts.js"></script>
<?php elseif ($currentPage == "orders") : ?>
    <script src="../js/OrdersScripts.js"></script>
<?php elseif ($currentPage == "shopping_bag") : ?>
    <script src="../js/ShoppingBagScripts.js"></script>
<?php elseif ($currentPage == "my_company") : ?>
    <script src="../js/MyCompanyScripts.js"></script>
<?php elseif ($currentPage == "create_edit_product") : ?>
    <script src="../js/CreateEditProductScripts.js"></script>
<?php elseif ($currentPage == "buy_products") : ?>
    <script src="../js/BuyProductsScripts.js"></script>
<?php elseif ($currentPage == "my_data") : ?>
    <script src="../js/MyDataScripts.js"></script>
<?php endif; ?>