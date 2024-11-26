const bar = document.getElementById('bar');
const nav = document.getElementById('navbar');
const close = document.getElementById('close')

if (bar){
    bar.addEventListener('click',() =>{
        nav.classList.add('active');
    })
}

if (close){
    close.addEventListener('click', ()=>{
        nav.classList.remove('active')
    })
}

var login = document.getElementById("logIn");
var signup = document.getElementById("signUp");

function logIn(){
    login.style.display = 'flex';
    signup.style.display = 'none';
}

function signUp(){
    login.style.display = 'none';
    signup.style.display = 'flex';
}

document.getElementById('login-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent form submission for validation
    const firstName = document.getElementById('first-name').value.trim();
    const lastName = document.getElementById('last-name').value.trim();
    const password = document.getElementById('password').value;
    const birthday = document.getElementById('birthday').value;

    if (!validateName(firstName)) {
        alert("First Name must only contain letters.");
        return;
    }

    if (!validateName(lastName)) {
        alert("Last Name must only contain letters.");
        return;
    }

    if (!validatePassword(password)) {
        alert("Password must be at least 8 characters long, contain an uppercase letter, and a special character.");
        return;
    }

    if (!validateBirthday(birthday)) {
        alert("You must be at least 18 years old.");
        return;
    }

    alert("Form submitted successfully!");
    this.submit(); // Submit form after successful validation
});

function validateName(name) {
    const nameRegex = /^[A-Za-z]+$/;
    return nameRegex.test(name);
}


function validatePassword(password) {
    const passwordRegex = /^(?=.*[A-Z])(?=.*\W).{8,}$/;
    return passwordRegex.test(password);
}

function validateBirthday(birthday) {
    const birthDate = new Date(birthday);
    const today = new Date();
    const age = today.getFullYear() - birthDate.getFullYear();
    const monthDifference = today.getMonth() - birthDate.getMonth();
    const dayDifference = today.getDate() - birthDate.getDate();

    // Adjust age if the birthday has not occurred this year
    if (monthDifference < 0 || (monthDifference === 0 && dayDifference < 0)) {
        return age - 1 >= 18;
    }
    return age >= 18;
}
