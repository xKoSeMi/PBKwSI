<php session_start(); ?>

    <html>

    <head>
        <style>
            .button {
                background-color: #4CAF50;
                border: none;
                color: white;
                padding: 32px 48px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 24px;
                margin: 4px 2px;
                transition-duration: 0.4s;
                border-radius: 15px;
                cursor: pointer;
            }

            .button1 {
                background-color: white;
                color: black;
                border: 4px solid #4CAF50;
            }

            .button1:hover {
                background-color: #4CAF50;
                color: white;
            }

            ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                background-color: #333;
            }

            li {
                float: left;
            }

            li a {
                display: block;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

            li a:hover:not(.active) {
                background-color: #111;
            }

            .active {
                background-color: #4CAF50;
            }

            .container {
                height: 100%;
                position: relative;
            }

            .center {
                margin: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
            }

            .text {
                display: block;
                color: white;
                text-align: center;
                padding-top: 10px;
                padding-left: 14px;
                text-decoration: none;
                font-size: 24px;
            }
        </style>
    </head>

    <body>
        <ul>
            <li class="text"> Token:
                <?php
                session_start();
                if (isset($_SESSION['accessToken']) && $_SESSION["accessToken"] !== null) {
                    echo $_SESSION['accessToken'];
                ?>
                <?php } else { ?>
                    Brak Tokenu
                <?php } ?>
            </li>
            <?php
            session_start();
            if (isset($_SESSION['accessToken']) && $_SESSION["accessToken"] !== null) { ?>
                <li style="float:right"><a class="active" href="../PBKwSI/logout.php"> Wyloguj </a></li>
            <?php } else { ?>
                <li style="float:right"><a class="active" href="https://github.com/login/oauth/authorize?client_id=e7c717a2e4b9c8d9d1d1">Zaloguj się</a>
                <?php } ?>
        </ul>
        <?php
        session_start();
        $accessToken = $_SESSION['accessToken'];

        if ($accessToken != "") {
            header("Location: user.php");
        }        ?>
        <div class="container">
            <div class="center">
                <button class="button button1" onclick="location.href='https://github.com/login/oauth/authorize?client_id=e7c717a2e4b9c8d9d1d1'" type="button">
                    Zaloguj się
                </button>
            </div>
        </div>

    </body>

    </html>