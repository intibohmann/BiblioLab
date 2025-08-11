<?php
session_start();
session_unset();
session_destroy();
header("Location: /BiblioLab/Bibliolab/App/views/auth/login.php");
exit;
