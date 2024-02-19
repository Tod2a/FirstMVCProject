import { setMiddleLine } from "./setMiddleLine.js";
import { showActiveDiv } from "./showActiveDiv.js";
import { addEventSubmit } from "./manageFrom.js";

setMiddleLine();

const elements = document.querySelectorAll('section');


window.addEventListener('scroll', function() {
    showActiveDiv(elements, 'contact-active');
});


const url = window.location.href;
const container = document.querySelector('#contact-form');
const formTemp = document.querySelector('#contactFormJs');

addEventSubmit(url, formTemp, container);