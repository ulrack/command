<?php

use GrizzIt\ObjectFactory\Factory\ObjectFactory;
use Ulrack\Cli\Factory\IoFactory;
use Ulrack\Cli\Factory\FormFactory;
use Ulrack\Cli\Factory\ThemeFactory;
use Ulrack\Cli\Factory\ElementFactory;
use Ulrack\Cli\Generator\FormGenerator;
use Ulrack\Cli\Generator\ThemeGenerator;
use Ulrack\Command\Factory\InputFactory;
use Ulrack\Cli\Component\Theme\DefaultTheme;
use Ulrack\Command\Component\Command\Output;
use Ulrack\Command\Dao\CommandConfiguration;
use Ulrack\Command\Common\Command\InputInterface;
use Ulrack\Command\Common\Command\OutputInterface;
use Ulrack\Command\Component\Router\CommandRouter;
use Ulrack\Command\Common\Command\CommandInterface;
use Ulrack\Services\Common\ServiceFactoryInterface;

require_once(__DIR__ . '/../vendor/autoload.php');

$input = (new InputFactory())->create($argv);

$configuration = new CommandConfiguration();

$inputter = new CommandConfiguration(
    'services.inputter',
    'Dumps all the input you supplied to the command.'
);

$inputter->addCommandConfiguration(
    'foo',
    new CommandConfiguration(
        'services.foo',
        'A duplicate of the parent.',
        [
            // @see: configuration/schema/command.schema.json
            [
                'long' => 'parameter',
                'short' => 'p',
                'type' => 'string',
                'description' => 'A parameter',
                'required' => true
            ]
        ]
    )
);

$configuration->addCommandConfiguration(
    'inputter',
    $inputter
);

// A simplified version of the Service factory for this example.
$serviceFactory = new class implements ServiceFactoryInterface {
    /**
     * Retrieve the interpreted value of a service.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function create(string $key)
    {
        return new class implements CommandInterface {
            /**
             * Executes the command.
             *
             * @param InputInterface $input
             * @param OutputInterface $output
             *
             * @return void
             */
            public function __invoke(
                InputInterface $input,
                OutputInterface $output
            ): void {
                $output->outputText('Command: ', false);
                $output->outputText(implode(
                    ' ',
                    $input->getCommand()
                ), true, 'title');
                $output->writeLine('');

                $output->outputText('The parameters you supplied:');
                $parameters = $input->getParameters();
                if (count($parameters) > 0) {
                    $output->outputExplainedList($parameters);
                    $output->writeLine('');
                } else {
                    $output->outputText('None.');
                }

                $output->outputText('The flags you supplied:');
                $flags = $input->getFlags();
                if (count($flags) > 0) {
                    $output->outputList($flags);
                    $output->writeLine('');
                } else {
                    $output->outputText('Nothing.');
                }
            }
        };
    }

    /**
     * Adds an extension to the service factory.
     *
     * @param string $key
     * @param string $class
     * @param array $parameters
     *
     * @return void
     */
    public function addExtension(
        string $key,
        string $class,
        array $parameters = []
    ): void {
        return;
    }

    /**
     * Adds a hook to the key connected to an extension.
     *
     * @param string $key
     * @param string $class
     * @param int $sortOrder
     * @param array $parameters
     *
     * @return void
     */
    public function addHook(
        string $key,
        string $class,
        int $sortOrder,
        array $parameters = []
    ): void {
        return;
    }
};

$ioFactory = new IoFactory();
$theme = (new DefaultTheme(
    new ThemeGenerator(
        new ThemeFactory(
            $ioFactory
        )
    )
))->getTheme();

$elementFactory = new ElementFactory($theme, $ioFactory);

$formGenerator = new FormGenerator(
    new FormFactory($ioFactory, $theme),
    $elementFactory
);

$router = new CommandRouter(
    $configuration,
    $serviceFactory,
    new ElementFactory($theme, $ioFactory, true),
    $ioFactory,
    new Output(
        $formGenerator,
        $ioFactory,
        $theme,
        $elementFactory
    ),
    $formGenerator
);

exit($router->__invoke($input));
