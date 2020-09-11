export class Form {
    constructor(){
        this.shared = ['id', 'title','hasImage', 'image', 'index', 'newindex', 'required']
    }

    submit(type, url, data, saving = [true], obj = {}, loading){

        if (saving == null) saving = [true]

        return new Promise((resolve, reject) =>
        {
           axios[type](url,data)
              .then((res) => {
                  saving[0] = false
                  obj[loading] = false
                  resolve(res.data)
              })
              .catch((errors) => {
                  saving[0] = false
                  obj[loading] = false
                  alert('Unfortunately, error occured. Please check the console tab')
                  console.log(errors.response.data)
                  reject(errors.response.data)
              })
        })
    }

    send(type,url,data, obj, saving = 'updating'){
         this.submit(type,url,data,null,obj, saving).then(res => console.log(res))
    }

    changeObject(oldObj, newObj){
         this.shared.forEach((key) => {
             newObj[key] = oldObj[key]
         })

         return newObj
    }

    deleteUpload(obj){
        obj.hasImage = false
        obj.image    = ''
    }

    update(obj){
       let comps = obj.components
       let data = {}
       comps.forEach(comp => {
           data[comp.id] = comp.index
       })

       this.send('post', '../user/docs/update',  {data: data}, obj)
    }

    setData(comp,data){
       comp.index = data.index
       comp.newindex = data.index
    }

    fset(obj, data){
        let keys = Object.keys(data)
        keys.forEach((key) =>{
            obj[key] = data[key]
        })

        return obj
    }
}
