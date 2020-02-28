<?php

/**
 * LIBRERIA DE FUNCIONES QUE FACILITAN LA PROGRAMACIÓN DEL PROGRAMADOR ;)
 */
/**
 * getPost: Devuelve el post o en su defecto el valor que quiera el usuario si no existe
 */
function getPost($name, $else = null)
{
    return (isset($_POST[$name])) ? $_POST[$name] : $else;
}
/**
 * getGet: Devuelve el get o en su defecto el valor que quiera el usuario si no existe
 */
function getGet($name, $else = null)
{
    return (isset($_GET[$name])) ? $_GET[$name] : $else;
}
/**
 * getTagsVista: Obtiene todos los campos {{CAMPO}} de una vista
 */
function getTagsVista($vista)
{
    preg_match_all('/\{{(.*?)\}}/', $vista, $tags);
    return $tags[1];
}
/**
 * getArray: Devuelve el valor del index del array o en su defecto el valor que quiera el usuario si no existe
 *
 * @param $arr
 * @param $index
 * @param null $else
 * @return null
 */
function getArray($arr, $index, $else = null)
{
    return (isset($arr[$index])) ? $arr[$index] : $else;
}
/**
 * getCookie: Devuelve la cookie o en su defecto el valor que quiera el usuario si no existe
 *
 * @param $name
 * @param null $else
 * @return null
 */
function getCookie($name, $else = null)
{
    return (isset($_COOKIE[$name])) ? $_COOKIE[$name] : $else;
}
/**
 * addCookie: Añade una cookie y el tiempo de expiración es en dias
 *
 * @param $nombre
 * @param $valor
 * @param $tiempoDias
 * @return bool
 */
function addCookie($nombre, $valor, $tiempoDias)
{
    return setcookie($nombre, $valor, time() + ($tiempoDias * 24 * 60 * 60));
}
/** * redirectTo: Redirecciona al cliente a la url indicada * * @param $url */
function redirectTo($url)
{
    header("Location: $url");
    exit;
}
function contains($needle, $haystack)
{
    return strpos($haystack, $needle) !== false;
}
