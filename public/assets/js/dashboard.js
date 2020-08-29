document.addEventListener('DOMContentLoaded', function() {
    M.Tooltip.init(document.querySelectorAll('.tooltipped'), {
        position: 'top'
    });

    M.Modal.init(document.querySelectorAll('.modal'), {
        dismissible: false
    });
});

const createLinkForm = document.querySelector('form#linkCreate');
createLinkForm.addEventListener('submit', e => {
    e.preventDefault();
    const data = formDataToJSON(new FormData(createLinkForm));

    apiUse('post', '/link', data);
});

const deleteLink = id => {
    if (confirm('Are you sure?')) {
        apiUse('delete', `/link/${id}`);
    }
};
