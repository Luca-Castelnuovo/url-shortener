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

// TODO: create link
// POST - /link

const editLink = id => {
    // pre-fill modal with link details

    // open form

    // PATCH - /link/id

    alert(id);
}

const deleteLink = id => {
    // confirm request

    // send delete ajax request
    
    // DELETE - /link/id

    alert(id);
}
