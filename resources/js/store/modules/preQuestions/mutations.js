import {ACTION_TEST} from "./mutation-types";

export default {
    [ACTION_TEST]: (state, payload) => {
        state.test = false;
    }
}
