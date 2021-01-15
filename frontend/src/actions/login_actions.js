import axios from "axios";

import { LOGIN_USER } from "./types";
import { USER_SERVER } from "../components/Config.js";

export async function loginUser(dataToSubmit) {
  console.log("loginUser - fetch api - login_actions");
  const res = await axios.post(`${USER_SERVER}/login`, dataToSubmit, {
    "Content-Type": "application/json",
  });
  console.log("Res from server: ", res);
  return {
    type: LOGIN_USER,
    payload: res.data,
  };
}
