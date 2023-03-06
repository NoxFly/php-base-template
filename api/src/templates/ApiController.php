<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


require_once(PATH_ENGINE_TEMPLATES . 'Controller.php');
require_once(PATH_GUARDS . 'API.guard.php');


abstract class ApiController extends Controller {
	protected $status = 200;
	protected $data = [];
	

	function __construct() {
		$this->guard = new ApiGuard();
	}

	/**
	 * Ensure to always send a JSON as response.
	 * Wraps your method in a try-catch.
	 * When an Exception is bumped, always sends a JSON
	 * with this format :
	 * 
	 * {
	 * 	"status": {
	 * 		"status_code": int,
	 * 		"message": string,
	 * 		"details"?: mixed
	 * 	}
	 * }
	 * 
	 * In the method of the controller, you only have to :
	 * - call $this->sendData($req, $res, 'methodsName') in the GET/POST/PUT/DELETE method that receives the request.
	 * - do a throw new Exception() in your called method.
	 * 
	 * The Exception's parameter is a string that can :
	 * - only contains the status code (e.g: '404').
	 * - contains the status code followed by a detailed message, separated by a comma (e.g: '404,Unknown User').
	 * 
	 * @param stdClass $req
	 * @param ApiSite $res
	 * @param string $fn
	 */
	protected function sendData($req, $res, $fn) {
		try {
			$this->{$fn}($req, $res);
			$res->status($this->status)->json($this->data);
		}
		catch(Exception $e) {
			$ee = explode(',', $e->getMessage());

			if(count($ee) === 1) {
				if(is_numeric($ee[0])) {
					$res->api()->sendErrorResponse($res, intval($ee[0]));
				} else {
					$res->api()->sendErrorResponse($res, 500);
				}
			}
			else {
				$res->api()->sendErrorResponse($res, intval($ee[0]), $ee[1]);
			}
		}
	}
}