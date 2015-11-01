import { addTag } from './search';

window.addTag = addTag;

const sidebar = document.querySelector('.sidebar');
const sidebarToggle = document.querySelector('.sidebar-toggle');

sidebarToggle.addEventListener("click", function () {
    if (!sidebar.classList.contains("open")) {
        sidebar.classList.add("open");
        sidebarToggle.classList.add("open");
        sidebarToggle.innerHTML = '<i class="fa fa-angle-left"></i>';
    } else {
        sidebar.classList.remove("open");
        sidebarToggle.classList.remove("open");
        sidebarToggle.innerHTML = '<i class="fa fa-angle-right"></i>';
    }
});