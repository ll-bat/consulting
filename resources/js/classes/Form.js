






export class Form {

    async getPloss(){
        let {status,data} = await this.send('get', 'docs/all-ploss', null, null);
        if (status === 200){
            data.forEach(p => {
                if (p.name == ' ') p.name = ''
            })
            return data;
        }
        return null;
    }

    createPloss(fn){
        this.send('post', 'docs/new-ploss', null, null).then(res => fn(res))
    }


    async getUdanger(obj){
        let {status, data} = await this.send('get', 'docs/all-udanger', null, null);
        if (status == 200){
            data.forEach(u => {
                if (u.name == ' ') u.name = ''
            })
            return data;
        }
        return null;
    }

    createUdanger(fn){
        this.send('post', 'docs/new-udanger', null, null).then(res => fn(res))
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
                  alert('Unfortunately, error occurred. Please check the console tab')
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

