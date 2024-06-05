<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | KoKode</title>

    <link rel="stylesheet" href="base.css">
    <style>
        body {
            font-family: 'Noto Sans', 'Noto Sans JP', sans-serif;
        }

        .main__container {
            width: 80%;
        }

        .aside {
            box-shadow: 0px 0px 2px rgb(170, 170, 170);
            border-radius: 0.5rem;
            padding: 1rem;
            width: 18rem;
            box-sizing: border-box;
            position: fixed;
            height: 100vh;
        }

        .aside__title {
            color: #461111;
            font-weight: bolder;
            margin-bottom: 4rem;
        }

        .main__container {
            margin-left: 19rem;
            width: 100%;
        }

        .navigation {}

        .navigation__list {
            box-sizing: border-box;
            list-style: none;
            margin: 0;
            padding: 0;
            height: 100%;
            padding-bottom: 12rem;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .navigation__items {
            box-shadow: 0px 0px 2px rgb(170, 170, 170);
            border-radius: 0.5rem;
            padding: 1rem;
            color: #461111;
            background-color: white;
            text-decoration: none;
            margin-bottom: 2rem;
            display: block;
            transition-duration: 200ms;
        }

        .navigation__items:hover {
            color: white;
            background-color: #461111;
        }

        .navigation--active {
            color: white;
            background-color: #461111;
        }

        .lr_container {
            display: flex;
            min-height: 100vh;
        }

        .header {
            width: 100%;
            height: 4rem;
            box-sizing: border-box;
            box-shadow: 0px 0px 2px rgb(170, 170, 170);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 1rem;
        }

        .dash__container {
            margin-top: 4rem;
            display: grid;
            gap: 1rem;
            grid-template-columns: 1fr 1fr 1fr 1fr;
        }

        .card {
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box;
            box-shadow: 0px 0px 2px rgb(170, 170, 170);
            border-radius: 0.5rem;
            height: 14rem;
            padding: 1rem;
        }

        .card__title {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .card>p {
            font-size: 4rem;
            font-weight: bold;
        }

        .button--red {
            color: white;
            background-color: #f76464;
        }

        .button--red:hover {
            color: white;
            background-color: #c25151;
        }

        button {
            font-size: 1rem;
            padding: 1rem;
            display: block;
            border: none;
            background-color: white;
            box-shadow: 0px 0px 2px rgb(170, 170, 170);
            border-radius: 0.5rem;
            cursor: pointer;
        }

        button:hover {
            box-shadow: 0px 0px 2px rgb(139, 139, 139);
            background-color: rgb(232, 230, 230);
        }
    </style>
</head>

<body>

</body>
<div class="lr_container">
    <aside class="aside">
        <h1 class="aside__title">KoKode.</h1>
        <nav class="navigation">
            <ul class="navigation__list">
                <div>
                    <li>
                        <a href="./index.php" class="navigation__items navigation--active">Dashboard</a>
                    </li>
                    <li>
                        <a href="./articles.php" class="navigation__items">Artikel</a>
                    </li>
                    <li>
                        <a href="./categories.php" class="navigation__items">Kategori Artikel</a>
                    </li>
                </div>
                <div>
                    <li>
                        <form action="./../auth_process.php" method="POST"> <button type="submit" name="logout" class="navigation__items button--red"> Keluar </button> </form>
                    </li>
                </div>
            </ul>
        </nav>
    </aside>
    <main class="main__container">
        <header class="header">
                <h3>👤 
                <?php
                    if (isset($_SESSION["email"]) && isset($_SESSION["userId"])) {
                        echo $_SESSION["email"];
                    } else {
                        header('location:login.php');
                        return;
                    }
                ?> </h3>
        </header>

        <div class="dash__container">
            <div class="card">
                <h3 class="card__title">Jumlah Terbitan Artikel</h3>
                <p>✈️ 
                <?php
                    include './../db_connection.php';
                    $authorId = $_SESSION["userId"];

                    $statement = $conn->prepare("SELECT COUNT(ar.id) FROM tb_artikel as ar INNER JOIN tb_pengguna as au ON au.id = ar.id_pengguna WHERE au.id = ?");
                    $statement->bind_param("s", $authorId);
                    $statement->execute();
                    $result = $statement->get_result();
                    $articlesCount = $result->fetch_assoc()["COUNT(ar.id)"];
                    
                    echo $articlesCount;
                ?></p>
            </div>            
        </div>
    </main>
</div>

</html>