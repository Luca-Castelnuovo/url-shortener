document.addEventListener('DOMContentLoaded', function() {
    M.Tooltip.init(document.querySelectorAll('.tooltipped'), {
        position: 'top'
    });

    M.Modal.init(document.querySelectorAll('.modal'), {
        dismissible: false
    });

    M.Datepicker.init(document.querySelectorAll('.datepicker'), {
        autoClose: true,
        firstDay: 1,
        format: 'yyyy-mm-dd',
        minDate: new Date(),
        showClearBtn: true
    })
});

const createLinkForm = document.querySelector('form#linkCreate');
createLinkForm.addEventListener('submit', e => {
    e.preventDefault();
    const data = formDataToJSON(new FormData(createLinkForm));

    apiUse('post', '/link', data);
});

const editLink = id => {
    let link = window._links.find(o => o.id === id);

    document.querySelector('input[name="id"]').value = id;
    document.querySelector('input[name="expires_at"]').value = link.expires_at;
    document.querySelector('input[name="password"]').value = link.password;

    M.updateTextFields();
    M.Modal.getInstance(document.querySelector(`form#linkEdit`)).open();
};

const editLinkForm = document.querySelector('form#linkEdit');
editLinkForm.addEventListener('submit', e => {
    e.preventDefault();
    const data = formDataToJSON(new FormData(editLinkForm));

    apiUse('put', `/link/${data.id}`, data);
});

const deleteLink = id => {
    if (confirm('Are you sure?')) {
        apiUse('delete', `/link/${id}`);
    }
};
