<?php

foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $tmp_name);

    if (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'])) {
        throw new Exception("Plik nie jest odpowiedniego typu danych");
    }
    if ($_FILES['files']['size'][$key] > 7 * 1024 * 1024) {
        throw new Exception("Plik jest za duży");
    }
    if (getimagesize($tmp_name) === false) {
        throw new Exception("Plik nie jest zdjęciem");
    }
}


?>