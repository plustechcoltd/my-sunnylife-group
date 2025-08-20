<?php

namespace App\Helpers;

use App\Models\Language;

class LocalizationHelper
{
    public static function getConstValues(string $key): array
    {
        $values = config('const.'.$key);
        $result = [];
        foreach ($values as $value) {
            $result[$value] = __('const.'.$key.'.'.$value);
        }

        return $result;
    }

    public static function getLang($lang_code = '')
    {
        $lang_driver = config('app.lang_driver', 'config');

        $langs = [];

        switch ($lang_driver) {
            case 'config':
                $langs = config('lang', [
                    'ja' => [
                        'flag' => 'jp',
                        'label' => '日本語',
                    ],
                ]);
                foreach ($langs as $key => &$lang) {
                    $lang['default_yn'] = null;
                    if ($key == 'ja') {
                        $lang['default_yn'] = 'y';
                    }
                }
                break;

            case 'database':
                $langs = Language::query()
                                ->orderBy('sortno')
                                ->get()
                                ->mapWithKeys(function ($language) {
                                    return [
                                        $language->code => [
                                            'flag' => $language->flag,
                                            'label' => $language->label,
                                            'default_yn' => $language->default_yn,
                                            'sortno' => $language->sortno,
                                        ],
                                    ];
                                })
                                ->toArray();
                break;
            
            default:
                $langs = [];
                break;
        }

        if (!empty($lang_code)) {
            if (!isset($langs[$lang_code])) {
                $langs[$lang_code] = [
                    'flag' => $lang_code,
                    'label' => 'Unknown',
                ];
            }
            return $langs[$lang_code];
        }

        return $langs;
    }
}
