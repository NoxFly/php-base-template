<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


class ApiService {
	protected $baseUri = '/';
	protected $baseUrl = 'api/';
	/** @var string $token */
	protected $token = NULL;
	
	/**
	 * @param string $baseAppUri
	 */
	function __construct($baseAppUri) {
		$this->baseUri = preg_replace('/^((?:(?:https?)?:\/\/)?(?:[a-zA-Z0-9\-\/\.]+)\/)[a-zA-Z0-9\-]+\/?$/', '$1', $baseAppUri);
	}

	private function prepareHeaders($headers) {
		$flattened = array();
	  
		foreach($headers as $key => $header) {
		  	if (is_int($key)) {
				$flattened[] = $header;
		  	} else {
				$flattened[] = $key.': '.$header;
			}
		}
	  
		return implode("\r\n", $flattened);
	}

	public function getBaseUri() {
		return $this->baseUri . $this->baseUrl;
	}

	/**
	 * @param string $method
	 * @param string $endpointUrl
	 * @param array $body
	 */
	public function fetch($method, $endpointUrl, $body=[]) {
		if($method !== 'GET' && $method !== 'POST' && $method !== 'PUT' && $method !== 'DELETE') {
			throw new Exception('Method Not Allowed');
		}

		$headers = array(
			'Content-type: application/json'
		);

		if($this->token !== NULL) {
			array_push($headers, 'X-Auth-Token: ' . $this->token);
		}

		$options = array(
			'http' => array(
				'method' => $method
			)
		);

		if($method === 'POST' || $method === 'PUT') {
			$content = http_build_query($body);
			$options['http']['content'] = $content;
		}

		$options['http']['header'] = $this->prepareHeaders($headers);

		$context  = stream_context_create($options);
		$url = $this->getBaseUri() . $endpointUrl;

		$res = file_get_contents($url, false, $context);

		if($res === false) {
			throw new Exception('Failed to get data from ' . $url);
		}

		try {
			$res = json_decode($res, true);
			return $res;
		}
		catch(Exception $error) {
			throw new Exception('Failed to decode JSON from response.\n' . $res);
		}
	}

	/**
	 * @param string $token
	 */
	public function setToken($token) {
		$this->token = $token;
	}
}