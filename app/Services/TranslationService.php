<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Stichoza\GoogleTranslate\GoogleTranslate;

/**
 * خدمة الترجمة التلقائية عبر Google Translate (مكتبة Stichoza).
 *
 * لا تحتاج API Key — تستخدم الترجمة المجانية مباشرة.
 * النتائج تُخزَّن في Cache لمدة 30 يوماً لتسريع الترجمات المتكررة.
 *
 * @example
 * // $service = app(TranslationService::class);
 * // $service->translate('ملابس', 'en');  // => "Clothes"
 * // $service->translate('ملابس', 'tr');  // => "Giyim"
 */
class TranslationService
{
    protected GoogleTranslate $translator;

    /**
     * تهيئة مكتبة Google Translate عند إنشاء الخدمة.
     *
     * @example
     * // يُستدعى تلقائياً عند أول استخدام:
     * // app(TranslationService::class);
     */
    public function __construct()
    {
        $this->translator = new GoogleTranslate;
    }

    /**
     * ترجمة نص من لغة مصدر إلى لغة هدف.
     *
     * @param  string  $text  النص المراد ترجمته (عادةً عربي)
     * @param  string  $targetLang  اللغة المطلوبة (en, tr)
     * @param  string  $sourceLang  اللغة الأصلية (افتراضي: ar)
     *
     * @example
     * // translate('إلكترونيات', 'en', 'ar') => "Electronics"
     * // translate('إلكترونيات', 'ar', 'ar') => "إلكترونيات" (نفس اللغة)
     * // translate('', 'en')                  => "" (نص فارغ)
     */
    public function translate(string $text, string $targetLang, string $sourceLang = 'ar'): ?string
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
