
//function to make a mid lane used to detect if a section is active
function setMiddleLine ()
{
    //create the midlane
    const midLane = document.createElement('div');

    //array with the styles
    const styles = 
    {
        position: 'fixed',
        top: '50%',
    }

    //add styles to the div
    for (const prop in styles)
    {
        midLane.style[prop] = styles[prop];
    }

    //add the id
    midLane.id = 'midLane';

    //add the div to the body
    document.body.appendChild(midLane);
}

export { setMiddleLine };