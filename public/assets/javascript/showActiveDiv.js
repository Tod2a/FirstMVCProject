// Function to show or hide elements based on their position relative to a target container
function showActiveDiv(elements, classCss)
{
    // Get the target container (midLane in this case)
    const midLane = document.querySelector('#midLane');

    // Get the bounding rectangle of the target container
    let laneRect = midLane.getBoundingClientRect();

    // Iterate through the elements array to check each element's position
    elements.array.forEach(element => {
        // Get the bounding rectangle of the current element
        let elementRect = element.getBoundingClientRect();

        // Check if the current element is within the vertical bounds of the target container
        let isActiveElement = (elementRect.top < laneRect.bottom &&
            elementRect.bottom > laneRect.top);
        
        // Add or remove the specified CSS class based on the element's position
        if (isActiveElement)
        {
            // If the element is within the target container, add the specified CSS class
            element.classList.add(classCss);
        }
        else
        {
            // If the element is outside the target container, remove the specified CSS class
            element.classList.remove(classCss);
        }
    });
}

// Export the showActiveDiv function for external use
export { showActiveDiv };
