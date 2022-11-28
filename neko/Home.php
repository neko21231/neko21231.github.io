<!DOCTYPE HTML>
<html>

<head>
    <title>Create a Record</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Home</h1>
        </div>

        <?php
        include 'menu.php';
        include 'session.php';
        ?>


        <section class="home py-5" id="home">
            <div class="container-lg py-4">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-title text-center">
                            <h2 class="fw-bold mb-5">Art Shop</h2>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center ">
                    <h1>My Artwork </h1>
                    <div class="row gy-5 ">
                        <img src="image/IMG_1921.PNG" class="rounded float-start" alt="a1">
                        <br>
                        <img src="image/mmexportde743499c5c0e8abcb301b05f9c0e188_1653464370310.jpeg"
                            class="rounded float-end" alt="a2">
                        <br>
                        <img src="image/IMG_1916.PNG" class="rounded float-end" alt="a3">
                    </div>

                </div>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"></script>
</body>

</html>