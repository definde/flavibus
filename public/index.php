<?

require_once("../vendor/autoload.php");

$dispatcher = new Dba\Flavia\SimpleDispatch;
$dispatcher->dispatch($_SERVER);

