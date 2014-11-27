<?php

namespace Stevebauman\EloquentTable;

use Stevebauman\EloquentTable\TableCollection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

/**
 * TableTrait
 * 
 * Allows a laravel collection / eloquent collection to be converted into an
 * HTML table.
 * 
 * @package EloquentTable
 * @author Steve Bauman <steven_bauman_7@hotmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 */
trait TableTrait {
    
    /*
     * Stores the columns to display
     */
    public $eloquentTableColumns = array();
    
    /*
     * Stores the columns to hide when using
     * responsive templates
     */
    public $eloquentTableHiddenColumns = array();
    
    /*
     * Stores the column modifications
     */
    public $eloquentTableModifications = array();
    
    /*
     * Stores attributes to display onto the table
     */
    public $eloquentTableAttributes = array();
    
    /*
     * Stores column relationship meanings
     */
    public $eloquentTableMeans = array();
    
    /*
     * Stores column names to apply sorting
     */
    public $eloquentTableSort = array();
    
    /*
     * Enables / disables showing the pages on the table if the collection
     * is paginated
     */
    public $eloquentTablePages = false;
    
    /**
     * Assigns columns to display
     * 
     * @param array $columns
     * @return object
     */
    public function columns(array $columns = array())
    {
        $this->eloquentTableColumns = $columns;
        
        return $this;
    }
    
    /**
     * Assigns columns to hide for smartphone viewing
     * on responsive designed websites such as bootstrap
     * 
     * @param array $columns
     * @return object
     */
    public function hidden(array $columns = array())
    {
        $this->eloquentTableHiddenColumns = $columns;
        
        return $this;
    }
    
    /*
     * Enables pages to be shown on the view
     */
    public function showPages()
    {
        $this->eloquentTablePages = true;
        
        return $this;
    }
    
    /**
     * Assigns attributes to display on the table
     * 
     * @param array $attributes
     * @return object
     */
    public function attributes(array $attributes = array())
    {
        $this->eloquentTableAttributes = $this->arrayToHtmlAttributes($attributes);
        
        return $this;
    }
    
    
    
    /**
     * Generates view for the table
     * 
     * @param string $view
     * @return string
     */
    public function render($view = NULL)
    {
        if($view) {
            return view($view, array(
                'collection' => $this
            ));
        }

        return view('eloquenttable::table', array(
            'collection' => $this
        ))->render();
        
    }
    
    /**
     * Stores modifications to columns
     * 
     * @param type $column
     * @param Closure $closure
     * @return type
     */
    public function modify($column, $closure)
    {

        $this->eloquentTableModifications[$column] = $closure;
        
        return $this;
    }
    
    /**
     * Stores columns to sort in an array
     * 
     * @param type $columns
     * @return type
     */
    public function sortable($columns = array())
    {
        $this->eloquentTableSort = $columns;
        
        return $this;
    }
    
    /**
     * Tells the collection to use a different key (such as a relationship key)
     * rather than the one specified in the column
     * 
     * @param string $column
     * @param string $relation
     * @return object
     */
    public function means($column, $relation)
    {
        $this->eloquentTableMeans[$column] = $relation;
        
        return $this;
    }
    
    /**
     * Retrieves an eloquent relationships nested property
     * from a column
     * 
     * @param string $column
     * @return mixed
     */
    public function getRelationshipProperty($column)
    {
        $attributes = explode('.', $column);
        
        $tmpStr = $this;
        
        foreach($attributes as $attribute) {
            
            if($attribute === end($attributes)){
                    
                    if(is_object($tmpStr)){
                
                        $tmpStr = $tmpStr->$attribute;
                    
                    }
                
            } else{
                
                $tmpStr = $this->$attribute;
     
            }
            
        }
        
        return $tmpStr;
    }
    
    /**
     * Retrieves an eloquent relationship object from a column
     * 
     * @param string $column
     * @return object
     */
    public function getRelationshipObject($column)
    {
        $attributes = explode('.', $column);
        
        if(count($attributes) > 1) {
            $relationship = $attributes[count($attributes)-2];
        } else {
            $relationship = $attributes[count($attributes)-1];
        }
        
        return $this->$relationship;
    }
    
    /**
     * Retrieves hidden column attributes
     * 
     * @param string $column
     * @return string
     */
    public function getHiddenColumnAttributes($column)
    {
        /*
         * Check if custom attributes are being set on hidden column
         */
        if(array_key_exists($column, $this->eloquentTableHiddenColumns)){
            
            return $this->arrayToHtmlAttributes($this->eloquentTableHiddenColumns[$column]);
            
        /*
         * No custom attributes found, using default config attributes
         */
        } elseif(in_array($column, $this->eloquentTableHiddenColumns)){
            
            return $this->arrayToHtmlAttributes(Config::get('eloquenttable::default_hidden_column_attributes'));
        
        /*
         * Column wasn't found on the table
         */
        } else {
            
            return NULL;
            
        }
    }
    
    /**
     * Allows all columns on the current database table to be sorted through
     * query scope
     * 
     * @param object $query
     * @param string $field
     * @param string $sort
     * @return object
     */
    public function scopeSort($query, $field = NULL, $sort = NULL){
        
        /*
         * Make sure both the field and sort variables are present
         */
        if($field && $sort){
            
            /*
             * Retrieve all column names for the current model table
             */
            $columns = Schema::getColumnListing($this->table);
            
            /*
             * Make sure the field inputted is available on the current table
             */
            if(in_array($field, $columns)){

                /*
                 * Make sure the sort input is equal to asc or desc
                 */
                if($sort === 'asc' || $sort === 'desc'){
                    /*
                     * Return the query sorted
                     */
                    return $query->orderBy($field, $sort);
                }
            }
        }
        
        /*
         * Default order by created at field
         */
        return $query->orderBy('created_at', 'desc');
        
    }
    
    /**
     * Ovverides the newCollection method from the model this extends from
     * 
     * @param array $models
     * @return \Stevebauman\EloquentTable\TableCollection
     */
    public function newCollection(array $models = array()) {

        return new TableCollection($models);
        
    }
    
    /**
     * Converts an array of attributes to an html attribute string
     * 
     * @param array $attributes
     * @return string
     */
    private function arrayToHtmlAttributes(array $attributes = array())
    {
        $attributeString = '';
        
        if(count($attributes) > 0) {
            
            foreach ($attributes as $key => $value) {
                
                $attributeString .= " " . $key . "='" . $value . "'";
            }
            
        }
        
        return $attributeString;
    }
    
}
