<?php

include 'config.php'; // konekcija na bazu

if(isset($_GET['what'])) {
    if($_GET['what'] == 'members') {
        
        $sql = "SELECT * FROM members";
        $csv_columns = [
            "member_id",
            "first_name",
            "last_name",
            "email",
            "phone_number",
            "photo_path",
            "training_plan_id",
            "trainer_id",
            "access_card_pdf_path"
        ]; 

    } else if($_GET['what'] == 'trainers') {
        
        $sql = "SELECT * FROM trainers";
        $csv_columns = [
            "trainer_id",
            "first_name",
            "last_name",
            "email",
            "phone_number"
        ];

    } else {
        echo "Nevažeči request";
        die; // kod se dalje ne izvršava
    }

    $run = $conn->query($sql);

    $results = $run->fetch_all(MYSQLI_ASSOC);

    $output = fopen('php://output', 'w'); // otvaramo neki novi fajl

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename=' . $_GET['what'] . ".csv");

    fputcsv($output, $csv_columns); // u csv file prvo idu kolone

    foreach($results as $result) { // pa idu vrijednosti
        fputcsv($output, $result);
    }

    fclose($output);
}