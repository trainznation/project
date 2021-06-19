/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************!*\
  !*** ./resources/js/project/show_message.js ***!
  \**********************************************/
var projectContainer = document.querySelector("#project");
var messageContainer = document.querySelector('[data-kt-element="messages"]');
var messages = [];
var newMessage = "";
Echo["private"]('chat').listen('MessageSentEvent', function (e) {
  messages.push({
    message: e.message.message,
    user: e.user,
    date: e.date
  });
});

function fetchMessage() {
  axios.get('/api/project/' + projectContainer.dataset.projectId + '/messages').then(function (response) {
    messages = response.data;
  });
}

function addMessage() {
  axios.post("/api/project/".concat(projectContainer.dataset.projectId, "/messages"), {
    messages: messages
  }).then(function (response) {
    messages.push({
      message: response.data.message,
      user: response.data.user,
      date: response.data.date
    });
  });
}

function sendMessage() {
  addMessage(messages);
  newMessage = '';
}

fetchMessage();
window.setTimeout(function () {
  console.log(messages);
  messageContainer.innerHTML = '';
  messages.data.forEach(function (message) {
    if (message.user.id !== projectContainer.dataset.userId) {
      messageContainer.innerHTML = "\n                <div class=\"d-flex justify-content-start mb-10\">\n                    <!--begin::Wrapper-->\n                    <div class=\"d-flex flex-column align-items-start\">\n                        <!--begin::User-->\n                        <div class=\"d-flex align-items-center mb-2\">\n                            <!--begin::Avatar-->\n                            <div class=\"symbol symbol-35px symbol-circle\">\n                                <img alt=\"Pic\" src=\"assets/media/avatars/150-15.jpg\" />\n                            </div>\n                            <!--end::Avatar-->\n                            <!--begin::Details-->\n                            <div class=\"ms-3\">\n                                <a href=\"#\" class=\"fs-5 fw-bolder text-gray-900 text-hover-primary me-1\">".concat(message.user.name, "</a>\n                                <span class=\"text-muted fs-7 mb-1\">").concat(message.date, "</span>\n                            </div>\n                            <!--end::Details-->\n                        </div>\n                        <!--end::User-->\n                        <!--begin::Text-->\n                        <div class=\"p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start\" data-kt-element=\"message-text\">").concat(message.message, "</div>\n                        <!--end::Text-->\n                    </div>\n                    <!--end::Wrapper-->\n                </div>\n                ");
    } else {
      messageContainer.innerHTML = "\n                <div class=\"d-flex justify-content-end mb-10\">\n                    <!--begin::Wrapper-->\n                    <div class=\"d-flex flex-column align-items-end\">\n                        <!--begin::User-->\n                        <div class=\"d-flex align-items-center mb-2\">\n                            <!--begin::Details-->\n                            <div class=\"me-3\">\n                                <span class=\"text-muted fs-7 mb-1\">".concat(message.date, "</span>\n                                <a href=\"#\" class=\"fs-5 fw-bolder text-gray-900 text-hover-primary ms-1\">Vous</a>\n                            </div>\n                            <!--end::Details-->\n                            <!--begin::Avatar-->\n                            <div class=\"symbol symbol-35px symbol-circle\">\n                                <img alt=\"Pic\" src=\"assets/media/avatars/150-2.jpg\" />\n                            </div>\n                            <!--end::Avatar-->\n                        </div>\n                        <!--end::User-->\n                        <!--begin::Text-->\n                        <div class=\"p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end\" data-kt-element=\"message-text\">").concat(message.message, "</div>\n                        <!--end::Text-->\n                    </div>\n                    <!--end::Wrapper-->\n                </div>\n                ");
    }
  });
}, 1200);
document.querySelector('[data-kt-element="input"]').addEventListener('keyup', function (e) {
  if (e.code === 'Enter') {
    sendMessage();
  }
});
/******/ })()
;