let password =document.getElementsByName("password")[0];
    let passwordConfirm =document.getElementsByName("passwordConfirm")[0];
    let form = document.getElementById("form");
    form.addEventListener("submit", function(e) {
        e.preventDefault();
        if(password.value == passwordConfirm.value) {
            form.submit();
        
        }else {
            alert("Les mots de passes sont differents");
        }
    });