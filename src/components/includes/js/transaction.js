/**
 * Backend for Transaction Page
 * @author   Steve Andreas Immanuel <13517039@std.stei.itb.ac.id>
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

const deleteButtons = document.getElementsByClassName('tp-button red-background');

function DeleteReview() {
  const request = new XMLHttpRequest();
  const method = 'DELETE';
  const urlDelete = '../API/Review.php';
  const orderId = this.id;
  const async = true;
  request.open(method, urlDelete, async);
  request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  request.send(`order_id=${orderId}`);
  request.onreadystatechange = function ProcessDelete() {
    if (this.readyState === 4 && this.status === 200) {
      window.location.replace('transaction.php');
    }
  };
}

for (let i = 0; i < deleteButtons.length; i += 1) {
  deleteButtons[i].addEventListener('click', DeleteReview, false);
}
