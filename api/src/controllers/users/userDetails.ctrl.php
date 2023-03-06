<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


require_once(PATH_TEMPLATES . 'ApiController.php');
require_once(PATH_GUARDS . 'ApiPrivileges.guard.php');


class UserDetailsController extends ApiController {
	function __construct() {
        $this->guard = new ApiPrivilegesGuard(
            UserType::ADMIN | UserType::USER,
			UserType::NONE,
			UserType::ADMIN,
			UserType::ADMIN
        );
    }

	/**
     * Shows user's details
	 * Returning codes :
     * - 200 OK
	 * - 401 Unauthorized
     * - 404 Unknown user
	 * - 500 Database error
	 * 
     * @param stdClass $req
     * @param ApiSite $res
     */
	public function GET($req, $res) {
		$this->sendData($req, $res, 'getUser');
	}

	/**
     * Creates a user in the database.
	 * Returning codes :
     * - 200 OK
	 * - 400 Missing fields
	 * - 401 Unauthorized
     * - 403 Forbidden : some unique fields are already taken
	 * - 500 Database error
	 * 
     * @param stdClass $req
     * @param ApiSite $res
     */
	public function PUT($req, $res) {
		$this->sendData($req, $res, 'createUser');
	}

	/**
     * Delete a user from the database.
	 * Returning codes :
     * - 200 OK
	 * - 401 Unauthorized
     * - 404 The user does not exist
	 * - 500 Database error
	 * 
     * @param stdClass $req
     * @param ApiSite $res
     */
	public function DELETE($req, $res) {
		$this->sendData($req, $res, 'deleteUser');
	}


    /* -------------------------------------------------------- */


	protected function getDetails($req, $res) {
		throw new Exception('204,Not Implemented');
	}

	protected function createUser($req, $res) {
		throw new Exception('204,Not Implemented');
	}

	protected function deleteUser($req, $res) {
		throw new Exception('204,Not Implemented');
	}
}
