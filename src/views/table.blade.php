
<table @if($collection->eloquentTableAttributes) {{ $collection->eloquentTableAttributes }} @else class="table table-striped" @endif>
    
    <thead>
        <tr>
        @foreach($collection->eloquentTableColumns as $key=>$name)
            <th>
            @if(in_array($key, $collection->eloquentTableSort))
                
                {{ url_to_sort($name, array('field'=>$key, 'sort'=>'asc')) }}
                
            @elseif(array_key_exists($key, $collection->eloquentTableSort))
            
                {{ url_to_sort($name, array('field'=>$collection->eloquentTableSort[$key], 'sort'=>'asc')) }}
                
            @else
                {{ ucfirst($name) }}
            @endif
            </th>
        @endforeach
        
        </tr>
    </thead>
    
    <tbody>
        @foreach($collection as $record)
        <tr>
            
            @foreach($collection->eloquentTableColumns as $key=>$name)
                
                <td>
                @if(array_key_exists($key, $collection->eloquentTableMeans))
                
                    @if(array_key_exists($key, $collection->eloquentTableModifications))
                    
                        {{ call_user_func_array($collection->eloquentTableModifications[$key], array(
                                    $record->getRelationshipObject($collection->eloquentTableMeans[$key]), $record
                                )) 
                        }}
                        
                    @else
                        {{ $record->getRelationshipProperty($collection->eloquentTableMeans[$key]) }}
                    @endif
                
                
                @else
                    
                    @if(array_key_exists($key, $collection->eloquentTableModifications))
                    
                        {{ call_user_func_array($collection->eloquentTableModifications[$key], array($record)) }}
                        
                    @else
                        
                        @if($record->$key)
                            
                            {{ $record->$key  }}
                        
                        @else
                            
                            {{ $record->$name  }}
                            
                        @endif
                        
                    @endif
                    
                @endif
                </td>
            @endforeach
            
        </tr>
        @endforeach
    </tbody>
    
</table>

@if($collection->eloquentTablePages)

<div class="text-center">{{ $collection->appends(Input::except('page'))->links() }}</div>

@endif

