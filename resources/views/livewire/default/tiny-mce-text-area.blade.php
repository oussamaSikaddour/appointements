<div wire:ignore>
    <textarea id="{{ $htmlId }}"></textarea>
</div>

@script
<script>
    const getLang = () => {
        const storedLang = localStorage.getItem('language');
        switch (storedLang) {
            case 'Ar':
                return 'ar';
            case 'En':
                return 'en';
            case 'Fr':
                return 'fr_FR';
            default:
                return 'fr_FR'; // Default language
        }
    };

    // Initialize TinyMCE editor
    const initializeTinyMCE = (editorId, initialContent) => {
        tinymce.init({
            selector: `#${editorId}`,
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
            language: getLang(),
            setup: function (editor) {
                const updateContent = (content) => {
                    editor.setContent(content);
                    editor.save();
                };

                // Initialize content in the editor
                editor.on('init', function () {
                    updateContent(`{!! $content !!}`);
                });

                // Update Livewire content when mouse leaves the editor
                editor.on('MouseLeave', () => {
                    @this.call('setContent', editor.getContent());
                });
            },
        });
    };

    // Listen for the event and initialize TinyMCE
    $wire.on('initialize-tiny-mce', () => {
        initializeTinyMCE('{{ $htmlId }}', `{!! $content !!}`);
    });
</script>
@endscript
