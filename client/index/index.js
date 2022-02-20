const loggedUsersTable = document.querySelector( '.logged-users-table-body' )
const logOutButton     = document.querySelector( '.logout-button' )

logOutButton.addEventListener( 'click', async () => {
    await logOutUser()
})

const getUsersInterval = window.setInterval( async () => {

    await getLoggedUsers()

}, 3000 );

const getLoggedUsers = async () => {

    await fetch( 'http://localhost:8000/server/get_logged_users.php', {
        method: 'GET'
    })
    .then( ( res ) => res.json())
    .then( data => {
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
}

const appendLoggedUser = ( user ) => {

    loggedUsersTable.innerHTML += `
        <tr>
            <td> ${ user[ 0 ] } </td>
            <td> ${ user[ 5 ] } </td>
            <td> ${ user[ 4 ] } </td>
            <td> ${ user[ 2 ] } </td>
        </tr>
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