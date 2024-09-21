<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumMethods;

/**
 * HttpStatusEnum for required Http status codes
 *
 * @author Adeola Bada
 */
enum HttpStatusEnum: int
{
    use EnumMethods;

    case OK = 200;
    case CREATED = 201;
    case NO_CONTENT = 204;
    case MULTIPLE_CHOICES = 300;
    case MOVED_PERMANENTLY = 301;
    case FOUND = 302;
    case SEE_OTHER = 303;
    case NOT_MODIFIED = 304;
    case USE_PROXY = 305;
    case UNUSED = 306;
    case TEMPORARY_REDIRECT = 307;
    case PERMANENT_REDIRECT = 308;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case NOT_ACCEPTABLE = 406;
    case CONFLICT = 409;
    case UNPROCESSABLE = 422;
    case INTERNAL_SERVER_ERROR = 500;
}
