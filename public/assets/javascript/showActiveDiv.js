function showActiveDiv (element)
{
    const midLane = document.querySelector('#midLane');
    let laneRect = midLane.getBoundingClientRect();

    let elementRect = element.getBoundingClientRect();

    let isActiveElement = (elementRect.top < laneRect.bottom &&
        elementRect.bottom > laneRect.top)

    if (isActiveElement)
    {
        element.style.backgroundColor = '#8b4513';
        element.style.color = 'white';
    }
    else
    {
        element.style.backgroundColor = "white";
        element.style.color = 'black';
    }
}

export {showActiveDiv};