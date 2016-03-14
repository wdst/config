# config
example:

$config = new wdst\config\Config(__DIR__ . '/config.ini');

$cfg = $config->get();
$cfg = $config->get('section');
$cfg = $config->get('section', 'key');
$cfg = $config->get('section', 'key_no', 'default');