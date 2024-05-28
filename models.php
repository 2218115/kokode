<?php



function fetchAllCategoy() {
    $statement = $conn->prepare("SELECT (id, name) FROM tb_kategori");
    $statement->execute();
    $result = $statement->get_result();
    $data = $result->fetch_assoc();
    
    var_dump($data);
}

?>