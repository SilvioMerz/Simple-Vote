<?php
if (isset($_SESSION['USER']['LASTLOGIN']) && (time() - $_SESSION['USER']['LASTLOGIN'] > 3600)) {
session_unset();
session_destroy();
}
