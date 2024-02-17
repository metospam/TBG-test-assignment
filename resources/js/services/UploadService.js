import axios from "axios";

class UploadService {

    async uploadFile(file){
        const headers = {
            'Content-Type': "multipart/form-data",
        };

        return axios.post('api/v1/upload', {
            file: file,
        }, {headers})
    }

}

export default new UploadService();
