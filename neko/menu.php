<nav class="navbar navbar-dark bg-info fixed-top ">
    <div class="container-fluid">
        <a class="navbar-brand " href="#">neko Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
            aria-controls="offcanvasDarkNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-info " tabindex="-1" id="offcanvasDarkNavbar"
            aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">neko Shop</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 ">
                    <li class=" nav-item">
                        <a class=" nav-link " href="Home.php?page=home">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="product_read.php">Product List</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href="order_read.php">Order List</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href="customer_read.php">Customer List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="contact_us.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="logout.php">Log Out</a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>