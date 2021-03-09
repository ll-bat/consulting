
import httpService from "../services/httpService";

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

    async getDangers(processId) {
        if (this.store.process[processId]) {
            return this.store.process[processId];
        } else {
            const data = await httpService.get(`api/${processId}/dangers`);
            if (data) {
                this.store.process[processId] = data;
            }
            return data;
        }
    }

    async getControls(dangerId) {
        if (this.store.danger[dangerId]) {
            return this.store.danger[dangerId];
        } else {
            const data = await httpService.get(`api/${dangerId}/controls`);
            if (data) {
                this.store.danger[dangerId] = data;
            }
            return data;
        }
    }
}

const fetcher = new Fetcher();
export default fetcher;
