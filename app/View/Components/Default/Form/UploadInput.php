<?php

namespace App\View\Components\Default\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class UploadInput extends Component
{
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

        public string $label,
        public string $model,
        public ?string $types = null,
        public bool $multiple = false
    ) {
        $this->htmlId = 'id-' . Str::random(8);
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


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.default.form.upload-input',[
            'htmlId' => $this->htmlId,
            'typesToUpload' => $this->typesToUpload,
        ]);
    }
}
