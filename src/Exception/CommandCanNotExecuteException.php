<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Command\Exception;

use Exception;

class CommandCanNotExecuteException extends Exception
{
    /**
     * Constructor.
     *
     * @param string[] $command
     * @param string $reason
     */
    public function __construct(array $command, string $reason)
    {
        parent::__construct(
            sprintf(
                'Command "%s" can not be executed. %s',
                implode(' ', $command),
                $reason
            ),
            126
        );
    }
}
