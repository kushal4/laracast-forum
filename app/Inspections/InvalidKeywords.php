<?php

namespace App\Inspections;
class InvalidKeywords{

    protected $invalids=[
      "yahoo"
    ];
    public function detect($body){

        foreach ($this->invalids as $invalidKeyword){
            $search_pos=stripos($body,$invalidKeyword);
            // dd(is_int($search_pos));
            if (stripos($body, $invalidKeyword) !== false) {
                //dd("throw exception ends");
                //if (App::environment() == 'testing') {
                //throw new Exception('Your reply contains spam.');
                throw new \Exception('Your reply contains spam.');
                //}


            }
        }
    }
}