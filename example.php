<?php

include ('./vendor/autoload.php');

var_dump(json_decode( file_get_contents('keymap.default.json') ));
