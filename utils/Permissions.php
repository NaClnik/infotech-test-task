<?php
declare(strict_types=1);

namespace app\utils;

enum Permissions : string
{
    case SubscribeToAuthor = "subscribeToAuthor";
    case ViewBook = "viewBook";
    case AddBook = "addBook";
    case UpdateBook = "updateBook";
    case DeleteBook = "deleteBook";
}