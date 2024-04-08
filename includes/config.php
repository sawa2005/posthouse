<?php
// Starta session
session_start();

// Automatisk laddning av klassfiler
spl_autoload_register(function ($class_name) {
    include('classes/' . $class_name . '.class.php'); //sökväg till mappen för dina klasser
});

?>