<script>

import uploadService from "../services/UploadService";
import MessageMixin from "../mixins/MessageMixin";

export default {
    mixins: [MessageMixin],

    data() {
        return {
            file: null,
            iframeSrc: '',
        }
    },

    methods: {
        setFile(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;

            this.file = files[0];
        },

        uploadFile() {
            if (this.file) {
                uploadService.uploadFile(this.file)
                    .then(response => {
                        if (response.status === 200) {
                            let pdfSrc = response.data.src;

                            localStorage.setItem('pdfSrc', pdfSrc);
                            this.iframeSrc = pdfSrc;
                            this.isError = false;
                            this.message = 'File uploaded.';
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 400) {
                            let errors = error.response.data;

                            for (const key in errors) {
                                if (errors.hasOwnProperty(key) && errors[key].length > 0) {
                                    this.message = errors[key][0];
                                    this.isError = true;
                                    break;
                                }
                            }
                        }
                    })
            } else {
                this.isError = true;
                this.message = 'Upload file';
            }
        },
    },

    mounted() {
        let pdfSrc = localStorage.getItem('pdfSrc');
        if (pdfSrc) {
            this.iframeSrc = pdfSrc;
        }
    },
}

</script>

<template>
    <div class="upload">
        <h1 class="upload__title">upload PDF</h1>
        <form @submit.prevent="uploadFile" id="uploadForm" class="upload__form" method="post" enctype="multipart/form-data">
            <div class="upload__fake">
                <span>Upload here</span>
            </div>
            <input @change="setFile($event)" class="upload__file" type="file" name="pdfFile" id="pdfFile">
            <input type="submit" class="upload__btn btn btn-success" value="Upload PDF" name="submit">
        </form>

        <iframe v-show="iframeSrc" id="pdfViewer" :src="iframeSrc" width="600" height="400"></iframe>
    </div>

    <div class="popup-message" v-show="messageIsExists">
        <span class="popup-message__content" :class="{ 'error': isError }">{{ message }}</span>
        <button class="popup-message__close btn btn-danger" @click="resetMessage">
            Close
        </button>
    </div>
</template>

<style scoped>
.upload {
    margin-top: 30px;
    margin-bottom: 60px;
}

.upload__title {
    font-size: 30px;
    color: #2d9164;
    text-transform: uppercase;
    text-align: center;
    font-weight: 700;
}

.upload__form{
    margin-top: 15px;
    width: 300px;
    margin-inline: auto;
    display: flex;
    flex-direction: column;
    position: relative;
}

.upload__btn{
    margin-top: 10px;
    max-width: 300px;
    margin-inline: auto;
    cursor: pointer;
}

.upload__file{
    height: 100px;
    opacity: 0;
    cursor: pointer;
}

.upload__fake{
    position: absolute;
    top: 0;
    height: 100px;
    width: 100%;
    z-index: -1;
    border-radius: 4px;
    border: 2px solid #2d9164;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2d9164;
    font-weight: 700;
    text-transform: uppercase;
}

#pdfViewer{
    margin-top: 30px;
    margin-inline: auto;
    display: block;
}

</style>

