<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\filters;

use Zicht\Itertools\filters;

class AfterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Should accept
     *
     * @param mixed $expected
     * @param mixed $input
     * @param bool $orEqual
     * @dataProvider acceptProvider
     */
    public function testAccept($expected, $input, $orEqual = false)
    {
        $filter = filters\after($expected, null, $orEqual);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter($input));
    }

    /**
     * Provides test inputs that should be accepted by the filter
     *
     * @return array
     */
    public function acceptProvider()
    {
        return [
            // Test with DateTimeInterface
            ['$expected' => new \DateTimeImmutable('2020-04-01'), '$input' => new \DateTime('2020-05-01')],
            ['$expected' => new \DateTimeImmutable('2020-04-01'), '$input' => '2020-05-01'],

            // Test with numbers
            ['$expected' => 4, '$input' => 5],
            ['$expected' => 4.5, '$input' => 5.5],
            ['$expected' => 4, '$input' => 5.5],
            ['$expected' => 4.5, '$input' => 5],

            // The same value should be accepted when $orEqual = true
            ['$expected' => new \DateTimeImmutable('2020-04-01'), '$input' => new \DateTime('2020-04-01'), '$orEqual' => true],
            ['$expected' => 4, '$input' => 4, '$orEqual' => true],
        ];
    }

    /**
     * Should reject
     *
     * @param mixed $expected
     * @param mixed $input
     * @dataProvider rejectProvider
     */
    public function testReject($expected, $input)
    {
        $filter = filters\after($expected);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertFalse($filter($input));
    }

    /**
     * Provides test inputs that should be rejected by the filter
     *
     * @return array
     */
    public function rejectProvider()
    {
        return [
            // Test with DateTimeInterface
            ['$expected' => new \DateTimeImmutable('2020-04-01'), '$input' => new \DateTime('2020-03-01')],
            ['$expected' => new \DateTimeImmutable('2020-04-01'), '$input' => '2020-03-01'],

            // Test with numbers
            ['$expected' => 4, '$input' => 3],
            ['$expected' => 4.5, '$input' => 3.5],
            ['$expected' => 4, '$input' => 3.5],
            ['$expected' => 4.5, '$input' => 3],

            // The same value should be rejected
            ['$expected' => new \DateTimeImmutable('2020-04-01'), '$input' => new \DateTime('2020-04-01')],
            ['$expected' => 4, '$input' => 4],

            // Mismatching types are rejected
            ['$expected' => new \DateTimeImmutable('2020-04-01'), '$input' => 4],
            ['$expected' => new \DateTimeImmutable('2020-04-01'), '$input' => ''],
            ['$expected' => new \DateTimeImmutable('2020-04-01'), '$input' => 'now'],
            ['$expected' => new \DateTimeImmutable('2020-04-01'), '$input' => 'non-iso-date-string'],
            ['$expected' => new \DateTimeImmutable('2020-04-01'), '$input' => ' 2020-05-01'],
            ['$expected' => new \DateTimeImmutable('2020-04-01'), '$input' => 'X2020-05-01'],
            ['$expected' => new \DateTimeImmutable('2020-04-01'), '$input' => '2020-05-01 non-iso-date-string'],
            ['$expected' => new \DateTimeImmutable('2020-04-01'), '$input' => '2020-05-01Tnon-iso-date-string'],
            ['$expected' => 4, '$input' => new \DateTimeImmutable('2020-04-01')],

            // Unsuppoted types are rejected
            ['$expected' => 'foo', '$input' => 'foo'],
        ];
    }
}
