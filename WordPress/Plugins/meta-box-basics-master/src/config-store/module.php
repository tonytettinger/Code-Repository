<?php
/**
 * ConfigStore Module - bootstrap file.
 *
 * @license     GNU-2.0+
 */
namespace AntalTettinger\ConfigStore;
function autoload() {
    include __DIR__ . '/api.php';
    include __DIR__ . '/internals.php';
}

autoload();