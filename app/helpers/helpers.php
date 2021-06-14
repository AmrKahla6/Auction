<?php

    /**
     * @param string $routeName
     * @return string
     */

    function is_active(string $routeName)
    {
        return null !== request()->segment(2) &&  request()->segment(2) == $routeName ? 'active' : '' ;
    }

    function changeLang(){
         if(request()->segment(1) == "en"){
            $url = url()->current();
            $replace = str_replace(request()->segment(1) , 'ar' , $url);
            return $replace;
        }

        if(request()->segment(1) == "ar"){
            $url     = url()->current();
            $replace = str_replace(request()->segment(1) , 'en' , $url);
            return $replace;
        }
    }


