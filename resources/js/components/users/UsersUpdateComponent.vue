<script>
import UserService from "../../services/UserService";

export default {
    props: [
        'user',
        'currentPage',
        'search',
        'currentUserId',
    ],

    emits: [
        'resetCurrentUserId',
        'getResources',
    ],

    data() {
        return {
            currentUserName: '',
            currentUserToSend: '',
            currentUserType: null,
        }
    },

    methods: {
        async editUser(id) {
            await UserService.updateUser(id, this.currentUserName, this.currentUserToSend, this.currentUserType);
            this.$emit('resetCurrentUserId');
            this.$emit('getResources', this.currentPage, this.search);
        },

        setCurrentUserType(e) {
            this.currentUserType = e.target.value;
        },
    }
}
</script>

<template>
    <tr v-if="currentUserId === user.id" @keyup.enter="editUser(user.id)">
        <td style="text-align: center;">{{ user.id }}</td>
        <td><input type="text" v-model="currentUserName" placeholder="Name"></td>
        <td><input type="email" v-model="currentUserToSend" placeholder="To Send"></td>
        <td style="text-align: center;">
            <select v-model="currentUserType" name="type" id="">
                <option :selected="user.type === 'email'" value="email">
                    Email
                </option>
                <option :selected="user.type === 'telegram'" value="telegram">
                    Telegram
                </option>
            </select>
        </td>
        <td colspan="2">
            <button @click="editUser(user.id)" class="btn btn-success">
                Update
            </button>
        </td>
    </tr>
</template>

<style scoped>

</style>
