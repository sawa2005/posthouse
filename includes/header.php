<!DOCTYPE html>

<!-- Code by Samuel Ward -->

<html lang="sv">
<head>
    <title><?= $page_title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Montserrat:wght@600;800&family=Raleway:wght@500;700;900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/65b0fdf199.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
</head>
<body>
    <div id="container">
        <section id="content">
            <div class="left">
                <img src="img/burger.png" alt="Menu" class="menuicon">
                <div class="navlinks">
                    <a href="index.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="88" height="60" viewBox="0 0 88 60">
                            <text id="PH_" data-name="PH!" transform="translate(0 47)" fill="#fff" font-size="50" font-family="Rubik-BoldItalic, Rubik" font-weight="700" font-style="italic">
                                <tspan x="0" y="0">PH!</tspan>
                            </text>
                        </svg>
                    </a>
                    <?php 
                        Users::getLoggedInUser();
                    ?>
                    <div>
                        <ul>
                            <li><a href="allposts.php">ALL POSTS</a></li>
                            <li><a href="register.php">REGISTER</a></li>
                            <li><a href="login.php">LOG IN</a></li>
                            <li><a href="logout.php">LOG OUT</a></li>
                        </ul>
                    </div>
                    <div class="display" id="checkbox-container">
                        <p>Display Mode: </p>
                        <input type="checkbox" class="checkbox" id="checkbox">
                        <label for="checkbox" class="label">
                            <i class="fas fa-sun"></i>
                            <i class="fas fa-moon"></i>
                            <span class="ball"></span>
                        </label>
                    </div>
                    <div class="users">
                        <h3>All Users</h3>
                        <ul class="usernamelist">
                            <?php
                                Users::loadUsers();
                            ?>
                        </ul>
                    </div>
                    <p class="copyright">© 2021 Posthouse, Inc.</p>
                </div>
            </div>