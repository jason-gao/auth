<?php

namespace Auth;

class SimpleSignAuthStatic {

	private static $signKey;
	private static $expired = 60;
	private static $expiredCheck = true;
	private static $error;


	public static function init( $params ) {
		if ( isset( $params['signKey'] ) && $params['signKey'] ) {
			self::$signKey = $params['signKey'];
		}
		if ( isset( $params['expired'] ) && $params['expired'] ) {
			self::$expired = $params['expired'];
		}
		if ( isset( $params['expiredCheck'] ) ) {
			self::$expiredCheck = $params['expiredCheck'];
		}
	}


	public static function makeSign( $time, $params = [] ) {
		$params = self::argSort( $params );
		$params = json_encode( $params, 1 );
		$sign   = md5( md5( $time . $params . self::$signKey ) );

		return $sign;
	}

	public static function verifySign( $time, $sign, $params = [] ) {
		$sign2 = self::makeSign( $time, $params );
		$now   = time();
		$diff  = $now - $time;
		if ( self::$expiredCheck && ( $diff >= self::$expired ) ) {
			self::$error = 'sign expired';

			return false;
		}
		if ( $sign2 == $sign ) {
			return true;
		}

		self::$error = 'sign invalid';

		return false;
	}

	public static function getError() {
		return self::$error;
	}

	public static function argSort( $para ) {
		ksort( $para );
		reset( $para );

		return $para;
	}

}