import User from './User';

class Exception {

    handle(error) {
        this.isExpired(error.response.data.error);
    }

    isExpired(error) {
        if (error == 'Token is invalid' || error == 'There is problem with your token') {
            User.logOut()
        }
    }

}

export default Exception = new Exception();