<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Stichoza\GoogleTranslate\GoogleTranslate;

/**
 * خدمة الترجمة التلقائية عبر Google Translate (مكتبة Stichoza).
 *
 * الترجمة من الإنجليزية (المصدر) إلى العربية/التركية (الهدف).
 *
 * @example
 * // $service = app(TranslationService::class);
 * // $service->translate('Clothes', 'ar');  // => "ملابس"
 * // $service->translate('Clothes', 'tr');  // => "Giyim"
 */
class TranslationService
{
    protected GoogleTranslate $translator;

    public function __construct()
    {
        $this->translator = new GoogleTranslate;
    }

    /**
     * ترجمة نص من لغة مصدر إلى لغة هدف.
     *
     * @param  string  $text  النص المراد ترجمته (عادةً إنجليزي)
     * @param  string  $targetLang  اللغة المطلوبة (ar, tr)
     * @param  string  $sourceLang  اللغة الأصلية (افتراضي: en)
     */
    public function translate(string $text, string $targetLang, string $sourceLang = 'en'): ?string
    {
        $text = trim($text);

        if ($text === '' || $sourceLang === $targetLang) {
            return $text;
        }

        $cacheKey = 'trans:' . md5($text . $sourceLang . $targetLang);

        return Cache::remember($cacheKey, now()->addDays(30), function () use ($text, $targetLang, $sourceLang) {
            $this->translator->setSource($sourceLang);
            $this->translator->setTarget($targetLang);

            return $this->translator->translate($text);
        });
    }
}