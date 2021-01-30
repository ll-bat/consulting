
$(document).ready(() => {
    let data = {};
    const modal = $(`#partial-modal-content`);

    const createButton = $('#model-create-button');
    const _params = JSON.parse(createButton.attr('data-params'));
    const { onEnter } = _params;
    onEnter.forEach(field => {
        const el = modal.find(`[name=${field}`);
        el.on('keypress', e => {
            if (e.key === 'Enter') {
                el.trigger('change');
                $('#partial-modal-button').click();
            }
        })
    })

    createButton.on('click', e => {
        onNext(_params);
    })

    $('.modal-div .modal-element').each((idx, el) => {
        const params = JSON.parse($(el).attr('data-params'));

        $(el).on('click', e => {
            e.preventDefault()
            e.stopPropagation();
            onNext(params);
        })
    });
    $('.modal-div .modal-element-remove').each((idx, el) => {
        const { _nextUrl } = JSON.parse($(el).attr('data-params'));

        $(el).on('click', async e => {
            window.location = _nextUrl;
        })
    });
    function onNext({ fields, _nextUrl, title }) {
        data = {};
        for (let a in fields) {
            data[a] = fields[a];
            modal.find(`[name=${a}]`).removeClass('is-invalid is-valid').val(fields[a]);
        }
        modal.find('.modal-title').text(title);
        localStorage.setItem('_nextUrl', _nextUrl);
        $('#partial-modal-open-button').click();
    }
    $("#partial-modal-content .modal-input").each((idx, el) => {
        $(el).on('change', e => {
            if ($(el).hasClass('is-invalid')) {
                $(el).removeClass('is-invalid');
            }
            data[$(el).attr('name')] = e.target.value;
        })
    })
    $('#partial-modal-button').on('click', async e => {
        const url = localStorage.getItem('_nextUrl');
        if (!url) {
            alert("დაფიქსირდა შეცდომა. სცადეთ თავიდან");
            return;
        }

        for (let a in data) {
            if (data[a].length < 1) {
                alert('გთხოვთ, შეიყვანოთ მონაცემები');
                return;
            }
        }


        for (let a in data) {
            modal.find(`[name=${a}]`).removeClass('is-invalid');
        }

        modal.find('#modal-button-spinner').removeClass('d-none');

        const res = await $.post(url, data).catch(err => {
            const json = err.responseJSON;
            console.log(err);
            for (let a in json.errors) {
                modal.find(`[name=${a}]`).addClass('is-invalid');
            }
            modal.find('#modal-button-spinner').addClass('d-none');
            return;
        })


        if (res) {
            for (let a in data) {
                modal.find(`[name=${a}]`).removeClass('is-invalid').addClass('is-valid')
            }
            tout(() => {
                window.location = res;
            }, 400)

            modal.find('#modal-button-spinner').addClass('d-none');
        }
    })
})
