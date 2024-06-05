<?php

include './../db_connection.php';
include './../base.php';
session_start();

if(isset($_POST["delete"])) {
    try {
        $articleId = $_POST["id"];

        $statement = $conn->prepare("DELETE FROM tb_artikel WHERE tb_artikel.id = ?");
        $statement->bind_param("s", $articleId);
        $statement->execute();
        
        echo "
        <script>
        alert('Hapus berhasil');
        window.location = './articles.php';
        </script>
        ";
    } catch( Exception $e) {
        echo "
        <script>
        alert('Hapus gagal');
        window.location = './articles.php';
        </script>
        ";
    }
    
    return;
}

if(isset($_POST["insert"])) {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $categoryId = $_POST["categoryId"];
    $authorId = $_SESSION["userId"];

    // validasi masukan
    try {
        validate($title, "Judul", ["notblank" => true, "min" => 10]);
        validate($content, "Konten", ["notblank" => true, "min" => 10]);
        validate($categoryId, "kategori", ["notblank" => true]);
    } catch(ValidationException $e) {
        echo '<script> 
        alert(" ' . $e->getMessage() . ' ");
        window.location = "./articles.php"; 
        </script>';
        return;
    }
        
    try {
        $uuid = uuid4();
        $statement = $conn->prepare("INSERT INTO tb_artikel (id,  id_pengguna, id_category, title, content) VALUES (?, ?, ?, ?, ?)");
        $statement->bind_param("sssss", $uuid, $authorId, $categoryId, $title, $content);
        $statement->execute();
        
        echo "  
        <script>
        alert('Artikel berhasil di buat');
        window.location = './articles.php';
            </script>
        ";
    } catch (Excpetion $e) {
        echo "
            <script>
                alert('Artikel gagal di buat');
                window.location = './articles.php';
            </script>
        ";      
    }

    return;
}

if(isset($_POST["update"])) {
    $articleId = $_POST["id"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    $categoryId = $_POST["categoryId"];
    $authorId = $_SESSION["userId"];

    // validasi masukan
    try {
        validate($articleId, "Artikel Id", ["notblank" => true]);
        validate($title, "Judul", ["notblank" => true, "min" => 10]);
        validate($content, "Konten", ["notblank" => true, "min" => 10]);
        validate($categoryId, "kategori", ["notblank" => true]);
    } catch(ValidationException $e) {
        echo '<script> 
                alert(" ' . $e->getMessage() . ' ");
                window.location = "./articles.php"; 
            </script>';
        return;
    }
    
    try {
        $statement = $conn->prepare("UPDATE tb_artikel SET tb_artikel.title = ?, tb_artikel.content = ?, tb_artikel.id_category = ? WHERE tb_artikel.id = ? AND tb_artikel.id_pengguna = ?");
        $statement->bind_param("sssss", $title, $content, $categoryId, $articleId, $authorId);
        $statement->execute();

        echo "  
            <script>
                alert('Artikel berhasil di perbarui');
                window.location = './articles.php';
            </script>
        ";
    } catch (Excpetion $e) {
        echo "
            <script>
                alert('Artikel gagal di perbarui');
                window.location = './articles.php';
            </script>
        ";      
    }

    return;
}

require_once("./../vendor/dompdf/autoload.inc.php");

use Dompdf\Dompdf;

if(isset($_POST["report"])) {    

    try {
        $authorId = $_SESSION["userId"];
        $statement = $conn->prepare("SELECT ar.id as 'id', au.email as 'author_email', c.name as 'category', ar.title as 'title', ar.content as 'content' FROM tb_artikel as ar INNER JOIN tb_pengguna as au ON au.id = ar.id_pengguna INNER JOIN tb_kategori as c ON c.id = ar.id_category WHERE au.id = ?");
        $statement->bind_param("s", $authorId);
        $statement->execute();
        $result = $statement->get_result();
        $articles = $result->fetch_all(MYSQLI_ASSOC);

        $dompdf = new Dompdf();
        
        $html = '
            <style>
                * {
                    font-family: sans-serif;
                }

                table {
                    width: 100%;
                }

                td, th {
                    padding: 1rem;
                    border: 1px solid #dddddd;
                }
            </style>
        ';

        $html .= '<h1> Laporan Artikel ' . $articles[0]["author_email"]  . '</h1>'; 
        $html .= '<table>';
        $html .= '<thead>
                    <th>Judul Artikel</th>
                    <th>Konten Artikel</th>
                </thead>';
        $html .= '<tbody>';
        
        foreach($articles as $article) {
            $html .= '<tr>';
            $html .= '<td>' . $article["title"] . '</td>';
            $html .= '<td>' . $article["content"] . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody>';
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan-artikel.pdf');

        echo "  
            <script>
                alert('Artikel berhasil di perbarui');
                window.location = './articles.php';
            </script>
        ";
    } catch (Excpetion $e) {
        echo "
            <script>
                alert('Artikel gagal di perbarui');
                window.location = './articles.php';
            </script>
        ";      
    }

    return;
}

?>