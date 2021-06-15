import Plyr from 'plyr'
let codeEditor = document.querySelector('#codeEditor')

const player = new Plyr('#player')

let typeFile = [
    {"type": "c++", "mode": "text/x-c++src"},
    {"type": "csharp", "mode": "text/x-objectivec"},
    {"type": "css", "mode": "text/css"},
    {"type": "html", "mode": "text/html"},
    {"type": "js", "mode": "text/javascript"},
    {"type": "log", "mode": "text/mime"},
    {"type": "lua", "mode": "text/x-lua"},
    {"type": "php", "mode": "text/x-httpd-php"},
    {"type": "sql", "mode": "text/x-sql"},
    {"type": "txt", "mode": "text/mime"},
    {"type": "xml", "mode": "text/html"},
]

console.log(typeFile)

CodeMirror.fromTextArea(codeEditor, {
    lineNumbers: true,
    matchBrackets: true,
    tabSize: 2,
    mode: codeEditor.dataset.type,
    theme: 'monokai',
    gutters: ['error']
});






