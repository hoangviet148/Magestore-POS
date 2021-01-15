import React from "react";
import "./style.css";
import { connect } from "react-redux";
import {
  removeProduct,
  changeQuantity,
} from "../../../actions/product_actions";

const CartProduct = ({ product, removeProduct, changeQuantity }) => {
  return (
    <div className="shelf-item">
      <div className="shelf-item__del" onClick={() => removeProduct(product)} />
      <div className="shelf-item__thumb">
        <img
          classes="shelf-item__thumb"
          src={product.image}
          alt={product.title}
        />
      </div>

      <div className="shelf-item__details">
        <p className="title">{product.name}</p>
        <p className="desc">
          {product.sku}
          <br />
          <p>Quantity: {product.qty}</p>
        </p>
      </div>
      <div className="shelf-item__price">
        <p>$ {product.price}</p>
        <div>
          <button
            onClick={() => changeQuantity({ product: product, number: -1 })}
            disabled={product.qty === 1 ? true : false}
            className="change-product-button"
          >
            -
          </button>
          <button
            onClick={() => changeQuantity({ product: product, number: 1 })}
            className="change-product-button"
          >
            +
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
  removeProduct,
  changeQuantity,
};

export default connect(mapStateToProps, mapDispatchToProps)(CartProduct);
