
const getLoggedUsers =  async () => {
    
    return await fetch( '/user/get-logged', {
        method: 'GET'
    }).then( res => res.json() )

}

const getUser = async ( id ) => {

    let userDetails

    await fetch( `/user/get?id=${ id }`, {
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

const logOutUser = async () => {
   
    await fetch( '/user/logout', {
        method: 'GET'
    }).then( () => {

       
        window.location.href = '/public/login.html'
    })
}

const loginUser = async ( username, password ) => {
    

    return await fetch( `/user/login?username=${ username }&password=${ password }`, {
        method: 'GET'
    })
} 

export{
    getLoggedUsers,
    getUser,
    logOutUser,
    loginUser
}