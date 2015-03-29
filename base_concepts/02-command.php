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
