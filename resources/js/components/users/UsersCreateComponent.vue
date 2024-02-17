<script>
import UserService from "../../services/UserService";
import MessageMixin from "../../mixins/MessageMixin";

export default {
    mixins: [MessageMixin],

    data() {
        return {
            name: '',
            toSend: '',
            type: 'email',
            errors: {
                name: false,
                toSend: false,
                type: false,
            },
        }
    },

    methods: {
        async createUser() {
            if (this.validateUserData()) {
                await UserService.createUser(this.name, this.toSend, this.type)
                    .then(response => {
                        if (response.status === 200) {
                            this.message = 'User successfully created';
                            this.isError = false;
                            this.clearForm();
                        }
                    })
                    .catch(error => {
                        console.log(error);
                        if (error.response.status === 400) {
                            let errors = error.response.data;

                            for (const key in errors) {
                                if (errors.hasOwnProperty(key) && errors[key].length > 0) {
                                    this.message = errors[key][0];
                                    this.errors[key] = true;
                                    this.isError = true;
                                    break;
                                }
                            }
                        }
                    });
            }
        },

        validateUserData() {
            let isValid = true;
            this.errors.name = !this.name.trim();
            this.errors.toSend = !this.toSend.trim();
            this.errors.type = !this.type;
            if (this.errors.name || this.errors.toSend || this.errors.type) {
                isValid = false;
            }
            return isValid;
        },

        handleErrors() {
            this.errors.name = !this.name.trim();
            this.errors.toSend = !this.toSend.trim();
            this.errors.type = !this.type;
        },

        clearForm() {
            this.name = '';
            this.toSend = '';
            this.type = 'email';
        },
    },
}
</script>

<template>
    <form class="custom-form" @submit.prevent="createUser">
        <h1 class="custom-form__title">
            Create User
        </h1>

        <div class="custom-form__input" :class="{ 'error': errors.name }">
            <label for="name" hidden>Name</label>
            <input autocomplete="off" type="text" id="name" name="name" placeholder="Name" v-model="name"
                   @input="handleErrors">
        </div>
        <div class="custom-form__input" :class="{ 'error': errors.toSend }">
            <label for="toSend" hidden>To Send</label>
            <input autocomplete="off" type="text" id="toSend" name="toSend" placeholder="To Send" v-model="toSend"
                   @input="handleErrors">
        </div>
        <div class="custom-form__input" :class="{ 'error': errors.type }">
            <label for="type" hidden>Type</label>
            <select v-model="type" name="type">
                <option value="email">
                    Email
                </option>
                <option value="telegram">
                    Telegram
                </option>
            </select>
        </div>

        <button type="submit" class="custom-form__btn btn btn-success">
            Create
        </button>
    </form>

    <div class="popup-message" v-show="messageIsExists">
        <span class="popup-message__content" :class="{ 'error': isError }">{{ message }}</span>
        <button class="popup-message__close btn btn-success" @click="resetMessage">
            Accept
        </button>
    </div>
</template>

<style scoped>
.custom-form {
    margin-top: 50px;
    max-width: 500px;
    margin-inline: auto;
    text-align: center;
}

.custom-form__title {
    margin-bottom: 20px;
    text-align: center;
    font-weight: 500;
    font-size: 20px;
    color: #2d9164;
}

.custom-form__input {
    margin-bottom: 10px;
}

.custom-form__input select{
    height: 45px;
    background-color: #2f2f2f;
    text-align: start;
}

.custom-form__input input {
    text-align: start;
    height: 45px
}

.custom-form__input.error input {
    border: 1px solid #d92c3f;
}

.custom-form__btn {
    margin-top: 20px;
    max-width: 300px;
    margin-inline: auto;
}
</style>
