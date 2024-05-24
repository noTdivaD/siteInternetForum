<?php
class EmailConfirmationErrorController {
    public function index() {
        require_once BASE_PATH . '/app/view/email_verification_failed.php';
    }
}
