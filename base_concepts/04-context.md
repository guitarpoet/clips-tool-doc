# Base Concepts - Context

## The Context Concept in Clips Tool

Clips Tool is a framework that implements the functions based on Context.

What is a context in Clips Tool then?

For short, a context is a global hash for storing and accessing data or objects in Clips Tool.

## Why I need context when PHP already have $GLOBALS

1. The context of Clips Tool is the same context in php-clips, so that you can access all the objects in context through clips's rules code
2. Context is referenced by Clips\Tool, can be tracked through all the execution time of the application, and will not affect any original global variables
3. Clips\Tool provides many short hand methods to manipulate context 

## Use Context as Global Variables

You can use context as global variables using this code:

	Clips\context($key);

And set the context using this code:

	Clips\context($key, $value);

## Use Context as Global Stacks

Context can be used as stacks using this code:

	Clips\context($key, $value, true);

And use this value:

	Clips\context_pop($key);

## Future of Context

Clips\Tool will provide another tree context(something like [LDAP](TODO)), and it will use TreeNode api to get and query for data.
