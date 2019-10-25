/**
 * Backend for Review Page
 * @author   Steve Andreas Immanuel <13517039@std.stei.itb.ac.id>
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

let hasReviewed = false;
let rating = 10;
const stars = document.getElementsByClassName('rp-star-icon');
const submitButton = document.getElementById('submitButton');
const modal = document.getElementById('confirmationModal');
const movieTitle = document.getElementById('movieTitle');
const background = document.getElementById('mainContent');
const modalTitle = document.getElementById('modalTitle');
const modalDesc = document.getElementById('modalDesc');
const reviewInput = document.getElementById('review');
const backButton = document.getElementById('backButton');

const url = new URL(window.location.href);
const orderId = url.searchParams.get('order_id');

const request = new XMLHttpRequest();
const urlAPI = '../API/Review.php';
const async = true;
let method = 'GET';

const urlGET = `${urlAPI}?order_id=${orderId}`;
request.open(method, urlGET, async);
request.send();

request.onreadystatechange = function GetReview() {
  if (this.readyState === 4 && this.status === 200) {
    const data = JSON.parse(this.responseText);
    movieTitle.innerHTML = data.movie_name;
    if (data.review !== null) {
      reviewInput.value = data.review;
      document.getElementById(`star${data.rating}`).click();
      hasReviewed = true;
    }
  }
};

function SetRating() {
  rating = parseInt(this.id.substr(4), 10);
  for (let i = 0; i < stars.length; i += 1) {
    if (i <= rating - 1) {
      stars[i].style.color = '#febb3c';
    } else {
      stars[i].style.color = '#d7d7d7';
    }
  }
}

function SubmitReview() {
  const review = reviewInput.value || '';

  if (hasReviewed) {
    method = 'PUT';
  } else {
    method = 'POST';
  }

  request.open(method, urlAPI, async);
  request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  request.send(`order_id=${orderId}&rating=${rating}&review=${review}`);

  request.onreadystatechange = function PostReview() {
    if (this.readyState === 4 && this.status === 200) {
      if (this.responseText !== '200') {
        modalTitle.innerHTML = 'Fail to Sumbit Review';
        modalDesc.innerHTML = 'Your review could not be submitted. Please try again.';
      } else if (hasReviewed) {
        modalTitle.innerHTML = 'Review Updated';
        modalDesc.innerHTML = 'Your review has been updated. Thank you.';
      }
      modal.style.display = 'flex';
      modal.style.zIndex = 5;
      background.style.opacity = 0.5;
    }
  };
}

window.onclick = (event) => {
  if (event.target === modal) {
    window.location.replace('transaction.php');
  }
};

function GoBack() {
  window.history.back();
}

backButton.addEventListener('click', GoBack, false);
submitButton.addEventListener('click', SubmitReview, false);

for (let i = 0; i < stars.length; i += 1) {
  stars[i].addEventListener('click', SetRating, false);
}
