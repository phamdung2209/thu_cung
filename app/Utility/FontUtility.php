<?php

namespace App\Utility;

use App\Models\Currency;
use App\Models\Language;
use Config;
use Session;

class FontUtility
{
    public static function get_font_family()
    {
        $pdf_style_data = array();
        if (Session::has('currency_code')) {
            $currency_code = Session::get('currency_code');
        } else {
            $currency_code = Currency::findOrFail(get_setting('system_default_currency'))->code;
        }
        $language_code = Session::get('locale', Config::get('app.locale'));

        $direction = 'ltr';
        $text_align = 'left';
        $not_text_align = 'right';

        if (Language::where('code', $language_code)->first()->rtl == 1) {
            $direction = 'rtl';
            $text_align = 'right';
            $not_text_align = 'left';
        }

        if (
            $currency_code == 'BDT' ||
            $language_code == 'bd'
        ) {
            // bengali font
            $font_family = "freeserif";
        } elseif (
            $currency_code == 'KHR' ||
            $language_code == 'kh'
        ) {
            // khmer font
            $font_family = "'Hanuman','sans-serif'";
        } elseif ($currency_code == 'AMD') {
            // Armenia font
            $font_family = "'arnamu','sans-serif'";
            // }elseif($currency_code == 'ILS'){
            //     // Israeli font
            //     $font_family = "'Varela Round','sans-serif'";
        } elseif (
            $currency_code == 'AED' ||
            $currency_code == 'EGP' ||
            $language_code == 'sa' ||
            $currency_code == 'IQD' ||
            $language_code == 'ir' ||
            $language_code == 'om' ||
            $currency_code == 'ROM' ||
            $currency_code == 'SDG' ||
            $currency_code == 'ILS' ||
            $language_code == 'jo'
        ) {
            // middle east/arabic/Israeli font
            $font_family = "xbriyaz";
        } elseif ($currency_code == 'THB') {
            // thai font
            $font_family = "'Kanit','garuda'";
        } elseif (
            $currency_code == 'CNY' ||
            $language_code == 'zh'
        ) {
            // Chinese font
            $font_family = "'sun-exta','gb'";
        } elseif (
            $currency_code == 'MMK' ||
            $language_code == 'mm'
        ) {
            // Myanmar font
            $font_family = 'tharlon';
        } elseif (
            $currency_code == 'THB' ||
            $language_code == 'th'
        ) {
            // Thai font
            $font_family = "'zawgyi-one','garuda'";
        } else {
            // general for all
            $font_family = "'Roboto','sans-serif'";
        }
        
        $pdf_style_data['font_family'] = $font_family;
        $pdf_style_data['direction'] = $direction;
        $pdf_style_data['text_align'] = $text_align;
        $pdf_style_data['not_text_align'] = $not_text_align;
        return $pdf_style_data;
    }
}
