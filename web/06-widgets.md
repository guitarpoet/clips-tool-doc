# Web Development - Widgets

## The Concept of Widgets in Clips Tool

The Widgets is the core concept of Clips Tool. So, what a widget is in Clips Tool?

The widget in Clips Tool is a component of web application, it has its intializer(php), its configuration(json), its style part(scss) and its active part(js), it should have a presentation or many parts(smarty plugin or handlebar partial) or not.

Let's take a view of a common widget:

## DataTable Widget

DataTable Widget is very fundamental widget in [Master Details Pattern]({{siteurl "base_concepts/04-master-details"}}), let's see the contents of it:

1. Widget.php: This is the initializer for widget datatable, for datatable, it'll read the configuration, add the js and scss it needs to the context, add its smarty plugin folder to smarty engine when it is loaded
2. widget.json: This file is the metadata for Datatable widget, it is like this for now:
	{
		"author": "Jack &lt;guitarpoet@gmail.com&gt;",
		"date": "Wed Feb 18 16:52:03 2015",
		"version": "1.0",
		"name": "DataTable",
		"doc":"The datatable widget.",
		"depends": ["Jquery", "JQueryUICommon", "StoreJS"],
		"js": {
			"files": [
				"jquery.dataTables.js",
				"datatable.functions.js"
			]
		},
		"css": {
			"files": [
				"jquery.dataTables"
			]
		},
		"scss": {
			"files": [
				"pinet_datatables_mixin",
				"pinet_datatables"
			]
		}
	}

You can see the dependenciese of it, and see what files it provides
3. function.datatable.php: This is the smarty plugin file for this widget, after you initialize this widget, you'll have the ability to write {datatable} tag in your page, for details of Datatable widget, see [here]({{siteurl widgets/datatable}})

## Dependency Management of Widgets

As you can see in the above example, all widgets in Clips Tool may have its dependency. 
