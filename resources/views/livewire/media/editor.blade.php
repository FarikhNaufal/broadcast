<textarea wire:model="form.data" id="ckeditor" x-data x-init="ClassicEditor
    .create(document.querySelector('#ckeditor'), {
        plugins: [ClassicEditor,
            Essentials,
            Autoformat,
            Bold,
            Code,
            CodeBlock,
            Heading,
            HorizontalLine,
            Italic,
            Link,
            List,
            FontSize,
            Markdown,
            Paragraph,
            SourceEditing,
            TableToolbar,
            TextTransformation,
        ],
        toolbar: [
            'undo',
            'redo',
            '|',
            'bold',
            'italic',
            '|',
            'fontSize',
            'heading',
            '|',
            'bulletedList',
            'numberedList',
            '|',
            'code',
            '|',
            'link',
            'sourceEditing',
            'codeBlock',
            'horizontalLine',
        ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                {
                    model: 'heading1',
                    view: 'h1',
                    title: 'Heading 1',
                    class: 'ck-heading_heading1',
                },
                {
                    model: 'heading2',
                    view: 'h2',
                    title: 'Heading 2',
                    class: 'ck-heading_heading2',
                },
                {
                    model: 'heading3',
                    view: 'h3',
                    title: 'Heading 3',
                    class: 'ck-heading_heading3',
                },
                {
                    model: 'heading4',
                    view: 'h4',
                    title: 'Heading 4',
                    class: 'ck-heading_heading4',
                },
                {
                    model: 'heading5',
                    view: 'h5',
                    title: 'Heading 5',
                    class: 'ck-heading_heading5',
                },
                {
                    model: 'heading6',
                    view: 'h6',
                    title: 'Heading 6',
                    class: 'ck-heading_heading6',
                },
            ],

        },

    })
    .then(editor => {
        editor.model.document.on('change:data', () => {
            @this.set('form.data', editor.getData());
        });
    })
    .catch( /* ... */ );"></textarea>
