<?php
// Tar bort alla sessionsvariabler
session_start();
session_unset();
session_destroy();

// Gå till förstasidan
header("Location: index.php");
?>