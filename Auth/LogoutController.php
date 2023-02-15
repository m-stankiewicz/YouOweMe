<?php
class LogoutController {
    public function logout() {
        unset($_SESSION['user']);
    }
}
?>