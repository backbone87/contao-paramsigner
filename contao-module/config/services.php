<?php

/**
 * @copyright	backboneIT | Oliver Hoff 2014
 * @author		Oliver Hoff <oliver@hofff.com>
 * @license		commercial
 */

$container['bbit.util.ps'] = $container->share(function($container) {
	return new \bbit\contao\util\ps\ParameterSigner($GLOBALS['TL_CONFIG']['encryptionKey']);
});
