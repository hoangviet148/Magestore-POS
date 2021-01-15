import axios from "axios";

import {
  GET_PRODUCTS,
  SEARCH_PRODUCTS,
  ADD_TO_CART,
  REMOVE_PRODUCTS,
  CHANGE_QUANTITY,
  REQUEST_CHECKOUT,
  CREATE_QUOTE,
  GET_CART,
} from "./types";

import { USER_SERVER } from "../components/Config.js";

export const getProducts = async (payload) => {
  console.log("fetch get products api - product_actions");
  const res = await axios.get(
    `${USER_SERVER}/getProduct?
    searchCriteria[filter_groups][0][filters][0][field]=type_id&
    searchCriteria[filter_groups][0][filters][0][value]=simple&
    searchCriteria[filter_groups][0][filters][0][condition_type]=eq&
    searchCriteria[filter_groups][0][filters][1][field]=type_id&
    searchCriteria[filter_groups][0][filters][1][value]=configurable&
    searchCriteria[filter_groups][0][filters][1][condition_type]=eq&
    searchCriteria[pageSize]=16&
    searchCriteria[currentPage]=${payload.currentPage || 1}
    `,
    {
      "Content-Type": "application/json",
    }
  );
  console.log("payload: ", payload);
  console.log("Response from server: ", res);
  return {
    type: GET_PRODUCTS,
    payload: res.data,
  };
};

export async function searchProducts(payload) {
  console.log("fetch search products api - product_actions");
  const res = await axios.get(
    `${USER_SERVER}/getProduct?
    searchCriteria[filter_groups][1][filters][0][field]=type_id&
    searchCriteria[filter_groups][1][filters][0][value]=simple&
    searchCriteria[filter_groups][1][filters][0][condition_type]=eq&
    searchCriteria[filter_groups][1][filters][1][field]=type_id&
    searchCriteria[filter_groups][1][filters][1][value]=configurable&
    searchCriteria[filter_groups][1][filters][1][condition_type]=eq&
    searchCriteria[filter_groups][2][filters][0][field]=name&
    searchCriteria[filter_groups][2][filters][0][value]=${
      (payload && "%25" + payload.SearchTerm + "%25") || "%25%25"
    }&
    searchCriteria[filter_groups][2][filters][1][condition_type]=like&
    searchCriteria[filter_groups][2][filters][1][field]=sku&
    searchCriteria[filter_groups][2][filters][1][value]=${
      (payload && "%25" + payload.SearchTerm + "%25") || "%25%25"
    }&
    searchCriteria[filter_groups][2][filters][0][condition_type]=like&
    searchCriteria[pageSize]=16
    `,
    {
      "Content-Type": "application/json",
    }
  );
  console.log("payload: ", payload);
  console.log("Response from server: ", res);
  return {
    type: SEARCH_PRODUCTS,
    payload: res.data,
  };
}

export async function createQuote() {
  console.log("create quote - product_actions");
  const quoteId = await axios.post(
    "http://localhost:80/magento235/rest/default/V1/guest-carts",
    {
      "Content-type": "application/json",
    }
  );
  localStorage.setItem("quoteId", quoteId.data);
  return {
    type: CREATE_QUOTE,
    payload: quoteId.data,
  };
}

export async function getCart() {
  console.log("get cart - product_actions");
  const quoteId = localStorage.getItem("quoteId");
  const response = await axios.get(
    `http://localhost:80/magento235/rest/V1/guest-carts/${quoteId}/items`,
    {
      "Content-type": "application/json",
    }
  );
  const items = response.data;
  for (const item of items) {
    const res = await axios.get(
      `http://localhost:80/magento235/rest/V1/product/${item.sku}`
    );
    item.image = res.data;
  }
  console.log("items: ", items);
  return {
    type: GET_CART,
    payload: items,
  };
}

