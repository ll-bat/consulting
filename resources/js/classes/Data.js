






export class Data {
     constructor(){
         this.image       = ''
         this.hasImage    = false
         this.control     = []
         this.ploss       = []
         this.udanger     = []
         this.newControls = [{value:''}]
         this.newUdangers = [{value:''}]
         this.rpersons    = [{value:''}]
         this.etimes      = [{value:''}]
     }

     hasImage(){
         return this.image != ''
     }

     fset(obj){
         let keys = Object.keys(obj)
         keys.forEach(c => {
             this[c] = obj[c]
         })
     }
}
