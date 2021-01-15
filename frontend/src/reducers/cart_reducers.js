import {
  ADD_TO_CART,
  REMOVE_PRODUCTS,
  CHANGE_QUANTITY,
  REQUEST_CHECKOUT,
  CREATE_QUOTE,
  GET_CART,
} from "../actions/types";

const initialState = {
  carts: [],
};

const carts = (state = initialState, action) => {
  console.log("add to cart reducers - reducers");
  switch (action.type) {
    case CREATE_QUOTE:
      console.log("Case create quote");
      return state;
    case ADD_TO_CART:
      console.log("Case Add to cart");
      // const item = action.payload;
      // const checkProduct = state.carts.find((x) => x.id === item.id);
      // console.log("check: ", state)
      // if (checkProduct) {
      //   item.qty++;
      //   return { ...state, qty: item.qty };
      // }
      // item.qty = 1;
      //return { ...state, carts: [...state.carts, item], cartAdd: item };
      return { ...state, cartAdd: Math.random().toString(36) };
    case REMOVE_PRODUCTS:
      console.log("Case Remove cart");
      console.log("state.carts: ", state.carts);
      return { ...state, cartDelete: action.payload };
    // return {
    //   ...state ,carts: state.carts.filter((item) => item.id !== action.payload.id), cartDelete: action.payload
    // };
    case CHANGE_QUANTITY:
      console.log("case change quantity");
      return { ...state, cartUpdate: action.payload };
    case GET_CART:
      console.log("case request get cart");
      return { ...state, carts: action.payload };
    case REQUEST_CHECKOUT:
      console.log("case request checkout");
      localStorage.removeItem("quoteId");
      localStorage.setItem("quoteId", action.payload);
      return { ...state, carts: [] };
    default:
      return state;
  }
};

export default carts;
