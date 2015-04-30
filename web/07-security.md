# Web Development - Security

## The Design Guide Lines of Clips Tool Security

The security engine design for Clips Tool follow the guide lines below:

1. Security facility should have nothing with the code of controller, view or models
2. User can change security configurations in the runtime, without change any code of controller, view or model
3. Administrator can choose which [action]({{siteurl "base_concepts/08-action"}}) can be executed(in client and server) using security configuration
4. The security configuration should be rule based, and configured or tested using session or models
5. Security configuration can choose which view element to be shown or choose which state to shown(for example, which form element to be shown, or which should be readonly or hidden), security configuration should have the ability to manipulate the [pagination]({{siteurl "base_concepts/07-pagination"}}), to controll which column should be shown or hide

## How To Use It

If you want to use security facility of Clips Tool in your web application. You should first configure the security filter to your filter chain, like this:

	"filters": ["Security", "Rules", "Form", "Scss", "Css", "SmartyView", "MustacheView", "JsonView", "DirectView"]

And, then, you can create a rule file named security.rules in your application's rules folder(application/rules).

With content like this:

	(load-rules "/rules/security_base.rules"); This will load default security functions
	(defrule must-login-to-see-dashboard
		(uri-segs $?segs)
		(test (eq (nth$ 1 $?segs) "dashboard"))
		(test (not (php_call "Clips\\Web\\user_is_logged_in")))
		=>
		(reject-cause "require_login" "Must login to view dashboard pages")
	) 

And then when user is trying to view any page start with /dashboard, he will get an error report of "Must login to view dashboard pages", and you can customize the view by adding an error page of require_login.

Of cause, you can doing more than that, for example the configuration like this:

	(defrule only-admin-can-view-the-password-column
		(Clips\SecurityItem (type "column") (name "password"))
		(test (not (php_call "Clips\\Web\\user_is_in_group" "admin")))
		=>
		(reject-cause "now_allowed" "Only user in group admin can view the column password")
	)

This will affect to any datatable or listview that uses the [pagination]({{siteurl "base_concepts/05-pagination"}}) that has the password column. It didn't only affects the view, since it affects the pagination, so the column named password won't be queried from database completely.

## The Security Functions

There are few security function to aid you to write the security rules, described as below:

### Reject

You can reject the request by using this function, the usage for this function is like below:

	(reject "You Shall Not Pass!!!")

### Reject-Cause

You can reject the request not only using a reason, but with an cause(Clips Tool will use the cause to choose the error template, you can see [error handling]({{siteurl "web/08-error-handling"}}) for details) like this:

	(reject-cause "Gandalf Get Raged" "You Shall Not Pass!!!!")

### State

You can update the state of the security item(mostly the form field or pagination column) using this function like this:

	(state "hidden")

### Readonly

This function will change the security item's state to readonly:

	(readonly)
	
### None

This function will prevent the security item to be shown:

	(none)

### Hidden

This function will make the security item to be hidden

	(hidden)
