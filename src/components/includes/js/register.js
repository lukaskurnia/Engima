const usernameField = document.getElementById('username');
const emailField = document.getElementById('email');
const phoneField = document.getElementById('phone_number');
const passwordField = document.getElementById('password');
const confPasswordField = document.getElementById('confirm_password');
const form = document.getElementById('register-form');
const realFile = document.getElementById('imageFile');
const customButton = document.getElementById('customButton');
const customText = document.getElementById('profile_picture');

let usernameValid = false;
let emailValid = false;
let phoneValid = false;
let passwordValid = false;

const request = new XMLHttpRequest();
const method = 'GET';
const async = true;

function isEmailValid(email) {
  return (/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(email));
}

function isUserNameValid(name) {
  return (/^[0-9a-zA-Z_]+$/.test(name));
}

function isPhoneValid(phone) {
  return /^([0-9]{9,12})$/.test(phone);
}

function isPasswordSame(pass, confPass) {
  return pass === confPass;
}

function checkUsername() {
  const message = document.getElementById('usernameMessage');
  const username = this.value;
  usernameValid = false;
  if (isUserNameValid(username)) {
    const url = `../API/Register.php?username=${username}`;
    request.open(method, url, async);
    request.send();
    request.onreadystatechange = function CheckUnique() {
      if (this.readyState === 4 && this.status === 200) {
        if (JSON.parse(this.responseText).length === 0) {
          usernameField.style.border = 'solid 2px green';
          message.style.display = 'none';
          usernameValid = true;
        } else {
          message.innerHTML = `Username ${username} is exist! Please use another username`;
          usernameField.style.border = 'solid 2px red';
          message.style.display = 'flex';
        }
      }
    };

  } else {
    usernameField.style.border = 'solid 2px red';
    message.style.display = 'flex';
  }
}

function checkEmail() {
  const message = document.getElementById('emailMessage');
  emailValid = false;
  if (isEmailValid(this.value)) {
    emailField.style.border = 'solid 2px green';
    message.style.display = 'none';
    emailValid = true;
  } else {
    emailField.style.border = 'solid 2px red';
    message.style.display = 'flex';
  }
}

function checkPhone() {
  phoneValid = false;
  const message = document.getElementById('phoneMessage');
  if (isPhoneValid(this.value)) {
    phoneField.style.border = 'solid 2px green';
    message.style.display = 'none';
    phoneValid = true;
  } else {
    phoneField.style.border = 'solid 2px red';
    message.style.display = 'flex';
  }
}

function checkConfPassword() {
  const message = document.getElementById('confirmPassMessage');
  passwordValid = false;
  if (isPasswordSame(this.value, passwordField.value)) {
    passwordField.style.border = 'solid 2px green';
    confPasswordField.style.border = 'solid 2px green';
    message.style.display = 'none';
    passwordValid = true;
  } else {
    passwordField.style.border = 'solid 2px red';
    confPasswordField.style.border = 'solid 2px red';
    message.style.display = 'flex';
  }
}

function preventSubmit(e) {
  if (!(usernameValid && emailValid && phoneValid && passwordValid)) {
    e.preventDefault();
  }
}

function clickRealButton() {
  realFile.click();
}

function showPath() {
  if (this.value) {
    customText.value = this.value.split('\\').pop().split('/').pop();
  }
}

customButton.addEventListener('click', clickRealButton, false);
realFile.addEventListener('change', showPath, false);
usernameField.addEventListener('keyup', checkUsername, false);
emailField.addEventListener('keyup', checkEmail, false);
phoneField.addEventListener('keyup', checkPhone, false);
confPasswordField.addEventListener('keyup', checkConfPassword, false);
form.addEventListener('submit', preventSubmit, false);
