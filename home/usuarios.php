<?php
$page = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : 'lista-usuarios';
header("Location: form-edit-data.php?page=" . urlencode($page));
exit();
?>
