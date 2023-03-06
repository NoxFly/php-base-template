<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */


defined('_NOX') or die('401 Unauthorized');

// Put the types, classes, functions and variables that
// could be common to multiple projects in this folder.


/**
 * php 7.x does not have unions (for bitwise op)
 * dealing with this
 * Custom this Union as you want
 * Used everywhere, in both API side and Web side.
 * also for guards.
 * 
 * @see bitwiseAND
 */
abstract class UserType {
	const NONE = 0;
	const ANONYMOUS = 1;
	const USER = 2;
	const ADMIN = 4;
	const ALL = 7;
}

/**
 * Returns either a contains b or not.
 * @param int $a
 * @param int $b
 * @return bool
 */
function bitwiseAND($a, $b) {
	return ($a & $b) === $b;
}


/**
 * Generates random string with or without
 * - lowercases
 * - uppercases
 * - digits
 * - special characters
 * Uses PHP random_int() function.
 * 
 * See random_bytes() for another application that could be more appropriated.
 * 
 * @param int $length
 * @param bool $includeSpecial
 * @param bool $includeDigit
 * @param bool $includeUpper
 * @param bool $includeLower
 * @return string
 */
function generateRandomString(
	$length,
	$includeSpecial=false,
	$includeDigit=true,
	$includeUpper=true,
	$includeLower=true
) {
	$characters = '';

	if($includeLower) {
		$characters .= 'abcdefghijklmnopqrstuvwxyz';
	}

	if($includeUpper) {
		$characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	}

	if($includeDigit) {
		$characters .= '0123456789';
	}

	if($includeSpecial) {
		$characters .= '()[]{}-+/*|&~#_^@°=$£µ%.?,;:!§<>';
	}

	$charactersLength = mb_strlen($characters) - 1;
	$randomString = '';

	str_shuffle($characters);

	for ($i = 0; $i < $length; $i++) {
		$r = random_int(0, $charactersLength);
		$randomString .= mb_substr($characters, $r, 1);
	}

	return $randomString;
}