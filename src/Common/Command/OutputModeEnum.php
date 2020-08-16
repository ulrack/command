<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Command\Common\Command;

use GrizzIt\Enum\Enum;

/**
 * @method static OutputModeEnum OUTPUT_MODE_NORMAL()
 * @method static OutputModeEnum OUTPUT_MODE_VERBOSE()
 * @method static OutputModeEnum OUTPUT_MODE_QUIET()
 */
class OutputModeEnum extends Enum
{
    /**
     * Outputs normally.
     */
    public const OUTPUT_MODE_NORMAL = 'normal';

    /**
     * Displays additional context to the output.
     */
    public const OUTPUT_MODE_VERBOSE = 'verbose';

    /**
     * Suppresses all output.
     */
    public const OUTPUT_MODE_QUIET = 'quiet';
}
