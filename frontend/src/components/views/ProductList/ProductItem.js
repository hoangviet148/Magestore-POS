import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCartPlus } from "@fortawesome/free-solid-svg-icons";
import { connect } from "react-redux";
import { addToCart } from "../../../actions/product_actions";
import PropTypes from "prop-types";
import React, { useState } from "react";
import Radio from "@material-ui/core/Radio";
import axios from "axios";

const Modal = require("react-bootstrap").Modal;
const Button = require("react-bootstrap").Button;

function ProductItem({ product, addToCart }) {
  const { sku, name = {}, image, price } = product || {};
  const [modalShow, setModalShow] = useState(false);
  const [color, setColor] = useState(null);
  const [size, setSize] = useState(null);
  const colors = new Set();
  const sizes = new Set();

  product.childItems.map((p) => {
    colors.add(p.color.label);
    sizes.add(p.size.label);
  });
  const handleAddToCart = () => {
    console.log("handle add to cart");
    if (product.type_id === "configurable") {
      console.log("case configurable: ", modalShow);
      setModalShow(true);
    } else {
      addToCart(product);
    }
  };

  const onClose = () => {
    setModalShow(false);
  };

  const onAddConfigProductToCart = async () => {
    const p = product.childItems.filter(
      (p) => p.color.label === color && p.size.label === size
    );
    const entity_id = p[0].entity_id;
    console.log("entity_id: ", entity_id);
    const res = await axios.get(
      `http://localhost:80/magento235/rest/V1/staff/getProduct?
      searchCriteria[filter_groups][0][filters][0][field]=type_id&
      searchCriteria[filter_groups][0][filters][0][value]=simple&
      searchCriteria[filter_groups][0][filters][0][condition_type]=eq&
      searchCriteria[filter_groups][0][filters][0][field]=entity_id&
      searchCriteria[filter_groups][0][filters][0][value]=${entity_id}&
      searchCriteria[filter_groups][0][filters][0][condition_type]=eq&
      `,
      {
        "Content-Type": "application/json",
      }
    );
    console.log("res: ", res);
    addToCart(res.data.items[0]);
    setModalShow(false);
  };

  const handleSizeChange = (event) => {
    setSize(event.target.value);
  };

  const handleColorChange = (event) => {
    setColor(event.target.value);
  };
  return (
    <div className="col-sm-6 col-md-3 country-card">
      <div className="country-card-container border-gray rounded border mx-0 my-1 d-flex flex-row align-items-center p-1.1 bg-light">
        <div className="h-100 position-relative border-gray border-right px-4 bg-white rounded-left">
          <img
            className="d-block h-100"
            src={image}
            alt="image"
            width="80px !important"
            height="100% !important"
          />
        </div>

        <div className="flex-column px-3">
          <span className="country-name d-block text-wrap">{name}</span>

          <span className="badge badge-secondary">{sku}</span>

          <span className="badge badge-primary">price: {price}$</span>
          <button
            type="button"
            className="btn btn-warning"
            onClick={handleAddToCart}
            data-target="#mymodal"
          >
            <FontAwesomeIcon icon={faCartPlus} />
          </button>
        </div>
      </div>
      {product.type_id === "configurable" && (
        <Modal show={modalShow}>
          <Modal.Header>
            <Modal.Title>Sizes: </Modal.Title>
          </Modal.Header>
          <Modal.Body>
            <div className="form-check-inline">
              {sizes.map((p) => (
                <div>
                  <Radio
                    checked={size === p}
                    onChange={handleSizeChange}
                    value={p}
                    name="radio-button-color"
                  />
                  <span>{p}</span>
                </div>
              ))}
            </div>
          </Modal.Body>
          <Modal.Header>
            <Modal.Title>Colors: </Modal.Title>
          </Modal.Header>
          <Modal.Body>
            <div className="form-check-inline">
              {colors.map((p) => (
                <div>
                  <Radio
                    checked={color === p}
                    onChange={handleColorChange}
                    value={p}
                    name="radio-button-color"
                  />
                  <span>{p}</span>
                </div>
              ))}
            </div>
          </Modal.Body>

          <Modal.Footer>
            <Button onClick={onClose}>Cancel</Button>
            <Button onClick={onAddConfigProductToCart}>OK</Button>
          </Modal.Footer>
        </Modal>
      )}
    </div>
  );
}

ProductItem.propTypes = {
  product: PropTypes.object,
  addToCart: PropTypes.func,
};

const mapDispatchToProps = {
  addToCart,
};

export default connect(null, mapDispatchToProps)(ProductItem);
