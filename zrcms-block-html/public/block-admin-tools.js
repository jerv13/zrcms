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
        this.editor = null;
        this._getEditor = this._getEditor.bind(this);
        this.initEdit = this.initEdit.bind(this);
        this.getSaveData = this.getSaveData.bind(this);
        console.log('ZrcmsHtmlBlockEdit:construct');
    }

    /**
     * @return {Promise<any>}
     * @private
     */
    _getEditor() {
        if (this.editor) {
            return new Promise(
                (resolve, reject) => {
                    resolve(this.editor);
                }
            )
        }

        return this.initEdit().then(
            (initialized) => {
                return new Promise(
                    (resolve, reject) => {
                        resolve(this.editor);
                    }
                )
            }
        )
    }

    /**
     * @return {Promise<boolean>}
     */
    initEdit() {
        console.log('ZrcmsHtmlBlockEdit:initEdit complete');
        this.editor = tinymce.init(
            {
                selector: '[data-block-id=' + this.id + '] .zrcms-block-html',
                height: 500,
                menubar: false,
                plugins: [
                    // 'advlist autolink lists link image charmap print preview anchor textcolor',
                    // 'searchreplace visualblocks code fullscreen',
                    // 'insertdatetime media table contextmenu paste code help wordcount'
                ],
                toolbar: 'insert | undo redo |  formatselect | bold italic backcolor | bullist numlist outdent indent',
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tinymce.com/css/codepen.min.css'
                ]
            }
        );

        return new Promise(
            (resolve, reject) => {
                console.log('ZrcmsHtmlBlockEdit:getSaveData complete');
                resolve(true);
            }
        );
    }

    /**
     * @return {Promise<object>}
     */
    getSaveData() {
        console.log('ZrcmsHtmlBlockEdit:getSaveData');
        return this._getEditor().then(
            (editor) => {
                return new Promise(
                    (resolve, reject) => {
                        console.log('ZrcmsHtmlBlockEdit:getSaveData complete');
                        // @todo Fix this
                        //this.config.html = editor.getContent();
                        resolve(this.config);
                    }
                )
            }
        );
    }
}

window.ZrcmsHtmlBlockEdit = ZrcmsHtmlBlockEdit;
