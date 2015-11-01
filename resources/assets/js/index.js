import { addTag } from './search';

window.addTag = addTag;

var sidebar = document.querySelector('.sidebar');
var sidebarToggle = document.querySelector('.sidebar-toggle');

sidebarToggle.addEventListener("click", function () {
    if (!sidebar.classList.contains("open")) {
        $('.sidebar').addClass('open');
        sidebarToggle.classList.add("open");
        sidebarToggle.innerHTML = '<i class="fa fa-angle-left"></i>';
    } else {
        console.log('ik ben onvoldoende');
        sidebar.classList.remove("open");
        sidebarToggle.classList.remove("open");
        sidebarToggle.innerHTML = '<i class="fa fa-angle-right"></i>';
    }
});