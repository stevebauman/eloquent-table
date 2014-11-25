An HTML table generator for laravel collections

##Eloquent-Table


###Usage
    
Grab records from your model like usual:

    $books = Books::get();

    return view('books.index', compact('books'));

Inside your blade view:

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
            ->means('owned_by', 'user.full_name')
            ->render() 
    }}

The model books, needs to have a user method defining it's relation for this to work.

You must also use 'dot' notation to indicate the relationship.

Customizing the display of the column value:

    {{ $books->columns(array(
                'id' => 'ID',
                'title' => 'Title',
                'author' => 'Authored By',
                'owned_by' => 'Owned By',
            ))
            ->means('owned_by', 'user')
            ->modify('owned_by', function($user) {
                return $user->first_name . ' ' . $user->last_name;
            })
            ->render() 
    }}

Using modify, we can specify the column we want to modify, and the function will return the current relationship record.