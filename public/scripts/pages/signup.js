import { signupUser } from "../utils/api.js";
import { _ } from "../utils/helpers.js";

const signupFormSubmitButton = _( '.signup-form-sumbit-button' )
const errorsContainer        = _( '.errors-container' )

signupFormSubmitButton.addEventListener( 'click', async ( e ) => { 

    e.preventDefault()

    errorsContainer.innerHTML = ''

    const singupForm     = _( '.signup-form' )
    const singupFormData = new FormData( singupForm )

    try {
        await signupUser( singupFormData )
        window.location.href = '/'
    } catch ( error ) {
        renderError( error )
    }    
})

function renderError( error ) 
{
    errorsContainer.innerHTML = error
}