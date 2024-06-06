

document.querySelectorAll("#openprofilebutton").forEach(element =>{
    element.addEventListener("click", function(){
        document.querySelector("#profile_sidebar").classList.toggle("profile_sidebar-mobopen");
    });
});


document.querySelectorAll("#opendashboardsidebarbutton").forEach(element =>{
    element.addEventListener("click", function(){
        document.querySelector("#dashboard_sidebar").classList.toggle("dashboard_sidebar-mobopen");
    });
});
