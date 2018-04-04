/**
 * {BlockEdit} <interface>
 */
class ZrcmsHtmlBlockEdit {
    /**
     * @param {String} id
     * @param {Object} config
     */
    constructor(id, config) {
        this.id = id;
        this.config = config;
        this.editorId = null;
    }

    /**
     * @return {Promise<boolean>}
     */
    async initEdit() {
        this.editorId = tinymce.init(
            {
                selector: '[data-block-id=' + this.id + '] .zrcms-block-html',
                height: 500,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor textcolor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code help wordcount'
                ],
                toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tinymce.com/css/codepen.min.css'
                ]
            }
        );

        return true;
    }

    /**
     * @return {Promise<object>}
     */
    async getSaveData() {
        this.config.html = tinymce.get(this.editorId).getContent();

        return {};
    }
}
