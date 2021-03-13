import httpService from "../services/httpService";


export class Form {

    setupRedirect() {
        // httpService.setup({
        //     redirect: true,
        //     path: '/user/fields'
        // })
    }

    async getApiData() {
        const data = await httpService.get('docs/api/data');
        if (data.ploss && data.udanger) {

            ['ploss', 'udanger'].forEach(type => {
                data[type].forEach(item => {
                    if (item.name === ' ' || item.name === 'null') {
                        item.name = '';
                    }
                })
            });
            return data;

        } else {
            alert('დაფიქსირდა შეცდომა. სცადეთ გვერდის დარეფრეშება');
            throw new Error('Error occurred');
        }
    }

    async getPloss(){
        const data = await httpService.get('docs/all-ploss');
        data.forEach(p => {
            if (p.name === ' ') {
                p.name = ''
            }
        })
        return data;
    }

    async createPloss(fn){
        const res = await httpService.post('docs/new-ploss');
        fn(res);
    }


    async getUdanger(){
        const data = await httpService.get('docs/all-udanger');
        data.forEach(u => {
            if (u.name === ' ') u.name = ''
        })
        return data;
    }

    async createUdanger(fn){
        const res = await httpService.post('docs/new-udanger');
        fn(res);
    }

    async submit(url, data, fm){
        let fn = async () => {
            let ys = await prompt('Would you like to refresh the page ?');
            if (ys) {
                window.location = ''
            }
        }
        let res = await this.send('post', url, { data }, fn);
        if (res) {
            res = await this.send('post', 'docs/save-docs', fm, fn);
            $1('red_to_fin').submit();
        } else {
            console.log("error outer")
        }
    }


    send(type, url, data, fn){

        if (data && data.k) data.k = data.k.toString()

        return new Promise((resolve, reject) =>
        {
           axios[type](url,data)
              .then((res) => {
                  resolve(res.data)
              })
              .catch((errors) => {
                  alert('სამწუხაროდ, დაფიქსირდა შეცდომა. სცადეთ თავიდან')
                  console.log(errors.response.data)
                  reject(errors.response.data)
                  if (fn) (fn(errors.response.data))
              })
        })
    }

    getData(url='all-data'){
        return this.send('get', url, null, null);
    }

    getOtherData(url){
        return this.send('get', url, null, null);
    }
}

