An HTML table generator for laravel collections

##Eloquent-Table


###Usage
    
Grab records from your model like usual:

    $books = Books::get();

    return view('books.index', compact('books'));

Inside your blade view:

    {{ $books->columns(array(
                'id' => 'ID',
                'status' => 'Status',
                'priority' => 'Priority',
                'subject' => 'Subject',
                'description' => 'Description',
                'action' => 'Action',
            ))
            ->render() 
    }}