async function setRequest(url, requConfig)
{
    const response = await fetch(url, requConfig);

    if (response.ok)
    {
        return await response.text();
    }
    else
    {
        throw new Error(`La requête HTTP a échoué : ${response.status} ${response.statusText}`);
    }
}

async function postForm(UrlRequest, form, container)
{
    const data = new FormData(form);

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
        const response = await setRequest(UrlRequest, requestConfig);
        console.log(response);
        let newform = replaceForm(container, response);
        addEventSubmit(UrlRequest, newform, container);
    }
    catch(error)
    {
        console.log(`Erreur lors du formulaire : ${error.message}`);
    }
}

function replaceForm(container, newform)
{
    let oldform = container.querySelector('form');
    oldform.remove();

    container.innerHTML= newform;
    return container.querySelector('form');
}

function addEventSubmit(url, form, container)
{
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        postForm(url, form, container);
    });
}

export {addEventSubmit};