/**
 * Backend for Login Page
 * @author   Aldo Azali <13516125@std.stei.itb.ac.id>
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

// Method to check if email is valid
function isEmailValid(email) {
  // Regex took from https://www.w3resource.com/javascript/form/email-validation.php
  if (/^\w+(-]?\w+)*@\w+([-]?\w+)*(\.\w{2,4})+$/.test(email)) {
    return true;
  }
  return false;
}

// Method to get cookie from browser
// function getCookie(name) {
//   const cookie = document.cookie;
//   const prefix = name + '=';
//   let begin = cookie.indexOf('; ' + prefix);
//   if (begin === -1) {
//     begin = cookie.indexOf(prefix);
//     if (begin !== 0) {
//       return null;
//     }
//   } else {
//     begin += 2;
//     let end = document.cookie.indexOf(';', begin);
//     if (end === -1) {
//       end = cookie.length;
//     }
//   }
//   return decodeURI(cookie.substring(begin + prefix.length, end));
// }

// Method to do validation on client side to login
function loginHandler() {
  const loginForm = document.getElementById('login-form');
  loginForm.addEventListener('submit', event => {
    let email = document.getElementById('inputEmail').value;
    let password = document.getElementById('inputPassword').value;
    // Username empty
    if (!email) {
      alert('Email could not be empty!');
      event.preventDefault();
      return false;
    }
    else if (!isEmailValid(email)) {
      alert('Invalid Email Format!');
      event.preventDefault();
      return false;
    }
    // Password empty
    if (!password) {
      alert('Password could not be empty!');
      event.preventDefault();
      return false;
    }
    return true;
  });
}

// Doc ready
document.addEventListener(
  'DOMContentLoaded',
  () => {
    loginHandler();
  },
  false
);