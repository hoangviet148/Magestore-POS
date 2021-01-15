import React from "react";
import StaffInfo from "../StaffInfo";
import "./HomePage.css";
import Navbar from "../Navbar";
import Cart from "../FloatCart/FloatCart";
import ProductList from "../ProductList/ProductList";
function HomePage() {
  return (
    <div className="container-fluid h-100 border">
      <div className="row h-15 p-4">
        <StaffInfo />
        <Navbar />
      </div>

      <div className="row h-85 p-2 border">
        <div className="col-3" style={{ height: window.innerHeight }}>
          <Cart />
        </div>
        <div className="col-9 h-100">
          <ProductList />
        </div>
      </div>
    </div>
  );
}

export default HomePage;
