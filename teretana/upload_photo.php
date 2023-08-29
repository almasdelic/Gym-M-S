<?php

$photo = $_FILES['photo'];  // photo je iz koda JS - paramName

$photo_name = basename($photo['name']); // uzimamo ime slike

$photo_path = 'member_photos/' . $photo_name; // sacuvamo sliku korisnika u folder

$allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

$ext = pathinfo($photo_name, PATHINFO_EXTENSION); // uzimamo ekstenziju naseg fajla

if(in_array($ext, $allowed_ext) && $photo['size'] < 2000000) {
    move_uploaded_file($photo['tmp_name'], $photo_path);

    echo json_encode(['success' => true, 'photo_path' => $photo_path]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid file']);
}