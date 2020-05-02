<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Command\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Ulrack\Command\Common\Command\InputInterface;
use Ulrack\Command\Factory\InputFactory;

/**
 * @coversDefaultClass \Ulrack\Command\Factory\InputFactory
 * @covers \Ulrack\Command\Component\Command\Input
 */
class InputFactoryTest extends TestCase
{
    /**
     * @covers ::create
     * @covers ::prepareArguments
     *
     * @return void
     */
    public function testCreate(): void
    {
        $subject = new InputFactory();

        $arguments = [
            // Will be stripped
            'bin/ulrack',
            // Will be a command
            'foo',
            // Spaced variable
            '--bar',
            'qux',
            // Flag
            '--flag',
            // Spaced array variable
            '--baz[]',
            'bar',
            // One string variable
            '--foo=bar',
            // One string array variable
            '--baz[]=foo'
        ];

        $result = $subject->create($arguments);

        $this->assertInstanceOf(
            InputInterface::class,
            $result
        );

        $this->assertEquals(
            ['foo'],
            $result->getCommand()
        );

        $this->assertEquals(
            [
                'bar' => 'qux',
                'baz' => ['bar', 'foo'],
                'foo' => 'bar'
            ],
            $result->getParameters()
        );

        $this->assertEquals(
            ['flag'],
            $result->getFlags()
        );
    }
}
