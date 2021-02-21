import {
    ACTION_TEST, COMPLETE_DANGER, EDIT_DANGER, REMOVE_COMPLETED_DANGER, REMOVE_DANGER_IMAGE, RESTORE_CURRENT_DANGERS,
    SET_API_DATA, SET_CONTROLS_DATA, SET_DANGER, SET_DANGER_IMAGE,
    SET_DANGERS, SET_ELEMENT, SET_PROCESS,
    TOGGLE_CONTROLS, TOGGLE_CONTROLS_LOADER,
    TOGGLE_DANGER_LOADER,
    TOGGLE_DANGERS, TOGGLE_MAIN_LOADER, UPDATE_COMPLETED_DANGER, UPDATE_STORE
} from "./mutation-types";
import httpService from "../../../services/httpService";
import fetcher from "../../../classes/Fetcher";

export function letsTest({commit}) {
    commit(ACTION_TEST, false)
}

export async function getProcesses({commit}) {
    let data = await httpService.get('api/all-data');
    commit(SET_API_DATA, data);
    commit(TOGGLE_MAIN_LOADER, false);
}

export function setProcess({commit}, id) {
    commit(SET_PROCESS, id);
}

export async function getDangers({commit}, processId) {
    const data = await fetcher.getDangers(processId);
    commit(SET_DANGERS, data);
}

export function showDangersM({commit}, flag) {
    commit(TOGGLE_DANGERS, flag);
}

export function showControlsM({commit}, flag) {
    commit(TOGGLE_CONTROLS, flag);
}

export function showDangerLoaderM({commit}, flag) {
    commit(TOGGLE_DANGER_LOADER, flag);
}

export function setDanger({commit}, id) {
    commit(SET_DANGER, id);
}

export function showControlsLoaderM({commit}, flag) {
    commit(TOGGLE_CONTROLS_LOADER, flag);
}

export function setControls({commit}, data) {
    commit(SET_CONTROLS_DATA, data);
}

export async function getControls({commit}, dangerId) {
    const data = await fetcher.getControls(dangerId);
    commit(SET_CONTROLS_DATA, data);
}

export function setElement({commit}, elm) {
    commit(SET_ELEMENT, elm);
}

export function setDangerImage({commit}, data) {
    commit(SET_DANGER_IMAGE, data);
}

export function removeDangerImage({commit}) {
    commit(REMOVE_DANGER_IMAGE);
}

export function updateStore({commit}, fn) {
    commit(UPDATE_STORE, fn);
}

export function completeDanger({commit}) {
    commit(COMPLETE_DANGER);
}

export function editDanger({dispatch, commit}, dangerId) {
    commit(EDIT_DANGER, dangerId);
    dispatch('getControls', dangerId);
}

export function updateCompletedDanger({commit}) {
    commit(UPDATE_COMPLETED_DANGER);
}

export function removeCompletedDanger({commit}, dangerId) {
    commit(REMOVE_COMPLETED_DANGER, dangerId);
    commit(RESTORE_CURRENT_DANGERS);
}
