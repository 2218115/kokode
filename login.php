<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | KoKode</title>

    <link rel="stylesheet" href="./styles/base.css">

    <style>
        body {
            backdrop-filter: brightness(150%);
            background-image: url('./images/background.jpg');
            backdrop-filter: blur(8px);
            color: white;
            background-size: cover;
        }

        form {
            padding: 2rem;
            border: 1px solid black;
        }

        .form {
            padding: 2rem;
            border: 1px solid #461111;
        }

        .form__label {
            display: block;
            font-size: 1.2rem;
            margin-bottom: 0.4rem;
        }

        .title {
            text-align: center;
            margin-bottom: 4rem;
        }

        .flex--center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .form__input__group {
            margin-top: 0.4rem;
            margin-bottom: 0.4rem;
        }
    </style>
</head>

<body class="flex--center">
    <main class="container">
        <h1 class="title">Masuk ke akun kamu, iya Kamu🤗</h1>
        <form action="./auth_process.php" class="form" method="POST">
            <div class="form__input__group">
                <label for="email" class="form__label">Email</label>
                <input type="email" name="email" id="input_email" class="input mb1">
            </div>
            <div class="form__input__group">
                <label for="password" class="form__label">Katasandi</label>
                <input type="password" name="password" id="input_password" class="input mb1">
            </div>
            <button type="submit" name="login" class="button button--primary button--large" name="login">Masuk</button>
            <div class="form__input__group">
                <p>Kamu belum punya akun?🥲, ayo sini <a href="register.php" class="link">Daftar</a></p>
            </div>
        </form>
    </main>
    <footer class="container">
        <p>
            Copyright Website @makrusali
        </p>
    </footer>
</body>

</html>