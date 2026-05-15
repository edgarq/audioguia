'use strict';

document.addEventListener('DOMContentLoaded', function () {
    if (typeof Quill === 'undefined') return;

    var toolbarOptions = [
        [{ header: [2, 3, false] }],
        ['bold', 'italic', 'underline'],
        [{ list: 'ordered' }, { list: 'bullet' }],
        ['link', 'clean']
    ];

    var instances = {};
    ['es', 'en', 'fr'].forEach(function (lang) {
        var textarea  = document.getElementById('desc_' + lang);
        var container = document.getElementById('editor_' + lang);
        if (!textarea || !container) return;

        var quill = new Quill(container, {
            theme: 'snow',
            modules: { toolbar: toolbarOptions }
        });

        if (textarea.value.trim()) {
            quill.clipboard.dangerouslyPasteHTML(textarea.value);
        }

        instances[lang] = { quill: quill, textarea: textarea };
    });

    var form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function () {
            Object.keys(instances).forEach(function (lang) {
                var html = instances[lang].quill.root.innerHTML;
                instances[lang].textarea.value = (html === '<p><br></p>') ? '' : html;
            });
        });
    }
});
