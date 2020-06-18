function passwordSubmit() {
    const short_url = document.querySelector('input#short_url').value;
    const data = formDataToJSON(new FormData(document.querySelector('form#password')));

    if (!data['password']) {
        M.toast({html: 'Please enter password'});
        return;
    }

    apiUse('post', `${short_url}/password`, data);
}

function ratelimitSubmit() {
    const short_url = document.querySelector('input#short_url').value;
    const data = formDataToJSON(new FormData(document.querySelector('form#ratelimit')));

    apiUse('post', `${short_url}/ratelimit`, data);
}
