import User from './User';

class Exception {

    handle(error) {
        this.isExpired(error.response.data.error);
        this.isExpired(error.response.data.message);
    }

    isExpired(error) {
        if (error == 'Token is invalid' || error == 'There is problem with your token' || error == "Token has expired") {
            User.logOut()
        }
    }

}

export default Exception = new Exception();