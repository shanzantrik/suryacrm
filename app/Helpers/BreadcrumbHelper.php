<?php
// app/Helpers/BreadcrumbHelper.php

namespace App\Helpers;

class BreadcrumbHelper
{
  public static function generate()
  {
    $breadcrumbs = [];
    $segments = request()->segments();

    $url = '';

    foreach ($segments as $key => $segment) {
      $url .= '/' . $segment;

      // Push segment to breadcrumbs
      $breadcrumbs[] = [
        'name' => ucfirst($segment),
        'url' => $url
      ];
    }

    return $breadcrumbs;
  }
}
