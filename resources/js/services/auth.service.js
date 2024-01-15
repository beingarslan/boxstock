import axios from 'axios';

const API_URL = '/api/auth/';

class AuthService {
    login(data) {
        return axios
            .post(API_URL + 'login', {
                email: data.email,
                password: data.password
            })
            .then(response => {
                if (response.data.accessToken) {
                    localStorage.setItem('user', JSON.stringify(response.data));
                }
                return response.data;
            });
    }

    logout() {
        localStorage.removeItem('user');
    }

    register(data) {
        return axios.post(API_URL + 'register', {
            data: data
        });
    }
}

export default new AuthService();
