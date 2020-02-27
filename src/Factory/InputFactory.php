<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Command\Factory;

use Ulrack\Command\Component\Command\Input;
use Ulrack\Command\Common\Command\InputInterface;
use Ulrack\Command\Common\Factory\InputFactoryInterface;

class InputFactory implements InputFactoryInterface
{
    /**
     * Creates a CLI command request.
     *
     * @param array $arguments The arguments passed to the command line.
     *
     * @return InputInterface
     */
    public static function create(array $arguments): InputInterface
    {
        return new Input(
            ...static::prepareArguments(
                $arguments
            )
        );
    }

    /**
     * Prepare the CLI arguments.
     *
     * @param array $arguments
     *
     * @return array
     */
    private static function prepareArguments(array $arguments): array
    {
        // Strip the script
        array_shift($arguments);

        $command = [];
        $flags = [];
        $parameters = [];
        while ($argument = array_shift($arguments)) {
            // First find out if there is a flag or parameter passed.
            if (substr($argument, 0, 1) === '-') {
                // The --parameter=value markdown is used
                if (strpos($argument, '=') > 0) {
                    $expArg = explode('=', $argument);

                    if (substr($expArg[0], -2, 2) === '[]') {
                        // Array markdown is used.
                        $parameters[rtrim(
                            ltrim($expArg[0], '-'),
                            '[]'
                        )][] = $expArg[1];

                        continue;
                    }

                    $parameters[ltrim($expArg[0], '-')] = $expArg[1];

                    continue;
                }

                // No subsequent value starting without a "-"
                // It must be a flag
                if (empty($arguments[0])
                    || substr($arguments[0], 0, 1) === '-'
                ) {
                    $flags[] = ltrim($argument, '-');

                    continue;
                }

                // There was a subsequent value starting without a "-"
                // It counts as a parameter
                $argument = ltrim($argument, '-');

                if (substr($argument, -2, 2) === '[]') {
                    // Array markdown is used.
                    $parameters[rtrim($argument, '[]')][] = array_shift(
                        $arguments
                    );

                    continue;
                }

                $parameters[$argument] = array_shift($arguments);

                continue;
            }

            // Additional arguments go into the command array
            $command[] = $argument;
        }

        return [$command, $parameters, $flags];
    }
}
