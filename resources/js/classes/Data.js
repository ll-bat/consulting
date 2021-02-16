export class Data {
    constructor() {
        this.image = '';
        this.hasImage = false;
        this.control = [];
        this.ploss = [];
        this.udanger = [];
        this.newControls = {first: [], second: []};
        this.newUdangers = [];
        this.newPloss = [];
        this.rpersons = [];
        this.etimes = {
            normal: [],
            time: []
        };
    }

    hasImage() {
        return this.image != ''
    }

    fset(obj) {
        let keys = Object.keys(obj)
        keys.forEach(c => {
            this[c] = obj[c]
        })
    }
}
