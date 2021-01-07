class AppStorage {

    setToken(token) {
        localStorage.setItem('token', token);
    }

    setUser(user) {
        localStorage.setItem('user', user);
    }

    setUserType(user_type) {
        localStorage.setItem('user_type', user_type);
    }

    store(token, user, user_type) {
        this.setToken(token);
        this.setUser(user);
        this.setUserType(user_type);
    }

    clear() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        localStorage.removeItem('user_type');
    }

    getToken() {
        return localStorage.getItem('token');
    }

    getUser() {
        return localStorage.getItem('user');
    }

    getUserType() {
        return localStorage.getItem('user_type');
    }

}

export default AppStorage = new AppStorage();