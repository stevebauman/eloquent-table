<?php
    
    /**
     * Returns a URL with supplied query parameters and current icon for
     * the current sort direction
     * 
     * @param string $title
     * @param array $parameters
     * @return string
     */
    function url_to_sort($title, $parameters)
    {
        $field = Input::get('field');
        $sort = Input::get('sort');

        if($sort == 'desc'){
            $parameters['sort'] = 'asc';
        } else{
            $parameters['sort'] = 'desc';
        }

        if($field == $parameters['field']){
            $icon = sprintf('fa %s-%s', 'fa-sort', $parameters['sort']);
        } else{
            $icon = sprintf('fa %s', 'fa-sort');
        }

        return sprintf('<a class="link-sort" href="%s">%s <i class="%s"></i></a>', Request::url() . '?' .  http_build_query($parameters), $title, $icon);
    }
    
    /**
     * Helper for view facade. Checks if view helper function already exists
     * for Laravel 5 support. This is identical to the Laravel 5 view() helper.
     * 
     * @param string $view
     * @param array $data
     * @param array $mergeData
     * @return mixed
     */
    if(!function_exists('view'))
    {
        function view($view, $data = array(), $mergeData = array())
        {
            return View::make($view, $data, $mergeData);
        }
    }