# Base Concepts - Commands

## What is a command for Clips Tool

Clips Tool begin with a framework to create command line data processing tools. So, the command
support is the base part of the Clips Tools.

A Clips Tool Command is an extension of Clips Tool, you can call your command using Clips Tool's script:
	
	clips {your command}

## How did Clips Tool find the command

Clips Tool will try to read your configurate at the configuration folders(cwd, /etc/, /etc/clips_tool, ~/.clips_tool ...),
to get the configuration of where commands folder is.

If no configuration about command is found, Clips Tool will try {your namespace}\Commands and commands folder at cwd or
Clips Tool's base path.

Say, you call the Clips Tool like this:

	clips hello world

Clips Tool will try to load command from:

1. {folder of your namespace}/Commands/HelloCommand.php
2. {cwd}/commands/hello_command.php
3. {folder of clips}/Commands/HelloCommand.php
4. {folder of clips}/commands/hello_command.php

## Input and output

The inputs of command is the command line args.

For honor philosophy 18. Don't reinvent the wheel, Clips Tool didn't provide the command line parser. You can use
the one symphony provides.

Clips Tool will just give all the command line arguments (exclude the clips tool's script and the command) to the command as the argument.

But, if you want to get the whole arguments you can add the annotation to ask for it like this:

	/**
	 * @Clips\FullArgs
	 */
	public function execute($args) {
	}

The output of the command will output to stdout like this:

	$this->output('some text');

Output function won't auto add the line break since sometimes you don't want it to add.

The return value of execute will be the shell return code of this command, if no return code is there, null will be treat as 0.

## The error handling

Command should catch every exception it will needs to handle. And report the error using error function.

## Built-in commands

### Console Command

Console command will start a CLIPS engine console in command line. You can play with it and call any functions in Clips Tool.

Usage
	clips console	

### Generate Command

Generate command is used for generating codes or other depenencies to ease the development using Clips Tool.

You can generate lots of codes using generate command(the whole scaffole, for example).

For scaffolding, see scaffolding.

Usage
	clips generate widget
	clips generate model
	clips generate controller
	clips generate pagination
	clips generate form
	clips generate view
	clips generate scaffold
	clips generate bcap

## Get Command

Get command will retrieve the depenencies that didn't distribute using composer(browser caps for example) to the cache folder to ease the development using Clips Tool.

Usage
	clips get bcap

## List Command

List command will list all the commands clips tool can execute now.

Usage
	clips list

## Markup Command

Render the markup
