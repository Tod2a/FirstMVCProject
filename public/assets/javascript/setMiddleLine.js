function setMiddleLine ()
{
    const midLane = document.createElement('div');

    const styles = 
    {
        position: 'fixed',
        top: '50%',
    }

    for (const prop in styles)
    {
        midLane.style[prop] = styles[prop];
    }

    midLane.id = 'midLane';

    document.body.appendChild(midLane);
}

export { setMiddleLine };