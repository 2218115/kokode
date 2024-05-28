<?php

// https://www.uuidgenerator.net/dev-corner/php
// generator uuid
function uuid4($data = null) {
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

// helper untuk validasi masukan
class ValidationException extends Exception {}
function validate($data, $dataName, $rules) {
    foreach($rules as $rule => $value) {
        switch($rule) {
            case "min": {
                if (strlen($data) < $value) {
                    throw  new ValidationException('Gagal: ' . $dataName . ' harus lebih dari ' . $value . ' karakter');
                }
            } break;

            case "max": {
                if (strlen($data) > $value) {
                    throw  new ValidationException('Gagal: ' . $dataName . ' harus kurang dari ' . $value . 'karakter');
                }
            } break;

            case "notblank": {
                if (empty($data)) {
                    throw  new ValidationException('Gagal: ' . $dataName . ' harus di isi');
                }
            } break;            
        }
    }
}

// fungsi untuk memotong kalimat    
function cutSentence($sentence, $max) {
    if (strlen($sentence) > $max) {
        return substr($sentence, 0, $max) . ' ....';
    }
    return $sentence;
}

?>