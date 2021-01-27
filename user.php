<html>

<head>
    <style>
        .login {
            border: 2px solid lime;
            border-radius: 12px;
            color: lime;
            padding: 6px;
            display: inline-block;
            margin-top: 12px;
        }

        .nick {
            display: inline-block;
            font-size: 48px;
            padding-left: 12px;
        }

        .customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .customers td,
        .customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .customers tr:hover {
            background-color: #ddd;
        }

        .customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
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

        .text {
            display: block;
            color: white;
            text-align: center;
            padding-top: 10px;
            padding-left: 14px;
            text-decoration: none;
            font-size: 24px;
        }

        li a:hover:not(.active) {
            background-color: #111;
        }

        .active {
            background-color: #4CAF50;
        }
    </style>
</head>

<body>

    <ul>
            <li class="text"> Token:
            <?php
                session_start();
                echo $_SESSION['accessToken'];
            ?>
            </li>
            <?php
                session_start();
                if (isset($_SESSION['accessToken']) && $_SESSION["accessToken"] !== null) { ?>
                    <li style="float:right"><a class="active" href="../PBKwSI/logout.php"> Wyloguj </a></li>
                <?php }
                 else { ?>
                    <li style="float:right"><a class="active" href="https://github.com/login/oauth/authorize?client_id=e7c717a2e4b9c8d9d1d1">Zaloguj się</a>
                <?php } ?>
    </ul>



            <?php
            function error($msg)
            {
                $response = [];
                $response['success'] = false;
                $response['message'] = $msg;
                return json_encode($response);
            }

            session_start();
            $accessToken = $_SESSION['accessToken'];

            if ($accessToken == "") {
                die(error('Error: Invalid access token'));
            }

            $url = "https://api.github.com/user";

            $authHeader = "Authorization: token " . $accessToken;
            $userAgentHeader = "User-Agent: PBKwSI";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', $authHeader, $userAgentHeader));

            $response = curl_exec($ch);

            curl_close($ch);
            $data = json_decode($response, true);

            echo '<div class="login">';
            echo '<img src="' . $data["avatar_url"] . '" style="width:100px">';
            echo '<div class="nick"><strong>Witaj ' . $data['login'] . '</br> ID: ' . $data['id'] . '</strong></div>';
            echo '</div>';

            $repoUrl = $data['repos_url'];

            $ch2 = curl_init();
            curl_setopt($ch2, CURLOPT_URL, $repoUrl);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Accept: application/json', $authHeader, $userAgentHeader));
            $response = curl_exec($ch2);
            curl_close($ch2);

            $repo = json_decode($response, true);
            echo "<div class='container'>";

            echo '<table class="customers">
                <thead>
                <tr>
                <h2>
                    <th>Nazwa</th>
                    <th>Opis</th>
                    <th>Jezyk</th>
                    <th>Data utworzenia</th>
                    <th>Ostatnia zmiana</th>
                    <th>Obserujący</th>
                </h2>
                </tr>';

            foreach ($repo as $r) {
                echo '<tr>';
                echo '<td> <a href="' . $r['html_url'] . '">' .  $r['name'] . '</a></td>';
                echo '<td>' . $r['description'] . '</td>';
                echo '<td>' . $r['language'] . '</td>';
                echo '<td>' . $r['created_at'] . '</td>';
                echo '<td>' . $r['pushed_at'] . '</td>';
                echo '<td>' . $r['watchers_count'] . '</td>';
                echo '</tr>';
            }

            echo '</table>';
            echo "</div>";

            ?>

</body>

</html>