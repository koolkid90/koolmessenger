<?

class CSRFTokens {
	public function checkCSRF() {


if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('CSRF атака обнаружена!');
	}
}
}

?>