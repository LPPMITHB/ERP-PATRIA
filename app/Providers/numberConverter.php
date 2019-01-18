<?php

namespace App\Providers;

class numberConverter
{
    private static $map, $strings;
    private static function map()
    {
        $map = array();
        $num = 1;
        $count = 1;
        while($num < 307)
        {
            if($count == 1) $map[$num] = $num+2;
            elseif($count == 2) $map[$num] = $num+1;
            else 
            {
                $map[$num] = $num;
                $count = 0;
            }
            $count++;
            $num++;
        }
        return $map;
    }
    private static function strings()
    {
        return array 
        (
            6 => 'thousand',
            9 => 'million',
            12 => 'billion',
            15 => 'trillion',
            18 => 'quadrillion',
            21 => 'quintillion',
            24 => 'sextillion',
            27 => 'septillion',
            30 => 'octillion',
            33 => 'nonillion',
            36 => 'decillion',
            39 => 'undecillion',
            42 => 'duodecillion',
            45 => 'tredecillion',
            48 => 'quattuordecillion',
            51 => 'quindecillion',
            54 => 'sexdecillion',
            57 => 'septendecillion',
            60 => 'octodecillion',
            63 => 'novemdecillion',
            66 => 'vigintillion',
            69 => 'unvigintillion',
            72 => 'duovigintillion',
            75 => 'trevigintillion',
            78 => 'quattuorvigintillion',
            81 => 'quinvigintillion',
            84 => 'sexvigintillion',
            87 => 'septenvigintillion',
            90 => 'octovigintillion',
            93 => 'novemvigintillion',
            96 => 'trigintillion',
            99 => 'untrigintillion',
            102 => 'duotrigintillion',
            105 => 'tretrigintillion',
            108 => 'quattuortrigintillion',
            111 => 'quintrigintillion',
            114 => 'sextrigintillion',
            117 => 'septentrigintillion',
            120 => 'octotrigintillion',
            123 => 'novemtrigintillion',
            126 => 'quadragintillion',
            129 => 'unquadragintillion',
            132 => 'duoquadragintillion',
            135 => 'trequadragintillion',
            138 => 'quattuorquadragintillion',
            141 => 'quinquadragintillion',
            144 => 'sexquadragintillion',
            147 => 'septenquadragintillion',
            150 => 'octoquadragintillion',
            153 => 'novemquadragintillion',
            156 => 'quinquagintillion',
            159 => 'unquinquagintillion',
            162 => 'duoquinquagintillion',
            165 => 'trequinquagintillion',
            168 => 'quattuorquinquagintillion',
            171 => 'quinquinquagintillion',
            174 => 'sexquinquagintillion',
            177 => 'septenquinquagintillion',
            180 => 'octoquinquagintillion',
            183 => 'novemquinquagintillion',
            186 => 'sexagintillion',
            189 => 'unsexagintillion',
            192 => 'duosexagintillion',
            195 => 'tresexagintillion',
            198 => 'quattuorsexagintillion',
            201 => 'quinsexagintillion',
            204 => 'sexsexagintillion',
            207 => 'septensexagintillion',
            210 => 'octosexagintillion',
            213 => 'novemsexagintillion',
            216 => 'septuagintillion',
            219 => 'unseptuagintillion',
            222 => 'duoseptuagintillion',
            225 => 'treseptuagintillion',
            228 => 'quattuorseptuagintillion',
            231 => 'quinseptuagintillion',
            234 => 'sexseptuagintillion',
            237 => 'septenseptuagintillion',
            240 => 'octoseptuagintillion',
            243 => 'novemseptuagintillion',
            246 => 'octogintillion',
            249 => 'unoctogintillion',
            252 => 'duooctogintillion',
            255 => 'treoctogintillion',
            258 => 'quattuoroctogintillion',
            261 => 'quinoctogintillion',
            264 => 'sexoctogintillion',
            267 => 'septenoctogintillion',
            270 => 'octooctogintillion',
            273 => 'novemoctogintillion',
            276 => 'nonagintillion',
            279 => 'unnonagintillion',
            282 => 'duononagintillion',
            285 => 'trenonagintillion',
            288 => 'quattuornonagintillion',
            291 => 'quinnonagintillion',
            294 => 'sexnonagintillion',
            297 => 'septennonagintillion',
            300 => 'octononagintillion',
            303 => 'novemnonagintillion',
            306 => 'centillion',
        );
    }
    public static function longform($number = string, $commas = true)
    {
        $negative = substr($number, 0, 1) == '-' ? 'negative ' : '';
        list($number) = explode('.', $number);          
        $number = trim(preg_replace("/[^0-9]/u", "", $number));
        $number = (string)(ltrim($number,'0'));
        if(empty($number)) return 'zero';
        $length = strlen($number);
        if($length <  2) return $negative.self::ones($number);
        if($length <  3) return $negative.self::tens($number);
        if($length <  4) return $commas ? $negative.str_replace('hundred ', 'hundred and ', self::hundreds($number)) : $negative.self::hundreds($number);
        if($length < 307) 
        {
            self::$map = self::map();
            self::$strings = self::strings();
            $result = self::beyond($number, self::$map[$length]);
            if(!$commas) return $negative.$result;
            $strings = self::$strings;
            $thousand = array_shift($strings);
            foreach($strings as $string) $result = str_replace($string.' ', $string.', ', $result);
            if(strpos($result, 'thousand') !== false) list($junk,$remainder) = explode('thousand', $result);
            else $remainder = $result;
            return strpos($remainder, 'hundred') !== false ? $negative.str_replace('thousand ', 'thousand, ', $result) : $negative.str_replace('thousand ', 'thousand and ', $result);
        }
        return 'a '.$negative.'number too big for your britches';
    }
    private static function ones($number)
    {
        $ones = array('zero','one','two','three','four','five','six','seven','eight','nine');
        return $ones[$number];
    }
    private static function tens($number)
    {
        $number = (string)(ltrim($number,'0'));
        if(strlen($number) < 2) return self::ones($number);
        if($number < 20)
        {
            $teens = array('ten','eleven','twelve','thirteen','fourteen','fifteen','sixteen','seventeen','eighteen','nineteen');
            return $teens[($number-10)];
        }
        else
        {
            $tens = array('','','twenty','thirty','forty','fifty','sixty','seventy','eighty','ninety');
            $word = $tens[$number[0]];
            return empty($number[1]) ? $word : $word.'-'.self::ones($number[1]);
        }
    }
    private static function hundreds($number)
    {
        $number = (string)(ltrim($number,'0'));
        if(strlen($number) < 3) return self::tens($number);
        $word = self::ones($number[0]).' hundred';
        $remainder = substr($number, -2);
        if(ltrim($remainder,'0') != '') $word .= ' '.self::tens($remainder);
        return $word;
    }
    private static function beyond($number, $limit)
    {
        $number = (string)(ltrim($number,'0'));
        $length = strlen($number);
        if($length < 4) return self::hundreds($number);
        if($length < ($limit-2)) return self::beyond($number, self::$map[($limit-3)]);
        if($length == $limit) $word = self::hundreds(substr($number, 0, 3), true);
        elseif($length == ($limit-1)) $word = self::tens(substr($number, 0, 2));
        else $word = self::ones($number[0]);
        $word .= ' '.self::$strings[$limit];
        $sub = ($limit-3);
        $remainder = substr($number, -$sub);
        if(ltrim($remainder,'0') != '') $word .= ' '.self::beyond($remainder, self::$map[$sub]);
        return $word;
    }
    public static function numberformat($number, $fixed = 0, $dec = '.', $thou = ',')
    {
        $negative = substr($number, 0, 1) == '-' ? '-' : '';
        $number = trim(preg_replace("/[^0-9\.]/u", "", $number));
        $number = (string)(ltrim($number,'0'));
        $fixed = (int)$fixed;
        if(!is_numeric($fixed)) $fixed = 0;
        if(strpos($number, $dec) !== false) list($number,$decimals) = explode($dec, $number); 
        else $decimals = '0';
        if($fixed) $decimals = '.'.str_pad(substr($decimals, 0, $fixed), $fixed, 0, STR_PAD_RIGHT);
        else $decimals = '';
        $thousands = array_map('strrev', array_reverse(str_split(strrev($number), 3)));
        return $negative.implode($thou,$thousands).$decimals;
    }
}