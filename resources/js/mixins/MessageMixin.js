const MessageMixin = {
    data() {
        return {
            message: '',
            isError: false
        }
    },
    methods:{
        resetMessage(){
            this.message = '';
        }
    },
    computed: {
        messageIsExists() {
            return this.message && this.message.length > 0;
        }
    }
};

export default MessageMixin;
