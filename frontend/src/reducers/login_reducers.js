import { LOGIN_USER } from "../actions/types";

export default function (state = {}, action) {
  console.log("login_reducers - reducers");
  switch (action.type) {
    case LOGIN_USER:
      console.log("Case Login_user");
      return { ...state, success: action.payload };
    default:
      return state;
  }
}
