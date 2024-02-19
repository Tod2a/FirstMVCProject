import { setMiddleLine } from "./setMiddleLine.js";
import { showActiveDiv } from "./showActiveDiv.js";
import { addEventSubmit } from "./manageFrom.js";

//contact module to set all function for the contact page

//set the middle line for the function showActiveDiv
setMiddleLine();

//select all the section of the contact page
const elements = document.querySelectorAll('section');

//Add the event to the window, for each scroll activate de showActiveDiv function
window.addEventListener('scroll', function() {
    showActiveDiv(elements, 'contact-active');
});

//variables necessary to the function addEventSubmit and activation of this one
const url = window.location.href;
const container = document.querySelector('#contact-form');
const formTemp = document.querySelector('#contactFormJs');

addEventSubmit(url, formTemp, container);