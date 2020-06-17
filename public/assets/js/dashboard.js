document.addEventListener('DOMContentLoaded', function() {
    M.Tooltip.init(document.querySelectorAll('.tooltipped'), {
        position: 'top'
    });

    M.Modal.init(document.querySelectorAll('.modal'), {
        dismissible: false
    });
});

const copy = str => {
    const el = document.createElement('textarea');
    
    el.value = str;
    el.setAttribute('readonly', '');
    el.style.position = 'absolute';
    el.style.left = '-9999px';
    document.body.appendChild(el);

    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
};

const createLinkForm = document.querySelector('form#linkCreate');
createLinkForm.addEventListener('submit', e => {
    e.preventDefault();
    const data = formDataToJSON(new FormData(createLinkForm));

    apiUse('post', '/link', data);
});

const editLink = id => {
    // TODO: pre-fill modal with password (if set only show remove password btn) and expires

    // M.Modal.getInstance(
    //     document.querySelector(`.modal#edit`)
    // ).open();

    /*
    apiUse('put', `/file/${id}`, {
        password: '1234',
        expires_at: '2021-02-25'
    });
    */

    alert('Work in progress!');
};

const deleteLink = id => {
    if (confirm('Are you sure?')) {
        apiUse('delete', `/link/${id}`);
    }
};
