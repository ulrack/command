[![Build Status](https://travis-ci.com/ulrack/command.svg?branch=master)](https://travis-ci.com/ulrack/command)

# Ulrack Command

This package supplies command routing for PHP applications.

## Installation

To install the package run the following command:

```
composer require ulrack/command
```

## Usage

### [Command configuration](src/Dao/CommandConfiguration.php)
Command configuration is done through an object.
The main command configuration should be an empty instance of this class.
This main object can then be supplied to the [router](src/Common/Router/RouterInterface.php).

All sub-commands can be added to their respective command configuration instance.
This can be infinitely deep.
All command configuration instances have the following flags configured by default:
- `no-interaction`, disables the interactive reader.
- `help`, displays help text for the execution of the command.
- `verbose`, displays additional information about the execution of the command.
- `quiet`, suppresses the output of the command.
Sub-commands of a parent command can be executed by separating them by a space.

### [Router](src/Component/Router/CommandRouter.php)
The command router performs the routing of commands.
It creates an instance of the `service` and executes it.
This service object must implement the [CommandInterface](src/Common/Command/CommandInterface.php).

To find out more about how services work, see the `ulrack/services` package.

### Input and Output
The [input](src/Component/Command/Input.php) is an object which provides the input to the implementation of the command.
The [output](src/Component/Command/Output.php) provides a standard set of methods for displaying output to the user of the application.
The input instance can be created by providing the `$argv` to the `create` method of the [InputFactory](src/Factory/InputFactory.php).

### Standard commands
The package contains two standard commands for displaying a command [list](src/Command/ListCommandsCommand.php)
and showing a command [explanation](src/Command/HelpCommand.php).

## Examples

An example can be found in the [examples](examples) directory.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## MIT License

Copyright (c) GrizzIT

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
