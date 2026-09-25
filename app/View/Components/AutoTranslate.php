<?php

namespace App\View\Components;

use App\Traits\Translatable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class AutoTranslate extends Component
{
    public string $group;

    public string $field;

    public ?string $label;

    public array $translations;

    public bool $multiline;

    public function __construct(
        string $group,
        string $field,
        ?Model $model = null,
        ?string $label = null,
        ?bool $multiline = null,
        array $translations = [],
    ) {
        $this->group = $group;
        $this->field = $field;
        $this->label = $label ?? $this->defaultLabel($field);
        $this->multiline = $multiline ?? str_contains($field, 'description');
        $this->translations = $this->resolveTranslations($model, $field, $translations);
    }

    public function render(): View
    {
        return view('components.auto-translate');
    }

    protected function resolveTranslations(?Model $model, string $field, array $translations): array
    {
        if ($translations !== []) {
            return $translations;
        }

        if ($model && in_array(Translatable::class, class_uses_recursive($model), true)) {
            $arabicText = trim((string) old($field, ''));

            return $model->resolveTranslationsForField(
                $field,
                $arabicText !== '' ? $arabicText : null
            );
        }

        return session("{$field}_translations", []);
    }

    protected function defaultLabel(string $field): string
    {
        return match ($field) {
            'name' => 'ترجمات الاسم',
            'description' => 'ترجمات الوصف',
            default => 'ترجمات ' . str_replace('_', ' ', $field),
        };
    }
}
