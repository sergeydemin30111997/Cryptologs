document.querySelectorAll(".mx_button_act-openmodalwindow").forEach(element => {
    element.addEventListener("click", function () {
        if (element.hasAttribute("target_modal_id")) {
            document.querySelector("#modal_windows_container").classList.toggle("modal_windows_container-active");
            var targed_window = document.querySelector("#" + element.getAttribute("target_modal_id"));
            targed_window.classList.toggle("modal_window-active");
        } else {
            console.error("[.mx_button_act-openmodalwindow] doesnt have [target_modal_id] attribute!")
        }
    });
});
document.querySelectorAll(".mx_button_act-closemessagewindow").forEach(element => {
    element.addEventListener("click", function () {
        if (element.hasAttribute("target_modal_id")) {
            document.querySelector("#form_message").classList.toggle("form_message");
        } else {
            console.error("[.mx_button_act-closemessagewindow] doesnt have [target_modal_id] attribute!");
        }
    });
});
