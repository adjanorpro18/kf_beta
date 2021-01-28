<?php

namespace App\Data;

use App\Entity\Category;
use Symfony\Component\Validator\Constraints\DateTime;

class SearchData
{

    /**
     * @var string
     */
    public $q='';

    /**
     * @var Category[]
     */
    public $categories= [];

    /**
     * @var null | DateTime
     */
    public $min;

    /**
     * @var null | DateTime
     */
    public $max;

}
