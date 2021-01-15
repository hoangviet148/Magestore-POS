import React, { useState, useEffect } from "react";
import ProductItem from "./ProductItem";
import "./ProductList.css";
import { getProducts } from "../../../actions/product_actions";
import { connect } from "react-redux";
import ReactPaginate from "react-paginate";

const ProductList = ({ products, getProducts }) => {
  const [totalPages, setTotalPages] = useState(1);
  const [currentPage, setCurrentPage] = useState(1);
  const [totalProducts, setTotalProducts] = useState(0);
  const [Products, setProducts] = useState(null);

  useEffect(() => {
    console.log("useEffect1")
    getProducts({ currentPage });
  }, [currentPage]);

  useEffect(() => {
    console.log("useEffect2")
    if (products && products.total_count) {
      console.log("useEffect2 - if")
      const temp = Math.ceil(products.total_count / 16);
      setTotalPages(temp);
      setTotalProducts(products.total_count)
      setProducts(products)
    }
    console.log("products: ", products)
  }, [products]);


  if (totalProducts === 0) return null;

  const headerClass = [
    "text-dark py-2 pr-4 m-0",
    currentPage ? "border-gray border-right" : "",
  ]
    .join(" ")
    .trim();

  return (
    <div className="container mb-5">
      <div className="row d-flex flex-row">
        <div className="w-100 px-4 d-flex flex-row flex-wrap align-items-center justify-content-between">
          <div className="d-flex flex-row align-items-center">
            <h2 className={headerClass}>
              <strong className="text-secondary">{totalProducts}</strong>{" "}
              Products
            </h2>
            {currentPage && (
              <span className="current-page d-inline-block h-100 pl-4 text-secondary">
                Page <span className="font-weight-bold">{currentPage}</span> /{" "}
                <span className="font-weight-bold">{totalPages}</span>
              </span>
            )}
          </div>
          <div className="d-flex flex-row py-4 align-items-center">
            <ReactPaginate
              breakClassName={"page-item"}
              breakLinkClassName={"page-link"}
              containerClassName={"pagination"}
              pageClassName={"page-item"}
              pageLinkClassName={"page-link"}
              previousClassName={"page-item"}
              previousLinkClassName={"page-link"}
              nextClassName={"page-item"}
              nextLinkClassName={"page-link"}
              activeClassName={"active"}
              previousLabel={"prev"}
              nextLabel={"next"}
              breakLabel={"..."}
              pageCount={totalPages}
              marginPagesDisplayed={2}
              pageRangeDisplayed={3}
              onPageChange={(e) => setCurrentPage(e.selected + 1)}
            />
          </div>
        </div>
        {Products && Products.items && Products.items.map((product) => (
          <ProductItem key={product.id} product={product} />
        ))}
      </div>
    </div>
  );
};


const mapStateToProps = ({ products }) => products;

const mapDispatchToProps = {
  getProducts,
};

export default connect(mapStateToProps, mapDispatchToProps)(ProductList);
