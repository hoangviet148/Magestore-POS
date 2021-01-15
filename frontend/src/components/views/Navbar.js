import React, { useState } from "react";
import { searchProducts } from "../../actions/product_actions";
import { connect } from "react-redux";
import { useHistory } from "react-router-dom";

function Navbar(props) {
  let history = useHistory();
  const [SearchTerm, setSearchTerm] = useState("");
  const handleSubmit = (e) => {
    props.searchProducts({ SearchTerm }).then((response) => {
      console.log("Search Component - after reducers", response);
    });
    e.preventDefault();
  };

  const handleChange = (e) => {
    const target = e.target;
    const value = target.value;
    setSearchTerm(value);
  };

  const logoutHandler = () => {
    localStorage.clear();
    history.push("/");
  };
  return (
    <div className="col-9">
      <div className="row">
        <div className="input-group w-75 col-sm-9 d-flex justify-content-start">
          <form className="w-100" onSubmit={handleSubmit}>
            <div className="form-row align-items-center">
              <div className="col-8">
                <input
                  type="text"
                  name="query"
                  className="form-control"
                  id="inlineFormInput"
                  placeholder="Please type name or sku of product"
                  onChange={handleChange}
                />
              </div>
              <div className="col-2">
                <button type="submit" className="btn btn-primary">
                  Search
                </button>
              </div>
            </div>
          </form>
        </div>

        <div className="input-group-append col-sm-3 d-flex justify-content-end">
          <button
            onClick={logoutHandler}
            type="button"
            className="btn btn-warning"
          >
            Logout
          </button>
        </div>
      </div>
    </div>
  );
}

const mapDispatchToProps = {
  searchProducts,
};

export default connect(null, mapDispatchToProps)(Navbar);
