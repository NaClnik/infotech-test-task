<?php

namespace app\utils;

enum Roles : string
{
    case Reader = "reader";
    case Author = "author";
}
