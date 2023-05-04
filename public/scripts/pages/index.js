import { getLoggedUsers, logOutUser  } from "../utils/api.js"
import { _  } from "../utils/helpers.js"
import { UserRow } from "../view-components/UserRow.js"
const loggedUsersTable            = _( '.logged-users-table-body' )
const logOutButton                = _( '.logout-button' )
const loggedUserDetailsPopWrapper = _( '.user-details-pop-wrapper' )  

window.addEventListener( 'load', async () => {

    renderLoggedUsers()
} )

window.setInterval( async () => {

    renderLoggedUsers()  
}, 3000);


logOutButton.addEventListener( 'click', async () => {

    logOutButton.disabled = true

    try {
        await logOutUser()
        window.location.href = '/login'
    } catch ( error ) {
        alert( 'Something went wrong, please try refreshing the page')
        logOutButton.disabled = false
    }
})


loggedUserDetailsPopWrapper.addEventListener( 'click', () => {

    loggedUserDetailsPopWrapper.classList.toggle( 'invisible' )
})

async function renderLoggedUsers(  ){

    let users
    try {
        users = await getLoggedUsers()
    } catch ( error ) {
        alert( 'Something went wrong, please try refreshing the page')
    }

    loggedUsersTable.innerHTML = ''

    users.forEach( user => {

        loggedUsersTable.appendChild( UserRow( user ) )
    });
}