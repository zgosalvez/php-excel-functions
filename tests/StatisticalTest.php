<?php

use \Zejesago\PhpExcelFunctions\Statistical;

class StatisticalTest extends PHPUnit_Framework_TestCase {

    /**
     * Tests max
     *
     * @return void
     * @access public
     */
    public function testMax()
    {
        $this->assertEquals(0, Statistical::max('not numeric'));
        $this->assertEquals(4, Statistical::max('4', '1', '2.5', '2.5', 'not numeric'));
        $this->assertEquals(4, Statistical::max('4', 1, 2.5, 2.5, 'not numeric'));
        $this->assertEquals(4, Statistical::max(array('4', 1, 2.5, 2.5, 'not numeric')));
        $this->assertEquals(27, Statistical::max(10, 7, 9, 27, 2));
        $this->assertEquals(27, Statistical::max(array(10, 7, 9, 27, 2)));
        $this->assertEquals(30, Statistical::max(array(10, 7, 9, 27, 2), 30));
    }

    /**
     * Tests rankAvg
     *
     * @return void
     * @access public
     */
    public function testRankAvg()
    {
        $stubs = array(
            '1010',
            1875,
            1875,
            1700,
            1700,
            1700,
            'not numeric',
        );

        $this->assertEquals(6, Statistical::rankAvg(1010, $stubs));
        $this->assertEquals(1.5, Statistical::rankAvg(1875, $stubs));
        $this->assertEquals(1.5, Statistical::rankAvg(1875, $stubs));
        $this->assertEquals(4, Statistical::rankAvg(1700, $stubs));
        $this->assertEquals(4, Statistical::rankAvg('1700', $stubs));
        $this->assertEquals(4, Statistical::rankAvg('1700', $stubs));
        $this->assertFalse(Statistical::rankAvg('not numeric', $stubs));

        $this->assertEquals(1, Statistical::rankAvg('1010', $stubs, 1));
        $this->assertEquals(5.5, Statistical::rankAvg(1875, $stubs, -1));
        $this->assertEquals(5.5, Statistical::rankAvg(1875, $stubs, -5.5));
        $this->assertEquals(3, Statistical::rankAvg(1700, $stubs, true));
        $this->assertEquals(3, Statistical::rankAvg('1700', $stubs, 'testing'));
        $this->assertEquals(3, Statistical::rankAvg('1700', $stubs, 'false'));
    }

    /**
     * Tests rankEq
     *
     * @return void
     * @access public
     */
    public function testRankEq()
    {
        $stubs = array(
            '1010',
            1875,
            1875,
            1700,
            1700,
            1700,
            'not numeric',
        );

        $this->assertEquals(6, Statistical::rankEq(1010, $stubs));
        $this->assertEquals(1, Statistical::rankEq(1875, $stubs));
        $this->assertEquals(1, Statistical::rankEq(1875, $stubs));
        $this->assertEquals(3, Statistical::rankEq(1700, $stubs));
        $this->assertEquals(3, Statistical::rankEq('1700', $stubs));
        $this->assertEquals(3, Statistical::rankEq('1700', $stubs));
        $this->assertFalse(Statistical::rankEq('not numeric', $stubs));

        $this->assertEquals(1, Statistical::rankEq('1010', $stubs, 1));
        $this->assertEquals(5, Statistical::rankEq(1875, $stubs, -1));
        $this->assertEquals(5, Statistical::rankEq(1875, $stubs, -5.5));
        $this->assertEquals(2, Statistical::rankEq(1700, $stubs, true));
        $this->assertEquals(2, Statistical::rankEq('1700', $stubs, 'testing'));
        $this->assertEquals(2, Statistical::rankEq('1700', $stubs, 'false'));

        $stubs = array(
            7,
            3.5,
            3.5,
            1,
            2,
        );

        $this->assertEquals(3, Statistical::rankEq(3.5, $stubs, 1));
        $this->assertEquals(5, Statistical::rankEq(7, $stubs, 1));
        $this->assertEquals(0.5, ((
            count($stubs) + 1 - Statistical::rankEq(3.5, $stubs, 0) - Statistical::rankEq(3.5, $stubs, 1)
            ) / 2));
        $this->assertEquals(0, ((
            count($stubs) + 1 - Statistical::rankEq(2, $stubs, 0) - Statistical::rankEq(2, $stubs, 1)
            ) / 2));
    }

}
