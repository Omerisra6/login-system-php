import { loginUser } from "../utils/api.js";
import { _ } from "../utils/helpers.js";

const loginFormSubmitButton = _( '.login-form-sumbit-button' )
const usernameInput         = _( '.username-input' )
const passwordInput         = _( '.password-input' )
const errorsContainer       = _( '.errors-container' )

loginFormSubmitButton.addEventListener( 'click', async ( e ) => { 

    e.preventDefault()

    errorsContainer.innerHTML = ''
    
    const username = usernameInput.value
    const password = passwordInput.value

    try {
        await loginUser( username, password )    
        window.location.href = '/'
    } catch ( error ) 
    {
        renderError( error )
    }    
})

function renderError( error ) 
{
    errorsContainer.innerHTML = error
}