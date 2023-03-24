/*
    Funzioni condivise per la validazione lato client
*/

function ValidateText(text) {
    return text.match(/^[a-z][a-z\s]*$/i) != null;
}

function ValidateEmail(email) {
    return email.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/) != null;
}

function ValidatePassword(password) {
    return password.match(/^((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*){8,}$/) != null;
}