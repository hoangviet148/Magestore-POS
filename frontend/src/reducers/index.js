import { combineReducers } from 'redux';
import loginReducers from './login_reducers';
import productsReducers from './product_reducers';
import cartsReducers from './cart_reducers';

import 'bootstrap/dist/css/bootstrap.css';

const rootReducer = combineReducers({
    users: loginReducers,
    products: productsReducers,
    carts: cartsReducers
});

export default rootReducer;
