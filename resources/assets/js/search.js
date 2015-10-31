import products from './products';
import request from 'superagent';
import { throttle } from 'lodash/function';

const search = document.querySelector('.search');
const searchField = search.querySelector('.search__field');
const searchTags = search.querySelector('.search__tags');
const searchAutocomplete = document.querySelector('.search__autocomplete');
const searchSubmit = document.querySelector('.search__submit');

let searchItems = [];
let lastSearchItem = 0;
let currentRequest;

const requestCompletion = throttle(function (query) {
  if (currentRequest) {
    currentRequest.abort();
  }

  currentRequest = request
    .post('api/search/product-tags/')
    .send({ query })
    .end((error, response) => {
      currentRequest = null;
      if (error === null) {
        searchAutocomplete.innerHTML = '';

        response.body.products
          .slice(0, 10)
          .forEach(current => {
            const li = document.createElement('li');
            li.addEventListener('click', () => {
              addTag(current);
              searchAutocomplete.innerHTML = '';
              searchField.value = '';
            });
            li.textContent = current;
            searchAutocomplete.appendChild(li);
          });
      }
    })
}, 250);

function removeTagClick(key) {
  const tag = searchItems.find(item => item.key === key);
  searchItems = searchItems.filter(item => item !== tag);
  searchTags.removeChild(tag.tag);
}

function removeLastTag() {
  if (searchItems.length === 0) return;
  const tag = searchItems.pop();
  searchTags.removeChild(tag.tag);
}

export function addTag(value) {
  if (value === '') return;
  const tag = document.createElement('div');
  const removeTag = document.createElement('button');
  const key = lastSearchItem++;
  tag.classList.add('search__tag');
  tag.textContent = value + ' ';

  removeTag.textContent = '×';
  removeTag.classList.add('search__tag__remove');
  removeTag.addEventListener('click', () => removeTagClick(key));

  tag.appendChild(removeTag);
  searchTags.appendChild(tag);

  searchItems = [...searchItems, {
    key,
    value,
    tag,
  }]
}

searchField.addEventListener('keyup', function(event) {
  requestCompletion(event.target.value);
});

searchField.addEventListener('keydown', function(event) {

  if (event.keyCode === 8 && event.target.value === '') {
    removeLastTag();
  } else if (event.keyCode === 188 || event.keyCode === 13) {
    // , or enter is pressed

    addTag(event.target.value);

    // clear the input
    event.target.value = '';

    event.preventDefault();
  } else {
  }
}, false);

searchSubmit.addEventListener('click', (event) => {
  console.log('sdaf', searchField.value);
  request
    .post('api/search/recipes')
    .send({
      products: [
        ...searchItems.map(item => item.value),
        searchField.value === '' ? undefined : searchField.value
      ]
    })
    .end((error, response) => {
      console.log(error, response);
    });
})
