export const serevrURL = 'http://localhost:5555'
const getLoggedUsers =  async () => {
    
    return await fetch( serevrURL + '/get_logged_users.php', {
        method: 'GET'
    }).then( res => res.json() )

}

const getUser = async ( id ) => {

    let userDetails

    await fetch( serevrURL + `/get_user.php?id=${ id }`, {
        method: 'GET'
    })
    .then( ( res ) => res.json())
    .then( data => {
       userDetails = data
    })
    .catch( ( ) => {
        
        //On error ( user not logged ) redirect to login page
        alert( 'Error: You are not logged in, please login again' )
        window.location = '/login.html' 
        
    })

    return userDetails
}

const logOutUser =  async () => {
   
    await fetch( serevrURL + '/user_routes.php', {
        method: 'GET'
    }).then( () => {

        window.location = '/login.html'
        
    })
}

export{
    getLoggedUsers,
    getUser,
    logOutUser
}