<?php

namespace App\Message;

use Exception;

class ContactMail
{
    private array $contentArray ;
    /**
     * Retrieve content to get passed to it's Handler
     * @param $contentArray : associative array
     */
    public function __construct(array $contentArray)
    {   // if the given array is not empty and if it's not an list array 
        if ( !count($contentArray) == 0 && !array_is_list($contentArray)) {
           
            foreach ($contentArray as $key => $value) {
                $this->contentArray[$key] = $value;
                
            }
            
        }else{
            throw new Exception("Array is not associative");
        }
    }

    public function getContent(): array
    {
        
        return $this->contentArray;
    }
    
}