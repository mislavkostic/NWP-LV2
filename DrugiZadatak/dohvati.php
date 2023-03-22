<?php
    session_start();
    if (!is_dir("uploads/")) {
        echo "<p>No files for decrypting.</p>";
        die();
    }
    $files = array_diff(scandir("uploads/"), array('..', '.'));
    if (count($files) === 0) {
        echo "<p>No files for decrypting</p>";
    } else {
        echo "<ul>";
        foreach ($files as $file) {
            $fileName = substr($file, 0, strlen($file) - 4);

            echo "<li> <a href=\"preuzmi.php?file=$fileName\">$fileName</a></li>";
        }
        echo "</ul>";
    }
?>



