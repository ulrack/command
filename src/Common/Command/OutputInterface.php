<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Command\Common\Command;

use GrizzIt\Task\Common\TaskListInterface;
use Ulrack\Cli\Common\Generator\FormGeneratorInterface;

interface OutputInterface
{
    /**
     * Writes the output to the user.
     *
     * @param string $input
     * @param string $style
     *
     * @return void
     */
    public function write(string $input, string $style = 'text'): void;

    /**
     * Writes the output in a line to the user.
     *
     * @param string $input
     * @param string $style
     *
     * @return void
     */
    public function writeLine(string $input, string $style = 'text'): void;

    /**
     * Writes a mutable line to the user.
     * The next writer will overwrite this line.
     *
     * @param string $input
     * @param string $style
     *
     * @return void
     */
    public function overWrite(string $input, string $style = 'text'): void;

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
     *
     * @return void
     */
    public function outputText(
        string $content,
        bool $newLine = true,
        string $styleKey = 'text'
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
     *
     * @return void
     */
    public function outputTable(
        array $keys,
        array $items,
        string $tableCharacters = 'table-characters',
        string $style = 'table-style',
        string $boxStyle = 'table-box-style',
        string $keyStyle = 'table-key-style'
    ): void;

    /**
     * Output a list.
     *
     * @param array $items
     * @param string $style
     *
     * @return void
     */
    public function outputList(
        array $items,
        string $style = 'list'
    ): void;

    /**
     * Output an explained list.
     *
     * @param array $items
     * @param string $keyStyle
     * @param string $descriptionStyle
     *
     * @return void
     */
    public function outputExplainedList(
        array $items,
        string $keyStyle = 'explained-list-key',
        string $descriptionStyle = 'explained-list-description'
    ): void;

    /**
     * Output a block.
     *
     * @param string $content
     * @param string $style
     * @param string $padding
     * @param string $margin
     *
     * @return void
     */
    public function outputBlock(
        string $content,
        string $style = 'block',
        string $padding = 'block-padding',
        string $margin = 'block-margin'
    ): void;

    /**
     * Output a progress bar.
     *
     * @param TaskListInterface $taskList
     * @param string $progressCharacters
     * @param string $textStyle
     * @param string $progressStyle
     *
     * @return void
     */
    public function outputProgressBar(
        TaskListInterface $taskList,
        string $progressCharacters = 'progress-characters',
        string $textStyle = 'progress-text',
        string $progressStyle = 'progress-bar'
    ): void;
}
