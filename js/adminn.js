function reload() {
    document.location.reload();
}

function loginForm() {
    let login = document.querySelector('#login').value;
    let password = document.querySelector('#password').value;
    fetch('php/auth.php', {
        method: 'POST',
        cache: 'no-cache',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            op: 'login',
            login: login,
            password: password
        })
    })
    .then(response => response.text())
    .then(body => {
        try {
            return JSON.parse(body);
        }
        catch {
            throw Error(body);
        }
    })
    .then(data => {
        if(data['status'] == 'OK') reload();
        else {
            console.log(data);
            alert(data['msg']);
        }
    })
    .catch(console.error);
}

addEventListener('DOMContentLoaded', () => {
    let form = document.querySelector('form');
    form.addEventListener('submit', event => event.preventDefault());
})