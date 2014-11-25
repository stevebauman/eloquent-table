<?php

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