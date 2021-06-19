let projectContainer = document.querySelector("#project")
let messageContainer = document.querySelector('[data-kt-element="messages"]')
let messages = []
let newMessage = ""

Echo.private('chat')
    .listen('MessageSentEvent', (e) => {
        messages.push({
            message: e.message.message,
            user: e.user,
            date: e.date
        });
    });

function fetchMessage() {
    axios.get('/api/project/'+projectContainer.dataset.projectId+'/messages')
        .then(response => {
            messages = response.data
        })
}

function addMessage() {
    axios.post(`/api/project/${projectContainer.dataset.projectId}/messages`, {
        messages
    }).then(response => {
        messages.push({
            message: response.data.message,
            user: response.data.user,
            date: response.data.date
        })
    });
}

function sendMessage() {
    addMessage(messages);
    newMessage = '';
}

fetchMessage()
window.setTimeout(() => {
    console.log(messages)
    messageContainer.innerHTML = '';
    messages.data.forEach(message => {
        if(message.user.id !== projectContainer.dataset.userId) {
            messageContainer.innerHTML = `
                <div class="d-flex justify-content-start mb-10">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column align-items-start">
                        <!--begin::User-->
                        <div class="d-flex align-items-center mb-2">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle">
                                <img alt="Pic" src="assets/media/avatars/150-15.jpg" />
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Details-->
                            <div class="ms-3">
                                <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">${message.user.name}</a>
                                <span class="text-muted fs-7 mb-1">${message.date}</span>
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::User-->
                        <!--begin::Text-->
                        <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">${message.message}</div>
                        <!--end::Text-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                `;
        } else {
            messageContainer.innerHTML = `
                <div class="d-flex justify-content-end mb-10">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column align-items-end">
                        <!--begin::User-->
                        <div class="d-flex align-items-center mb-2">
                            <!--begin::Details-->
                            <div class="me-3">
                                <span class="text-muted fs-7 mb-1">${message.date}</span>
                                <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">Vous</a>
                            </div>
                            <!--end::Details-->
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle">
                                <img alt="Pic" src="assets/media/avatars/150-2.jpg" />
                            </div>
                            <!--end::Avatar-->
                        </div>
                        <!--end::User-->
                        <!--begin::Text-->
                        <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text">${message.message}</div>
                        <!--end::Text-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                `;
        }
    })
}, 1200)

document.querySelector('[data-kt-element="input"]')
    .addEventListener('keyup', (e) => {
        if(e.code === 'Enter') {
            sendMessage()
        }
    })
