import {
    ACTION_TEST,
    COMPLETE_DANGER,
    EDIT_DANGER,
    INIT_OLD_DOC,
    REMOVE_COMPLETED_DANGER,
    REMOVE_DANGER_IMAGE,
    RESTORE_CURRENT_DANGERS,
    SET_API_DATA,
    SET_CONTROLS,
    SET_CONTROLS_DATA,
    SET_DANGER,
    SET_DANGER_IMAGE,
    SET_DANGERS,
    SET_ELEMENT,
    SET_PROCESS,
    TOGGLE_CONTROLS,
    TOGGLE_CONTROLS_LOADER,
    TOGGLE_DANGER_LOADER,
    TOGGLE_DANGERS,
    TOGGLE_MAIN_LOADER,
    UPDATE_COMPLETED_DANGER,
    UPDATE_STORE
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

        const mapper = state.completedDangers[state.processId] || {};

        if (state.unprocessedProcess[state.processId]) {
            state.unprocessedProcess[state.processId] = false;

            state.currentDangers = data.filter(danger => {
                if (mapper[danger.id]) {
                    mapper[danger.id] = danger.name;
                    return false;
                }
                return true;
            });

            const keys = Object.keys(mapper);

            const removedDangers = {};

            keys.forEach(danger => {
                if (typeof mapper[danger] === 'boolean') {
                    delete mapper[danger];
                    removedDangers[danger] = true;
                }
            });

            state.sendData = state.sendData.filter(el => !removedDangers[el.did]);

        } else {
            state.currentDangers = data.filter(danger => !mapper[danger.id]);
        }


    },

    [RESTORE_CURRENT_DANGERS]: (state) => {
        const mapper = state.completedDangers[state.processId] || {};
        state.currentDangers = state.dangers.filter(danger => !mapper[danger.id]);
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
        if (state.isUpdate) {
            state.isUpdate = false;
        }
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
    },

    [COMPLETE_DANGER]: (state) => {
        const {processId, dangerId} = state;

        if (!state.completedDangers[processId]) {
            state.completedDangers[processId] = {};
        }
        state.currentDangers = state.currentDangers.filter(danger => {
            if (danger.id === dangerId) {
                state.completedDangers[processId][danger.id] = danger.name;
                return false;
            }
            return true;
        });

        state.sendData.push({ pid: processId, did: dangerId, data: state.data });

        state.info = state.info.filter(e => e.did !== dangerId || e.pid !== processId);
        state.data = new Data();

        state.dangerId = -1;
        state.toBeWatched = !state.toBeWatched;
        state.showControls = false;

        const x = $("#dangers-part").position().top;
        window.scrollTo(x,0);
    },

    [EDIT_DANGER]: (state, dangerId) => {
        dangerId = parseInt(dangerId);
        const processId = state.processId;
        const elm = state.sendData.find(el => el.pid === processId && el.did === dangerId);

        state.data = JSON.parse(JSON.stringify(elm.data));
        state.dangerId = dangerId;
        state.isUpdate = true;
        state.showControls = true;
    },

    [UPDATE_COMPLETED_DANGER]: (state) => {
        const {processId, dangerId} = state;
        const elm = state.sendData.find(el => el.pid === processId && el.did === dangerId);
        elm.data = state.data;

        console.log(elm.data);

        state.data = new Data();
        state.dangerId = -1;
        state.isUpdate = false;
        state.showControls = false;

        const x = $("#dangers-part").position().top;
        window.scrollTo(x,0);
    },

    [REMOVE_COMPLETED_DANGER]: (state, dangerId) => {
        dangerId = parseInt(dangerId);
        const processId = state.processId;

        delete state.completedDangers[processId][dangerId];

        let elm = null;
        state.sendData = state.sendData.filter(el => {
            if (el.pid === processId && el.did === dangerId) {
                elm = el;
                return false;
            }
            return true;
        });

        state.info.push(elm);
        state.toBeWatched = !state.toBeWatched;

        if (state.dangerId === dangerId) {
            state.isUpdate = false;
        }

        const did = state.dangerId;
        state.dangerId = -1;
        state.dangerId = did;
    },

    [INIT_OLD_DOC]: (state, data) => {
        state.newDoc = false;
        state.sendData = data;

        data.forEach(el => {
            if (!state.completedDangers[el.pid]) {
                state.completedDangers[el.pid] = {};
            }
            state.completedDangers[el.pid][el.did] = true;
            state.unprocessedProcess[el.pid] = true;
        });
    }
}
