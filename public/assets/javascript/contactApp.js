import { setMiddleLine } from "./setMiddleLine.js";
import { showActiveDiv } from "./showActiveDiv.js";

setMiddleLine();

const elements = document.querySelectorAll('section');

elements.forEach(element =>
{
    showActiveDiv(element)
    window.addEventListener('scroll', function() {
        showActiveDiv(element);
    });
});