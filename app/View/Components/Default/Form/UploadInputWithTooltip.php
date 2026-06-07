<?php

namespace App\View\Components\Default\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class UploadInputWithTooltip extends Component
{
    public string $iconHtml;
    public string $htmlId;
    public ?string $typesToUpload = null;

    /**
     * Create a new component instance.
     *
     * @param string $tooltip The tooltip text to display on hover.
     * @param string $icon The key for the icon in the configuration.
     * @param string $model The Livewire model binding.
     * @param string|null $types Comma-separated short types like 'pdf,img,excel' or raw MIME types.
     * @param bool $multiple Allow multiple file selection.
     */
    public function __construct(
        public string $tooltip,
        public string $icon,
        public string $model,
        public ?string $types = null,
        public bool $multiple = false
    ) {
        $this->htmlId = 'id-' . Str::random(8);
        $this->iconHtml = $this->resolveIconHtml($icon);
        $this->typesToUpload = $this->resolveMimeTypes($types);
    }

    private function resolveMimeTypes(?string $types): ?string
    {
        if (!$types) return null;

        $map = [
            'pdf' => ['application/pdf'],
            'img' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            'excel' => [
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-excel',
            ],
            'doc' => ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            'csv' => ['text/csv'],
            'zip' => ['application/zip'],
        ];

        $inputTypes = explode(',', $types);
        $resolved = [];

        foreach ($inputTypes as $typeKey) {
            $typeKey = trim(strtolower($typeKey));
            if (isset($map[$typeKey])) {
                $resolved = array_merge($resolved, $map[$typeKey]);
            } else {
                $resolved[] = $typeKey; // Treat as raw MIME type
            }
        }

        return implode(',', array_unique($resolved));
    }

    private function getIconFromConfig(string $icon): string
    {
        return config("constants.ICONS.$icon", '<i class="fa-solid fa-question"></i>');
    }

    private function resolveIconHtml(string $icon): string
    {
        $iconHtml = $this->getIconFromConfig($icon);

        if (empty($iconHtml)) {
            Log::warning("Icon '{$icon}' not found in configuration.");
        }

        return $iconHtml;
    }

    public function render(): View|Closure|string
    {
        return view('components.default.form.upload-input-with-tooltip', [
            'iconHtml' => $this->iconHtml,
            'htmlId' => $this->htmlId,
            'typesToUpload' => $this->typesToUpload,
        ]);
    }
}
