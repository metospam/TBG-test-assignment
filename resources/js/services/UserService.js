import axios from "axios";

class UserService {

    API_URL = 'http://0.0.0.0/api/v1/users';

    async deleteUser(id) {
        return await axios.delete(this.API_URL + `/${id}`);
    }

    async fetchUsers(page, search = '') {
        return await axios.post(this.API_URL, {page: page, search: search});
    }
    //
    async updateUser(id, name, toSend, type) {
        return await axios.patch(this.API_URL + `/${id}`, {
            name: name,
            to_send: toSend,
            type: type,
        });
    }

    async createUser(name, toSend, type){
        return await axios.post(this.API_URL + '/create', {
            name: name,
            to_send: toSend,
            type: type,
        });
    }

    async sendToUser(userId, filePath){
        return await axios.post(this.API_URL + '/send', {
            user_id: userId,
            file_path: filePath,
        });
    }
}

export default new UserService();
