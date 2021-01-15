
const STATUS_OK = 300

function run(method, url, data, options = null) {
    return axios[method](url, data, options);
}

function errorHandler(status, data) {
    throw new Error(`Error occurred when processing your request. status - ${status}, body - ${data}`)
}

const httpService = {
    get : async (url, options) => {
        const {status, data} = await run('get', url, null, options);
        if (status < STATUS_OK) {
            return data;
        } else {
            errorHandler(status, data)
        }
    },
    post: async (url, params, options) => {
        const {status, data} = await run('post', url, params, options);
        if (status < STATUS_OK) {
            return data;
        } else {
            errorHandler(status, data);
        }
    }
}

export default httpService;
