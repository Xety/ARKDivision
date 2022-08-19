import './bootstrap';
import './vue';

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new window.bootstrap.Tooltip(tooltipTriggerEl));

const toastElList = document.querySelectorAll('.toast');
const toastList = [...toastElList].map(toastEl => new window.bootstrap.Toast(toastEl).show());