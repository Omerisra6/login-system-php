export const UserInPop = ( user ) =>{
    
    const userInPopElement         = document.createElement( 'div' )
    userInPopElement.classList.add = 'logged-user'
    userInPopElement.dataset.id    = user[ 'id' ]

    userInPopElement.innerHTML = 
    `   
    <h2 class="pop-title"> ${ user[ 'username' ] }'s details </h2>

    <div class="user-detail">
        <h5> User Agent </h5>
        <h3> ${ user[ 'user_agent' ] } </h3>
    </div>

    <div class="user-detail">
        <h5> Register Time</h5>
        <h3> ${ user[ 'register_time' ] } </h3>
    </div>

    <div class="user-detail">
        <h5> Login count </h5>
        <h3> ${ user[ 'login_count' ] } </h3>
    </div>
    `

    return userInPopElement
}
