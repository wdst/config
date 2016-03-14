<?php

require __DIR__ . '/../Config.php';

$config = new wdst\config\Config(__DIR__ . '/config.ini');

function test_ini($name, $result)
{
    $test = "== $name ==" . PHP_EOL;
    $test .= print_r($result, 1) . PHP_EOL;
    $test .= "------------" . PHP_EOL;
    return $test;
}

print "====== INI ======" . PHP_EOL;

print test_ini("All", $config->get());
print test_ini("Section", $config->get('section'));
print test_ini("Key", $config->get('section', 'key'));
print test_ini("Default", $config->get('section', 'key_no', 'default'));

try{
    $config->get('no_section');
}catch(Exception $e){
    print test_ini("Error no_section", $e->getMessage());
}

try{
    $config->get('no_section');
}catch(Exception $e){
    print test_ini("Error no_section", $e->getMessage());
}

try{
    $config = new wdst\config\Config(__DIR__ . '/config_no.ini');
}catch(Exception $e){
    print test_ini("Error no_file", $e->getMessage());
}

try{
    $config = new wdst\config\Config(__DIR__ . '/config.ini', 'bad_type');
}catch(Exception $e){
    print test_ini("Error type", $e->getMessage());
}

$config = new wdst\config\Config(__DIR__ . '/config.ini');
try{
    $config->filename(__DIR__ . '/config_no.ini');
    $config->get();
}catch(Exception $e){
    print test_ini("Error no_file", $e->getMessage());
}

$config = new wdst\config\Config(__DIR__ . '/config2.ini', 'ini');
try{
    $config->get();
}catch(Exception $e){
    print test_ini("Error file ini empty: ", $e->getMessage());
}

$config = new wdst\config\Config(__DIR__ . '/config.php', 'ini');
try{
    $config->get();
}catch(Exception $e){
    print test_ini("Error file ini empty: ", $e->getMessage());
}

$config = new wdst\config\Config(__DIR__ . '/config.php', 'ini');
try{
    $config->get();
}catch(Exception $e){
    print test_ini("Error 2 file ini empty: ", $e->getMessage());
}

$config = new wdst\config\Config(__DIR__ . '/config.php', 'ini');
try{
    $config->get();
}catch(Exception $e){
    print test_ini("Error 2 file ini empty: ", $e->getMessage());
}

$config = new wdst\config\Config(__DIR__ . '/config.cfg');
print test_ini("cfg", $config->get());


print "====== PHP ======" . PHP_EOL;

$config = new wdst\config\Config(__DIR__ . '/config.php');

print test_ini("All", $config->get());
print test_ini("Section", $config->get('section'));
print test_ini("Key", $config->get('section', 'key'));
print test_ini("Default", $config->get('section', 'key_no', 'default'));
