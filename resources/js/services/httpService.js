
const STATUS_OK = 300

function run(method, url, data, options = null) {
    return axios[method](url, data, options);
}

function errorHandler(status, data) {
    alert('დაფიქსირდა შეცდომა. სცადეთ თავიდან')
    throw new Error(`Error occurred when processing your request. status - ${status}, body - ${data}`)
}

const httpService = {

    redirect : false,
    path : null,

    setup: (obj) => {
        for (let a in obj) {
            httpService[a] = obj[a];
        }
    },

    get : async (url, options) => {
        const {status, data} = await run('get', url, null, options).catch(err => {
            if (httpService.redirect) {
                window.location = httpService.path;
            } else {
                errorHandler(status, data)
                console.log(err);
            }
        });
        if (status < STATUS_OK) {
            return data;
        } else {
            errorHandler(status, data)
        }
    },

    post: async (url, params, options) => {
        const {status, data} = await run('post', url, params, options).catch(err => {
            if (httpService.redirect) {
                alert('დაფიქსირდა შეცდომა. სცადეთ გვერდის დარეფრეშება');
                return;
            }
        });
        if (status < STATUS_OK) {
            return data;
        } else {
            errorHandler(status, data);
        }
    }
}

export default httpService;
