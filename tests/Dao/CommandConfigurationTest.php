<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Command\Tests\Dao;

use PHPUnit\Framework\TestCase;
use Ulrack\Command\Common\Dao\CommandConfigurationInterface;
use Ulrack\Command\Dao\CommandConfiguration;

/**
 * @coversDefaultClass \Ulrack\Command\Dao\CommandConfiguration
 */
class CommandConfigurationTest extends TestCase
{
    /**
     * @covers ::addCommandConfiguration
     * @covers ::getFlags
     * @covers ::getParameters
     * @covers ::getCommand
     * @covers ::hasCommand
     * @covers ::getService
     * @covers ::getCommands
     * @covers ::getDescription
     * @covers ::__construct
     *
     * @return void
     */
    public function testConfiguration(): void
    {
        $service = 'service';
        $description = 'description';
        $parameters = ['parameter' => 'value'];
        $flags = [
            [
                'long' => 'flag',
                'short' => 'f',
                'description' => 'A flag'
            ]
        ];

        $allFlags = array_merge(
            $flags,
            (new CommandConfiguration())->getFlags()
        );

        $subject = new CommandConfiguration($service, $description, $parameters, $flags);

        $this->assertEquals($allFlags, $subject->getFlags());
        $this->assertEquals($parameters, $subject->getParameters());
        $this->assertEquals(false, $subject->hasCommand('command'));
        $this->assertEquals($service, $subject->getService());
        $this->assertEquals([], $subject->getCommands());
        $this->assertEquals($description, $subject->getDescription());

        $command = 'command';
        $configuration = $this->createMock(CommandConfigurationInterface::class);
        $subject->addCommandConfiguration($command, $configuration);

        $this->assertEquals(true, $subject->hasCommand('command'));
        $this->assertEquals($configuration, $subject->getCommand('command'));
        $this->assertEquals([$command], $subject->getCommands());
    }
}
