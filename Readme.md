# Clips Tools Documentation

## What is Clips Tool?

Clips Tool is a PHP framework based on [CLIPS](http://clipsrules.sourceforge.net/) 
rule engine.

Clips Tool has 3 purposes:

1. Embed CLIPS rule engine into PHP, and make it easy to use in PHP environment
2. Use the power of the rule engine (operation based on the rules) create a  small
framework to ease the working of writting plugin and command based command line tools
3. Use the power of the rule engine to create a powerful and flexiable web 
application framework

## What is CLIPS, and why we should use it in PHP?

[CLIPS](http://clipsrules.sourceforge.net/) for me is a fast(yes, very fast) 
RETE based rule engine written in C, it use a dialect of lisp as its grammar.

Compare to these PHP based rule engines(php-rules, for example). The lisp syntax
of CLIPS is more clean and beautiful. And clips is faster than any other rule
engine written in PHP.

CLIPS's language syntax is very rich, you can even write object oriented code
in it.

And CLIPS is very stable for its long life.

For details of CLIPS, you can get it [here](http://clipsrules.sourceforge.net/WhatIsCLIPS.html).

And for the reason of writting this framework (part of it, the command line part), 
you can be found at [here](http://thinkingcloud.info/2015/01/why-we-needs-another-data-processing-framework/).

## The Main philosophy of Clips Tool

1. Simple is better than complex
2. Declearation is better than Implementation
3. Craft the model carefully, explain every detail at every corner, then let 
framework work on the rest
4. The most important feature of the framework is how easy to get hands on it
5. Don't try to restrict user's mind, let them hack, and give them tools
6. Use reasonable configurations by default, and let user change it as he like
7. Nothing is granted, every core service can be replaced as user like
8. Let the base service or library clever enough but not too clever
9. Code may behaves differently based on context
10. Everything should use rules to define, use them
11. Be extendable from the very begining
12. Dynamic typing is a good thing, let's make max use of it
13. Code format matters, even the generated code
14. To implement the functions, the less code, the better
15. Master/Detail is powerful and fundamental, please do use it a lot
16. Keep all the same kind of things together, if possible
17. Test, code and test again, write as much testcase as possible when needed
18. Don't reinvent the wheel.
