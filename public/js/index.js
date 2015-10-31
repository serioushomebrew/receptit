(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

require('./search');

},{"./search":2}],2:[function(require,module,exports){
'use strict';

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) arr2[i] = arr[i]; return arr2; } else { return Array.from(arr); } }

var search = document.querySelector('.search');
var searchField = search.querySelector('.search__field');
var searchTags = search.querySelector('.search__tags');

var searchItems = [];
var lastSearchItem = 0;

function removeTagClick(key) {
  var tag = searchItems.find(function (item) {
    return item.key === key;
  });
  searchItems = searchItems.filter(function (item) {
    return item !== tag;
  });
  searchTags.removeChild(tag.tag);
}

function removeLastTag() {
  if (searchItems.length === 0) return;
  var tag = searchItems.pop();
  searchTags.removeChild(tag.tag);
}

function addTag(value) {
  if (value === '') return;
  var tag = document.createElement('div');
  var removeTag = document.createElement('button');
  var key = lastSearchItem++;
  tag.classList.add('search__tag');
  tag.textContent = value + ' ';

  removeTag.textContent = '×';
  removeTag.classList.add('search__tag__remove');
  removeTag.addEventListener('click', function () {
    return removeTagClick(key);
  });

  tag.appendChild(removeTag);
  searchTags.appendChild(tag);

  searchItems = [].concat(_toConsumableArray(searchItems), [{
    key: key,
    value: value,
    tag: tag
  }]);
}

searchField.addEventListener('keydown', function (event) {
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

},{}]},{},[1]);
