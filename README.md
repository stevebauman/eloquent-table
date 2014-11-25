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

Handling relationship values using `means`:

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

