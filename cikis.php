<?php
session_start();
session_destroy(); // Sunucu tarafındaki oturumu siler
?>
<script>
    // Tarayıcı hafızasındaki verileri temizle
    localStorage.removeItem('oturum');
    localStorage.removeItem('favoriHaberler');
    
    // Ana sayfaya yönlendir
    window.location.href = 'index.php';
</script>