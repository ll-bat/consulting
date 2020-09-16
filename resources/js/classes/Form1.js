






export class Form1 {

     
    getPloss(obj){
        this.send('get', 'docs/all-ploss', null, null).then((res) => {
            res.forEach(p => {
                if (p.name == ' ') p.name = ''
            })
            obj.ploss = res
            obj.created = false
        })
    }

    createPloss(fn){
        this.send('post', 'docs/new-ploss', null, null).then(res => fn(res))
    }


    getUdanger(obj){
        this.send('get', 'docs/all-udanger', null, null).then((res) => {
            res.forEach(u => {
                if (u.name == ' ') u.name = ''
            })
            obj.udanger = res
        })
    }

    createUdanger(fn){
        this.send('post', 'docs/new-udanger', null, null).then(res => fn(res))
    }

    submit(url, data, fm){
        let fn = () => {window.location=''}
        this.send('post', url, {data: data},fn).then(res => {
            console.log(res)
            this.send('post', 'docs/save-docs', fm,fn).then(res => {
                console.log(res)
                $1('red_to_fin').submit()
            })
        })
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
                  alert('Unfortunately, error occured. Please check the console tab')
                  console.log(errors.response.data)
                  reject(errors.response.data)
                  if (fn) (fn(errors.response.data))
              })
        })
    }

    getData(url='all-data',obj, fn){
        this.send('get', url, null, null).then(res => this.process(obj,res,fn))
    }

    getOtherData(url, obj){
        this.send('get', url, null, null).then(res => this.processOtherData(obj,res))
    }
    
    process(obj, data,fn){
        obj.process = data[0]
        obj.danger  = data[1]
        obj.control = data[2]
        if (fn) fn()
    }

    processOtherData(obj,data) {
        obj.ploss   = data[0]
        obj.udanger = data[1]
    }
}
