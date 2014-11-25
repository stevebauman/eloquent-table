An HTML table generator for laravel collections

##Eloquent-Table

###Installation

Include the package in `composer.json`:

    "stevebauman/eloquenttable": "dev-master"

Include the service provider in your `app.php` config file:
    
    /* 
    * Replace the current Pagination Service Provider if you use Pagination on
    * your models
    */
    'Stevebauman\EloquentTable\PaginationServiceProvider',
    'Stevebauman\EloquentTable\EloquentTableServiceProvider',

###Usage
    
Grab records from your model like usual:

    $books = Books::get();

    return view('books.index', compact('books'));

Inside your blade view, we just specify the columns we want to show, and then call the render method:

    {{ $books->columns(array(
                'id' => 'ID',
                'title' => 'Title',
                'author' => 'Authored By'
            ))
            ->render() 
    }}

Handling relationship values using `means($column, $relationship)`:

    {{ $books->columns(array(
                'id' => 'ID',
                'title' => 'Title',
                'author' => 'Authored By',
                'owned_by' => 'Owned By',
            ))
            ->means('owned_by', 'user.first_name')
            ->render()
    }}

The model books, needs to have a user method defining it's relation for this to work.

You must also use 'dot' notation to indicate the relationship.

Customizing the display of the column value using `modify($column, $closure)`:

    {{ $books->columns(array(
                'id' => 'ID',
                'title' => 'Title',
                'author' => 'Authored By',
                'owned_by' => 'Owned By',
            ))
            ->means('owned_by', 'user')
            ->modify('owned_by', function($user, $book) {
                return $user->first_name . ' ' . $user->last_name;
            })
            ->render() 
    }}

Using modify, we can specify the column we want to modify, and the function will return the current relationship record,
as well as the current base record, in this case the book.

With eloquent-table, we can also generate sortable links for columns easily:

    {{ $books->columns(array(
                'id' => 'ID',
                'title' => 'Title',
                'author' => 'Authored By',
                'owned_by' => 'Owned By',
            ))
            ->sortable(array('id', 'title'))
            ->render()
    }}

A link will be generated inside the column header that will be clickable. The HTML generated will look like:

    <a class="link-sort" href="http://www.example.com/books?field=id&amp;sort=desc">
        ID <i class="fa fa-sort"></i>
    </a>