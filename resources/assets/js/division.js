import './bootstrap';
import './vue';

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new window.bootstrap.Tooltip(tooltipTriggerEl));

const toastElList = document.querySelectorAll('.toast');
const toastList = [...toastElList].map(toastEl => new window.bootstrap.Toast(toastEl).show());

const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new window.bootstrap.Popover(popoverTriggerEl))




/*app = {

    init: function() {
        alert('test');
    }

};
module.exports = app;*/