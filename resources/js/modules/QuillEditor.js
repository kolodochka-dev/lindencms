// resources/js/modules/QuillEditor.js
import { Module } from './Module.js'
import Quill from 'quill';

export class QuillEditor extends Module {
    onLoaded() {
        this.load();

        // Handle HTMX dynamic content loading
        document.addEventListener('htmx:afterSwap', (event) => {
            if (event.detail.target !== document.body || event.detail.boosted) {
                setTimeout(() => this.load(), 100);
            }
        });

        document.addEventListener('htmx:beforeHistoryUpdate', () => {
            this.load();
        });

        document.addEventListener('htmx:load', (event) => {
            if (event.detail.boosted) {
                setTimeout(() => this.load(), 100);
            }
        });

        document.body.addEventListener('htmx:historyRestore', () => this.load());

        // Add every quill editors to the HTMX request parameters
        document.body.addEventListener('htmx:configRequest', function (event) {
            // Check if this is a save request
            if (event.detail.elt.closest('[hx-post]')) {
                // Find all Quill editors
                const quillEditors = document.querySelectorAll('.quill-editor');

                quillEditors.forEach((editor) => {
                    if (editor && editor.quill) {
                        // Get the specific field name from data-name attribute
                        const fieldName = editor.dataset.name;
                        const content = editor.quill.root.innerHTML;

                        event.detail.parameters[fieldName] = content;
                    }
                });
            }
        });
    }

    load() {
        const editors = document.querySelectorAll('.quill-editor');

        editors.forEach(element => {
            // Skip if already initialized
            if (element.quill) return;

            // Find the hidden textarea
            const textareaId = `${element.id}-textarea`;
            const textarea = document.getElementById(textareaId);

            // Get initial content from textarea value
            let initialContent = '';
            if (textarea) {
                initialContent = textarea.value;
            }

            const placeholder = element.dataset.placeholder || 'Write your content here...';
            const isReadonly = element.dataset.readonly === 'true';
            const isDisabled = element.dataset.disabled === 'true';

            // Initialize Quill
            const quill = new Quill(element, {
                debug: 'info',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'header': 1 }, { 'header': 2 }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'font': [] }],
                        [{ 'align': [] }],
                        ['link', 'image', 'video']
                    ],
                },
                placeholder: placeholder,
                theme: 'snow',
                bounds: 'main',
            });

            // Set initial content
            if (initialContent) {
                quill.clipboard.dangerouslyPasteHTML(initialContent);
            }

            // Sync content to textarea on change
            if (!isDisabled) {
                quill.on('text-change', () => {
                    const html = quill.root.innerHTML;
                    if (textarea) {
                        textarea.value = html;
                    }
                });
            }

            // Store reference
            element.quill = quill;

            console.log('✅ Quill editor initialized for:', element.dataset.name);
        });
    }
}