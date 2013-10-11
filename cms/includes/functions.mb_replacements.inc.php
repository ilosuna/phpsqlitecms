<?php
/*
 * Replacement functions for the multibyte string functions.
 * Only include this file if the multibyte string functionsa are not available!
 */

function mb_internal_encoding($charset='')
 {
 }

function mb_strlen($str, $encoding='')
 {
  return strlen ($str);
 }

function mb_substr($str, $start, $length=0, $encoding='')
 {
  return substr($str, $start, $length);
 }

function mb_strpos($haystack, $needle, $offset=0, $encoding='')
 {
  return strpos($haystack, $needle, $offset);
 }

function mb_strrpos($haystack, $needle, $offset=0, $encoding='')
 {
  return strrpos($haystack, $needle, $offset);
 }

function mb_strtolower($str, $encoding='')
 {
  return strtolower($str);
 }

function mb_strtoupper($str, $encoding='')
 {
  return strtoupper($str);
 }

function mb_encode_mimeheader($str, $charset='utf-8', $transfer_encoding='', $linefeed='', $indent='')
 {
  return '=?'.$charset.'?B?'.base64_encode($str).'?=';
 }
?>
