function passwordSubmit() {
    const data = formDataToJSON(new FormData(document.querySelector('form#password')));

    if (!data['password']) {
        M.toast({html: 'Please enter password'});
        return;
    }

    apiUse('post', '/ltc/password', data); // TODO: make /ltc/ dynamic
}

function ratelimitSubmit() {
    const data = formDataToJSON(new FormData(document.querySelector('form#ratelimit')));

    apiUse('post', '/ltc/ratelimit', data); // TODO: make /ltc/ dynamic
}
