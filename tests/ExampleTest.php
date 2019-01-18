<?php

namespace Tests;

use Auth\SimpleSignAuth;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    /**
     * @node_name test sign
     * @link
     * @desc
     */
    public function testSimpleSign()
    {
        $params = [
            'signKey'      => 'a',
            'expired'      => 60,
            'expiredCheck' => true
        ];
        $auth   = new SimpleSignAuth($params);
        $data   = [
            'a' => 1,
            'b' => [
                'a' => 1
            ]
        ];

        $t = time();
        echo "t:" . $t . PHP_EOL;

        $sign = $auth->makeSign($t, $data);
        echo "sign:" . $sign . PHP_EOL;

        $r1    = $auth->verifySign($t, $sign, $data);
        $error = $auth->getError();
        echo PHP_EOL . "error1:" . $error . PHP_EOL;
        $this->assertTrue($r1);

        $t2    = 1547806237;
        $sign2 = 'decc4fa7cf200bbcf7164464d977018e';
        $r2    = $auth->verifySign($t2, $sign2, $data);
        $error = $auth->getError();
        echo PHP_EOL . "error2:" . $error . PHP_EOL;
        $this->assertTrue($r2);
    }
}
