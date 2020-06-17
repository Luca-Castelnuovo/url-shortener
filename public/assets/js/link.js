function ratelimitSubmit() {
    formSubmit(
        document.querySelector('form#ratelimit'),
        '/ltc/ratelimit', // TODO: make /ltc/ dynamic
        false
    );
}
