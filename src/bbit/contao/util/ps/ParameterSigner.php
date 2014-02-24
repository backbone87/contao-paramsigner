<?php

/**
 * @copyright	backboneIT | Oliver Hoff 2014
 * @author		Oliver Hoff <oliver@hofff.com>
 * @license		commercial
 */

namespace bbit\contao\util\ps;

class ParameterSigner {

	const SEPARATOR = '-';

	/** @var string */
	private $secret = '';

	/**
	 * @param string $secret
	 */
	public function __construct($secret) {
		$this->setSecret($secret);
	}

	/**
	 * @return string
	 */
	public function getSecret() {
		return $this->secret;
	}

	/**
	 * @param string $secret
	 * @return void
	 */
	public function setSecret($secret) {
		$this->secret = $secret;
	}

	/**
	 * @param array $params
	 * @param string $key
	 * @return array
	 */
	public function sign(array $params, $key = 'h') {
		unset($params[$key]);
		if($params) {
			$hash = array_keys($params);
			array_unshift($hash, static::getSignature($this->getSecret(), $params));
			$params[$key] = implode(self::SEPARATOR, $hash);
		}
		return $params;
	}

	/**
	 * @param array $params
	 * @param string $key
	 * @return boolean
	 */
	public function validate(array $params, $key = 'h') {
		$keys = explode(self::SEPARATOR, $params[$key]);
		$hash = array_shift($keys);
		$keys = array_flip($keys);
		$params = array_merge($keys, array_intersect_key($params, $keys));
		return $hash === static::getSignature($this->getSecret(), $params);
	}

	/**
	 * @param string $secret
	 * @param array $params
	 * @return string
	 */
	public static function getSignature($secret, array $params) {
		return sha1(implode($secret, str_split(serialize($params), 10)));
	}

}
