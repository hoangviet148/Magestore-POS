import React, { useEffect, useState } from "react";
import { connect } from "react-redux";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faShoppingBag } from "@fortawesome/free-solid-svg-icons";
import CartProduct from "./CartProduct";
import "./style.css";
import {
  requestCheckout,
  createQuote,
  getCart,
} from "../../../actions/product_actions";
import { toast } from "react-toastify";

const FloatCart = ({ carts, requestCheckout, createQuote, getCart }) => {
  const totalCart =
    (carts &&
      carts.carts.reduce((total, currentValue) => {
        return (total += currentValue.qty * currentValue.price);
      }, 0)) ||
    0;

  useEffect(() => {
    console.log("carts: ", carts);
    console.log("useEffect - FloatCart");
    if (!localStorage.getItem("quoteId")) {
      createQuote();
      getCart();
    } else {
      getCart();
    }
  }, [carts.cartAdd, carts.cartDelete, carts.cartUpdate]);

  const handleCheckout = () => {
    requestCheckout();
    setTimeout(() => {
      toast.success("Checkout Success!", {
        position: toast.POSITION.TOP_CENTER,
      });
    }, 3000);

    console.log("carts: ", carts.carts);
  };

  return (
    <div className="h-100">
      <div className="d-flex align-items-center">
        <FontAwesomeIcon icon={faShoppingBag} className="fa-2x" />
        <p className="d-flex justify-content-center display-4">Cart</p>
      </div>
      <div className="scrollbar">
        <div className="row">
          <div className="col-sm-12 col-md-12 col-md-offset-1">
            <table className=" table table-hover">
              <tbody>
                {carts &&
                  carts.carts.map((product) => (
                    <CartProduct product={product} key={product.id} />
                  ))}
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div className="position-absolute fixed-bottom">
        <div className="bg-light list-group-item d-flex justify-content-between">
          <span>Total (USD)</span>
          <strong>$ {totalCart}</strong>
        </div>
        <div className="d-flex justify-content-center mt-2">
          <button
            type="button"
            className="btn btn-success w-100"
            onClick={handleCheckout}
          >
            Checkout
          </button>
        </div>
      </div>
    </div>
  );
};

const mapStateToProps = (state) => {
  return state;
};

const mapDispatchToProps = {
  requestCheckout,
  createQuote,
  getCart,
};

export default connect(mapStateToProps, mapDispatchToProps)(FloatCart);
