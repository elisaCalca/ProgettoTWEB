<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand">
        <img id="logo-navbar" src="../Images/logos/goto_home_btn.png" class="nav-logo" alt="" width="148" height="58">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav flex-grow-1">
            <li class="nav-item me-auto expand">
                <form id="form-search" class="d-flex">
                    <input id="text-to-search" class="form-control" type="search" placeholder="Cerca" aria-label="Search">
                    <button id="search-prod" class="btn btn-outline-warning" type="submit"><i class="bi bi-search"></i></button>
                </form>
            </li>
            <li class="nav-item me-auto">
                <a class="nav-link dropdown-toggle drop-father-item-sel mt-1" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Profilo
                </a>
                <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item drop-item-sel" href="my_data.php">I miei dati</a>
                    <a id="nav-my-company" class="dropdown-item drop-item-sel" href="my_company.php">Il mio negozio</a>
                    <a class="dropdown-item drop-item-sel" href="logout.php">Logout</a>
                </div>
            </li>
            <li class="nav-item me-auto">
                <button id="shopping-bag" type="button" class="btn btn-outline-light position-relative">
                    <i class="bi bi-bag-fill"></i>
                    <!-- <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        99+
                    </span> -->
                </button>
            </li>
        </ul>
    </div>
</nav>