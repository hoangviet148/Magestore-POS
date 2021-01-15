import {
  GET_PRODUCTS,
  SEARCH_PRODUCTS,
} from "../actions/types";

const initialState = {
  products: [],
};

const products = (state = initialState, action) => {
  console.log("getProducts_reducers - reducers");
  switch (action.type) {
    case GET_PRODUCTS:
      console.log("Case Get_Products");
      return { ...state, products: action.payload };
    case SEARCH_PRODUCTS:
      console.log("Case Search_Products");
      return { ...state, products: action.payload };
    default:
      return state;
  }
};

export default products;
