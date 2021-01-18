export function chboxId(d, i, n) {
    return `chboxId${d}_${n}_${i}`
};

export function checkedId(d, i, n) {
    return `checkedId${d}_${n}_${i}`
};

export function checkControl(id, i) {
    let el = this.data.control.find(e => e.id === id)

    if (!el) {
        return false
    } else {
        return el.value === i
    }
}

export function toggleControl(id, i, cls) {
    let el = this.data.control.find(e => e.id === id)
    // el.values[i] = (el.values[i] + 1) % 2
    if (!el) {
        this.data.control.push({id: id, value: i})
    } else {
        el.value = i
    }

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

export function checkPloss(id) {
    let el = this.data.ploss.find(p => p.id === id)

    if (!el) {
        return false;
    }

    return el.value & 1
}

export function togglePloss(id) {
    let el = this.data.ploss.find(p => p.id === id)

    if (!el) {
        tout(() => {
            el = {value: 1, id: id}
            this.data.ploss.push(el)
        })
    } else {
        tout(() => {
            el.value = (el.value + 1) % 2
        })
    }

    toggleInput(id, 0, 'ploss')
}

export function checkUdanger(id) {
    let el = this.data.udanger.find(e => e.id === id)

    if (!el) {
        return false;
    }

    return el.value & 1
}

export function toggleUdanger(id) {
    let el = this.data.udanger.find(e => e.id === id)

    if (!el) {
        tout(() => {
            el = {value: 1, id: id}
            this.data.udanger.push(el)
        })
    } else {
        tout(() => {
            el.value = (el.value + 1) % 2
        }, 20)
    }

    toggleInput(id, 0, 'udanger')
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

export function removeLoader() {
    this.loading = false;
    $('#show_data').removeClass('d-none');
    tout(() => $('#edit-process').css({'border-top': '10px solid #673ab7'}), 500)
}

export function setControlAnswers() {
    this.controlAnswers.push({
        text: 'არსებული',
        label: 'მონიშნეთ თუ სახეზეა, იცავთ, იყენებთ, მიღებულია ეს ზომა'
    });
    this.controlAnswers.push({
        text: 'დამატებითი',
        label: 'მონიშნეთ თუ სახეზე არ არის, არ გაქვთ მიღებულია ეს ზომა და შემდგომში მიიღებთ ამ ზომას (შეძლებისდაგვარად აუცილებელია)'
    })
    this.controlAnswers.push({text: 'არ არის აუცილებელი ან შესაძლებელი არ არის გამოყენება', label: ''});
}

export function combine() {
    this.combined = []
    this.combined.push({
        class: '',
        style: 'border-radius:0;border-bottom:5px solid lightgrey',
        text: 'აირჩიეთ პოტენციური ზიანი',
        data: this.ploss,
        update: this.helpers.togglePloss,
        check: this.helpers.checkPloss,
        type: 'ploss'
    })
    this.combined.push({
        class: 'pb-0',
        style: 'border-radius:0;padding-bottom:0 !important',
        text: 'ვინ იმყოფება საფრთხის ქვეშ',
        data: this.udanger,
        update: this.helpers.toggleUdanger,
        check: this.helpers.checkUdanger,
        type: 'udanger'
    })
}
