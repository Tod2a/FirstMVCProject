// Function to make an asynchronous HTTP request and handle the response
async function setRequest(url, requConfig)
{
    // Use the Fetch API to make the HTTP request
    const response = await fetch(url, requConfig);

    if (response.ok)
    {
        // If the response is successful, return the text content
        return await response.text();
    }
    else
    {
        // If the response is not successful, throw an error with status information
        throw new Error(`La requête HTTP a échoué : ${response.status} ${response.statusText}`);
    }
}

// Function to handle submitting a form asynchronously
async function postForm(UrlRequest, form, container)
{
    // Create a FormData object from the form
    const data = new FormData(form);

    // Configuration for the HTTP request, including method, headers, and body
    const requestConfig = 
    {
        method: "POST",
        // HTTP header config
        headers:
        {
            "X-Requested-With": "XMLHttpRequest"
        },
        body: data
    }

    try
    {
        // Make the asynchronous HTTP request using setRequest function
        const response = await setRequest(UrlRequest, requestConfig);
        console.log(response);

        // Replace the current form in the container with the new form received in the response
        let newform = replaceForm(container, response);

        // Add submit event listener to the new form
        addEventSubmit(UrlRequest, newform, container);
    }
    catch(error)
    {
        // Handle any errors that occur during the form submission
        console.log(`Erreur lors du formulaire : ${error.message}`);
    }
}

// Function to replace the existing form in a container with a new form
function replaceForm(container, newform)
{
    // Remove the old form from the container
    let oldform = container.querySelector('form');
    oldform.remove();

    // Set the innerHTML of the container to the new form's HTML
    container.innerHTML = newform;

    // Return the new form element
    return container.querySelector('form');
}

// Function to add a submit event listener to a form
function addEventSubmit(url, form, container)
{
    // Add a submit event listener to the form to prevent the default form submission
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Call postForm function to handle the asynchronous form submission
        postForm(url, form, container);
    });
}

// Export the addEventSubmit function for external use
export { addEventSubmit };
