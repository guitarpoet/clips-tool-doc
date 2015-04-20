# Base Concepts - Pagination

## The Concept of Pagination

The pagination in Clips Tool is the core part of the master view. The model of Clips Tool will support pagination to query the database(and other atasources) automaticly.

The controller of Clips Tool will support pagination query automaticly, so if you want to use pagination support in Clips Tool, you just need a pagination configuration file.

## The configuration of Pagination

The code below is a typical pagination configuration.

	{
		"from": "groups",
		"columns": [
			{ "data":"groups.id", "action":"group/show", "title":"ID" },
			{ "data":"groups.name", "title":"Name" },
			{ "data":"groups.notes", "title":"Notes" }
		]
	}

The pagination configuration is consists of these parts:

1. from: The tables that select data from, can be string or array
2. columns: The column configurations(see below for details)
3. join: The join configurations
4. where: The where configurations
5. orderBy: The order by fields and direction
6. groupBy: The group by fields
