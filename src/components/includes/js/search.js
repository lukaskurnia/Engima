/**
 * Backend for Search Page
 * @author   Steve Andreas Immanuel <13517039@std.stei.itb.ac.id>
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

const firstPage = 1;
let totalPage = null;
// const contentLimit = 20;
const mainContent = document.getElementById('mainContent');
const moviePage = [];
let totalResult = null;

const url = new URL(window.location.href);
const query = url.searchParams.get('query');

function DisableButton(buttonId) {
  document.getElementById(buttonId).disabled = true;
}

function ShowPagination(_currentPage) {
  const buttonToDisable = [];
  let pagination = `<div id="pageNumber" class="sp-page">
        <button onclick="callUpdateContent(${_currentPage - 1})" id="backButton" class="sp-page__text">
            Back
        </button>`;
  if (_currentPage === 1) {
    const upperBound = totalPage < _currentPage + 3 ? totalPage : 3;
    for (let i = _currentPage; i < upperBound + 1; i += 1) {
      pagination += `<button onclick="callUpdateContent(${i})" id="page${i}" class="sp-page__button">
                    ${i}
                </button>`;
    }
    buttonToDisable.push('backButton');
  } else if (_currentPage === totalPage) {
    const lowerBound = totalPage - 2 > 0 ? totalPage - 2 : 1;
    for (let i = lowerBound; i < totalPage + 1; i += 1) {
      pagination += `<button onclick="callUpdateContent(${i})" id="page${i}" class="sp-page__button">
                    ${i}
                </button>`;
    }
    buttonToDisable.push('nextButton');
  } else {
    for (let i = _currentPage - 1; i < _currentPage + 2; i += 1) {
      pagination += `<button onclick="callUpdateContent(${i})" id="page${i}" class="sp-page__button">
                    ${i}
                </button>`;
    }
  }
  pagination += `<button onclick="callUpdateContent(${_currentPage + 1})" id="nextButton" class="sp-page__text">
                Next
            </button>
        </div>`;
  mainContent.innerHTML += pagination;
  DisableButton(`page${_currentPage}`);
  buttonToDisable.forEach((buttonId) => {
    DisableButton(buttonId);
  });
}

function UpdateContent(desiredPage) {
  let contentWrapper = `<div class="sp-content__wrapper">
                          <h3><b>
                            Showing search result for keyword "${query}"
                          </b></h3>
                          <h3 class="sp-counter">
                            ${totalResult} results available
                          </h3>`;

  if (totalPage > 0) {
    const movieList = moviePage[desiredPage];
    for (let i = 0; i < movieList.results.length; i += 1) {
      let rating = movieList.results[i].vote_average;
      if (rating === null) {
        rating = 'No rating yet';
      }//  else {
      //   rating = Math.round(Number.parseFloat(rating) * 100) / 100;
      // }
      contentWrapper += `<div class="sp-content__row">
                  <div class="sp-content__left">
                      <div class="sp-content__image">
                          <img class="poster" src="https://image.tmdb.org/t/p/w500${movieList.results[i].poster_path}" alt="Movie poster">
                      </div>
                      <div class="sp-content__desc">
                          <p class="sp-title">${movieList.results[i].title}</p>
                          <div class="rating">
                              <img class="small-icon" src="../icons/star.png" alt="star">
                              <span class="rating__text">${rating}</span>
                          </div>
                          <p class="sp-description">${movieList.results[i].overview}</p>
                      </div>
                  </div>
                  <div class="sp-content__detail">
                    <a class="sp-content__detail" href="detail.php?movie_id=${movieList.results[i].id}">
                        <span>View details</span>
                        <img src="../icons/next.png" alt="detail">
                    </a>
                  </div>
              </div>`;
    }
  }
  contentWrapper += '</div>';
  mainContent.innerHTML = contentWrapper;

  if (totalPage > 1) {
    ShowPagination(desiredPage);
  }
}

// function callUpdateContent(desiredPage){
//   const request = new XMLHttpRequest();
//   const method = 'GET';
//   const api_key = '2dc9c50e0d06264a13a9e6953b693bba';
//   let page = desiredPage;
//   const urlGetData = `https://api.themoviedb.org/3/search/movie?api_key=${api_key}&query=${query}&page=${page}`;
//   const async = true;

//   request.open(method, urlGetData, async);
//   request.send();

//   request.onreadystatechange = function Process() {
//     if (this.readyState === 4 && this.status === 200) {      
//       mainContent.innerHTML = this.responseText;
//       const data = JSON.parse(this.responseText);
//       totalResult = data.total_results;
//       // mainContent.innerHTML = data.results.length;
      
//       totalPage = data.total_pages;
//       // for (let i = 0; i < totalPage; i += 1) {
//       moviePage[page] = data;
//       // }
      
//       UpdateContent(page);
//     }
//   };
// }

function callUpdateContent(desiredPage){
  const request = new XMLHttpRequest();
  const method = 'GET';
  let page = desiredPage;
  const urlGetData = `../API/MovieDB.php?query=${query}&page=${page}`;
  const async = true;

  request.open(method, urlGetData, async);
  request.send();

  request.onreadystatechange = function Process() {
    if (this.readyState === 4 && this.status === 200) {      
      
      // mainContent.innerHTML = this.responseText;

      const data = JSON.parse(this.responseText);
      totalResult = data.total_results;
      
      
      totalPage = data.total_pages;
      
      moviePage[page] = data;
      
      UpdateContent(page);
    }
  };
}


if (query !== null) {
    callUpdateContent(firstPage);
  }
else {
  mainContent.innerHTML = '<h3><b>Invalid, please input movie title...</b></h3>';
}
