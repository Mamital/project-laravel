<?php

use Morilog\Jalali\Jalalian;

function jalaliDate($date, $format = '%A, %d %B %Y')
{
    return Jalalian::forge($date)->format($format);
}

function persian($number)
{
    $arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    return str_replace($arabic_western, $arabic_eastern, $number);
}
