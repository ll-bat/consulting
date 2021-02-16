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
    // el.values[i] = (el.values[i] + 1) % 2
    let fn = (store) => {
        const el = store.data.control.find(e => e.id === id)
        if (!el) {
            store.data.control.push({id: id, value: i})
        } else {
            el.value = i
        }
    }
    this.update(fn);
}

export function toggleInput(id, i, type, cls) {
    // let sym = `${id}_${type}_${i}`;
    //
    // if (!cls) cls = 'checked-diff';
    //
    // const selector = $(`#chboxId${sym}`);
    //
    // if (!selector.hasClass('hovered-checkmark-diff')) {
    //     selector.addClass('hovered-checkmark-diff');
    //     $(`#checkedId${sym}`).addClass(cls);
    // } else {
    //     if (cls === 'checked-circle') return
    //     selector.removeClass('hovered-checkmark-diff');
    //     $(`#checkedId${sym}`).removeClass(cls);
    // }
}

export function checkPloss(id) {
    let el = this.data.ploss.find(p => p.id === id)

    if (!el) {
        return false;
    }

    return el.value & 1
}

export function togglePloss(id) {
    const fn = (store) => {
        let el = store.data.ploss.find(p => p.id === id)
        if (!el) {
            store.data.ploss.push({value: 1, id: id});
        } else {
            el.value = (el.value + 1) % 2;
        }
    }
    this.update(fn);
    // toggleInput(id, 0, 'ploss')
}

export function checkUdanger(id) {
    let el = this.data.udanger.find(e => e.id === id)

    if (!el) {
        return false;
    }

    return el.value & 1
}

export function toggleUdanger(id) {
    const fn = (store) => {
        let el = store.data.udanger.find(e => e.id === id)
        if (!el) {
            store.data.udanger.push({value: 1, id: id})
        } else {
            el.value = (el.value + 1) % 2
        }
    }
    this.update(fn);
    // toggleInput(id, 0, 'udanger')
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
        class: 'mb-4 rounded-8 test-shadow',
        style: 'border-radius:0;border-bottom:0;',
        text: 'აირჩიეთ პოტენციური ზიანი',
        data: this.ploss,
        update: this.helpers.togglePloss,
        check: this.helpers.checkPloss,
        type: 'ploss'
    })
    this.combined.push({
        class: 'pb-0 rounded-8 test-shadow',
        style: 'border-radius:0;padding-bottom:0 !important; ',
        text: 'ვინ იმყოფება საფრთხის ქვეშ',
        data: this.udanger,
        update: this.helpers.toggleUdanger,
        check: this.helpers.checkUdanger,
        type: 'udanger'
    })
}
