<?php
function route_class()
{
  return str_replace('.', '-', Route::currentRouteName());
}

/**
 * 自动提取摘要
 * @param  [type]  $value  [description]
 * @param  integer $length [description]
 * @return [type]          [description]
 */
function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}

function make_link($value)
{
  return $value;
}