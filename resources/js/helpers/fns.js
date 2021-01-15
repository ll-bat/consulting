export function chboxId(d, i, n) {
    return `chboxId${d}_${n}_${i}`
};

export function checkedId(d, i, n) {
    return `checkedId${d}_${n}_${i}`
};

export function checkControl(id, i) {
    let el = this.data.control.find(e => e.id == id)

    if (!el) {
        this.data.control.push({id: id, value: -1})
        return false
    } else return el.value == i
}

export function toggleControl(id, i, cls) {
    let el = this.data.control.find(e => e.id == id)
    // el.values[i] = (el.values[i] + 1) % 2
    el.value = i

    toggleInput(id, i, 'control', cls)
}

export function toggleInput(id, i, type, cls) {
    let sym = `${id}_${type}_${i}`;

    if (!cls) cls = 'checked';

    const selector = $(`#chboxId${sym}`);

    if (!selector.hasClass('hovered-checkmark')) {
        selector.addClass('hovered-checkmark');
        $(`#checkedId${sym}`).addClass(cls);
    } else {
        if (cls === 'checked-circle') return
        selector.removeClass('hovered-checkmark');
        $(`#checkedId${sym}`).removeClass(cls);
    }
}

export function checkPloss(i, id) {
    let el = this.data.ploss.find(e => e.ind == i)

    if (!el) {
        el = {ind: i, value: 0, id: id}
        this.data.ploss.push(el)
    }

    return el.value == 1
}

export function togglePloss(i, p) {
    let el = this.data.ploss[i]

    tout(() => {
        el.value = (el.value + 1) % 2
    }, 20)

    toggleInput(el.id, 0, 'ploss')
}

export function checkUdanger(i, id) {
    let el = this.data.udanger.find(e => e.ind == i)

    if (!el) {
        el = {ind: i, value: 0, id: id}
        this.data.udanger.push(el)
    }

    return el.value & 1
}

export function toggleUdanger(i, p) {
    let el = this.data.udanger[i]

    tout(() => {
        el.value = (el.value + 1) % 2
    }, 20)

    toggleInput(el.id, 0, 'udanger')
}

export function chainedAnim(cname, len, c) {
    if (c >= len) return

    let tme = 200
    for (let i = 0; i < len; i++) {
        let newt = tme + 500
        tout(() => {
            $(`.${cname}`).addClass('animated-border-left anim-half-width anim-margin')
        }, tme)
        tme = newt
    }
}
