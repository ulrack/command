<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Command\Common\Command;

use GrizzIt\Task\Common\TaskListInterface;
use Ulrack\Command\Common\Command\OutputModeEnum;
use Ulrack\Cli\Common\Generator\FormGeneratorInterface;

interface OutputInterface
{
    /**
     * Writes the output to the user.
     *
     * @param string $input
     * @param string $style
     * @param bool $verbose
     *
     * @return void
     */
    public function write(
        string $input,
        string $style = 'text',
        bool $verbose = false
    ): void;

    /**
     * Writes the output in a line to the user.
     *
     * @param string $input
     * @param string $style
     * @param bool $verbose
     *
     * @return void
     */
    public function writeLine(
        string $input,
        string $style = 'text',
        bool $verbose = false
    ): void;

    /**
     * Writes a mutable line to the user.
     * The next writer will overwrite this line.
     *
     * @param string $input
     * @param string $style
     * @param bool $verbose
     *
     * @return void
     */
    public function overWrite(
        string $input,
        string $style = 'text',
        bool $verbose = false
    ): void;

    /**
     * Retrieves the form generator.
     *
     * @return FormGeneratorInterface
     */
    public function getFormGenerator(): FormGeneratorInterface;

    /**
     * Output a text element.
     *
     * @param string $content
     * @param bool $newLine
     * @param string $styleKey
     * @param bool $verbose
     *
     * @return void
     */
    public function outputText(
        string $content,
        bool $newLine = true,
        string $styleKey = 'text',
        bool $verbose = false
    ): void;

    /**
     * Outputs a table.
     *
     * @param string[] $keys
     * @param array $items
     * @param string $tableCharacters
     * @param string $style
     * @param string $boxStyle
     * @param string $keyStyle
     * @param bool $verbose
     *
     * @return void
     */
    public function outputTable(
        array $keys,
        array $items,
        string $tableCharacters = 'table-characters',
        string $style = 'table-style',
        string $boxStyle = 'table-box-style',
        string $keyStyle = 'table-key-style',
        bool $verbose = false
    ): void;

    /**
     * Output a list.
     *
     * @param array $items
     * @param string $style
     * @param bool $verbose
     *
     * @return void
     */
    public function outputList(
        array $items,
        string $style = 'list',
        bool $verbose = false
    ): void;

    /**
     * Output an explained list.
     *
     * @param array $items
     * @param string $keyStyle
     * @param string $descriptionStyle
     * @param bool $verbose
     *
     * @return void
     */
    public function outputExplainedList(
        array $items,
        string $keyStyle = 'explained-list-key',
        string $descriptionStyle = 'explained-list-description',
        bool $verbose = false
    ): void;

    /**
     * Output a block.
     *
     * @param string $content
     * @param string $style
     * @param string $padding
     * @param string $margin
     * @param bool $verbose
     *
     * @return void
     */
    public function outputBlock(
        string $content,
        string $style = 'block',
        string $padding = 'block-padding',
        string $margin = 'block-margin',
        bool $verbose = false
    ): void;

    /**
     * Output a progress bar.
     *
     * @param TaskListInterface $taskList
     * @param string $progressCharacters
     * @param string $textStyle
     * @param string $progressStyle
     * @param bool $verbose
     *
     * @return void
     */
    public function outputProgressBar(
        TaskListInterface $taskList,
        string $progressCharacters = 'progress-characters',
        string $textStyle = 'progress-text',
        string $progressStyle = 'progress-bar',
        bool $verbose = false
    ): void;

    /**
     * Sets the output mode.
     *
     * @param OutputModeEnum $outputMode
     *
     * @return void
     */
    public function setOutputMode(OutputModeEnum $outputMode): void;
}
