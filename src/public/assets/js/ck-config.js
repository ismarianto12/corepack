/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

// CKEDITOR.editorConfig = function(config) {
//     // Define changes to default configuration here. For example:
//     config.language = 'fr';
//     config.uiColor = '#AADC6E';
//     config.filebrowserUploadMethod = "form";
// };

CKEDITOR.plugins.registered['save'] = {
    init: function (editor) {
        var command = editor.addCommand('save', {
            modes: { wysiwyg: 1, source: 1 },
            exec: function (editor) {
                // Custom function for the save button
                formSave();
            }
        });
        editor.ui.addButton('Save', { label: 'Save', command: 'save' });
    }

}

CKEDITOR.editorConfig = function (config) {
    config.toolbar = [
        { name: 'document', items: ['Source', 'Maximize', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates'] },
        { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
        { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
        { name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'] },
        '/',
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat'] },
        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'] },
        { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
        { name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
        '/',
        { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
        { name: 'colors', items: ['TextColor', 'BGColor'] },
        { name: 'tools', items: ['Maximize', 'ShowBlocks'] },
        { name: 'about', items: ['About', 'Markdown'] }
    ];
    config.extraPlugins = 'markdown';
    config.uiColor = '#AADC6E';
    config.filebrowserUploadMethod = "form";
};