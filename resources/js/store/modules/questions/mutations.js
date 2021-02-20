import {
    ACTION_TEST, REMOVE_DANGER_IMAGE,
    SET_API_DATA, SET_CONTROLS, SET_CONTROLS_DATA, SET_DANGER, SET_DANGER_IMAGE,
    SET_DANGERS, SET_ELEMENT, SET_PROCESS,
    TOGGLE_CONTROLS, TOGGLE_CONTROLS_LOADER,
    TOGGLE_DANGER_LOADER,
    TOGGLE_DANGERS, TOGGLE_MAIN_LOADER, UPDATE_STORE
} from "./mutation-types";
import {Data} from "../../../classes/Data";

export default {
    [ACTION_TEST]: (state, payload) => {
        state.test = false;
    },

    [SET_API_DATA]: (state, data) => {
        state.processes = data.processes;
        state.ploss = data.ploss;
        state.udanger = data.udanger;
    },

    [SET_PROCESS]: (state, id) => {
        state.processId = id;
    },

    [SET_DANGERS]: (state, data) => {
        state.dangers = data;
        state.currentDangers = data;
    },

    [TOGGLE_DANGERS]: (state, flag) => {
        state.showDangers = flag;
    },

    [TOGGLE_CONTROLS]: (state, flag) => {
        state.showControls = flag;
    },

    [TOGGLE_DANGER_LOADER]: (state, flag) => {
        state.showDangerLoader = flag;
    },

    [SET_DANGER]: (state, id) => {
        state.dangerId = id;
    },

    [TOGGLE_CONTROLS_LOADER]: (state, flag) => {
        state.showControlsLoader = flag;
    },

    [SET_CONTROLS_DATA]: (state, data) => {
        state.currentControls = data;
    },

    [SET_ELEMENT]: (state, elm) => {
        if (elm) {
            state.elm = elm
            state.data = elm.data;
        } else {
            state.data = new Data();
            state.elm = {pid: state.processId, did: state.dangerId, data: state.data};
            state.info.push(state.elm);
        }
    },

    [SET_DANGER_IMAGE]: (state, data) => {
        state.data.image = data.image;
        state.data.hasImage = data.hasImage;
        state.data.imageName = data.imageName;
        state.fm.append(data.imageName, data.fm.value);
    },

    [REMOVE_DANGER_IMAGE]: (state) => {
        state.data.image = '';
        state.data.hasImage = false;
        state.fm.delete(state.data.imageName);
        state.data.imageName = '';
        state.data.oldImage = false;
    },

    [UPDATE_STORE]: (state, fn) => {
        fn(state);
    },

    [TOGGLE_MAIN_LOADER]: (state, flag) => {
        state.loading = flag;
    }
}
