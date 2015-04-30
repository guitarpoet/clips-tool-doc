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
desc substance_data;
+------------------+---------------+------+-----+---------+-------+
| Field            | Type          | Null | Key | Default | Extra |
+------------------+---------------+------+-----+---------+-------+
| id               | bigint(20)    | NO   | PRI | NULL    |       |
| smiles           | longtext      | YES  |     | NULL    |       |
| bond_annotations | text          | YES  |     | NULL    |       |
| coordinate_type  | varchar(16)   | YES  |     | NULL    |       |
| datasource_name  | varchar(255)  | YES  | MUL | NULL    |       |
| datasource_regid | varchar(16)   | YES  |     | NULL    |       |
| datasource_url   | varchar(1024) | YES  |     | NULL    |       |
| substance_url    | varchar(1024) | YES  |     | NULL    |       |
| cas              | varchar(32)   | YES  | MUL | NULL    |       |
| nonstandard_bond | varchar(1024) | YES  |     | NULL    |       |
| pubmed_id        | varchar(32)   | YES  |     | NULL    |       |
| comment          | longtext      | YES  |     | NULL    |       |
| snynonym         | text          | YES  |     | NULL    |       |
| total_charge     | varchar(16)   | YES  |     | NULL    |       |
+------------------+---------------+------+-----+---------+-------+
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

As you can see in the above example, all widgets in Clips Tool may have its dependency, when you require this widget as depenency, the depenency widgets of this widget(and their dependencies too) will be load an initialized for you too. And, don't worry, Clips Tool will only load and initialize the widget once, so, even all of your widgets require jquery, jquery widget will get initialize once.

The depenency management for widgets in Clips Tool 1.0 is that simple, in 1.1 version of Clips Tool, I'll add more complex depenency management to Clips Tool.

## How to write your own widget

Since Clips Tool is extendable by the heart, so, what to do if you want to write your own widget?

You can use this wizzard to aid you:

	./vender/bin/clips generate widget

And, walk through this wizzard, you'll create a bootstrap for your widget.

The folder structure of a widget is soemthing like this:

* widget.json: The configuration file for this widget
* Widget.php: The initialize class for this widget
* js: The folder to put your JavaScript files
* scss: The folder to put your SASS files
* css: The folder to put your CSS files
* smarty: The folder to put your Smarty plugins
* mustache: The folder to put your mustache particials

What you need to do, is add the files that you want to put, and then change the configuration of your widget.
