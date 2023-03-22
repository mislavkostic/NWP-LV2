<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Document</title>
</head>
<body>
<?php
    $xml = simplexml_load_file("LV2.xml");
    $content = "<main>
    <ul> ";
    foreach ($xml->record as $profile) {
        $id = $profile->id;
        $firstName = $profile->ime;
        $lastName = $profile->prezime;
        $email = $profile->email;
        $sex = $profile->spol;
        $image = $profile->slika;
        $bio = $profile->zivotopis;
        $content .=
                "<li>
                     <div class='profile'>
                        <img src=$image alt='Profile picture' id='profilePicture'>
                        <h4>$firstName $lastName</h4>
                        <div class='personal_data'>
                            <p><b>Sex</b>: $sex</p>
                            <p><b>Email</b>: $email</p>
                            <p><b>Biography</b>: $bio</p>
                        </div>
                    </div>
                </li>";
    }
    $content .=
            "</ul>
            </main>";
    echo $content;
?>
</body>
</html>