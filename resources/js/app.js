require('./bootstrap');

window.mousetrap = require('mousetrap');
window.sortable = require('sortablejs');

window.TextAreaExtended = require('./modules/TextAreaExtended').default;
window.Scroller = require('./modules/Scroller').default;
window.flatpickr = require("flatpickr");

window.Notiflix = require("notiflix");
window.Notiflix.Notify.Init({
    position: 'center-top',
    useFontAwesome:true,
    fontAwesomeIconSize:"32px",
    width: "320px"
});

window.livewire.on('notify', data => {
    switch(data.level) {
        case 'success':
            return window.Notiflix.Notify.Success(data.message);
        case 'info':
            return window.Notiflix.Notify.Info(data.message);
        case 'warning':
            return window.Notiflix.Notify.Warning(data.message);
        case 'error':
            return window.Notiflix.Notify.Failure(data.message);
    }
});
