
function showActiveDiv (elements, classCss)
{
    const midLane = document.querySelector('#midLane');
    let laneRect = midLane.getBoundingClientRect();

    elements.array.forEach(element => {
        let elementRect = element.getBoundingClientRect();

        let isActiveElement = (elementRect.top < laneRect.bottom &&
            elementRect.bottom > laneRect.top)
        
        if (isActiveElement)
        {
            element.classList.add(classCss);
        }
        else
        {
            element.classList.remove(classCss);
        }
    });
    
}

export {showActiveDiv};