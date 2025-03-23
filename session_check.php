<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.gc_maxlifetime', 3600);
    ini_set('session.cookie_lifetime', 3600);
    
    session_start();
}

if (!isset($_SESSION['username'])) {
    echo '<script>alert("Silakan login terlebih dahulu"); window.location.href="index.php";</script>';
    exit();
}
?>