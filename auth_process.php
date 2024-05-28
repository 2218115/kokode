<?php 
include './db_connection.php';
include './base.php';

if(isset($_POST['register'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // validasi masukan
    try {
        validate($email, "Email", ["notblank" => true]);
        validate($password, "Katasandi", ["notblank" => true, "min" => 8]);
    } catch(ValidationException $e) {
        echo '<script> 
                alert(" ' . $e->getMessage() . ' ");
                window.location = "register.php"; 
            </script>';
        return;
    }

    try {
        $statement = $conn->prepare("SELECT email, password FROM tb_pengguna WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_assoc();

        if ($data) {
            echo "  
            <script>
                    alert('Email sudah terdaftar');
                    window.location = 'register.php';
                </script>
            ";
            return;
        }
    } catch(Exception $e) {
        echo "
            <script>
                alert('Terjadi kesalahan');
                window.location = 'register.php';
            </script>
        ";        
    }


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $uuid = uuid4();

    try {
        $statement = $conn->prepare("INSERT INTO tb_pengguna (id,  email, password) VALUES (?, ?, ?)");
        $statement->bind_param("sss", $uuid, $email, $hashed_password);
        $statement->execute();

        echo "  
            <script>
                alert('Registrasi berhasil, silahkan Login');
                window.location = 'login.php';
            </script>
        ";
    } catch (Excpetion $e) {
        echo "
            <script>
                alert('Terjadi kesalahan');
                window.location = 'register.php';
            </script>
        ";      
    }

    return;
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // validasi masukan
    try {
        validate($email, "Email", ["notblank" => true]);
        validate($password, "Katasandi", ["notblank" => true]);
    } catch(ValidationException $e) {
        echo '<script> 
                alert(" ' . $e->getMessage() . ' ");
                window.location = "login.php"; 
            </script>';
        return;
    }

    try {
        $statement = $conn->prepare("SELECT id, email, password FROM tb_pengguna WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_assoc();

        if (!$data) {      
                echo "  
                <script>
                    alert('Pengguna dengan ' .$email . ' tidak di temukan');
                    window.location = 'login.php';
                </script>
            ";
            return;
        }

        $isPassowordSame = password_verify($password, $data["password"]);
        if ($isPassowordSame) {
            echo "  
                <script>
                    alert('Login berhasil');
                    window.location = 'index.php';
                </script>
            ";
            session_start();
            $_SESSION["email"] = $email;
            $_SESSION["userId"] = $data["id"];

            header("location:dashboard/index.php");
        } else {
            echo "  
                <script>
                    alert('Login gagal katasandi salah');
                    window.location = 'login.php';
                </script>
            ";
        }        
    } catch (Excpetion $e) {
        echo "
            <script>
                alert('Terjadi kesalahan');
                window.location = 'login.php';
            </script>
        ";      
    }

    return;
}

if (isset($_POST["logout"])) {
    session_start();
    session_destroy();
    header("location:index.php");
}

?>
