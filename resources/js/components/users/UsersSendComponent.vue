<script>
import UserService from "../../services/UserService";
import MessageMixin from "../../mixins/MessageMixin";

export default {
    mixins: [MessageMixin],
    props: ['userId'],

    data(){
        return {
            isLoading: false,
        }
    },

    methods: {
        sendFile() {
            let path = localStorage.getItem('pdfSrc');
            if (path) {
                this.message = 'Loading...';
                this.isLoading = true;

                UserService.sendToUser(this.userId, path)
                    .then(response => {
                        if (response.status === 200) {
                            localStorage.setItem('pdfSrc', '');
                            this.message = '';
                            this.isLoading = false;
                        }
                    })
                    .catch(error => {
                        console.log(error);
                        this.isError = true;
                        this.message = 'The entered data is incorrect, or the bot is not activated.';
                        this.isLoading = false;
                    });

            } else {
                this.isError = true;
                this.message = 'Upload PDF file';
            }
        },

        openAgree() {
            this.message = 'Are you sure you want to send the file?';
            this.isError = false;
        },
    },

    computed:{
        showSendButton(){
            return !this.isLoading;
        }
    }
}

</script>

<template>
    <button @click="openAgree" class="btn btn-success">
        Send
    </button>

    <div class="popup-message" v-show="messageIsExists">
        <span class="popup-message__content" :class="{ 'error': isError }">{{ message }}</span>
        <template v-if="!isError">
            <div class="popup-message__action">
                <button v-show="showSendButton" class="popup-message__close btn btn-success" @click="sendFile">
                    Send
                </button>
                <button class="popup-message__close btn btn-danger" @click="resetMessage">
                    Close
                </button>
            </div>
        </template>
        <button v-else class="popup-message__close btn btn-danger" @click="resetMessage">
            Close
        </button>
    </div>
</template>

