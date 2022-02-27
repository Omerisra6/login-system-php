const loggedUsersTable            = _( '.logged-users-table-body' )
const logOutButton                = _( '.logout-button' )
const loggedUserDetailsPopWrapper = _( '.user-details-pop-wrapper' )  
const loggedUserDetailsContainer  = _( '.logged-user-details-container' )
const closeUserDetailsPop         = _( '.close-user-details-pop' )
const currentUsername             = _( '.welcome-text' ).dataset.username

logOutButton.addEventListener( 'click', async () => {
    await logOutUser()
})

const getUsersInterval = window.setInterval( async () => {

    await getLoggedUsers()

}, 3000 );

closeUserDetailsPop.addEventListener( 'click', () => {
    loggedUserDetailsPopWrapper.classList.toggle( 'invisible' )
})

const renderLoggedUsers = ( users ) => {

    const usersWithoutCurrent = users.filter( user => {
        return user[ 'username' ] !== currentUsername
    })

    loggedUsersTable.innerHTML = ''

    usersWithoutCurrent.forEach( user => {
        renderLoggedUser( user )
    });

    attachListenersToUsers( )

}

const renderLoggedUser = ( user ) => {

    loggedUsersTable.innerHTML += `
        <tr class="logged-user" data-id=${ user[ 'id' ] }>
            <td> ${ user[ 'username' ] } </td>
            <td> ${ user[ 'last_login' ] } </td>
            <td> ${ new Date( user[ 'last_action' ] ) } </td>
            <td> ${ user[ 'ip' ] } </td>
        </tr>
    `
}

const renderUserToPop = ( userDetails ) => {

    loggedUserDetailsContainer.innerHTML = 
    `
        <h2 class="pop-title"> ${ userDetails[ 'username' ] }\`s details </h2>

        <div class="user-detail">
            <h5> User Agent </h5>
            <h3> ${ userDetails[ 'user_agent' ] } </h3>
        </div>

        <div class="user-detail">
            <h5> Register Time</h5>
            <h3> ${ userDetails[ 'register_time' ] } </h3>
        </div>

        <div class="user-detail">
            <h5> Login count </h5>
            <h3> ${ userDetails[ 'login_count' ] } </h3>
        </div>
        
    `
}

const getLoggedUsers =  async () => {

    await fetch( '/server/get_logged_users.php', {
        method: 'GET'
    })
    .then( ( res ) => res.json())
    .then( async ( data ) => {

        renderLoggedUsers( data )
    })
    .catch( ( error ) => {
        
        //On error ( user not logged ) redirect to login page
        alert( 'Error: You are not logged in, please login again' )
        window.location = '/client/forms/login.html' 
        

    })
}

const attachListenersToUsers = async() => {

    const loggedUsers = document.querySelectorAll( '.logged-user' )

    loggedUsers.forEach( user => {

        user.addEventListener( 'click', async () => {
            const id    = user.dataset.id
            const userDetails = await getUser( id )
            renderUserToPop( userDetails )
            loggedUserDetailsPopWrapper.classList.toggle( 'invisible' )
        })    
 
    });

}

const getUser = async ( id ) => {

    let userDetails

    await fetch( `/server/get_user.php?id=${ id }`, {
        method: 'GET'
    })
    .then( ( res ) => res.json())
    .then( data => {
       userDetails = data
    })
    .catch( ( ) => {
        
        //On error ( user not logged ) redirect to login page
        alert( 'Error: You are not logged in, please login again' )
        window.location = '/client/forms/login.html' 
        
    })

    return userDetails
}

const logOutUser =  async () => {
   
    await fetch( '/server/logout_user.php', {
        method: 'GET'
    }).then( () => {

        //Redirecting to login page
        window.location = '/client/forms/login.html'
        
    })
}

function _ ( selector ){

    return document.querySelector( selector )
}