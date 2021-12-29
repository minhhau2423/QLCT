'use strict'
$(document).ready(function () {
    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

    $('#dismiss, .overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.overlay').removeClass('active');
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });

    var tmp="";
    /* search list task */
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#list .hnotice"+tmp+"").not().filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    //deadline
    deadline.min = new Date().toISOString().split("T")[0];

    //filter-left
    $('#all').on('click',()=>{
        tmp="";
        $('.hsidebar-filter').removeClass('hsidebar-filter-active');
        $('#all').addClass('hsidebar-filter-active');
        $('.hnotice').show();
    })
    $('#success').on('click',()=>{
        tmp="-success";
        $('.hsidebar-filter').removeClass('hsidebar-filter-active');
        $('#success').addClass('hsidebar-filter-active');
        $('.hnotice').hide();
        $('.hnotice-success').show();
    })
    $('#new').on('click',()=>{
        tmp="-new";
        $('.hsidebar-filter').removeClass('hsidebar-filter-active');
        $('#new').addClass('hsidebar-filter-active');
        $('.hnotice').hide();
        $('.hnotice-new').show();
    })
    $('#rejected').on('click',()=>{
        tmp="-rejected";
        $('.hsidebar-filter').removeClass('hsidebar-filter-active');
        $('#rejected').addClass('hsidebar-filter-active');
        $('.hnotice').hide();
        $('.hnotice-rejected').show();
    })
    $('#waiting').on('click',()=>{
        tmp="-waiting";
        $('.hsidebar-filter').removeClass('hsidebar-filter-active');
        $('#waiting').addClass('hsidebar-filter-active');
        $('.hnotice').hide();
        $('.hnotice-waiting').show();
    })
    $('#inprogress').on('click',()=>{
        tmp="-inprogress";
        $('.hsidebar-filter').removeClass('hsidebar-filter-active');
        $('#inprogress').addClass('hsidebar-filter-active');
        $('.hnotice').hide();
        $('.hnotice-inprogress').show();
    })
    $('#cancel').on('click',()=>{
        tmp="-cancel";
        $('.hsidebar-filter').removeClass('hsidebar-filter-active');
        $('#cancel').addClass('hsidebar-filter-active');
        $('.hnotice').hide();
        $('.hnotice-cancel').show();
    })

    //

});

function showPassword() {
    let x = document.getElementById("password");
    let icon = document.getElementById("eye-icon")
    if (x.type === "password") {
        x.type = "text";
        icon.classList.remove("fa-eye")
        icon.classList.add("fa-eye-slash")
    } else {
        x.type = "password";
        icon.classList.remove("fa-eye-slash")
        icon.classList.add("fa-eye")
    }
}

//validate
(function () {  
    'use strict';  
    window.addEventListener('load', function () {
        var form = document.getElementById('form-add-task');  
        form.addEventListener('submit', function (event) {  
            if (form.checkValidity() === false) {  
                event.preventDefault();  
                event.stopPropagation();  
            }  
            form.classList.add('was-validated');  
        }, false);  
    }, false);  
})();

//list file
function updateList() {
    var input = document.getElementById('filepost');
    var output = document.getElementById('fileList');
    var children = "";
    for (var i = 0; i < input.files.length; ++i) {
        children += '<li>' + input.files.item(i).name + '</li>';
    }
    output.innerHTML = '<ul>'+children+'</ul>';
}

//download file
function download(name){
    window.location="download.php?path=files/"+name;
 }