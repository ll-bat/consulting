let dom = document

function  $1(id) {
    return document.getElementById(id);
}
function $$(cname){
    return document.getElementsByClassName(cname);
}

function $2(cname){
    return document.getElementsByClassName(cname);
}


function imageLoad(event, id, fn){
    let input = event.target
    let reader = new FileReader();
    reader.onload = function(){
        let dataURL = reader.result;

        if (id)
            $1(id).src = dataURL
        if (fn){
            fn(dataURL)
        }
    };
    reader.readAsDataURL(input.files[0]);
}

let u = {
    tr : 'transform',
    ts : 'transition',
    bg : 'background-color',
    bc : 'border-color',
    bb : 'border-bottom',
    btc: 'border-bottom-color',
    br : 'border',
    o  : 'opacity',
    b  : 'bottom',
    t  : 'top',
    l  : 'left',
    r  : 'right',
    dw : 'down',
    ml : 'margin-left',
    mt : 'margin-top',
    mr : 'margin-right',
    md : 'margin-down',
    d  : 'display',
    w  : 'width',
    h  : 'height'
}

let st = (o, d)=>{

    if (typeof d === "object")
        InitObj()
    else InitStr()

    function InitObj(){
        let keys = Object.keys(d)

        keys.forEach(key => {
            if (u[key])
              o.style[u[key]] = d[key]
            else o.style[key] = d[key]
        })
    }

    function InitStr(){
        if (typeof d !== "string")
        {
            alert("data is not of type string")
            return
        }

        if (o == null) return

        let s = d.split(';')
        s.forEach(c => {
            c = c.split(':')
            let key = c[0]
            if (u[key] !== undefined) key = u[key]
            o.style[key] = c[1]
        })

    }
}

let tout = (fn,t) => {
    setTimeout(fn,t)
}

let cnst = ''
function cl(el,c, t,  pr){
    if (c == '')
        el.className = cnst
    else {
        cnst = el.className
        el.className += (' ' + c)
    }
    t.loading = pr
}

function tgclass(el, c, t){
    let cls = el.className
    el.className += ' ' + c
    tout(() => {
        el.className = cls
    }, t)
}

function has(el, c){
    let cls = el.className.split(' ')
    return cls.includes(c)
}

function add(el, c){
    el.className += ' ' + c
}

function remove(el,c){
    el.className = el.className.split(' ').filter(n => n != c).join(' ')
}

function min(a,b){
    return Math.min(a,b)
}

function max(a,b){
    return Math.max(a,b)
}

function sin(a){
    return Math.sin(a)
}

function cos(a){
    return Math.cos(a)
}

function sqrt(a) {
    return Math.sqrt(a)
}

function abs(a){
    return Math.abs(a)
}

function floor(a) {
    return Math.floor(a)
}

function rand(n){
    return Math.floor(Math.random()*n)
}

function random(n){
    return Math.random()*n
}

function floor(n){
    return Math.floor(n)
}

Array.prototype.insert = function ( index, item ) {
    this.splice( index, 0, item );
};

function get_uuid(){
    var dt = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx'.replace(/[x]/g, function(c) {
        var r = (dt + Math.random()*16)%16 | 0;
        dt = Math.floor(dt/16);
        return (c=='x' ? r :(r&0x3|0x8)).toString(16);
    });
    return uuid;
}
