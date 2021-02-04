import {LOGGED_USER} from "./mutation-types";

export default {
    [ LOGGED_USER ] (state, user) {
        state.logged_user = user
    }
}
