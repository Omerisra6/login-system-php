import { getUser } from "../utils/api.js"
import { _, formatDate } from "../utils/helpers.js"
import { UserInPop } from "./UserInPop.js"

export const UserRow = ( user ) =>{
    
    const userRowElement         = document.createElement( 'tr' )
    userRowElement.classList.add = 'logged-user'
    userRowElement.dataset.id    = user[ 'id' ]

    const date = formatDate( user[ 'last_action' ] )
    userRowElement.innerHTML = 
    `   
    <td> ${ user[ 'username' ] } </td>
    <td> ${ user[ 'last_login' ] } </td>
    <td> ${ date  } </td>
    <td> ${ user[ 'ip' ] } </td>   
    `

    userRowElement.addEventListener( 'click', () => { showPopWithDetails( user ) } )
    return userRowElement
}

async function showPopWithDetails( user ) 
{
    const loggedUserDetailsContainer  = _( '.logged-user-details-container' )
    const loggedUserDetailsPopWrapper = _( '.user-details-pop-wrapper' )  

    const id    = user[ 'id' ]
    
    let userDetails
    try {
        userDetails = await getUser( id )    
    } catch (error) {
        alert( 'Something went wrong, please try refreshing the page')
    }

    loggedUserDetailsContainer.innerHTML = ''
    loggedUserDetailsContainer.appendChild( UserInPop( userDetails ) )
    loggedUserDetailsPopWrapper.classList.toggle( 'invisible' )
}
