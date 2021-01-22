class Toolbox {

    constructor(elements) {
        this.elements = elements
    }

    save(element, id, page) {
        let el = this.elements[element]
        el.element = element
        el.page = page

        axios['post']('modify/save-texts', el)
            .then(res => {
                $1('box-spinner-' + id).classList.add('d-none')
            })
            .catch(err => {
                alert('სამწუხაროდ, რაღაც შეცდომაა. სცადეთ ახლიდან')
                console.log(err)
                $1('box-spinner-' + id).classList.add('d-none')
            })
    }
}

function boxInputHandler(e, elm, id, page) {
    app[page].elements[elm]['value'] = e.target.value
}

function boxBoldHandler(e, elm, id, page) {
    if (app[page].elements[elm]['is-bold']) {
        app[page].elements[elm]['is-bold'] = false
        $('#' + 'input-' + id).removeClass('font-weight-bolder')
        $('#' + 'bold-' + id).removeClass('is-selected')
    } else {
        app[page].elements[elm]['is-bold'] = true
        $('#' + 'input-' + id).addClass('font-weight-bolder')
        $('#' + 'bold-' + id).addClass('is-selected')
    }
}

function boxFontsizeHandler(e, elm, id, page) {
    $1('input-' + id).style.fontSize = e.target.value + 'rem'
    app[page].elements[elm]['font-size'] = e.target.value
}

function boxColorHandler(e, elm, id, page) {
    $1('input-' + id).style.color = e.target.value
    $(e.target).next().css({'background': e.target.value})
    app[page].elements[elm].color = e.target.value
}

function boxUpdateHandler(elm, id, page) {
    $1('box-spinner-' + id).classList.remove('d-none')
    app[page].save(elm, id, page)
}
