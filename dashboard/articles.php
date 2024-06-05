<?php
include './../db_connection.php';
include './../base.php';

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
        * {
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
            margin-bottom: 4rem;
        }



        .dash__container {
            margin-top: 1rem;
            display: grid;
            gap: 1rem;
            grid-template-columns: 1fr 1fr 1fr 1fr;
        }

        .card {
            display: flex;
            flex-direction: column;
            align-items: start;
            justify-content: space-between;
            box-sizing: border-box;
            box-shadow: 0px 0px 2px rgb(170, 170, 170);
            border-radius: 0.5rem;
            height: 14rem;
            padding: 1rem;
        }

        .card__buttons {
            display: flex;
            gap: 1rem;
        }

        .card__title {
            width: 100%;
            margin: 0;
            padding: 0;
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

        .button--brown {
            color: white;
            background-color: #461111;
        }

        button-outline-brown {
            border: 1px solid #461111;
            color: #461111;
        }

        .button--brown:hover {
            background-color: #390e0e;
        }

        .button--red {
            color: white;
            background-color: #f76464;
        }

        .button--red:hover {
            color: white;
            background-color: #c25151;
        }


        .button--blue {
            color: white;
            background-color: rgb(93, 93, 238);
        }

        .button--blue:hover {
            color: white;
            background-color: rgb(63, 63, 200);
        }

        .form_modal {
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            backdrop-filter: blur(10px);
            box-sizing: border-box;
            position: absolute;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .form_modal > form {
            box-shadow: 0px 0px 2px rgb(170, 170, 170);
            border-radius: 0.5rem;
            background-color: white;
        }

        .form_modal > form > div {
            margin: 2rem;
        }

        .form_modal > form > div > label {
            display: block;
            margin-bottom: 0.8rem;
        }

        .form_modal > form > div > input {
            box-shadow: 0px 0px 2px rgb(170, 170, 170);
            border-radius: 0.5rem;
            border: none;
            padding: 0.6rem ;
            font-size: 1.2rem;
        }

        .form_modal > form > div > textarea {
            box-shadow: 0px 0px 2px rgb(170, 170, 170);
            border-radius: 0.5rem;
            border: none;
            padding:  0.6rem ;
            font-size: 1.2rem;
        }

        .form_modal > form > div > select {
            box-shadow: 0px 0px 2px rgb(170, 170, 170);
            border-radius: 0.5rem;
            border: none;
            padding:  0.6rem ;
            font-size: 1.2rem;
        }

        .form_modal > .button__close {
            background-color: red;
            margin-right: 2rem;
            color: white;
        }
    </style>
</head>

<body>
    
    <div class="lr_container">
        <aside class="aside">
            <h1 class="aside__title">KoKode.</h1>
            <nav class="navigation">
                <ul class="navigation__list">
                    <div>
                        <li>
                            <a href="./index.php" class="navigation__items">Dashboard</a>
                        </li>
                        <li>
                            <a href="./articles.php" class="navigation__items navigation--active">Artikel</a>
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
        <div class="form_modal" id="form_modal">
            <button class="button__close" onclick="closeModal()"> X </button>
            <form action="./articles_process.php" method="POST" >
                <div>
                    <label for="title">Judul</label>
                    <input type="text" name="title" />
                </div>
                <div>
                    <label for="content">Konten</label>
                    <textarea name="content" cols="100" rows="10"> </textarea>
                </div> 
                <div>
                    <label> Kategori </label>
                    <select name="categoryId">
                    <?php 
                        $statement = $conn->prepare("SELECT * FROM tb_kategori");
                        $statement->execute();
                        $result = $statement->get_result();
                        $categories = $result->fetch_all(MYSQLI_ASSOC);
                        
                        foreach ($categories as $category) {
                            echo '<option value="'. $category["id"] .'">' . $category["name"] . '</option>';                    
                        }
                    ?>
                    </select>
                </div>
            <div>
                <button type="submit" name="insert" class="button--brown">Buat</button>
            </div>
    </form>
</div>
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
        
        <div style="display: flex; gap: 1rem;">
            <button class="button--brown" onclick="showModal()">Buat Artikel 📢</button>
            <form action="./articles_process.php" method="POST">
                <button class="button--outline-brown" type="submit" name="report"> Cetak Data Artikel</button>
            </form>
        </div>

        <div class="dash__container">
            <?php 
                
                $authorId = $_SESSION["userId"];
                
                $statement = $conn->prepare("SELECT ar.id as 'id', au.email as 'author_email', c.name as 'category', ar.title as 'title', ar.content as 'content' FROM tb_artikel as ar INNER JOIN tb_pengguna as au ON au.id = ar.id_pengguna INNER JOIN tb_kategori as c ON c.id = ar.id_category WHERE au.id = ?");
                $statement->bind_param("s", $authorId);
                $statement->execute();
                $result = $statement->get_result();
                $articles = $result->fetch_all(MYSQLI_ASSOC);
                
                $dummyId = 0;

                foreach ($articles as $article) {
                    echo '
                    <div class="card">
                    <h3 class="card__title">'. $article["title"] .'</h3>
                    <p> '. cutSentence($article["content"], 100) . '</p>
                    <div class="card__buttons">
                    <button class="button--blue" onclick="showModalEdit('. $dummyId .')">Rubah</button>
                    <form action="./articles_process.php" method="POST">
                    <input type="hidden" value="'. $article["id"] .'"  name="id"/>
                    <button type="submit" name="delete" class="button--red">Hapus</button> 
                    </form>
                    </div>
                    </div>
                    ';

                    echo '
                    <div class="form_modal" id="form_edit_'. $dummyId .'">
                        <button class="button__close" onclick="closeModalEdit('. $dummyId .')"> X </button>
                        <form action="./articles_process.php" method="POST" >
                            <input type="hidden" value="'. $article["id"] .'"  name="id"/>
                            <div>
                                <label for="title">Judul</label>
                                <input type="text" name="title" value="'. $article["title"] .'"/>
                            </div>
                            <div>
                                <label for="content">Konten</label>
                                <textarea name="content" cols="100" rows="10">'. $article["content"] .'</textarea>
                            </div> 
                            <div>
                                <label> Kategori </label>
                                <select name="categoryId">';

                    foreach ($categories as $category) {
                        if ($category == $articles["category"]) {
                            echo  '<option value="'. $category["id"] .'" selected>' . $category["name"] . '</option> ';
                        } else {
                            echo  '<option value="'. $category["id"] .'">' . $category["name"] . '</option> ';
                        }
                    }
                    
                    echo '
                                </select>
                        </div>
                    <div>
                        <button type="submit" name="update" class="button--brown">Perbarui</button>
                    </div>
                    </form>
                    </div>
                    ';
                    
                    $dummyId++;
                }
                ?>
        </div>
    </main>
</div>
<script>
    const formModal = document.getElementById("form_modal");

    function showModal() {
            formModal.style.display = "flex";
    }

    function closeModal() {
        formModal.style.display = "none";
    }

    function showModalEdit(id) {
        const el = document.getElementById(`form_edit_${id}`);
        el.style.display = "flex";
    }

    function closeModalEdit(id) {
        const el = document.getElementById(`form_edit_${id}`);
        el.style.display = "none";
    }

</script>
</body>

</html>