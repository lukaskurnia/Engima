/**
 * Backend for Buy Page
 * @author   Steve Andreas Immanuel <13517039@std.stei.itb.ac.id>
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

let hasSelected = false;
const modal = document.getElementById('confirmationModal');
const modalTitle = document.getElementById('modalTitle');
const modalDesc = document.getElementById('modalDesc');
const background = document.getElementById('mainContent');
const backButton = document.getElementById('backButton');
let data;
let dataHasLoaded = false;
let selectedSeat = null;
const userId = document.getElementById('userId').value;

const url = new URL(window.location.href);
const scheduleId = url.searchParams.get('schedule_id');
const request = new XMLHttpRequest();
let method = 'GET';
const urlAPI = '../API/Buy.php';
const async = true;

function DisableButton(buttonId) {
  document.getElementById(buttonId).disabled = true;
}
function GetSeats() {
  request.open(method, `${urlAPI}?schedule_id=${scheduleId}`, async);
  request.send();

  request.onreadystatechange = function ProcessMovie() {
    if (this.readyState === 4 && this.status === 200) {
      // document.getElementById('movieTitle').innerHTML = this.responseText;
      // document.getElementById ('movieTitle').innerHTML = "Hai";
      data = JSON.parse(this.responseText);
      document.getElementById('movieTitle').innerHTML = data.movie;
      document.getElementById('scheduleTime').innerHTML = data.datetime;
      dataHasLoaded = true;
      data.seats.forEach((seat) => {
        DisableButton(`btn${seat.seat_number}`);
      });
    }
  };
}


function formatPrice(num) {
  return `Rp ${num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')}`;
}

function ShowConfirmation() {
  method = 'POST';
  request.open(method, urlAPI, async);
  request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  request.send(`user_id=${userId}&schedule_id=${scheduleId}&seat_number=${selectedSeat}`);
  request.onreadystatechange = function ProcessConfirmation() {
    if (this.readyState === 4 && this.status === 200) {
      data = JSON.parse(this.responseText);
      if (data.status !== '200') {
        modalTitle.innerHTML = 'Transaction Failed';
        modalDesc.innerHTML = 'Your transaction could not be processed. Please try again.';
      }
      modal.style.display = 'flex';
      modal.style.zIndex = 5;
      background.style.opacity = 0.5;
      document.getElementById('txn_number').innerHTML = "Transaction no. " + data.txn_id;
      document.getElementById('virtual_acc').innerHTML = "Please Transfer to this Virtual Account : " + data.virtual_acc;
    }
  };
}

function SelectSeat() {
  if (dataHasLoaded) {
    if (!hasSelected) {
      const confirmationContent = document.getElementById('confirmationContent');
      confirmationContent.innerHTML = `
                <div class="bp-confirmation__movie">
                    <h3 class="bp-confirmation__movie--black">${data.movie}</h3>
                    <h4 class="bp-confirmation__movie--light">${data.datetime}</h4>
                </div>
                <div class="bp-confirmation__price">
                    <h3 id="seat-number">Seat #${this.innerHTML}</h3>
                    <h3>${formatPrice(40000)}</h3>
                </div>
                <div class="bp-confirmation__button-area">
                    <button id="confirmationButton" class="bp-confirmation__button"><b>Buy Ticket</b></button>
                </div>
            `;
      hasSelected = true;
      document.getElementById('confirmationButton').addEventListener('click', ShowConfirmation, false);
    } else {
      document.getElementById('seat-number').innerHTML = `Seat #${this.innerHTML}`;
    }
    selectedSeat = this.innerHTML;
  } else {
    // handle loading
  }
}


function GoBack() {
  window.history.back();
}


window.onclick = (event) => {
  if (event.target === modal) {
    modal.style.display = 'none';
    modal.style.zIndex = -5;
    background.style.opacity = 1;
    window.location.reload();
  }
};

backButton.addEventListener('click', GoBack, false);

for (let i = 1; i <= 30; i += 1) {
  document.getElementById(`btn${i}`).addEventListener('click', SelectSeat, false);
}

GetSeats();
// setInterval(GetSeats, 2000);
