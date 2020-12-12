<?php

$iniarr = parse_ini_file("keyring.ini", true);

print_r($iniarr["1"]["public"].PHP_EOL);
print_r($iniarr["1"]["private"].PHP_EOL);

