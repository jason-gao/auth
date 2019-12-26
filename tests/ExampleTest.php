<?php

namespace Tests;

use Auth\SimpleSignAuth;
use Auth\SimpleSignAuthStatic;

error_reporting( 0 ); //for coverage warning

class ExampleTest extends TestCase {
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testBasicTest() {
		$this->assertTrue( true );
	}

	/**
	 * @node_name test sign
	 * @link
	 * @desc
	 */
	public function testSimpleSign() {
		$params = [
			'signKey'      => 'a',
			'expired'      => 600,
			'expiredCheck' => true
		];
		$auth   = new SimpleSignAuth( $params );
		$data   = [
			'a' => 1,
			'b' => [
				'a' => 1
			]
		];

		$t = time();
		echo "t:" . $t . PHP_EOL;

		$sign = $auth->makeSign( $t, $data );
		echo "sign:" . $sign . PHP_EOL;

		$r1    = $auth->verifySign( $t, $sign, $data );
		$error = $auth->getError();
		echo PHP_EOL . "testSimpleSign error1:" . $error . PHP_EOL;
		$this->assertTrue( $r1 );

		$t2    = 1577353173;
		$sign2 = 'decc4fa7cf200bbcf7164464d977018e';
		$r2    = $auth->verifySign( $t2, $sign2, $data );
		$error = $auth->getError();
		echo PHP_EOL . "testSimpleSign error2:" . $error . PHP_EOL;
		$this->assertTrue( $r2 );
	}


	/**
	 * @node_name test sign
	 * @link
	 * @desc
	 */
	public function testSimpleSignAuthStatic() {
		$params = [
			'signKey'      => 'a',
			'expired'      => 3600,
			'expiredCheck' => true
		];
		SimpleSignAuthStatic::init( $params );
		$data = [
			'a' => 1,
			'b' => [
				'a' => 1
			]
		];

		$t = time();
		echo "t:" . $t . PHP_EOL;

		$sign = SimpleSignAuthStatic::makeSign( $t, $data );
		echo "sign:" . $sign . PHP_EOL;

		$r1    = SimpleSignAuthStatic::verifySign( $t, $sign, $data );
		$error = SimpleSignAuthStatic::getError();
		echo PHP_EOL . "testSimpleSignAuthStatic error1:" . $error . PHP_EOL;
		$this->assertTrue( $r1 );

		$t2    = 1577354392;
		$sign2 = 'f0ad827dd491affe0e426ec4986d674f';
		$r2    = SimpleSignAuthStatic::verifySign( $t2, $sign2, $data );
		$error = SimpleSignAuthStatic::getError();
		echo PHP_EOL . "testSimpleSignAuthStatic error2:" . $error . PHP_EOL;
		$this->assertTrue( $r2 );
	}
}
