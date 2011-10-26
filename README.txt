PHP Object Generator

As a developer of both Rails and PHP I am lucky enough to see the advantages one has over the other. One of the clear advantages Rails has over PHP is its RAD capabilities. This is largely thanks to ActiveRecord and the fantastic Rails command line tools.

PHP however, does not have these command line tools and while there is an implementation of ActiveRecord for PHP, it is not native to PHP and in my opinion, some how just doesn't feel right. Others may disagree but that is just my opinion. As a result of this, writing objects in PHP is a labour intensive and lets face it; boring task! Get this set that.... so much time wasted on repeating the same task.

Anyway, last weekend I set about writing an object generator that would some how mirror the abilities of the Rails command line. I ended up with <link>this</link>.

All you have to do is install the object_generator folder into your site. Then, navigate to yoursite.local/object_generator, enter the name of what you want your object to be called and the table that it will represent and click submit. A file will then be created in the object_generator folder which you can copy and paste to your desired location.

Each object created will extend my standard Object class which contains the following useful methods:

// Create a new object instance where $id represents the primary key of a table row
$user = new User( $id );

// Edit some attributes
$user->setName( $name );
$user->setAge( $age );

// Save the object
$user->save();

// Represent the object as an array
$user->toArray();

// Delete the object
$user->delete();