<?php

include './../db_connection.php';
include './../base.php';
session_start();

if(isset($_POST["delete"])) {
    try {
        $kategoriId = $_POST["id"];

        $statement = $conn->prepare("DELETE FROM tb_kategori WHERE tb_kategori.id = ?");
        $statement->bind_param("s", $kategoriId);
        $statement->execute();

        
        echo "
        <script>
        alert('Hapus berhasil');
        window.location = './categories.php';
        </script>
        ";
    } catch( Exception $e) {
        echo "
        <script>
        alert('Hapus gagal, kategori sudah terpakai di artikel..');
        window.location = './categories.php';
        </script>
        ";
    }
    
    return;
}

if(isset($_POST["insert"])) {
    $name = $_POST["name"];

    // validasi masukan
    try {
        validate($name, "Nama Kategori", ["notblank" => true, "min" => 3]);
    } catch(ValidationException $e) {
        echo '<script> 
        alert(" ' . $e->getMessage() . ' ");
        window.location = "./categories.php"; 
        </script>';
        return;
    }
        
    try {
        $uuid = uuid4();
        $statement = $conn->prepare("INSERT INTO tb_kategori (id,  name) VALUES (?, ?)");
        $statement->bind_param("ss", $uuid, $name);
        $statement->execute();
        
        echo '  
        <script>
        alert("Kategori Artikel berhasil di buat");
        window.location = "./categories.php";
            </script>
        ';
    } catch (Excpetion $e) {
        echo '
            <script>
                alert("Kategori Artikel gagal di buat");
                window.location = "./categories.php";
            </script>
        ';      
    }

    return;
}

if(isset($_POST["update"])) {
    $categoryId = $_POST["id"];
    $name = $_POST["name"];

    // validasi masukan
    try {
        validate($categoryId, "Kategori Id", ["notblank" => true]);
        validate($name, "Nama Kategori", ["notblank" => true, "min" => 3]);
    } catch(ValidationException $e) {
        echo '<script> 
                alert(" ' . $e->getMessage() . ' ");
                window.location = "./categories.php";
            </script>';
        return;
    }
    
    try {
        $statement = $conn->prepare("UPDATE tb_kategori SET name = ? WHERE id = ?");
        $statement->bind_param("ss", $name, $categoryId);
        $statement->execute();
        
        echo "  
            <script>
                alert('Kategori Artikel berhasil di perbarui');
                window.location = './categories.php';
            </script>
        ";
    } catch (Excpetion $e) {
        echo "
            <script>
                alert('Kategori Artikel gagal di perbarui');
                window.location = './categories.php';
            </script>
        ";      
    }

    return;
}

?>