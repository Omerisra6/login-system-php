async function fetchWrapper(url, method = "GET", body = null) {
  const response = await fetch(url, {
    method,
    body,
  });

  const json = await response.json();
  return response.ok ? json : Promise.reject(json);
}

const getLoggedUsers = () => {
  return fetchWrapper("/user/get-logged");
};

const getUser = async (id) => {
  return fetchWrapper(`/user?id=${id}`);
};

const logOutUser = () => {
  return fetchWrapper("/user/logout");
};

const loginUser = (username, password) => {
  return fetchWrapper(`/user/login?username=${username}&password=${password}`);
};

const signupUser = (singupFormData) => {
  return fetchWrapper("/user/signup", "POST", singupFormData);
};

export { getLoggedUsers, getUser, logOutUser, loginUser, signupUser };
