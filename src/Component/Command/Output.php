<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Command\Component\Command;

use Ulrack\Cli\Common\Io\WriterInterface;
use GrizzIt\Task\Common\TaskListInterface;
use Ulrack\Cli\Common\Theme\ThemeInterface;
use Ulrack\Cli\Common\Factory\IoFactoryInterface;
use Ulrack\Command\Common\Command\OutputModeEnum;
use Ulrack\Command\Common\Command\OutputInterface;
use Ulrack\Cli\Common\Factory\ElementFactoryInterface;
use Ulrack\Cli\Common\Generator\FormGeneratorInterface;

class Output implements OutputInterface
{
    /**
     * Contains the form generator.
     *
     * @var FormGeneratorInterface
     */
    private $formGenerator;

    /**
     * Contains the writer.
     *
     * @var WriterInterface
     */
    private $writer;

    /**
     * Contains the current theme.
     *
     * @var ThemeInterface
     */
    private $theme;

    /**
     * Contains the element factory for outputting objects.
     *
     * @var ElementFactoryInterface
     */
    private $elementFactory;

    /**
     * Determines what information will be displayed.
     *
     * @var OutputModeEnum
     */
    private $outputMode;

    /**
     * Constructor
     *
     * @param FormGeneratorInterface $formGenerator
     * @param IoFactoryInterface $ioFactory
     * @param ThemeInterface $theme
     * @param ElementFactoryInterface $elementFactory
     */
    public function __construct(
        FormGeneratorInterface $formGenerator,
        IoFactoryInterface $ioFactory,
        ThemeInterface $theme,
        ElementFactoryInterface $elementFactory
    ) {
        $this->formGenerator = $formGenerator;
        $this->writer = $ioFactory->createStandardWriter();
        $this->theme = $theme;
        $this->elementFactory = $elementFactory;
        $this->outputMode = OutputModeEnum::OUTPUT_MODE_NORMAL();
    }

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
    ): void {
        if ($this->canOutput($verbose)) {
            $style = $this->theme->getStyle($style);
            $style->apply();
            $this->writer->write($input);
            $style->reset();
        }
    }

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
    ): void {
        if ($this->canOutput($verbose)) {
            $style = $this->theme->getStyle($style);
            $style->apply();
            $this->writer->writeLine($input);
            $style->reset();
        }
    }

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
    ): void {
        if ($this->canOutput($verbose)) {
            $style = $this->theme->getStyle($style);
            $style->apply();
            $this->writer->overWrite($input);
            $style->reset();
        }
    }

    /**
     * Retrieves the form generator.
     *
     * @return FormGeneratorInterface
     */
    public function getFormGenerator(): FormGeneratorInterface
    {
        return $this->formGenerator;
    }

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
    ): void {
        if ($this->canOutput($verbose)) {
            $this->elementFactory->createText(
                $content,
                $newLine,
                $styleKey
            )->render();
        }
    }

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
    ): void {
        if ($this->canOutput($verbose)) {
            $this->elementFactory->createTable(
                $keys,
                $items,
                $tableCharacters,
                $style,
                $boxStyle,
                $keyStyle
            )->render();
        }
    }

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
    ): void {
        if ($this->canOutput($verbose)) {
            $this->elementFactory->createList(
                $items,
                $style
            )->render();
        }
    }

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
    ): void {
        if ($this->canOutput($verbose)) {
            $this->elementFactory->createExplainedList(
                $items,
                $keyStyle,
                $descriptionStyle
            )->render();
        }
    }

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
    ): void {
        if ($this->canOutput($verbose)) {
            $this->elementFactory->createBlock(
                $content,
                $style,
                $padding,
                $margin
            )->render();
        }
    }

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
    ): void {
        if ($this->canOutput($verbose)) {
            $this->elementFactory->createProgressBar(
                $taskList,
                $progressCharacters,
                $textStyle,
                $progressStyle
            )->render();
        }
    }

    /**
     * Sets the output mode.
     *
     * @param OutputModeEnum $outputMode
     *
     * @return void
     */
    public function setOutputMode(OutputModeEnum $outputMode): void
    {
        $this->outputMode = $outputMode;
    }

    /**
     * Determines whether the output can be rendered.
     *
     * @param bool $verbose
     *
     * @return bool
     */
    private function canOutput(bool $verbose): bool
    {
        if ((string) $this->outputMode !== OutputModeEnum::OUTPUT_MODE_QUIET) {
            if (
                $verbose &&
                (string) $this->outputMode === OutputModeEnum::OUTPUT_MODE_VERBOSE
            ) {
                return true;
            } elseif (!$verbose) {
                return true;
            }
        }

        return false;
    }
}
