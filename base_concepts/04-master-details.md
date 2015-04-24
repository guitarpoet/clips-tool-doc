# Base Concepts - Master and Details

## The Concept of Master and Details

For most of the time(80%?), all the system requirements can be divide using master and details pattern.

So, what is a master and details pattern?

Master and Details pattern is a UE(User Experience) pattern. It will use 2 kind of views(master and details) to provide most of the views.

* Master: The master view in most times will provide a [pagination]({{site_url "base_concepts/05-pagination"}}) enabled view(a table or a listview), it will provide all the functions that a pagination provides
* Details: The details view in most times is a readonly or editable form

### Purpose of Master and Details Pattern

The purpose of Master and Details pattern is aim to provide a consistant UI to let user manage all the domain objects. Can use Master View for the Create, Delete and Query operations, and can use Details View for Edit, Delete the domain object.

### The Functions of Master

1. Show the collection of data objects using table or listview UI
2. Provides the order by search support(by clicking table header or use drop box)
3. Provides the simple search support(by use textfield)
4. Provides the support of pagination

### The Functions of Details

1. View the fields of the data object
2. Edit the fields of the data object
