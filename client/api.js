const getLoggedUsers =  async () => {
    
    return await fetch( '/server/get_logged_users.php', {
        method: 'GET'
    }).then( res => res.json() )

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

export{
    getLoggedUsers,
    getUser,
    logOutUser
}