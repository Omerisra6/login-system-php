const loggedUsersTable            = document.querySelector( '.logged-users-table-body' )
const logOutButton                = document.querySelector( '.logout-button' )
const loggedUserDetailsPopWrapper = document.querySelector( '.user-details-pop-wrapper' )  
const loggedUserDetailsContainer  = document.querySelector( '.logged-user-details-container' )
const closeUserDetailsPop         = document.querySelector( '.close-user-details-pop' )

logOutButton.addEventListener( 'click', async () => {
    await logOutUser()
})

const getUsersInterval = window.setInterval( async () => {

    await getLoggedUsers()

}, 3000 );

closeUserDetailsPop.addEventListener( 'click', () => {
    loggedUserDetailsPopWrapper.classList.toggle( 'invisible' )
})


const getLoggedUsers =  async () => {

    await fetch( 'http://localhost:8000/server/get_logged_users.php', {
        method: 'GET'
    })
    .then( ( res ) => res.json())
    .then( async ( data ) => {
        appendLoggedUsers( data )
    })
    .catch( ( ) => {
        
        //On error ( user not logged ) redirect to login page
        alert( 'Error: You are not logged in, please login again' )
        window.location = 'http://localhost:8000/client/forms/login.html' 
        

    })
}

const appendLoggedUsers = ( users ) => {

    loggedUsersTable.innerHTML = ''

    users.forEach( user => {
        appendLoggedUser( user)
    });

    attachListenersToUsers( )

}

const appendLoggedUser = ( user ) => {

    loggedUsersTable.innerHTML += `
        <tr class="logged-user" data-name=${ user[ 0 ] }>
            <td> ${ user[ 0 ] } </td>
            <td> ${ user[ 6 ] } </td>
            <td> ${ user[ 5 ] } </td>
            <td> ${ user[ 3 ] } </td>
        </tr>
    `
}

const attachListenersToUsers = async() => {

    const loggedUsers = document.querySelectorAll( '.logged-user' )

    loggedUsers.forEach( user => {

        user.addEventListener( 'click', async () => {
            const username    = user.dataset.name
            const userDetails = await getUser( username )
            console.log( userDetails )
            appendUserToPop( userDetails )
            loggedUserDetailsPopWrapper.classList.toggle( 'invisible' )
        })    
 
    });

}

const getUser = async ( username ) => {

    let userDetails

    await fetch( `http://localhost:8000/server/get_user.php?username=${ username }`, {
        method: 'GET'
    })
    .then( ( res ) => res.json())
    .then( data => {
       userDetails = data
    })
    .catch( ( ) => {
        
        //On error ( user not logged ) redirect to login page
        alert( 'Error: You are not logged in, please login again' )
        window.location = 'http://localhost:8000/client/forms/login.html' 
        
    })

    return userDetails
}

const appendUserToPop = ( userDetails ) => {

    loggedUserDetailsContainer.innerHTML = 
    `
        <h2 class="pop-title"> ${ userDetails[ 0 ] }\`s details </h2>

        <div class="user-detail">
            <h5> User Agent </h5>
            <h3> ${ userDetails[ 4 ] } </h3>
        </div>

        <div class="user-detail">
            <h5> Register Time</h5>
            <h3> ${ userDetails[ 0 ] } </h3>
        </div>

        <div class="user-detail">
            <h5> Register Time</h5>
            <h3> ${ userDetails[ 7 ] } </h3>
        </div>

        <div class="user-detail">
            <h5> Login count </h5>
            <h3> ${ userDetails[ 2 ] } </h3>
        </div>
        
    `
}

const logOutUser =  async () => {
   
    await fetch( 'http://localhost:8000/server/logout_user.php', {
        method: 'GET'
    }).then( () => {

        //Redirecting to login page
        window.location = 'http://localhost:8000/client/forms/login.html'
        
    })
}