const search = document.querySelector('.search');
const searchField = search.querySelector('.search__field');
const searchTags = search.querySelector('.search__tags');

let searchItems = [];
let lastSearchItem = 0;

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

function addTag(value) {
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

searchField.addEventListener('keydown', function(event) {
  console.log(event.keyCode);
  if (event.keyCode === 8 && event.target.value === '') {
    removeLastTag();
  } else if (event.keyCode === 188 || event.keyCode === 13) {
    // , or enter is pressed

    addTag(event.target.value);

    // clear the input
    event.target.value = '';

    event.preventDefault();
  }
}, false);
