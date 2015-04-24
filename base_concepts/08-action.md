# Base Concepts - Actions

## The Action Concept for Clips Tool

The Action object is an abstraction object of user actions, in most case, the user interaction with the action object will act as the click on html button or link.

in Clips Tool, there are 3 kind of actions:

###S erver Side Action

The action that needs server side processing, mostly, this action refers to an http request that will be handled by controller's method.

For this kind of action, there must be 3 value for each action, label, uri and arguments, the uri should be the server relative uri something like this "user/create", and
the other required value for this action is the arguments(mostly an array)

### Client Side Action

The action that needs client side processing, mostly, the JavaScript operation when this action(act as button or link) clicked.

For this kind of action, there must be 3 value for each action, label, action script and data, the action script should be the JavaScript that will be triggered when this

action element is clicked(mostly button or link), in this script, you can use this to refer to the action element.

The data is the data attribute that bind to this action element, so that you can access to any data in the action script by using [jQuery](https://code.jquery.com/)'s data function.

### Exteral Action

This is the most simple action. It only needs label and an external url. User will get redirect to the external page when clicking the action element.
