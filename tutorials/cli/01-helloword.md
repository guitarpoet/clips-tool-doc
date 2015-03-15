# CLI - Tutorial 1 - Hello world

Using [Clips Tool](http://www.github.com/guitarpoet/clips-tool), you can create a
powerful command line application using just few lines of code.

## Requirements

You'll need a little depenency before use Clips Tool.

 * PHP >= 5.3.0
 * [php-clips](http://github.com/guitarpoet/php-clips): Clips Rule Engine's PHP port

And, if you want to use the full power of the Clips Tool command line, you'll need
some optional PHP plugins:
 * php-posix: a PHP interface to those functions defined in the IEEE 1003.1 (POSIX.1) standards document which are not accessible through other means
 (used for user detection -- for interaction wizzards)
 * php-intl: Internationalization extension implements ICU library functionality in PHP.
 (used for locale detection -- for i18n support)

## Step 1, setup the Clips Tool (for Linux or Mac OS X)

1. Clone the clips-tool's code

Find any folder you like (say /opt/local/src), Run command(be sure you have the file
permission, if you don't have the permission, use sudo.):

	$git clone https://github.com/guitarpoet/clips-tool.git

2. Install the depenencies using composer (If you don't have composer, see how to install it at [here](http://TODO.com))

	$cd {clips tool home} && composer.phar install

3. Add the path of clips script to yor PATH environment variable, or link the script into your bin folder
	
	$sudo ln -s {clips tool home}/clips /usr/local/bin/clips

## Step 1++, steup the Clips Tool using composer

If you don't want to install a system wide Clips Tool, you can install the Clips Tool
using Composer by project(though I don't think this is a good idea, at least for command
line application).

Using composer to create a composer.json
	
	$composer init

Add the depenedency, just add the code below to your composer dependency section
	
	"guitarpoet"/clips-tool:"*"

After the composer done the downloading and code generating, you'll find clips script
locate in vendor/bin. You can use it like this:

	$vendor/bin/clips

## Step 2, Test if clips is installed

Just run the command:

	$clips version

And you'll get the version of the clips

## Step 3, create the hello command

Pick a folder you want to use(say ~/clips-tool-play/hello), and run the wizzard

	$clips generate command 

Then follow the wizzard to generate the code, the code should locate at ./commands/HelloCommand.php the code should be something like this:

	<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

	use Clips\Command;

	/**
	 * This is a simple command
	 * 
	 * @author Jack
	 * @version 1.0
	 * @date Sun Mar  8 21:31:40 2015
	 */
	class HelloCommand extends Command {
		public function execute($args) {
		}
	}

And this is your first command.

If you run this command

	$clips hello

You won't get anything, since you haven't write anything about who the command should work.
	
So, let's change the command file to this.

	<?php in_array(__FILE__, get_included_files()) or exit("No direct sript access allowed");

	use Clips\Command;

	/**
	 * This is a simple command
	 * 
	 * @author Jack
	 * @version 1.0
	 * @date Sun Mar  8 21:31:40 2015
	 */
	class HelloCommand extends Command {
		public function execute($args) {
			$this->output("Hello World!");
		}
	}
	

## Step 3++, make it further

Pretty simple, huh?

But not very useable, let's take it a step further:

	<?php in_array(__FILE__, get_included_files()) or exit("No direct sript access allowed");

	use Clips\Command;

	/**
	 * This is a simple command
	 * 
	 * @author Jack
	 * @version 1.0
	 * @date Sun Mar  8 21:31:40 2015
	 */
	class HelloCommand extends Command {
		public function execute($args) {
			$name = Clips\get_default($args, 0, 'World');
			$this->output("Hello $name!");
		}
	}

Then you can run the command like this:

	$clips hello world

Will get this result

	Hello world!

And if you don't add the argument to the command, like this:

	$clips hello

Will get this result

	Hello World!

Though this example of get_default function is very simple, 
but it follows the philosophy of Clips Tool:

6. Use reasonable configurations by default, and let user change it as he like
