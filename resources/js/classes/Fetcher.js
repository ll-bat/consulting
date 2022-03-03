
import httpService from "../services/httpService";
import * as http from "http";

class Fetcher {
    constructor() {
        this.init();
    }

    init() {
        this.store = {
            process : {},
            danger : {}
        }
    }

    sleep(time) {
        return new Promise((res) => {
            tout(() => {
                res()
            }, time);
        })
    }

    async getDocumentData(documentId, queryParams) {
        return httpService.get(`api/get-document-data/${documentId}`, null, queryParams)
    }

    async getDangers(processId, queryParams) {
        if (this.store.process[processId]) {
            return this.store.process[processId];
        } else {
            const data = await httpService.get(`api/${processId}/dangers`, null, queryParams);
            if (data) {
                this.store.process[processId] = data;
            }
            return data;
        }
    }

    async getControls(dangerId, queryParams) {
        if (this.store.danger[dangerId]) {
            return this.store.danger[dangerId];
        } else {
            const data = await httpService.get(`api/${dangerId}/controls`, null, queryParams);
            if (data) {
                this.store.danger[dangerId] = data;
            }
            return data;
        }
    }
}

const fetcher = new Fetcher();
export default fetcher;
