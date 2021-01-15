import React from "react";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

import {
  BrowserRouter as Router,
  Route,
  Switch,
  Redirect,
} from "react-router-dom";
import "./app.css";

// pages for this product
import HomePage from "./views/HomePage/HomePage.js";
import LoginPage from "./views/LoginPage.js";

//null   Anyone Can go inside
//true   only logged in user can go inside
//false  logged in user can't go inside

function App() {
  const RedirectToHome = ({ component: Component, ...rest }) => {
    return (
      <Route
        {...rest}
        render={(props) => {
          console.log("Redirect when cookie exists");
          const item = localStorage.getItem("staffName");
          // Do all your conditional tests here
          return (item !== undefined && item !== null) ? (
            <Redirect to="/home" />
          ) : (
              <Component {...props} />
          );
        }}
      />
    );
  };
  return (
    <div style={{ paddingTop: "0px", minHeight: "calc(100vh - 80px)" }}>
      <Router>
        <Switch>
          <Route path="/home" component={HomePage} />
          <RedirectToHome path="/" component={LoginPage} />
        </Switch>
      </Router>
      <ToastContainer />
    </div>
  );
}

export default App;
