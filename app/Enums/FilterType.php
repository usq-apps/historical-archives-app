<?php

namespace App\Enums;

enum FilterType: string
{
    case Category = 'category';
    case Subcategory = 'subcategory';
    case Collections = 'collections';
}
