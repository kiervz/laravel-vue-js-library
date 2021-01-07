import Token from "./Token";
import AppStorage from "./AppStorage";

class User {

    responseAfterLogin(res) {
        const access_token = res.data.access_token;
        const user = res.data.user;
        const user_type = res.data.user_type;

        if (Token.isValid(access_token)) {
            AppStorage.store(access_token, user, user_type);
            window.location = '/dashboard';
        } else {
            this.$isHaveError = false
        }
    }

    hasToken() {
        const storedToken = AppStorage.getToken();

        if (storedToken) {
            return Token.isValid(storedToken) ? true : this.logOut();
        }

        return false;
    }

    loggedIn() {
        return this.hasToken();
    }

    logOut() {
        AppStorage.clear();
        window.location = '/login';
    }

    name() {
        if (this.loggedIn()) {
            return AppStorage.getUser();
        }
    }

    userType() {
        if (this.loggedIn()) {
            return AppStorage.getUserType();
        }
    }

    id() {
        if (this.loggedIn()) {
            const payload = Token.payload(AppStorage.getToken());

            return payload.sub;
        }
    }

    own(id) {
        return this.id() == id
    }

    admin() {
        return this.id() == 1
    }
    
}

export default User = new User();