export async function addToCart(payload) {
  console.log("add to cart - product_actions");
  console.log("payload: ", payload);
  const quoteId = localStorage.getItem("quoteId");
  await axios.post(
    `http://localhost:80/magento235/rest/default/V1/guest-carts/${quoteId}/items`,
    {
      cartItem: {
        sku: payload.sku,
        qty: 1,
        quote_id: quoteId,
      },
    },
    {
      "Content-type": "application/json",
    }
  );
  return {
    type: ADD_TO_CART,
    payload: payload,
  };
}

export async function removeProduct(payload) {
  console.log("remove products - product_actions");
  console.log("payload: ", payload);
  const quoteId = localStorage.getItem("quoteId");
  await axios.delete(
    `http://localhost:80/magento235/rest/V1/guest-carts/${quoteId}/items/${payload.item_id}`,
    {
      "Content-type": "application/json",
    }
  );
  return {
    type: REMOVE_PRODUCTS,
    payload: payload,
  };
}

export async function changeQuantity(payload) {
  console.log("change quantity - product_actions");
  console.log("payload: ", payload);
  const quoteId = localStorage.getItem("quoteId");
  const qty = payload.product.qty;
  const item_id = payload.product.item_id;
  await axios.put(
    `http://localhost:80/magento235/rest/V1/guest-carts/${quoteId}/items/${item_id}`,
    {
      cartItem: {
        item_id: item_id,
        qty: qty + payload.number,
        quote_id: quoteId,
      },
    }
  );
  return {
    type: CHANGE_QUANTITY,
    payload: payload,
  };
}

export async function requestCheckout() {
  console.log("checkout - action");

  const quoteId = localStorage.getItem("quoteId");
  await axios.post(
    `http://localhost:80/magento235/rest/default/V1/guest-carts/${quoteId}/estimate-shipping-methods`,
    {
      address: {
        region: "New York",
        region_id: 43,
        region_code: "NY",
        country_id: "US",
        street: ["123 Oak Ave"],
        postcode: "10577",
        city: "Purchase",
        firstname: "Jane",
        lastname: "Doe",
        customer_id: 5,
        email: "jdoe@example.com",
        telephone: "(512) 555-1111",
        same_as_billing: 1,
      },
      email: "jdoe@example.com",
    }
  );

  await axios.post(
    `http://localhost:80/magento235/rest/default/V1/guest-carts/${quoteId}/shipping-information`,
    {
      addressInformation: {
        shipping_address: {
          region: "New York",
          region_id: 43,
          region_code: "NY",
          country_id: "US",
          street: ["123 Oak Ave"],
          postcode: "10577",
          city: "Purchase",
          firstname: "Jane",
          lastname: "Doe",
          email: "jdoe@example.com",
          telephone: "512-555-1111",
        },
        billing_address: {
          region: "New York",
          region_id: 43,
          region_code: "NY",
          country_id: "US",
          street: ["123 Oak Ave"],
          postcode: "10577",
          city: "Purchase",
          firstname: "Jane",
          lastname: "Doe",
          email: "jdoe@example.com",
          telephone: "512-555-1111",
        },
        shipping_carrier_code: "tablerate",
        shipping_method_code: "bestway",
      },
    }
  );

  const res = await axios.post(
    `http://localhost:80/magento235/rest/default/V1/guest-carts/${quoteId}/payment-information`,
    {
      paymentMethod: {
        method: "checkmo",
      },
      billing_address: {
        email: "jdoe@example.com",
        region: "New York",
        region_id: 43,
        region_code: "NY",
        country_id: "US",
        street: ["123 Oak Ave"],
        postcode: "10577",
        city: "Purchase",
        telephone: "512-555-1111",
        firstname: "Jane",
        lastname: "Doe",
      },
      email: "jdoe@example.com",
    }
  );

  const newQuote = await axios.post(
    "http://localhost:80/magento235/rest/default/V1/guest-carts",
    {
      "Content-type": "application/json",
    }
  );

  console.log("res: ", res);
  return {
    type: REQUEST_CHECKOUT,
    payload: newQuote.data,
  };
}
