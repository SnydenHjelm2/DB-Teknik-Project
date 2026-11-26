const account = {
    elements: {
        log_in: {
            button: document.querySelector("#log-in button"),

            pwd: document.querySelector("#log-in .pwd"),

            status: document.querySelector("#log-in .status"),

            username: document.querySelector("#log-in .username"),
        },

        register: {
            button: document.querySelector("#register button"),

            pwd: document.querySelector("#register .pwd"),

            status: document.querySelector("#register .status"),

            username: document.querySelector("#register .username"),
        }
    }
}

const request = {
    async send(endpoint, method = "GET", body = null) {
        let options = {
            method: method.toUpperCase(),
            headers: {"content-type": "application/json"},
        }

        if (body) options.body = JSON.stringify(body);

        let resp = await fetch(`http://localhost:8000/${endpoint}`, options);

        return resp.json();
    }
}