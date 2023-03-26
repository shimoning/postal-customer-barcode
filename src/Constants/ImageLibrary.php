<?php

namespace Shimoning\PostalCustomerBarcode\Constants;

enum ImageLibrary: string
{
    case GD = 'gd';
    case IMAGE_MAGICK = 'ImageMagick';
}
