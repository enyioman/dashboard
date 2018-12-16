export default class Gate {
    
    constructor(user) {
        this.user = user;
    }

    isAdmin() {
        return this.user.level === 'admin';
    }

    isModerator() {
        return this.user.level === 'moderator';
    }

    isUser() {
        return this.user.level === 'user';
    }

    isAdminOrModerator() {
        if (this.user.level === 'admin' || this.user.level === 'moderator')
        return true;
    }
}